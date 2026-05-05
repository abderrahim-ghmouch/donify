@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-[#fbf8f6] font-['Nunito'] relative overflow-hidden">

    {{-- Atmospheric blobs --}}
    <div class="fixed inset-0 pointer-events-none overflow-hidden z-0">
        <div class="absolute inset-x-0 bottom-0 h-full bg-gradient-to-t from-[#064e3b]/25 via-[#064e3b]/5 to-transparent"></div>
        <div class="absolute top-1/4 left-1/4 w-[500px] h-[500px] bg-emerald-400/40 rounded-full blur-[150px]"></div>
        <div class="absolute bottom-1/3 right-1/4 w-[450px] h-[450px] bg-emerald-500/35 rounded-full blur-[130px]"></div>
        <div class="absolute top-1/2 right-1/3 w-[400px] h-[400px] bg-emerald-300/30 rounded-full blur-[140px]"></div>
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
                        <div id="stripeConnectStatus" class="text-xl font-black tracking-tight text-white">Checking Stripe</div>
                        <p class="text-xs text-emerald-400/70 font-semibold uppercase tracking-[0.12em] mt-2">Connect Stripe to receive payouts</p>
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

        <div class="relative w-full max-w-2xl bg-white rounded-lg border border-emerald-800/20 shadow-2xl transform transition-all duration-700 translate-y-20 scale-[0.98] opacity-0 overflow-hidden" id="modalContainer">

            {{-- Modal Header --}}
            <div class="relative flex flex-col items-center p-6 border-b border-emerald-900/10 bg-white text-center">
                <div class="text-[10px] font-bold uppercase tracking-wider text-[#059669]/60 mb-2">New Campaign</div>
                <h5 class="text-2xl font-bold text-[#1A1A1A] tracking-tight leading-none">Launch Campaign</h5>
                <button onclick="closeMissionModal()" class="absolute top-4 right-4 w-8 h-8 rounded-md bg-white hover:bg-gray-50 flex items-center justify-center transition-all border border-emerald-800/20">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-[#1A1A1A] transition-colors" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M6 18L18 6M6 6l12 12"/></svg>
                </button>
            </div>

            {{-- Form --}}
            <div class="max-h-[70vh] overflow-y-auto [&::-webkit-scrollbar]:w-1.5 [&::-webkit-scrollbar-thumb]:bg-emerald-200 bg-white">
                <form id="createCampaignForm" class="font-['Nunito'] p-6 space-y-5">

                    {{-- Campaign Title --}}
                    <div class="space-y-2">
                        <label class="text-[10px] font-bold text-[#059669] uppercase tracking-wider">Campaign Title</label>
                        <input type="text" id="cTitle" placeholder="My Amazing Campaign"
                            class="w-full bg-[#064e3b]/5 border border-[#064e3b]/20 rounded-md outline-none py-3 px-4 text-sm font-medium text-[#1A1A1A] placeholder:text-gray-300 focus:border-[#064e3b] focus:bg-white transition-all">
                    </div>

                    {{-- Description --}}
                    <div class="space-y-2">
                        <label class="text-[10px] font-bold text-[#059669] uppercase tracking-wider">Description</label>
                        <textarea id="cDesc" placeholder="Tell your story..."
                            class="w-full bg-[#064e3b]/5 border border-[#064e3b]/20 rounded-md outline-none py-3 px-4 text-sm font-medium text-[#1A1A1A] placeholder:text-gray-300 focus:border-[#064e3b] focus:bg-white h-28 resize-none leading-relaxed"></textarea>
                    </div>

                    {{-- Category & Target --}}
                    <div class="grid grid-cols-2 gap-4">
                        <div class="space-y-2">
                            <label class="text-[10px] font-bold text-[#059669] uppercase tracking-wider">Category</label>
                            <select id="cCategory" class="w-full bg-white border border-[#064e3b]/20 rounded-md outline-none py-3 px-4 text-sm font-medium text-[#1A1A1A] focus:border-[#064e3b] transition-all cursor-pointer">
                                <option value="">Select Category</option>
                            </select>
                        </div>
                        <div class="space-y-2">
                            <label class="text-[10px] font-bold text-[#059669] uppercase tracking-wider">Target (MAD)</label>
                            <input type="number" id="cTarget" placeholder="5000" min="1" max="20000"
                                class="w-full bg-white border border-[#064e3b]/20 rounded-md outline-none py-3 px-4 text-lg font-bold text-[#064e3b] placeholder:text-gray-200 focus:border-[#064e3b] transition-all">
                        </div>
                    </div>

                    {{-- Dates --}}
                    <div class="grid grid-cols-2 gap-4">
                        <div class="space-y-2">
                            <label class="text-[10px] font-bold text-[#059669] uppercase tracking-wider">Start Date</label>
                            <input type="date" id="cStartDate" class="w-full bg-white border border-[#064e3b]/20 rounded-md outline-none py-3 px-4 text-xs font-medium text-[#1A1A1A] focus:border-[#064e3b] transition-all">
                        </div>
                        <div class="space-y-2">
                            <label class="text-[10px] font-bold text-[#059669] uppercase tracking-wider">End Date</label>
                            <input type="date" id="cEndDate" class="w-full bg-white border border-[#064e3b]/20 rounded-md outline-none py-3 px-4 text-xs font-medium text-[#1A1A1A] focus:border-[#064e3b] transition-all">
                        </div>
                    </div>

                    {{-- Image Upload --}}
                    <div class="space-y-2">
                        <label class="text-[10px] font-bold text-[#059669] uppercase tracking-wider">Campaign Image</label>
                        <label class="block relative cursor-pointer group">
                            <input type="file" id="cImages" class="absolute inset-0 opacity-0 z-10" accept="image/*">
                            <div class="w-full py-6 border-2 border-dashed border-[#064e3b]/30 rounded-md flex items-center justify-center transition-all group-hover:border-[#064e3b] bg-white hover:bg-[#064e3b]/5">
                                <p id="dropText" class="text-xs font-medium text-[#059669]/60 group-hover:text-[#059669] transition-colors">Click to upload image</p>
                            </div>
                        </label>
                    </div>

                    {{-- Preview & Submit --}}
                    <div class="space-y-4 pt-2">
                        <div id="galleryPreview" class="h-32 w-full rounded-md bg-[#064e3b]/5 border border-[#064e3b]/20 overflow-hidden flex items-center justify-center cursor-pointer hover:border-[#064e3b] transition-all" onclick="document.getElementById('cImages').click()">
                            <span class="text-xs font-medium text-gray-300">No image selected</span>
                        </div>
                        <button type="submit" id="submitBtn" class="w-full py-3 bg-[#064e3b] text-white rounded-md text-xs font-bold uppercase tracking-wider hover:bg-[#053d31] transition-all shadow-sm">
                            Launch Campaign
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
