@extends('layouts.app', ['hide_nav' => true])

@section('content')
    <div class="relative overflow-hidden bg-[#fbf8f6]">
        {{-- Full-Depth Atmospheric Gradient (Footer to absolute Top) --}}
        <div
            class="absolute inset-x-0 bottom-0 h-full bg-gradient-to-t from-[#064e3b]/40 via-[#064e3b]/10 to-transparent pointer-events-none z-0">
        </div>

        <!-- Hero Section -->
        <section
            class="relative min-h-[95vh] flex items-center justify-center overflow-hidden px-10 pt-10 z-10 font-quicksand bg-transparent">
            {{-- Mirrored Top-Down Gradient (Specifically for Hero) --}}
            <div
                class="absolute inset-x-0 top-0 h-full bg-gradient-to-b from-[#064e3b]/40 via-[#064e3b]/10 to-transparent pointer-events-none -z-10">
            </div>

            <!-- Logo Watermark Background (Shifted Left) -->
            <div
                class="absolute inset-0 z-0 flex items-center justify-center pointer-events-none opacity-[0.2] -translate-x-16">
                <img src="{{ asset('images/donifylg.png') }}" class="w-[1000px]   select-none">
            </div>

            <div class="max-w-5xl mx-auto w-full relative z-10 text-center">
                <!-- Branded Logo Above Hero -->
                <div class="mb-10 flex justify-center">
                    <img src="{{ asset('images/donifylg.png') }}" class="h-20 w-auto object-contain">
                </div>

                <h1 class="text-4xl sm:text-5xl md:text-8xl font-black text-[#1A1A1A] mb-8 leading-tight">
                    Donify <br><span class="text-[#064e3b]">Be the Change</span>
                </h1>

                <p class="text-lg text-gray-600 mb-12 leading-relaxed max-w-2xl mx-auto font-medium">
                    The Moroocan's most secure gateway for donating. Join a global network of changemakers today.
                </p>

                <div class="flex flex-col sm:flex-row gap-5 justify-center items-center px-4">
                    <a href="{{ route('login') }}"
                        class="w-full sm:w-auto bg-transparent text-black px-12 md:px-20 py-4 rounded-xl font-bold text-sm uppercase tracking-[0.2em] text-center border-2 border-black hover:bg-black hover:text-white transition-all transform hover:scale-[1.08]">
                        Login
                    </a>
                    <a href="{{ route('register') }}"
                        class="w-full sm:w-auto bg-[#1A1A1A] text-white px-12 md:px-20 py-4 rounded-xl font-bold text-sm uppercase tracking-[0.2em] text-center hover:bg-[#a4e6bb] bgopacity-10 transition-all transform hover:scale-[1.02] shadow-2xl">
                        Join Now
                    </a>
                </div>

                <div class="mt-20 pt-10 flex flex-wrap justify-center gap-8 md:gap-12 transition-all">
                    <span
                        class="font-black text-2xl tracking-tighter text-[#059669] hover:text-[#000000] ransition-all duration-300 cursor-default hover:scale-110 transform">TRUSTED</span>
                    <span
                        class="font-black text-2xl tracking-tighter text-[#059669] hover:text-[#000000]  transition-all duration-300 cursor-default hover:scale-110 transform">SECURE</span>
                    <span
                        class="font-black text-2xl tracking-tighter text-[#059669] hover:text-[#000000]   transition-all duration-300 cursor-default hover:scale-110 transform">GLOBAL</span>
                    <span
                        class="font-black text-2xl tracking-tighter text-[#059669] hover:text-[#000000]  transition-all duration-300 cursor-default hover:scale-110 transform">VERIFIED</span>
                    <span
                        class="font-black text-2xl tracking-tighter text-[#059669] hover:text-[#000000]  transition-all duration-300 cursor-default hover:scale-110 transform">AUTHENTIC</span>
                    <span
                        class="font-black text-2xl tracking-tighter text-[#059669] hover:text-[#000000]  transition-all duration-300 cursor-default hover:scale-110 transform">IMPACTFUL</span>
                </div>
            </div>
    </div>
    </section>

    <!-- Stats Section -->
    <section class="py-24 px-6 bg-transparent z-10 relative">
        <div class="max-w-7xl mx-auto grid grid-cols-2 md:grid-cols-4 gap-12">
            <div class="text-center group cursor-default p-8 transition-all duration-500">
                <h3
                    class="text-5xl font-black text-[#1A1A1A] mb-3 tracking-tighter group-hover:text-[#DAA520] transition-colors">
                    240M+ MAD</h3>
                <p class="text-gray-400 font-bold tracking-widest uppercase text-[10px]">Total Raised</p>
            </div>
            <div class="text-center group cursor-default p-8 transition-all duration-500 delay-100">
                <h3
                    class="text-5xl font-black text-[#1A1A1A] mb-3 tracking-tighter group-hover:text-[#DAA520] transition-colors">
                    1,500</h3>
                <p class="text-gray-400 font-bold tracking-widest uppercase text-[10px]">Active Campaigns</p>
            </div>
            <div class="text-center group cursor-default p-8 transition-all duration-500 delay-200">
                <h3
                    class="text-5xl font-black text-[#1A1A1A] mb-3 tracking-tighter group-hover:text-[#DAA520] transition-colors">
                    850</h3>
                <p class="text-gray-400 font-bold tracking-widest uppercase text-[10px]">Organizations</p>
            </div>
            <div class="text-center group cursor-default p-8 transition-all duration-500 delay-300">
                <h3
                    class="text-5xl font-black text-[#1A1A1A] mb-3 tracking-tighter group-hover:text-[#DAA520] transition-colors">
                    12K+</h3>
                <p class="text-gray-400 font-bold tracking-widest uppercase text-[10px]">Happy Donors</p>
            </div>
        </div>
    </section>

    <!-- Institutional Partnership Interface -->
    <section class="relative py-24 px-10 z-10">
        <div
            class="max-w-7xl mx-auto flex flex-col md:flex-row justify-between items-center gap-12 border-t border-[#064e3b]/10 pt-24">

            {{-- Left: Identity Block --}}
            <div class="max-w-2xl space-y-6">
                <h2 class="text-4xl md:text-5xl font-black text-[#1A1A1A] leading-tight tracking-tighter">
                    Scale Your Social <br><span class="text-[#064e3b]">Impact as a Partner.</span>
                </h2>
                <p class="text-[#1A1A1A]/60 text-lg font-medium max-w-lg leading-relaxed">
                    Connect your organization to the most transparent donation ecosystem. Validate your mission and reach a
                    global network of donors instantly.
                </p>
            </div>

            {{-- Right: Direct Access Protocol --}}
            <div class="flex-shrink-0">
                <a href="{{ route('organisations.register') }}"
                    class="text-3xl md:text-5xl font-black text-[#1A1A1A] uppercase tracking-tighter hover:text-[#064e3b] transition-all duration-500 flex items-center gap-6 group">
                    Apply Now.
                    <svg class="w-10 h-10 transform group-hover:translate-x-4 transition-transform duration-500"
                        fill="none" stroke="currentColor" stroke-width="3" viewBox="0 0 24 24">
                        <path d="M17 8l4 4m0 0l-4 4m4-4H3" />
                    </svg>
                </a>
            </div>
        </div>
    </section>



    <!-- Call to Action -->
    <section class="w-full font-['Quicksand'] relative overflow-hidden bg-transparent z-10">
        <div class="flex flex-col md:flex-row items-stretch">

            {{-- Left: Slogan Image --}}
            <div class="w-full md:w-1/2 p-12 md:p-24 flex justify-center items-center">
                <img src="{{ asset('images/slogan.png') }}" alt="Donify Slogan"
                    class="w-full max-w-lg h-auto object-contain animate-fade-in drop-shadow-2xl">
            </div>

            {{-- Right: Content --}}
            <div class="w-full md:w-1/2 p-12 md:p-24 relative flex items-center">
                <div class="max-w-xl mx-auto md:mx-0">
                    <h2
                        class="text-3xl md:text-6xl font-extrabold text-[#1A1A1A] mb-8 leading-tight transition-colors duration-1000 group-hover:text-white">
                        Ready to lead <br><span class="text-[#064e3b]">the change?</span>
                    </h2>

                    <p class="text-gray-600 text-lg md:text-xl mb-12 font-medium leading-relaxed">
                        Join thousands of verified organizations and donors in building a more impactful future together.
                        Every big change starts with a small step.
                    </p>

                    <div class="flex flex-col sm:flex-row gap-4 justify-center md:justify-start">
                        <a href="{{ route('register') }}"
                            class="bg-black text-white px-8 py-3 rounded-md font-bold text-sm border border-black hover:bg-[#996515] hover:text-white hover:border-[#996515] transition-all text-center uppercase tracking-[0.2em]">
                            Get Started
                        </a>
                        <a href="#"
                            class="bg-transparent text-black px-8 py-3 rounded-md font-bold text-sm border border-black hover:text-[#996515] hover:border-[#996515] transition-all duration-500 text-center uppercase tracking-[0.2em]">
                            Our Vision
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </section>
    </div>
@endsection
