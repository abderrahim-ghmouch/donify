@extends('layouts.app')

@section('styles')
<style>
    .profile-hero {
        background: linear-gradient(135deg, #0F172A 0%, #064e3b 60%, #0F172A 100%);
    }
    .avatar-ring {
        background: linear-gradient(135deg, #10b981, #6366f1);
        padding: 3px;
        border-radius: 9999px;
    }
    .stat-card {
        background: rgba(255,255,255,0.07);
        backdrop-filter: blur(10px);
        border: 1px solid rgba(255,255,255,0.12);
        border-radius: 1.25rem;
        transition: all 0.3s ease;
    }
    .stat-card:hover {
        background: rgba(255,255,255,0.12);
        transform: translateY(-2px);
    }
    .tab-btn {
        padding: 0.6rem 1.5rem;
        border-radius: 0.75rem;
        font-weight: 600;
        font-size: 0.875rem;
        transition: all 0.25s ease;
        color: #64748b;
        border: 1.5px solid transparent;
        cursor: pointer;
        background: transparent;
    }
    .tab-btn.active {
        background: #10b981;
        color: #fff;
        box-shadow: 0 4px 15px rgba(16,185,129,0.3);
    }
    .tab-btn:not(.active):hover {
        border-color: #10b981;
        color: #10b981;
    }
    .tab-panel { display: none; }
    .tab-panel.active { display: block; }
    .input-field {
        width: 100%;
        padding: 0.85rem 1.25rem;
        border-radius: 0.875rem;
        background: #f8fafc;
        border: 1.5px solid #e2e8f0;
        font-size: 0.925rem;
        transition: all 0.2s ease;
        outline: none;
        color: #0f172a;
    }
    .input-field:focus {
        border-color: #10b981;
        background: #fff;
        box-shadow: 0 0 0 4px rgba(16,185,129,0.1);
    }
    .input-field:disabled {
        background: #f1f5f9;
        color: #94a3b8;
        cursor: not-allowed;
    }
    .badge-role {
        display: inline-flex;
        align-items: center;
        gap: 0.3rem;
        padding: 0.3rem 0.9rem;
        border-radius: 9999px;
        font-size: 0.78rem;
        font-weight: 700;
        letter-spacing: 0.03em;
        text-transform: uppercase;
    }
    .badge-donor   { background: #d1fae5; color: #065f46; }
    .badge-porter  { background: #ede9fe; color: #5b21b6; }
    .badge-admin   { background: #fee2e2; color: #991b1b; }
    .donation-row {
        display: flex;
        align-items: center;
        gap: 1rem;
        padding: 1rem 1.25rem;
        border-radius: 1rem;
        background: #f8fafc;
        border: 1px solid #e2e8f0;
        transition: all 0.2s ease;
    }
    .donation-row:hover { background: #ecfdf5; border-color: #a7f3d0; }
    .fav-card {
        border-radius: 1.25rem;
        overflow: hidden;
        border: 1px solid #e2e8f0;
        background: #fff;
        transition: all 0.3s ease;
    }
    .fav-card:hover { transform: translateY(-4px); box-shadow: 0 20px 40px rgba(0,0,0,0.1); }
    .animate-fade-up {
        animation: fadeUp 0.5s ease both;
    }
    @keyframes fadeUp {
        from { opacity: 0; transform: translateY(20px); }
        to   { opacity: 1; transform: translateY(0); }
    }
    .save-btn {
        background: linear-gradient(135deg, #10b981 0%, #059669 100%);
        color: #fff;
        padding: 0.75rem 2rem;
        border-radius: 0.875rem;
        font-weight: 700;
        font-size: 0.925rem;
        border: none;
        cursor: pointer;
        transition: all 0.25s ease;
        box-shadow: 0 4px 15px rgba(16,185,129,0.3);
    }
    .save-btn:hover { transform: translateY(-2px); box-shadow: 0 8px 20px rgba(16,185,129,0.4); }
    .save-btn:disabled { opacity: 0.7; transform: none; cursor: not-allowed; }
    #profilePage { display: none; }
    #profileLoading { display: flex; }
    #profileGuest { display: none; }
</style>
@endsection

@section('content')

{{-- Loading state --}}
<div id="profileLoading" class="min-h-screen items-center justify-center">
    <div class="text-center">
        <div class="w-16 h-16 border-4 border-emerald-500 border-t-transparent rounded-full animate-spin mx-auto mb-4"></div>
        <p class="text-gray-500 font-medium">Loading your profile...</p>
    </div>
</div>

{{-- Not authenticated --}}
<div id="profileGuest" class="min-h-screen flex items-center justify-center px-6">
    <div class="text-center max-w-md">
        <div class="w-24 h-24 bg-emerald-100 rounded-full flex items-center justify-center mx-auto mb-6">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12 text-emerald-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
            </svg>
        </div>
        <h2 class="text-2xl font-bold font-outfit mb-3">Sign in to view your profile</h2>
        <p class="text-gray-500 mb-8">Access your donations, favourites, and account settings all in one place.</p>
        <div class="flex gap-4 justify-center">
            <a href="{{ route('login') }}" class="btn-primary px-8 py-3 rounded-xl font-bold">Sign In</a>
            <a href="{{ route('register') }}" class="px-8 py-3 rounded-xl font-bold border border-emerald-500 text-emerald-600 hover:bg-emerald-50 transition-all">Register</a>
        </div>
    </div>
</div>

{{-- Main Profile Page --}}
<div id="profilePage" class="animate-fade-up">

    {{-- Hero Banner --}}
    <div class="profile-hero pt-10 pb-32 px-6 relative overflow-hidden">
        {{-- Decorative blobs --}}
        <div class="absolute top-0 right-0 w-96 h-96 bg-emerald-500/10 blur-[120px] rounded-full pointer-events-none"></div>
        <div class="absolute bottom-0 left-1/4 w-64 h-64 bg-indigo-500/10 blur-[100px] rounded-full pointer-events-none"></div>

        <div class="max-w-5xl mx-auto relative z-10">
            <div class="flex flex-col md:flex-row items-center md:items-end gap-8">
                {{-- Avatar --}}
                <div class="relative flex-shrink-0">
                    <div class="avatar-ring">
                        <div id="heroAvatarWrap" class="w-32 h-32 rounded-full overflow-hidden bg-slate-700 flex items-center justify-center">
                            <svg id="heroAvatarFallback" xmlns="http://www.w3.org/2000/svg" class="h-14 w-14 text-slate-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                            </svg>
                            <img id="heroAvatarImg" src="" alt="Avatar" class="w-full h-full object-cover hidden">
                        </div>
                    </div>
                    <label for="avatarUploadInput" class="absolute bottom-1 right-1 w-9 h-9 bg-emerald-500 hover:bg-emerald-600 transition-colors rounded-full flex items-center justify-center cursor-pointer shadow-lg" title="Change photo">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z"/>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 13a3 3 0 11-6 0 3 3 0 016 0z"/>
                        </svg>
                    </label>
                    <input type="file" id="avatarUploadInput" accept="image/*" class="hidden">
                </div>

                {{-- Name & role --}}
                <div class="text-white text-center md:text-left">
                    <div class="flex items-center gap-3 justify-center md:justify-start mb-2">
                        <h1 id="heroName" class="text-3xl md:text-4xl font-extrabold font-outfit">Loading...</h1>
                        <span id="heroBadge" class="badge-role badge-donor">Donor</span>
                    </div>
                    <p id="heroEmail" class="text-slate-400 text-sm mb-4">—</p>
                    <p class="text-slate-300 text-sm">Member since <span id="heroJoined">—</span></p>
                </div>

                {{-- Stats --}}
                <div class="md:ml-auto grid grid-cols-3 gap-4">
                    <div class="stat-card p-5 text-center">
                        <p id="statDonations" class="text-3xl font-bold text-emerald-400 font-outfit">—</p>
                        <p class="text-slate-400 text-xs mt-1 uppercase tracking-wide">Donations</p>
                    </div>
                    <div class="stat-card p-5 text-center">
                        <p id="statAmount" class="text-3xl font-bold text-emerald-400 font-outfit">—</p>
                        <p class="text-slate-400 text-xs mt-1 uppercase tracking-wide">Given</p>
                    </div>
                    <div class="stat-card p-5 text-center">
                        <p id="statFavs" class="text-3xl font-bold text-emerald-400 font-outfit">—</p>
                        <p class="text-slate-400 text-xs mt-1 uppercase tracking-wide">Favourites</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Content area (pulled up to overlap hero) --}}
    <div class="max-w-5xl mx-auto px-6 -mt-20 pb-20 relative z-10">

        {{-- Tabs --}}
        <div class="bg-white rounded-2xl shadow-xl p-2 flex gap-2 mb-8 overflow-x-auto border border-gray-100">
            <button class="tab-btn active" data-tab="settings" onclick="switchTab('settings', this)">⚙️ Account Settings</button>
            <button class="tab-btn" data-tab="donations" onclick="switchTab('donations', this)">💚 My Donations</button>
            <button class="tab-btn" data-tab="favourites" onclick="switchTab('favourites', this)">❤️ Favourites</button>
        </div>

        {{-- ── TAB: Settings ── --}}
        <div id="tab-settings" class="tab-panel active">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">

                {{-- Profile Form --}}
                <div class="md:col-span-2 bg-white rounded-2xl shadow-sm border border-gray-100 p-8">
                    <h2 class="text-xl font-bold font-outfit mb-6">Personal Information</h2>
                    <div id="settingsSuccess" class="hidden mb-4 p-4 bg-emerald-50 text-emerald-700 rounded-xl text-sm border border-emerald-100 font-semibold">✅ Profile updated successfully!</div>
                    <div id="settingsError"   class="hidden mb-4 p-4 bg-red-50 text-red-600 rounded-xl text-sm border border-red-100"></div>

                    <form id="profileForm" class="grid grid-cols-1 md:grid-cols-2 gap-5">
                        <div>
                            <label class="block text-sm font-semibold text-gray-600 mb-2">First Name</label>
                            <input type="text" id="editFirstName" class="input-field" placeholder="First Name">
                        </div>
                        <div>
                            <label class="block text-sm font-semibold text-gray-600 mb-2">Last Name</label>
                            <input type="text" id="editLastName" class="input-field" placeholder="Last Name">
                        </div>
                        <div class="md:col-span-2">
                            <label class="block text-sm font-semibold text-gray-600 mb-2">Email Address</label>
                            <input type="email" id="editEmail" class="input-field" placeholder="Email">
                        </div>
                        <div class="md:col-span-2">
                            <label class="block text-sm font-semibold text-gray-600 mb-2">Role</label>
                            <input type="text" id="editRole" class="input-field" disabled>
                        </div>
                        <div class="md:col-span-2 flex justify-end pt-2">
                            <button type="submit" id="saveProfileBtn" class="save-btn">Save Changes</button>
                        </div>
                    </form>
                </div>

                {{-- Avatar card --}}
                <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-8 flex flex-col items-center text-center">
                    <h2 class="text-xl font-bold font-outfit mb-6 self-start">Profile Photo</h2>
                    <div class="avatar-ring mb-4">
                        <div id="settingsAvatarWrap" class="w-28 h-28 rounded-full overflow-hidden bg-slate-100 flex items-center justify-center">
                            <svg id="settingsAvatarFallback" xmlns="http://www.w3.org/2000/svg" class="h-12 w-12 text-slate-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                            </svg>
                            <img id="settingsAvatarImg" src="" alt="Avatar" class="w-full h-full object-cover hidden">
                        </div>
                    </div>
                    <p class="text-gray-400 text-xs mb-6">JPG, PNG · Max 2MB</p>
                    <label for="avatarUploadInput" class="save-btn w-full text-center cursor-pointer block">Change Photo</label>
                    <div id="avatarUploadMsg" class="hidden mt-3 text-xs text-emerald-600 font-semibold"></div>
                </div>

            </div>
        </div>

        {{-- ── TAB: Donations ── --}}
        <div id="tab-donations" class="tab-panel">
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-8">
                <div class="flex items-center justify-between mb-6">
                    <h2 class="text-xl font-bold font-outfit">My Donation History</h2>
                    <span id="donationCountBadge" class="px-3 py-1 bg-emerald-50 text-emerald-700 rounded-full text-sm font-bold">0 donations</span>
                </div>
                <div id="donationsLoading" class="text-center py-12 text-gray-400">
                    <div class="w-8 h-8 border-2 border-emerald-400 border-t-transparent rounded-full animate-spin mx-auto mb-3"></div>
                    Loading donations...
                </div>
                <div id="donationsList" class="space-y-3 hidden"></div>
                <div id="donationsEmpty" class="hidden text-center py-16">
                    <div class="w-20 h-20 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-4">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-10 w-10 text-gray-300" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"/>
                        </svg>
                    </div>
                    <p class="text-gray-400 font-medium">No donations yet.</p>
                    <a href="{{ route('campaigns.index') }}" class="inline-block mt-4 btn-primary px-6 py-2.5 rounded-xl font-bold text-sm">Browse Campaigns</a>
                </div>
            </div>
        </div>

        {{-- ── TAB: Favourites ── --}}
        <div id="tab-favourites" class="tab-panel">
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-8">
                <div class="flex items-center justify-between mb-6">
                    <h2 class="text-xl font-bold font-outfit">Saved Campaigns</h2>
                    <span id="favsCountBadge" class="px-3 py-1 bg-rose-50 text-rose-600 rounded-full text-sm font-bold">0 saved</span>
                </div>
                <div id="favsLoading" class="text-center py-12 text-gray-400">
                    <div class="w-8 h-8 border-2 border-emerald-400 border-t-transparent rounded-full animate-spin mx-auto mb-3"></div>
                    Loading favourites...
                </div>
                <div id="favGrid" class="grid grid-cols-1 md:grid-cols-2 gap-5 hidden"></div>
                <div id="favsEmpty" class="hidden text-center py-16">
                    <div class="w-20 h-20 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-4">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-10 w-10 text-gray-300" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M5 5a2 2 0 012-2h10a2 2 0 012 2v16l-7-5-7 5V5z"/>
                        </svg>
                    </div>
                    <p class="text-gray-400 font-medium">No favourites saved yet.</p>
                    <a href="{{ route('campaigns.index') }}" class="inline-block mt-4 btn-primary px-6 py-2.5 rounded-xl font-bold text-sm">Explore Campaigns</a>
                </div>
            </div>
        </div>

    </div><!-- /content area -->
</div><!-- /profilePage -->

@endsection

@section('scripts')
<script>
// ─── Helpers ──────────────────────────────────
function fmtDate(iso) {
    if (!iso) return '—';
    return new Date(iso).toLocaleDateString('en-GB', { year: 'numeric', month: 'long', day: 'numeric' });
}
function fmtMoney(n) {
    return '$' + Number(n || 0).toLocaleString('en-US', { minimumFractionDigits: 0 });
}

function switchTab(name, btn) {
    document.querySelectorAll('.tab-panel').forEach(p => p.classList.remove('active'));
    document.querySelectorAll('.tab-btn').forEach(b => b.classList.remove('active'));
    document.getElementById('tab-' + name).classList.add('active');
    btn.classList.add('active');
    if (name === 'donations') loadDonations();
    if (name === 'favourites') loadFavourites();
}

function setBadge(role) {
    const el = document.getElementById('heroBadge');
    el.className = 'badge-role';
    if (role === 'admin')  { el.classList.add('badge-admin');  el.textContent = '⚡ Admin'; }
    else if (role === 'porter') { el.classList.add('badge-porter'); el.textContent = '🚀 Porter'; }
    else { el.classList.add('badge-donor'); el.textContent = '💚 Donor'; }
}

function setAvatar(url) {
    ['hero','settings'].forEach(prefix => {
        const img = document.getElementById(prefix + 'AvatarImg');
        const fallback = document.getElementById(prefix + 'AvatarFallback');
        if (url) {
            img.src = url;
            img.classList.remove('hidden');
            fallback.classList.add('hidden');
        } else {
            img.classList.add('hidden');
            fallback.classList.remove('hidden');
        }
    });
}

// ─── Init ─────────────────────────────────────
document.addEventListener('DOMContentLoaded', async () => {
    const loading = document.getElementById('profileLoading');
    const guest   = document.getElementById('profileGuest');
    const page    = document.getElementById('profilePage');

    if (!ApiClient.isAuthenticated()) {
        loading.style.display = 'none';
        guest.style.display   = 'flex';
        return;
    }

    // Fetch fresh /me data
    let user;
    try {
        const data = await ApiClient.request('/auth/me');
        user = data;
        // update cached user
        ApiClient.setUser(user);
    } catch(e) {
        loading.style.display = 'none';
        guest.style.display   = 'flex';
        return;
    }

    loading.style.display = 'none';
    page.style.display    = 'block';

    // Fill hero
    document.getElementById('heroName').textContent  = (user.first_name || '') + ' ' + (user.last_name || '');
    document.getElementById('heroEmail').textContent = user.email || '—';
    document.getElementById('heroJoined').textContent = fmtDate(user.created_at);
    setBadge(user.role);

    // Fill form
    document.getElementById('editFirstName').value = user.first_name || '';
    document.getElementById('editLastName').value  = user.last_name  || '';
    document.getElementById('editEmail').value     = user.email      || '';
    document.getElementById('editRole').value      = (user.role || 'donor').charAt(0).toUpperCase() + (user.role || 'donor').slice(1);

    // Avatars
    const avatarUrl = user.images && user.images.url ? user.images.url : null;
    setAvatar(avatarUrl);

    // Load stats from /my-donations
    loadStats();
    loadFavsCount();
});

// ─── Stats ────────────────────────────────────
async function loadStats() {
    try {
        const data = await ApiClient.request('/my-donations');
        const list = data.data || data || [];
        document.getElementById('statDonations').textContent = list.length;
        const total = list.reduce((s, d) => s + parseFloat(d.amount || 0), 0);
        document.getElementById('statAmount').textContent = fmtMoney(total);
    } catch(e) {
        document.getElementById('statDonations').textContent = '—';
        document.getElementById('statAmount').textContent    = '—';
    }
}

async function loadFavsCount() {
    try {
        const data = await ApiClient.request('/favourites');
        const list = data.data || data || [];
        document.getElementById('statFavs').textContent = list.length;
    } catch(e) {
        document.getElementById('statFavs').textContent = '—';
    }
}

// ─── Donations Tab ────────────────────────────
let donationsLoaded = false;
async function loadDonations() {
    if (donationsLoaded) return;
    donationsLoaded = true;
    const loadingEl = document.getElementById('donationsLoading');
    const listEl    = document.getElementById('donationsList');
    const emptyEl   = document.getElementById('donationsEmpty');
    const badge     = document.getElementById('donationCountBadge');

    try {
        const data = await ApiClient.request('/my-donations');
        const list = data.data || data || [];
        loadingEl.classList.add('hidden');
        badge.textContent = list.length + ' donation' + (list.length !== 1 ? 's' : '');

        if (list.length === 0) { emptyEl.classList.remove('hidden'); return; }

        listEl.innerHTML = list.map(d => `
            <div class="donation-row">
                <div class="w-10 h-10 rounded-xl bg-emerald-100 flex items-center justify-center flex-shrink-0">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-emerald-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"/>
                    </svg>
                </div>
                <div class="flex-1 min-w-0">
                    <p class="font-semibold text-gray-800 text-sm truncate">${d.campaign ? d.campaign.title : 'Campaign #' + (d.campaign_id || '?')}</p>
                    <p class="text-xs text-gray-400 mt-0.5">${fmtDate(d.created_at)}</p>
                </div>
                <div class="text-right flex-shrink-0">
                    <span class="text-emerald-600 font-bold text-base">${fmtMoney(d.amount)}</span>
                </div>
            </div>
        `).join('');
        listEl.classList.remove('hidden');
    } catch(e) {
        loadingEl.classList.add('hidden');
        emptyEl.classList.remove('hidden');
    }
}

// ─── Favourites Tab ───────────────────────────
let favsLoaded = false;
async function loadFavourites() {
    if (favsLoaded) return;
    favsLoaded = true;
    const loadingEl = document.getElementById('favsLoading');
    const gridEl    = document.getElementById('favGrid');
    const emptyEl   = document.getElementById('favsEmpty');
    const badge     = document.getElementById('favsCountBadge');

    try {
        const data = await ApiClient.request('/favourites');
        const list = data.data || data || [];
        loadingEl.classList.add('hidden');
        badge.textContent = list.length + ' saved';
        document.getElementById('statFavs').textContent = list.length;

        if (list.length === 0) { emptyEl.classList.remove('hidden'); return; }

        gridEl.innerHTML = list.map(fav => {
            const c = fav.campaign || fav;
            const pct = Math.min(100, ((c.current_amount || 0) / Math.max(1, c.target_amount || 1)) * 100).toFixed(0);
            const img = c.images && c.images[0] ? c.images[0].url : '';
            return `
            <div class="fav-card group">
                <div class="h-40 overflow-hidden bg-gray-100 relative">
                    ${img ? `<img src="${img}" alt="${c.title}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">` : `<div class="w-full h-full flex items-center justify-center text-gray-300"><svg xmlns='http://www.w3.org/2000/svg' class='h-12 w-12' fill='none' viewBox='0 0 24 24' stroke='currentColor'><path stroke-linecap='round' stroke-linejoin='round' stroke-width='1.5' d='M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z'/></svg></div>`}
                    <div class="absolute inset-0 bg-gradient-to-t from-black/40 to-transparent opacity-0 group-hover:opacity-100 transition-opacity"></div>
                </div>
                <div class="p-5">
                    <h3 class="font-bold text-gray-800 mb-1 truncate">${c.title || 'Campaign'}</h3>
                    <div class="flex justify-between text-xs text-gray-400 mb-2">
                        <span>${fmtMoney(c.current_amount)}</span>
                        <span>${pct}%</span>
                    </div>
                    <div class="w-full h-1.5 bg-gray-100 rounded-full overflow-hidden mb-4">
                        <div class="h-full bg-emerald-500 rounded-full" style="width:${pct}%"></div>
                    </div>
                </div>
            </div>`;
        }).join('');
        gridEl.classList.remove('hidden');
    } catch(e) {
        loadingEl.classList.add('hidden');
        emptyEl.classList.remove('hidden');
    }
}

// ─── Profile Update ───────────────────────────
document.getElementById('profileForm').addEventListener('submit', async (e) => {
    e.preventDefault();
    const btn     = document.getElementById('saveProfileBtn');
    const success = document.getElementById('settingsSuccess');
    const error   = document.getElementById('settingsError');
    success.classList.add('hidden');
    error.classList.add('hidden');

    btn.disabled = true;
    btn.textContent = 'Saving...';
    try {
        const updated = await ApiClient.request('/auth/profile', {
            method: 'PUT',
            body: JSON.stringify({
                first_name: document.getElementById('editFirstName').value,
                last_name:  document.getElementById('editLastName').value,
                email:      document.getElementById('editEmail').value,
            })
        });
        const u = updated.user || updated;
        ApiClient.setUser(u);
        document.getElementById('heroName').textContent = (u.first_name || '') + ' ' + (u.last_name || '');
        document.querySelector('.user-name').textContent = u.first_name || 'User';
        success.classList.remove('hidden');
    } catch(err) {
        const msg = err.message || (err.errors ? Object.values(err.errors)[0][0] : 'Update failed.');
        error.textContent = msg;
        error.classList.remove('hidden');
    } finally {
        btn.disabled = false;
        btn.textContent = 'Save Changes';
    }
});

// ─── Avatar Upload ────────────────────────────
document.getElementById('avatarUploadInput').addEventListener('change', async (e) => {
    const file = e.target.files[0];
    if (!file) return;
    const msg = document.getElementById('avatarUploadMsg');
    msg.textContent = 'Uploading...';
    msg.classList.remove('hidden');

    // Preview immediately
    const reader = new FileReader();
    reader.onload = ev => setAvatar(ev.target.result);
    reader.readAsDataURL(file);

    const fd = new FormData();
    fd.append('image', file);
    try {
        const res = await ApiClient.request('/auth/avatar', {
            method: 'POST',
            body: fd,
            headers: { 'Content-Type': null }
        });
        const user = ApiClient.getUser();
        if (user) { user.images = { url: res.url }; ApiClient.setUser(user); }
        setAvatar(res.url);
        const navAvatar = document.getElementById('userAvatar');
        if (navAvatar) navAvatar.innerHTML = `<img src="${res.url}" class="w-full h-full object-cover">`;
        msg.textContent = '✅ Photo updated!';
        setTimeout(() => msg.classList.add('hidden'), 3000);
    } catch(err) {
        msg.textContent = '❌ Upload failed. Try again.';
        msg.classList.remove('hidden');
    }
});
</script>
@endsection
