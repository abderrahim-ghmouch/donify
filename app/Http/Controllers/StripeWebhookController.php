<?php

namespace App\Http\Controllers;

use App\Models\Campaign;
use App\Models\Payment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class StripeWebhookController extends Controller
{
    public function handle(Request $request)
    {
        $payload = $request->getContent();
        $sigHeader = $request->header('Stripe-Signature');
        $webhookSecret = config('services.stripe.webhook_secret');

        try {
            $event = \Stripe\Webhook::constructEvent($payload, $sigHeader, $webhookSecret);
        } catch (\Exception $e) {
            Log::error('Webhook signature verification failed: ' . $e->getMessage());
            return response()->json(['error' => 'Invalid signature'], 400);
        }

        if ($event->type === 'checkout.session.completed') {
            $session = $event->data->object;
            
            $payment = Payment::where('transaction_id', $session->id)->with('donation')->first();
            
            if (!$payment) {
                Log::warning('Payment not found for session: ' . $session->id);
                return response()->json(['status' => 'ignored'], 200);
            }

            if ($payment->status === 'completed') {
                return response()->json(['status' => 'already_processed'], 200);
            }

            DB::transaction(function () use ($payment, $session) {
                $lockedPayment = Payment::whereKey($payment->id)->lockForUpdate()->first();
                $lockedDonation = $lockedPayment->donation()->lockForUpdate()->first();
                $lockedCampaign = Campaign::whereKey($lockedDonation->campaign_id)->lockForUpdate()->first();

                if ($lockedPayment->status !== 'completed') {
                    $lockedDonation->update(['status' => 'completed']);
                    $lockedPayment->update([
                        'status' => 'completed',
                        'response_message' => 'Webhook confirmed',
                        'stripe_charge_id' => $session->payment_intent ?? $session->id,
                    ]);
                    $lockedCampaign->increment('current_amount', (float) $lockedPayment->amount);
                }
            });

            Log::info('Donation confirmed via webhook: ' . $payment->id);
        }

        return response()->json(['status' => 'success'], 200);
    }
}
