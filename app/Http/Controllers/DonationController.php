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
            'amount' => 'required|numeric|min:1'
        ]);

        try {
            return DB::transaction(function () use ($request, $campaign) {
                // Create Donation
                $donation = Donation::create([
                    'user_id' => auth()->id(),
                    'campaign_id' => $campaign->id,
                    'amount' => $request->amount,
                    'status' => 'completed' 
                ]);

                // Update Campaign Current Amount
                $campaign->increment('current_amount', $request->amount);

                return response()->json([
                    'status' => 'success',
                    'message' => 'Thank you for your donation!',
                    'data' => [
                        'donation' => $donation,
                        'campaign_current_amount' => $campaign->current_amount
                    ]
                ], 201);
            });
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Something went wrong with the donation.'
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
