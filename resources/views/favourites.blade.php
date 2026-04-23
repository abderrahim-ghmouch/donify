@extends('layouts.app')

@section('content')

{{-- Favourites Gallery (Luxury Raja Theme) --}}
<div class="min-h-screen bg-[#fbf8f6] font-quicksand relative overflow-hidden">
    
    {{-- Global Atmospheric Green Gradient --}}
    <div class="absolute bottom-0 left-0 right-0 h-[1000px] bg-gradient-to-t from-[#064e3b]/90 via-[#064e3b]/20 via-40% to-transparent pointer-events-none z-0"></div>

    {{-- Hero Section --}}
    <section class="relative pt-40 pb-20 px-8 z-10 overflow-hidden">
        <div class="max-w-7xl mx-auto text-center">
            <div class="animate-fade-in flex flex-col items-center">
                <div class="mb-6 inline-flex items-center gap-3 px-6 py-2 rounded-full bg-black/5 border border-black/5">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-[#DAA520]" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M11.645 20.91l-.007-.003-.022-.012a15.247 15.247 0 01-.383-.218 25.18 25.18 0 01-4.244-3.17C4.688 15.36 2.25 12.174 2.25 8.25 2.25 5.322 4.714 3 7.688 3A5.5 5.5 0 0112 5.052 5.5 5.5 0 0116.313 3c2.973 0 5.437 2.322 5.437 5.25 0 3.925-2.438 7.111-4.739 9.256a25.175 25.175 0 01-4.244 3.17 15.247 15.247 0 01-.383.219l-.022.012-.007.004-.003.001a.752.752 0 01-.704 0l-.003-.001z" />
                    </svg>
                    <span class="text-[10px] font-black uppercase tracking-[0.4em] text-gray-500">Personal Mission Gallery.</span>
                </div>
                
                <h1 class="text-5xl md:text-8xl font-black text-[#1A1A1A] leading-[0.95] mb-8 tracking-tighter mx-auto">
                    Saved<br>
                    <span class="text-[#064e3b]">Watchlist.</span>
                </h1>
                <p class="text-gray-400 text-xl font-medium tracking-tight max-w-3xl mb-16 leading-relaxed mx-auto">
                    Your personal selection of high-impact initiatives. <br class="hidden md:block"> Monitor their progress and initialize support protocols.
                </p>
                
                <div class="flex gap-16 border-t border-black/5 pt-12 w-full max-w-2xl justify-center">
                    <div class="flex flex-col items-center gap-1">
                        <span id="favCount" class="text-4xl font-black text-[#1A1A1A] tracking-tighter leading-none">0</span>
                        <span class="text-[9px] text-gray-400 font-bold uppercase tracking-[0.2em]">Bookmarked</span>
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- Discovery Hub: Grid Area --}}
    <section class="relative z-10 px-8 pb-32">
        <div class="max-w-7xl mx-auto">
            
            {{-- Skeleton Grid --}}
            <div id="skeletonGrid" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-12 text-left">
                @for ($i = 0; $i < 3; $i++)
                <div class="bg-white/40 rounded-[2.5rem] p-4 h-[520px] animate-pulse border border-black/5 flex flex-col">
                    <div class="w-full h-64 bg-gray-200 rounded-[2.5rem] mb-8"></div>
                    <div class="px-4 space-y-4">
                        <div class="h-8 bg-gray-200 rounded-full w-3/4"></div>
                        <div class="h-4 bg-gray-200 rounded-full w-full"></div>
                        <div class="h-4 bg-gray-200 rounded-full w-5/6"></div>
                    </div>
                </div>
                @endfor
            </div>

            {{-- Campaigns Grid --}}
            <div id="campaignsGrid" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-12 hidden text-left"></div>

            {{-- Empty State --}}
            <div id="emptyState" class="hidden py-32 text-center">
                <div class="max-w-md mx-auto">
                    <div class="w-24 h-24 rounded-full bg-black/5 flex items-center justify-center mx-auto mb-8">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-10 w-10 text-gray-300" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z" />
                        </svg>
                    </div>
                    <h3 class="text-3xl font-black text-[#1A1A1A] mb-4 tracking-tighter">Your watchlist is empty.</h3>
                    <p class="text-gray-400 font-medium mb-10">You haven't bookmarked any missions yet. Explore the Global Mission Hall to find initiatives that resonate with you.</p>
                    <a href="{{ route('campaigns.index') }}" class="inline-block px-12 py-6 bg-[#1A1A1A] text-[#059669] border-2 border-[#1A1A1A] rounded-2xl font-black uppercase tracking-widest text-[11px] transition-all transform hover:-translate-y-1 shadow-2xl">Explore Hall</a>
                </div>
            </div>

        </div>
    </section>
</div>

<style>
    .animate-fade-up { animation: fadeUp 0.6s cubic-bezier(0.16, 1, 0.3, 1) both; }
    @keyframes fadeUp { from { opacity: 0; transform: translateY(30px); } to { opacity: 1; transform: translateY(0); } }
</style>

@endsection

@section('scripts')
<script>
let favourites = [];

document.addEventListener('DOMContentLoaded', async () => {
    if (!ApiClient.isAuthenticated()) {
        window.location.href = '/login';
        return;
    }
    await loadFavourites();
});

async function loadFavourites() {
    try {
        const res = await ApiClient.getFavourites();
        // Since we are likely getting a list of Favourite objects { user_id, campaign_id, campaign: {...} }
        // We extract the campaigns
        favourites = (res.data || res || []).map(f => f.campaign).filter(c => c !== null);
        
        document.getElementById('favCount').textContent = favourites.length;
        renderFavourites();
    } catch(e) {
        console.error('Failed to load favourites:', e);
        showEmpty();
    }
}

function renderFavourites() {
    const grid = document.getElementById('campaignsGrid');
    const skeleton = document.getElementById('skeletonGrid');
    const empty = document.getElementById('emptyState');

    skeleton.classList.add('hidden');
    
    if (favourites.length === 0) {
        showEmpty();
        return;
    }

    grid.innerHTML = favourites.map((c, i) => campaignCard(c, i)).join('');
    grid.classList.remove('hidden');
    empty.classList.add('hidden');

    grid.querySelectorAll('.campaign-intel-card').forEach((el, i) => {
        el.style.animationDelay = (i * 80) + 'ms';
        el.classList.add('animate-fade-up');
    });
}

function showEmpty() {
    document.getElementById('skeletonGrid').classList.add('hidden');
    document.getElementById('campaignsGrid').classList.add('hidden');
    document.getElementById('emptyState').classList.remove('hidden');
}

function campaignCard(c, i) {
    const pct = Math.min(100, ((c.current_amount || 0) / Math.max(1, c.target_amount || 1)) * 100).toFixed(1);
    const img = c.images && c.images[0] ? c.images[0].url : (c.image_url ? c.image_url : null);
    const cat = c.category ? (c.category.name || c.category.category_name || '') : 'Mission';

    return `
    <div class="campaign-intel-card group bg-white/40 backdrop-blur-xl rounded-[3rem] overflow-hidden border border-black/5 hover:border-[#064e3b] transition-all duration-700 shadow-sm hover:shadow-2xl flex flex-col h-full relative">
        <div class="relative h-64 overflow-hidden bg-gray-100">
            ${img 
                ? `<img class="w-full h-full object-cover transition-transform duration-1000 group-hover:scale-110" src="${img}" alt="${escHtml(c.title)}">`
                : `<div class="w-full h-full flex items-center justify-center text-gray-200"><svg class="h-20 w-20" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg></div>`
            }
            <div class="absolute top-6 left-6 px-4 py-1.5 rounded-full bg-black/80 backdrop-blur-md text-[#059669] text-[8px] font-black uppercase tracking-widest border border-[#059669]/20 shadow-xl">
                ${escHtml(cat)}
            </div>
            
            {{-- Unfavourite Pulse --}}
            <button onclick="unfavourite(event, ${c.id})" class="absolute top-6 right-6 w-10 h-10 rounded-full bg-white shadow-xl flex items-center justify-center text-red-500 hover:scale-110 transition-transform active:scale-95 group/heart z-30">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="currentColor" viewBox="0 0 24 24">
                    <path d="M11.645 20.91l-.007-.003-.022-.012a15.247 15.247 0 01-.383-.218 25.18 25.18 0 01-4.244-3.17C4.688 15.36 2.25 12.174 2.25 8.25 2.25 5.322 4.714 3 7.688 3A5.5 5.5 0 0112 5.052 5.5 5.5 0 0116.313 3c2.973 0 5.437 2.322 5.437 5.25 0 3.925-2.438 7.111-4.739 9.256a25.175 25.175 0 01-4.244 3.17 15.247 15.247 0 01-.383.219l-.022.012-.007.004-.003.001a.752.752 0 01-.704 0l-.003-.001z" />
                </svg>
            </button>
        </div>

        <div class="p-10 flex-grow flex flex-col">
            <h3 class="text-2xl font-black text-[#1A1A1A] mb-4 tracking-tighter leading-tight group-hover:text-[#064e3b] transition-colors line-clamp-2" style="min-height:3.5rem;">
                ${escHtml(c.title)}.
            </h3>
            <p class="text-gray-400 text-sm font-medium mb-10 line-clamp-2 leading-relaxed">
                ${escHtml(c.description || '')}
            </p>

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

                <a href="/campaigns/${c.id}" class="block w-full py-5 rounded-2xl bg-[#1A1A1A] text-white text-center text-[10px] font-black uppercase tracking-widest hover:bg-[#064e3b] hover:text-white transition-all transform hover:-translate-y-1 shadow-xl cursor-pointer active:scale-95 group-hover:shadow-[0_20px_40_rgba(6,78,59,0.2)]">
                    View Details →
                </a>
            </div>
        </div>
    </div>`;
}

async function unfavourite(event, id) {
    event.preventDefault();
    if(!confirm('Remove this mission from your watchlist?')) return;
    
    try {
        await ApiClient.toggleFavourite(id);
        favourites = favourites.filter(c => c.id !== id);
        document.getElementById('favCount').textContent = favourites.length;
        renderFavourites();
    } catch(e) {
        alert('Action failed.');
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
