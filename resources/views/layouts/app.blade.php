<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Donify - Empowering Communities through Giving</title>
    
    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700&family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">
    
    <!-- Tailwind CDN (using for layout) -->
    <script src="https://cdn.tailwindcss.com"></script>
    
    <!-- Custom Design Tokens & Utilities -->
    <style>
        :root {
            --primary: #2fd91cff;
            --primary-dark: #185f49ff;
            --primary-light: #D1FAE5;
            --secondary: #6366F1;
            --dark: #0F172A;
            --light: #F8FAFC;
        }

        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            background-color: var(--light);
            color: var(--dark);
            overflow-x: hidden;
        }

        .font-outfit { font-family: 'Outfit', sans-serif; }

        .glass {
            background: rgba(255, 255, 255, 0.7);
            backdrop-filter: blur(10px);
            -webkit-backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.3);
        }

        .btn-primary {
            background-color: var(--primary);
            color: white;
            transition: all 0.3s ease;
        }

        .btn-primary:hover {
            background-color: var(--primary-dark);
            transform: translateY(-2px);
            box-shadow: 0 10px 15px -3px rgba(16, 185, 129, 0.3);
        }

        .text-gradient {
            background: linear-gradient(135deg, var(--primary) 0%, var(--secondary) 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }

        .nav-link {
            position: relative;
            color: var(--dark);
            font-weight: 500;
            transition: color 0.3s ease;
        }

        .nav-link::after {
            content: '';
            position: absolute;
            width: 0;
            height: 2px;
            bottom: -4px;
            left: 0;
            background-color: var(--primary);
            transition: width 0.3s ease;
        }

        .nav-link:hover::after {
            width: 100%;
        }
    </style>
    @yield('styles')
</head>
<body class="antialiased">
    <!-- Navbar -->
    @unless(isset($hide_nav) && $hide_nav)
    <nav class="fixed w-full z-50 top-0 transition-all duration-300 px-6 py-4" id="navbar">
        <div class="max-w-[95%] mx-auto grid grid-cols-3 items-center bg-[#fbf8f6]/80 backdrop-blur-md border border-black rounded-[1.5rem] px-8 py-2 shadow-[0_15px_40px_rgba(0,0,0,0.08)]">
            
            {{-- Left Side: Nav Links --}}
            <div class="hidden md:flex items-center space-x-10">
                <a href="{{ route('campaigns.index') }}" class="nav-link text-xs font-bold uppercase tracking-[0.2em] text-gray-800 hover:text-[#02a95c] transition-colors">Campaigns</a>
                <a href="{{ route('organisations.index') }}" class="nav-link text-xs font-bold uppercase tracking-[0.2em] text-gray-800 hover:text-[#02a95c] transition-colors">Organisations</a>
                <a href="#" class="nav-link text-xs font-bold uppercase tracking-[0.2em] text-gray-800 hover:text-[#02a95c] transition-colors">Impact</a>
            </div>

            {{-- Center: Logo --}}
            <div class="flex justify-center">
                <a href="{{ route('home') }}" class="group transition-transform hover:scale-105 active:scale-95">
                    <img src="{{ asset('images/donifylg.png') }}?v={{ time() }}" alt="Donify Logo" class="h-12 w-auto object-contain">
                </a>
            </div>

            {{-- Right Side: Auth --}}
            <div class="flex items-center justify-end space-x-6">
                <div class="auth-user hidden flex items-center space-x-6">
                    <a href="{{ route('profile') }}" id="navProfileLink" class="text-gray-800 font-bold hover:text-[#02a95c] transition-colors text-xs uppercase tracking-widest">Profile</a>
                    <a href="{{ route('dashboard') }}" id="navDashboardLink" class="hidden items-center gap-1.5 bg-[#02a95c] hover:bg-[#028b4c] text-white px-6 py-2.5 rounded-full font-bold text-xs transition-all shadow-lg shadow-[#02a95c]/20">
                        Dashboard
                    </a>
                    <button onclick="handleLogout()" class="text-gray-400 hover:text-black transition-all p-2">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7" />
                        </svg>
                    </button>
                </div>
                
                <div class="auth-guest flex items-center space-x-6">
                    <a href="{{ route('login') }}" class="text-gray-800 font-bold hover:text-[#02a95c] transition-colors text-xs uppercase tracking-widest">Login</a>
                    <a href="{{ route('register') }}" class="bg-black text-white px-8 py-2.5 rounded-full font-bold text-xs uppercase tracking-widest hover:bg-gray-800 transition-all shadow-xl shadow-black/10">Get Started</a>
                </div>
            </div>

        </div>
    </nav>
    @endunless

    <!-- Main Content -->
    <main class="{{ (isset($hide_nav) && $hide_nav) ? '' : 'pt-24' }} min-h-screen">
        @yield('content')
    </main>

    <!-- Footer -->
    @unless(isset($hide_nav) && $hide_nav)
    <footer class="bg-slate-900 text-white py-20 px-6 mt-20">
        <div class="max-w-7xl mx-auto grid grid-cols-1 md:grid-cols-4 gap-12">
            <div class="col-span-1 md:col-span-1">
                <div class="flex items-center space-x-3 mb-6">
                    <img src="{{ asset('images/donifylg.png') }}" alt="Donify Logo" class="h-10 w-auto">
                    <span class="text-2xl font-bold font-outfit tracking-tighter">Donify</span>
                </div>
                <p class="text-slate-400 leading-relaxed">
                    Donify is a global crowdfunding platform empowering individuals and organizations to raise funds for what matters most.
                </p>
            </div>
            <div>
                <h4 class="font-bold mb-6 text-lg">Platform</h4>
                <ul class="space-y-4 text-slate-400">
                    <li><a href="#" class="hover:text-emerald-400 transition-colors">How it Works</a></li>
                    <li><a href="#" class="hover:text-emerald-400 transition-colors">Campaigns</a></li>
                    <li><a href="#" class="hover:text-emerald-400 transition-colors">Organisations</a></li>
                    <li><a href="#" class="hover:text-emerald-400 transition-colors">Safety</a></li>
                </ul>
            </div>
            <div>
                <h4 class="font-bold mb-6 text-lg">Support</h4>
                <ul class="space-y-4 text-slate-400">
                    <li><a href="#" class="hover:text-emerald-400 transition-colors">Help Center</a></li>
                    <li><a href="#" class="hover:text-emerald-400 transition-colors">Privacy Policy</a></li>
                    <li><a href="#" class="hover:text-emerald-400 transition-colors">Terms of Service</a></li>
                    <li><a href="#" class="hover:text-emerald-400 transition-colors">Contact Us</a></li>
                </ul>
            </div>
            <div>
                <h4 class="font-bold mb-6 text-lg">Newsletter</h4>
                <p class="text-slate-400 mb-4">Get updates on impactful campaigns.</p>
                <div class="flex">
                    <input type="email" placeholder="Email" class="bg-slate-800 border-none rounded-l-xl px-4 py-2 w-full focus:ring-1 focus:ring-emerald-500">
                    <button class="bg-emerald-500 px-4 py-2 rounded-r-xl hover:bg-emerald-600 transition-colors">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M10.293 3.293a1 1 0 011.414 0l6 6a1 1 0 010 1.414l-6 6a1 1 0 01-1.414-1.414L14.586 11H3a1 1 0 110-2h11.586l-4.293-4.293a1 1 0 010-1.414z" clip-rule="evenodd" />
                        </svg>
                    </button>
                </div>
            </div>
        </div>
        <div class="max-w-7xl mx-auto pt-12 mt-12 border-t border-slate-800 text-center text-slate-500 text-sm">
            &copy; {{ date('Y') }} Donify. All rights reserved.
        </div>
    </footer>
    @endunless

    <!-- Native JavaScript for Interactions -->
    <script src="{{ asset('js/api-client.js') }}"></script>
    <script>
        // Navbar Scroll Effect
        window.addEventListener('scroll', () => {
            const nav = document.getElementById('navbar');
            if (window.scrollY > 50) {
                nav.classList.remove('py-4');
                nav.classList.add('py-2');
            } else {
                nav.classList.remove('py-2');
                nav.classList.add('py-4');
            }
        });

        // Universal UI Auth Guard
        function updateAuthUI() {
            const guestElements = document.querySelectorAll('.auth-guest');
            const userElements = document.querySelectorAll('.auth-user');
            const userNameElements = document.querySelectorAll('.user-name');
            const userAvatarElement = document.getElementById('userAvatar');
            const dashLink = document.getElementById('navDashboardLink');
            const adminLink = document.getElementById('navAdminLink');

            const hide = el => { if(el){ el.classList.add('hidden'); el.classList.remove('inline-flex'); } };
            const show = el => { if(el){ el.classList.remove('hidden'); el.classList.add('inline-flex'); } };

            if (ApiClient.isAuthenticated()) {
                const user = ApiClient.getUser();
                guestElements.forEach(el => el.classList.add('hidden'));
                userElements.forEach(el => el.classList.remove('hidden'));
                userNameElements.forEach(el => el.textContent = user.first_name);

                if (user.images && user.images.url) {
                    userAvatarElement.innerHTML = `<img src="${user.images.url}" class="w-full h-full object-cover">`;
                }

                // Role-aware links
                if (user.role === 'porter') { 
                    show(dashLink); 
                    hide(adminLink); 
                } else if (user.role === 'admin') { 
                    hide(dashLink); 
                    show(adminLink); 
                } else { 
                    hide(dashLink); 
                    hide(adminLink); 
                }
            } else {
                guestElements.forEach(el => el.classList.remove('hidden'));
                userElements.forEach(el => el.classList.add('hidden'));
                hide(dashLink);
                hide(adminLink);
            }
        }

        document.addEventListener('DOMContentLoaded', updateAuthUI);

        function handleLogout() {
            ApiClient.logout();
        }
    </script>
    @yield('scripts')
</body>
</html>

