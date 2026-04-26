@extends('layouts.app', ['hide_nav' => true])


@section('content')
<div class="flex flex-col md:flex-row h-screen bg-[#fbf8f6] font-quicksand overflow-hidden relative">

    <!-- Dynamic Gradient Background (80% Coverage with Green) -->
    <div class="absolute inset-y-0 left-0 w-[80%] bg-gradient-to-r from-[#064e3b]/40 to-transparent z-0"></div>

    <!-- Left Side: Form Container -->
    <div class="w-full md:w-2/5 flex flex-col relative z-20 overflow-hidden">

        <!-- Background Quotes (Left) -->
        <div class="absolute inset-0 z-0 pointer-events-none opacity-[0.05]">
            <div class="absolute top-10 left-10 text-6xl font-black text-[#1A1A1A] -rotate-12 uppercase">Join</div>
            <div class="absolute top-1/4 right-20 text-7xl font-black text-[#064e3b] rotate-6 uppercase">Impact</div>
            <div class="absolute bottom-1/4 left-5 text-6xl font-black text-[#DAA520] -rotate-6 uppercase">Givers</div>
            <div class="absolute bottom-10 right-10 text-7xl font-black text-[#1A1A1A] rotate-12 uppercase">Change</div>
        </div>

        <!-- Form Content -->
        <div class="h-full flex flex-col px-8 md:px-16 py-10 relative z-10 overflow-hidden">
            <!-- Back Arrow -->
            <div class="mb-6">
                <a href="{{ route('home') }}" class="inline-flex items-center text-[#1A1A1A] hover:text-[#064e3b] transition-all group">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
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
                    <h1 class="text-4xl md:text-5xl font-black text-[#1A1A1A] mb-3 leading-tight">Join Donify</h1>
                    <p class="text-gray-500 font-medium text-lg leading-relaxed">Start your journey of giving and impact today.</p>
                </div>

                <form id="registerForm" class="space-y-6">
                    <!-- Error Message -->
                    <div id="registerError" class="hidden bg-red-50 text-red-500 p-5 rounded-xl text-sm border border-red-100 italic">
                    </div>

                    <div class="grid grid-cols-2 gap-5">
                        <div>
                            <label class="block text-[10px] font-bold uppercase tracking-widest text-gray-400 mb-2 ml-1">First Name</label>
                            <input type="text" id="first_name" required
                                class="w-full px-6 py-4 rounded-xl bg-white border border-gray-200 focus:border-[#064e3b] focus:ring-4 focus:ring-[#064e3b]/5 transition-all outline-none font-medium placeholder-gray-300 text-sm shadow-sm"
                                placeholder="John">
                        </div>
                        <div>
                            <label class="block text-[10px] font-bold uppercase tracking-widest text-gray-400 mb-2 ml-1">Last Name</label>
                            <input type="text" id="last_name" required
                                class="w-full px-6 py-4 rounded-xl bg-white border border-gray-100 focus:border-[#064e3b] focus:ring-4 focus:ring-[#064e3b]/5 transition-all outline-none font-medium placeholder-gray-300 text-sm shadow-sm"
                                placeholder="Doe">
                        </div>
                    </div>

                    <div>
                        <label class="block text-[10px] font-bold uppercase tracking-widest text-gray-400 mb-2 ml-1">Email Address</label>
                        <input type="email" id="email" required
                            class="w-full px-6 py-4 rounded-xl bg-white border border-gray-200 focus:border-[#064e3b] focus:ring-4 focus:ring-[#064e3b]/5 transition-all outline-none font-medium placeholder-gray-300 text-sm shadow-sm"
                            placeholder="john@example.com">
                    </div>

                    <div class="grid grid-cols-2 gap-5">
                        <div>
                            <label class="block text-[10px] font-bold uppercase tracking-widest text-gray-400 mb-2 ml-1">Password</label>
                            <input type="password" id="password" required
                                class="w-full px-6 py-4 rounded-xl bg-white border border-gray-200 focus:border-[#064e3b] focus:ring-4 focus:ring-[#064e3b]/5 transition-all outline-none font-medium placeholder-gray-300 text-sm shadow-sm"
                                placeholder="Min. 9 characters">
                        </div>
                        <div>
                            <label class="block text-[10px] font-bold uppercase tracking-widest text-gray-400 mb-2 ml-1">Role</label>
                            <div class="relative">
                                <select id="role"
                                    class="w-full px-6 py-4 rounded-xl bg-white border border-gray-200 focus:border-[#064e3b] focus:ring-4 focus:ring-[#064e3b]/5 transition-all outline-none font-bold text-gray-700 text-sm appearance-none shadow-sm cursor-pointer">
                                    <option value="donor">Donor</option>
                                    <option value="porter">Campaign Porter</option>
                                </select>
                                <div class="absolute right-5 top-1/2 -translate-y-1/2 pointer-events-none text-gray-400">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                        <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                    </svg>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div>
                        <label class="block text-[10px] font-bold uppercase tracking-widest text-gray-400 mb-2 ml-1">Profile Photo</label>
                        <div class="flex items-center space-x-6 bg-white p-4 rounded-xl border border-gray-200 shadow-sm">
                            <div id="imagePreview"
                                class="w-14 h-14 rounded-full bg-gray-50 flex items-center justify-center overflow-hidden border border-gray-200 transition-colors">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-gray-300" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                                </svg>
                            </div>
                            <div class="flex-1">
                                <input type="file" id="image" accept="image/*"
                                    class="w-full text-xs text-gray-500 file:mr-4 file:py-2 file:px-5 file:rounded-full file:border-0 file:text-[10px] file:font-bold file:uppercase file:bg-gray-100 file:text-gray-700 hover:file:bg-[#064e3b] hover:file:text-white transition-all cursor-pointer">
                            </div>
                        </div>
                    </div>

                    <div class="pt-4">
                        <button type="submit" id="registerBtn"
                            class="w-full bg-[#1A1A1A] hover:bg-[#064e3b] text-white py-5 rounded-xl font-bold text-sm uppercase tracking-[0.2em] shadow-xl transition-all active:scale-[0.98]">
                            Create Account
                        </button>

                        <div class="text-center mt-6">
                            <p class="text-gray-500 font-medium text-[10px]">
                                Already have an account?
                                <a href="{{ route('login') }}" class="text-[#064e3b] font-bold hover:underline ml-1 uppercase">Sign in</a>
                            </p>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Right Side: Visual Asset overlay -->
    <div class="hidden md:block w-3/5 relative bg-transparent overflow-hidden">
        <!-- Main Asset Overlay (Logo centered) -->
        <div class="absolute inset-x-0 bottom-0 h-1/2 flex items-end justify-center pb-12 z-0 opacity-10 grayscale brightness-150">
             <img src="{{ asset('images/donifylg.png') }}" class="w-full h-auto object-contain">
        </div>

        <!-- Floating Quotes Overlay -->
        <div class="absolute inset-0 z-10 pointer-events-none p-12">
            <!-- Group 1: MASSIVE QUOTES -->
            <div class="absolute top-12 right-12 text-right max-w-[450px] opacity-100">
                <h3 class="text-4xl lg:text-5xl font-black text-[#1A1A1A] leading-tight italic mb-3">"The world is changed by your example."</h3>
                <p class="text-[#064e3b] font-bold uppercase tracking-[0.3em] text-[14px]">Paulo Coelho</p>
            </div>

            <div class="absolute bottom-12 right-12 text-right max-w-[500px] opacity-100">
                <h3 class="text-5xl lg:text-6xl font-black text-[#064e3b] leading-tight italic mb-4">"We make a life by what we give."</h3>
                <p class="text-[#1A1A1A] font-bold uppercase tracking-[0.3em] text-[16px]">Winston Churchill</p>
            </div>

            <!-- Group 2: GOLD & BOLD -->
            <div class="absolute top-1/4 left-10 text-left max-w-[350px] opacity-90">
                <h3 class="text-3xl font-black text-[#DAA520] leading-tight italic mb-2">"Happiness comes from your own actions."</h3>
                <p class="text-[#1A1A1A] font-bold uppercase tracking-widest text-[12px]">Dalai Lama</p>
            </div>

            <!-- New Quote -->
            <div class="absolute top-[40%] right-[15%] text-right max-w-[300px] opacity-100">
                <h3 class="text-4xl font-black text-[#DAA520] leading-tight italic mb-2">"Allah ydawmha naama"</h3>
                <p class="text-[#1A1A1A] font-bold uppercase tracking-widest text-[14px]">Sirajdin</p>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    // Image Preview logic
    document.getElementById('image').addEventListener('change', function(e) {
        const preview = document.getElementById('imagePreview');
        const file = e.target.files[0];
        if (file) {
            const reader = new FileReader();
            reader.onload = function(e) {
                preview.innerHTML = `<img src="${e.target.result}" class="w-full h-full object-cover">`;
                preview.classList.remove('border-dashed');
                preview.classList.add('border-solid', 'border-[#064e3b]');
            }
            reader.readAsDataURL(file);
        }
    });

    document.getElementById('registerForm').addEventListener('submit', async (e) => {
        e.preventDefault();

        const firstName = document.getElementById('first_name').value;
        const lastName = document.getElementById('last_name').value;
        const email = document.getElementById('email').value;
        const password = document.getElementById('password').value;
        const role = document.getElementById('role').value;
        const imageFile = document.getElementById('image').files[0];

        const formData = new FormData();
        formData.append('first_name', firstName);
        formData.append('last_name', lastName);
        formData.append('email', email);
        formData.append('password', password);
        formData.append('role', role);
        if (imageFile) {
            formData.append('image', imageFile);
        }

        const btn = document.getElementById('registerBtn');
        const errorDiv = document.getElementById('registerError');

        btn.disabled = true;
        btn.innerHTML =
            '<span class="flex items-center justify-center text-[10px]"><svg class="animate-spin h-3 w-3 mr-2" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg> PROCESSING...</span>';
        errorDiv.classList.add('hidden');

        try {
            await ApiClient.register(formData);
            await ApiClient.login(email, password);
            window.location.href = '/campaigns';
        } catch (error) {
            console.error(error);
            const message = error.message || (error.errors ? Object.values(error.errors)[0][0] :
                'Registration failed. Please check your details.');
            errorDiv.textContent = message;
            errorDiv.classList.remove('hidden');
            btn.disabled = false;
            btn.innerHTML = 'CREATE ACCOUNT';
        }
    });
</script>
@endsection
