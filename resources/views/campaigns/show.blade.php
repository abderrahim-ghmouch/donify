@extends('layouts.app')

@section('content')
{{-- Campaign Intelligence Console (Luxury Raja Theme) --}}
<div class="min-h-screen bg-[#fbf8f6] font-quicksand relative overflow-hidden">
    
    {{-- Atmospheric Green Gradient (Footer based) --}}
    <div class="absolute inset-x-0 bottom-0 h-[80%] bg-gradient-to-t from-[#064e3b]/40 via-[#064e3b]/10 to-transparent pointer-events-none z-0"></div>

    {{-- Header Section: Visual Identity --}}
    <section class="relative pt-32 pb-20 px-8 z-10 transition-all duration-700">
        <div class="max-w-7xl mx-auto">
            {{-- Breadcrumbs / Meta --}}
            <div class="flex flex-wrap items-center gap-4 mb-8">
                <a href="/campaigns" class="text-[10px] font-black uppercase tracking-[0.2em] text-gray-400 hover:text-[#1A1A1A] transition-colors">Campaigns</a>
                <span class="text-gray-300 text-[10px]">/</span>
                <span class="text-[10px] font-black uppercase tracking-[0.2em] text-[#064e3b]">{{ $campaign->category->name ?? 'Visionary' }}</span>
                <div class="px-3 py-1 rounded-full bg-black text-[#059669] text-[8px] font-black uppercase tracking-widest ml-auto border border-[#059669]/20">
                    Mission: Active
                </div>
            </div>

            {{-- Main Title --}}
            <h1 class="text-4xl md:text-7xl font-black text-[#1A1A1A] leading-[1.1] mb-8 tracking-tighter">
                {{ $campaign->title }}.
            </h1>

            {{-- Porter Identity --}}
            <div class="flex items-center gap-4 border-t border-black/5 pt-8">
                <div class="w-12 h-12 rounded-full bg-gray-200 flex items-center justify-center overflow-hidden border-2 border-white shadow-xl">
                    <img src="https://ui-avatars.com/api/?name={{ urlencode($campaign->user->name) }}&background=064e3b&color=fff" alt="Porter">
                </div>
                <div>
                    <p class="text-[10px] text-gray-400 font-bold uppercase tracking-widest italic">Initiated by</p>
                    <h3 class="text-sm font-black text-[#1A1A1A]">{{ $campaign->user->name }}</h3>
                </div>
            </div>
        </div>
    </section>

    {{-- Main Operation Area --}}
    <section class="relative z-10 px-8 pb-32">
        <div class="max-w-7xl mx-auto flex flex-col md:flex-row gap-16">
            
            {{-- Left: Mission Narrative --}}
            <div class="flex-1 space-y-12">
                {{-- Cover Image --}}
                <div class="rounded-[2.5rem] overflow-hidden shadow-2xl bg-gray-100 group">
                    @if($campaign->images && count($campaign->images) > 0)
                        <img src="{{ $campaign->images[0]->url }}" class="w-full h-auto object-cover min-h-[400px] group-hover:scale-105 transition-transform duration-1000" alt="Campaign Identity">
                    @else
                        <div class="w-full h-[500px] flex items-center justify-center bg-gradient-to-br from-gray-50 to-gray-200">
                             <svg xmlns="http://www.w3.org/2000/svg" class="h-20 w-20 text-gray-300" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                            </svg>
                        </div>
                    @endif
                </div>

                {{-- The Story --}}
                <div class="prose prose-xl prose-stone max-w-none bg-white/40 backdrop-blur-xl p-12 rounded-[2.5rem] border border-black/5 shadow-sm">
                    <h2 class="text-2xl font-black text-[#1A1A1A] mb-8 tracking-tight italic">Mission Narrative.</h2>
                    <div class="text-gray-600 font-medium leading-relaxed whitespace-pre-line text-lg">
                        {{ $campaign->description }}
                    </div>
                </div>

                {{-- Impact Stats --}}
                <div class="grid grid-cols-2 md:grid-cols-4 gap-8">
                    <div class="bg-black p-8 rounded-3xl group hover:bg-[#064e3b] transition-all duration-500 transform hover:-translate-y-2">
                        <h4 class="text-[#059669] text-[10px] font-black uppercase tracking-widest mb-2 group-hover:text-white">Backers</h4>
                        <p class="text-white text-3xl font-black">{{ $campaign->donations->count() }}</p>
                    </div>
                    <div class="bg-white p-8 rounded-3xl border border-black/5 shadow-sm hover:shadow-xl transition-all duration-500 transform hover:-translate-y-2">
                        <h4 class="text-gray-400 text-[10px] font-black uppercase tracking-widest mb-2">Category</h4>
                        <p class="text-[#1A1A1A] text-lg font-black tracking-tighter">{{ $campaign->category->name ?? 'General' }}</p>
                    </div>
                    <div class="bg-white p-8 rounded-3xl border border-black/5 shadow-sm hover:shadow-xl transition-all duration-500 transform hover:-translate-y-2">
                        <h4 class="text-gray-400 text-[10px] font-black uppercase tracking-widest mb-2">Status</h4>
                        <p class="text-[#1A1A1A] text-lg font-black tracking-tighter italic">{{ ucfirst($campaign->status) }}</p>
                    </div>
                    <div class="bg-white p-8 rounded-3xl border border-black/5 shadow-sm hover:shadow-xl transition-all duration-500 transform hover:-translate-y-2">
                        <h4 class="text-gray-400 text-[10px] font-black uppercase tracking-widest mb-2">Conclusion</h4>
                        <p class="text-[#1A1A1A] text-lg font-black tracking-tighter">{{ $campaign->end_date ? \Carbon\Carbon::parse($campaign->end_date)->format('M d, Y') : 'Infinite' }}</p>
                    </div>
                </div>
            </div>

            {{-- Right: Donation Hub (Sticky) --}}
            <div class="w-full md:w-[400px]">
                <div class="sticky top-12">
                    <div class="bg-[#064e3b] p-10 rounded-[2.5rem] shadow-2xl border-4 border-black group relative overflow-hidden">
                        {{-- Background Accent --}}
                        <div class="absolute -top-20 -right-20 w-40 h-40 bg-white/5 rounded-full blur-3xl group-hover:bg-white/10 transition-all"></div>
                        
                        {{-- Progress Info --}}
                        <div class="relative z-10">
                            <h3 class="text-white text-[10px] font-black uppercase tracking-[0.3em] mb-12 italic border-b border-white/10 pb-4">Funding Status</h3>
                            
                            <div class="mb-10">
                                <div class="flex items-baseline gap-2 text-white mb-2">
                                    <span class="text-5xl font-black italic tracking-tighter" id="currentAmountDisplay">${{ number_format($campaign->current_amount) }}</span>
                                </div>
                                <p class="text-[#059669] text-sm font-bold tracking-tight">Gathered of ${{ number_format($campaign->target_amount) }} target</p>
                            </div>

                            {{-- Progress Bar --}}
                            @php
                                $percentage = min(100, ($campaign->current_amount / max(1, $campaign->target_amount)) * 100);
                            @endphp
                            <div class="w-full h-4 bg-black/40 rounded-full mb-4 overflow-hidden border border-white/5">
                                <div class="h-full bg-gradient-to-r from-emerald-500 to-emerald-300 rounded-full shadow-[0_0_20px_rgba(16,185,129,0.5)] transition-all duration-1000" style="width: {{ $percentage }}%"></div>
                            </div>
                            <div class="flex justify-between text-white text-[10px] font-black uppercase tracking-widest mb-16 px-1">
                                <span>{{ number_format($percentage, 1) }}% Funded</span>
                                <span>{{ $campaign->end_date ? \Carbon\Carbon::parse($campaign->end_date)->diffForHumans() : 'Active' }}</span>
                            </div>

                            {{-- Pledge Form --}}
                            <div class="space-y-6">
                                <div class="relative">
                                    <span class="absolute left-6 top-1/2 -translate-y-1/2 text-[#1A1A1A] font-black text-xl">$</span>
                                    <input type="number" id="donationAmount" placeholder="Enter amount" class="w-full bg-[#fbf8f6] border-2 border-black rounded-2xl py-6 pl-12 pr-8 text-black font-black text-xl outline-none focus:ring-4 focus:ring-emerald-500/20 transition-all placeholder-gray-300">
                                </div>
                                <button id="donateBtn" class="w-full bg-[#1A1A1A] text-[#059669] border-2 border-[#1A1A1A] hover:bg-black hover:text-white rounded-2xl py-6 font-black uppercase tracking-widest text-xs transition-all shadow-xl italic cursor-pointer transform hover:-translate-y-1 active:scale-95">
                                    Pledge Support
                                </button>
                                <p id="donationMessage" class="hidden text-center text-[10px] font-black uppercase tracking-widest text-emerald-400 animate-pulse mt-4"></p>
                            </div>
                        </div>
                    </div>

                    {{-- Social Trust --}}
                    <div class="mt-8 px-6 text-center">
                        <p class="text-gray-400 text-[10px] font-bold uppercase tracking-widest leading-relaxed">
                            Verified Porter System. <br> Every contribution is tracked & secure.
                        </p>
                    </div>
                </div>
            </div>

        </div>
    </section>
</div>

<script src="{{ asset('js/api-client.js') }}"></script>
<script>
document.addEventListener('DOMContentLoaded', () => {
    const donateBtn = document.getElementById('donateBtn');
    const amountInput = document.getElementById('donationAmount');
    const msg = document.getElementById('donationMessage');
    const campaignId = "{{ $campaign->id }}";

    donateBtn.addEventListener('click', async () => {
        if (!ApiClient.isAuthenticated()) {
            window.location.href = '/login';
            return;
        }

        const amount = amountInput.value;
        if (!amount || amount <= 0) {
            alert('Please enter a valid amount.');
            return;
        }

        donateBtn.disabled = true;
        donateBtn.innerHTML = 'Processing Pledge...';
        msg.classList.add('hidden');

        try {
            const res = await ApiClient.request(`/campaigns/${campaignId}/donate`, {
                method: 'POST',
                body: JSON.stringify({ amount: amount })
            });

            msg.textContent = 'Mission Supported. Thank You.';
            msg.classList.remove('hidden');
            
            // Animation Update
            setTimeout(() => {
                 window.location.reload();
            }, 1000);

        } catch (err) {
            alert(err.message || 'Donation failed. Please check your credentials.');
            donateBtn.disabled = false;
            donateBtn.innerHTML = 'Pledge Support';
        }
    });

    // Preset amounts logic (Optional enhancement)
    amountInput.addEventListener('keypress', (e) => {
        if(e.key === 'Enter') donateBtn.click();
    });
});
</script>
@endsection
