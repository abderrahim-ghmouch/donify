@extends('layouts.app')

@section('content')

{{-- Favourites Gallery (Luxury Raja Theme) --}}
<div class="min-h-screen bg-[#fbf8f6] font-quicksand relative overflow-hidden">
    
    {{-- Global Atmospheric Green Gradient --}}
    <div class="absolute bottom-0 left-0 right-0 h-[1000px] bg-gradient-to-t from-[#064e3b]/90 via-[#064e3b]/20 via-40% to-transparent pointer-events-none z-0"></div>

    {{-- Hero Section --}}
    <section class="relative pt-24 pb-12 px-8 z-10 overflow-hidden">
        <div class="max-w-7xl mx-auto text-center">
            <div class="animate-fade-in flex flex-col items-center">
                <div class="mb-6 inline-flex items-center gap-3 px-6 py-2 rounded-full bg-black/5 border border-black/5">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-[#DAA520]" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M11.645 20.91l-.007-.003-.022-.012a15.247 15.247 0 01-.383-.218 25.18 25.18 0 01-4.244-3.17C4.688 15.36 2.25 12.174 2.25 8.25 2.25 5.322 4.714 3 7.688 3A5.5 5.5 0 0112 5.052 5.5 5.5 0 0116.313 3c2.973 0 5.437 2.322 5.437 5.25 0 3.925-2.438 7.111-4.739 9.256a25.175 25.175 0 01-4.244 3.17 15.247 15.247 0 01-.383.219l-.022.012-.007.004-.003.001a.752.752 0 01-.704 0l-.003-.001z" />
                    </svg>
                    <span class="text-[10px] font-black uppercase tracking-[0.4em] text-gray-500">Personal Mission Gallery.</span>
                </div>
                
                <h1 class="text-4xl md:text-6xl font-black text-[#1A1A1A] leading-[0.95] mb-6 tracking-tighter mx-auto">
                    Saved<br>
                    <span class="text-[#064e3b]">Watchlist.</span>
                </h1>
                
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



@endsection
