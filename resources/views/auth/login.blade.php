@extends('layouts.app')

@section('content')
<div class="max-w-md mx-auto my-20 animate-fade-in">
    <div class="glass p-10 rounded-3xl shadow-xl border border-white/50">
        <div class="text-center mb-10">
            <h1 class="text-3xl font-bold font-outfit mb-2">Welcome Back</h1>
            <p class="text-gray-500">Sign in to continue making an impact.</p>
        </div>

        <form id="loginForm" class="space-y-6">
            <div id="loginError" class="hidden bg-red-50 text-red-500 p-4 rounded-xl text-sm border border-red-100"></div>

            <div>
                <label class="block text-sm font-semibold mb-2 ml-1">Email Address</label>
                <input type="email" id="email" required
                    class="w-full px-5 py-4 rounded-2xl bg-white border border-gray-100 focus:border-emerald-500 focus:ring-4 focus:ring-emerald-500/10 transition-all outline-none"
                    placeholder="name@example.com">
            </div>

            <div>
                <div class="flex justify-between mb-2 ml-1">
                    <label class="text-sm font-semibold">Password</label>
                    <a href="#" class="text-xs text-emerald-600 hover:text-emerald-700 font-medium">Forgot?</a>
                </div>
                <input type="password" id="password" required
                    class="w-full px-5 py-4 rounded-2xl bg-white border border-gray-100 focus:border-emerald-500 focus:ring-4 focus:ring-emerald-500/10 transition-all outline-none"
                    placeholder="••••••••">
            </div>

            <button type="submit" id="loginBtn"
                class="w-full btn-primary py-4 rounded-2xl font-bold text-lg shadow-lg shadow-emerald-200">
                Sign In
            </button>
        </form>

        <div class="text-center mt-10">
            <p class="text-gray-500 text-sm">
                Don't have an account? 
                <a href="{{ route('register') }}" class="text-emerald-600 font-bold hover:underline">Sign up</a>
            </p>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    document.getElementById('loginForm').addEventListener('submit', async (e) => {
        e.preventDefault();
        const email = document.getElementById('email').value;
        const password = document.getElementById('password').value;
        const btn = document.getElementById('loginBtn');
        const errorDiv = document.getElementById('loginError');

        btn.disabled = true;
        btn.innerHTML = '<span class="flex items-center justify-center"><svg class="animate-spin h-5 w-5 mr-3" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg> Signing in...</span>';
        errorDiv.classList.add('hidden');

        try {
            const data = await ApiClient.login(email, password);
            window.location.href = '/';
        } catch (error) {
            errorDiv.textContent = error.error || 'Invalid email or password. Please try again.';
            errorDiv.classList.remove('hidden');
            btn.disabled = false;
            btn.textContent = 'Sign In';
        }
    });
</script>
@endsection
