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
<section class="py-24 px-6 bg-[#fbf8f6] border-t border-gray-100">
    <div class="max-w-7xl mx-auto grid grid-cols-2 md:grid-cols-4 gap-12">
        <div class="text-center animate-fade-in">
            <h3 class="text-5xl font-black text-gray-800 mb-3 tracking-tighter">$24M+</h3>
            <p class="text-gray-400 font-bold tracking-widest uppercase text-[10px]">Total Raised</p>
        </div>
        <div class="text-center animate-fade-in delay-100">
            <h3 class="text-5xl font-black text-gray-800 mb-3 tracking-tighter">1,500</h3>
            <p class="text-gray-400 font-bold tracking-widest uppercase text-[10px]">Active Campaigns</p>
        </div>
        <div class="text-center animate-fade-in delay-200">
            <h3 class="text-5xl font-black text-gray-800 mb-3 tracking-tighter">850</h3>
            <p class="text-gray-400 font-bold tracking-widest uppercase text-[10px]">Organizations</p>
        </div>
        <div class="text-center animate-fade-in delay-300">
            <h3 class="text-5xl font-black text-gray-800 mb-3 tracking-tighter">12K+</h3>
            <p class="text-gray-400 font-bold tracking-widest uppercase text-[10px]">Happy Donors</p>
        </div>
    </div>
</section>



<!-- Call to Action -->
<section class="py-24 px-6 bg-[#fbf8f6] font-['Quicksand']">
    <div class="max-w-5xl mx-auto">
        <div class="bg-white rounded-[3rem] shadow-sm border border-gray-100 relative overflow-hidden p-12 md:p-20 flex flex-col items-center text-center">
            
            <div class="absolute top-0 left-0 w-full h-2 bg-[#02a95c]"></div>

            <div class="relative z-10 max-w-2xl">
                <h2 class="text-4xl md:text-5xl font-extrabold text-gray-800 mb-6 leading-tight">
                    Ready to lead <span class="text-[#02a95c]">the change?</span>
                </h2>
                
                <p class="text-gray-600 text-lg md:text-xl mb-10 font-medium leading-relaxed">
                    Join thousands of verified organizations and donors in building a more impactful future together. Every big change starts with a small step.
                </p>
                
                <div class="flex flex-col sm:flex-row gap-4 justify-center">
                    <a href="{{ route('register') }}" class="bg-[#02a95c] text-white px-10 py-4 rounded-full font-bold text-lg hover:bg-[#028b4c] hover:scale-105 transition-all shadow-lg shadow-[#02a95c]/20">
                        Get Started Now
                    </a>
                    <a href="#" class="bg-white text-gray-800 px-10 py-4 rounded-full font-bold text-lg border-2 border-gray-200 hover:border-[#02a95c] hover:text-[#02a95c] transition-all">
                        Our Vision
                    </a>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
