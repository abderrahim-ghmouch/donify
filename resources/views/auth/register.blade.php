@extends('layouts.app')

@section('content')
<div class="max-w-xl mx-auto my-10 animate-fade-in">
    <div class="glass p-10 rounded-3xl shadow-xl border border-white/50">
        <div class="text-center mb-10">
            <h1 class="text-3xl font-bold font-outfit mb-2 text-gradient">Join Donify</h1>
            <p class="text-gray-500">Start your journey of giving and impact today.</p>
        </div>

        <form id="registerForm" class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div id="registerError" class="col-span-1 md:col-span-2 hidden bg-red-50 text-red-500 p-4 rounded-xl text-sm border border-red-100"></div>

            <div>
                <label class="block text-xl font-semibold mb-2 ml-1">First Name</label>
                <input type="text" id="first_name" required
                    class="w-full px-5 py-4 rounded-2xl bg-white border border-gray-100 focus:border-emerald-500 focus:ring-4 focus:ring-emerald-500/10 transition-all outline-none"
                    placeholder="John">
            </div>

            <div>
                <label class="block text-sm font-semibold mb-2 ml-1">Last Name</label>
                <input type="text" id="last_name" required
                    class="w-full px-5 py-4 rounded-2xl bg-white border border-gray-100 focus:border-emerald-500 focus:ring-4 focus:ring-emerald-500/10 transition-all outline-none"
                    placeholder="Doe">
            </div>

            <div class="col-span-1 md:col-span-2">
                <label class="block text-sm font-semibold mb-2 ml-1">Email Address</label>
                <input type="email" id="email" required
                    class="w-full px-5 py-4 rounded-2xl bg-white border border-gray-100 focus:border-emerald-500 focus:ring-4 focus:ring-emerald-500/10 transition-all outline-none"
                    placeholder="john@example.com">
            </div>

            <div class="col-span-1 md:col-span-2">
                <label class="block text-sm font-semibold mb-2 ml-1">Password</label>
                <input type="password" id="password" required
                    class="w-full px-5 py-4 rounded-2xl bg-white border border-gray-100 focus:border-emerald-500 focus:ring-4 focus:ring-emerald-500/10 transition-all outline-none"
                    placeholder="Min. 9 characters">
            </div>

            <div class="col-span-1 md:col-span-2">
                <label class="block text-sm font-semibold mb-2 ml-1">Profile Picture</label>
                <div class="flex items-center space-x-4">
                    <div id="imagePreview" class="w-16 h-16 rounded-2xl bg-gray-100 flex items-center justify-center overflow-hidden border-2 border-dashed border-gray-200">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                        </svg>
                    </div>
                    <div class="flex-1">
                        <input type="file" id="image" accept="image/*"
                            class="w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-xl file:border-0 file:text-sm file:font-semibold file:bg-emerald-50 file:text-emerald-700 hover:file:bg-emerald-100 transition-all cursor-pointer">
                        <p class="text-xs text-gray-400 mt-1">Optional. Max 2MB (JPG, PNG)</p>
                    </div>
                </div>
            </div>

            <div class="col-span-1 md:col-span-2">
                <label class="block text-sm font-semibold mb-2 ml-1">I want to join as</label>
                <select id="role" class="w-full px-5 py-4 rounded-2xl bg-white border border-gray-100 focus:border-emerald-500 focus:ring-4 focus:ring-emerald-500/10 transition-all outline-none appearance-none">
                    <option value="donor">Donor (Support causes)</option>
                    <option value="porter">Campaign Porter (Create causes)</option>
                </select>
            </div>

            <div class="col-span-1 md:col-span-2">
                <button type="submit" id="registerBtn"
                    class="w-full btn-primary py-4 rounded-2xl font-bold text-lg shadow-lg shadow-emerald-200 mt-4">
                    Create Account
                </button>
            </div>
        </form>

        <div class="text-center mt-10">
            <p class="text-gray-500 text-sm">
                Already have an account? 
                <a href="{{ route('login') }}" class="text-emerald-600 font-bold hover:underline">Sign in</a>
            </p>
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
        btn.innerHTML = '<span class="flex items-center justify-center"><svg class="animate-spin h-5 w-5 mr-3" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg> Creating account...</span>';
        errorDiv.classList.add('hidden');

        try {
            await ApiClient.register(formData);
            // After successful registration, try to log them in automatically
            await ApiClient.login(email, password);
            window.location.href = '/';
        } catch (error) {
            console.error(error);
            const message = error.message || (error.errors ? Object.values(error.errors)[0][0] : 'Registration failed. Please check your details.');
            errorDiv.textContent = message;
            errorDiv.classList.remove('hidden');
            btn.disabled = false;
            btn.innerHTML = 'Create Account';
        }
    });
</script>
@endsection
