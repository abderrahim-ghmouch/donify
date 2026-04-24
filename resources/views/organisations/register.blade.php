@extends('layouts.app', ['hide_nav' => true, 'hide_footer' => true])

@section('content')
<div class="flex flex-col md:flex-row h-screen bg-[#fbf8f6] font-quicksand overflow-hidden relative">
    
    {{-- Identity Zone (Left): Natural Perspective --}}
    <div class="hidden md:flex md:w-1/2 relative overflow-hidden bg-[url('{{ asset('images/people.jpeg') }}')] bg-cover bg-center">
        {{-- Right-to-Left Dark Emerald Transition --}}
        <div class="absolute inset-x-0 bottom-0 top-0 bg-gradient-to-l from-[#0d1f1a] via-transparent to-transparent z-10"></div>
    </div>
    
    {{-- Form Zone (Right): Midnight Emerald Theme --}}
    <div class="w-full md:w-1/2 overflow-y-auto custom-scrollbar relative z-20 shadow-lg bg-gradient-to-bl from-[#10b981] via-[#064e3b] to-[#0d1f1a]">
        <div class="max-w-4xl mx-auto px-8 py-20 relative z-10">
            {{-- Top Navigation --}}
            <div class="mb-10 flex justify-between items-center relative z-10">
                <a href="{{ route('home') }}" class="inline-flex items-center gap-3 text-white/70 hover:text-white transition-all group font-bold text-sm bg-white/5 px-5 py-2.5 rounded-full border border-white/10 hover:bg-white/10 shadow-sm">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-5"  viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                    </svg>
                    Return to Home
                </a>
            </div>

            <div class="mb-16">
                <div class="flex items-center gap-3 mb-4">
                    <img src="{{ asset('images/donifylg.png') }}" class="h-24 w-auto">
                    <div class="h-6 w-px bg-white/10"></div>
                    <span class="text-[12px] font-black uppercase tracking-[0.4em] text-[#fbf8f6]/30">Empowering Impact</span>
                </div>
                <h1 class="text-3xl font-bold text-[#fbf8f6] leading-tight tracking-tight">Be the <span class="text-white/40">Change.</span></h1>
            </div>

            {{-- State Headers --}}
            <div id="registerHeader">
                <div class="mb-16 relative z-10">
                    <h2 class="text-6xl font-extrabold text-white tracking-tighter leading-none uppercase">Register Organisation</h1>
                    <p class="text-yellow-200 text-lg mt-4 uppercase tracking-[0.3em] font-bold">register your organisation</p>
                </div>
            </div>

            <div id="registerFormContainer">
                <form id="orgRegisterForm" class="space-y-8 relative z-10">
                    <div id="registerError" class="hidden bg-red-50 text-red-600 p-6 rounded-2xl text-xs font-bold border border-red-100 animate-shake"></div>

                {{-- Section 1: Identity --}}
                <div class="space-y-6">
                    {{-- Identification Section --}}
                    <div class="space-y-3 relative">
                        <label class="text-[11px] font-black text-black uppercase tracking-[0.4em] ml-1">Organisation Identity</label>
                        <input type="text" id="name" required placeholder="OFFICIAL LEGAL NAME" class="w-full px-8 py-5 rounded-2xl bg-[#fbf8f6] border-2 border-black focus:bg-white transition-all outline-none text-sm font-bold text-black placeholder:text-black/20">
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                        <div class="space-y-3 relative">
                            <label class="text-[11px] font-black text-black uppercase tracking-[0.4em] ml-1">Official Protocol Email</label>
                            <input type="email" id="email" required placeholder="NAME@ORGANISATION.ORG" class="w-full px-8 py-5 rounded-2xl bg-[#fbf8f6] border-2 border-black focus:bg-white transition-all outline-none text-sm font-bold text-black placeholder:text-black/20">
                        </div>
                        <div class="space-y-3 relative">
                            <label class="text-[11px] font-black text-black uppercase tracking-[0.4em] ml-1">Direct Secure Line</label>
                            <input type="text" id="phone" required placeholder="+212 000-000000" class="w-full px-8 py-5 rounded-2xl bg-[#fbf8f6] border-2 border-black focus:bg-white transition-all outline-none text-sm font-bold text-black placeholder:text-black/20">
                        </div>
                    </div>

                    <div class="space-y-3 relative">
                        <label class="text-[11px] font-black text-black uppercase tracking-[0.4em] ml-1">Physical Base Address</label>
                        <input type="text" id="address" required placeholder="FULL OFFICE SUITE ADDRESS" class="w-full px-8 py-5 rounded-2xl bg-[#fbf8f6] border-2 border-black focus:bg-white transition-all outline-none text-sm font-bold text-black placeholder:text-black/20">
                    </div>

                    <div class="space-y-3 relative">
                        <label class="text-[11px] font-black text-black uppercase tracking-[0.4em] ml-1">Mission Synthesis</label>
                        <textarea id="description" placeholder="BRIEF ARCHITECTURE OF YOUR GOALS..." class="w-full px-8 py-5 rounded-2xl bg-[#fbf8f6] border-2 border-black focus:bg-white transition-all outline-none text-sm font-bold text-black placeholder:text-black/20 h-40 resize-none"></textarea>
                    </div>

                    <div class="space-y-3 relative">
                        <label class="text-[11px] font-black text-black uppercase tracking-[0.4em] ml-1">Security Access Key</label>
                        <input type="password" id="password" required placeholder="••••••••" class="w-full px-8 py-5 rounded-2xl bg-[#fbf8f6] border-2 border-black focus:bg-white transition-all outline-none text-sm font-bold text-black placeholder:text-black/20">
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div class="space-y-2">
                            <label class="text-sm font-black text-black uppercase tracking-widest ml-1">Brand Logo</label>
                            <input type="file" id="logo" accept="image/*" class="w-full text-[10px] text-black/40 file:mr-4 file:py-2.5 file:px-5 file:rounded-lg file:border-2 file:border-black file:text-[10px] file:font-black file:uppercase file:bg-white file:text-black hover:file:bg-black hover:file:text-white transition-all cursor-pointer">
                        </div>
                        <div class="space-y-2">
                            <label class="text-sm font-black text-black uppercase tracking-widest ml-1">Legal Dossier (PDF)</label>
                            <input type="file" id="document" required accept=".pdf,image/*" class="w-full text-[10px] text-black/40 file:mr-4 file:py-2.5 file:px-5 file:rounded-lg file:border-2 file:border-black file:text-[10px] file:font-black file:uppercase file:bg-white file:text-black hover:file:bg-black hover:file:text-white transition-all cursor-pointer">
                        </div>
                    </div>
                </div>

                    <div class="pt-8">
                        <button type="submit" id="registerBtn" class="w-full bg-black hover:bg-zinc-800 text-white py-6 rounded-xl font-black text-xs uppercase tracking-[0.4em] shadow-2xl transition-all active:scale-[0.98] border-none">Complete Registration</button>
                        <p class="text-center mt-6 text-xs text-white/40 uppercase tracking-widest font-bold">
                            Already registered? <a href="{{ route('login') }}" class="text-emerald-400 font-black hover:underline ml-1">Sign In</a>
                        </p>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
    // Registration Handler
    document.getElementById('orgRegisterForm').addEventListener('submit', async (e) => {
        e.preventDefault();
        
        const btn = document.getElementById('registerBtn');
        const errorDiv = document.getElementById('registerError');
        
        const fd = new FormData();
        fd.append('name', document.getElementById('name').value);
        fd.append('email', document.getElementById('email').value);
        fd.append('password', document.getElementById('password').value);
        fd.append('description', document.getElementById('description').value);
        fd.append('phone', document.getElementById('phone').value);
        fd.append('address', document.getElementById('address').value);
        
        const logo = document.getElementById('logo').files[0];
        if(logo) fd.append('logo', logo);
        
        const doc = document.getElementById('document').files[0];
        if(doc) fd.append('document', doc);

        btn.disabled = true;
        btn.innerHTML = '<span class="flex items-center justify-center animate-pulse tracking-widest">INITIALIZING PROTOCOL...</span>';
        errorDiv.classList.add('hidden');

        try {
            await ApiClient.registerOrganisation(fd);
            alert('Application Deployed. Access will be authorized upon manual admin verification.');
            window.location.href = '/';
        } catch (error) {
            console.error(error);
            const msg = error.message || (error.errors ? Object.values(error.errors)[0][0] : 'Validation failure. Security check manual logs.');
            errorDiv.textContent = msg;
            errorDiv.classList.remove('hidden');
            btn.disabled = false;
            btn.innerHTML = 'COMPLETE REGISTRATION';
        }
    });
</script>
@endsection
