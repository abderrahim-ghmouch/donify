<?php

namespace App\Http\Controllers;

use App\Models\Campaign;
use App\Models\Organisation;
use Illuminate\Http\Request;

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

    public function campaign($id)
    {
        $campaign = Campaign::with(['images', 'user', 'category', 'donations'])->findOrFail($id);
        return view('campaigns.show', compact('campaign'));
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

    public function adminDashboard()
    {
        return view('admin.dashboard');
    }
}
