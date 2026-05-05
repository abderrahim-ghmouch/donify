@extends('layouts.app')

@section('content')
{{-- Loading State --}}
<div id="profileLoading" class="min-h-screen flex items-center justify-center bg-cream font-quicksand">
    <div class="text-center">
        <div class="w-12 h-12 border-2 border-[#064e3b] border-t-transparent rounded-full animate-spin mx-auto mb-6"></div>
        <p class="text-sm font-bold tracking-widest text-gray-400">Retrieving Account</p>
    </div>
</div>

{{-- Main Profile Experience --}}
<div id="profilePage" class="min-h-screen bg-[#fbf8f6] font-quicksand relative overflow-hidden" style="display:none">
    
    {{-- Refined Atmospheric Gradient (Footer based, slightly deeper/longer) --}}
    {{-- Sync Global Atmosphere: Ultimate Static Rise (Porter Dashboard Spec) --}}
    <div class="absolute bottom-0 left-0 right-0 h-[1200px] bg-gradient-to-t from-[#064e3b]/90 via-[#064e3b]/20 via-40% to-transparent pointer-events-none z-0"></div>

    {{-- Hero Section (Bright Top) --}}
    <section class="relative pt-32 pb-20 px-8 z-10">
        <div class="max-w-4xl mx-auto">
            <div class="flex flex-col md:flex-row items-center gap-12">
                
                {{-- Avatar Stack (Now Perfect Circle) --}}
                <div class="relative group">
                    <div class="w-40 h-40 rounded-full overflow-hidden border-4 border-[#1A1A1A]/5 p-1 bg-white/40 backdrop-blur-md transition-all group-hover:border-[#DAA520]/50 shadow-2xl">
                        <div id="heroAvatarWrap" class="w-full h-full rounded-full overflow-hidden bg-[#1A1A1A]">
                            <img id="heroAvatarImg" src="" alt="Avatar" class="w-full h-full object-cover hidden">
                            <div id="heroAvatarFallback" class="w-full h-full flex items-center justify-center text-white/20">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-16 w-16" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                                </svg>
                            </div>
                        </div>
                    </div>
                    <label for="avatarUploadInput" class="absolute bottom-0 right-0 w-10 h-10 bg-[#DAA520] hover:bg-[#1A1A1A] text-white transition-all rounded-full flex items-center justify-center cursor-pointer shadow-2xl transform hover:scale-110">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z"/>
                        </svg>
                    </label>
                    <input type="file" id="avatarUploadInput" accept="image/*" class="hidden">
                </div>

                {{-- User Info (Dark Text on Bright Top) --}}
                <div class="flex-1 text-center md:text-left">
                    <h1 id="heroName" class="text-4xl md:text-6xl font-black text-[#1A1A1A] leading-none mb-3 tracking-tighter">Loading...</h1>
                    <p id="heroEmail" class="text-gray-400 text-xl font-medium tracking-tight">—</p>
                </div>

            </div>
        </div>
    </section>

    {{-- Info Protocol Area (Transparent/Integrated) --}}
    <div class="max-w-4xl mx-auto px-8 pb-32 relative z-10 font-quicksand">
        
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            
            {{-- Update Form (No White Card) --}}
            <div class="lg:col-span-3 bg-transparent p-0">
                <div class="flex items-center justify-between mb-12">
                    <div>
                        <h2 class="text-2xl font-black text-[#1A1A1A] mb-1 tracking-tight">Details Registry</h2>
                        <p class="text-[10px] text-gray-400 font-bold tracking-widest">Update Your Identification</p>
                    </div>
                    <div id="settingsSuccess" class="hidden px-5 py-2 bg-emerald-50 text-emerald-600 rounded-xl text-[9px] font-black tracking-widest border border-emerald-100">Synchronized</div>
                </div>

                <form id="profileForm" class="space-y-10">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-10">
                        <div>
                            <label class="block text-[10px] font-black tracking-[0.2em] text-[#1A1A1A] mb-4 ml-2">First Identity</label>
                            <input type="text" id="editFirstName" class="w-full px-8 py-6 rounded-2xl bg-gray-100/50 border-2 border-gray-200 outline-none focus:border-[#064e3b] focus:ring-4 focus:ring-[#064e3b]/5 transition-all text-base font-semibold text-[#1A1A1A] placeholder-gray-300" placeholder="First Name">
                        </div>
                        <div>
                            <label class="block text-[10px] font-black tracking-[0.2em] text-[#1A1A1A] mb-4 ml-2">Last Identity</label>
                            <input type="text" id="editLastName" class="w-full px-8 py-6 rounded-2xl bg-gray-100/50 border-2 border-gray-200 outline-none focus:border-[#064e3b] focus:ring-4 focus:ring-[#064e3b]/5 transition-all text-base font-semibold text-[#1A1A1A] placeholder-gray-300" placeholder="Last Name">
                        </div>
                    </div>
                    <div>
                        <label class="block text-[10px] font-black tracking-[0.2em] text-[#1A1A1A] mb-4 ml-2">Communication Link</label>
                        <input type="email" id="editEmail" class="w-full px-8 py-6 rounded-2xl bg-gray-100/50 border-2 border-gray-200 outline-none focus:border-[#064e3b] focus:ring-4 focus:ring-[#064e3b]/5 transition-all text-base font-semibold text-[#1A1A1A] placeholder-gray-300" placeholder="Email Address">
                    </div>
                    <div>
                        <label class="block text-[10px] font-black tracking-[0.2em] text-[#1A1A1A] mb-4 ml-2">Verified role</label>
                        <input type="text" id="editRole" class="w-full px-8 py-6 rounded-2xl bg-gray-200/30 border-2 border-gray-200 outline-none opacity-50 text-sm font-medium text-[#1A1A1A]" disabled>
                    </div>
                    
                    <div class="pt-10 flex justify-end">
                        <button type="submit" id="saveProfileBtn" class="px-12 py-5 bg-[#064e3b] text-[#1A1A1A] border-2 border-[#1A1A1A] rounded-xl font-black tracking-widest text-[11px] transition-all transform hover:-translate-y-1 hover:bg-[#1A1A1A] hover:text-[#064e3b] shadow-2xl cursor-pointer active:scale-95">Commit Identity Changes</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
