@extends('layouts.app')

@section('content')
<!-- Hero Section -->
<section class="relative min-h-[90vh] flex items-center justify-center overflow-hidden px-6 pt-20 bg-[#fbf8f6] font-['Quicksand']">
    <div class="max-w-5xl mx-auto w-full relative z-10 text-center">
        <div class="animate-fade-in">
        
            <h1 class="text-6xl md:text-8xl font-extrabold text-gray-800 leading-[1.1] mb-8 tracking-tight">
                Amplify Impact. <br><span class="text-[#02a95c]">Empower Change.</span>
            </h1>
            
            <p class="text-lg text-gray-600 mb-12 leading-relaxed max-w-2xl mx-auto font-medium">
                The world's most trusted gateway for meaningful giving. <br class="hidden md:block"> Join a global network of changemakers and verified organizations today.
            </p>
            
            <div class="flex flex-col sm:flex-row gap-5 justify-center items-center">
                <a href="{{ route('campaigns.index') }}" class="w-full sm:w-auto bg-[#02a95c] text-white px-10 py-4 rounded-full font-bold text-lg text-center shadow-lg shadow-[#02a95c]/30 hover:bg-[#028b4c] hover:scale-105 transition-all">
                    Explore Campaigns
                </a>
                <a href="{{ route('organisations.register') }}" class="w-full sm:w-auto bg-white text-gray-800 px-10 py-4 rounded-full font-bold text-lg text-center border-2 border-gray-200 hover:border-[#02a95c] hover:text-[#02a95c] transition-all flex items-center justify-center gap-2">
                    Start as Organisation
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-[#02a95c]" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M10.293 3.293a1 1 0 011.414 0l6 6a1 1 0 010 1.414l-6 6a1 1 0 01-1.414-1.414L14.586 11H3a1 1 0 110-2h11.586l-4.293-4.293a1 1 0 010-1.414z" clip-rule="evenodd" />
                    </svg>
                </a>
            </div>
            
            <div class="mt-20 pt-10 border-t border-gray-200 flex flex-wrap justify-center gap-8 opacity-50 grayscale hover:grayscale-0 transition-all">
                <span class="font-bold text-xl tracking-tight text-gray-400">TRUSTED</span>
                <span class="font-bold text-xl tracking-tight text-gray-400">SECURE</span>
                <span class="font-bold text-xl tracking-tight text-gray-400">IMPACTFUL</span>
                <span class="font-bold text-xl tracking-tight text-gray-400">GLOBAL</span>
            </div>
        </div>
    </div>
</section>  

<!-- Stats Section -->
<section class="py-20 px-6 bg-white">
    <div class="max-w-7xl mx-auto grid grid-cols-2 md:grid-cols-4 gap-8">
        <div class="text-center animate-fade-in delay-100">
            <h3 class="text-4xl font-bold text-emerald-600 mb-2 font-outfit">$24M+</h3>
            <p class="text-gray-500 font-medium tracking-wide uppercase text-xs">Total Raised</p>
        </div>
        <div class="text-center animate-fade-in delay-200">
            <h3 class="text-4xl font-bold text-emerald-600 mb-2 font-outfit">1,500</h3>
            <p class="text-gray-500 font-medium tracking-wide uppercase text-xs">Active Campaigns</p>
        </div>
        <div class="text-center animate-fade-in delay-300">
            <h3 class="text-4xl font-bold text-emerald-600 mb-2 font-outfit">850</h3>
            <p class="text-gray-500 font-medium tracking-wide uppercase text-xs">Organizations</p>
        </div>
        <div class="text-center animate-fade-in">
            <h3 class="text-4xl font-bold text-emerald-600 mb-2 font-outfit">12K+</h3>
            <p class="text-gray-500 font-medium tracking-wide uppercase text-xs">Happy Donors</p>
        </div>
    </div>
</section>

<!-- Featured Campaigns -->
<section class="py-24 px-6 bg-slate-50">
    <div class="max-w-7xl mx-auto">
        <div class="flex flex-col md:flex-row justify-between items-end mb-12 gap-6">
            <div class="max-w-xl">
                <h2 class="text-4xl font-bold font-outfit mb-4">Urgent Fundraising</h2>
                <p class="text-gray-500 text-lg">These campaigns are close to reaching their goals. A small contribution could push them over the finish line.</p>
            </div>
            <a href="{{ route('campaigns.index') }}" class="text-emerald-600 font-bold hover:text-emerald-700 flex items-center space-x-2 transition-all">
                <span>View All Campaigns</span>
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd" d="M12.293 5.293a1 1 0 011.414 0l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414-1.414L14.586 11H3a1 1 0 110-2h11.586l-3.293-3.293a1 1 0 010-1.414z" clip-rule="evenodd" />
                </svg>
            </a>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
            @forelse($featuredCampaigns as $campaign)
                <div class="bg-white rounded-3xl overflow-hidden shadow-lg group hover:shadow-2xl transition-all duration-300 border border-gray-100 flex flex-col">
                    <div class="relative h-56 overflow-hidden">
                        @if($campaign->images->first())
                            <img src="{{ $campaign->images->first()->url }}" alt="{{ $campaign->title }}" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500">
                        @else
                            <img src="{{ asset('images/campaign_placeholder.png') }}" alt="{{ $campaign->title }}" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500">
                        @endif
                        <div class="absolute top-4 left-4 bg-white/90 backdrop-blur px-3 py-1 rounded-full text-xs font-bold text-emerald-600 shadow-sm border border-emerald-100/50">
                            {{ $campaign->category->name ?? 'General' }}
                        </div>
                    </div>
                    
                    <div class="p-8 flex flex-col flex-grow">
                        <h3 class="text-xl font-bold mb-3 font-outfit line-clamp-1 h-7 group-hover:text-emerald-600 transition-colors">
                            {{ $campaign->title }}
                        </h3>
                        <p class="text-gray-500 text-sm mb-6 line-clamp-2 leading-relaxed">
                            {{ $campaign->description }}
                        </p>
                        
                        <div class="mt-auto">
                            @php
                                $percent = min(100, ($campaign->current_amount / max(1, $campaign->target_amount)) * 100);
                            @endphp
                            <div class="flex justify-between items-end mb-2">
                                <span class="text-emerald-600 font-bold text-lg">${{ number_format($campaign->current_amount) }}</span>
                                <span class="text-gray-400 text-sm">Target: ${{ number_format($campaign->target_amount) }}</span>
                            </div>
                            <div class="w-full h-2 bg-emerald-50 rounded-full overflow-hidden mb-6">
                                <div class="h-full bg-emerald-500 rounded-full transition-all duration-1000" style="width: {{ $percent }}%"></div>
                            </div>
                            
                            <a href="{{ route('campaigns.show', $campaign->id) }}" class="w-full block text-center py-3 bg-gray-50 hover:bg-emerald-500 hover:text-white text-gray-700 font-bold rounded-xl transition-all border border-gray-100">
                                View Details
                            </a>
                        </div>
                    </div>
                </div>
            @empty
                <!-- Skeleton/Empty state if no campaigns -->
                <div class="col-span-1 md:col-span-3 text-center py-20 bg-white rounded-3xl border border-dashed border-gray-200">
                    <p class="text-gray-400">Loading live campaigns...</p>
                </div>
            @endforelse
        </div>
    </div>
</section>

<!-- Mobile/Native Call to Action -->
<section class="py-24 px-6 overflow-hidden">
    <div class="max-w-7xl mx-auto bg-slate-900 rounded-[3rem] relative overflow-hidden p-12 md:p-20 flex flex-col md:flex-row items-center justify-between gap-12">
        <div class="relative z-10 max-w-xl">
            <h2 class="text-4xl md:text-5xl font-bold text-white font-outfit mb-6 leading-tight">Ready to make a difference?</h2>
            <p class="text-slate-400 text-lg mb-10">Join thousands of donors and changemakers. It takes less than 2 minutes to start your own campaign.</p>
            <div class="flex flex-col sm:flex-row gap-4">
                <a href="{{ route('register') }}" class="btn-primary px-8 py-4 rounded-2xl font-bold">Sign Up Now</a>
                <a href="#" class="px-8 py-4 rounded-2xl font-bold text-white border border-slate-700 hover:bg-slate-800 transition-all text-center">How it Works</a>
            </div>
        </div>
        
        <div class="relative w-full md:w-1/3">
            <div class="absolute -top-20 -right-20 w-80 h-80 bg-emerald-500/20 blur-[100px] rounded-full"></div>
            <div class="glass p-6 rounded-3xl border-slate-700/50 shadow-2xl relative z-10">
                <div class="flex items-center space-x-4 mb-6 text-white">
                    <div class="w-12 h-12 rounded-full bg-emerald-500 flex items-center justify-center font-bold">JD</div>
                    <div>
                        <p class="font-bold">John Doe</p>
                        <p class="text-xs text-slate-400">Just donated $500</p>
                    </div>
                </div>
                <div class="h-2 bg-slate-800 rounded-full mb-4 overflow-hidden">
                    <div class="h-full bg-emerald-500 w-[75%]"></div>
                </div>
                <p class="text-white text-sm font-bold">75% of target reached!</p>
            </div>
        </div>
    </div>
</section>
@endsection
