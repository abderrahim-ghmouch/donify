@extends('layouts.app', ['hide_nav' => true])

@section('content')
<!-- Hero Section -->
<section class="relative min-h-[95vh] flex items-center justify-center overflow-hidden px-6 pt-10 bg-[#fbf8f6] font-quicksand">
    <!-- Logo Watermark Background -->
    <div class="absolute inset-0 z-0 flex items-center justify-center pointer-events-none opacity-[0.2]">
        <img src="{{ asset('images/donifylg.png') }}" alt="" class="w-[900px] h-auto grayscale select-none">
    </div>

    <div class="max-w-5xl mx-auto w-full relative z-10 text-center">
        <div class="animate-fade-in">
            <!-- Branded Logo Above Hero -->
            <div class="mb-10 flex justify-center">
                <img src="{{ asset('images/donifylg.png') }}" class="h-20 w-auto object-contain">
            </div>
        
            <h1 class="text-4xl sm:text-5xl md:text-8xl font-black text-[#1A1A1A] mb-8 leading-tight">
                Donify <br><span class="text-[#064e3b]">Be the Change</span>
            </h1>
            
            <p class="text-lg text-gray-600 mb-12 leading-relaxed max-w-2xl mx-auto font-medium">
                The world's most trusted gateway for meaningful giving. Join a global network of changemakers today.
            </p>
            
            <div class="flex flex-col sm:flex-row gap-5 justify-center items-center px-4">
                <a href="{{ route('login') }}" class="w-full sm:w-auto bg-transparent text-black px-12 md:px-20 py-4 rounded-xl font-bold text-sm uppercase tracking-[0.2em] text-center border-2 border-black hover:bg-black hover:text-white transition-all transform hover:scale-[1.02]">
                    Login
                </a>
                <a href="{{ route('register') }}" class="w-full sm:w-auto bg-[#1A1A1A] text-white px-12 md:px-20 py-4 rounded-xl font-bold text-sm uppercase tracking-[0.2em] text-center hover:bg-[#064e3b] transition-all transform hover:scale-[1.02] shadow-2xl">
                    Join Now
                </a>
            </div>
            
            <div class="mt-20 pt-10 border-t border-gray-200 flex flex-wrap justify-center gap-8 opacity-50 grayscale hover:grayscale-0 transition-all">
                <span class="font-bold text-xl tracking-tight text-gray-400">TRUSTED</span>
                <span class="font-bold text-xl tracking-tight text-gray-400">SECURE</span>
                <span class="font-bold text-xl tracking-tight text-gray-400">IMPACTFUL</span>
               
                
            </div>
        </div>
    </div>
</section>  

<!-- Stats Section -->
<section class="py-24 px-6 bg-[#fbf8f6] border-t border-gray-100">
    <div class="max-w-7xl mx-auto grid grid-cols-2 md:grid-cols-4 gap-12">
        <div class="text-center group cursor-default p-8 transition-all duration-500">
            <h3 class="text-5xl font-black text-[#1A1A1A] mb-3 tracking-tighter group-hover:text-[#DAA520] transition-colors">$24M+</h3>
            <p class="text-gray-400 font-bold tracking-widest uppercase text-[10px]">Total Raised</p>
        </div>
        <div class="text-center group cursor-default p-8 transition-all duration-500 delay-100">
            <h3 class="text-5xl font-black text-[#1A1A1A] mb-3 tracking-tighter group-hover:text-[#DAA520] transition-colors">1,500</h3>
            <p class="text-gray-400 font-bold tracking-widest uppercase text-[10px]">Active Campaigns</p>
        </div>
        <div class="text-center group cursor-default p-8 transition-all duration-500 delay-200">
            <h3 class="text-5xl font-black text-[#1A1A1A] mb-3 tracking-tighter group-hover:text-[#DAA520] transition-colors">850</h3>
            <p class="text-gray-400 font-bold tracking-widest uppercase text-[10px]">Organizations</p>
        </div>
        <div class="text-center group cursor-default p-8 transition-all duration-500 delay-300">
            <h3 class="text-5xl font-black text-[#1A1A1A] mb-3 tracking-tighter group-hover:text-[#DAA520] transition-colors">12K+</h3>
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
                <h2 class="text-3xl md:text-6xl font-extrabold text-[#1A1A1A] mb-8 leading-tight transition-colors duration-1000 group-hover:text-white">
                    Ready to lead <br><span class="text-[#064e3b]">the change?</span>
                </h2>
                
                <p class="text-gray-600 text-lg md:text-xl mb-12 font-medium leading-relaxed">
                    Join thousands of verified organizations and donors in building a more impactful future together. Every big change starts with a small step.
                </p>
                
                <div class="flex flex-col sm:flex-row gap-4 justify-center md:justify-start">
                    <a href="{{ route('register') }}" class="bg-black text-white px-8 py-3 rounded-md font-bold text-sm border border-black hover:bg-[#996515] hover:text-white hover:border-[#996515] transition-all text-center uppercase tracking-[0.2em]">
                        Get Started
                    </a>
                    <a href="#" class="bg-transparent text-black px-8 py-3 rounded-md font-bold text-sm border border-black hover:text-[#996515] hover:border-[#996515] transition-all duration-500 text-center uppercase tracking-[0.2em]">
                        Our Vision
                    </a>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
