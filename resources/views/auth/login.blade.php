@extends('layouts.app', ['hide_nav' => true])


@section('content')
    <div class="flex flex-col md:flex-row h-screen bg-[#fbf8f6] font-quicksand overflow-hidden relative">

        <!-- Dynamic Gradient Background (80% Coverage with Green) -->
        <div class="absolute inset-y-0 left-0 w-[80%] bg-gradient-to-r from-[#064e3b]/40 to-transparent z-0"></div>

        <!-- Left Side: Form Container -->
        <div class="w-full md:w-2/5 flex flex-col relative z-20 overflow-hidden">

            <!-- Background Quotes (Left) -->
            <div class="absolute inset-0 z-0 pointer-events-none opacity-[0.05]">
                <div class="absolute top-10 left-10 text-6xl font-black text-[#1A1A1A] -rotate-12 uppercase">Donify</div>
                <div class="absolute top-1/4 right-20 text-7xl font-black text-[#064e3b] rotate-6 uppercase">Safety</div>
                <div class="absolute bottom-1/4 left-5 text-6xl font-black text-[#DAA520] -rotate-6 uppercase">Impact</div>
                <div class="absolute bottom-10 right-10 text-7xl font-black text-[#1A1A1A] rotate-12 uppercase">Logic</div>
            </div>

            <!-- Form Content -->
            <div class="h-full flex flex-col px-8 md:px-16 py-10 relative z-10 overflow-hidden">
                <!-- Back Arrow -->
                <div class="mb-6">
                    <a href="{{ route('home') }}"
                        class="inline-flex items-center text-[#1A1A1A] hover:text-[#064e3b] transition-all group">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-3" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                        </svg>
                        <span class="font-bold text-xs uppercase tracking-widest text-gray-500">Home</span>
                    </a>
                </div>

                <div class="max-w-lg w-full mt-auto mb-auto bg-transparent relative z-10">
                    {{-- Logo Section --}}
                    <div class="mb-10 text-left">
                        <img src="{{ asset('images/donifylg.png') }}" alt="Donify Logo"
                            class="h-16 w-auto object-contain drop-shadow-[0_10px_15px_rgba(2,169,92,0.1)]">
                    </div>

                    <div class="mb-8">
                        <h1 class="text-4xl md:text-6xl font-black text-[#1A1A1A] mb-3 leading-tight">Welcome Back</h1>
                        <p class="text-gray-500 font-medium text-lg leading-relaxed">Sign in to continue making an impact.
                        </p>
                    </div>

                    <form id="loginForm" class="space-y-6">
                        <!-- Error Message -->
                        <div id="loginError"
                            class="hidden bg-red-50 text-red-500 p-5 rounded-xl text-sm border border-red-100 italic">
                        </div>

                        <div>
                            <label
                                class="block text-[10px] font-bold uppercase tracking-widest text-gray-400 mb-2 ml-1">Email
                                Address</label>
                            <input type="email" id="email" required
                                class="w-full px-6 py-4 rounded-xl bg-white border border-gray-100 focus:border-[#064e3b] focus:ring-4 focus:ring-[#064e3b]/5 transition-all outline-none font-medium placeholder-gray-300 text-sm shadow-sm"
                                placeholder="john@example.com">
                        </div>

                        <div>
                            <div class="flex justify-between items-center mb-2 ml-1">
                                <label
                                    class="block text-[10px] font-bold uppercase tracking-widest text-gray-400">Password</label>
                                <a href="#"
                                    class="text-[9px] font-bold text-[#064e3b] hover:underline uppercase tracking-tight">Forgot
                                    Password?</a>
                            </div>
                            <input type="password" id="password" required
                                class="w-full px-6 py-4 rounded-xl bg-white border border-gray-100 focus:border-[#064e3b] focus:ring-4 focus:ring-[#064e3b]/5 transition-all outline-none font-medium placeholder-gray-300 text-sm shadow-sm"
                                placeholder="••••••••">
                        </div>

                        <div class="pt-4">
                            <button type="submit" id="loginBtn"
                                class="w-full bg-[#1A1A1A] hover:bg-[#064e3b] text-white py-5 rounded-xl font-bold text-sm uppercase tracking-[0.2em] shadow-xl transition-all active:scale-[0.98]">
                                Sign In
                            </button>

                            <div class="text-center mt-6">
                                <p class="text-gray-500 font-medium text-[10px]">
                                    New to Donify?
                                    <a href="{{ route('register') }}"
                                        class="text-[#064e3b] font-bold hover:underline ml-1 uppercase">Create Account</a>
                                </p>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- Right Side: Visual Aspect Overlay -->
        <div class="hidden md:block w-3/5 relative bg-transparent overflow-hidden">
            <!-- Main Logo Accent (Replacing missing bg image) -->
            <div
                class="absolute inset-x-0 bottom-0 h-1/2 flex items-end justify-center pb-12 z-0 opacity-10 grayscale brightness-150">
                <img src="{{ asset('images/donifylg.png') }}" class="w-full h-auto object-contain">
            </div>

            <!-- Floating Quotes Overlay -->
            <div class="absolute inset-0 z-10 pointer-events-none p-12">
                <!-- Group 1: MASSIVE QUOTES -->
                <div class="absolute top-12 right-12 text-right max-w-[450px] opacity-100">
                    <h3 class="text-4xl lg:text-5xl font-black text-[#1A1A1A] leading-tight italic mb-3">"The world is
                        changed by your example."</h3>
                    <p class="text-[#064e3b] font-bold uppercase tracking-[0.3em] text-[14px]">Paulo Coelho</p>
                </div>

                <div class="absolute bottom-12 right-12 text-right max-w-[500px] opacity-100">
                    <h3 class="text-5xl lg:text-6xl font-black text-[#064e3b] leading-tight italic mb-4">"We make a life by
                        what we give."</h3>
                    <p class="text-[#1A1A1A] font-bold uppercase tracking-[0.3em] text-[16px]">Winston Churchill</p>
                </div>

                <!-- Accent Items -->
                <div class="absolute top-1/2 right-10 text-right max-w-[350px] opacity-80">
                    <h3 class="text-3xl font-black text-[#DAA520] leading-tight italic mb-2">"Happiness comes from your
                        actions."</h3>
                    <p class="text-[#1A1A1A] font-bold uppercase tracking-widest text-[12px]">Dalai Lama</p>
                </div>

                <!-- New Quote -->
                <div class="absolute bottom-[20%] left-10 text-left max-w-[350px] opacity-100">
                    <h3 class="text-4xl font-black text-[#064e3b] leading-tight italic mb-2">"Allah ydawmha naama"</h3>
                    <p class="text-[#1A1A1A] font-bold uppercase tracking-widest text-[14px]">Sirajdin</p>
                </div>
            </div>
        </div>
    </div>

    @endsection
