<?php

namespace App\Http\Controllers;

use App\Models\Donation;
use App\Models\Payment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class WebhookController extends Controller
{
    /**
     * ENTRY POINT: Stripe calls this URL automatically after every payment event.
     *
     * This method is registered at: POST /api/webhooks/stripe
     * It is PUBLIC - no login required because Stripe (not a user) is calling it.
     *
     * Stripe sends many types of events (payment success, failure, refund, etc.).
     * We read the event type and decide what to do with it.
     */
    public function handleStripe(Request $request)
    {
        // Get the raw body of the request sent by Stripe
        $payload   = $request->getContent();

        // Get the security signature Stripe added to the request header
        $sigHeader = $request->header('Stripe-Signature');

        // Get our webhook secret from the .env file
        $secret    = config('services.stripe.webhook_secret');

        // SECURITY CHECK:
        // If we have a webhook secret configured, we verify the signature.
        // This confirms the request is genuinely from Stripe and not a fake request
        // from a hacker trying to mark donations as completed without paying.
        if ($secret) {
            try {
                \Stripe\Stripe::setApiKey(config('services.stripe.secret'));
                $event = \Stripe\Webhook::constructEvent($payload, $sigHeader, $secret);
            } catch (\Stripe\Exception\SignatureVerificationException $e) {
                // The signature is invalid - reject the request immediately
                Log::warning('Stripe webhook signature verification failed.', ['error' => $e->getMessage()]);
                return response()->json(['error' => 'Invalid signature.'], 400);
            }
        } else {
            // No webhook secret in .env - skip the security check.
            // This is acceptable during local development but MUST be configured in production.
            $event = \Stripe\Event::constructFrom(json_decode($payload, true));
        }

        // ROUTING: Check what type of event Stripe sent us and call the right handler.
        switch ($event->type) {

            // This event fires when a donor completes payment on the Stripe checkout page.
            case 'checkout.session.completed':
                $this->handleCheckoutSessionCompleted($event->data->object);
                break;

            // This event fires when a payment attempt is declined by the bank.
            case 'payment_intent.payment_failed':
                $this->handlePaymentFailed($event->data->object);
                break;

            default:
                // We received an event we do not handle yet - just log it and move on.
                Log::info('Stripe webhook received unhandled event.', ['type' => $event->type]);
        }

        // Always return 200 to tell Stripe we received the event successfully.
        // If we return an error, Stripe will keep retrying for up to 3 days.
        return response()->json(['status' => 'received'], 200);
    }

    /**
     * HANDLER: Payment was successful.
     *
     * This method is called when a donor successfully pays on the Stripe checkout page.
     * It performs three database updates:
     *   1. Marks the donation record as "completed".
     *   2. Marks the payment record as "completed".
     *   3. Adds the donated amount to the campaign's funded total.
     *
     * All three updates happen inside a single database transaction so that
     * if any one of them fails, none of them are saved. This prevents data inconsistency.
     */
    private function handleCheckoutSessionCompleted($session)
    {
        // When we created the Stripe Checkout Session in DonationController,
        // we passed the donation ID as "client_reference_id".
        // Stripe sends it back here so we can find the correct donation record.
        $donationId = $session->client_reference_id;

        if (!$donationId) {
            Log::warning('Stripe webhook: checkout.session.completed missing client_reference_id.');
            return;
        }

        // Find the donation and its related campaign in the database
        $donation = Donation::with('campaign')->find($donationId);

        if (!$donation) {
            Log::warning('Stripe webhook: Donation not found.', ['donation_id' => $donationId]);
            return;
        }

        // Safety check: if this donation was already processed (e.g. Stripe sent the event twice),
        // do nothing to avoid adding the amount to the campaign a second time.
        if ($donation->status === 'completed') {
            return;
        }

        // Run all three updates inside a single database transaction
        DB::transaction(function () use ($donation, $session) {

            // Step 1: Mark the donation as completed
            $donation->update(['status' => 'completed']);

            // Step 2: Find the payment record by the Stripe session ID and mark it as completed.
            // The session ID was saved in the "transaction_id" column when the session was created.
            Payment::where('transaction_id', $session->id)
                ->update([
                    'status'        => 'completed',
                    'provider_data' => [
                        'stripe_payment_intent' => $session->payment_intent
                    ],
                ]);

            // Step 3: Add the donated amount to the campaign's current funded total.
            // This is the update that visually changes the progress bar on the campaign page.
            $donation->campaign->increment('current_amount', $donation->amount);

            Log::info('Donation completed via Stripe.', [
                'donation_id' => $donation->id,
                'campaign_id' => $donation->campaign_id,
                'amount'      => $donation->amount,
            ]);
        });
    }

    /**
     * HANDLER: Payment failed.
     *
     * This method is called when a donor's card is declined or the payment fails for any reason.
     * We mark the payment record as "failed" so the system knows the transaction did not go through.
     * The donation record stays as "pending" - the donor can try again.
     */
    private function handlePaymentFailed($paymentIntent)
    {
        Payment::where('transaction_id', $paymentIntent->id)
            ->update([
                'status'           => 'failed',
                'response_message' => $paymentIntent->last_payment_error->message ?? 'Payment failed.',
            ]);

        Log::info('Payment failed.', ['payment_intent' => $paymentIntent->id]);
    }
}
