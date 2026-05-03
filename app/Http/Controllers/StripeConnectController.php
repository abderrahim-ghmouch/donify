<?php

namespace App\Http\Controllers;

use App\Models\Campaign;
use App\Models\Donation;
use App\Models\Payout;
use App\Models\Stripe as StripeAccount;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Stripe\Account;
use Stripe\AccountLink;
use Stripe\Stripe;
use Stripe\Transfer;

class StripeConnectController extends Controller
{
    public function status()
    {
        $user = auth('api')->user();
        $stripe = $user->stripe;

        if ($stripe?->stripe_account_id) {
            Stripe::setApiKey(config('services.stripe.secret'));
            $account = Account::retrieve($stripe->stripe_account_id);
            $stripe->update([
                'status' => ($account->charges_enabled && $account->payouts_enabled) ? 'active' : 'pending',
            ]);
        }

        return response()->json([
            'status' => 'success',
            'data' => [
                'connected' => (bool) $stripe?->stripe_account_id,
                'ready' => $stripe?->status === 'active',
                'stripe_status' => $stripe?->status ?? 'not_connected',
            ],
        ]);
    }

    public function onboarding(Request $request)
    {
        $user = $request->user('api');
        Stripe::setApiKey(config('services.stripe.secret'));

        $stripe = StripeAccount::firstOrCreate(
            ['user_id' => $user->id],
            ['status' => 'pending']
        );

        if (!$stripe->stripe_account_id) {
            $account = Account::create([
                'type' => 'express',
                'country' => 'US',
                'email' => $user->email,
                'capabilities' => [
                    'card_payments' => ['requested' => true],
                    'transfers' => ['requested' => true],
                ],
                'business_type' => 'individual',
            ]);

            $stripe->update([
                'stripe_account_id' => $account->id,
                'status' => 'pending',
            ]);
        }

        $link = AccountLink::create([
            'account' => $stripe->stripe_account_id,
            'refresh_url' => url('/porter/dashboard?payout=refresh'),
            'return_url' => url('/porter/dashboard?payout=connected'),
            'type' => 'account_onboarding',
        ]);

        return response()->json([
            'status' => 'success',
            'url' => $link->url,
        ]);
    }

    public function campaignPayout(Request $request, Campaign $campaign)
    {
        $validated = $request->validate([
            'amount' => 'nullable|numeric|min:1',
        ]);

        $user = $request->user('api');

        if ($campaign->user_id !== $user->id) {
            return response()->json([
                'status' => 'error',
                'message' => 'You can only request payouts for your own campaigns.',
            ], 403);
        }

        $stripe = $user->stripe;
        if (!$stripe?->stripe_account_id || $stripe->status !== 'active') {
            return response()->json([
                'status' => 'error',
                'message' => 'Connect your Stripe payout account before requesting money.',
            ], 422);
        }

        $requestedAmount = isset($validated['amount']) ? (float) $validated['amount'] : null;

        $payout = DB::transaction(function () use ($campaign, $user, $requestedAmount) {
            $lockedCampaign = Campaign::whereKey($campaign->id)->lockForUpdate()->firstOrFail();
            $available = $this->availableForCampaign($lockedCampaign->id);
            $amount = $requestedAmount ?? $available;

            if ($amount > $available) {
                throw new HttpResponseException(response()->json([
                    'status' => 'error',
                    'message' => 'Requested payout exceeds the available campaign balance.',
                    'available' => round($available, 2),
                ], 422));
            }

            if ($amount <= 0) {
                throw new HttpResponseException(response()->json([
                    'status' => 'error',
                    'message' => 'This campaign has no completed, unpaid donations yet.',
                ], 422));
            }

            return Payout::create([
                'user_id' => $user->id,
                'campaign_id' => $lockedCampaign->id,
                'amount' => $amount,
                'currency' => 'USD',
                'status' => 'pending',
            ]);
        });

        try {
            Stripe::setApiKey(config('services.stripe.secret'));
            $transfer = Transfer::create([
                'amount' => (int) round($payout->amount * 100),
                'currency' => strtolower($payout->currency),
                'destination' => $stripe->stripe_account_id,
                'metadata' => [
                    'payout_id' => $payout->id,
                    'campaign_id' => $campaign->id,
                    'porter_id' => $user->id,
                ],
            ]);

            $payout->update([
                'status' => 'completed',
                'stripe_transfer_id' => $transfer->id,
                'provider_data' => $transfer->toArray(),
            ]);
        } catch (\Throwable $e) {
            $payout->update([
                'status' => 'failed',
                'failure_message' => $e->getMessage(),
            ]);

            return response()->json([
                'status' => 'error',
                'message' => 'Stripe transfer failed: ' . $e->getMessage(),
            ], 500);
        }

        return response()->json([
            'status' => 'success',
            'message' => 'Payout transfer created successfully.',
            'data' => $payout->fresh(),
        ]);
    }

    private function availableForCampaign(int $campaignId): float
    {
        $completedDonations = (float) Donation::where('campaign_id', $campaignId)
            ->where('status', 'completed')
            ->sum('amount');

        $reservedPayouts = (float) Payout::where('campaign_id', $campaignId)
            ->whereIn('status', ['pending', 'processing', 'completed'])
            ->sum('amount');

        return round($completedDonations - $reservedPayouts, 2);
    }
}
