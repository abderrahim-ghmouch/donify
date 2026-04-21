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
    .step-indicator {
        width: 40px;
        height: 40px;
        display: flex;
        align-items: center;
        justify-content: center;
        border-radius: 12px;
        font-weight: 700;
        transition: all 0.3s ease;
    }
    .step-active {
        background: var(--primary);
        color: white;
        box-shadow: 0 10px 15px -3px rgba(47, 217, 28, 0.3);
    }
    .step-pending {
        background: #f1f5f9;
        color: #94a3b8;
    }
    .form-step {
        display: none;
        animation: slideIn 0.4s ease-out;
    }
    .form-step.active {
        display: block;
    }
    @keyframes slideIn {
        from { opacity: 0; transform: translateX(20px); }
        to { opacity: 1; transform: translateX(0); }
    }
</style>
@endsection

@section('content')
<div class="min-h-screen py-12 px-6 flex items-center justify-center bg-[#f8fafc] relative overflow-hidden">
    <!-- Abstract background elements -->
    <div class="absolute top-0 right-0 w-96 h-96 bg-emerald-100 rounded-full blur-[100px] opacity-50 -mr-48 -mt-48"></div>
    <div class="absolute bottom-0 left-0 w-96 h-96 bg-indigo-100 rounded-full blur-[100px] opacity-50 -ml-48 -mb-48"></div>

    <div class="max-w-5xl w-full grid grid-cols-1 lg:grid-cols-12 gap-8 items-center relative z-10">
        <!-- Left Side: Info -->
        <div class="lg:col-span-5 hidden lg:block">
            <h1 class="text-5xl font-extrabold font-outfit leading-tight mb-6">
                Amplify your <span class="text-emerald-500">Organisation's</span> Impact.
            </h1>
            <p class="text-lg text-slate-500 mb-8 leading-relaxed">
                Join Donify as a verified organization. Manage campaigns, build trust with donors, and transform more lives.
            </p>

            <div class="space-y-6">
                <div class="flex items-center space-x-4">
                    <div class="w-12 h-12 bg-white rounded-2xl shadow-sm flex items-center justify-center text-emerald-500">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
                        </svg>
                    </div>
                    <div>
                        <h4 class="font-bold text-slate-800">Verification Badge</h4>
                        <p class="text-sm text-slate-500">Get a verified status to increase donor confidence.</p>
                    </div>
                </div>
                <div class="flex items-center space-x-4">
                    <div class="w-12 h-12 bg-white rounded-2xl shadow-sm flex items-center justify-center text-blue-500">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 3.055A9.001 9.001 0 1020.945 13H11V3.055z" />
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20.488 9H15V3.512A9.025 9.025 0 0120.488 9z" />
                        </svg>
                    </div>
                    <div>
                        <h4 class="font-bold text-slate-800">Advanced Analytics</h4>
                        <p class="text-sm text-slate-500">Track donations and campaign performance in detail.</p>
                    </div>
                </div>
            </div>
            
            <div class="mt-12 p-6 bg-white/50 rounded-3xl border border-white/50">
                <p class="text-slate-600 italic">"Donify helped us reach 3x more supporters in just 6 months. The verification process is thorough but worth it."</p>
                <div class="mt-4 flex items-center space-x-3">
                    <div class="w-10 h-10 bg-slate-200 rounded-full"></div>
                    <div>
                        <p class="text-sm font-bold">Sarah Williams</p>
                        <p class="text-xs text-slate-400">Director, GreenHope Foundation</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Right Side: Form -->
        <div class="lg:col-span-7">
            <div class="auth-card rounded-[2rem] p-8 md:p-12">
                <div class="mb-10">
                    <h2 class="text-3xl font-bold font-outfit mb-2">Create Org Account</h2>
                    <p class="text-slate-500">Already have an account? <a href="{{ route('organisations.login') }}" class="text-emerald-500 font-bold hover:underline">Log in</a></p>
                </div>

                <!-- Progress Steps -->
                <div class="flex items-center space-x-4 mb-10">
                    <div class="step-indicator step-active" id="stepIndicator-1">1</div>
                    <div class="h-px flex-1 bg-slate-200"></div>
                    <div class="step-indicator step-pending" id="stepIndicator-2">2</div>
                    <div class="h-px flex-1 bg-slate-200"></div>
                    <div class="step-indicator step-pending" id="stepIndicator-3">3</div>
                </div>

                <form id="orgRegisterForm">
                    <!-- Step 1: Basic Account Info -->
                    <div class="form-step active" id="step-1">
                        <h3 class="font-bold text-lg mb-6">Basic Information</h3>
                        <div class="space-y-5">
                            <div>
                                <label class="block text-sm font-bold text-slate-700 mb-2">Organisation Name</label>
                                <input type="text" name="name" required class="w-full input-field px-5 py-3.5 rounded-2xl outline-none" placeholder="e.g. Red Cross International">
                            </div>
                            <div>
                                <label class="block text-sm font-bold text-slate-700 mb-2">Email Address</label>
                                <input type="email" name="email" required class="w-full input-field px-5 py-3.5 rounded-2xl outline-none" placeholder="contact@organisation.org">
                            </div>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                                <div>
                                    <label class="block text-sm font-bold text-slate-700 mb-2">Password</label>
                                    <input type="password" name="password" required class="w-full input-field px-5 py-3.5 rounded-2xl outline-none" placeholder="•••••••••">
                                </div>
                                <div>
                                    <label class="block text-sm font-bold text-slate-700 mb-2">Confirm Password</label>
                                    <input type="password" name="password_confirmation" required class="w-full input-field px-5 py-3.5 rounded-2xl outline-none" placeholder="•••••••••">
                                </div>
                            </div>
                        </div>
                        <div class="mt-10">
                            <button type="button" onclick="nextStep(2)" class="w-full btn-primary py-4 rounded-2xl font-bold flex items-center justify-center space-x-2">
                                <span>Next: Contact Details</span>
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd" d="M10.293 3.293a1 1 0 011.414 0l6 6a1 1 0 010 1.414l-6 6a1 1 0 01-1.414-1.414L14.586 11H3a1 1 0 110-2h11.586l-4.293-4.293a1 1 0 010-1.414z" clip-rule="evenodd" />
                                </svg>
                            </button>
                        </div>
                    </div>

                    <!-- Step 2: Contact & Description -->
                    <div class="form-step" id="step-2">
                        <h3 class="font-bold text-lg mb-6">Contact & Details</h3>
                        <div class="space-y-5">
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                                <div>
                                    <label class="block text-sm font-bold text-slate-700 mb-2">Phone Number</label>
                                    <input type="text" name="phone" required class="w-full input-field px-5 py-3.5 rounded-2xl outline-none" placeholder="+1 (555) 000-0000">
                                </div>
                                <div>
                                    <label class="block text-sm font-bold text-slate-700 mb-2">Address</label>
                                    <input type="text" name="address" required class="w-full input-field px-5 py-3.5 rounded-2xl outline-none" placeholder="123 Hope St, NY">
                                </div>
                            </div>
                            <div>
                                <label class="block text-sm font-bold text-slate-700 mb-2">Description</label>
                                <textarea name="description" rows="4" class="w-full input-field px-5 py-3.5 rounded-2xl outline-none resize-none" placeholder="Tell us about your mission..."></textarea>
                            </div>
                        </div>
                        <div class="mt-10 flex space-x-4">
                            <button type="button" onclick="nextStep(1)" class="w-1/3 bg-slate-100 text-slate-600 py-4 rounded-2xl font-bold hover:bg-slate-200 transition-all">Back</button>
                            <button type="button" onclick="nextStep(3)" class="flex-1 btn-primary py-4 rounded-2xl font-bold flex items-center justify-center space-x-2">
                                <span>Next: Verification</span>
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd" d="M10.293 3.293a1 1 0 011.414 0l6 6a1 1 0 010 1.414l-6 6a1 1 0 01-1.414-1.414L14.586 11H3a1 1 0 110-2h11.586l-4.293-4.293a1 1 0 010-1.414z" clip-rule="evenodd" />
                                </svg>
                            </button>
                        </div>
                    </div>

                    <!-- Step 3: Verification Documents -->
                    <div class="form-step" id="step-3">
                        <h3 class="font-bold text-lg mb-6">Official Verification</h3>
                        <div class="space-y-6">
                            <div class="p-6 bg-amber-50 rounded-2xl border border-amber-100 flex items-start space-x-4">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-amber-500 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                                <p class="text-sm text-amber-800 leading-relaxed">
                                    To protect our community, we require a formal document (Tax ID, Registration Certificate, or similar) to verify your organisation's identity.
                                </p>
                            </div>
                            
                            <div>
                                <label class="block text-sm font-bold text-slate-700 mb-2">Verification Document (PDF, JPG, PNG)</label>
                                <div class="relative group">
                                    <div class="w-full py-10 border-2 border-dashed border-slate-200 rounded-2xl flex flex-col items-center justify-center group-hover:border-emerald-500 transition-all bg-slate-50">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-10 w-10 text-slate-300 mb-3 group-hover:text-emerald-500 transition-all" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12" />
                                        </svg>
                                        <p class="text-slate-500 text-sm font-medium">Click to upload document</p>
                                        <p id="fileName" class="text-emerald-500 text-xs mt-2 font-bold"></p>
                                    </div>
                                    <input type="file" name="document" id="documentInput" required class="absolute inset-0 opacity-0 cursor-pointer" onchange="updateFileName(this)">
                                </div>
                            </div>

                            <div>
                                <label class="block text-sm font-bold text-slate-700 mb-2">Logo (Optional)</label>
                                <input type="file" name="logo" class="w-full text-sm text-slate-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-bold file:bg-emerald-50 file:text-emerald-700 hover:file:bg-emerald-100 cursor-pointer">
                            </div>
                        </div>

                        <div class="mt-10 flex space-x-4">
                            <button type="button" onclick="nextStep(2)" class="w-1/3 bg-slate-100 text-slate-600 py-4 rounded-2xl font-bold hover:bg-slate-200 transition-all">Back</button>
                            <button type="submit" id="submitBtn" class="flex-1 bg-slate-800 text-white py-4 rounded-2xl font-bold hover:bg-slate-900 transition-all shadow-lg flex items-center justify-center space-x-2">
                                <span>Submit Registration</span>
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd" />
                                </svg>
                            </button>
                        </div>
                    </div>
                </form>

                <div id="successMessage" class="hidden mt-8 text-center animate-bounce">
                    <div class="w-16 h-16 bg-emerald-100 text-emerald-500 rounded-full flex items-center justify-center mx-auto mb-4">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                        </svg>
                    </div>
                    <h4 class="text-xl font-bold text-slate-800">Registration Submitted!</h4>
                    <p class="text-slate-500 mt-2">We've received your application. Our team will verify your organization within 24-48 hours. Watch your email!</p>
                    <a href="{{ route('home') }}" class="inline-block mt-6 text-emerald-500 font-bold">Back to Home</a>
                </div>

                <div id="errorMessage" class="hidden mt-6 p-4 bg-red-50 text-red-600 rounded-xl text-sm font-medium border border-red-100">
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    function nextStep(step) {
        // Toggle steps
        document.querySelectorAll('.form-step').forEach(el => el.classList.remove('active'));
        document.getElementById('step-' + step).classList.add('active');
        
        // Update indicators
        document.querySelectorAll('.step-indicator').forEach((el, index) => {
            if (index + 1 === step) {
                el.classList.add('step-active');
                el.classList.remove('step-pending');
            } else if (index + 1 < step) {
                el.classList.add('step-active');
                el.classList.remove('step-pending');
            } else {
                el.classList.remove('step-active');
                el.classList.add('step-pending');
            }
        });
    }

    function updateFileName(input) {
        const fileName = input.files[0] ? input.files[0].name : '';
        document.getElementById('fileName').textContent = fileName ? 'Selected: ' + fileName : '';
    }

    document.getElementById('orgRegisterForm').addEventListener('submit', async (e) => {
        e.preventDefault();
        const form = e.target;
        const btn = document.getElementById('submitBtn');
        const errorEl = document.getElementById('errorMessage');
        const successEl = document.getElementById('successMessage');
        
        errorEl.classList.add('hidden');
        btn.disabled = true;
        btn.innerHTML = 'Processing...';

        const fd = new FormData(form);

        try {
            const data = await ApiClient.registerOrganisation(fd);
            console.log('Success:', data);
            form.classList.add('hidden');
            successEl.classList.remove('hidden');
            
            // Scroll to success message
            successEl.scrollIntoView({ behavior: 'smooth', block: 'center' });
        } catch (err) {
            console.error('Error:', err);
            errorEl.textContent = err.error || err.message || (err.errors ? Object.values(err.errors).flat()[0] : 'An error occurred. Please try again.');
            errorEl.classList.remove('hidden');
        } finally {
            btn.disabled = false;
            btn.innerHTML = 'Submit Registration';
        }
    });
</script>
@endsection
