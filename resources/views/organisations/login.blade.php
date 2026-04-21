@extends('layouts.app')

@section('styles')
<style>
    .auth-card {
        background: rgba(255, 255, 255, 0.9);
        backdrop-filter: blur(20px);
        border: 1px solid rgba(255, 255, 255, 0.5);
        box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.1);
    }
    .input-field {
        background: #f8fafc;
        border: 1px solid #e2e8f0;
        transition: all 0.3s ease;
    }
    .input-field:focus {
        border-color: var(--primary);
        background: white;
        box-shadow: 0 0 0 4px rgba(47, 217, 28, 0.1);
    }
    .login-hero {
        background: linear-gradient(135deg, #10b981 0%, #3b82f6 100%);
    }
</style>
@endsection

@section('content')
<div class="min-h-screen py-12 px-6 flex items-center justify-center bg-[#f8fafc] relative overflow-hidden">
    <!-- Background elements -->
    <div class="absolute top-0 right-0 w-96 h-96 bg-emerald-100 rounded-full blur-[100px] opacity-40 -mr-48 -mt-48"></div>
    <div class="absolute bottom-0 left-0 w-[500px] h-[500px] bg-blue-50 rounded-full blur-[120px] opacity-40 -ml-64 -mb-64"></div>

    <div class="max-w-md w-full relative z-10">
        <div class="auth-card rounded-[2.5rem] p-8 md:p-12">
            <div class="mb-10 text-center">
                <div class="w-16 h-16 bg-emerald-500 rounded-2xl flex items-center justify-center text-white mx-auto mb-6 shadow-lg shadow-emerald-200">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                    </svg>
                </div>
                <h2 class="text-3xl font-bold font-outfit mb-2">Organisation Login</h2>
                <p class="text-slate-500">Access your impact dashboard</p>
            </div>

            <form id="orgLoginForm" class="space-y-6">
                <div>
                    <label class="block text-sm font-bold text-slate-700 mb-2">Email Address</label>
                    <div class="relative">
                        <span class="absolute inset-y-0 left-0 pl-4 flex items-center text-slate-400">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 12a4 4 0 10-8 0 4 4 0 008 0zm0 0v1.5a2.5 2.5 0 005 0V12a9 9 0 10-9 9m4.5-1.206a8.959 8.959 0 01-4.5 1.207" />
                            </svg>
                        </span>
                        <input type="email" name="email" required class="w-full input-field pl-12 pr-5 py-4 rounded-2xl outline-none" placeholder="name@organisation.org">
                    </div>
                </div>

                <div>
                    <div class="flex justify-between items-center mb-2">
                        <label class="text-sm font-bold text-slate-700">Password</label>
                        <a href="#" class="text-xs font-bold text-emerald-500 hover:underline">Forgot?</a>
                    </div>
                    <div class="relative">
                        <span class="absolute inset-y-0 left-0 pl-4 flex items-center text-slate-400">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                            </svg>
                        </span>
                        <input type="password" name="password" required class="w-full input-field pl-12 pr-5 py-4 rounded-2xl outline-none" placeholder="•••••••••">
                    </div>
                </div>

                <div class="flex items-center space-x-3 py-2">
                    <input type="checkbox" id="remember" class="w-4 h-4 rounded text-emerald-500 focus:ring-emerald-500 border-slate-300">
                    <label for="remember" class="text-sm text-slate-500 font-medium cursor-pointer">Remember this device</label>
                </div>

                <button type="submit" id="submitBtn" class="w-full bg-slate-800 text-white py-4 rounded-2xl font-bold hover:bg-slate-900 transition-all shadow-lg shadow-slate-200 mt-2">
                    Login to Dashboard
                </button>
            </form>

            <div id="errorMessage" class="hidden mt-6 p-4 bg-red-50 text-red-600 rounded-xl text-sm font-medium border border-red-100"></div>

            <div class="mt-10 pt-8 border-t border-slate-100 text-center">
                <p class="text-slate-500">New Organisation? <a href="{{ route('organisations.register') }}" class="text-emerald-500 font-bold hover:underline">Apply Now</a></p>
            </div>
        </div>

        <div class="mt-8 text-center">
            <a href="{{ route('login') }}" class="text-slate-400 text-sm font-medium hover:text-slate-600 transition-colors">Are you an individual donor? Click here</a>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    document.getElementById('orgLoginForm').addEventListener('submit', async (e) => {
        e.preventDefault();
        const btn = document.getElementById('submitBtn');
        const errorEl = document.getElementById('errorMessage');
        const email = e.target.email.value;
        const password = e.target.password.value;

        errorEl.classList.add('hidden');
        btn.disabled = true;
        btn.innerHTML = 'Authenticating...';

        try {
            const data = await ApiClient.loginOrganisation(email, password);
            console.log('Login successful:', data);
            
            // Redirect to dashboard (porters and organisations might share the dashboard or have specialized ones)
            window.location.href = '/dashboard';
        } catch (err) {
            console.error('Login error:', err);
            let msg = err.error || err.message || 'Invalid credentials.';
            
            if (err.status === 'pending') {
                msg = 'Your account is still awaiting administrator verification.';
            }
            
            errorEl.textContent = msg;
            errorEl.classList.remove('hidden');
        } finally {
            btn.disabled = false;
            btn.innerHTML = 'Login to Dashboard';
        }
    });
</script>
@endsection
