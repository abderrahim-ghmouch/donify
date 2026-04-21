@extends('layouts.app')

@section('styles')
<style>
    /* ── Hero (identical gradient to campaigns page) ── */
    .dash-hero {
        background: linear-gradient(135deg, #0f172a 0%, #064e3b 55%, #0f172a 100%);
        padding: 5rem 1.5rem 6rem;
        position: relative;
        overflow: hidden;
    }
    .dash-hero::before {
        content: '';
        position: absolute;
        top: -60px; right: -60px;
        width: 450px; height: 450px;
        background: radial-gradient(circle, rgba(16,185,129,.18) 0%, transparent 70%);
        pointer-events: none;
    }
    .dash-hero::after {
        content: '';
        position: absolute;
        bottom: -80px; left: 10%;
        width: 380px; height: 380px;
        background: radial-gradient(circle, rgba(99,102,241,.13) 0%, transparent 70%);
        pointer-events: none;
    }

    /* ── Stat cards in hero ── */
    .hero-stat {
        background: rgba(255,255,255,.08);
        backdrop-filter: blur(10px);
        border: 1px solid rgba(255,255,255,.12);
        border-radius: 1.25rem;
        padding: 1.4rem 1.75rem;
        text-align: center;
        min-width: 130px;
        transition: all .3s ease;
    }
    .hero-stat:hover { background: rgba(255,255,255,.14); transform: translateY(-3px); }
    .hero-stat-val   { font-size: 2rem; font-weight: 800; color: #34d399; font-family: 'Outfit', sans-serif; line-height: 1; }
    .hero-stat-label { font-size: .72rem; color: rgba(255,255,255,.5); text-transform: uppercase; letter-spacing: .06em; font-weight: 700; margin-top: .4rem; }

    /* ── Tab navigation (matches filter-pill style from campaigns) ── */
    .dash-tab-bar {
        background: #fff;
        border-radius: 2rem;
        border: 1px solid #f1f5f9;
        box-shadow: 0 2px 12px rgba(0,0,0,.06);
        padding: .4rem;
        display: inline-flex;
        gap: .3rem;
    }
    .dash-tab {
        padding: .65rem 1.6rem;
        border-radius: 9999px;
        font-weight: 700;
        font-size: .875rem;
        cursor: pointer;
        border: none;
        background: transparent;
        color: #64748b;
        transition: all .25s ease;
        display: inline-flex;
        align-items: center;
        gap: .5rem;
        white-space: nowrap;
    }
    .dash-tab:hover { color: #0f172a; background: #f8fafc; }
    .dash-tab.active {
        background: #10b981;
        color: #fff;
        box-shadow: 0 4px 15px rgba(16,185,129,.3);
    }

    /* ── Panel ── */
    .dash-panel { display: none; animation: fadeUp .35s ease both; }
    .dash-panel.active { display: block; }
    @keyframes fadeUp { from{opacity:0;transform:translateY(14px)} to{opacity:1;transform:translateY(0)} }

    /* ── Form fields ── */
    .field-label { display: block; font-size: .85rem; font-weight: 700; color: #374151; margin-bottom: .5rem; }
    .field-input {
        width: 100%; padding: .9rem 1.15rem;
        border-radius: .875rem; border: 1.5px solid #e2e8f0;
        background: #f8fafc; font-size: .9rem; color: #0f172a;
        outline: none; transition: all .2s;
    }
    .field-input:focus { border-color: #10b981; background: #fff; box-shadow: 0 0 0 4px rgba(16,185,129,.1); }
    .field-input::placeholder { color: #94a3b8; }
    textarea.field-input { resize: vertical; min-height: 140px; }
    select.field-input { appearance: none; cursor: pointer;
        background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' fill='none' viewBox='0 0 24 24' stroke='%2364748b' stroke-width='2'%3E%3Cpath stroke-linecap='round' stroke-linejoin='round' d='M19 9l-7 7-7-7'/%3E%3C/svg%3E");
        background-repeat: no-repeat; background-position: right .9rem center; background-size: 1rem; padding-right: 2.5rem;
    }

    /* ── Drop zone ── */
    .drop-zone {
        border: 2px dashed #cbd5e1; border-radius: 1rem;
        padding: 2.5rem 1.5rem; text-align: center;
        cursor: pointer; transition: all .25s; background: #f8fafc;
        position: relative;
    }
    .drop-zone.dragover { border-color: #10b981; background: #ecfdf5; }
    .drop-zone input[type=file] { position: absolute; inset: 0; opacity: 0; cursor: pointer; }
    .drop-preview { max-height: 160px; max-width: 100%; border-radius: .75rem; object-fit: cover; margin: 1rem auto 0; display: none; }

    /* ── Submit button ── */
    .submit-btn {
        background: linear-gradient(135deg, #10b981 0%, #059669 100%);
        color: #fff; padding: .9rem 2.5rem; border-radius: 1rem;
        font-weight: 800; font-size: 1rem; border: none; cursor: pointer;
        transition: all .25s; box-shadow: 0 4px 15px rgba(16,185,129,.35);
        display: inline-flex; align-items: center; gap: .6rem;
    }
    .submit-btn:hover { transform: translateY(-2px); box-shadow: 0 8px 25px rgba(16,185,129,.45); }
    .submit-btn:disabled { opacity: .65; transform: none; cursor: not-allowed; }

    /* ── Campaign table ── */
    .camp-table { width: 100%; border-collapse: collapse; }
    .camp-table th {
        text-align: left; font-size: .75rem; font-weight: 700;
        color: #64748b; text-transform: uppercase; letter-spacing: .06em;
        padding: .85rem 1.25rem; background: #f8fafc; border-bottom: 1px solid #f1f5f9;
    }
    .camp-table td { padding: 1.1rem 1.25rem; border-bottom: 1px solid #f8fafc; font-size: .875rem; vertical-align: middle; color: #374151; }
    .camp-table tr:last-child td { border-bottom: none; }
    .camp-table tr:hover td { background: #f0fdf4; }

    /* ── Status pills ── */
    .s-pill {
        display: inline-flex; align-items: center; gap: .3rem;
        padding: .3rem .85rem; border-radius: 9999px;
        font-size: .75rem; font-weight: 700;
    }
    .s-pending   { background: #fef3c7; color: #92400e; }
    .s-active    { background: #d1fae5; color: #065f46; }
    .s-cancelled { background: #fee2e2; color: #991b1b; }
    .s-completed { background: #ede9fe; color: #5b21b6; }

    /* ── Progress mini ── */
    .prog-track { width: 100%; height: 5px; background: #f1f5f9; border-radius: 9999px; overflow: hidden; }
    .prog-fill  { height: 100%; background: linear-gradient(90deg, #10b981, #059669); border-radius: 9999px; }

    /* ── Alerts ── */
    .alert { padding: 1rem 1.25rem; border-radius: .875rem; font-size: .875rem; font-weight: 600; margin-bottom: 1.5rem; display: none; }
    .alert-success { background: #ecfdf5; color: #065f46; border: 1px solid #a7f3d0; }
    .alert-error   { background: #fef2f2; color: #991b1b; border: 1px solid #fecaca; }

    /* ── Skeleton ── */
    .skeleton { background: linear-gradient(90deg, #f1f5f9 25%, #e2e8f0 50%, #f1f5f9 75%); background-size: 200% 100%; animation: shimmer 1.4s infinite; border-radius: .75rem; }
    @keyframes shimmer { 0%{background-position:200% 0} 100%{background-position:-200% 0} }

    /* ── Card thumb ── */
    .thumb-sm { width: 44px; height: 44px; border-radius: .625rem; object-fit: cover; background: #f1f5f9; flex-shrink: 0; display: inline-flex; align-items: center; justify-content: center; color: #cbd5e1; overflow: hidden; }

    /* ── Guard screens ── */
    #dashGuest, #dashWrongRole { display: none; }
    #dashLoading { display: flex; }
    #dashContent { display: none; }
</style>
@endsection

@section('content')

{{-- ── Loading ── --}}
<div id="dashLoading" class="min-h-screen items-center justify-center flex">
    <div class="text-center">
        <div class="w-14 h-14 border-4 border-emerald-500 border-t-transparent rounded-full animate-spin mx-auto mb-4"></div>
        <p class="text-gray-400 font-medium">Loading your dashboard…</p>
    </div>
</div>

{{-- ── Guest guard ── --}}
<div id="dashGuest" class="min-h-screen items-center justify-center flex py-20 px-6">
    <div class="text-center max-w-sm">
        <div class="w-20 h-20 bg-emerald-100 rounded-full flex items-center justify-center mx-auto mb-6">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-10 w-10 text-emerald-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/>
            </svg>
        </div>
        <h2 class="text-2xl font-bold font-outfit mb-3">Sign in required</h2>
        <p class="text-gray-500 mb-8">Please log in to access your porter dashboard.</p>
        <a href="{{ route('login') }}" class="btn-primary px-8 py-3 rounded-xl font-bold">Sign In</a>
    </div>
</div>

{{-- ── Wrong role guard ── --}}
<div id="dashWrongRole" class="min-h-screen items-center justify-center flex py-20 px-6">
    <div class="text-center max-w-sm">
        <div class="w-20 h-20 bg-amber-100 rounded-full flex items-center justify-center mx-auto mb-6">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-10 w-10 text-amber-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
            </svg>
        </div>
        <h2 class="text-2xl font-bold font-outfit mb-3">Porter Access Only</h2>
        <p class="text-gray-500 mb-8">This dashboard is exclusively for Campaign Porters.</p>
        <a href="{{ route('home') }}" class="btn-primary px-8 py-3 rounded-xl font-bold">Go Home</a>
    </div>
</div>

{{-- ── Main Dashboard Content ── --}}
<div id="dashContent">

    {{-- ── HERO ── --}}
    <section class="dash-hero">
        <div class="max-w-7xl mx-auto relative z-10">

            {{-- Badge + Heading --}}
            <span class="inline-block px-4 py-1.5 rounded-full bg-emerald-500/20 text-emerald-300 font-bold text-sm mb-5 border border-emerald-500/30">
                🚀 Porter Dashboard
            </span>
            <div class="flex flex-col md:flex-row md:items-end justify-between gap-8 mb-10">
                <div>
                    <h1 class="text-4xl md:text-5xl font-extrabold text-white font-outfit leading-tight mb-3">
                        Welcome back,<br><span class="text-emerald-400" id="heroName">Porter</span>!
                    </h1>
                    <p class="text-slate-400 text-lg max-w-xl">
                        Manage your campaigns, create new ones, and track your impact — all in one place.
                    </p>
                </div>

                {{-- Stat cards --}}
                <div class="flex flex-wrap gap-4">
                    <div class="hero-stat">
                        <div id="sTotalCampaigns" class="hero-stat-val">—</div>
                        <div class="hero-stat-label">Total</div>
                    </div>
                    <div class="hero-stat">
                        <div id="sPending" class="hero-stat-val" style="color:#fbbf24;">—</div>
                        <div class="hero-stat-label">Pending</div>
                    </div>
                    <div class="hero-stat">
                        <div id="sActive" class="hero-stat-val">—</div>
                        <div class="hero-stat-label">Active</div>
                    </div>
                    <div class="hero-stat">
                        <div id="sTotalRaised" class="hero-stat-val" style="color:#a78bfa;">—</div>
                        <div class="hero-stat-label">Raised</div>
                    </div>
                </div>
            </div>

            {{-- Tab navigation --}}
            <div class="overflow-x-auto pb-1">
                <div class="dash-tab-bar">
                    <button class="dash-tab active" data-panel="overview" onclick="switchTab('overview', this)">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 5a1 1 0 011-1h4a1 1 0 011 1v4a1 1 0 01-1 1H5a1 1 0 01-1-1V5zM14 5a1 1 0 011-1h4a1 1 0 011 1v4a1 1 0 01-1 1h-4a1 1 0 01-1-1V5zM4 13a1 1 0 011-1h4a1 1 0 011 1v4a1 1 0 01-1 1H5a1 1 0 01-1-1v-4zM14 13a1 1 0 011-1h4a1 1 0 011 1v4a1 1 0 01-1 1h-4a1 1 0 01-1-1v-4z"/></svg>
                        Overview
                    </button>
                    <button class="dash-tab" data-panel="create" onclick="switchTab('create', this)">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                        New Campaign
                    </button>
                    <button class="dash-tab" data-panel="my-campaigns" onclick="switchTab('my-campaigns', this); loadMyCampaigns();">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/></svg>
                        My Campaigns
                    </button>
                </div>
            </div>
        </div>
    </section>

    {{-- ── CONTENT AREA (matches bg-slate-50 from campaigns) ── --}}
    <section class="py-12 px-6 bg-slate-50 min-h-screen">
        <div class="max-w-7xl mx-auto">

            {{-- ── OVERVIEW ── --}}
            <div id="panel-overview" class="dash-panel active">

                {{-- Recent campaigns --}}
                <div class="bg-white rounded-3xl border border-gray-100 shadow-sm overflow-hidden">
                    <div class="flex items-center justify-between px-8 py-6 border-b border-gray-100">
                        <div>
                            <h2 class="text-xl font-bold font-outfit">Recent Campaigns</h2>
                            <p class="text-gray-400 text-sm mt-0.5">Your latest campaign submissions</p>
                        </div>
                        <button onclick="switchTab('create', document.querySelector('[data-panel=create]'))"
                            class="btn-primary px-5 py-2.5 rounded-xl text-sm font-bold" style="padding:.65rem 1.25rem;font-size:.85rem;">
                            + New Campaign
                        </button>
                    </div>
                    <div id="recentList" class="p-8">
                        <div class="text-center py-10 text-gray-400">
                            <div class="w-7 h-7 border-2 border-emerald-400 border-t-transparent rounded-full animate-spin mx-auto mb-3"></div>
                            Loading…
                        </div>
                    </div>
                </div>

                {{-- How it works info card --}}
                <div class="mt-8 bg-slate-900 rounded-3xl p-8 md:p-10 relative overflow-hidden">
                    <div class="absolute right-0 top-0 w-64 h-64 bg-emerald-500/10 blur-[80px] rounded-full pointer-events-none"></div>
                    <h3 class="text-2xl font-bold text-white font-outfit mb-6">How campaign approval works</h3>
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 relative z-10">
                        <div class="flex items-start gap-4">
                            <div class="w-10 h-10 rounded-xl bg-emerald-500/20 border border-emerald-500/30 flex items-center justify-center flex-shrink-0">
                                <span class="text-emerald-400 font-bold">1</span>
                            </div>
                            <div>
                                <p class="text-white font-bold mb-1">You Submit</p>
                                <p class="text-slate-400 text-sm">Fill the form with your campaign details and cover image. Status will be <span class="text-amber-400 font-semibold">Pending</span>.</p>
                            </div>
                        </div>
                        <div class="flex items-start gap-4">
                            <div class="w-10 h-10 rounded-xl bg-indigo-500/20 border border-indigo-500/30 flex items-center justify-center flex-shrink-0">
                                <span class="text-indigo-400 font-bold">2</span>
                            </div>
                            <div>
                                <p class="text-white font-bold mb-1">Admin Reviews</p>
                                <p class="text-slate-400 text-sm">Our team checks your campaign for accuracy and compliance within 24 hours.</p>
                            </div>
                        </div>
                        <div class="flex items-start gap-4">
                            <div class="w-10 h-10 rounded-xl bg-emerald-500/20 border border-emerald-500/30 flex items-center justify-center flex-shrink-0">
                                <span class="text-emerald-400 font-bold">3</span>
                            </div>
                            <div>
                                <p class="text-white font-bold mb-1">Goes Live</p>
                                <p class="text-slate-400 text-sm">Once approved, your campaign becomes <span class="text-emerald-400 font-semibold">Active</span> and visible to all donors.</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- ── CREATE CAMPAIGN ── --}}
            <div id="panel-create" class="dash-panel">
                <div class="max-w-2xl mx-auto">
                    <div class="bg-white rounded-3xl border border-gray-100 shadow-sm p-8 md:p-10">

                        <div class="flex items-center gap-4 mb-8">
                            <div class="w-12 h-12 rounded-2xl bg-emerald-100 flex items-center justify-center">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-emerald-600" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                            </div>
                            <div>
                                <h2 class="text-2xl font-bold font-outfit">Create New Campaign</h2>
                                <p class="text-gray-400 text-sm mt-0.5">Submitted campaigns are reviewed before going live.</p>
                            </div>
                        </div>

                        <div class="alert alert-success" id="createSuccess">
                            ✅ Campaign submitted! It will go live after admin review — usually within 24 hours.
                        </div>
                        <div class="alert alert-error" id="createError"></div>

                        <form id="createCampaignForm" novalidate class="space-y-6">

                            <div>
                                <label class="field-label">Campaign Title <span class="text-red-400">*</span></label>
                                <input type="text" id="cTitle" class="field-input" placeholder="Give your campaign a clear, compelling title" required maxlength="255">
                            </div>

                            <div>
                                <label class="field-label">Description <span class="text-red-400">*</span></label>
                                <textarea id="cDesc" class="field-input" placeholder="Tell your story — why this campaign matters, how funds will be used…" required></textarea>
                            </div>

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                                <div>
                                    <label class="field-label">Category <span class="text-red-400">*</span></label>
                                    <select id="cCategory" class="field-input" required>
                                        <option value="">Select a category…</option>
                                    </select>
                                </div>
                                <div>
                                    <label class="field-label">Fundraising Goal (USD) <span class="text-red-400">*</span></label>
                                    <input type="number" id="cTarget" class="field-input" placeholder="e.g. 5000" min="1" required>
                                </div>
                            </div>

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                                <div>
                                    <label class="field-label">Start Date</label>
                                    <input type="date" id="cStartDate" class="field-input">
                                </div>
                                <div>
                                    <label class="field-label">End Date</label>
                                    <input type="date" id="cEndDate" class="field-input">
                                </div>
                            </div>

                            <div>
                                <label class="field-label">Cover Image <span class="text-gray-400 font-normal">(optional)</span></label>
                                <div class="drop-zone" id="dropZone">
                                    <input type="file" id="cImage" accept="image/jpeg,image/png,image/jpg,image/gif">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-10 w-10 text-gray-300 mx-auto mb-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                    </svg>
                                    <p class="text-gray-400 text-sm font-semibold">Click or drag & drop an image here</p>
                                    <p class="text-gray-300 text-xs mt-1">JPG, PNG, GIF · Max 4 MB</p>
                                    <img id="dropPreview" class="drop-preview" alt="Preview">
                                </div>
                            </div>

                            {{-- Pending notice (matches the glassmorphism card from welcome page) --}}
                            <div class="flex items-start gap-3 p-4 rounded-2xl bg-amber-50 border border-amber-100">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-amber-500 flex-shrink-0 mt-0.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                </svg>
                                <p class="text-amber-800 text-sm font-medium leading-relaxed">
                                    After submission your campaign will be <strong>Pending</strong> until an admin approves it. You'll see the status update in <em>My Campaigns</em>.
                                </p>
                            </div>

                            <div class="flex items-center gap-5 pt-2">
                                <button type="submit" id="submitBtn" class="submit-btn">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                                    Submit for Review
                                </button>
                                <button type="button" onclick="resetForm()" class="text-gray-400 hover:text-gray-600 font-semibold text-sm transition-colors">Reset</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            {{-- ── MY CAMPAIGNS ── --}}
            <div id="panel-my-campaigns" class="dash-panel">
                <div class="bg-white rounded-3xl border border-gray-100 shadow-sm overflow-hidden">
                    <div class="flex items-center justify-between px-8 py-6 border-b border-gray-100">
                        <div>
                            <h2 class="text-xl font-bold font-outfit">My Campaigns</h2>
                            <p class="text-gray-400 text-sm mt-0.5">All campaigns you have submitted</p>
                        </div>
                        <button onclick="loadMyCampaigns()" class="flex items-center gap-2 text-emerald-600 font-bold text-sm hover:text-emerald-700 transition-colors px-4 py-2 rounded-xl hover:bg-emerald-50">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/></svg>
                            Refresh
                        </button>
                    </div>
                    <div id="myCampaignsBody" class="p-4">
                        <div class="text-center py-16 text-gray-400">
                            <div class="w-8 h-8 border-2 border-emerald-400 border-t-transparent rounded-full animate-spin mx-auto mb-3"></div>
                            Loading your campaigns…
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </section>

</div>{{-- /dashContent --}}

@endsection

@section('scripts')
<script>
// ─── Boot ─────────────────────────────────────
document.addEventListener('DOMContentLoaded', async () => {
    const loading   = document.getElementById('dashLoading');
    const guest     = document.getElementById('dashGuest');
    const wrongRole = document.getElementById('dashWrongRole');
    const content   = document.getElementById('dashContent');

    if (!ApiClient.isAuthenticated()) {
        loading.style.display = 'none';
        guest.style.display   = 'flex';
        return;
    }

    let user;
    try {
        user = await ApiClient.request('/auth/me');
        ApiClient.setUser(user);
    } catch(e) {
        loading.style.display = 'none';
        guest.style.display   = 'flex';
        return;
    }

    if (user.role !== 'porter' && user.role !== 'organisation') {
        loading.style.display   = 'none';
        wrongRole.style.display = 'flex';
        return;
    }

    loading.style.display  = 'none';
    content.style.display  = 'block';
    document.getElementById('heroName').textContent = user.first_name || 'Porter';

    await Promise.all([loadCategories(), loadOverview()]);
});

// ─── Tab switching ────────────────────────────
function switchTab(name, btn) {
    document.querySelectorAll('.dash-panel').forEach(p => p.classList.remove('active'));
    document.querySelectorAll('.dash-tab').forEach(b => b.classList.remove('active'));
    document.getElementById('panel-' + name).classList.add('active');
    if (btn) btn.classList.add('active');
}

// ─── Categories ───────────────────────────────
async function loadCategories() {
    try {
        const res = await fetch('/api/categories', { headers: { 'Accept': 'application/json' } });
        const json = await res.json();
        const cats = json.data || json || [];
        const sel = document.getElementById('cCategory');
        cats.forEach(c => {
            const opt = document.createElement('option');
            opt.value = c.id;
            opt.textContent = c.name || c.category_name;
            sel.appendChild(opt);
        });
    } catch(e) {}
}

// ─── Overview ─────────────────────────────────
async function loadOverview() {
    try {
        const res = await ApiClient.request('/my-campaigns');
        const list = res.data || res || [];

        document.getElementById('sTotalCampaigns').textContent = list.length;
        document.getElementById('sPending').textContent        = list.filter(c => c.status === 'pending').length;
        document.getElementById('sActive').textContent         = list.filter(c => c.status === 'active').length;
        const raised = list.reduce((s, c) => s + parseFloat(c.current_amount || 0), 0);
        document.getElementById('sTotalRaised').textContent    = '$' + raised.toLocaleString('en-US', {maximumFractionDigits: 0});

        renderRecentList(list.slice(0, 5));
    } catch(e) {
        document.getElementById('recentList').innerHTML = '<p class="text-center text-gray-400 py-8">Could not load campaigns.</p>';
    }
}

function renderRecentList(list) {
    const el = document.getElementById('recentList');
    if (!list.length) {
        el.innerHTML = `<div class="text-center py-16">
            <div class="w-16 h-16 bg-emerald-100 rounded-full flex items-center justify-center mx-auto mb-4">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-emerald-500" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 4v16m8-8H4"/></svg>
            </div>
            <p class="text-gray-500 font-semibold mb-1">No campaigns yet</p>
            <p class="text-gray-400 text-sm mb-6">Create your first campaign to get started.</p>
            <button onclick="switchTab('create', document.querySelector('[data-panel=create]'))" class="submit-btn" style="padding:.7rem 1.5rem;font-size:.875rem;">
                Create Campaign
            </button>
        </div>`;
        return;
    }

    el.innerHTML = `<div class="space-y-3">` + list.map(c => {
        const img = c.images && c.images[0] ? `<img src="${c.images[0].url}" class="thumb-sm">` : `<div class="thumb-sm"><svg xmlns='http://www.w3.org/2000/svg' class='h-5 w-5' fill='none' viewBox='0 0 24 24' stroke='currentColor'><path stroke-linecap='round' stroke-linejoin='round' stroke-width='1.5' d='M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z'/></svg></div>`;
        const pct = Math.min(100, ((c.current_amount||0)/Math.max(1,c.target_amount||1))*100).toFixed(0);
        return `<div class="flex items-center gap-4 p-4 rounded-2xl bg-gray-50 hover:bg-emerald-50 border border-transparent hover:border-emerald-100 transition-all">
            ${img}
            <div class="flex-1 min-w-0">
                <p class="font-bold text-gray-800 text-sm truncate">${escHtml(c.title)}</p>
                <div class="prog-track mt-1.5 w-32"><div class="prog-fill" style="width:${pct}%"></div></div>
            </div>
            <div class="flex items-center gap-3 flex-shrink-0">
                <span class="text-emerald-600 font-bold text-sm">$${fmtNum(c.current_amount||0)}</span>
                <span class="s-pill s-${c.status}">${statusIcon(c.status)} ${c.status}</span>
            </div>
        </div>`;
    }).join('') + `</div>`;
}

// ─── My Campaigns table ───────────────────────
async function loadMyCampaigns() {
    const body = document.getElementById('myCampaignsBody');
    body.innerHTML = `<div class="text-center py-16 text-gray-400"><div class="w-8 h-8 border-2 border-emerald-400 border-t-transparent rounded-full animate-spin mx-auto mb-3"></div>Loading…</div>`;

    try {
        const res = await ApiClient.request('/my-campaigns');
        const list = res.data || res || [];

        if (!list.length) {
            body.innerHTML = `<div class="text-center py-16">
                <p class="text-gray-400 mb-5">No campaigns yet.</p>
                <button onclick="switchTab('create', document.querySelector('[data-panel=create]'))" class="submit-btn" style="padding:.7rem 1.5rem;font-size:.875rem;">
                    Create Campaign
                </button>
            </div>`;
            return;
        }

        body.innerHTML = `<div class="overflow-x-auto">
        <table class="camp-table">
            <thead><tr>
                <th>Campaign</th>
                <th>Category</th>
                <th>Goal</th>
                <th>Raised</th>
                <th>Status</th>
                <th>Submitted</th>
            </tr></thead>
            <tbody>${list.map(c => {
                const img = c.images && c.images[0]
                    ? `<img src="${c.images[0].url}" class="thumb-sm">`
                    : `<div class="thumb-sm"><svg xmlns='http://www.w3.org/2000/svg' class='h-5 w-5' fill='none' viewBox='0 0 24 24' stroke='currentColor'><path stroke-linecap='round' stroke-linejoin='round' stroke-width='1.5' d='M4 16l4.586-4.586a2 2 0 012.828 0L16 16M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z'/></svg></div>`;
                const cat = c.category ? (c.category.name || c.category.category_name || '—') : '—';
                const pct = Math.min(100, ((c.current_amount||0)/Math.max(1,c.target_amount||1))*100).toFixed(1);
                return `<tr>
                    <td>
                        <div style="display:flex;align-items:center;gap:.75rem;">
                            ${img}
                            <div>
                                <p style="font-weight:700;color:#0f172a;max-width:220px;overflow:hidden;text-overflow:ellipsis;white-space:nowrap;">${escHtml(c.title)}</p>
                                <div class="prog-track" style="width:100px;margin-top:.35rem;"><div class="prog-fill" style="width:${pct}%"></div></div>
                            </div>
                        </div>
                    </td>
                    <td>${escHtml(cat)}</td>
                    <td style="font-weight:700;color:#0f172a;">$${fmtNum(c.target_amount)}</td>
                    <td style="font-weight:700;color:#10b981;">$${fmtNum(c.current_amount||0)}</td>
                    <td><span class="s-pill s-${c.status}">${statusIcon(c.status)} ${c.status}</span></td>
                    <td style="color:#94a3b8;">${fmtDate(c.created_at)}</td>
                </tr>`;
            }).join('')}</tbody>
        </table></div>`;
    } catch(e) {
        body.innerHTML = '<p class="text-center text-red-400 py-8">Failed to load campaigns.</p>';
    }
}

// ─── Create Campaign Form ─────────────────────
const dropZone   = document.getElementById('dropZone');
const imageInput = document.getElementById('cImage');
const preview    = document.getElementById('dropPreview');

['dragover','dragenter'].forEach(ev => dropZone.addEventListener(ev, e => { e.preventDefault(); dropZone.classList.add('dragover'); }));
['dragleave','drop'].forEach(ev   => dropZone.addEventListener(ev, e => { e.preventDefault(); dropZone.classList.remove('dragover'); }));
dropZone.addEventListener('drop', e => { imageInput.files = e.dataTransfer.files; previewImage(); });
imageInput.addEventListener('change', previewImage);

function previewImage() {
    const file = imageInput.files[0];
    if (!file) return;
    const reader = new FileReader();
    reader.onload = e => { preview.src = e.target.result; preview.style.display = 'block'; };
    reader.readAsDataURL(file);
}

document.getElementById('createCampaignForm').addEventListener('submit', async (e) => {
    e.preventDefault();
    const btn     = document.getElementById('submitBtn');
    const success = document.getElementById('createSuccess');
    const errorEl = document.getElementById('createError');
    success.style.display = 'none';
    errorEl.style.display = 'none';

    const title  = document.getElementById('cTitle').value.trim();
    const desc   = document.getElementById('cDesc').value.trim();
    const catId  = document.getElementById('cCategory').value;
    const target = document.getElementById('cTarget').value;
    const start  = document.getElementById('cStartDate').value;
    const end    = document.getElementById('cEndDate').value;
    const img    = imageInput.files[0];

    if (!title || !desc || !catId || !target) {
        errorEl.textContent = 'Please fill in all required fields.';
        errorEl.style.display = 'block';
        return;
    }

    const fd = new FormData();
    fd.append('title', title);
    fd.append('description', desc);
    fd.append('category_id', catId);
    fd.append('target_amount', target);
    if (start) fd.append('start_date', start);
    if (end)   fd.append('end_date',   end);
    if (img)   fd.append('image', img);

    btn.disabled = true;
    btn.innerHTML = `<svg class="animate-spin h-5 w-5" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"/><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"/></svg> Submitting…`;

    try {
        await ApiClient.request('/campaigns', {
            method: 'POST',
            body: fd,
            headers: { 'Content-Type': null }
        });
        success.style.display = 'block';
        success.scrollIntoView({ behavior: 'smooth', block: 'center' });
        resetForm();
        await loadOverview();
    } catch(err) {
        const msg = err.message || (err.errors ? Object.values(err.errors).flat()[0] : 'Submission failed.');
        errorEl.textContent = msg;
        errorEl.style.display = 'block';
    } finally {
        btn.disabled = false;
        btn.innerHTML = `<svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg> Submit for Review`;
    }
});

function resetForm() {
    document.getElementById('createCampaignForm').reset();
    preview.style.display = 'none';
    preview.src = '';
}

// ─── Utils ────────────────────────────────────
function statusIcon(s) { return {pending:'⏳',active:'✅',completed:'🏁',cancelled:'❌'}[s]||'•'; }
function fmtNum(n)  { return Number(n||0).toLocaleString('en-US'); }
function fmtDate(iso) {
    if (!iso) return '—';
    return new Date(iso).toLocaleDateString('en-GB',{day:'numeric',month:'short',year:'numeric'});
}
function escHtml(s) {
    const d = document.createElement('div');
    d.appendChild(document.createTextNode(s||''));
    return d.innerHTML;
}
</script>
@endsection
