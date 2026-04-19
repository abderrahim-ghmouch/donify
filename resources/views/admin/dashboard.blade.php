@extends('layouts.app')

@section('styles')
<style>
    /* ── Root layout ── */
    .admin-wrap {
        display: grid;
        grid-template-columns: 20% 80%;
        min-height: calc(100vh - 80px);
        background: #f1f5f9;
    }
    @media (max-width: 900px) {
        .admin-wrap { grid-template-columns: 1fr; }
        .admin-sidebar { display: none; }
    }

    /* ════════════════════════════════
       SIDEBAR  (20%)
    ════════════════════════════════ */
    .admin-sidebar {
        background: #0f172a;
        display: flex;
        flex-direction: column;
        padding: 2rem 1.25rem 1.5rem;
        position: sticky;
        top: 80px;
        height: calc(100vh - 80px);
        overflow-y: auto;
        border-right: 1px solid rgba(255,255,255,.05);
    }

    /* Brand */
    .sb-brand {
        display: flex; align-items: center; gap: .75rem;
        margin-bottom: 2.5rem; padding-bottom: 1.5rem;
        border-bottom: 1px solid rgba(255,255,255,.07);
    }
    .sb-brand-icon {
        width: 38px; height: 38px; border-radius: .875rem;
        background: linear-gradient(135deg,#10b981,#059669);
        display: flex; align-items: center; justify-content: center;
        box-shadow: 0 4px 12px rgba(16,185,129,.4);
    }
    .sb-brand-text { font-family:'Outfit',sans-serif; font-weight:800; font-size:1.1rem; color:#fff; line-height:1; }
    .sb-brand-sub  { font-size:.65rem; color:#64748b; font-weight:600; letter-spacing:.06em; text-transform:uppercase; margin-top:.1rem; }

    /* Section label */
    .sb-section { font-size:.68rem; font-weight:700; color:#475569; text-transform:uppercase; letter-spacing:.09em; padding:.4rem .75rem; margin-top:1.25rem; margin-bottom:.2rem; }

    /* Nav item */
    .sb-item {
        display:flex; align-items:center; gap:.8rem;
        padding:.7rem .9rem; border-radius:.875rem;
        color:#94a3b8; font-weight:600; font-size:.875rem;
        cursor:pointer; border:none; background:transparent;
        width:100%; text-align:left; transition:all .2s; text-decoration:none;
        position: relative;
    }
    .sb-item svg { width:18px; height:18px; flex-shrink:0; }
    .sb-item:hover { background:rgba(255,255,255,.07); color:#e2e8f0; }
    .sb-item.active { background:rgba(16,185,129,.15); color:#34d399; }
    .sb-item.active::before {
        content:''; position:absolute; left:0; top:20%; bottom:20%;
        width:3px; background:#10b981; border-radius:9999px;
    }

    /* Badge on nav */
    .sb-badge {
        margin-left:auto; background:#ef4444; color:#fff;
        font-size:.65rem; font-weight:800; min-width:18px; height:18px;
        border-radius:9999px; display:flex; align-items:center; justify-content:center;
        padding:0 .3rem;
    }
    .sb-badge.amber { background:#f59e0b; }

    /* Bottom user card */
    .sb-user {
        margin-top: auto; padding-top: 1.5rem;
        border-top: 1px solid rgba(255,255,255,.07);
        display:flex; align-items:center; gap:.75rem;
    }
    .sb-avatar {
        width:38px; height:38px; border-radius:.75rem;
        background:#1e3a5f; display:flex; align-items:center;
        justify-content:center; color:#38bdf8; font-weight:800;
        overflow:hidden; flex-shrink:0;
    }
    .sb-user-name  { color:#e2e8f0; font-weight:700; font-size:.85rem; }
    .sb-user-role  { color:#64748b; font-size:.7rem; font-weight:600; text-transform:uppercase; letter-spacing:.05em; }

    /* ════════════════════════════════
       MAIN AREA  (80%)
    ════════════════════════════════ */
    .admin-main { overflow-y: auto; }

    /* Top bar */
    .admin-topbar {
        background:#fff; border-bottom:1px solid #f1f5f9;
        padding:1.25rem 2rem;
        display:flex; align-items:center; justify-content:space-between;
        position: sticky; top: 80px; z-index: 10;
    }
    .admin-topbar h1 { font-family:'Outfit',sans-serif; font-size:1.4rem; font-weight:800; color:#0f172a; }
    .admin-topbar p  { color:#94a3b8; font-size:.82rem; margin-top:.1rem; }

    /* Stat cards */
    .stat-row { display:grid; grid-template-columns:repeat(auto-fit,minmax(160px,1fr)); gap:1rem; padding:1.5rem 2rem 0; }
    .stat-card {
        background:#fff; border-radius:1.25rem;
        border:1px solid #f1f5f9;
        box-shadow: 0 1px 6px rgba(0,0,0,.04);
        padding:1.25rem 1.5rem;
        display:flex; align-items:center; gap:.875rem;
        transition: all .25s;
    }
    .stat-card:hover { transform:translateY(-2px); box-shadow:0 6px 20px rgba(0,0,0,.08); }
    .stat-icon { width:46px; height:46px; border-radius:.875rem; display:flex; align-items:center; justify-content:center; flex-shrink:0; }
    .stat-icon svg { width:22px; height:22px; }
    .stat-val { font-size:1.6rem; font-weight:800; line-height:1; font-family:'Outfit',sans-serif; }
    .stat-lbl { font-size:.72rem; color:#94a3b8; font-weight:700; text-transform:uppercase; letter-spacing:.05em; margin-top:.2rem; }

    /* ── Panels ── */
    .admin-body { padding:1.5rem 2rem 3rem; }
    .panel { display:none; animation:fadeUp .3s ease both; }
    .panel.active { display:block; }
    @keyframes fadeUp { from{opacity:0;transform:translateY(14px)} to{opacity:1;transform:translateY(0)} }

    /* Section header */
    .section-head {
        display:flex; align-items:center; justify-content:space-between;
        margin-bottom:1.25rem;
    }
    .section-head h2 { font-size:1.15rem; font-weight:800; color:#0f172a; font-family:'Outfit',sans-serif; }
    .section-head p  { color:#94a3b8; font-size:.82rem; margin-top:.15rem; }

    /* ── Cards ── */
    .card {
        background:#fff; border-radius:1.5rem;
        border:1px solid #f1f5f9;
        box-shadow: 0 1px 8px rgba(0,0,0,.04);
        overflow:hidden;
    }
    .card-header {
        padding:1.1rem 1.5rem;
        border-bottom:1px solid #f8fafc;
        display:flex; align-items:center; justify-content:space-between;
        background:#fff;
    }
    .card-header h3 { font-weight:800; font-size:1rem; color:#0f172a; }

    /* ── Tables ── */
    .data-table { width:100%; border-collapse:collapse; }
    .data-table th {
        text-align:left; font-size:.72rem; font-weight:700;
        color:#64748b; text-transform:uppercase; letter-spacing:.06em;
        padding:.85rem 1.25rem; background:#f8fafc; border-bottom:1px solid #f1f5f9;
        white-space: nowrap;
    }
    .data-table td {
        padding:.95rem 1.25rem; border-bottom:1px solid #f8fafc;
        font-size:.875rem; color:#374151; vertical-align:middle;
    }
    .data-table tr:last-child td { border-bottom:none; }
    .data-table tr:hover td { background:#fafffe; }

    /* ── Status pills ── */
    .pill {
        display:inline-flex; align-items:center; gap:.3rem;
        padding:.25rem .75rem; border-radius:9999px;
        font-size:.72rem; font-weight:700; white-space:nowrap;
    }
    .p-pending   { background:#fef3c7; color:#92400e; }
    .p-active    { background:#d1fae5; color:#065f46; }
    .p-cancelled { background:#fee2e2; color:#991b1b; }
    .p-completed { background:#ede9fe; color:#5b21b6; }
    .p-donor     { background:#e0f2fe; color:#0369a1; }
    .p-porter    { background:#d1fae5; color:#065f46; }
    .p-admin     { background:#fce7f3; color:#9d174d; }
    .p-banned    { background:#fee2e2; color:#991b1b; }
    .p-active-user { background:#d1fae5; color:#065f46; }

    /* ── Action buttons ── */
    .btn-approve {
        display:inline-flex; align-items:center; gap:.35rem;
        padding:.4rem .9rem; border-radius:.6rem;
        background:#d1fae5; color:#065f46; font-weight:700;
        font-size:.78rem; border:1px solid #a7f3d0;
        cursor:pointer; transition:all .2s;
    }
    .btn-approve:hover { background:#10b981; color:#fff; border-color:#10b981; }

    .btn-reject {
        display:inline-flex; align-items:center; gap:.35rem;
        padding:.4rem .9rem; border-radius:.6rem;
        background:#fee2e2; color:#991b1b; font-weight:700;
        font-size:.78rem; border:1px solid #fecaca;
        cursor:pointer; transition:all .2s;
    }
    .btn-reject:hover { background:#ef4444; color:#fff; border-color:#ef4444; }

    .btn-ban {
        display:inline-flex; align-items:center; gap:.35rem;
        padding:.4rem .9rem; border-radius:.6rem;
        background:#fef3c7; color:#92400e; font-weight:700;
        font-size:.78rem; border:1px solid #fde68a;
        cursor:pointer; transition:all .2s;
    }
    .btn-ban:hover { background:#f59e0b; color:#fff; border-color:#f59e0b; }

    .btn-unban {
        display:inline-flex; align-items:center; gap:.35rem;
        padding:.4rem .9rem; border-radius:.6rem;
        background:#e0f2fe; color:#0369a1; font-weight:700;
        font-size:.78rem; border:1px solid #bae6fd;
        cursor:pointer; transition:all .2s;
    }
    .btn-unban:hover { background:#0ea5e9; color:#fff; border-color:#0ea5e9; }

    /* ── Filter pills (campaigns panel) ── */
    .filter-pill {
        padding:.4rem 1rem; border-radius:9999px;
        border:1.5px solid #e2e8f0; background:#fff;
        font-size:.8rem; font-weight:700; color:#64748b;
        cursor:pointer; transition:all .2s; white-space:nowrap;
    }
    .filter-pill:hover,.filter-pill.active { border-color:#10b981; background:#ecfdf5; color:#065f46; }
    .filter-pill.active { box-shadow:0 0 0 3px rgba(16,185,129,.12); }

    /* ── Search input ── */
    .search-input {
        padding:.55rem 1rem; border-radius:.875rem;
        border:1.5px solid #e2e8f0; background:#fff;
        font-size:.85rem; color:#0f172a; outline:none;
        transition:all .2s; min-width:220px;
    }
    .search-input:focus { border-color:#10b981; box-shadow:0 0 0 3px rgba(16,185,129,.1); }
    .search-input::placeholder { color:#94a3b8; }

    /* ── Avatar thumbnail ── */
    .thumb { width:38px; height:38px; border-radius:.625rem; object-fit:cover; background:#f1f5f9; flex-shrink:0; display:inline-flex; align-items:center; justify-content:center; color:#94a3b8; overflow:hidden; font-weight:700; font-size:.85rem; }

    /* ── Toast ── */
    #toast {
        position:fixed; bottom:1.5rem; right:1.5rem; z-index:9999;
        padding:.85rem 1.5rem; border-radius:1rem;
        font-weight:700; font-size:.875rem;
        box-shadow:0 8px 30px rgba(0,0,0,.15);
        display:none; min-width:240px;
        transition: all .3s ease;
    }
    #toast.success { background:#ecfdf5; color:#065f46; border:1px solid #a7f3d0; }
    #toast.error   { background:#fef2f2; color:#991b1b; border:1px solid #fecaca; }

    /* ── Guards ── */
    #adminLoading { display:flex; }
    #adminGuest, #adminWrongRole, #adminContent { display:none; }
</style>
@endsection

@section('content')

{{-- Loading --}}
<div id="adminLoading" class="min-h-screen items-center justify-center flex">
    <div class="text-center">
        <div class="w-14 h-14 border-4 border-emerald-500 border-t-transparent rounded-full animate-spin mx-auto mb-4"></div>
        <p class="text-gray-400 font-medium">Loading admin panel…</p>
    </div>
</div>

{{-- Guest --}}
<div id="adminGuest" class="min-h-screen items-center justify-center flex py-20 px-6">
    <div class="text-center max-w-sm">
        <div class="w-20 h-20 bg-emerald-100 rounded-full flex items-center justify-center mx-auto mb-6">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-10 w-10 text-emerald-500" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/></svg>
        </div>
        <h2 class="text-2xl font-bold font-outfit mb-3">Authentication Required</h2>
        <p class="text-gray-500 mb-8">Please log in with an admin account to access this panel.</p>
        <a href="{{ route('login') }}" class="btn-primary px-8 py-3 rounded-xl font-bold">Sign In</a>
    </div>
</div>

{{-- Wrong role --}}
<div id="adminWrongRole" class="min-h-screen items-center justify-center flex py-20 px-6">
    <div class="text-center max-w-sm">
        <div class="w-20 h-20 bg-red-100 rounded-full flex items-center justify-center mx-auto mb-6">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-10 w-10 text-red-500" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M18.364 18.364A9 9 0 005.636 5.636m12.728 12.728A9 9 0 015.636 5.636m12.728 12.728L5.636 5.636"/></svg>
        </div>
        <h2 class="text-2xl font-bold font-outfit mb-3">Admin Access Only</h2>
        <p class="text-gray-500 mb-8">You do not have permission to view this page.</p>
        <a href="{{ route('home') }}" class="btn-primary px-8 py-3 rounded-xl font-bold">Go Home</a>
    </div>
</div>

{{-- ═══════════════════════════════════════
     ADMIN CONTENT
═══════════════════════════════════════ --}}
<div id="adminContent">
<div class="admin-wrap">

    {{-- ════════ SIDEBAR 20% ════════ --}}
    <aside class="admin-sidebar">

        <div class="sb-brand">
            <div class="sb-brand-icon">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/></svg>
            </div>
            <div>
                <div class="sb-brand-text">Donify</div>
                <div class="sb-brand-sub">Admin Panel</div>
            </div>
        </div>

        <div class="sb-section">Main</div>
        <button class="sb-item active" data-target="overview" onclick="switchPanel('overview',this)">
            <svg fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 5a1 1 0 011-1h4a1 1 0 011 1v4a1 1 0 01-1 1H5a1 1 0 01-1-1V5zM4 13a1 1 0 011-1h4a1 1 0 011 1v4a1 1 0 01-1 1H5a1 1 0 01-1-1v-4zM14 5a1 1 0 011-1h4a1 1 0 011 1v4a1 1 0 01-1 1h-4a1 1 0 01-1-1V5zM14 13a1 1 0 011-1h4a1 1 0 011 1v4a1 1 0 01-1 1h-4a1 1 0 01-1-1v-4z"/></svg>
            Overview
        </button>

        <div class="sb-section">Moderation</div>
        <button class="sb-item" data-target="campaigns" onclick="switchPanel('campaigns',this); loadAllCampaigns();">
            <svg fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/></svg>
            Campaigns
            <span class="sb-badge amber" id="sbPendingCount">0</span>
        </button>
        <button class="sb-item" data-target="users" onclick="switchPanel('users',this); loadUsers();">
            <svg fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/></svg>
            Users
            <span class="sb-badge" id="sbBannedCount">0</span>
        </button>

        <div class="sb-section">Site</div>
        <a href="{{ route('campaigns.index') }}" class="sb-item">
            <svg fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3.055 11H5a2 2 0 012 2v1a2 2 0 002 2 2 2 0 012 2v2.945M8 3.935V5.5A2.5 2.5 0 0010.5 8h.5a2 2 0 012 2 2 2 0 104 0 2 2 0 012-2h1.064M15 20.488V18a2 2 0 012-2h3.064M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
            View Public Site
        </a>
        <button class="sb-item" onclick="handleLogout()">
            <svg fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/></svg>
            Sign Out
        </button>

        {{-- Admin user card --}}
        <div class="sb-user">
            <div class="sb-avatar" id="sbAvatar">A</div>
            <div>
                <div class="sb-user-name" id="sbName">Admin</div>
                <div class="sb-user-role">Administrator</div>
            </div>
        </div>
    </aside>

    {{-- ════════ MAIN AREA 80% ════════ --}}
    <div class="admin-main">

        {{-- Topbar --}}
        <div class="admin-topbar">
            <div>
                <h1 id="panelTitle">Overview</h1>
                <p id="panelSub">Platform overview and key metrics</p>
            </div>
            <div class="flex items-center gap-3">
                <span class="text-xs font-bold text-gray-400 uppercase tracking-wider">Admin Console</span>
                <div class="w-2 h-2 rounded-full bg-emerald-400 animate-pulse"></div>
            </div>
        </div>

        {{-- Stat row --}}
        <div class="stat-row" id="statRow">
            <div class="stat-card">
                <div class="stat-icon" style="background:#d1fae5;">
                    <svg class="text-emerald-600" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/></svg>
                </div>
                <div>
                    <div id="sUsers" class="stat-val text-emerald-600">—</div>
                    <div class="stat-lbl">Total Users</div>
                </div>
            </div>
            <div class="stat-card">
                <div class="stat-icon" style="background:#fee2e2;">
                    <svg class="text-red-500" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18.364 18.364A9 9 0 005.636 5.636m12.728 12.728A9 9 0 015.636 5.636m12.728 12.728L5.636 5.636"/></svg>
                </div>
                <div>
                    <div id="sBanned" class="stat-val text-red-500">—</div>
                    <div class="stat-lbl">Banned</div>
                </div>
            </div>
            <div class="stat-card">
                <div class="stat-icon" style="background:#fef3c7;">
                    <svg class="text-amber-500" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                </div>
                <div>
                    <div id="sPendingCamps" class="stat-val" style="color:#d97706;">—</div>
                    <div class="stat-lbl">Pending</div>
                </div>
            </div>
            <div class="stat-card">
                <div class="stat-icon" style="background:#d1fae5;">
                    <svg class="text-emerald-600" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                </div>
                <div>
                    <div id="sActiveCamps" class="stat-val text-emerald-600">—</div>
                    <div class="stat-lbl">Active Camps</div>
                </div>
            </div>
            <div class="stat-card">
                <div class="stat-icon" style="background:#ede9fe;">
                    <svg class="text-indigo-500" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/></svg>
                </div>
                <div>
                    <div id="sTotalCamps" class="stat-val text-indigo-600">—</div>
                    <div class="stat-lbl">All Camps</div>
                </div>
            </div>
        </div>

        {{-- ────── PANELS ────── --}}
        <div class="admin-body">

            {{-- ── OVERVIEW ── --}}
            <div id="panel-overview" class="panel active">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

                    {{-- Pending campaigns mini --}}
                    <div class="card">
                        <div class="card-header">
                            <div>
                                <h3>⏳ Pending Campaigns</h3>
                                <p class="text-xs text-gray-400 mt-0.5">Awaiting your review</p>
                            </div>
                            <button onclick="switchPanel('campaigns', document.querySelector('[data-target=campaigns]')); loadAllCampaigns();" class="text-emerald-600 text-xs font-bold hover:underline">View all →</button>
                        </div>
                        <div id="ovPendingList" class="p-4 space-y-2 max-h-72 overflow-y-auto">
                            <div class="text-center py-6 text-gray-400 text-sm">
                                <div class="w-6 h-6 border-2 border-emerald-400 border-t-transparent rounded-full animate-spin mx-auto mb-2"></div>Loading…
                            </div>
                        </div>
                    </div>

                    {{-- Recent users mini --}}
                    <div class="card">
                        <div class="card-header">
                            <div>
                                <h3>👥 Recent Users</h3>
                                <p class="text-xs text-gray-400 mt-0.5">Latest registrations</p>
                            </div>
                            <button onclick="switchPanel('users', document.querySelector('[data-target=users]')); loadUsers();" class="text-emerald-600 text-xs font-bold hover:underline">View all →</button>
                        </div>
                        <div id="ovUserList" class="p-4 space-y-2 max-h-72 overflow-y-auto">
                            <div class="text-center py-6 text-gray-400 text-sm">
                                <div class="w-6 h-6 border-2 border-emerald-400 border-t-transparent rounded-full animate-spin mx-auto mb-2"></div>Loading…
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- ── CAMPAIGNS ── --}}
            <div id="panel-campaigns" class="panel">
                <div class="card">
                    <div class="card-header flex-wrap gap-3">
                        <div>
                            <h3>All Campaigns</h3>
                            <p class="text-xs text-gray-400 mt-0.5">Approve or reject pending submissions</p>
                        </div>
                        <div class="flex flex-wrap items-center gap-2 ml-auto">
                            {{-- Status filter pills --}}
                            <div class="flex gap-2 flex-wrap" id="campStatusFilters">
                                <button class="filter-pill active" data-status="all" onclick="setCampFilter('all',this)">All</button>
                                <button class="filter-pill" data-status="pending"   onclick="setCampFilter('pending',this)">⏳ Pending</button>
                                <button class="filter-pill" data-status="active"    onclick="setCampFilter('active',this)">✅ Active</button>
                                <button class="filter-pill" data-status="cancelled" onclick="setCampFilter('cancelled',this)">❌ Rejected</button>
                                <button class="filter-pill" data-status="completed" onclick="setCampFilter('completed',this)">🏁 Completed</button>
                            </div>
                            <input type="text" id="campSearch" class="search-input" placeholder="Search campaigns…" oninput="renderCampaignsTable()">
                        </div>
                    </div>
                    <div id="campTableWrap" style="overflow-x:auto;">
                        <div class="text-center py-16 text-gray-400">
                            <div class="w-7 h-7 border-2 border-emerald-400 border-t-transparent rounded-full animate-spin mx-auto mb-3"></div>Loading campaigns…
                        </div>
                    </div>
                </div>
            </div>

            {{-- ── USERS ── --}}
            <div id="panel-users" class="panel">
                <div class="card">
                    <div class="card-header flex-wrap gap-3">
                        <div>
                            <h3>All Users</h3>
                            <p class="text-xs text-gray-400 mt-0.5">Manage users — ban or unban accounts</p>
                        </div>
                        <div class="flex items-center gap-2 ml-auto flex-wrap">
                            <div class="flex gap-2" id="userRoleFilters">
                                <button class="filter-pill active" data-role="all"    onclick="setUserFilter('all',this)">All</button>
                                <button class="filter-pill" data-role="donor"         onclick="setUserFilter('donor',this)">Donors</button>
                                <button class="filter-pill" data-role="porter"        onclick="setUserFilter('porter',this)">Porters</button>
                                <button class="filter-pill" data-role="admin"         onclick="setUserFilter('admin',this)">Admins</button>
                                <button class="filter-pill" data-role="banned"        onclick="setUserFilter('banned',this)">🚫 Banned</button>
                            </div>
                            <input type="text" id="userSearch" class="search-input" placeholder="Search users…" oninput="renderUsersTable()">
                        </div>
                    </div>
                    <div id="userTableWrap" style="overflow-x:auto;">
                        <div class="text-center py-16 text-gray-400">
                            <div class="w-7 h-7 border-2 border-emerald-400 border-t-transparent rounded-full animate-spin mx-auto mb-3"></div>Loading users…
                        </div>
                    </div>
                </div>
            </div>

        </div>{{-- /admin-body --}}
    </div>{{-- /admin-main --}}
</div>{{-- /admin-wrap --}}
</div>{{-- /adminContent --}}

{{-- Toast --}}
<div id="toast"></div>

@endsection

@section('scripts')
<script>
// ─── State ────────────────────────────────────
let allUsers     = [];
let allCampaigns = [];
let campFilter   = 'all';
let userFilter   = 'all';

// ─── Boot ─────────────────────────────────────
document.addEventListener('DOMContentLoaded', async () => {
    const loading   = document.getElementById('adminLoading');
    const guest     = document.getElementById('adminGuest');
    const wrongRole = document.getElementById('adminWrongRole');
    const content   = document.getElementById('adminContent');

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

    if (user.role !== 'admin') {
        loading.style.display   = 'none';
        wrongRole.style.display = 'flex';
        return;
    }

    loading.style.display = 'none';
    content.style.display = 'block';

    // Sidebar user card
    document.getElementById('sbName').textContent = (user.first_name || '') + ' ' + (user.last_name || '');
    const sbAv = document.getElementById('sbAvatar');
    if (user.images && user.images.url) {
        sbAv.innerHTML = `<img src="${user.images.url}" style="width:100%;height:100%;object-fit:cover;">`;
    } else {
        sbAv.textContent = (user.first_name || 'A')[0].toUpperCase();
    }

    // Load both datasets for overview
    await Promise.all([loadUsers(false), loadAllCampaigns(false)]);
    renderOverview();
});

// ─── Panel switching ──────────────────────────
function switchPanel(name, btn) {
    document.querySelectorAll('.panel').forEach(p => p.classList.remove('active'));
    document.querySelectorAll('.sb-item').forEach(b => b.classList.remove('active'));
    document.getElementById('panel-' + name).classList.add('active');
    if (btn) btn.classList.add('active');
    const titles = { overview:'Overview', campaigns:'Campaigns', users:'Users' };
    const subs   = { overview:'Platform overview and key metrics', campaigns:'Review, approve or reject campaign submissions', users:'Manage user accounts — ban or unban' };
    document.getElementById('panelTitle').textContent = titles[name] || name;
    document.getElementById('panelSub').textContent   = subs[name]  || '';
}

// ─── Load Users ───────────────────────────────
async function loadUsers(render = true) {
    try {
        const res = await ApiClient.request('/users');
        allUsers = res.data || res || [];

        // Update stats
        document.getElementById('sUsers').textContent  = allUsers.length;
        const banned = allUsers.filter(u => u.is_banned).length;
        document.getElementById('sBanned').textContent = banned;
        document.getElementById('sbBannedCount').textContent = banned;

        if (render) renderUsersTable();
        return allUsers;
    } catch(e) {
        document.getElementById('userTableWrap').innerHTML = '<p class="text-center text-red-400 py-8">Failed to load users.</p>';
    }
}

// ─── Load Campaigns ───────────────────────────
async function loadAllCampaigns(render = true) {
    try {
        const res = await ApiClient.request('/campaigns/all');
        allCampaigns = res.data || res || [];

        const pending  = allCampaigns.filter(c => c.status === 'pending').length;
        const active   = allCampaigns.filter(c => c.status === 'active').length;
        document.getElementById('sPendingCamps').textContent = pending;
        document.getElementById('sActiveCamps').textContent  = active;
        document.getElementById('sTotalCamps').textContent   = allCampaigns.length;
        document.getElementById('sbPendingCount').textContent = pending;

        if (render) renderCampaignsTable();
        return allCampaigns;
    } catch(e) {
        document.getElementById('campTableWrap').innerHTML = '<p class="text-center text-red-400 py-8">Failed to load campaigns.</p>';
    }
}

// ─── Overview rendering ───────────────────────
function renderOverview() {
    // Pending campaigns mini-list
    const pending = allCampaigns.filter(c => c.status === 'pending').slice(0, 6);
    const ovPL = document.getElementById('ovPendingList');
    ovPL.innerHTML = pending.length ? pending.map(c => `
        <div class="flex items-center gap-3 p-3 rounded-xl hover:bg-slate-50 transition-colors">
            ${campThumb(c)}
            <div class="flex-1 min-w-0">
                <p class="font-bold text-sm text-gray-800 truncate">${escHtml(c.title)}</p>
                <p class="text-xs text-gray-400">${c.user ? escHtml(c.user.first_name+' '+c.user.last_name) : '—'}</p>
            </div>
            <div class="flex gap-1 flex-shrink-0">
                <button class="btn-approve" onclick="approveCampaign(${c.id}, this)">✓</button>
                <button class="btn-reject"  onclick="rejectCampaign(${c.id}, this)">✕</button>
            </div>
        </div>`).join('') : '<p class="text-center text-gray-400 py-6 text-sm">No pending campaigns 🎉</p>';

    // Recent users mini-list
    const ovUL = document.getElementById('ovUserList');
    ovUL.innerHTML = allUsers.slice(0, 6).map(u => `
        <div class="flex items-center gap-3 p-3 rounded-xl hover:bg-slate-50 transition-colors">
            ${userAvatar(u)}
            <div class="flex-1 min-w-0">
                <p class="font-bold text-sm text-gray-800 truncate">${escHtml(u.first_name+' '+u.last_name)}</p>
                <p class="text-xs text-gray-400 truncate">${escHtml(u.email)}</p>
            </div>
            <span class="pill p-${u.role}">${u.role}</span>
        </div>`).join('');
}

// ─── Campaign Table ───────────────────────────
function setCampFilter(val, btn) {
    campFilter = val;
    document.querySelectorAll('#campStatusFilters .filter-pill').forEach(b => b.classList.remove('active'));
    btn.classList.add('active');
    renderCampaignsTable();
}

function renderCampaignsTable() {
    const q = (document.getElementById('campSearch')?.value || '').toLowerCase();
    let list = [...allCampaigns];
    if (campFilter !== 'all') list = list.filter(c => c.status === campFilter);
    if (q) list = list.filter(c => (c.title||'').toLowerCase().includes(q) || (c.user ? (c.user.first_name+' '+c.user.last_name).toLowerCase().includes(q) : false));

    const wrap = document.getElementById('campTableWrap');
    if (!list.length) {
        wrap.innerHTML = `<div class="text-center py-16">
            <p class="text-gray-400 font-semibold">No campaigns found</p>
            <p class="text-gray-300 text-sm mt-1">Try a different filter.</p>
        </div>`;
        return;
    }

    wrap.innerHTML = `<table class="data-table">
        <thead><tr>
            <th>Campaign</th>
            <th>Porter</th>
            <th>Category</th>
            <th>Goal</th>
            <th>Status</th>
            <th>Date</th>
            <th>Actions</th>
        </tr></thead>
        <tbody>${list.map(c => {
            const cat  = c.category ? (c.category.name || c.category.category_name || '—') : '—';
            const user = c.user ? escHtml(c.user.first_name + ' ' + c.user.last_name) : '—';
            return `<tr id="camp-row-${c.id}">
                <td>
                    <div style="display:flex;align-items:center;gap:.75rem;">
                        ${campThumb(c)}
                        <span style="font-weight:700;max-width:180px;overflow:hidden;text-overflow:ellipsis;white-space:nowrap;display:block;">${escHtml(c.title)}</span>
                    </div>
                </td>
                <td style="color:#64748b;">${user}</td>
                <td style="color:#64748b;">${escHtml(cat)}</td>
                <td style="font-weight:700;">$${fmtNum(c.target_amount)}</td>
                <td><span class="pill p-${c.status}">${statusEmoji(c.status)} ${c.status}</span></td>
                <td style="color:#94a3b8;white-space:nowrap;">${fmtDate(c.created_at)}</td>
                <td>
                    <div style="display:flex;gap:.4rem;">
                        ${c.status === 'pending' ? `
                            <button class="btn-approve" onclick="approveCampaign(${c.id}, this)">✓ Approve</button>
                            <button class="btn-reject"  onclick="rejectCampaign(${c.id}, this)">✕ Reject</button>
                        ` : `<span style="color:#94a3b8;font-size:.78rem;font-weight:600;">${c.status === 'active' ? 'Live ✅' : 'No action'}</span>`}
                    </div>
                </td>
            </tr>`;
        }).join('')}</tbody>
    </table>`;
}

// ─── User Table ───────────────────────────────
function setUserFilter(val, btn) {
    userFilter = val;
    document.querySelectorAll('#userRoleFilters .filter-pill').forEach(b => b.classList.remove('active'));
    btn.classList.add('active');
    renderUsersTable();
}

function renderUsersTable() {
    const q = (document.getElementById('userSearch')?.value || '').toLowerCase();
    let list = [...allUsers];
    if (userFilter === 'banned') list = list.filter(u => u.is_banned);
    else if (userFilter !== 'all') list = list.filter(u => u.role === userFilter);
    if (q) list = list.filter(u =>
        (u.first_name+' '+u.last_name).toLowerCase().includes(q) ||
        (u.email||'').toLowerCase().includes(q)
    );

    const wrap = document.getElementById('userTableWrap');
    if (!list.length) {
        wrap.innerHTML = `<div class="text-center py-16"><p class="text-gray-400 font-semibold">No users found</p></div>`;
        return;
    }

    wrap.innerHTML = `<table class="data-table">
        <thead><tr>
            <th>User</th>
            <th>Email</th>
            <th>Role</th>
            <th>Status</th>
            <th>Joined</th>
            <th>Actions</th>
        </tr></thead>
        <tbody>${list.map(u => `
            <tr id="user-row-${u.id}">
                <td>
                    <div style="display:flex;align-items:center;gap:.75rem;">
                        ${userAvatar(u)}
                        <span style="font-weight:700;">${escHtml(u.first_name+' '+u.last_name)}</span>
                    </div>
                </td>
                <td style="color:#64748b;">${escHtml(u.email)}</td>
                <td><span class="pill p-${u.role}">${u.role}</span></td>
                <td>
                    <span class="pill ${u.is_banned ? 'p-banned' : 'p-active-user'}">
                        ${u.is_banned ? '🚫 Banned' : '✅ Active'}
                    </span>
                </td>
                <td style="color:#94a3b8;white-space:nowrap;">${fmtDate(u.created_at)}</td>
                <td>
                    ${u.role !== 'admin' ? (u.is_banned
                        ? `<button class="btn-unban" onclick="unbanUser(${u.id}, this)">🔓 Unban</button>`
                        : `<button class="btn-ban"   onclick="banUser(${u.id}, this)">🚫 Ban</button>`
                    ) : `<span style="color:#94a3b8;font-size:.78rem;font-weight:600;">Protected</span>`}
                </td>
            </tr>`).join('')}
        </tbody>
    </table>`;
}

// ─── Actions: Campaigns ───────────────────────
async function approveCampaign(id, btn) {
    setLoading(btn, true);
    try {
        await ApiClient.request(`/campaigns/${id}/approve`, { method: 'POST' });
        const camp = allCampaigns.find(c => c.id === id);
        if (camp) camp.status = 'active';
        toast('Campaign approved — it is now live! ✅', 'success');
        renderCampaignsTable();
        renderOverview();
        updateStatBadges();
    } catch(e) {
        toast('Failed to approve campaign.', 'error');
    } finally { setLoading(btn, false); }
}

async function rejectCampaign(id, btn) {
    setLoading(btn, true);
    try {
        await ApiClient.request(`/campaigns/${id}/reject`, { method: 'POST' });
        const camp = allCampaigns.find(c => c.id === id);
        if (camp) camp.status = 'cancelled';
        toast('Campaign rejected.', 'error');
        renderCampaignsTable();
        renderOverview();
        updateStatBadges();
    } catch(e) {
        toast('Failed to reject campaign.', 'error');
    } finally { setLoading(btn, false); }
}

// ─── Actions: Users ───────────────────────────
async function banUser(id, btn) {
    setLoading(btn, true);
    try {
        await ApiClient.request(`/users/${id}/ban`, { method: 'POST' });
        const u = allUsers.find(u => u.id === id);
        if (u) u.is_banned = true;
        toast('User has been banned.', 'error');
        renderUsersTable();
        updateStatBadges();
    } catch(e) {
        toast('Failed to ban user.', 'error');
    } finally { setLoading(btn, false); }
}

async function unbanUser(id, btn) {
    setLoading(btn, true);
    try {
        await ApiClient.request(`/users/${id}/unban`, { method: 'POST' });
        const u = allUsers.find(u => u.id === id);
        if (u) u.is_banned = false;
        toast('User has been unbanned. ✅', 'success');
        renderUsersTable();
        updateStatBadges();
    } catch(e) {
        toast('Failed to unban user.', 'error');
    } finally { setLoading(btn, false); }
}

// ─── Helpers ─────────────────────────────────
function updateStatBadges() {
    const pending = allCampaigns.filter(c => c.status === 'pending').length;
    const banned  = allUsers.filter(u => u.is_banned).length;
    document.getElementById('sPendingCamps').textContent   = pending;
    document.getElementById('sActiveCamps').textContent    = allCampaigns.filter(c => c.status === 'active').length;
    document.getElementById('sBanned').textContent         = banned;
    document.getElementById('sbPendingCount').textContent  = pending;
    document.getElementById('sbBannedCount').textContent   = banned;
}

function campThumb(c) {
    const img = c.images && c.images[0] ? c.images[0].url : null;
    return img
        ? `<img src="${img}" class="thumb">`
        : `<div class="thumb"><svg xmlns='http://www.w3.org/2000/svg' class='h-5 w-5' fill='none' viewBox='0 0 24 24' stroke='currentColor'><path stroke-linecap='round' stroke-linejoin='round' stroke-width='1.5' d='M4 16l4.586-4.586a2 2 0 012.828 0L16 16M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z'/></svg></div>`;
}

function userAvatar(u) {
    return u.images && u.images.url
        ? `<img src="${u.images.url}" class="thumb">`
        : `<div class="thumb">${(u.first_name||'U')[0].toUpperCase()}</div>`;
}

function setLoading(btn, on) {
    btn.disabled = on;
    btn.style.opacity = on ? '.6' : '1';
}

function statusEmoji(s) { return {pending:'⏳',active:'✅',completed:'🏁',cancelled:'❌'}[s]||'•'; }
function fmtNum(n)  { return Number(n||0).toLocaleString('en-US'); }
function fmtDate(iso) {
    if (!iso) return '—';
    return new Date(iso).toLocaleDateString('en-GB',{day:'numeric',month:'short',year:'2-digit'});
}
function escHtml(s) {
    const d = document.createElement('div');
    d.appendChild(document.createTextNode(s||''));
    return d.innerHTML;
}

let toastTimer;
function toast(msg, type = 'success') {
    const el = document.getElementById('toast');
    el.textContent = msg;
    el.className = type;
    el.style.display = 'block';
    el.style.opacity = '1';
    clearTimeout(toastTimer);
    toastTimer = setTimeout(() => {
        el.style.opacity = '0';
        setTimeout(() => el.style.display = 'none', 300);
    }, 3500);
}
</script>
@endsection
