<?php

namespace App\Http\Controllers;

use App\Models\Campaign;
use App\Models\Donation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DonationController extends Controller
{
    /**
     * Store a newly created donation.
     */
    public function donate(Request $request, $campaignId)
    {
        $campaign = Campaign::findOrFail($campaignId);

        $request->validate([
            'amount' => 'required|numeric|min:10' // Minimum MAD for valid transaction
        ]);

        try {
            \Stripe\Stripe::setApiKey(config('services.stripe.secret'));

            return DB::transaction(function () use ($request, $campaign) {
                // 1. Create Donation Record (Pending)
                $donation = Donation::create([
                    'user_id' => auth('api')->id(),
                    'campaign_id' => $campaign->id,
                    'amount' => $request->amount,
                    'status' => 'pending'
                ]);

                // 2. Initialize Stripe Checkout Session
                $session = \Stripe\Checkout\Session::create([
                    'payment_method_types' => ['card'],
                    'line_items' => [[
                        'price_data' => [
                            'currency' => 'mad',
                    'product_data' => [
                            'name' => "Contribution: " . $campaign->title,
                            'description' => "Supporting " . ($campaign->user->name ?? 'Community Initiative'),
                        ],
                        'unit_amount' => $request->amount * 100, // Amount in fractional units (cents)
                    ],
                    'quantity' => 1,
                ]],
                'mode' => 'payment',
                'success_url' => route('campaigns.show', $campaign->id) . '?payment=success&session_id={CHECKOUT_SESSION_ID}',
                'cancel_url' => route('campaigns.show', $campaign->id) . '?payment=cancel',
                    'customer_email' => auth('api')->user()->email,
                    'client_reference_id' => $donation->id,
                ]);

                // 3. Create Supporting Payment Logic
                \App\Models\Payment::create([
                    'user_id' => auth('api')->id(),
                    'donation_id' => $donation->id,
                    'amount' => $request->amount,
                    'currency' => 'MAD',
                    'payment_method' => 'stripe',
                    'status' => 'pending',
                    'transaction_id' => $session->id,
                    'provider_data' => [
                        'stripe_checkout_url' => $session->url,
                        'campaign_id' => $campaign->id
                    ]
                ]);

                return response()->json([
                    'status' => 'success',
                    'checkout_url' => $session->url
                ]);
            });
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Initialization failed: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Confirm a Stripe checkout session and credit the campaign once.
     */
    public function confirm(Request $request, Campaign $campaign)
    {
        $validated = $request->validate([
            'session_id' => 'required|string',
        ]);

        \Stripe\Stripe::setApiKey(config('services.stripe.secret'));

        $payment = \App\Models\Payment::where('transaction_id', $validated['session_id'])
            ->with('donation')
            ->firstOrFail();

        if ($payment->donation?->campaign_id !== $campaign->id) {
            return response()->json([
                'status'  => 'error',
                'message' => 'Payment does not belong to this campaign.',
            ], 403);
        }

        if ($payment->status === 'completed' && $payment->donation?->status === 'completed') {
            return response()->json([
                'status' => 'success',
                'message' => 'Donation already confirmed.',
                'data' => [
                    'campaign' => $campaign->fresh()->load(['images', 'category', 'user']),
                    'donation' => $payment->donation,
                    'payment'  => $payment,
                ],
            ]);
        }

        $session = \Stripe\Checkout\Session::retrieve($validated['session_id']);

        if (($session->payment_status ?? null) !== 'paid') {
            return response()->json([
                'status'  => 'error',
                'message' => 'Payment is not completed yet.',
            ], 422);
        }

        $result = DB::transaction(function () use ($campaign, $payment, $session) {
            $lockedPayment = \App\Models\Payment::whereKey($payment->id)->lockForUpdate()->first();
            $lockedDonation = \App\Models\Donation::whereKey($lockedPayment->donation_id)->lockForUpdate()->first();
            $lockedCampaign = Campaign::whereKey($campaign->id)->lockForUpdate()->first();

            if ($lockedPayment->status !== 'completed') {
                $lockedDonation->update(['status' => 'completed']);
                $lockedPayment->update([
                    'status' => 'completed',
                    'response_message' => 'Stripe checkout confirmed.',
                    'stripe_charge_id' => $session->payment_intent ?? $session->id,
                ]);
                $lockedCampaign->increment('current_amount', (float) $lockedPayment->amount);
            }

            return [
                'campaign' => $lockedCampaign->fresh()->load(['images', 'category', 'user']),
                'donation' => $lockedDonation->fresh(),
                'payment'  => $lockedPayment->fresh(),
            ];
        });

        return response()->json([
            'status'  => 'success',
            'message' => 'Donation confirmed and campaign updated.',
            'data'    => $result,
        ]);
    }

    /**
     * Display a listing of user's donations.
     */
    public function myDonations()
    {
        $donations = Donation::where('user_id', auth('api')->id())
            ->with('campaign:id,title')
            ->orderBy('created_at', 'desc')
            ->get();

        return response()->json([
            'status' => 'success',
            'data' => $donations
        ]);
    }
}
