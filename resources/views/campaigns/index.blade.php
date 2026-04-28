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
                <div class=" flex gap-12 mt-12 items-baseline">
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
            <div id="campaignsGrid" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 lg:grid-rows-2 gap-8  text-left"></div>

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


