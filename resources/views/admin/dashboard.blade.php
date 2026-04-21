@php $hide_nav = true; @endphp
@extends('layouts.app')

@section('content')

    {{-- ── SCREEN SHIELDS ── --}}
    <div id="adminLoading" class="fixed inset-0 z-[100] bg-slate-50 flex items-center justify-center">
        <div class="flex flex-col items-center">
            <div class="w-12 h-12 border-2 border-slate-200 border-t-black rounded-full animate-spin"></div>
            <p class="mt-4 text-[10px] font-bold text-slate-400 uppercase tracking-widest">Admin Console Init</p>
        </div>
    </div>

    <div id="adminGuest" class="hidden min-h-screen bg-slate-50 flex items-center justify-center p-6">
        <div class="bg-white border-2 border-slate-200 rounded-lg p-12 text-center shadow-sm max-w-sm w-full">
            <h2 class="text-2xl font-bold text-black mb-8">Access Restricted</h2>
            <a href="{{ route('login') }}" class="inline-block w-full bg-black text-white py-4 rounded-lg font-bold transition-all duration-300 hover:opacity-80 active:scale-95">Sign In</a>
        </div>
    </div>

    {{-- ── MAIN ADMIN LAYOUT ── --}}
    <div id="adminContent" style="display:none" class="min-h-screen bg-gradient-to-tr from-slate-50 to-emerald-50/30 flex">

        {{-- Mobile Overlay --}}
        <div id="sidebarOverlay" class="fixed inset-0 bg-slate-900/10 backdrop-blur-sm z-40 lg:hidden hidden" onclick="closeSidebar()"></div>

        {{-- ── SIDEBAR ── --}}
        <aside id="sidebar" class="fixed top-0 left-0 z-50 h-full w-64 bg-white border-r-2 border-slate-100 flex flex-col transform -translate-x-full lg:translate-x-0 transition-transform duration-300 ease-in-out">
            <div class="p-8 border-b border-slate-50">
                <div class="flex items-center gap-3">
                    <div class="w-8 h-8 bg-black rounded-lg flex items-center justify-center text-white">
                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path d="M12 21.6C6.37 16.06 1 11.3 1 7.19 1 3.4 4.07 2 6.28 2c1.31 0 4.15.5 5.72 4.46C13.59 2.49 16.46 2 17.72 2 20.26 2 23 3.62 23 7.18c0 4.07-5.14 8.63-11 14.42z"/></svg>
                    </div>
                    <span class="text-xl font-bold text-black">Donify</span>
                </div>
            </div>

            <nav class="flex-1 px-4 py-6 space-y-1">
                <button onclick="goTab('overview',this)" class="nav-btn nav-active w-full flex items-center gap-3 px-4 py-3 rounded-lg text-sm font-bold text-black bg-slate-50 border-none cursor-pointer text-left transition-all duration-300 hover:bg-slate-50">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path d="M3 3h7v7H3zM14 3h7v7h-7zM3 14h7v7H3zM14 14h7v7h-7z"/></svg>
                    Dashboard
                </button>
                <button onclick="goTab('campaigns',this)" class="nav-btn w-full flex items-center gap-3 px-4 py-3 rounded-lg text-sm font-medium text-slate-500 bg-transparent border-none cursor-pointer text-left transition-all duration-300 hover:bg-slate-50 hover:text-black">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M19 11H5m14 0l-2-2m2 2l-2 2M5 11l2-2m-2 2l2 2"/></svg>
                    Campaigns
                </button>
                <button onclick="goTab('users',this)" class="nav-btn w-full flex items-center gap-3 px-4 py-3 rounded-lg text-sm font-medium text-slate-500 bg-transparent border-none cursor-pointer text-left transition-all duration-300 hover:bg-slate-50 hover:text-black">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M16 21v-2a4 4 0 00-4-4H5a4 4 0 00-4 4v2M8 7a4 4 0 100-8 4 4 0 000 8z"/></svg>
                    Users
                </button>
                <button onclick="goTab('organisations',this)" class="nav-btn w-full flex items-center gap-3 px-4 py-3 rounded-lg text-sm font-medium text-slate-500 bg-transparent border-none cursor-pointer text-left transition-all duration-300 hover:bg-slate-50 hover:text-black">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/></svg>
                    Partners
                </button>
                <button onclick="goTab('categories',this)" class="nav-btn w-full flex items-center gap-3 px-4 py-3 rounded-lg text-sm font-medium text-slate-500 bg-transparent border-none cursor-pointer text-left transition-all duration-300 hover:bg-slate-50 hover:text-black">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M7 7h.01M7 3h5c.5 0 1 .2 1.4.6l7 7a2 2 0 010 2.8l-7 7a2 2 0 01-2.8 0l-7-7A2 2 0 013 12V7a4 4 0 014-4z"/></svg>
                    Categories
                </button>
            </nav>

            <div class="p-4 border-t border-slate-50">
                <button onclick="ApiClient.logout()" class="w-full flex items-center gap-3 px-4 py-3 rounded-lg text-sm font-bold text-red-500 bg-transparent border-none cursor-pointer text-left transition-all duration-300 hover:bg-red-50">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path d="M17 16l4-4m0 0l-4-4m4 4H7"/></svg>
                    Logout
                </button>
            </div>
        </aside>

        {{-- ── MAIN AREA ── --}}
        <div class="lg:ml-64 flex-1 flex flex-col min-w-0 h-screen overflow-y-auto">
            
            {{-- Top Nav Bar --}}
            <header class="sticky top-6 z-40 mx-8 bg-white/70 backdrop-blur-md border-2 border-slate-100 rounded-xl shadow-sm h-16 flex items-center justify-between px-8 transition-all">
                <div class="flex items-center gap-4">
                    <button onclick="openSidebar()" class="p-2 rounded-lg hover:bg-slate-50 lg:hidden border-none cursor-pointer">
                        <svg class="w-6 h-6 text-slate-600" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M4 6h16M4 12h16M4 18h16"/></svg>
                    </button>
                    <h1 id="panelTitle" class="text-sm font-bold text-black uppercase tracking-widest">Dashboard</h1>
                </div>
                <div class="flex items-center gap-4">
                    <div id="sbAv" class="w-8 h-8 rounded-lg bg-black text-white font-bold flex items-center justify-center text-[10px] overflow-hidden uppercase">A</div>
                    <div class="hidden sm:block">
                        <p id="sbName" class="text-[11px] font-bold text-black truncate">Admin</p>
                        <p class="text-[9px] text-slate-400 font-medium uppercase tracking-widest">Master Console</p>
                    </div>
                </div>
            </header>

            {{-- Main Content --}}
            <main class="flex-1 p-8 max-w-7xl w-full mx-auto pb-20">

                {{-- Pages --}}
                
                <div id="panel-overview" class="view-panel space-y-8 animate-in fade-in duration-500">
                    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
                        <div class="bg-white border-2 border-slate-100 rounded-lg shadow-sm">
                            <div class="px-8 py-6 border-b border-slate-50 flex items-center justify-between">
                                <h3 class="text-[10px] font-bold text-slate-400 uppercase tracking-[0.2em]">Pending Review</h3>
                                <button onclick="goTab('campaigns')" class="text-[10px] font-bold text-black hover:underline cursor-pointer border-none bg-transparent">View Matrix</button>
                            </div>
                            <div id="ovPend" class="divide-y divide-slate-50"></div>
                        </div>
                        <div class="bg-white border-2 border-slate-100 rounded-lg shadow-sm">
                            <div class="px-8 py-6 border-b border-slate-50 flex items-center justify-between">
                                <h3 class="text-[10px] font-bold text-slate-400 uppercase tracking-[0.2em]">New Partners</h3>
                                <button onclick="goTab('organisations')" class="text-[10px] font-bold text-black hover:underline cursor-pointer border-none bg-transparent">Verify All</button>
                            </div>
                            <div id="ovOrgs" class="divide-y divide-slate-50"></div>
                        </div>
                    </div>
                </div>

                <div id="panel-campaigns" class="hidden view-panel space-y-6">
                    <div class="bg-white border-2 border-slate-100 rounded-lg shadow-sm overflow-hidden">
                        <div id="campWrap" class="min-h-[300px]"></div>
                    </div>
                </div>

                <div id="panel-users" class="hidden view-panel space-y-6">
                    <div class="bg-white border-2 border-slate-100 rounded-lg shadow-sm overflow-hidden">
                        <div id="userWrap" class="min-h-[300px]"></div>
                    </div>
                </div>

                <div id="panel-organisations" class="hidden view-panel space-y-6">
                    <div class="bg-white border-2 border-slate-100 rounded-lg shadow-sm overflow-hidden">
                        <div id="orgWrap" class="min-h-[300px]"></div>
                    </div>
                </div>

                <div id="panel-categories" class="hidden view-panel space-y-8">
                    <div class="flex flex-col xl:flex-row gap-8 items-start">
                        <div class="w-full xl:w-[380px] bg-white border-2 border-slate-100 rounded-lg p-8 shadow-sm">
                            <h3 class="text-lg font-bold text-black mb-6">Add Domain</h3>
                            <div class="space-y-4">
                                <input id="catName" type="text" placeholder="Health, Tech..." class="w-full border border-slate-200 rounded-lg px-4 py-3 text-sm font-medium outline-none focus:border-black transition-all">
                                <button id="catBtn" onclick="createCat()" class="w-full bg-black text-white py-3 rounded-lg font-bold text-sm transition-all duration-300 hover:opacity-80 active:scale-95 border-none cursor-pointer">Create Category</button>
                            </div>
                        </div>
                        <div class="flex-1 w-full bg-white border-2 border-slate-100 rounded-lg shadow-sm overflow-hidden min-h-[400px]">
                            <div class="px-8 py-5 border-b border-slate-50 flex items-center justify-between">
                                <h3 class="text-sm font-bold text-black">Active Domains</h3>
                                <div id="catCount" class="text-[10px] font-bold text-slate-400">0 Items</div>
                            </div>
                            <div id="catGrid" class="p-6 grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4"></div>
                        </div>
                    </div>
                </div>

            </main>
        </div>
    </div>

    {{-- Notification Toast --}}
    <div id="toast" class="fixed bottom-10 right-10 z-[100] bg-black text-white px-8 py-4 rounded-lg text-xs font-bold shadow-2xl transition-all duration-500 opacity-0 translate-y-20 pointer-events-none"></div>

@endsection

@section('scripts')
    <script>
        function openSidebar() {
            document.getElementById('sidebar').classList.remove('-translate-x-full');
            document.getElementById('sidebarOverlay').classList.remove('hidden');
        }
        function closeSidebar() {
            document.getElementById('sidebar').classList.add('-translate-x-full');
            document.getElementById('sidebarOverlay').classList.add('hidden');
        }

        const VIEW_CONFIG = {
            overview: 'Dashboard',
            campaigns: 'Campaign Moderation',
            users: 'Citizen Database',
            organisations: 'Partner Network',
            categories: 'Domain Mapping'
        };

        function goTab(name, btn) {
            document.querySelectorAll('.view-panel').forEach(p => p.classList.add('hidden'));
            const p = document.getElementById('panel-' + name);
            if(p) p.classList.remove('hidden');

            document.getElementById('panelTitle').textContent = VIEW_CONFIG[name] || 'Admin';

            document.querySelectorAll('.nav-btn').forEach(b => {
                b.classList.remove('nav-active', 'bg-slate-50', 'text-black');
                b.classList.add('bg-transparent', 'text-slate-500', 'font-medium');
            });
            
            const target = btn || document.querySelectorAll('.nav-btn')[0];
            if(target) {
                target.classList.add('nav-active', 'bg-slate-50', 'text-black');
                target.classList.remove('bg-transparent', 'text-slate-500', 'font-medium');
            }
            closeSidebar();
        }
        window.goTab = goTab;
    </script>
    <script src="{{ asset('js/admin-dashboard.js') }}"></script>
@endsection

@section('styles')
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;500;600;700;800;900&display=swap" rel="stylesheet">
    {{-- TAILWIND ONLY - NO CUSTOM CSS BLOCKS --}}
@endsection
