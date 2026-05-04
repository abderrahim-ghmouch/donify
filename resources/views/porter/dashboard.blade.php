@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-[#fbf8f6] font-quicksand relative overflow-hidden">

    {{-- Atmospheric blobs --}}
    <div class="fixed inset-0 pointer-events-none overflow-hidden z-0">
        <div class="absolute inset-x-0 bottom-0 h-full bg-gradient-to-t from-[#064e3b]/25 via-[#064e3b]/5 to-transparent"></div>
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
                <h1 class="relative text-6xl md:text-8xl font-black text-black leading-none tracking-tighter z-10">
                    Dash<span class="text-black">board</span>
                </h1>
            </div>

            <div class="flex flex-col items-center gap-4 mb-16">
                <div class="h-[2px] w-12 bg-[#996515] rounded-full"></div>
                <p class="text-sm font-bold text-black/60 uppercase tracking-[0.4em]">
                    Porter — <span id="heroName" class="text-black font-black">...</span>
                </p>
            </div>

            {{-- Stats + Stripe side by side on desktop --}}
            <div class="w-full max-w-4xl grid grid-cols-1 lg:grid-cols-3 gap-5 mb-5">
                <div class="bg-white rounded-lg border border-emerald-800/20 p-8 shadow-sm text-left hover:shadow-md hover:border-emerald-700/40 transition-all group">
                    <div class="flex items-center gap-2 mb-3">
                        <div class="w-1.5 h-1.5 rounded-full bg-[#059669]"></div>
                        <div class="text-xs font-black uppercase tracking-[0.3em] text-[#059669]/70">Total Raised</div>
                    </div>
                    <div id="porterTotalRaised" class="text-4xl font-black tracking-tighter text-[#1A1A1A] transition-colors">0 MAD</div>
                </div>
                <div class="bg-white rounded-lg border border-emerald-800/20 p-8 shadow-sm text-left hover:shadow-md hover:border-emerald-700/40 transition-all group">
                    <div class="flex items-center gap-2 mb-3">
                        <div class="w-1.5 h-1.5 rounded-full bg-[#059669]"></div>
                        <div class="text-xs font-black uppercase tracking-[0.3em] text-[#059669]/70">Campaigns</div>
                    </div>
                    <div id="porterCampaignCount" class="text-4xl font-black tracking-tighter text-[#1A1A1A] transition-colors">0</div>
                </div>
                <div class="bg-white rounded-lg border border-emerald-800/20 p-8 shadow-sm text-left hover:shadow-md hover:border-emerald-700/40 transition-all group">
                    <div class="flex items-center gap-2 mb-3">
                        <div class="w-1.5 h-1.5 rounded-full bg-[#059669]"></div>
                        <div class="text-xs font-black uppercase tracking-[0.3em] text-[#059669]/70">Donations</div>
                    </div>
                    <div id="porterDonationCount" class="text-4xl font-black tracking-tighter text-[#1A1A1A] transition-colors">0</div>
                </div>
            </div>

            {{-- Stripe + CTA row --}}
            <div class="w-full max-w-4xl grid grid-cols-1 lg:grid-cols-3 gap-5 mb-12">
                {{-- Stripe card spans 2 cols --}}
                <div class="lg:col-span-2 bg-gradient-to-br from-[#064e3b] to-[#042f24] rounded-lg border border-emerald-300/35 p-8 shadow-md flex flex-col sm:flex-row items-start sm:items-center justify-between gap-6 text-left hover:shadow-lg transition-all relative overflow-hidden">
                    <div class="absolute -top-32 -right-32 w-64 h-64 bg-emerald-400/10 rounded-full blur-[100px]"></div>
                    <div class="relative z-10">
                        <div class="text-xs font-black uppercase tracking-[0.3em] text-emerald-400/60 mb-2">Payout Channel</div>
                        <div id="stripeConnectStatus" class="text-xl font-black tracking-tight text-white">Checking Stripe...</div>
                        <p class="text-xs text-emerald-400/70 font-semibold uppercase tracking-[0.12em] mt-2">Connect Stripe Express to receive payouts.</p>
                    </div>
                    <button id="stripeConnectBtn" class="relative z-10 flex-shrink-0 px-6 py-4 rounded-md bg-[#1A1A1A] text-white text-xs font-black uppercase tracking-[0.3em] hover:bg-black transition-all shadow-sm border border-emerald-300/25">
                        Connect Stripe
                    </button>
                </div>

                {{-- Launch CTA as a card --}}
                <button onclick="openMissionModal()" class="group relative lg:col-span-1 rounded-lg bg-[#fff7ed]/85 backdrop-blur-xl border border-amber-300/80 text-xs font-black uppercase tracking-[0.4em] transition-all shadow-sm overflow-hidden flex items-center justify-center py-8 lg:py-0 hover:shadow-md hover:border-amber-400">
                    <span class="relative z-10 text-[#1A1A1A]">+ Launch Campaign</span>
                </button>
            </div>
        </div>
    </section>

    {{-- Campaigns List --}}
    <section class="relative z-10 px-6 pb-32">
        <div class="max-w-5xl mx-auto">

            <div class="flex items-center justify-between mb-10 border-b border-emerald-900/10 pb-6">
                <div>
                    <h3 class="text-xl font-black text-[#1A1A1A] tracking-tight">My Campaigns</h3>
                    <p class="text-xs font-bold text-[#1A1A1A]/40 uppercase tracking-[0.3em] mt-1">Active portfolio</p>
                </div>
                <div class="flex items-center gap-3">
                    <div class="w-2 h-2 rounded-full bg-[#059669] animate-pulse"></div>
                    <span class="text-xs font-black text-[#059669] uppercase tracking-widest">Live</span>
                </div>
            </div>

            <div class="flex flex-col gap-5" id="myCampaignsList">
                @for($i = 0; $i < 3; $i++)
                <div class="bg-white h-36 rounded-lg border border-emerald-800/20 animate-pulse shadow-sm"></div>
                @endfor
            </div>
        </div>
    </section>

    {{-- Campaign Modal --}}
    <div id="missionModal" class="fixed inset-0 z-[100] hidden opacity-0 transition-all duration-500 flex items-center justify-center p-4 md:p-8">
        <div class="absolute inset-0 bg-[#1A1A1A]/60 backdrop-blur-sm" onclick="closeMissionModal()"></div>

        <div class="relative w-full max-w-6xl bg-white rounded-lg border border-emerald-800/20 shadow-2xl transform transition-all duration-700 translate-y-20 scale-[0.98] opacity-0 overflow-hidden" id="modalContainer">

            {{-- Modal Header --}}
            <div class="relative flex flex-col items-center p-12 lg:p-16 border-b border-emerald-900/10 bg-white text-center">
                <div class="text-xs font-black uppercase tracking-[0.6em] text-[#059669]/60 mb-4">New Campaign</div>
                <h5 class="text-3xl md:text-4xl font-black text-[#1A1A1A] tracking-tighter leading-none">Deploy.</h5>
                <button onclick="closeMissionModal()" class="absolute top-8 right-8 w-10 h-10 rounded-full bg-white hover:bg-gray-50 flex items-center justify-center transition-all border border-emerald-800/20">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-[#1A1A1A] transition-colors" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M6 18L18 6M6 6l12 12"/></svg>
                </button>
            </div>

            {{-- Form --}}
            <div class="max-h-[70vh] overflow-y-auto [&::-webkit-scrollbar]:w-1.5 [&::-webkit-scrollbar-thumb]:bg-emerald-200 bg-white">
                <form id="createCampaignForm" class="grid grid-cols-1 lg:grid-cols-12 font-quicksand">

                    {{-- Left: Narrative --}}
                    <div class="lg:col-span-7 p-10 lg:p-16 space-y-10">
                        <div class="space-y-4">
                            <label class="text-xs font-black text-[#059669] uppercase tracking-[0.4em]">Campaign Title</label>
                            <input type="text" id="cTitle" placeholder="PROJECT LABEL"
                                class="w-full bg-[#064e3b]/5 border-2 border-[#064e3b]/20 rounded-lg outline-none py-5 px-6 text-lg font-black text-[#1A1A1A] placeholder:text-gray-300 focus:border-[#064e3b] focus:bg-white transition-all uppercase tracking-widest shadow-sm">
                        </div>
                        <div class="space-y-4">
                            <label class="text-xs font-black text-[#059669] uppercase tracking-[0.4em]">Description</label>
                            <textarea id="cDesc" placeholder="Describe your campaign..."
                                class="w-full bg-[#064e3b]/5 border-2 border-[#064e3b]/20 rounded-lg outline-none py-5 px-6 text-base font-medium text-[#1A1A1A] placeholder:text-gray-300 focus:border-[#064e3b] focus:bg-white h-48 resize-none leading-relaxed shadow-sm"></textarea>
                        </div>
                    </div>

                    {{-- Right: Config --}}
                    <div class="lg:col-span-5 p-10 lg:p-16 space-y-10 bg-[#064e3b]/5 border-l-2 border-[#064e3b]/20">
                        <div class="space-y-4">
                            <label class="text-xs font-black text-[#059669] uppercase tracking-[0.4em]">Category</label>
                            <select id="cCategory" class="w-full bg-white border-2 border-[#064e3b]/20 rounded-lg outline-none py-5 px-6 text-sm font-black text-[#1A1A1A] focus:border-[#064e3b] transition-all cursor-pointer uppercase tracking-widest shadow-sm">
                                <option value="">Select Category</option>
                            </select>
                        </div>
                        <div class="space-y-4">
                            <label class="text-xs font-black text-[#059669] uppercase tracking-[0.4em]">Target (MAD)</label>
                            <input type="number" id="cTarget" placeholder="0" min="1" max="20000"
                                class="w-full bg-white border-2 border-[#064e3b]/20 rounded-lg outline-none py-5 px-6 text-4xl font-black text-[#064e3b] placeholder:text-gray-200 focus:border-[#064e3b] transition-all tracking-tighter shadow-sm">
                            <p class="text-[10px] font-bold text-[#059669]/60 uppercase tracking-wider ml-1">Maximum: 20,000 MAD</p>
                        </div>
                        <div class="grid grid-cols-2 gap-5">
                            <div class="space-y-4">
                                <label class="text-xs font-black text-[#059669] uppercase tracking-[0.4em]">Start Date</label>
                                <input type="date" id="cStartDate" class="w-full bg-white border-2 border-[#064e3b]/20 rounded-lg outline-none py-4 px-5 text-sm font-black text-[#1A1A1A] focus:border-[#064e3b] transition-all shadow-sm">
                            </div>
                            <div class="space-y-4">
                                <label class="text-xs font-black text-[#059669] uppercase tracking-[0.4em]">End Date</label>
                                <input type="date" id="cEndDate" class="w-full bg-white border-2 border-[#064e3b]/20 rounded-lg outline-none py-4 px-5 text-sm font-black text-[#1A1A1A] focus:border-[#064e3b] transition-all shadow-sm">
                            </div>
                        </div>
                        <div class="space-y-4">
                            <label class="text-xs font-black text-[#059669] uppercase tracking-[0.4em]">Campaign Image</label>
                            <label class="block relative cursor-pointer group">
                                <input type="file" id="cImages" class="absolute inset-0 opacity-0 z-10" accept="image/*">
                                <div class="w-full py-10 border-2 border-dashed border-[#064e3b]/30 rounded-lg flex items-center justify-center transition-all group-hover:border-[#064e3b] bg-white hover:bg-[#064e3b]/5">
                                    <p id="dropText" class="text-xs font-black text-[#059669]/60 uppercase tracking-[0.4em] group-hover:text-[#059669] transition-colors">Upload Image (+)</p>
                                </div>
                            </label>
                        </div>
                    </div>

                    {{-- Actions --}}
                    <div class="lg:col-span-12 p-10 lg:p-16 bg-[#064e3b]/5 border-t-2 border-[#064e3b]/20 flex flex-col items-center gap-8">
                        <div id="galleryPreview" class="h-36 w-56 rounded-lg bg-white border-2 border-[#064e3b]/20 overflow-hidden shadow-sm flex items-center justify-center cursor-pointer hover:border-[#064e3b] transition-all" onclick="document.getElementById('cImages').click()">
                            <span class="text-xs font-black text-gray-200 uppercase tracking-[0.3em]">No Image</span>
                        </div>
                        <button type="submit" id="submitBtn" class="w-full md:w-auto px-20 py-5 bg-[#064e3b] text-white rounded-lg text-xs font-black uppercase tracking-[0.5em] hover:bg-[#053d31] transition-all shadow-sm border-2 border-[#064e3b] hover:border-[#053d31]">
                            Launch Campaign
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
