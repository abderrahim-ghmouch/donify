@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-[#fbf8f6] font-quicksand relative overflow-hidden">

    {{-- Atmospheric blobs --}}
    <div class="fixed inset-0 pointer-events-none overflow-hidden z-0">
        <div class="absolute -top-[10%] -right-[5%] w-[60%] h-[60%] bg-[#064e3b]/8 blur-[180px] rounded-full"></div>
        <div class="absolute -bottom-[20%] -left-[10%] w-[55%] h-[55%] bg-emerald-400/10 blur-[150px] rounded-full"></div>
    </div>

    {{-- Hero Header --}}
    <section class="relative pt-36 pb-16 px-6 z-10 text-center">
        <div class="max-w-5xl mx-auto flex flex-col items-center">

            {{-- Title with logo watermark behind it --}}
            <div class="relative flex items-center justify-center mb-4">
                {{-- Logo as background watermark --}}
                <img src="{{ asset('images/donifylg.png') }}" alt=""
                    class="absolute w-[420px] md:w-[580px] opacity-[0.06] select-none pointer-events-none">
                {{-- Title on top --}}
                <h1 class="relative text-6xl md:text-8xl font-black text-[#1A1A1A] leading-none tracking-tighter z-10">
                    Dash<span class="text-[#064e3b]">board</span>
                </h1>
            </div>

            <div class="flex flex-col items-center gap-4 mb-16">
                <div class="h-[2px] w-12 bg-[#064e3b]/40 rounded-full"></div>
                <p class="text-sm font-bold text-[#1A1A1A]/50 uppercase tracking-[0.4em]">
                    Porter — <span id="heroName" class="text-[#064e3b] font-black">...</span>
                </p>
            </div>

            {{-- Stats + Stripe side by side on desktop --}}
            <div class="w-full max-w-4xl grid grid-cols-1 lg:grid-cols-3 gap-5 mb-5">
                <div class="bg-white rounded-2xl border border-[#064e3b]/15 p-8 shadow-sm text-left hover:shadow-md hover:border-[#064e3b]/30 transition-all group">
                    <div class="flex items-center gap-2 mb-3">
                        <div class="w-1.5 h-1.5 rounded-full bg-[#064e3b]"></div>
                        <div class="text-xs font-black uppercase tracking-[0.3em] text-[#064e3b]/60">Total Raised</div>
                    </div>
                    <div id="porterTotalRaised" class="text-4xl font-black tracking-tighter text-[#1A1A1A] group-hover:text-[#064e3b] transition-colors">0 MAD</div>
                </div>
                <div class="bg-white rounded-2xl border border-[#064e3b]/15 p-8 shadow-sm text-left hover:shadow-md hover:border-[#064e3b]/30 transition-all group">
                    <div class="flex items-center gap-2 mb-3">
                        <div class="w-1.5 h-1.5 rounded-full bg-[#064e3b]"></div>
                        <div class="text-xs font-black uppercase tracking-[0.3em] text-[#064e3b]/60">Campaigns</div>
                    </div>
                    <div id="porterCampaignCount" class="text-4xl font-black tracking-tighter text-[#1A1A1A] group-hover:text-[#064e3b] transition-colors">0</div>
                </div>
                <div class="bg-white rounded-2xl border border-[#064e3b]/15 p-8 shadow-sm text-left hover:shadow-md hover:border-[#064e3b]/30 transition-all group">
                    <div class="flex items-center gap-2 mb-3">
                        <div class="w-1.5 h-1.5 rounded-full bg-[#064e3b]"></div>
                        <div class="text-xs font-black uppercase tracking-[0.3em] text-[#064e3b]/60">Donations</div>
                    </div>
                    <div id="porterDonationCount" class="text-4xl font-black tracking-tighter text-[#1A1A1A] group-hover:text-[#064e3b] transition-colors">0</div>
                </div>
            </div>

            {{-- Stripe + CTA row --}}
            <div class="w-full max-w-4xl grid grid-cols-1 lg:grid-cols-3 gap-5 mb-12">
                {{-- Stripe card spans 2 cols --}}
                <div class="lg:col-span-2 bg-[#064e3b]/5 rounded-2xl border border-[#064e3b]/20 p-8 shadow-sm flex flex-col sm:flex-row items-start sm:items-center justify-between gap-6 text-left">
                    <div>
                        <div class="text-xs font-black uppercase tracking-[0.3em] text-[#064e3b]/60 mb-2">Payout Channel</div>
                        <div id="stripeConnectStatus" class="text-xl font-black tracking-tight text-[#1A1A1A]">Checking Stripe...</div>
                        <p class="text-xs text-[#1A1A1A]/40 font-semibold uppercase tracking-[0.12em] mt-2">Connect Stripe Express to receive payouts.</p>
                    </div>
                    <button id="stripeConnectBtn" class="flex-shrink-0 px-6 py-4 rounded-xl bg-[#064e3b] text-white text-xs font-black uppercase tracking-[0.3em] hover:bg-black transition-all shadow-lg">
                        Connect Stripe
                    </button>
                </div>

                {{-- Launch CTA as a card --}}
                <button onclick="openMissionModal()" class="group relative lg:col-span-1 rounded-2xl bg-[#064e3b] text-white text-xs font-black uppercase tracking-[0.4em] transition-all shadow-xl overflow-hidden flex items-center justify-center py-8 lg:py-0">
                    <div class="absolute inset-0 bg-black translate-y-full group-hover:translate-y-0 transition-transform duration-500"></div>
                    <span class="relative z-10">+ Launch Campaign</span>
                </button>
            </div>
        </div>
    </section>

    {{-- Campaigns List --}}
    <section class="relative z-10 px-6 pb-32">
        <div class="max-w-5xl mx-auto">

            <div class="flex items-center justify-between mb-10 border-b border-[#064e3b]/15 pb-6">
                <div>
                    <h3 class="text-xl font-black text-[#1A1A1A] tracking-tight">My Campaigns</h3>
                    <p class="text-xs font-bold text-[#1A1A1A]/40 uppercase tracking-[0.3em] mt-1">Active portfolio</p>
                </div>
                <div class="flex items-center gap-3">
                    <div class="w-2 h-2 rounded-full bg-emerald-500 animate-pulse"></div>
                    <span class="text-xs font-black text-[#064e3b] uppercase tracking-widest">Live</span>
                </div>
            </div>

            <div class="flex flex-col gap-5" id="myCampaignsList">
                @for($i = 0; $i < 3; $i++)
                <div class="bg-white h-36 rounded-2xl border border-[#064e3b]/10 animate-pulse shadow-sm"></div>
                @endfor
            </div>
        </div>
    </section>

    {{-- Campaign Modal --}}
    <div id="missionModal" class="fixed inset-0 z-[100] hidden opacity-0 transition-all duration-500 flex items-center justify-center p-4 md:p-8">
        <div class="absolute inset-0 bg-[#fbf8f6]/80 backdrop-blur-xl" onclick="closeMissionModal()"></div>

        <div class="relative w-full max-w-6xl bg-white rounded-2xl border border-[#064e3b]/20 shadow-[0_60px_120px_rgba(6,78,59,0.12)] transform transition-all duration-700 translate-y-20 scale-[0.98] opacity-0 overflow-hidden" id="modalContainer">

            {{-- Modal Header --}}
            <div class="relative flex flex-col items-center p-12 lg:p-20 border-b border-[#064e3b]/10 bg-[#064e3b]/5 text-center">
                <div class="text-xs font-black uppercase tracking-[0.6em] text-[#064e3b]/60 mb-6">New Campaign</div>
                <h5 class="text-5xl md:text-7xl font-black text-[#1A1A1A] tracking-tighter leading-none">Deploy.</h5>
                <button onclick="closeMissionModal()" class="absolute top-10 right-10 w-12 h-12 rounded-full bg-white hover:bg-emerald-50 flex items-center justify-center transition-all border border-[#064e3b]/15">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-[#064e3b]/40 hover:text-[#064e3b] transition-colors" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M6 18L18 6M6 6l12 12"/></svg>
                </button>
            </div>

            {{-- Form --}}
            <div class="max-h-[70vh] overflow-y-auto [&::-webkit-scrollbar]:w-1.5 [&::-webkit-scrollbar-thumb]:bg-emerald-100 bg-white">
                <form id="createCampaignForm" class="grid grid-cols-1 lg:grid-cols-12 font-quicksand">

                    {{-- Left: Narrative --}}
                    <div class="lg:col-span-7 p-10 lg:p-20 space-y-12">
                        <div class="space-y-4">
                            <label class="text-xs font-black text-[#064e3b]/70 uppercase tracking-[0.4em]">Campaign Title</label>
                            <input type="text" id="cTitle" placeholder="PROJECT LABEL"
                                class="w-full bg-[#fbf8f6] border border-[#064e3b]/15 rounded-xl outline-none py-6 px-8 text-xl font-black text-[#1A1A1A] placeholder:text-slate-300 focus:border-[#064e3b]/50 transition-all uppercase tracking-widest">
                        </div>
                        <div class="space-y-4">
                            <label class="text-xs font-black text-[#064e3b]/70 uppercase tracking-[0.4em]">Description</label>
                            <textarea id="cDesc" placeholder="Describe your campaign..."
                                class="w-full bg-[#fbf8f6] border border-[#064e3b]/15 rounded-xl outline-none py-6 px-8 text-base font-medium text-slate-600 placeholder:text-slate-300 focus:border-[#064e3b]/50 h-56 resize-none leading-relaxed"></textarea>
                        </div>
                    </div>

                    {{-- Right: Config --}}
                    <div class="lg:col-span-5 p-10 lg:p-20 space-y-12 bg-emerald-50/30 border-l border-[#064e3b]/10">
                        <div class="space-y-4">
                            <label class="text-xs font-black text-[#064e3b]/70 uppercase tracking-[0.4em]">Category</label>
                            <select id="cCategory" class="w-full bg-white border border-[#064e3b]/15 rounded-xl outline-none py-6 px-8 text-sm font-black text-[#1A1A1A] focus:border-[#064e3b]/50 transition-all cursor-pointer uppercase tracking-widest">
                                <option value="">Select Category</option>
                            </select>
                        </div>
                        <div class="space-y-4">
                            <label class="text-xs font-black text-[#064e3b]/70 uppercase tracking-[0.4em]">Target (MAD)</label>
                            <input type="number" id="cTarget" placeholder="0"
                                class="w-full bg-white border border-[#064e3b]/15 rounded-xl outline-none py-6 px-8 text-5xl font-black text-[#064e3b] placeholder:text-emerald-100 focus:border-[#064e3b]/50 transition-all tracking-tighter">
                        </div>
                        <div class="grid grid-cols-2 gap-6">
                            <div class="space-y-4">
                                <label class="text-xs font-black text-[#064e3b]/70 uppercase tracking-[0.4em]">Start Date</label>
                                <input type="date" id="cStartDate" class="w-full bg-white border border-[#064e3b]/15 rounded-xl outline-none py-4 px-6 text-sm font-black text-[#1A1A1A] focus:border-[#064e3b]/50 transition-all">
                            </div>
                            <div class="space-y-4">
                                <label class="text-xs font-black text-[#064e3b]/70 uppercase tracking-[0.4em]">End Date</label>
                                <input type="date" id="cEndDate" class="w-full bg-white border border-[#064e3b]/15 rounded-xl outline-none py-4 px-6 text-sm font-black text-[#1A1A1A] focus:border-[#064e3b]/50 transition-all">
                            </div>
                        </div>
                        <div class="space-y-4">
                            <label class="text-xs font-black text-[#064e3b]/70 uppercase tracking-[0.4em]">Campaign Image</label>
                            <label class="block relative cursor-pointer group">
                                <input type="file" id="cImages" class="absolute inset-0 opacity-0 z-10" accept="image/*">
                                <div class="w-full py-10 border-2 border-dashed border-[#064e3b]/20 rounded-2xl flex items-center justify-center transition-all group-hover:border-[#064e3b]/50 bg-white hover:bg-emerald-50/30">
                                    <p id="dropText" class="text-xs font-black text-[#064e3b]/40 uppercase tracking-[0.4em] group-hover:text-[#064e3b] transition-colors">Upload Image (+)</p>
                                </div>
                            </label>
                        </div>
                    </div>

                    {{-- Actions --}}
                    <div class="lg:col-span-12 p-12 lg:p-20 bg-[#064e3b]/5 border-t border-[#064e3b]/10 flex flex-col items-center gap-10">
                        <div id="galleryPreview" class="h-40 w-64 rounded-xl bg-white border border-[#064e3b]/20 overflow-hidden shadow-lg flex items-center justify-center cursor-pointer hover:border-[#064e3b]/40 transition-all" onclick="document.getElementById('cImages').click()">
                            <span class="text-xs font-black text-[#064e3b]/30 uppercase tracking-[0.3em]">No Image</span>
                        </div>
                        <button type="submit" id="submitBtn" class="w-full md:w-auto px-24 py-6 bg-[#064e3b] text-white rounded-xl text-xs font-black uppercase tracking-[0.6em] hover:bg-black transition-all shadow-xl">
                            Launch Campaign
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
