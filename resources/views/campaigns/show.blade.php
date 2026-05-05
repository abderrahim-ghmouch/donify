@extends('layouts.app')

@section('content')
    @php
        $leadName =
            $campaign->organisation?->name ??
            trim(($campaign->user?->first_name ?? '') . ' ' . ($campaign->user?->last_name ?? '')) ?:
            'Campaign Owner';
            $leadFirstName = $campaign->organisation?->name ?? ($campaign->user?->first_name ?? 'this campaign');
               $leadImage =
              $campaign->organisation?->verificationDocument?->url ??
            ($campaign->user?->images?->url ?? asset('images/mysterious-profile.svg'));
        $categoryName = $campaign->category?->category_name ?? 'Visionary';
    @endphp

    {{-- campign dashboard --}}
    <div class="min-h-screen bg-[#fbf8f6] font-quicksand relative overflow-hidden">

        {{-- Refined Atmospheric Atmosphere --}}
        <div
            class="absolute inset-x-0 bottom-0 h-full bg-gradient-to-t from-[#064e3b]/25 via-[#064e3b]/5 to-transparent pointer-events-none z-0">
        </div>

        {{-- Header Section: Visual Identity --}}
        <section class="relative pt-24 md:pt-32 pb-10 md:pb-14 px-5 md:px-8 z-10">
            <div class="max-w-7xl mx-auto">
                {{-- Navigation Meta --}}
                <div class="flex flex-wrap items-center gap-4 md:gap-6 mb-10 md:mb-12">
                    <a href="{{ route('campaigns.index') }}"
                        class="group inline-flex items-center gap-3 rounded-md border border-emerald-800/25 bg-white/80 px-5 py-3 text-xs font-black  tracking-[0.22em] text-[#064e3b] shadow-sm transition-all hover:border-emerald-700/50 hover:bg-white hover:text-[#1A1A1A]">
                        <span
                            class="text-base leading-none transform group-hover:-translate-x-1 transition-transform">←</span>
                        Campaigns
                    </a>

                    <div class="w-full sm:w-auto sm:ml-auto flex items-center gap-3">
                        <span class="text-[9px] font-black  tracking-widest text-gray-300">Campaign Registry</span>
                        <div
                            class="px-4 md:px-5 py-2 rounded-md bg-[#1A1A1A] text-[#059669] text-[9px] font-black  tracking-widest border border-[#059669]/60 shadow-sm">
                            {{ strtoupper($campaign->status) }}
                        </div>
                    </div>
                </div>

                {{-- Optimized Title Hierarchy --}}
                <h1
                    class="text-4xl md:text-6xl font-black text-[#1A1A1A] leading-[1.08] mb-10 md:mb-12 tracking-tight max-w-5xl">
                    {{ $campaign->title }}
                </h1>

                {{-- Lead Authority --}}

                <div class="flex items-center gap-5 border-t border-emerald-900/10 pt-8 md:pt-10">
                    <div
                        class="w-14 h-14 rounded-lg bg-white border border-emerald-700/25 p-1 shadow-sm overflow-hidden group shrink-0">
                        <img class="w-full h-full object-cover rounded-md group-hover:scale-105 transition-transform duration-700"
                            src="{{ $leadImage }}" alt="Lead">
                    </div>
                    <div>
                        <span class="text-[9px] font-black text-[#059669]  tracking-[0.3em] block mb-1">Project Lead</span>
                        <h2 class=" font-black text-[#1A1A1A]  tracking-wider">{{ $leadName }}</h2>
                    </div>
                </div>
            </div>
        </section>

        {{-- Core Operation Grid --}}
        <section class="relative z-10 px-5 md:px-8 pb-24 md:pb-32">
            <div class="max-w-7xl mx-auto flex flex-col lg:flex-row gap-10 xl:gap-16">

                {{-- Left: Narrative Column --}}

                <div class="flex-1 space-y-8 md:space-y-10">
                    {{-- Cinematic Asset --}}

                    <div
                        class="rounded-lg overflow-hidden shadow-sm bg-white border border-emerald-800/20 group aspect-video">
                        @if ($campaign->images && $campaign->images->count() > 0)
                            <img src="{{ $campaign->images->first()->url }}"
                                class="w-full h-full object-cover transition-transform duration-1000 group-hover:scale-105"
                                alt="Campaign Identity">
                        @else
                            <div
                                class="w-full h-full flex items-center justify-center bg-gray-50  font-black text-gray-200 tracking-tight text-2xl md:text-3xl">
                                Asset Pending</div>
                        @endif
                    </div>

                    {{-- Intent & Purpose --}}
                    <div
                        class="bg-[#fff7ed]/85 backdrop-blur-xl p-7 md:p-10 rounded-lg border border-amber-300/80 shadow-sm">
                        <div class="flex items-center gap-4 mb-8 md:mb-10">
                            <div class="h-px flex-grow bg-amber-500/20"></div>
                            <h2
                                class="text-[10px] md:text-[11px] font-black text-[#1A1A1A] tracking-[0.24em] md:tracking-[0.4em]  text-center">
                                The Mission Narrative</h2>
                            <div class="h-px flex-grow bg-amber-500/20"></div>
                        </div>
                        <div
                            class="text-[#1A1A1A] font-medium leading-8 whitespace-pre-line text-base md:text-lg opacity-90 tracking-tight">
                            {{ $campaign->description }}
                        </div>
                    </div>

                </div>

                {{-- Right: Support Interface (Sticky) --}}
                <div class="w-full lg:w-[420px] xl:w-[440px] shrink-0">
                    <div class="lg:sticky lg:top-28">
                        <div
                            class="bg-gradient-to-br from-[#064e3b] to-[#042f24] p-7 md:p-10 rounded-lg shadow-md border border-emerald-300/35 relative overflow-hidden">
                            {{-- Light Burst Decor --}}
                            <div class="absolute -top-32 -right-32 w-64 h-64 bg-emerald-400/10 rounded-full blur-[100px]">
                            </div>

                            <div class="relative z-10">
                                <h3
                                    class="text-emerald-400/60 text-[10px] font-black
                                     tracking-[0.32em] md:tracking-[0.4em] mb-9 md:mb-10 border-b border-emerald-300/20 pb-5">
                                    Support Protocol</h3>

                                <div class="mb-10 md:mb-12 text-center lg:text-left">
                                    <div class="flex items-baseline justify-center lg:justify-start gap-2 text-white mb-2">

                                        <span class="text-4xl sm:text-5xl xl:text-6xl font-black tracking-tight break-words"
                                            id="currentAmountDisplay">{{ number_format($campaign->current_amount) }}
                                            MAD</span>
                                    </div>
                                    <p class="text-emerald-400/70 text-[9px] font-black  tracking-widest">
                                        Authorized Goal: {{ number_format($campaign->target_amount) }} MAD</p>
                                </div>

                                {{-- the progressif bar --}}


                                @php $pct = min(100, ($campaign->current_amount / max(1, $campaign->target_amount)) * 100); @endphp
                                <div class="space-y-4 mb-10 md:mb-12">
                                    <div
                                        class="w-full h-2.5 bg-black/40 rounded-full overflow-hidden p-0.5 border border-emerald-200/20">
                                        <div id="campaignProgressBar"
                                            class="h-full bg-gradient-to-r from-emerald-600 to-emerald-400 rounded-full transition-all duration-1000 shadow-[0_0_20px_rgba(52,211,153,0.3)]"
                                            style="width: {{ $pct }}%"></div>
                                    </div>
                                    <div
                                        class="flex justify-between items-center text-[10px] font-black  text-white/50 tracking-[0.2em] px-1">
                                        <span id="campaignPercent"
                                            class="text-emerald-400">{{ number_format($pct, 1) }}%</span>
                                        <span>{{ $campaign->end_date ? \Carbon\Carbon::parse($campaign->end_date)->diffForHumans() : 'Standing' }}</span>
                                    </div>
                                </div>

                                {{-- Pledge Terminal --}}
                                <div class="space-y-6">
                                    <div class="space-y-4">
                                        <label
                                            class="text-[9px] font-black text-white/40  tracking-widest ml-1">Contribute
                                            for {{ $leadFirstName }}</label>
                                        <div class="relative group">
                                            <div
                                                class="absolute left-6 top-1/2 -translate-y-1/2 text-[#1A1A1A] font-black text-xs opacity-30 select-none">
                                                MAD</div>
                                            <input type="number" id="donationAmount" placeholder="0.00" min="10"
                                                max="20000"
                                                class="w-full bg-white border border-emerald-100/80 focus:border-emerald-400/70 rounded-md py-5 md:py-6 pl-16 pr-6 text-[#1A1A1A] font-black text-2xl outline-none transition-all shadow-sm placeholder:text-gray-200">
                                        </div>
                                    </div>
                                    <button id="donateBtn"
                                        class="w-full bg-[#1A1A1A] text-white hover:bg-black rounded-md py-6 md:py-7 font-black  tracking-[0.24em] md:tracking-[0.32em] text-[10px] transition-all shadow-sm active:scale-95 group border border-emerald-300/25">
                                        Initiate Support <span
                                            class="ml-2 group-hover:translate-x-2 transition-transform inline-block">→</span>
                                    </button>
                                    <p id="donationMessage"
                                        class="hidden text-center text-[9px] font-black  tracking-widest text-emerald-400 animate-pulse">
                                    </p>
                                </div>
                            </div>
                        </div>


                        <div class="mt-6 flex items-center justify-center gap-3 opacity-45">
                            <svg class="w-4 h-4 text-gray-400" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd"
                                    d="M2.166 4.999A11.954 11.954 0 0010 1.944 11.954 11.954 0 0017.834 5c.11.65.166 1.32.166 2.001 0 4.946-3.076 9.165-7.402 10.824L10 18l-.598-.235A11.948 11.948 0 012 7.001c0-.681.056-1.35.166-2.002zm7.834 2.112A1.25 1.25 0 1110 4.611a1.25 1.25 0 010 2.5z" />
                            </svg>
                            <p
                                class="text-[9px] text-[#1A1A1A] font-bold  tracking-widest leading-relaxed text-center">
                                Institutionally Verified <br> Multi-Level Security Protocol
                            </p>
                        </div>
                    </div>
                </div>

            </div>
        </section>
    </div>

    {{-- Data bridge: passes PHP values to the external JS file without Blade syntax in JS --}}
    <div id="campaignData" data-campaign-id="{{ $campaign->id }}" class="hidden"></div>
@endsection
