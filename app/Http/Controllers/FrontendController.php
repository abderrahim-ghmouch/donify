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
        $campaign = Campaign::with(['images', 'user.images', 'organisation.verificationDocument', 'category', 'donations'])->findOrFail($id);
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

    public function createCampaign()
    {
        return view('porter.create');
    }

    public function adminDashboard()
    {
        // Check if user is authenticated and is an admin
        if (!auth()->check() || auth()->user()->role !== 'admin') {
            return redirect()->route('login')->with('error', 'Unauthorized access');
        }

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
