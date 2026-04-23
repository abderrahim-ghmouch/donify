@extends('layouts.app', ['hide_nav' => true, 'hide_footer' => true])

@section('content')
<div class="flex flex-col md:flex-row h-screen bg-[#fbf8f6] font-quicksand overflow-hidden relative">
    
    {{-- Identity Zone (Left): Natural Perspective --}}
    <div class="hidden md:flex md:w-1/2 relative overflow-hidden bg-[url('{{ asset('images/people.jpeg') }}')] bg-cover bg-center">
        {{-- Right-to-Left Dark Emerald Transition --}}
        <div class="absolute inset-x-0 bottom-0 top-0 bg-gradient-to-l from-[#0d1f1a] via-transparent to-transparent z-10"></div>
    </div>
    
    {{-- Form Zone (Right): Midnight Emerald Theme --}}
    <div class="w-full md:w-1/2 overflow-y-auto custom-scrollbar relative z-20 shadow-lg" style="background: linear-gradient(to right, #163a30 0%, #163a30 40%, #253d36 70%, #8ca19b 90%, #e3e3e3 100%);">
        <div class="max-w-xl mx-auto px-8 py-16 relative z-10">
            {{-- Top Navigation --}}
            <div class="mb-10 flex justify-between items-center relative z-10">
                <a href="{{ route('home') }}" class="inline-flex items-center gap-3 text-white/70 hover:text-white transition-all group font-bold text-sm bg-white/5 px-5 py-2.5 rounded-full border border-white/10 hover:bg-white/10 shadow-sm">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                    </svg>
                    Return to Home
                </a>
            </div>

            {{-- Platform Slogan at Apex --}}
            <div class="mb-16">
                <div class="flex items-center gap-3 mb-4">
                    <img src="{{ asset('images/donifylg.png') }}" class="h-8 w-auto brightness-0 invert opacity-80">
                    <div class="h-4 w-px bg-white/10"></div>
                    <span class="text-[10px] font-black uppercase tracking-[0.4em] text-[#fbf8f6]/30">Empowering Impact.</span>
                </div>
                <h1 class="text-3xl font-bold text-[#fbf8f6] leading-tight tracking-tight">Be the <span class="text-white/40">Change.</span></h1>
            </div>

            {{-- State Headers --}}
            <div id="registerHeader">
                <div class="mb-12 relative z-10">
                    <h2 class="text-4xl font-extrabold text-white tracking-tight">Register Organisation.</h2>
                    <p class="text-white/30 text-sm mt-1">Initialize your professional profile and global presence.</p>
                </div>
            </div>

            <div id="loginHeader" class="hidden">
                <div class="mb-12 relative z-10">
                    <h2 class="text-4xl font-extrabold text-white tracking-tight">Partner Login.</h2>
                    <p class="text-white/30 text-sm mt-1">Access your secure organisational dashboard.</p>
                </div>
            </div>

            <div id="registerFormContainer">
                <form id="orgRegisterForm" class="space-y-8 relative z-10">
                    <div id="registerError" class="hidden bg-red-50 text-red-600 p-6 rounded-2xl text-xs font-bold border border-red-100 animate-shake"></div>

                {{-- Section 1: Identity --}}
                <div class="space-y-6">
                    {{-- Identification Section --}}
                    <div class="space-y-2 relative">
                        <label class="text-[10px] font-bold text-gray-500 uppercase tracking-widest ml-1">Organisation Name</label>
                        <input type="text" id="name" required placeholder="Official legal name" class="w-full px-6 py-4 rounded-xl bg-[#1d352f] border border-[#2d4d44] focus:border-[#b8860b] focus:bg-[#25423b] transition-all outline-none text-sm font-medium text-white placeholder:text-white/20">
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div class="space-y-2 relative">
                            <label class="text-[10px] font-bold text-gray-500 uppercase tracking-widest ml-1">Official Email</label>
                            <input type="email" id="email" required placeholder="name@organisation.org" class="w-full px-6 py-4 rounded-xl bg-[#1d352f] border border-[#2d4d44] focus:border-[#b8860b] focus:bg-[#25423b] transition-all outline-none text-sm font-medium text-white placeholder:text-white/20">
                        </div>
                        <div class="space-y-2 relative">
                            <label class="text-[10px] font-bold text-gray-500 uppercase tracking-widest ml-1">Contact Phone</label>
                            <input type="text" id="phone" required placeholder="+1 (555) 000-0000" class="w-full px-6 py-4 rounded-xl bg-[#1d352f] border border-[#2d4d44] focus:border-[#b8860b] focus:bg-[#25423b] transition-all outline-none text-sm font-medium text-white placeholder:text-white/20">
                        </div>
                    </div>

                    <div class="space-y-2 relative">
                        <label class="text-[10px] font-bold text-gray-500 uppercase tracking-widest ml-1">Physical Address</label>
                        <input type="text" id="address" required placeholder="Full office address" class="w-full px-6 py-4 rounded-xl bg-[#1d352f] border border-[#2d4d44] focus:border-[#b8860b] focus:bg-[#25423b] transition-all outline-none text-sm font-medium text-white placeholder:text-white/20">
                    </div>

                    <div class="space-y-2 relative">
                        <label class="text-[10px] font-bold text-gray-500 uppercase tracking-widest ml-1">Mission Description</label>
                        <textarea id="description" placeholder="Briefly describe your purpose and goals..." class="w-full px-6 py-4 rounded-xl bg-[#1d352f] border border-[#2d4d44] focus:border-[#b8860b] focus:bg-[#25423b] transition-all outline-none text-sm font-medium text-white placeholder:text-white/20 h-32 resize-none"></textarea>
                    </div>

                    <div class="space-y-2 relative">
                        <label class="text-[10px] font-bold text-gray-500 uppercase tracking-widest ml-1">Security Key (Password)</label>
                        <input type="password" id="password" required placeholder="••••••••" class="w-full px-6 py-4 rounded-xl bg-[#1d352f] border border-[#2d4d44] focus:border-[#b8860b] focus:bg-[#25423b] transition-all outline-none text-sm font-medium text-white placeholder:text-white/20">
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div class="space-y-2">
                            <label class="text-[10px] font-bold text-gray-500 uppercase tracking-widest ml-1">Brand Logo</label>
                            <input type="file" id="logo" accept="image/*" class="w-full text-[10px] text-white/20 file:mr-4 file:py-2.5 file:px-5 file:rounded-lg file:border file:border-[#2d4d44] file:text-[10px] file:font-bold file:uppercase file:bg-[#1d352f] file:text-white hover:file:bg-[#25423b] transition-all cursor-pointer">
                        </div>
                        <div class="space-y-2">
                            <label class="text-[10px] font-bold text-gray-500 uppercase tracking-widest ml-1">Legal Dossier (PDF)</label>
                            <input type="file" id="document" required accept=".pdf,image/*" class="w-full text-[10px] text-white/20 file:mr-4 file:py-2.5 file:px-5 file:rounded-lg file:border file:border-[#2d4d44] file:text-[10px] file:font-bold file:uppercase file:bg-[#1d352f] file:text-white hover:file:bg-[#25423b] transition-all cursor-pointer">
                        </div>
                    </div>
                </div>

                    <div class="pt-8">
                        <button type="submit" id="registerBtn" class="w-full bg-[#b8860b] hover:bg-[#996515] text-white py-4 rounded-xl font-bold text-sm tracking-wide shadow-lg transition-all active:scale-[0.98]">Complete Registration</button>
                        <p class="text-center mt-6 text-xs text-white/40">
                            Already registered? <a href="javascript:void(0)" onclick="toggleMode('login')" class="text-[#b8860b] font-bold hover:underline ml-1">Switch to Login</a>
                        </p>
                    </div>
                </form>
            </div>

            <div id="loginFormContainer" class="hidden">
                <form id="orgLoginForm" class="space-y-8 relative z-10">
                    <div id="loginError" class="hidden bg-red-50 text-red-600 p-6 rounded-2xl text-xs font-bold border border-red-100 animate-shake italic"></div>

                    <div class="space-y-6">
                        <div class="space-y-2 relative">
                            <label class="text-[10px] font-bold text-gray-500 uppercase tracking-widest ml-1">Official Email</label>
                            <input type="email" id="loginEmail" required placeholder="name@organisation.org" class="w-full px-6 py-4 rounded-xl bg-[#1d352f] border border-[#2d4d44] focus:border-[#b8860b] focus:bg-[#25423b] transition-all outline-none text-sm font-medium text-white placeholder:text-white/20">
                        </div>

                        <div class="space-y-2 relative">
                            <label class="text-[10px] font-bold text-gray-500 uppercase tracking-widest ml-1">Security Key</label>
                            <input type="password" id="loginPassword" required placeholder="••••••••" class="w-full px-6 py-4 rounded-xl bg-[#1d352f] border border-[#2d4d44] focus:border-[#b8860b] focus:bg-[#25423b] transition-all outline-none text-sm font-medium text-white placeholder:text-white/20">
                        </div>
                    </div>

                    <div class="pt-8">
                        <button type="submit" id="loginBtn" class="w-full bg-[#b8860b] hover:bg-[#996515] text-white py-4 rounded-xl font-bold text-sm tracking-wide shadow-lg transition-all active:scale-[0.98]">Secure Login</button>
                        <p class="text-center mt-6 text-xs text-white/40">
                            New organisation? <a href="javascript:void(0)" onclick="toggleMode('register')" class="text-[#b8860b] font-bold hover:underline ml-1">Register Now</a>
                        </p>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
    function toggleMode(mode) {
        if (mode === 'login') {
            document.getElementById('registerHeader').classList.add('hidden');
            document.getElementById('registerFormContainer').classList.add('hidden');
            document.getElementById('loginHeader').classList.remove('hidden');
            document.getElementById('loginFormContainer').classList.remove('hidden');
        } else {
            document.getElementById('loginHeader').classList.add('hidden');
            document.getElementById('loginFormContainer').classList.add('hidden');
            document.getElementById('registerHeader').classList.remove('hidden');
            document.getElementById('registerFormContainer').classList.remove('hidden');
        }
    }

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
            btn.innerHTML = 'DEPLOY APPLICATION';
        }
    });

    // Login Handler
    document.getElementById('orgLoginForm').addEventListener('submit', async (e) => {
        e.preventDefault();
        
        const btn = document.getElementById('loginBtn');
        const errorDiv = document.getElementById('loginError');
        const email = document.getElementById('loginEmail').value;
        const password = document.getElementById('loginPassword').value;

        btn.disabled = true;
        btn.innerHTML = '<span class="flex items-center justify-center animate-pulse tracking-widest">VERIFYING IDENTITY...</span>';
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
            btn.innerHTML = 'VERIFY IDENTITY';
        }
    });
</script>
@endsection
