@extends('layouts.app')

@section('content')
<!-- Hero Section -->
<section class="relative min-h-[90vh] flex items-center justify-center overflow-hidden px-6 pt-20 bg-[#fbf8f6] font-['Quicksand']">
    <!-- Logo Watermark Background -->
    <div class="absolute inset-0 z-0 flex items-center justify-center pointer-events-none opacity-[0.2]">
        <img src="{{ asset('images/donifylg.png') }}" alt="" class="w-[900px] h-auto grayscale select-none">
    </div>

    <div class="max-w-5xl mx-auto w-full relative z-10 text-center">
        <div class="animate-fade-in">
        
            <h1 class="text-6xl md:text-8xl font-extrabold text-gray-800 leading-[1.1] mb-8 tracking-tight">
                Donify <br><span class="text-[#02a95c]">Empower Change.</span>
            </h1>
            
            <p class="text-lg text-gray-600 mb-12 leading-relaxed max-w-2xl mx-auto font-medium">
                The world's most trusted gateway for meaningful giving. <br class="hidden md:block"> Join a global network of changemakers and verified organizations today.
            </p>
            
            <div class="flex flex-col sm:flex-row gap-6 justify-center items-center">
                <a href="{{ route('campaigns.index') }}" class="w-full sm:w-auto bg-black text-white px-16 py-3 rounded-md font-bold text-sm uppercase tracking-[0.2em] text-center hover:bg-gray-800 transition-all shadow-xl shadow-black/10">
                    Explore Campaigns
                </a>
                <a href="{{ route('organisations.register') }}" class="w-full sm:w-auto bg-white text-black px-16 py-3 rounded-md font-bold text-sm uppercase tracking-[0.2em] text-center border-2 border-black hover:bg-black hover:text-white transition-all">
                    Start as Organisation
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
<section class="w-full font-['Quicksand'] relative overflow-hidden bg-gradient-to-b from-[#fbf8f6] to-[#0b1612]">
    <div class="flex flex-col md:flex-row items-stretch">
        
        {{-- Left: Slogan Image --}}
        <div class="w-full md:w-1/2 p-12 md:p-24 flex justify-center items-center">
            <img src="{{ asset('images/slogan.png') }}" alt="Donify Slogan" class="w-full max-w-lg h-auto object-contain animate-fade-in drop-shadow-2xl">
        </div>

        {{-- Right: Content --}}
        <div class="w-full md:w-1/2 p-12 md:p-24 relative flex items-center">
            <div class="max-w-xl mx-auto md:mx-0">
                <h2 class="text-4xl md:text-6xl font-extrabold text-gray-800 mb-8 leading-tight transition-colors duration-1000 group-hover:text-white">
                    Ready to lead <br><span class="text-[#02a95c]">the change?</span>
                </h2>
                
                <p class="text-gray-600 text-lg md:text-xl mb-12 font-medium leading-relaxed">
                    Join thousands of verified organizations and donors in building a more impactful future together. Every big change starts with a small step.
                </p>
                
                <div class="flex flex-col sm:flex-row gap-4 justify-center md:justify-start">
                    <a href="{{ route('register') }}" class="bg-black text-white px-8 py-3 rounded-md font-bold text-sm border border-black hover:bg-transparent hover:text-black transition-all text-center uppercase tracking-[0.2em]">
                        Get Started
                    </a>
                    <a href="#" class="bg-transparent text-black px-8 py-3 rounded-md font-bold text-sm border border-black hover:bg-black hover:text-white transition-all text-center uppercase tracking-[0.2em]">
                        Our Vision
                    </a>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
