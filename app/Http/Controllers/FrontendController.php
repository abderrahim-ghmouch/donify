<?php

namespace App\Http\Controllers;

use App\Models\Campaign;
use App\Models\Donation;
use App\Models\Organisation;
use App\Models\Payment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class FrontendController extends Controller
{
    public function index()
    {
        $featuredCampaigns = Campaign::with('images')->latest()->take(3)->get();
        return view('welcome', compact('featuredCampaigns'));
    }

    public function campaigns()
    {
        return view('campaigns.index');
    }

    public function campaign($id, Request $request)
    {
        $campaign = Campaign::with(['images', 'user', 'category', 'donations'])->findOrFail($id);

        // When Stripe redirects the donor back after paying, the URL contains
        // ?payment=success&session_id=cs_test_...
        // We use the session_id to verify the payment with Stripe immediately,
        // update the database, and refresh the campaign data — so the progress
        // bar shows the correct amount the moment the donor lands on this page.
        if ($request->payment === 'success' && $request->session_id) {
            $this->processReturnedPayment($request->session_id, $campaign);
            $campaign->refresh(); // reload from DB to get the updated current_amount
        }

        return view('campaigns.show', compact('campaign'));
    }

    /**
     * Verify a Stripe Checkout Session on the donor's return.
     * Updates the donation, payment, and campaign amount in one transaction.
     * The webhook serves as a secondary safety net for the same operation.
     */
    private function processReturnedPayment(string $sessionId, Campaign $campaign): void
    {
        try {
            \Stripe\Stripe::setApiKey(config('services.stripe.secret'));

            // Ask Stripe: was this session actually paid?
            $session = \Stripe\Checkout\Session::retrieve($sessionId);

            if ($session->payment_status !== 'paid') {
                return; // not paid yet — do nothing
            }

            // Find the pending payment record saved when the session was created
            $payment = Payment::where('transaction_id', $sessionId)
                ->where('status', 'pending')
                ->first();

            // If it's already completed (webhook fired first), do nothing
            if (!$payment) {
                return;
            }

            $donation = Donation::find($payment->donation_id);

            if (!$donation || $donation->status === 'completed') {
                return;
            }

            // Mark donation + payment as completed, increment campaign total
            DB::transaction(function () use ($donation, $payment, $campaign) {
                $donation->update(['status' => 'completed']);
                $payment->update(['status' => 'completed']);
                $campaign->increment('current_amount', $donation->amount);
            });

        } catch (\Exception $e) {
            // Webhook will handle it as a fallback if this fails
            Log::warning('Payment verification on return failed.', [
                'session_id' => $sessionId,
                'error'      => $e->getMessage(),
            ]);
        }
    }

    public function organisations()
    {
        $organisations = Organisation::where('is_verified', true)->latest()->paginate(9);
        return view('organisations.index', compact('organisations'));
    }

    public function login()
    {
        return view('auth.login');
    }

    public function register()
    {
        return view('auth.register');
    }

    public function profile()
    {
        return view('auth.profile');
    }

    public function dashboard()
    {
        return view('porter.dashboard');
    }

    public function createCampaign()
    {
        return view('porter.create');
    }

    public function adminDashboard()
    {
        $users = \App\Models\User::latest()->get();
        $campaigns = \App\Models\Campaign::with('images')->latest()->get();
        $organisations = \App\Models\Organisation::latest()->get();
        $categories = \App\Models\Category::all();

        return view('admin.dashboard', compact('users', 'campaigns', 'organisations', 'categories'));
    }

    public function organisationRegister()
    {
        return view('organisations.register');
    }

    public function favourites()
    {
        return view('favourites');
    }

    public function logout(Request $request)
    {
        auth()->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/');
    }
}
