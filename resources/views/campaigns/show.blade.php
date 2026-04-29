@extends('layouts.app')

@section('content')
{{-- Campaign Intelligence Console (Luxury Raja Theme) --}}
<div class="min-h-screen bg-[#fbf8f6] font-quicksand relative overflow-hidden">
    
    {{-- Refined Atmospheric Atmosphere --}}
    <div class="absolute inset-x-0 bottom-0 h-[100%] bg-gradient-to-t from-[#064e3b]/30 via-[#064e3b]/5 to-transparent pointer-events-none z-0"></div>

    {{-- Header Section: Visual Identity --}}
    <section class="relative pt-32 pb-16 px-8 z-10">
        <div class="max-w-7xl mx-auto">
            {{-- Navigation Meta --}}
            <div class="flex flex-wrap items-center gap-6 mb-12">
                <a href="/campaigns" class="group flex items-center gap-2 text-[10px] font-black uppercase tracking-[0.4em] text-gray-400 hover:text-[#1A1A1A] transition-all">
                    <span class="transform group-hover:-translate-x-1 transition-transform">←</span> Hall
                </a>
                <span class="w-1 h-1 rounded-full bg-gray-300"></span>
                <span class="text-[10px] font-black uppercase tracking-[0.4em] text-[#059669]">{{ $campaign->category->name ?? 'Visionary' }}</span>
                
                <div class="ml-auto flex items-center gap-3">
                    <span class="text-[9px] font-black uppercase tracking-widest text-gray-300">Mission Registry</span>
                    <div class="px-5 py-2 rounded-xl bg-[#1A1A1A] text-[#059669] text-[9px] font-black uppercase tracking-widest border border-[#059669]/20 shadow-2xl">
                        {{ strtoupper($campaign->status) }}
                    </div>
                </div>
            </div>

            {{-- Optimized Title Hierarchy --}}
            <h1 class="text-4xl md:text-6xl font-black text-[#1A1A1A] leading-[1.1] mb-12 tracking-tight max-w-5xl">
                {{ $campaign->title }}.
            </h1>

            {{-- Lead Authority --}}
            <div class="flex items-center gap-6 border-t border-black/[0.05] pt-12">
                <div class="w-14 h-14 rounded-2xl bg-white border-2 border-black/5 p-1 shadow-xl overflow-hidden group">
                    <img class="w-full h-full object-cover rounded-xl group-hover:scale-110 transition-transform duration-700" src="https://ui-avatars.com/api/?name={{ urlencode($campaign->user->name) }}&background=1A1A1A&color=059669" alt="Lead">
                </div>
                <div>
                    <span class="text-[9px] font-black text-[#059669] uppercase tracking-[0.3em] block mb-1">Project Lead.</span>
                    <h3 class="text-base font-black text-[#1A1A1A] uppercase tracking-wider italic">{{ $campaign->user->name }}</h3>
                </div>
            </div>
        </div>
    </section>

    {{-- Core Operation Grid --}}
    <section class="relative z-10 px-8 pb-32">
        <div class="max-w-7xl mx-auto flex flex-col lg:flex-row gap-20">
            
            {{-- Left: Narrative Column --}}
            <div class="flex-1 space-y-16">
                {{-- Cinematic Asset --}}
                <div class="rounded-[2.5rem] overflow-hidden shadow-[0_32px_64px_-16px_rgba(0,0,0,0.15)] bg-white border border-black/5 group aspect-video">
                    @if($campaign->images && count($campaign->images) > 0)
                        <img src="{{ $campaign->images[0]->url }}" class="w-full h-full object-cover transition-transform duration-1000 group-hover:scale-105" alt="Campaign Identity">
                    @else
                        <div class="w-full h-full flex items-center justify-center bg-gray-50 uppercase font-black text-gray-200 tracking-tighter text-3xl">Asset Pending</div>
                    @endif
                </div>

                {{-- Intent & Purpose --}}
                <div class="bg-white/40 backdrop-blur-3xl p-12 md:p-16 rounded-[2.5rem] border border-white/60 shadow-xl">
                    <div class="flex items-center gap-4 mb-12">
                        <div class="h-px flex-grow bg-black/5"></div>
                        <h2 class="text-[11px] font-black text-[#1A1A1A] tracking-[0.6em] uppercase">The Mission Narrative</h2>
                        <div class="h-px flex-grow bg-black/5"></div>
                    </div>
                    <div class="text-[#1A1A1A] font-medium leading-relaxed whitespace-pre-line text-lg opacity-90 tracking-tight">
                        {{ $campaign->description }}
                    </div>
                </div>

                {{-- Technical Metrics --}}
                <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                    <div class="bg-[#1A1A1A] p-8 rounded-3xl group transition-all duration-500 shadow-2xl border border-black">
                        <h4 class="text-gray-500 text-[8px] font-black uppercase tracking-[0.2em] mb-4">Authority</h4>
                        <p class="text-[#059669] text-2xl font-black tracking-tighter">{{ $campaign->donations->count() }} Pledges</p>
                    </div>
                    @foreach(['Sector' => $campaign->category->name ?? 'Global', 'Phase' => $campaign->status, 'Horizon' => ($campaign->end_date ? \Carbon\Carbon::parse($campaign->end_date)->format('M d') : 'Open')] as $label => $val)
                    <div class="bg-white/60 p-8 rounded-3xl border border-black/5 shadow-sm hover:bg-white transition-all">
                        <h4 class="text-gray-400 text-[8px] font-black uppercase tracking-[0.2em] mb-4">{{ $label }}</h4>
                        <p class="text-[#1A1A1A] text-lg font-black tracking-tighter uppercase italic">{{ $val }}</p>
                    </div>
                    @endforeach
                </div>
            </div>

            {{-- Right: Support Interface (Sticky) --}}
            <div class="w-full lg:w-[440px]">
                <div class="lg:sticky lg:top-32">
                    <div class="bg-gradient-to-br from-[#064e3b] to-[#042f24] p-12 rounded-[2.5rem] shadow-[0_45px_90px_-20px_rgba(6,78,59,0.3)] border-2 border-white/5 relative overflow-hidden">
                        {{-- Light Burst Decor --}}
                        <div class="absolute -top-32 -right-32 w-64 h-64 bg-emerald-400/10 rounded-full blur-[100px]"></div>
                        
                        <div class="relative z-10">
                            <h3 class="text-emerald-400/50 text-[10px] font-black uppercase tracking-[0.5em] mb-12 border-b border-emerald-400/10 pb-6 italic">Support Protocol</h3>
                            
                            <div class="mb-14 text-center lg:text-left">
                                <div class="flex items-baseline justify-center lg:justify-start gap-2 text-white mb-2">
                                    <span class="text-6xl font-black tracking-tighter" id="currentAmountDisplay">{{ number_format($campaign->current_amount) }} MAD</span>
                                </div>
                                <p class="text-emerald-400/70 text-[9px] font-black uppercase tracking-widest">Authorized Goal: {{ number_format($campaign->target_amount) }} MAD</p>
                            </div>

                            {{-- High Precision Progress --}}
                            @php $pct = min(100, ($campaign->current_amount / max(1, $campaign->target_amount)) * 100); @endphp
                            <div class="space-y-4 mb-16">
                                <div class="w-full h-2.5 bg-black/40 rounded-full overflow-hidden p-0.5 border border-white/5">
                                    <div class="h-full bg-gradient-to-r from-emerald-600 to-emerald-400 rounded-full transition-all duration-1000 shadow-[0_0_20px_rgba(52,211,153,0.3)]" style="width: {{ $pct }}%"></div>
                                </div>
                                <div class="flex justify-between items-center text-[10px] font-black uppercase text-white/50 tracking-[0.2em] px-1">
                                    <span class="text-emerald-400">{{ number_format($pct, 1) }}% Efficient</span>
                                    <span>{{ $campaign->end_date ? \Carbon\Carbon::parse($campaign->end_date)->diffForHumans() : 'Standing' }}</span>
                                </div>
                            </div>

                            {{-- Pledge Terminal --}}
                            <div class="space-y-6">
                                <div class="space-y-4">
                                    <label class="text-[9px] font-black text-white/30 uppercase tracking-widest ml-1 italic">Contribution Magnitude</label>
                                    <div class="relative group">
                                        <div class="absolute left-6 top-1/2 -translate-y-1/2 text-[#1A1A1A] font-black text-xs opacity-30 select-none">MAD</div>
                                        <input type="number" id="donationAmount" placeholder="0.00" class="w-full bg-white border-2 border-transparent focus:border-emerald-400/30 rounded-2xl py-6 pl-16 pr-8 text-[#1A1A1A] font-black text-2xl outline-none transition-all shadow-inner placeholder:text-gray-200">
                                    </div>
                                </div>
                                <button id="donateBtn" class="w-full bg-[#1A1A1A] text-white hover:bg-black rounded-2xl py-7 font-black uppercase tracking-[0.4em] text-[10px] transition-all shadow-2xl active:scale-95 group">
                                    Initiate Support <span class="ml-2 group-hover:translate-x-2 transition-transform inline-block">→</span>
                                </button>
                                <p id="donationMessage" class="hidden text-center text-[9px] font-black uppercase tracking-widest text-emerald-400 animate-pulse"></p>
                            </div>
                        </div>
                    </div>

                    
                    <div class="mt-8 flex items-center justify-center gap-3 opacity-40">
                        <svg class="w-4 h-4 text-gray-400" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M2.166 4.999A11.954 11.954 0 0010 1.944 11.954 11.954 0 0017.834 5c.11.65.166 1.32.166 2.001 0 4.946-3.076 9.165-7.402 10.824L10 18l-.598-.235A11.948 11.948 0 012 7.001c0-.681.056-1.35.166-2.002zm7.834 2.112A1.25 1.25 0 1110 4.611a1.25 1.25 0 010 2.5z"/></svg>
                        <p class="text-[9px] text-[#1A1A1A] font-bold uppercase tracking-widest leading-relaxed text-center">
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


