@extends('layouts.app', ['hide_nav' => true, 'hide_footer' => true])

@section('styles')
<style>
    .font-quicksand { font-family: 'Quicksand', sans-serif; }
    
    .profile-hero {
        background: linear-gradient(135deg, #1A1A1A 0%, #064e3b 100%);
    }

    .glass-card {
        background: rgba(255, 255, 255, 0.03);
        backdrop-filter: blur(20px);
        border: 1px solid rgba(255, 255, 255, 0.1);
        border-radius: 2rem;
    }

    .accent-gold { color: #DAA520; }
    .bg-cream { background-color: #fbf8f6; }

    .tab-btn {
        position: relative;
        padding: 1rem 2rem;
        font-weight: 700;
        letter-spacing: 0.1em;
        text-transform: uppercase;
        font-size: 0.75rem;
        color: #94a3b8;
        transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
    }
    
    .tab-btn::after {
        content: '';
        position: absolute;
        bottom: 0;
        left: 50%;
        width: 0;
        height: 2px;
        background: #064e3b;
        transition: all 0.4s ease;
        transform: translateX(-50%);
    }

    .tab-btn.active {
        color: #1A1A1A;
    }

    .tab-btn.active::after {
        width: 40%;
    }

    .stat-pill {
        background: rgba(255, 255, 255, 0.05);
        border: 1px solid rgba(255, 255, 255, 0.1);
        border-radius: 1.25rem;
        padding: 1.25rem;
        transition: all 0.3s ease;
    }

    .stat-pill:hover {
        background: rgba(255, 255, 255, 0.08);
        border-color: rgba(255, 255, 255, 0.2);
    }

    .input-field {
        width: 100%;
        padding: 1.25rem 1.5rem;
        border-radius: 1.25rem;
        background: white;
        border: 1px solid #eef2f3;
        font-size: 0.875rem;
        font-weight: 500;
        transition: all 0.3s ease;
        outline: none;
    }

    .input-field:focus {
        border-color: #064e3b;
        box-shadow: 0 0 0 4px rgba(6, 78, 59, 0.05);
    }

    .save-btn {
        background: #1A1A1A;
        color: white;
        padding: 1.25rem 3rem;
        border-radius: 1.25rem;
        font-weight: 800;
        text-transform: uppercase;
        letter-spacing: 0.2em;
        font-size: 0.75rem;
        transition: all 0.3s ease;
        border: none;
        cursor: pointer;
    }

    .save-btn:hover {
        background: #064e3b;
        transform: translateY(-2px);
        box-shadow: 0 10px 25px rgba(0,0,0,0.1);
    }

    .donation-item {
        background: white;
        border: 1px solid #eef2f3;
        border-radius: 1.5rem;
        padding: 1.5rem;
        transition: all 0.3s ease;
    }

    .donation-item:hover {
        border-color: #064e3b;
        transform: translateX(5px);
    }

    .tab-panel { display: none; }
    .tab-panel.active { display: block; }
    
    #profilePage { display: none; }
</style>
@endsection

@section('content')
{{-- Loading State --}}
<div id="profileLoading" class="min-h-screen flex items-center justify-center bg-cream font-quicksand">
    <div class="text-center">
        <div class="w-12 h-12 border-2 border-[#064e3b] border-t-transparent rounded-full animate-spin mx-auto mb-6"></div>
        <p class="text-sm font-bold uppercase tracking-widest text-gray-400">Retrieving Account...</p>
    </div>
</div>

{{-- Main Profile Experience --}}
<div id="profilePage" class="min-h-screen bg-cream font-quicksand">
    
    {{-- Hero Section --}}
    <section class="profile-hero relative pt-20 pb-48 px-8 overflow-hidden">
        {{-- Background Accents --}}
        <div class="absolute inset-0 z-0 pointer-events-none overflow-hidden">
            <div class="absolute top-10 right-10 text-[10rem] font-black text-white/5 uppercase select-none">Profile</div>
            <div class="absolute bottom-[-5%] left-10 text-[8rem] font-black text-[#DAA520]/10 uppercase select-none">Impact</div>
        </div>

        <div class="max-w-6xl mx-auto relative z-10">
            {{-- Integrated Logo --}}
            <div class="flex items-center justify-between mb-16">
                <a href="{{ route('home') }}" class="flex items-center gap-3 group">
                    <img src="{{ asset('images/donifylg.png') }}" class="h-10 w-auto brightness-0 invert opacity-100 transition-transform group-hover:scale-105">
                </a>
                <a href="{{ route('home') }}" class="text-white/40 hover:text-white transition-all text-[10px] font-black uppercase tracking-[0.3em]">Return Home</a>
            </div>

            <div class="flex flex-col lg:flex-row items-center lg:items-end gap-12">
                
                {{-- Avatar Stack --}}
                <div class="relative group">
                    <div class="w-44 h-44 rounded-[2.5rem] overflow-hidden border-4 border-white/20 p-1 bg-white/5 backdrop-blur-md transition-all group-hover:border-[#DAA520]/50">
                        <div id="heroAvatarWrap" class="w-full h-full rounded-[2.2rem] overflow-hidden bg-[#1A1A1A]">
                            <img id="heroAvatarImg" src="" alt="Avatar" class="w-full h-full object-cover hidden">
                            <div id="heroAvatarFallback" class="w-full h-full flex items-center justify-center text-white/20">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-20 w-20" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                                </svg>
                            </div>
                        </div>
                    </div>
                    <label for="avatarUploadInput" class="absolute -bottom-2 -right-2 w-12 h-12 bg-[#DAA520] hover:bg-white text-white hover:text-[#1A1A1A] transition-all rounded-2xl flex items-center justify-center cursor-pointer shadow-2xl">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z"/>
                        </svg>
                    </label>
                    <input type="file" id="avatarUploadInput" accept="image/*" class="hidden">
                </div>

                {{-- User Info --}}
                <div class="flex-1 text-center lg:text-left">
                    <div class="flex flex-col sm:flex-row items-center lg:items-end gap-4 mb-4">
                        <h1 id="heroName" class="text-4xl md:text-6xl font-black text-white leading-none">Loading...</h1>
                        <span id="heroBadge" class="px-5 py-2 rounded-xl bg-[#DAA520] text-[#1A1A1A] text-[10px] font-black uppercase tracking-[0.2em]">Donor</span>
                    </div>
                    <p id="heroEmail" class="text-white/60 text-lg font-medium mb-6">—</p>
                    <div class="flex items-center justify-center lg:justify-start gap-4">
                        <div class="text-[10px] uppercase font-black tracking-widest text-[#DAA520] border border-[#DAA520]/30 px-3 py-1 rounded-lg">Member Since <span id="heroJoined" class="text-white ml-2">—</span></div>
                    </div>
                </div>

                {{-- Stats Grid --}}
                <div class="grid grid-cols-3 gap-3 w-full lg:w-auto">
                    <div class="stat-pill">
                        <div id="statAmount" class="text-2xl font-black text-white mb-1">$0</div>
                        <div class="text-[9px] uppercase font-black tracking-widest text-white/40">Total Given</div>
                    </div>
                    <div class="stat-pill">
                        <div id="statDonations" class="text-2xl font-black text-white mb-1">0</div>
                        <div class="text-[9px] uppercase font-black tracking-widest text-white/40">Impacts</div>
                    </div>
                    <div class="stat-pill">
                        <div id="statFavs" class="text-2xl font-black text-white mb-1">0</div>
                        <div class="text-[9px] uppercase font-black tracking-widest text-white/40">Saved</div>
                    </div>
                </div>

            </div>
        </div>
    </section>

    {{-- Control Center --}}
    <div class="max-w-6xl mx-auto px-8 -mt-24 pb-32 relative z-10">
        
        {{-- Navigation Tabs --}}
        <div class="bg-white rounded-[2.5rem] shadow-[0_20px_50px_rgba(0,0,0,0.05)] p-2 flex justify-between sm:justify-start gap-2 mb-12 border border-black/5">
            <button class="tab-btn active" data-tab="settings" onclick="switchTab('settings', this)">Settings</button>
            <button class="tab-btn" data-tab="donations" onclick="switchTab('donations', this)">Donations</button>
            <button class="tab-btn" data-tab="favourites" onclick="switchTab('favourites', this)">Favourites</button>
        </div>

        {{-- Panels --}}
        <div class="animate-fade-up">
            
            {{-- Setting Panel --}}
            <div id="tab-settings" class="tab-panel active">
                <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                    
                    {{-- General settings --}}
                    <div class="lg:col-span-2 bg-white rounded-[3rem] p-10 md:p-16 shadow-[0_30px_60px_rgba(0,0,0,0.02)] border border-black/5">
                        <div class="flex items-center justify-between mb-12">
                            <div>
                                <h2 class="text-2xl font-black text-[#1A1A1A] mb-2 tracking-tight">Identity Details</h2>
                                <p class="text-sm text-gray-400 font-medium">Manage your personal presence on Donify.</p>
                            </div>
                            <div id="settingsSuccess" class="hidden px-6 py-2 bg-emerald-50 text-emerald-600 rounded-xl text-[10px] font-black uppercase tracking-widest border border-emerald-100 italic">Saved!</div>
                        </div>

                        <form id="profileForm" class="space-y-8">
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                                <div>
                                    <label class="block text-[10px] font-black uppercase tracking-[0.2em] text-gray-400 mb-3 ml-2">First Identity</label>
                                    <input type="text" id="editFirstName" class="input-field" placeholder="First Name">
                                </div>
                                <div>
                                    <label class="block text-[10px] font-black uppercase tracking-[0.2em] text-gray-400 mb-3 ml-2">Last Identity</label>
                                    <input type="text" id="editLastName" class="input-field" placeholder="Last Name">
                                </div>
                            </div>
                            <div>
                                <label class="block text-[10px] font-black uppercase tracking-[0.2em] text-gray-400 mb-3 ml-2">Communication Channel</label>
                                <input type="email" id="editEmail" class="input-field" placeholder="Email Address">
                            </div>
                            <div>
                                <label class="block text-[10px] font-black uppercase tracking-[0.2em] text-gray-400 mb-3 ml-2">Assigned Role</label>
                                <input type="text" id="editRole" class="input-field bg-cream cursor-not-allowed opacity-60" disabled>
                            </div>
                            
                            <div class="pt-8 border-t border-black/5 flex justify-end">
                                <button type="submit" id="saveProfileBtn" class="save-btn">Verify Changes</button>
                            </div>
                        </form>
                    </div>

                    {{-- Security info --}}
                    <div class="flex flex-col gap-8">
                        <div class="bg-[#1A1A1A] rounded-[3rem] p-12 text-center text-white relative overflow-hidden group">
                           <div class="absolute inset-0 bg-[#064e3b] translate-y-full group-hover:translate-y-0 transition-transform duration-700"></div>
                           <div class="relative z-10">
                               <div class="w-16 h-16 bg-white/5 backdrop-blur-md rounded-[2rem] mx-auto mb-8 flex items-center justify-center border border-white/10 shadow-2xl">
                                   <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-[#DAA520]" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                       <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
                                   </svg>
                               </div>
                               <h4 class="text-xl font-black mb-4 tracking-tight">Security Vault</h4>
                               <p class="text-white/50 text-[11px] uppercase tracking-[0.2em] font-black mb-8 leading-relaxed italic">Encrypted Session</p>
                               <button class="w-full py-4 border-2 border-[#DAA520]/20 rounded-2xl text-[10px] font-black uppercase tracking-[0.2em] text-[#DAA520] hover:bg-[#DAA520] hover:text-[#1A1A1A] transition-all">Update Credentials</button>
                           </div>
                        </div>

                        <div class="bg-white rounded-[3rem] p-10 border border-black/5 flex items-center justify-between group cursor-pointer hover:bg-red-50 transition-all hover:border-red-100" onclick="handleLogout()">
                            <div>
                                <h5 class="font-black text-gray-800 tracking-tight group-hover:text-red-600 transition-colors">Terminate Identity</h5>
                                <p class="text-[10px] text-gray-400 font-black uppercase tracking-[0.2em]">End current session</p>
                            </div>
                            <div class="w-12 h-12 rounded-2xl bg-red-50 flex items-center justify-center text-red-500 transition-transform group-hover:rotate-12">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7" />
                                </svg>
                            </div>
                        </div>
                    </div>

                </div>
            </div>

            {{-- Donation Panel --}}
            <div id="tab-donations" class="tab-panel">
                <div class="bg-white rounded-[3rem] p-12 md:p-20 shadow-[0_30px_60px_rgba(0,0,0,0.02)] border border-black/5">
                    <div class="flex items-center justify-between mb-16">
                        <h2 class="text-3xl font-black text-[#1A1A1A] tracking-tight italic">Impact Log.</h2>
                        <div id="donationsCount" class="text-[10px] font-black text-[#DAA520] uppercase tracking-widest border-2 border-[#DAA520]/20 px-4 py-2 rounded-xl">0 Records</div>
                    </div>

                    <div id="donationsLoading" class="text-center py-20">
                        <div class="w-10 h-10 border-2 border-[#064e3b] border-t-transparent rounded-full animate-spin mx-auto mb-4"></div>
                        <p class="text-xs font-bold uppercase tracking-widest text-gray-300">Synchronizing...</p>
                    </div>

                    <div id="donationsList" class="space-y-6 hidden"></div>

                    <div id="donationsEmpty" class="hidden text-center py-20">
                        <h4 class="text-2xl font-black text-gray-300 italic mb-8">No impacts recorded yet.</h4>
                        <a href="{{ route('campaigns.index') }}" class="save-btn inline-block">Begin Your Legacy</a>
                    </div>
                </div>
            </div>

            {{-- Favourites Panel --}}
            <div id="tab-favourites" class="tab-panel">
                <div class="bg-white rounded-[3rem] p-12 md:p-20 shadow-[0_30px_60px_rgba(0,0,0,0.02)] border border-black/5">
                     <div class="flex items-center justify-between mb-16">
                        <h2 class="text-3xl font-black text-[#1A1A1A] tracking-tight italic">Watchlist.</h2>
                        <div id="favsCount" class="text-[10px] font-black text-[#064e3b] uppercase tracking-widest border-2 border-[#064e3b]/20 px-4 py-2 rounded-xl">0 Tracked</div>
                    </div>

                    <div id="favsLoading" class="text-center py-20">
                        <div class="w-10 h-10 border-2 border-[#064e3b] border-t-transparent rounded-full animate-spin mx-auto mb-4"></div>
                        <p class="text-xs font-bold uppercase tracking-widest text-gray-300">Syncing Watchlist...</p>
                    </div>

                    <div id="favGrid" class="grid grid-cols-1 md:grid-cols-2 gap-8 hidden"></div>

                    <div id="favsEmpty" class="hidden text-center py-20">
                         <h4 class="text-2xl font-black text-gray-300 italic mb-8">Your watchlist is empty.</h4>
                         <a href="{{ route('campaigns.index') }}" class="save-btn inline-block italic">Explore Causes</a>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>

{{-- Authentication Guard for Guest Redirect --}}
<div id="profileGuest" class="min-h-screen flex items-center justify-center bg-cream px-8 font-quicksand">
    <div class="text-center max-w-lg">
        <div class="mb-12">
            <img src="{{ asset('images/donifylg.png') }}" class="h-24 w-auto mx-auto grayscale opacity-20">
        </div>
        <h2 class="text-4xl font-black text-[#1A1A1A] mb-4 italic tracking-tight">Identity Required.</h2>
        <p class="text-gray-400 font-medium mb-12 text-lg italic">"To see your impact, you must first be known."</p>
        <div class="flex flex-col sm:flex-row gap-4 justify-center">
            <a href="{{ route('login') }}" class="save-btn text-center">Establish Session</a>
            <a href="{{ route('register') }}" class="px-12 py-5 rounded-2xl font-black text-[10px] uppercase tracking-widest border-2 border-[#1A1A1A] text-[#1A1A1A] hover:bg-[#1A1A1A] hover:text-white transition-all text-center">Begin Journey</a>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
// ─── Formatting Stats ─────────────────────────
function fmtDate(iso) {
    if (!iso) return '—';
    return new Date(iso).toLocaleDateString('en-GB', { year: 'numeric', month: 'long', day: 'numeric' });
}
function fmtMoney(n) {
    return '$' + Number(n || 0).toLocaleString('en-US', { minimumFractionDigits: 0 });
}

// ─── UI Interactions ──────────────────────────
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
    el.textContent = role === 'admin' ? 'Curator' : (role === 'porter' ? 'Changemaker' : 'Contributor');
    el.style.background = role === 'admin' ? '#1A1A1A' : (role === 'porter' ? '#064e3b' : '#DAA520');
    el.style.color = role === 'admin' ? 'white' : (role === 'porter' ? 'white' : '#1A1A1A');
}

function setAvatar(url) {
    const img = document.getElementById('heroAvatarImg');
    const fallback = document.getElementById('heroAvatarFallback');
    if (url) {
        img.src = url;
        img.classList.remove('hidden');
        fallback.classList.add('hidden');
    } else {
        img.classList.add('hidden');
        fallback.classList.remove('hidden');
    }
}

// ─── Life Cycle ───────────────────────────────
document.addEventListener('DOMContentLoaded', async () => {
    const loading = document.getElementById('profileLoading');
    const guest   = document.getElementById('profileGuest');
    const page    = document.getElementById('profilePage');

    if (!ApiClient.isAuthenticated()) {
        loading.style.display = 'none';
        guest.style.display   = 'flex';
        return;
    }

    try {
        const user = await ApiClient.request('/auth/me');
        ApiClient.setUser(user);
        
        // Admin Redirect: Admins should not access profile, redirect to dashboard
        if (user.role === 'admin') {
            window.location.href = '/admin';
            return;
        }

        loading.style.display = 'none';
        page.style.display    = 'block';

        // Bind Data
        document.getElementById('heroName').textContent  = (user.first_name || '') + ' ' + (user.last_name || '');
        document.getElementById('heroEmail').textContent = user.email || '—';
        document.getElementById('heroJoined').textContent = fmtDate(user.created_at);
        setBadge(user.role);

        document.getElementById('editFirstName').value = user.first_name || '';
        document.getElementById('editLastName').value  = user.last_name  || '';
        document.getElementById('editEmail').value     = user.email      || '';
        document.getElementById('editRole').value      = (user.role || 'Contributor').toUpperCase();

        const avatarUrl = user.images && user.images.url ? user.images.url : null;
        setAvatar(avatarUrl);

        loadHeaderStats();
    } catch(e) {
        loading.style.display = 'none';
        guest.style.display   = 'flex';
    }
});

async function loadHeaderStats() {
    try {
        const [donations, favs] = await Promise.all([
            ApiClient.request('/my-donations'),
            ApiClient.request('/favourites')
        ]);
        
        const dList = donations.data || donations || [];
        const fList = favs.data || favs || [];
        
        document.getElementById('statDonations').textContent = dList.length;
        document.getElementById('statFavs').textContent = fList.length;
        
        const total = dList.reduce((s, d) => s + parseFloat(d.amount || 0), 0);
        document.getElementById('statAmount').textContent = fmtMoney(total);
    } catch(e) { console.error('Stat sync failed'); }
}

// ─── Donation Logic ───────────────────────────
async function loadDonations() {
    const listEl = document.getElementById('donationsList');
    const loadingEl = document.getElementById('donationsLoading');
    const emptyEl = document.getElementById('donationsEmpty');
    const countEl = document.getElementById('donationsCount');

    try {
        const data = await ApiClient.request('/my-donations');
        const list = data.data || data || [];
        loadingEl.classList.add('hidden');
        countEl.textContent = `${list.length} Records`;

        if (list.length === 0) { emptyEl.classList.remove('hidden'); return; }

        listEl.innerHTML = list.map(d => `
            <div class="donation-item flex items-center gap-6">
                <div class="w-14 h-14 bg-gray-50 rounded-2xl flex items-center justify-center flex-shrink-0 text-[#064e3b]">
                   <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                       <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-12c-2.21 0-4 1.79-4 4s1.79 4 4 4 4-1.79 4-4-1.79-4-4-4zm0 16a8 8 0 100-16 8 8 0 000 16z" />
                   </svg>
                </div>
                <div class="flex-1">
                    <h5 class="font-black text-gray-800 tracking-tight">${d.campaign ? d.campaign.title : 'Legacy Cause'}</h5>
                    <p class="text-[9px] uppercase font-black tracking-widest text-[#DAA520] mt-1">${fmtDate(d.created_at)}</p>
                </div>
                <div class="text-right">
                    <div class="text-xl font-black text-[#1A1A1A]">${fmtMoney(d.amount)}</div>
                    <p class="text-[8px] font-black uppercase text-gray-400 tracking-tighter">Verified Contribution</p>
                </div>
            </div>
        `).join('');
        listEl.classList.remove('hidden');
    } catch(e) { loadingEl.classList.add('hidden'); emptyEl.classList.remove('hidden'); }
}

// ─── Favourites Logic ─────────────────────────
async function loadFavourites() {
    const gridEl = document.getElementById('favGrid');
    const loadingEl = document.getElementById('favsLoading');
    const emptyEl = document.getElementById('favsEmpty');
    const countEl = document.getElementById('favsCount');

    try {
        const data = await ApiClient.request('/favourites');
        const list = data.data || data || [];
        loadingEl.classList.add('hidden');
        countEl.textContent = `${list.length} Tracked`;

        if (list.length === 0) { emptyEl.classList.remove('hidden'); return; }

        gridEl.innerHTML = list.map(fav => {
            const c = fav.campaign || fav;
            const pct = Math.min(100, ((c.current_amount || 0) / Math.max(1, c.target_amount || 1)) * 100).toFixed(0);
            const img = c.images && c.images[0] ? c.images[0].url : '';
            return `
                 <div class="bg-cream rounded-[2.5rem] overflow-hidden border border-black/5 group cursor-pointer hover:shadow-2xl transition-all duration-700">
                    <div class="h-56 bg-gray-100 relative overflow-hidden">
                        ${img ? `<img src="${img}" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-700">` : ''}
                        <div class="absolute inset-0 bg-gradient-to-t from-[#1A1A1A]/80 to-transparent"></div>
                        <div class="absolute bottom-6 left-6 right-6">
                            <h4 class="text-white font-black text-xl leading-tight mb-2 truncate">${c.title}</h4>
                            <div class="flex justify-between items-center text-[10px] font-black uppercase tracking-widest text-[#DAA520]">
                                <span>Target Reached</span>
                                <span>${pct}%</span>
                            </div>
                        </div>
                    </div>
                    <div class="p-8">
                         <div class="w-full h-1 bg-black/5 rounded-full overflow-hidden mb-6">
                            <div class="h-full bg-[#064e3b] transition-all duration-1000" style="width:${pct}%"></div>
                        </div>
                        <div class="flex justify-between items-center">
                            <div class="text-lg font-black text-[#1A1A1A]">${fmtMoney(c.current_amount)}</div>
                            <div class="text-[9px] font-black uppercase tracking-widest text-[#064e3b]">Invested</div>
                        </div>
                    </div>
                 </div>
            `;
        }).join('');
        gridEl.classList.remove('hidden');
    } catch(e) { loadingEl.classList.add('hidden'); emptyEl.classList.remove('hidden'); }
}

// ─── Update Logic ─────────────────────────────
document.getElementById('profileForm').addEventListener('submit', async (e) => {
    e.preventDefault();
    const btn = document.getElementById('saveProfileBtn');
    const success = document.getElementById('settingsSuccess');
    
    btn.disabled = true;
    btn.textContent = 'Verifying...';
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
        success.classList.remove('hidden');
        setTimeout(() => success.classList.add('hidden'), 3000);
    } catch(err) { alert('Update failed'); } finally {
        btn.disabled = false;
        btn.textContent = 'Verify Changes';
    }
});

// ─── Avatar Logic ─────────────────────────────
document.getElementById('avatarUploadInput').addEventListener('change', async (e) => {
    const file = e.target.files[0];
    if (!file) return;

    const fd = new FormData();
    fd.append('image', file);
    try {
        const res = await ApiClient.request('/auth/avatar', {
            method: 'POST',
            body: fd,
            headers: { 'Content-Type': null }
        });
        setAvatar(res.url);
        const user = ApiClient.getUser();
        if (user) { user.images = { url: res.url }; ApiClient.setUser(user); }
        // Sync Navbar
        const navImg = document.getElementById('userAvatar');
        if (navImg) navImg.innerHTML = `<img src="${res.url}" class="w-full h-full object-cover">`;
    } catch(err) { alert('Upload failed'); }
});
</script>
@endsection
