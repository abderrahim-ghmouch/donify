@extends('layouts.app')

@section('styles')
<style>
    /* ── Hero ── */
    .campaigns-hero {
        background: linear-gradient(135deg, #0f172a 0%, #064e3b 55%, #0f172a 100%);
        padding: 5rem 1.5rem 6rem;
        position: relative;
        overflow: hidden;
    }
    .campaigns-hero::before {
        content: '';
        position: absolute;
        top: -60px; right: -60px;
        width: 450px; height: 450px;
        background: radial-gradient(circle, rgba(16,185,129,.18) 0%, transparent 70%);
        pointer-events: none;
    }
    .campaigns-hero::after {
        content: '';
        position: absolute;
        bottom: -80px; left: 10%;
        width: 380px; height: 380px;
        background: radial-gradient(circle, rgba(99,102,241,.13) 0%, transparent 70%);
        pointer-events: none;
    }

    /* ── Search bar ── */
    .search-wrap {
        position: relative;
        max-width: 560px;
    }
    .search-wrap input {
        width: 100%;
        padding: 1rem 1rem 1rem 3.2rem;
        border-radius: 1rem;
        border: none;
        outline: none;
        font-size: 0.95rem;
        background: rgba(255,255,255,.12);
        backdrop-filter: blur(10px);
        color: #fff;
        transition: background .25s;
    }
    .search-wrap input::placeholder { color: rgba(255,255,255,.55); }
    .search-wrap input:focus { background: rgba(255,255,255,.2); }
    .search-wrap svg {
        position: absolute;
        left: 1rem; top: 50%;
        transform: translateY(-50%);
        color: rgba(255,255,255,.6);
    }

    /* ── Filter pills ── */
    .filter-pill {
        display: inline-flex; align-items: center; gap: .35rem;
        padding: .45rem 1.1rem;
        border-radius: 9999px;
        border: 1.5px solid #e2e8f0;
        background: #fff;
        font-size: .82rem;
        font-weight: 600;
        color: #64748b;
        cursor: pointer;
        transition: all .25s;
        white-space: nowrap;
    }
    .filter-pill:hover, .filter-pill.active {
        border-color: #10b981;
        background: #ecfdf5;
        color: #065f46;
    }
    .filter-pill.active { box-shadow: 0 0 0 3px rgba(16,185,129,.15); }

    /* ── Sort select ── */
    .sort-select {
        padding: .55rem 2.2rem .55rem 1rem;
        border-radius: .75rem;
        border: 1.5px solid #e2e8f0;
        background: #fff;
        font-size: .85rem;
        font-weight: 600;
        color: #334155;
        cursor: pointer;
        outline: none;
        appearance: none;
        background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' fill='none' viewBox='0 0 24 24' stroke='%2364748b' stroke-width='2'%3E%3Cpath stroke-linecap='round' stroke-linejoin='round' d='M19 9l-7 7-7-7'/%3E%3C/svg%3E");
        background-repeat: no-repeat;
        background-position: right .6rem center;
        background-size: 1rem;
        transition: border-color .2s;
    }
    .sort-select:focus { border-color: #10b981; }

    /* ── Campaign cards ── */
    .camp-card {
        background: #fff;
        border-radius: 1.5rem;
        overflow: hidden;
        border: 1px solid #f1f5f9;
        box-shadow: 0 2px 12px rgba(0,0,0,.05);
        display: flex;
        flex-direction: column;
        transition: all .3s ease;
    }
    .camp-card:hover {
        transform: translateY(-6px);
        box-shadow: 0 20px 40px rgba(0,0,0,.12);
        border-color: #a7f3d0;
    }
    .camp-card .thumb {
        width: 100%; height: 210px;
        object-fit: cover;
        transition: transform .5s ease;
    }
    .camp-card:hover .thumb { transform: scale(1.06); }
    .camp-card .thumb-wrap { overflow: hidden; position: relative; height: 210px; background: #f1f5f9; }
    .camp-card .thumb-placeholder {
        width: 100%; height: 100%;
        display: flex; align-items: center; justify-content: center;
        color: #cbd5e1;
    }

    .status-badge {
        position: absolute; top: .9rem; left: .9rem;
        padding: .25rem .75rem;
        border-radius: 9999px;
        font-size: .72rem; font-weight: 700;
        backdrop-filter: blur(8px);
        border: 1px solid rgba(255,255,255,.3);
    }
    .status-active   { background: rgba(16,185,129,.85); color: #fff; }
    .status-completed { background: rgba(99,102,241,.85); color: #fff; }
    .status-cancelled { background: rgba(239,68,68,.85); color: #fff; }

    .fav-btn {
        position: absolute; top: .9rem; right: .9rem;
        width: 36px; height: 36px;
        border-radius: 50%;
        background: rgba(255,255,255,.85);
        backdrop-filter: blur(8px);
        border: none; cursor: pointer;
        display: flex; align-items: center; justify-content: center;
        transition: all .25s;
        color: #94a3b8;
    }
    .fav-btn:hover { background: #fff; color: #ef4444; transform: scale(1.15); }
    .fav-btn.favd  { color: #ef4444; background: #fff; }

    .progress-bar {
        width: 100%; height: 6px;
        background: #f1f5f9; border-radius: 9999px; overflow: hidden;
        margin-bottom: 1rem;
    }
    .progress-fill {
        height: 100%; border-radius: 9999px;
        background: linear-gradient(90deg, #10b981, #059669);
        transition: width 1s ease;
    }

    .view-btn {
        width: 100%; padding: .75rem;
        border-radius: .875rem;
        background: #f8fafc;
        border: 1.5px solid #e2e8f0;
        font-weight: 700; font-size: .875rem;
        color: #475569;
        cursor: pointer;
        transition: all .25s;
        text-align: center;
        text-decoration: none;
        display: block;
    }
    .view-btn:hover {
        background: #10b981; color: #fff;
        border-color: #10b981;
        box-shadow: 0 4px 15px rgba(16,185,129,.3);
    }

    /* ── Skeleton loader ── */
    .skeleton { background: linear-gradient(90deg, #f1f5f9 25%, #e2e8f0 50%, #f1f5f9 75%); background-size: 200% 100%; animation: shimmer 1.4s infinite; border-radius: .75rem; }
    @keyframes shimmer { 0%{background-position:200% 0} 100%{background-position:-200% 0} }

    /* ── Empty state ── */
    .empty-state { text-align: center; padding: 5rem 2rem; }
    .empty-state svg { width: 80px; height: 80px; color: #cbd5e1; margin: 0 auto 1.5rem; }

    /* ── Pagination ── */
    .page-btn {
        width: 38px; height: 38px; border-radius: .6rem;
        display: inline-flex; align-items: center; justify-content: center;
        border: 1.5px solid #e2e8f0;
        background: #fff; color: #64748b;
        font-weight: 700; font-size: .875rem;
        cursor: pointer; transition: all .2s;
    }
    .page-btn:hover, .page-btn.active {
        background: #10b981; color: #fff; border-color: #10b981;
    }
    .page-btn:disabled { opacity: .4; cursor: not-allowed; }

    /* ── Animations ── */
    .animate-fade-up { animation: fadeUp .45s ease both; }
    @keyframes fadeUp { from{opacity:0;transform:translateY(18px)} to{opacity:1;transform:translateY(0)} }
    .grid-area { display: grid; grid-template-columns: repeat(auto-fill, minmax(300px, 1fr)); gap: 1.75rem; }
</style>
@endsection

@section('content')

{{-- ── Hero ── --}}
<section class="campaigns-hero">
    <div class="max-w-7xl mx-auto relative z-10">
        <div class="mb-8">
            <span class="inline-block px-4 py-1.5 rounded-full bg-emerald-500/20 text-emerald-300 font-bold text-sm mb-4 border border-emerald-500/30">
                🌍 Explore Campaigns
            </span>
            <h1 class="text-4xl md:text-6xl font-extrabold text-white font-outfit leading-tight mb-4">
                Every cause<br><span class="text-emerald-400">deserves support.</span>
            </h1>
            <p class="text-slate-300 text-lg max-w-xl mb-8">
                Browse hundreds of real campaigns. Filter by category, search by keyword, and donate in seconds.
            </p>

            {{-- Search --}}
            <div class="search-wrap">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                </svg>
                <input type="text" id="searchInput" placeholder="Search campaigns by title or description…">
            </div>
        </div>

        {{-- Quick stats --}}
        <div class="flex flex-wrap gap-6 mt-6">
            <div class="text-white">
                <span id="totalCount" class="text-2xl font-bold text-emerald-400">—</span>
                <span class="text-slate-400 text-sm ml-2">campaigns</span>
            </div>
            <div class="text-white">
                <span id="activeCount" class="text-2xl font-bold text-emerald-400">—</span>
                <span class="text-slate-400 text-sm ml-2">active</span>
            </div>
        </div>
    </div>
</section>

{{-- ── Filters + Grid ── --}}
<section class="py-12 px-6 bg-slate-50 min-h-screen">
    <div class="max-w-7xl mx-auto">

        {{-- Filter bar --}}
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-4 mb-8 flex flex-wrap items-center gap-3">
            <span class="text-sm font-bold text-gray-500 mr-1">Filter:</span>
            <div id="categoryFilters" class="flex flex-wrap gap-2">
                <button class="filter-pill active" data-cat="all" onclick="setCategory('all', this)">
                    All Categories
                </button>
                {{-- More pills injected by JS --}}
            </div>
            <div class="ml-auto flex items-center gap-3">
                <label class="text-sm font-semibold text-gray-500">Sort:</label>
                <select class="sort-select" id="sortSelect" onchange="applyFilters()">
                    <option value="newest">Newest First</option>
                    <option value="oldest">Oldest First</option>
                    <option value="progress">Most Funded</option>
                    <option value="target">Highest Goal</option>
                </select>
            </div>
        </div>

        {{-- Results info --}}
        <div class="flex items-center justify-between mb-6">
            <p id="resultsInfo" class="text-sm text-gray-500 font-medium">Loading campaigns…</p>
        </div>

        {{-- Skeleton loaders --}}
        <div id="skeletonGrid" class="grid-area">
            @for ($i = 0; $i < 6; $i++)
            <div class="camp-card">
                <div class="skeleton" style="height:210px; border-radius:0;"></div>
                <div class="p-6 space-y-3">
                    <div class="skeleton h-5 w-3/4"></div>
                    <div class="skeleton h-4 w-full"></div>
                    <div class="skeleton h-4 w-5/6"></div>
                    <div class="skeleton h-2 w-full mt-4"></div>
                    <div class="skeleton h-10 w-full mt-2 rounded-xl"></div>
                </div>
            </div>
            @endfor
        </div>

        {{-- Campaigns Grid --}}
        <div id="campaignsGrid" class="grid-area hidden"></div>

        {{-- Empty state --}}
        <div id="emptyState" class="hidden">
            <div class="empty-state">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
                <h3 class="text-xl font-bold text-gray-700 mb-2">No campaigns found</h3>
                <p class="text-gray-400">Try a different search term or category filter.</p>
                <button onclick="resetFilters()" class="mt-6 btn-primary px-6 py-2.5 rounded-xl font-bold text-sm">
                    Clear Filters
                </button>
            </div>
        </div>

        {{-- Pagination --}}
        <div id="pagination" class="flex justify-center items-center gap-2 mt-12 hidden"></div>

    </div>
</section>

@endsection

@section('scripts')
<script>
// ─── State ────────────────────────────────────
const PAGE_SIZE = 9;
let allCampaigns  = [];
let filtered      = [];
let categories    = [];
let activeCat     = 'all';
let searchQ       = '';
let sortBy        = 'newest';
let currentPage   = 1;
let favIds        = new Set();

// ─── Boot ─────────────────────────────────────
document.addEventListener('DOMContentLoaded', async () => {
    await Promise.all([loadCampaigns(), loadCategories(), loadFavourites()]);
    applyFilters();

    // Search debounce
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

// ─── Data Fetching ────────────────────────────
async function loadCampaigns() {
    try {
        const res = await fetch('/api/campaigns', { headers: { 'Accept': 'application/json' } });
        const json = await res.json();
        allCampaigns = json.data || json || [];
        document.getElementById('totalCount').textContent  = allCampaigns.length;
        document.getElementById('activeCount').textContent = allCampaigns.filter(c => c.status === 'active').length;
    } catch(e) { console.error('Failed to load campaigns', e); }
}

async function loadCategories() {
    try {
        const res = await fetch('/api/categories', { headers: { 'Accept': 'application/json' } });
        const json = await res.json();
        categories = json.data || json || [];
        buildCategoryPills();
    } catch(e) { /* categories optional */ }
}

async function loadFavourites() {
    if (!ApiClient.isAuthenticated()) return;
    try {
        const res = await ApiClient.request('/favourites');
        (res.data || res || []).forEach(f => { if (f.campaign_id) favIds.add(f.campaign_id); });
    } catch(e) {}
}

// ─── Category pills ───────────────────────────
function buildCategoryPills() {
    const wrap = document.getElementById('categoryFilters');
    categories.forEach(cat => {
        const btn = document.createElement('button');
        btn.className = 'filter-pill';
        btn.dataset.cat = cat.id;
        btn.textContent = cat.name || cat.category_name || ('Category ' + cat.id);
        btn.onclick = () => setCategory(cat.id, btn);
        wrap.appendChild(btn);
    });
}

function setCategory(id, btn) {
    activeCat = id;
    document.querySelectorAll('.filter-pill').forEach(b => b.classList.remove('active'));
    btn.classList.add('active');
    currentPage = 1;
    applyFilters();
}

function resetFilters() {
    searchQ = ''; activeCat = 'all'; sortBy = 'newest'; currentPage = 1;
    document.getElementById('searchInput').value = '';
    document.getElementById('sortSelect').value = 'newest';
    document.querySelectorAll('.filter-pill').forEach(b => b.classList.remove('active'));
    document.querySelector('[data-cat="all"]').classList.add('active');
    applyFilters();
}

// ─── Filter + Sort ────────────────────────────
function applyFilters() {
    sortBy = document.getElementById('sortSelect').value;
    let list = [...allCampaigns];

    // Category filter
    if (activeCat !== 'all') list = list.filter(c => String(c.category_id) === String(activeCat));

    // Search
    if (searchQ) list = list.filter(c =>
        (c.title || '').toLowerCase().includes(searchQ) ||
        (c.description || '').toLowerCase().includes(searchQ)
    );

    // Sort
    list.sort((a, b) => {
        if (sortBy === 'oldest')   return new Date(a.created_at) - new Date(b.created_at);
        if (sortBy === 'progress') {
            const pa = (a.current_amount || 0) / Math.max(1, a.target_amount || 1);
            const pb = (b.current_amount || 0) / Math.max(1, b.target_amount || 1);
            return pb - pa;
        }
        if (sortBy === 'target')   return (b.target_amount || 0) - (a.target_amount || 0);
        return new Date(b.created_at) - new Date(a.created_at); // newest
    });

    filtered = list;
    renderPage();
}

// ─── Render ───────────────────────────────────
function renderPage() {
    const grid     = document.getElementById('campaignsGrid');
    const skeleton = document.getElementById('skeletonGrid');
    const empty    = document.getElementById('emptyState');
    const info     = document.getElementById('resultsInfo');
    const pagEl    = document.getElementById('pagination');

    skeleton.classList.add('hidden');

    if (filtered.length === 0) {
        grid.classList.add('hidden');
        pagEl.classList.add('hidden');
        empty.classList.remove('hidden');
        info.textContent = 'No results found.';
        return;
    }

    empty.classList.add('hidden');
    const total = filtered.length;
    const totalPages = Math.ceil(total / PAGE_SIZE);
    currentPage = Math.min(currentPage, totalPages);
    const start = (currentPage - 1) * PAGE_SIZE;
    const page  = filtered.slice(start, start + PAGE_SIZE);

    info.textContent = `Showing ${start + 1}–${Math.min(start + PAGE_SIZE, total)} of ${total} campaigns`;

    grid.innerHTML = page.map((c, i) => campaignCard(c, i)).join('');
    grid.classList.remove('hidden');
    renderPagination(totalPages);

    // Animate cards in
    grid.querySelectorAll('.camp-card').forEach((el, i) => {
        el.style.animationDelay = (i * 60) + 'ms';
        el.classList.add('animate-fade-up');
    });
}

function campaignCard(c, i) {
    const pct  = Math.min(100, ((c.current_amount || 0) / Math.max(1, c.target_amount || 1)) * 100).toFixed(1);
    const img  = c.images && c.images[0] ? c.images[0].url : null;
    const cat  = c.category ? (c.category.name || c.category.category_name || '') : '';
    const isFav = favIds.has(c.id);
    const status = c.status || 'active';

    return `
    <div class="camp-card">
        <div class="thumb-wrap">
            ${img
                ? `<img class="thumb" src="${img}" alt="${escHtml(c.title)}" loading="lazy">`
                : `<div class="thumb-placeholder"><svg xmlns="http://www.w3.org/2000/svg" class="h-16 w-16" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg></div>`
            }
            ${cat ? `<div class="status-badge status-${status}">${escHtml(cat)}</div>` : `<div class="status-badge status-${status}">${status}</div>`}
            ${ApiClient.isAuthenticated()
                ? `<button class="fav-btn ${isFav ? 'favd' : ''}" title="${isFav ? 'Remove from favourites' : 'Add to favourites'}" onclick="toggleFav(event, ${c.id}, this)">
                      <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="${isFav ? 'currentColor' : 'none'}" viewBox="0 0 24 24" stroke="currentColor">
                          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"/>
                      </svg>
                   </button>`
                : ''}
        </div>
        <div class="p-6 flex flex-col flex-grow">
            <h3 class="text-lg font-bold text-gray-800 mb-2 font-outfit line-clamp-2 leading-tight group-hover:text-emerald-600" style="min-height:2.8rem;">
                ${escHtml(c.title)}
            </h3>
            <p class="text-gray-400 text-sm mb-4 line-clamp-2 leading-relaxed flex-grow">
                ${escHtml(c.description || '')}
            </p>
            <div class="mt-auto">
                <div class="flex justify-between text-sm mb-1">
                    <span class="font-bold text-emerald-600">$${fmtNum(c.current_amount || 0)}</span>
                    <span class="text-gray-400">of $${fmtNum(c.target_amount || 0)}</span>
                </div>
                <div class="progress-bar">
                    <div class="progress-fill" style="width:${pct}%"></div>
                </div>
                <div class="flex justify-between text-xs text-gray-400 mb-4">
                    <span>${pct}% funded</span>
                    ${c.end_date ? `<span>Ends ${fmtDate(c.end_date)}</span>` : ''}
                </div>
                <a href="/campaigns/${c.id}" class="view-btn">View Campaign →</a>
            </div>
        </div>
    </div>`;
}

// ─── Favourite toggle ─────────────────────────
async function toggleFav(e, campId, btn) {
    e.preventDefault(); e.stopPropagation();
    if (!ApiClient.isAuthenticated()) { window.location.href = '{{ route("login") }}'; return; }
    const isFav = btn.classList.contains('favd');
    btn.style.opacity = '.5'; btn.style.pointerEvents = 'none';
    try {
        await ApiClient.request(`/campaigns/${campId}/favourite`, { method: 'POST' });
        if (isFav) {
            favIds.delete(campId);
            btn.classList.remove('favd');
            btn.querySelector('svg').setAttribute('fill', 'none');
            btn.title = 'Add to favourites';
        } else {
            favIds.add(campId);
            btn.classList.add('favd');
            btn.querySelector('svg').setAttribute('fill', 'currentColor');
            btn.title = 'Remove from favourites';
        }
    } catch(err) { console.error(err); }
    finally { btn.style.opacity = '1'; btn.style.pointerEvents = 'auto'; }
}

// ─── Pagination ───────────────────────────────
function renderPagination(totalPages) {
    const el = document.getElementById('pagination');
    if (totalPages <= 1) { el.classList.add('hidden'); return; }
    el.classList.remove('hidden');

    let html = `<button class="page-btn" ${currentPage===1?'disabled':''} onclick="goPage(${currentPage-1})">‹</button>`;
    for (let p = 1; p <= totalPages; p++) {
        if (totalPages > 7 && p > 2 && p < totalPages - 1 && Math.abs(p - currentPage) > 1) {
            if (p === 3 || p === totalPages - 2) html += `<span class="page-btn" style="cursor:default;border:none">…</span>`;
            continue;
        }
        html += `<button class="page-btn ${p===currentPage?'active':''}" onclick="goPage(${p})">${p}</button>`;
    }
    html += `<button class="page-btn" ${currentPage===totalPages?'disabled':''} onclick="goPage(${currentPage+1})">›</button>`;
    el.innerHTML = html;
}

function goPage(p) {
    currentPage = p;
    renderPage();
    window.scrollTo({ top: document.getElementById('campaignsGrid').offsetTop - 100, behavior: 'smooth' });
}

// ─── Utils ────────────────────────────────────
function fmtNum(n) { return Number(n).toLocaleString('en-US'); }
function fmtDate(iso) {
    if (!iso) return '';
    return new Date(iso).toLocaleDateString('en-GB', { day: 'numeric', month: 'short', year: 'numeric' });
}
function escHtml(str) {
    const d = document.createElement('div');
    d.appendChild(document.createTextNode(str || ''));
    return d.innerHTML;
}
</script>
@endsection
