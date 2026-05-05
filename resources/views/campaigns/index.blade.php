@extends('layouts.app')

@section('content')


<div class="min-h-screen bg-[#fbf8f6] font-quicksand relative overflow-hidden">

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
                <div class="relative w-full max-w-6xl bg-white/20 backdrop-blur-3xl p-5 rounded-[3rem] border-2 border-black/5 shadow-2xl flex flex-col lg:flex-row items-stretch gap-6 mx-auto">
                    {{-- Search Input --}}
                    <div class="relative flex-grow">
                        <svg xmlns="http://www.w3.org/2000/svg" class="absolute left-8 top-1/2 -translate-y-1/2 h-6 w-6 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                        </svg>
                        <input type="text" id="searchInput" placeholder="Search"
                            class="w-full pl-20 pr-8 py-6 rounded-[2rem] bg-gray-20 border-2 border-transparent outline-none focus:border-[#064e3b] focus:bg-white transition-all text-base font-bold text-[#1A1A1A] placeholder-gray-300">
                    </div>

                    {{-- Category Select Hub --}}
                    <div class="relative flex items-center min-w-[240px] px-8 bg-gray-50 rounded-[2rem] border-2 border-transparent hover:border-black/5 transition-all">
                        <span class="text-[10px] font-black tracking-widest text-gray-400 mr-4 uppercase">Category</span>
                        <select id="categorySelect" onchange="handleCategoryChange()" class="absolute inset-0 w-full h-full opacity-0 cursor-pointer z-20">
                            <option value="all">All Categories</option>
                        </select>
                        <div id="categoryLabel" class="text-sm font-black text-[#1A1A1A] uppercase tracking-widest leading-none">All Categories</div>
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 ml-auto text-black" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M19 9l-7 7-7-7"/></svg>
                    </div>




    </section>

    {{-- Discovery Hub: Grid Area --}}
    <section class="relative z-10 px-8 pb-32">
        <div class="max-w-7xl mx-auto">



            <div id="skeletonGrid" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-12 text-left">
                @for ($i = 0; $i < 6; $i++)
                <div class="bg-[#fbf8f6] rounded-2xl h-[520px] animate-pulse border-2 border-[#064e3b]/40 flex flex-col overflow-hidden">
                    <div class="w-full h-64 bg-gray-100 mb-0"></div>
                    <div class="p-10 bg-gradient-to-br from-[#fbf8f6] to-[#f5ede4] flex-grow space-y-4">
                        <div class="h-8 bg-gray-200 rounded-full w-3/4"></div>
                        <div class="h-4 bg-gray-200 rounded-full w-full"></div>
                        <div class="h-4 bg-gray-200 rounded-full w-5/6"></div>
                        <div class="h-12 bg-gray-200 rounded-xl w-full mt-auto"></div>
                    </div>
                </div>
                @endfor
            </div>

            {{-- Campaigns Grid --}}
            <div id="campaignsGrid" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-10 text-left"></div>

            {{-- Empty State --}}
            <div id="emptyState" class="hidden py-32 text-center">
                <div class="max-w-md mx-auto">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-24 w-24 text-gray-200 mx-auto mb-8" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"/>
                    </svg>
                    <h2 class="text-3xl font-black text-[#1A1A1A] mb-4 tracking-tighter">No Data Found</h2>
                    <p class="text-gray-400 font-medium mb-10">The current criteria does not match any tracked initiatives</p>
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
<script>
let allCampaigns = [];
let categories = [];
let currentFilters = { search: '', category: 'all' };

async function loadCategories() {
    try {
        const response = await fetch('/api/categories');
        const data = await response.json();
        categories = data.data;

        const select = document.getElementById('categorySelect');
        categories.forEach(cat => {
            const option = document.createElement('option');
            option.value = cat.id;
            option.textContent = cat.category_name;
            select.appendChild(option);
        });
    } catch (error) {
        console.error('Failed to load categories:', error);
    }
}

async function loadCampaigns() {
    try {
        const response = await fetch('/api/campaigns');
        const data = await response.json();
        allCampaigns = data.data;
        filterAndDisplay();
    } catch (error) {
        console.error('Failed to load campaigns:', error);
    } finally {
        document.getElementById('skeletonGrid').style.display = 'none';
    }
}

function handleCategoryChange() {
    const select = document.getElementById('categorySelect');
    const label = document.getElementById('categoryLabel');
    currentFilters.category = select.value;
    label.textContent = select.options[select.selectedIndex].text;
    filterAndDisplay();
}

function filterAndDisplay() {
    let filtered = allCampaigns;

    if (currentFilters.search) {
        filtered = filtered.filter(c =>
            c.title.toLowerCase().includes(currentFilters.search.toLowerCase()) ||
            c.description.toLowerCase().includes(currentFilters.search.toLowerCase())
        );
    }

    if (currentFilters.category !== 'all') {
        filtered = filtered.filter(c => c.category_id == currentFilters.category);
    }

    displayCampaigns(filtered);
}

function displayCampaigns(campaigns) {
    const grid = document.getElementById('campaignsGrid');
    const empty = document.getElementById('emptyState');

    if (campaigns.length === 0) {
        grid.innerHTML = '';
        empty.classList.remove('hidden');
        return;
    }

    empty.classList.add('hidden');
    grid.innerHTML = campaigns.map(campaign => {
        const image = campaign.images?.[0]?.url || '/images/placeholder.jpg';
        const progress = campaign.target_amount > 0 ? (campaign.current_amount / campaign.target_amount * 100) : 0;
        const categoryName = campaign.category?.category_name || 'General';

        return `
            <a href="/campaigns/${campaign.id}" class="group block bg-[#fbf8f6] rounded-2xl overflow-hidden border-2 border-[#064e3b]/40 hover:border-[#064e3b] hover:shadow-2xl transition-all duration-300 hover:-translate-y-2">
                <div class="relative h-64 overflow-hidden">
                    <img src="${image}" alt="${campaign.title}" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-700">
                    <div class="absolute top-4 left-4">
                        <span class="px-4 py-2 bg-[#064e3b]/90 backdrop-blur-sm text-white text-[9px] font-black uppercase tracking-widest rounded-full border border-white/20">
                            ${categoryName}
                        </span>
                    </div>
                    <div class="absolute inset-0 bg-gradient-to-t from-black/40 via-transparent to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
                </div>
                <div class="p-8 bg-gradient-to-br from-[#fbf8f6] to-[#f5ede4]">
                    <h3 class="text-xl font-black text-[#1A1A1A] mb-3 line-clamp-2 tracking-tight leading-tight group-hover:text-[#064e3b] transition-colors">${campaign.title}</h3>
                    <p class="text-sm text-gray-500 mb-6 line-clamp-2 leading-relaxed">${campaign.description}</p>

                    <div class="space-y-3">
                        <div class="flex justify-between items-baseline">
                            <div>
                                <span class="text-2xl font-black text-[#064e3b]">${campaign.current_amount.toLocaleString()}</span>
                                <span class="text-xs font-bold text-gray-400 ml-1">MAD</span>
                            </div>
                            <span class="text-xs font-bold text-gray-400">of ${campaign.target_amount.toLocaleString()} MAD</span>
                        </div>

                        <div class="relative">
                            <div class="w-full bg-gray-200 rounded-full h-2.5 overflow-hidden">
                                <div class="bg-gradient-to-r from-[#064e3b] to-[#059669] h-full rounded-full transition-all duration-500 shadow-lg" style="width: ${Math.min(progress, 100)}%"></div>
                            </div>
                        </div>

                        <div class="flex justify-between items-center pt-2">
                            <span class="text-xs font-black text-[#064e3b] tracking-wider">${Math.round(progress)}% FUNDED</span>
                            <span class="text-[9px] font-bold text-gray-400 uppercase tracking-widest flex items-center gap-1">
                                <svg class="w-3 h-3" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                                Active
                            </span>
                        </div>
                        
                        <div class="pt-4">
                            <button class="w-full py-3 bg-gradient-to-r from-[#064e3b] to-[#059669] text-white font-black text-xs tracking-wider rounded-xl hover:shadow-lg transition-all duration-300 group-hover:from-[#059669] group-hover:to-[#064e3b]">
                                View Details
                            </button>
                        </div>
                    </div>
                </div>
            </a>
        `;
    }).join('');
}

function resetFilters() {
    currentFilters = { search: '', category: 'all' };
    document.getElementById('searchInput').value = '';
    document.getElementById('categorySelect').value = 'all';
    document.getElementById('categoryLabel').textContent = 'All Categories';
    filterAndDisplay();
}

document.getElementById('searchInput').addEventListener('input', (e) => {
    currentFilters.search = e.target.value;
    filterAndDisplay();
});

loadCategories();
loadCampaigns();
</script>
@endsection

