@extends('layouts.app', ['hide_nav' => true, 'hide_footer' => true])

@section('content')
<div class="flex flex-col md:flex-row h-screen bg-[#fbf8f6] font-quicksand overflow-hidden relative">
    
    {{-- Left Side: Access Context --}}
    <div class="hidden md:flex md:w-1/2 bg-[#1A1A1A] relative overflow-hidden flex-col justify-between p-20">
        {{-- Abstract Rise --}}
        <div class="absolute bottom-0 left-0 right-0 h-2/3 bg-gradient-to-t from-[#064e3b]/40 to-transparent z-0"></div>

        <div class="relative z-10 space-y-10">
            <a href="{{ route('home') }}" class="inline-flex items-center text-white/40 hover:text-white transition-all group">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-3" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path d="M10 19l-7-7m0 0l7-7m-7 7h18" /></svg>
                <span class="font-bold text-xs uppercase tracking-widest text-white/40">Home</span>
            </a>

            <div class="space-y-4">
                <img src="{{ asset('images/donifylg.png') }}" class="h-16 w-auto brightness-0 invert opacity-90 drop-shadow-2xl">
                <h1 class="text-6xl font-black text-white leading-none tracking-tighter italic">Partner <br> Access.</h1>
                <p class="text-white/40 text-xs font-black uppercase tracking-[0.5em] mt-4">Authorized Personnel Only</p>
            </div>
        </div>

        <div class="relative z-10">
            <div class="max-w-[400px]">
                <h3 class="text-3xl font-black text-[#996515] leading-tight mb-4 italic">"Transparency is the cornerstone of trust."</h3>
                <p class="text-white/30 text-[10px] font-black uppercase tracking-widest">Protocol 04. Unified Integrity</p>
            </div>
        </div>
    </div>

    {{-- Right Side: Login Form --}}
    <div class="w-full md:w-1/2 flex flex-col justify-center items-center bg-white p-12">
        <div class="max-w-md w-full space-y-12">
            <div class="text-center md:text-left">
                <h2 class="text-4xl font-black text-[#1A1A1A] tracking-tighter">Execute Login.</h2>
                <p class="text-gray-400 font-medium mt-2">Manage your organization's missions and impact.</p>
            </div>

            <form id="orgLoginForm" class="space-y-6">
                <div id="loginError" class="hidden bg-red-50 text-red-600 p-6 rounded-2xl text-xs font-bold border border-red-100 italic"></div>

                <div class="space-y-2">
                    <label class="text-[10px] font-bold text-gray-400 uppercase tracking-widest ml-1">Official Email</label>
                    <input type="email" id="email" required class="w-full px-6 py-5 rounded-2xl bg-gray-50 border border-gray-100 focus:border-[#064e3b] focus:ring-4 focus:ring-[#064e3b]/5 transition-all outline-none text-sm font-medium shadow-sm">
                </div>

                <div class="space-y-2">
                    <label class="text-[10px] font-bold text-gray-400 uppercase tracking-widest ml-1">Access Credentials</label>
                    <input type="password" id="password" required class="w-full px-6 py-5 rounded-2xl bg-gray-50 border border-gray-100 focus:border-[#064e3b] focus:ring-4 focus:ring-[#064e3b]/5 transition-all outline-none text-sm font-medium shadow-sm">
                </div>

                <div class="pt-6">
                    <button type="submit" id="loginBtn" class="w-full bg-[#1A1A1A] hover:bg-[#064e3b] text-white py-6 rounded-2xl font-black text-xs uppercase tracking-[0.4em] shadow-2xl transition-all active:scale-[0.98]">Identity Verification</button>
                    
                    <div class="flex flex-col items-center gap-4 mt-10">
                        <p class="text-[10px] font-bold text-gray-400 uppercase tracking-widest">
                            New Partner Entity? 
                            <a href="{{ route('organisations.register') }}" class="text-[#064e3b] ml-1 hover:underline">Deploy Application</a>
                        </p>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    document.getElementById('orgLoginForm').addEventListener('submit', async (e) => {
        e.preventDefault();
        
        const btn = document.getElementById('loginBtn');
        const errorDiv = document.getElementById('loginError');
        const email = document.getElementById('email').value;
        const password = document.getElementById('password').value;

        btn.disabled = true;
        btn.innerHTML = '<span class="flex items-center justify-center animate-pulse tracking-[0.2em] italic">VERIFYING IDENTITY...</span>';
        errorDiv.classList.add('hidden');

        try {
            await ApiClient.loginOrganisation(email, password);
            window.location.href = '/porter/dashboard';
        } catch (error) {
            console.error(error);
            const msg = error.error || 'Identity rejection. Verification pending or invalid credentials.';
            errorDiv.textContent = msg;
            errorDiv.classList.remove('hidden');
            btn.disabled = false;
            btn.innerHTML = 'IDENTITY VERIFICATION';
        }
    });
</script>
@endsection
