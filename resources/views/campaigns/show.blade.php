@extends('layouts.app')

@section('content')
{{-- Campaign Intelligence Console (Luxury Raja Theme) --}}
<div class="min-h-screen bg-[#fbf8f6] font-quicksand relative overflow-hidden">
    
    {{-- Atmospheric Green Gradient (Footer based) --}}
    <div class="absolute inset-x-0 bottom-0 h-[80%] bg-gradient-to-t from-[#064e3b]/40 via-[#064e3b]/10 to-transparent pointer-events-none z-0"></div>

    {{-- Header Section: Visual Identity --}}
    <section class="relative pt-24 pb-12 px-8 z-10 transition-all duration-700">
        <div class="max-w-7xl mx-auto">
            {{-- Breadcrumbs / Meta --}}
            <div class="flex flex-wrap items-center gap-4 mb-10">
                <a href="/campaigns" class="text-[10px] font-black uppercase tracking-[0.4em] text-gray-400 hover:text-[#1A1A1A] transition-colors">Hall</a>
                <span class="text-gray-300 text-[10px]">/</span>
                <span class="text-[10px] font-black uppercase tracking-[0.4em] text-[#059669]">{{ $campaign->category->name ?? 'Visionary' }}</span>
                <div class="px-5 py-2 rounded-xl bg-black/90 backdrop-blur-md text-[#059669] text-[9px] font-black uppercase tracking-widest ml-auto border border-[#059669]/30 shadow-xl">
                    Mission Status: {{ strtoupper($campaign->status) }}
                </div>
            </div>

            {{-- Main Title --}}
            <h1 class="text-4xl md:text-7xl font-black text-[#1A1A1A] leading-[1.05] mb-12 tracking-tighter">
                {{ $campaign->title }}.
            </h1>

            {{-- Porter Identity --}}
            <div class="flex items-center gap-5 border-t border-black/[0.03] pt-12">
                <div class="w-16 h-16 rounded-xl bg-white border-2 border-black/5 p-1 shadow-2xl relative overflow-hidden group">
                    <img class="w-full h-full object-cover rounded-lg group-hover:scale-110 transition-transform duration-700" src="https://ui-avatars.com/api/?name={{ urlencode($campaign->user->name) }}&background=064e3b&color=fff" alt="Lead">
                </div>
                <div>
                    <span class="text-[9px] font-black text-[#059669] uppercase tracking-[0.3em] block mb-1 italic">Mission Lead:</span>
                    <h3 class="text-lg font-black text-[#1A1A1A] uppercase tracking-wider italic underline decoration-[#059669]/20 underline-offset-8">{{ $campaign->user->name }}</h3>
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
                <div class="rounded-xl overflow-hidden shadow-2xl bg-white border border-black/5 group">
                    @if($campaign->images && count($campaign->images) > 0)
                        <img src="{{ $campaign->images[0]->url }}" class="w-full h-auto object-cover min-h-[500px] group-hover:scale-110 transition-transform duration-1000" alt="Identity">
                    @else
                        <div class="w-full h-[500px] flex items-center justify-center bg-gray-50 uppercase font-black text-gray-200 tracking-tighter text-4xl">No Image Asset</div>
                    @endif
                </div>

                {{-- The Story --}}
                <div class="prose prose-stone max-w-none bg-[#fbf8f6] p-12 rounded-xl border-2 border-black/5 shadow-inner">
                    <h2 class="text-2xl font-black text-[#1A1A1A] mb-10 tracking-[0.4em] uppercase underline decoration-[#059669] decoration-4 underline-offset-8">Mission Narrative.</h2>
                    <div class="text-black font-medium leading-relaxed whitespace-pre-line text-lg opacity-80">
                        {{ $campaign->description }}
                    </div>
                </div>

                {{-- Impact Stats --}}
                <div class="grid grid-cols-2 md:grid-cols-4 gap-6">
                    <div class="bg-black p-8 rounded-xl group transition-all duration-500 shadow-xl border-2 border-black">
                        <h4 class="text-[#059669] text-[9px] font-black uppercase tracking-widest mb-4">Backers</h4>
                        <p class="text-white text-4xl font-black tracking-tighter">{{ $campaign->donations->count() }}</p>
                    </div>
                    <div class="bg-white p-8 rounded-xl border-2 border-black/5 shadow-sm transition-all hover:bg-[#fbf8f6]">
                        <h4 class="text-gray-400 text-[9px] font-black uppercase tracking-widest mb-4">Sector</h4>
                        <p class="text-[#1A1A1A] text-xl font-black tracking-tighter uppercase">{{ $campaign->category->name ?? 'Vision' }}</p>
                    </div>
                    <div class="bg-white p-8 rounded-xl border-2 border-black/5 shadow-sm transition-all hover:bg-[#fbf8f6]">
                        <h4 class="text-gray-400 text-[9px] font-black uppercase tracking-widest mb-4">Phase</h4>
                        <p class="text-[#1A1A1A] text-xl font-black tracking-tighter uppercase italic">{{ $campaign->status }}</p>
                    </div>
                    <div class="bg-white p-8 rounded-xl border-2 border-black/5 shadow-sm transition-all hover:bg-[#fbf8f6]">
                        <h4 class="text-gray-400 text-[9px] font-black uppercase tracking-widest mb-4">Horizon</h4>
                        <p class="text-[#1A1A1A] text-xl font-black tracking-tighter uppercase">{{ $campaign->end_date ? \Carbon\Carbon::parse($campaign->end_date)->format('M d') : 'Open' }}</p>
                    </div>
                </div>
            </div>

            {{-- Right: Donation Hub (Sticky) --}}
            <div class="w-full md:w-[420px]">
                <div class="sticky top-12">
                    <div class="bg-[#064e3b] p-12 rounded-xl shadow-2xl border-2 border-black group relative overflow-hidden">
                        {{-- Background Accent --}}
                        <div class="absolute -top-20 -right-20 w-40 h-40 bg-white/5 rounded-full blur-3xl group-hover:bg-white/10 transition-all"></div>
                        
                        {{-- Progress Info --}}
                        <div class="relative z-10">
                            <h3 class="text-white text-[10px] font-black uppercase tracking-[0.5em] mb-12 italic border-b-2 border-white/10 pb-4">Funding Protocol</h3>
                            
                            <div class="mb-12">
                                <div class="flex items-baseline gap-2 text-white mb-2">
                                    <span class="text-6xl font-black italic tracking-tighter" id="currentAmountDisplay">${{ number_format($campaign->current_amount) }}</span>
                                </div>
                                <p class="text-emerald-400 text-[10px] font-black uppercase tracking-widest">Gathered of ${{ number_format($campaign->target_amount) }} Goal</p>
                            </div>

                            {{-- Progress Bar --}}
                            @php
                                $percentage = min(100, ($campaign->current_amount / max(1, $campaign->target_amount)) * 100);
                            @endphp
                            <div class="w-full h-3 bg-black rounded-full mb-4 overflow-hidden border border-white/10">
                                <div class="h-full bg-emerald-500 rounded-full transition-all duration-1000" style="width: {{ $percentage }}%"></div>
                            </div>
                            <div class="flex justify-between text-white text-[10px] font-black uppercase tracking-widest mb-16 px-1">
                                <span>{{ number_format($percentage, 1) }}% Efficiency</span>
                                <span class="italic text-emerald-400">{{ $campaign->end_date ? \Carbon\Carbon::parse($campaign->end_date)->diffForHumans() : 'Live' }}</span>
                            </div>

                            {{-- Pledge Form --}}
                            <div class="space-y-4">
                                <div class="space-y-4">
                                    <label class="text-[10px] font-black text-white/40 uppercase tracking-widest ml-1 leading-none">Investment Amount</label>
                                    <div class="relative">
                                        <span class="absolute left-6 top-1/2 -translate-y-1/2 text-black font-black text-xl">$</span>
                                        <input type="number" id="donationAmount" placeholder="0.00" class="w-full bg-[#fbf8f6] border-2 border-black rounded-xl py-6 pl-12 pr-8 text-black font-black text-2xl outline-none focus:bg-white transition-all placeholder:text-black/10">
                                    </div>
                                </div>
                                <button id="donateBtn" class="w-full bg-black text-white hover:bg-zinc-800 rounded-xl py-7 font-black uppercase tracking-[0.4em] text-[10px] transition-all shadow-2xl active:scale-95 mt-4">
                                    Initialize Support Protocol →
                                </button>
                                <p id="donationMessage" class="hidden text-center text-[10px] font-black uppercase tracking-widest text-emerald-400 animate-pulse mt-6"></p>
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
