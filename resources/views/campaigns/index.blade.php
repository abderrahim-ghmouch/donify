@extends('layouts.app')

@section('content')

{{-- Campaigns Discovery Console (Luxury Raja Theme) --}}
<div class="min-h-screen bg-[#fbf8f6] font-quicksand relative overflow-hidden">

    {{-- Global Atmospheric Green Gradient (Footer based) --}}
    {{-- REACHES THE TITLE: Increased height and opacity shift --}}
    {{-- Sync Global Atmosphere: Ultimate Static Rise (Porter Dashboard Spec) --}}
    <div class="absolute bottom-0 left-0 right-0 h-[1200px] bg-gradient-to-t from-[#064e3b]/90 via-[#064e3b]/20 via-40% to-transparent pointer-events-none z-0"></div>

    {{-- Hero Section: Discovery Identity --}}
    <section class="relative pt-24 pb-12 px-8 z-10 overflow-hidden">

        <div class="max-w-7xl mx-auto text-center">
            <div class="animate-fade-in flex flex-col items-center">

                <h1 class="text-4xl md:text-6xl font-black text-[#1A1A1A] leading-[0.95] mb-6 tracking-tighter shadow-sm mx-auto">
                    Give <br>
                    <span class="text-[#064e3b]">Your Hand</span>
                </h1>

                {{-- Unified Search & Multi-Select Bar --}}
                <div class="relative w-full max-w-6xl bg-white/60 backdrop-blur-3xl p-5 rounded-[3rem] border-2 border-black/5 shadow-2xl flex flex-col lg:flex-row items-stretch gap-6 mx-auto">
                    {{-- Search Input --}}
                    <div class="relative flex-grow">
                        <svg xmlns="http://www.w3.org/2000/svg" class="absolute left-8 top-1/2 -translate-y-1/2 h-6 w-6 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                        </svg>
                        <input type="text" id="searchInput" placeholder="Search mission by title or purpose..."
                            class="w-full pl-20 pr-8 py-6 rounded-[2rem] bg-gray-50 border-2 border-transparent outline-none focus:border-[#064e3b] focus:bg-white transition-all text-base font-bold text-[#1A1A1A] placeholder-gray-300">
                    </div>

                    {{-- Category Select Hub --}}
                    <div class="relative flex items-center min-w-[240px] px-8 bg-gray-50 rounded-[2rem] border-2 border-transparent hover:border-black/5 transition-all">
                        <span class="text-[10px] font-black tracking-widest text-gray-400 mr-4 uppercase">Sector.</span>
                        <select id="categorySelect" onchange="handleCategoryChange()" class="absolute inset-0 w-full h-full opacity-0 cursor-pointer z-20">
                            <option value="all">All Sectors</option>
                        </select>
                        <div id="categoryLabel" class="text-sm font-black text-[#1A1A1A] uppercase tracking-widest leading-none">All Sectors</div>
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 ml-auto text-black" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M19 9l-7 7-7-7"/></svg>
                    </div>

                    {{-- Sort Select Hub --}}
                    <div class="relative flex items-center min-w-[240px] px-8 bg-black rounded-[2rem] border-2 border-transparent hover:border-emerald-500/50 transition-all">
                        <span class="text-[10px] font-black tracking-widest text-emerald-500/50 mr-4 uppercase">Sort.</span>
                        <select id="sortSelect" onchange="applyFilters()" class="absolute inset-0 w-full h-full opacity-0 cursor-pointer z-20">
                            <option value="progress">Active Progress</option>
                            <option value="target">Goal Magnitude</option>
                        </select>
                        <div id="sortLabel" class="text-sm font-black text-white uppercase tracking-widest leading-none">Active Progress</div>
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 ml-auto text-emerald-500" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M19 9l-7 7-7-7"/></svg>
                    </div>
                </div>

                {{-- Telemetry Row --}}
                <div class="flex gap-12 mt-12 items-baseline">
                    <div class="text-center">
                        <span id="totalCount" class="text-3xl font-black text-[#1A1A1A] tracking-tighter">0</span>
                        <span class="text-[9px] text-gray-400 font-bold uppercase tracking-widest block mt-1">Tracked</span>
                    </div>
                    <div class="w-px h-8 bg-black/5"></div>
                    <div class="text-center">
                        <span id="activeCount" class="text-3xl font-black text-[#059669] tracking-tighter">0</span>
                        <span class="text-[9px] text-gray-400 font-bold uppercase tracking-widest block mt-1">Authorized</span>
                    </div>
                </div>
     
    </section>

    {{-- Discovery Hub: Grid Area --}}
    <section class="relative z-10 px-8 pb-32">
        <div class="max-w-7xl mx-auto">

            <div class="flex items-center justify-center mb-12 px-6">
                <p id="resultsInfo" class="text-[10px] text-gray-400 font-bold uppercase tracking-[0.2em]">Executing Data Fetch...</p>
            </div>

            {{-- Skeleton Grid --}}
            <div id="skeletonGrid" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-12 text-left">
                @for ($i = 0; $i < 6; $i++)
                <div class="bg-white rounded-xl h-[520px] animate-pulse border border-black/5 flex flex-col overflow-hidden">
                    <div class="w-full h-64 bg-gray-100 mb-0"></div>
                    <div class="p-10 bg-[#fbf8f6]/50 flex-grow space-y-4">
                        <div class="h-8 bg-gray-200 rounded-full w-3/4"></div>
                        <div class="h-4 bg-gray-200 rounded-full w-full"></div>
                        <div class="h-4 bg-gray-200 rounded-full w-5/6"></div>
                        <div class="h-12 bg-gray-200 rounded-xl w-full mt-auto"></div>
                    </div>
                </div>
                @endfor
            </div>

            {{-- Campaigns Grid --}}
            <div id="campaignsGrid" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-12 hidden text-left"></div>

            {{-- Empty State --}}
            <div id="emptyState" class="hidden py-32 text-center">
                <div class="max-w-md mx-auto">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-24 w-24 text-gray-200 mx-auto mb-8" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"/>
                    </svg>
                    <h3 class="text-3xl font-black text-[#1A1A1A] mb-4 tracking-tighter">No Data Found.</h3>
                    <p class="text-gray-400 font-medium mb-10">The current criteria does not match any tracked initiatives.</p>
                    <button onclick="resetFilters()" class="px-12 py-6 bg-[#1A1A1A] text-[#059669] border-2 border-[#1A1A1A] rounded-2xl font-black uppercase tracking-widest text-[11px] transition-all transform hover:-translate-y-1 shadow-2xl">Reset Hall</button>
                </div>
            </div>

            {{-- Pagination --}}
            <div id="pagination" class="flex justify-center items-center gap-4 mt-24 hidden"></div>

        </div>
    </section>
</div>



@endsection

@section('scripts')
<script src="{{ asset('js/api-client.js') }}"></script>
<script>
const PAGE_SIZE = 9;
let allCampaigns  = [];
let filtered      = [];
let categories    = [];
let activeCat     = 'all';
let searchQ       = '';
let sortBy        = 'progress';
let currentPage   = 1;
let favIds        = new Set();

document.addEventListener('DOMContentLoaded', async () => {
    await Promise.all([loadCampaigns(), loadCategories(), loadFavourites()]);
    applyFilters();

    // Search Intelligence
    let timer;
    document.getElementById('searchInput').addEventListener('input', e => {
        clearTimeout(timer);
        timer = setTimeout(() => {
            searchQ = e.target.value.trim().toLowerCase();
            currentPage = 1;
            applyFilters();
        }, 300);
    });
});

async function loadCampaigns() {
    try {
        const res = await fetch('/api/campaigns', { headers: { 'Accept': 'application/json' } });
        if (!res.ok) throw new Error(`HTTP Error: ${res.status}`);
        
        const json = await res.json();
        allCampaigns = json.data || json || [];
        
        console.log('Campaigns Synchronized:', allCampaigns.length);
        const totalEl = document.getElementById('totalCount');
        const activeEl = document.getElementById('activeCount');
        if (totalEl) totalEl.textContent = allCampaigns.length;
        if (activeEl) activeEl.textContent = allCampaigns.filter(c => c.status === 'active').length;
    } catch(e) {
        console.error('Operational Failure in Mission Discovery:', e);
        const info = document.getElementById('resultsInfo');
        if (info) info.innerHTML = `<span class="text-red-500 font-black">PROTOCOL ERROR: ${e.message}</span>`;
    }
}

async function loadCategories() {
    try {
        const res = await fetch('/api/categories', { headers: { 'Accept': 'application/json' } });
        const json = await res.json();
        categories = json.data || json || [];
        populateCategorySelect();
    } catch(e) {}
}

async function loadFavourites() {
    if (!ApiClient.isAuthenticated()) return;
    try {
        const res = await ApiClient.request('/favourites');
        (res.data || res || []).forEach(f => { if (f.campaign_id) favIds.add(f.campaign_id); });
    } catch(e) {}
}

function populateCategorySelect() {
    const sel = document.getElementById('categorySelect');
    categories.forEach(cat => {
        const opt = document.createElement('option');
        opt.value = cat.id;
        opt.textContent = (cat.name || cat.category_name || '').toUpperCase();
        sel.appendChild(opt);
    });
}

function handleCategoryChange() {
    const sel = document.getElementById('categorySelect');
    activeCat = sel.value;
    document.getElementById('categoryLabel').textContent = sel.options[sel.selectedIndex].text;
    currentPage = 1;
    applyFilters();
}

function applyFilters() {
    const sortSel = document.getElementById('sortSelect');
    if (sortSel) {
        sortBy = sortSel.value;
        const sortLab = document.getElementById('sortLabel');
        if (sortLab) sortLab.textContent = sortSel.options[sortSel.selectedIndex].text;
    }

    let list = [...allCampaigns];
    if (activeCat !== 'all') list = list.filter(c => String(c.category_id) === String(activeCat));
    if (searchQ) list = list.filter(c => (c.title || '').toLowerCase().includes(searchQ) || (c.description || '').toLowerCase().includes(searchQ));

    list.sort((a, b) => {
        if (sortBy === 'progress') {
            const pa = (a.current_amount || 0) / Math.max(1, a.target_amount || 1);
            const pb = (b.current_amount || 0) / Math.max(1, b.target_amount || 1);
            return pb - pa;
        }
        if (sortBy === 'target') return (b.target_amount || 0) - (a.target_amount || 0);
        return 0;
    });

    filtered = list;
    renderPage();
}

function resetFilters() {
    searchQ = ''; activeCat = 'all'; sortBy = 'progress'; currentPage = 1;
    document.getElementById('searchInput').value = '';
    document.getElementById('categorySelect').value = 'all';
    document.getElementById('categoryLabel').textContent = 'All Sectors';
    document.getElementById('sortSelect').value = 'progress';
    document.getElementById('sortLabel').textContent = 'Funded';
    applyFilters();
}

function renderPage() {
    const grid = document.getElementById('campaignsGrid');
    const skeleton = document.getElementById('skeletonGrid');
    const empty = document.getElementById('emptyState');
    const info = document.getElementById('resultsInfo');
    const pagEl = document.getElementById('pagination');

    skeleton.classList.add('hidden');
    if (filtered.length === 0) {
        grid.classList.add('hidden');
        pagEl.classList.add('hidden');
        empty.classList.remove('hidden');
        info.textContent = 'NO MATCHING DATA.';
        return;
    }

    empty.classList.add('hidden');
    const total = filtered.length;
    const totalPages = Math.ceil(total / PAGE_SIZE);
    currentPage = Math.min(currentPage, totalPages);
    const start = (currentPage - 1) * PAGE_SIZE;
    const page = filtered.slice(start, start + PAGE_SIZE);

    info.textContent = `ANALYZING ${start + 1}–${Math.min(start + PAGE_SIZE, total)} OF ${total} TRACKED MISSIONS.`;
    grid.innerHTML = page.map((c, i) => campaignCard(c, i)).join('');
    grid.classList.remove('hidden');
    renderPagination(totalPages);

    grid.querySelectorAll('.campaign-intel-card').forEach((el, i) => {
        el.style.animationDelay = (i * 80) + 'ms';
    });
}

function campaignCard(c, i) {
    const pct = Math.min(100, ((c.current_amount || 0) / Math.max(1, c.target_amount || 1)) * 100).toFixed(1);
    const img = c.images && c.images[0] ? c.images[0].url : null;
    const cat = c.category ? (c.category.name || c.category.category_name || '') : 'Mission';

    return `
    <div class="campaign-intel-card group bg-white rounded-xl overflow-hidden border border-black/5 hover:border-[#064e3b] transition-all duration-700 shadow-sm hover:shadow-2xl flex flex-col h-full relative">
        <div class="relative h-64 overflow-hidden bg-zinc-50 border-b border-black/[0.03]">
            ${img
                ? `<img class="w-full h-full object-cover transition-transform duration-1000 group-hover:scale-110" src="${img}" alt="${escHtml(c.title)}">`
                : `<div class="w-full h-full flex items-center justify-center text-gray-200"><svg class="h-20 w-20" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg></div>`
            }
            <div class="absolute top-6 left-6 px-4 py-1.5 rounded-full bg-black/80 backdrop-blur-md text-[#059669] text-[8px] font-black uppercase tracking-widest border border-[#059669]/20 shadow-xl">
                ${escHtml(cat)}
            </div>

            {{-- Save/Star Button --}}
            <button onclick="toggleFavourite(event, ${c.id})" id="fav-btn-${c.id}" class="absolute top-6 right-6 p-3 rounded-xl backdrop-blur-md transition-all border border-white/10 ${favIds.has(c.id) ? 'bg-[#FFD700]/20 text-[#FFD700] border-[#FFD700]/30' : 'bg-black/50 text-white/70 hover:text-white hover:bg-black/70'}">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="${favIds.has(c.id) ? 'currentColor' : 'none'}" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.382-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z" />
                </svg>
            </button>
        </div>

        <div class="p-10 flex-grow flex flex-col bg-[#fbf8f6] border-t border-black/[0.02]">
            <div class="flex items-center gap-2 mb-3">
                <span class="text-[9px] font-black text-emerald-600 uppercase tracking-[0.2em] italic">Project Lead:</span>
                <span class="text-[10px] font-bold text-[#1A1A1A] uppercase tracking-wider italic underline decoration-emerald-500/30 underline-offset-4">
                    ${escHtml(c.user ? c.user.name : 'Institutional Partner')}
                </span>
            </div>
            <h3 class="text-2xl font-black text-[#1A1A1A] mb-8 tracking-tighter leading-tight group-hover:text-[#064e3b] transition-colors line-clamp-2" style="min-height:3.5rem;">
                ${escHtml(c.title)}.
            </h3>

            <div class="mt-auto space-y-6">
                <div class="space-y-3">
                    <div class="flex justify-between items-baseline mb-2">
                        <span class="text-xl font-black text-[#1A1A1A] tracking-tighter">$${fmtNum(c.current_amount || 0)}</span>
                        <span class="text-[10px] text-gray-400 font-bold uppercase tracking-widest">of $${fmtNum(c.target_amount || 0)} Goal</span>
                    </div>
                    <div class="w-full h-2 rounded-full bg-black/5 overflow-hidden border border-black/5">
                        <div class="h-full bg-[#059669] rounded-full transition-all duration-1000" style="width: ${pct}%"></div>
                    </div>
                </div>

                <a href="/campaigns/${c.id}" class="block w-full py-5 rounded-xl bg-[#1A1A1A] text-white text-center text-[10px] font-black uppercase tracking-widest hover:bg-[#064e3b] hover:text-white transition-all transform hover:-translate-y-1 shadow-xl cursor-pointer transform active:scale-95">
                    Analyze Initiative →
                </a>
            </div>
        </div>
    </div>`;
}

function renderPagination(totalPages) {
    const el = document.getElementById('pagination');
    if (totalPages <= 1) { el.classList.add('hidden'); return; }
    el.classList.remove('hidden');

    let html = `<button class="p-4 rounded-xl border-2 border-black/5 text-gray-400 font-black hover:border-black hover:text-black transition-all" ${currentPage===1?'disabled':''} onclick="goPage(${currentPage-1})">PREV.</button>`;
    for (let p = 1; p <= totalPages; p++) {
        if (totalPages > 7 && p > 2 && p < totalPages - 1 && Math.abs(p - currentPage) > 1) {
            if (p === 3 || p === totalPages - 2) html += `<span class="text-gray-300 font-black tracking-widest px-2">...</span>`;
            continue;
        }
        html += `<button class="w-12 h-12 rounded-xl border-2 border-black/5 flex items-center justify-center font-black text-xs transition-all ${p===currentPage?'bg-[#064e3b] text-white border-[#064e3b] shadow-xl':'text-gray-400 hover:border-black hover:text-black'}" onclick="goPage(${p})">${p}.</button>`;
    }
    html += `<button class="p-4 rounded-xl border-2 border-black/5 text-gray-400 font-black hover:border-black hover:text-black transition-all" ${currentPage===totalPages?'disabled':''} onclick="goPage(${currentPage+1})">NEXT.</button>`;
    el.innerHTML = html;
}

function goPage(p) {
    currentPage = p;
    renderPage();
    window.scrollTo({ top: document.getElementById('campaignsGrid').offsetTop - 200, behavior: 'smooth' });
}

async function toggleFavourite(e, id) {
    if (e) e.preventDefault();
    if (!ApiClient.isAuthenticated()) {
        window.location.href = '/login';
        return;
    }

    const btn = document.getElementById(`fav-btn-${id}`);
    const svg = btn.querySelector('svg');
    const isFav = favIds.has(id);

    try {
        if (isFav) {
            await ApiClient.request(`/favourites/${id}`, 'DELETE');
            favIds.delete(id);
            btn.className = 'absolute top-6 right-6 p-3 rounded-xl backdrop-blur-md transition-all border border-white/10 bg-black/50 text-white/70 hover:text-white hover:bg-black/70';
            svg.setAttribute('fill', 'none');
        } else {
            await ApiClient.request('/favourites', 'POST', { campaign_id: id });
            favIds.add(id);
            btn.className = 'absolute top-6 right-6 p-3 rounded-xl backdrop-blur-md transition-all border border-[#FFD700]/30 bg-[#FFD700]/20 text-[#FFD700]';
            svg.setAttribute('fill', 'currentColor');
        }
    } catch(err) {
        console.error('Failed to toggle favourite:', err);
    }
}

function fmtNum(n) { return Number(n).toLocaleString('en-US'); }
function escHtml(str) {
    const d = document.createElement('div');
    d.appendChild(document.createTextNode(str || ''));
    return d.innerHTML;
}
</script>
@endsection
