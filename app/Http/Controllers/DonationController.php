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
                    'user_id' => auth()->id(),
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
                    'customer_email' => auth()->user()->email,
                    'client_reference_id' => $donation->id,
                ]);

                // 3. Create Supporting Payment Logic
                \App\Models\Payment::create([
                    'user_id' => auth()->id(),
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
     * Display a listing of user's donations.
     */
    public function myDonations()
    {
        $donations = Donation::where('user_id', auth()->id())
            ->with('campaign:id,title')
            ->orderBy('created_at', 'desc')
            ->get();

        return response()->json([
            'status' => 'success',
            'data' => $donations
        ]);
    }
}
