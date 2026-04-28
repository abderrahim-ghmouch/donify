@extends('layouts.app')

@section('content')

{{-- Porter Campaign Launchpad (Luxury Raja Theme) --}}
<div id="porterCreatePage" class="min-h-screen bg-[#fbf8f6] font-quicksand relative overflow-hidden">
    
    {{-- Atmospheric Green Gradient (Footer based, consistent with profile) --}}
    <div class="absolute inset-x-0 bottom-0 h-[75%] bg-gradient-to-t from-[#064e3b]/55 via-[#064e3b]/15 to-transparent pointer-events-none z-0"></div>

    {{-- Header Section --}}
    <section class="relative pt-32 pb-16 px-8 z-10">
        <div class="max-w-4xl mx-auto text-center md:text-left">
            <div class="inline-block px-4 py-1.5 rounded-full bg-[#1A1A1A] text-white font-black text-[10px] uppercase tracking-widest mb-6">
                Porter Initiative
            </div>
            <h1 class="text-4xl md:text-6xl font-black text-[#1A1A1A] leading-none mb-4 tracking-tighter shadow-sm">Launch Campaign.</h1>
            <p class="text-gray-400 text-xl font-medium tracking-tight">Initiate your vision and start gathering support from our global donor base.</p>
        </div>
    </section>

    {{-- Campaign Form Registry --}}
    <div class="max-w-4xl mx-auto px-8 pb-32 relative z-10">
        
        <div class="bg-transparent p-0">
            <div class="flex items-center justify-between mb-12 border-b border-black/5 pb-8">
                <div>
                    <h2 class="text-2xl font-black text-[#1A1A1A] mb-1 tracking-tight italic">Mission Details.</h2>
                    <p class="text-[10px] text-gray-400 font-bold uppercase tracking-widest">Define your impact and contribution strategy</p>
                </div>
                <div id="launchSuccess" class="hidden px-5 py-2 bg-emerald-50 text-emerald-600 rounded-xl text-[9px] font-black uppercase tracking-widest border border-emerald-100 italic">Campaign Initiated</div>
            </div>

            <form id="createCampaignForm" class="space-y-12">
                {{-- Title & Category --}}
                <div class="grid grid-cols-1 md:grid-cols-2 gap-10">
                    <div class="md:col-span-2">
                        <label class="block text-[10px] font-black uppercase tracking-[0.2em] text-[#1A1A1A] mb-4 ml-2">Campaign Heading</label>
                        <input type="text" id="cTitle" required class="w-full px-8 py-6 rounded-2xl bg-gray-100/50 border-2 border-gray-200 outline-none focus:border-[#064e3b] focus:ring-4 focus:ring-[#064e3b]/5 transition-all text-base font-semibold text-[#1A1A1A] placeholder-gray-300" placeholder="e.g. Sustainable Water Solutions in Rif">
                    </div>
                    <div>
                        <label class="block text-[10px] font-black uppercase tracking-[0.2em] text-[#1A1A1A] mb-4 ml-2">Strategic Category</label>
                        <select id="cCategory" required class="w-full px-8 py-6 rounded-2xl bg-gray-100/50 border-2 border-gray-200 outline-none focus:border-[#064e3b] focus:ring-4 focus:ring-[#064e3b]/5 transition-all text-base font-semibold text-[#1A1A1A] appearance-none cursor-pointer">
                            <option value="">Select Category...</option>
                        </select>
                    </div>
                    <div>
                        <label class="block text-[10px] font-black uppercase tracking-[0.2em] text-[#1A1A1A] mb-4 ml-2">Target Goal (MAD)</label>
                        <input type="number" id="cTarget" required class="w-full px-8 py-6 rounded-2xl bg-gray-100/50 border-2 border-gray-200 outline-none focus:border-[#064e3b] focus:ring-4 focus:ring-[#064e3b]/5 transition-all text-base font-semibold text-[#1A1A1A] placeholder-gray-300" placeholder="e.g. 50000">
                    </div>
                </div>

                {{-- Description --}}
                <div>
                    <label class="block text-[10px] font-black uppercase tracking-[0.2em] text-[#1A1A1A] mb-4 ml-2">Mission Narrative</label>
                    <textarea id="cDesc" required class="w-full px-8 py-6 rounded-3xl bg-gray-100/50 border-2 border-gray-200 outline-none focus:border-[#064e3b] focus:ring-4 focus:ring-[#064e3b]/5 transition-all text-base font-semibold text-[#1A1A1A] placeholder-gray-300 min-h-[200px]" placeholder="Tell the story of your campaign, the impact it will have, and why supporters should join your mission..."></textarea>
                </div>

                {{-- Dates and Image --}}
                <div class="grid grid-cols-1 md:grid-cols-2 gap-10">
                    <div>
                        <label class="block text-[10px] font-black uppercase tracking-[0.2em] text-[#1A1A1A] mb-4 ml-2">Mission Commencement</label>
                        <input type="date" id="cStartDate" class="w-full px-8 py-6 rounded-2xl bg-gray-100/50 border-2 border-gray-200 outline-none focus:border-[#064e3b] focus:ring-4 focus:ring-[#064e3b]/5 transition-all text-base font-semibold text-[#1A1A1A]">
                    </div>
                    <div>
                        <label class="block text-[10px] font-black uppercase tracking-[0.2em] text-[#1A1A1A] mb-4 ml-2">Mission Conclusion</label>
                        <input type="date" id="cEndDate" class="w-full px-8 py-6 rounded-2xl bg-gray-100/50 border-2 border-gray-200 outline-none focus:border-[#064e3b] focus:ring-4 focus:ring-[#064e3b]/5 transition-all text-base font-semibold text-[#1A1A1A]">
                    </div>
                </div>

                {{-- Image Dropzone (Ghost Style) --}}
                <div>
                    <label class="block text-[10px] font-black uppercase tracking-[0.2em] text-[#1A1A1A] mb-4 ml-2">Visual Identity (Cover)</label>
                    <div id="dropZone" class="relative group cursor-pointer">
                        <input type="file" id="cImage" accept="image/*" class="absolute inset-0 w-full h-full opacity-0 z-20 cursor-pointer">
                        <div class="w-full py-16 px-8 rounded-3xl bg-white/40 backdrop-blur-md border-2 border-dashed border-gray-200 group-hover:border-[#064e3b] transition-all text-center">
                            <div id="dropInitial">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-10 w-10 text-gray-300 mx-auto mb-4 group-hover:text-[#064e3b] transition-colors" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                </svg>
                                <p class="text-sm font-bold text-[#1A1A1A] uppercase tracking-widest">Deploy Campaign Media</p>
                                <p class="text-[10px] text-gray-400 font-medium mt-1">Select or drag & drop high-resolution visual</p>
                            </div>
                            <img id="dropPreview" class="hidden max-h-48 mx-auto rounded-xl shadow-xl border-4 border-white" alt="Preview">
                        </div>
                    </div>
                </div>

                {{-- Action Area --}}
                <div class="pt-10 flex flex-col md:flex-row items-center justify-between gap-8 border-t border-black/5">
                    <p class="text-[11px] text-gray-400 font-medium max-w-md italic leading-relaxed">By initiating this campaign, you commit to transparent reporting and fund allocation as per the Donify Porter Agreement.</p>
                    <div class="flex items-center gap-6">
                        <button type="button" onclick="window.location.href='/dashboard'" class="text-[10px] font-black uppercase tracking-widest text-gray-400 hover:text-[#1A1A1A] transition-colors">Abort</button>
                        <button type="submit" id="submitBtn" class="px-12 py-6 bg-[#064e3b] text-[#1A1A1A] border-2 border-[#1A1A1A] rounded-xl font-black uppercase tracking-widest text-[11px] transition-all transform hover:-translate-y-1 hover:bg-[#1A1A1A] hover:text-[#064e3b] shadow-2xl italic cursor-pointer active:scale-95">Verify & Launch Mission</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
