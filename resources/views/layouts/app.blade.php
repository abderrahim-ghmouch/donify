<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Donify - Empowering Communities through Giving</title>
    
    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700&family=Quicksand:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    
    <!-- Tailwind CDN (using for layout) -->
    <script src="https://cdn.tailwindcss.com"></script>
    
    <!-- Custom Design Tokens & Utilities -->
    <style>
        :root {
            --primary: #02a95c;
            --primary-dark: #028b4c;
            --primary-light: #D1FAE5;
            --secondary: #6366F1;
            --dark: #0F172A;
            --light: #fbf8f6;
        }

        body {
            font-family: 'Quicksand', sans-serif;
            background-color: var(--light);
            color: var(--dark);
            overflow-x: hidden;
        }

        .font-outfit { font-family: 'Outfit', sans-serif; }
        .font-quicksand { font-family: 'Quicksand', sans-serif; }

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
    <nav class="fixed w-full z-50 top-0 transition-all duration-300 px-4 md:px-6 py-4" id="navbar">
        <div class="max-w-[98%] md:max-w-[95%] mx-auto flex items-center justify-between md:grid md:grid-cols-3 bg-[#fbf8f6]/80 backdrop-blur-md border border-black/10 rounded-[1.2rem] md:rounded-[1.5rem] px-4 md:px-8 py-2 shadow-[0_15px_40px_rgba(0,0,0,0.05)]">
            
            {{-- Mobile: Toggle --}}
            <div class="flex md:hidden items-center">
                <button id="mobile-menu-open" class="p-2.5 bg-black/5 hover:bg-black/10 rounded-xl text-[#1A1A1A] transition-all active:scale-95">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h8m-8 6h16" />
                    </svg>
                </button>
            </div>

            {{-- Left Side: Nav Links (Desktop Only) --}}
            <div class="hidden md:flex items-center space-x-10">
                <a href="{{ route('campaigns.index') }}" class="nav-link text-xs font-bold uppercase tracking-[0.2em] text-[#1A1A1A] hover:text-[#064e3b] transition-colors">Campaigns</a>
                <a href="{{ route('organisations.index') }}" class="nav-link text-xs font-bold uppercase tracking-[0.2em] text-[#1A1A1A] hover:text-[#064e3b] transition-colors">Organisations</a>
                <a href="#" class="nav-link text-xs font-bold uppercase tracking-[0.2em] text-[#1A1A1A] hover:text-[#064e3b] transition-colors">Impact</a>
            </div>

            {{-- Center: Logo --}}
            <div class="flex justify-center">
                <a href="{{ route('home') }}" class="group transition-transform hover:scale-105 active:scale-95">
                    <img src="{{ asset('images/donifylg.png') }}" alt="Donify Logo" class="h-8 md:h-12 w-auto object-contain">
                </a>
            </div>

            {{-- Right Side: Auth --}}
            <div class="flex items-center justify-end space-x-2 md:space-x-6">
                {{-- Auth User --}}
                <div class="auth-user hidden flex items-center space-x-3 md:space-x-6">
                    <a href="{{ route('dashboard') }}" id="navDashboardLink" class="hidden items-center bg-[#064e3b] hover:bg-black text-white px-4 md:px-6 py-2 rounded-full font-bold text-[10px] md:text-xs transition-all tracking-widest">
                        DASHBOARD
                    </a>
                    <button onclick="handleLogout()" class="text-gray-400 hover:text-black transition-all p-1">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 md:h-5 md:w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7" />
                        </svg>
                    </button>
                </div>
                
                {{-- Auth Guest --}}
                <div class="auth-guest flex items-center space-x-2 md:space-x-4">
                    <a href="{{ route('login') }}" class="hidden sm:inline-block text-[#1A1A1A] font-bold hover:text-[#064e3b] transition-colors text-[10px] md:text-xs uppercase tracking-widest px-2">Login</a>
                    <a href="{{ route('register') }}" class="bg-black text-white px-4 md:px-8 py-2 md:py-2.5 rounded-full font-bold text-[10px] md:text-xs uppercase tracking-widest hover:bg-[#996515] transition-all shadow-lg">JOIN</a>
                </div>
            </div>
        </div>

        {{-- Mobile Slide-out Menu --}}
        <div id="mobile-menu" class="fixed inset-0 z-[100] bg-black/90 backdrop-blur-xl translate-x-full transition-transform duration-500 md:hidden">
            <div class="flex flex-col h-full p-8">
                <div class="flex justify-between items-center mb-16">
                    <img src="{{ asset('images/donifylg.png') }}" class="h-8 w-auto brightness-0 invert">
                    <button id="mobile-menu-close" class="text-white p-2">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>
                
                <div class="flex flex-col space-y-8">
                    <a href="{{ route('campaigns.index') }}" class="text-white text-2xl font-bold tracking-[0.2em] uppercase">Campaigns</a>
                    <a href="{{ route('organisations.index') }}" class="text-white text-2xl font-bold tracking-[0.2em] uppercase">Organisations</a>
                    <a href="#" class="text-white text-2xl font-bold tracking-[0.2em] uppercase">Impact</a>
                    <hr class="border-white/10 my-4">
                    <a href="{{ route('login') }}" class="text-gray-400 text-xl font-bold uppercase tracking-widest">Login</a>
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
    <footer class="bg-gradient-to-br from-[#0b1612] via-[#012418] to-black border-t border-white/5 pt-24 pb-12 px-6 font-['Quicksand'] relative overflow-hidden">
    <!-- Decorative Glow -->
    <div class="absolute top-0 right-0 w-80 h-80 bg-[#02a95c]/10 blur-[120px] rounded-full translate-x-1/2 -translate-y-1/2"></div>
    
    <div class="max-w-7xl mx-auto relative z-10">
        <div class="grid grid-cols-1 md:grid-cols-4 gap-12 mb-20">
            <div class="md:col-span-1">
                <div class="flex items-center gap-3 mb-8">
                    <img src="{{ asset('images/donifylg.png') }}" alt="Donify Logo" class="h-10 w-auto brightness-0 invert opacity-90">
                    <span class="font-extrabold text-2xl text-white tracking-tight">Donify</span>
                </div>
                <p class="text-gray-400 font-medium leading-relaxed">
                    The world's most trusted gateway for meaningful giving. Change the world, one donation at a time.
                </p>
            </div>
            
            <div>
                <h4 class="font-bold text-white text-lg mb-6">Discover</h4>
                <ul class="space-y-4 text-gray-500 font-medium">
                    <li><a href="#" class="hover:text-[#02a95c] transition-colors">Medical</a></li>
                    <li><a href="#" class="hover:text-[#02a95c] transition-colors">Emergency</a></li>
                    <li><a href="#" class="hover:text-[#02a95c] transition-colors">Education</a></li>
                    <li><a href="#" class="hover:text-[#02a95c] transition-colors">Nonprofits</a></li>
                </ul>
            </div>

            <div>
                <h4 class="font-bold text-white text-lg mb-6">Donify</h4>
                <ul class="space-y-4 text-gray-500 font-medium">
                    <li><a href="#" class="hover:text-[#02a95c] transition-colors">About Us</a></li>
                    <li><a href="#" class="hover:text-[#02a95c] transition-colors">How it Works</a></li>
                    <li><a href="#" class="hover:text-[#02a95c] transition-colors">Pricing</a></li>
                    <li><a href="#" class="hover:text-[#02a95c] transition-colors">Careers</a></li>
                </ul>
            </div>

            <div>
                <h4 class="font-bold text-white text-lg mb-6">Support</h4>
                <ul class="space-y-4 text-gray-500 font-medium">
                    <li><a href="#" class="hover:text-[#02a95c] transition-colors">Help Center</a></li>
                    <li><a href="#" class="hover:text-[#02a95c] transition-colors">Trust & Safety</a></li>
                    <li><a href="#" class="hover:text-[#02a95c] transition-colors">Contact Us</a></li>
                </ul>
            </div>
        </div>
        
        <div class="border-t border-white/5 pt-10 flex flex-col md:flex-row justify-between items-center gap-6">
            <p class="text-gray-500 font-medium text-sm">
                &copy; {{ date('Y') }} Donify. Empowerment through giving.
            </p>
            <div class="flex gap-8 text-sm font-medium text-gray-500">
                <a href="#" class="hover:text-white transition-all underline decoration-emerald-500/30 underline-offset-4">Terms</a>
                <a href="#" class="hover:text-white transition-all underline decoration-emerald-500/30 underline-offset-4">Privacy</a>
                <a href="#" class="hover:text-white transition-all underline decoration-emerald-500/30 underline-offset-4">Legal</a>
            </div>
        </div>
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

        // Mobile Menu Toggle
        const mobileMenuOpen = document.getElementById('mobile-menu-open');
        const mobileMenuClose = document.getElementById('mobile-menu-close');
        const mobileMenu = document.getElementById('mobile-menu');

        mobileMenuOpen?.addEventListener('click', () => {
            mobileMenu.classList.remove('translate-x-full');
        });

        mobileMenuClose?.addEventListener('click', () => {
            mobileMenu.classList.add('translate-x-full');
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
                    if (userAvatarElement) userAvatarElement.innerHTML = `<img src="${user.images.url}" class="w-full h-full object-cover">`;
                }

                // Role-aware links
                if (user.role === 'porter' || user.role === 'organisation') { 
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

