@php $hide_nav = true; @endphp
@extends('layouts.app')

@section('styles')
<style>
    .font-quicksand { font-family: 'Quicksand', sans-serif; }
    
    .admin-sidebar {
        background: linear-gradient(to right, rgba(2, 44, 34, 0.98), rgba(6, 78, 59, 0.7));
        backdrop-filter: blur(25px);
        -webkit-backdrop-filter: blur(25px);
        border: none;
        box-shadow: 20px 0 80px rgba(0,0,0,0.3);
    }

    .nav-btn {
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        position: relative;
        margin: 0.25rem 1rem;
        border-radius: 1.5rem;
    }

    .nav-btn.active {
        color: #DAA520 !important;
        background: rgba(218, 165, 32, 0.05);
    }

    .nav-btn.active svg {
        color: #DAA520;
    }

    .nav-btn.active::before {
        content: '';
        position: absolute;
        left: 0;
        top: 25%;
        bottom: 25%;
        width: 3px;
        background: #DAA520;
        border-radius: 0 4px 4px 0;
    }

    .panel-card {
        background: white;
        border: 1px solid #f0f0f0;
        border-radius: 3rem;
        box-shadow: 0 30px 60px rgba(0,0,0,0.02);
        transition: transform 0.4s ease;
    }

    .panel-card:hover {
        transform: translateY(-5px);
    }

    .stat-badge {
        font-family: 'Quicksand', sans-serif;
        font-weight: 800;
        text-transform: uppercase;
        letter-spacing: 0.15em;
        font-size: 0.6rem;
        padding: 0.4rem 1rem;
        border-radius: 0.75rem;
    }

    /* Modern Table */
    thead th {
        font-family: 'Quicksand', sans-serif;
        text-transform: uppercase;
        letter-spacing: 0.2em;
        font-size: 0.65rem;
        font-weight: 900;
        color: #94a3b8;
        padding: 1.5rem 2.5rem;
    }

    /* Scrollbar */
    ::-webkit-scrollbar { width: 4px; }
    ::-webkit-scrollbar-track { background: transparent; }
    ::-webkit-scrollbar-thumb { background: #e2e8f0; border-radius: 10px; }
</style>
@endsection

@section('content')

    {{-- ── SCREEN SHIELDS ── --}}
    <div id="adminLoading" class="fixed inset-0 z-[100] bg-[#fbf8f6] flex items-center justify-center font-quicksand">
        <div class="flex flex-col items-center">
            <div class="w-12 h-12 border-2 border-[#064e3b]/20 border-t-[#064e3b] rounded-full animate-spin"></div>
            <p class="mt-8 text-[10px] font-black text-gray-300 uppercase tracking-[0.4em]">Initializing Core</p>
        </div>
    </div>

    <div id="adminGuest" class="hidden min-h-screen bg-[#fbf8f6] flex items-center justify-center p-8 font-quicksand">
        <div class="bg-white rounded-[3.5rem] p-20 text-center shadow-2xl border border-black/5 max-w-sm">
            <img src="{{ asset('images/donifylg.png') }}" class="h-20 mx-auto opacity-10 mb-10 grayscale">
            <h2 class="text-3xl font-black text-[#1A1A1A] mb-4 italic tracking-tight">Clearance Required.</h2>
            <p class="text-gray-400 text-sm mb-10 leading-relaxed font-medium">Please sign in with administrative credentials.</p>
            <a href="{{ route('login') }}" class="inline-block w-full bg-[#1A1A1A] text-white py-5 rounded-2xl font-black text-[10px] uppercase tracking-[0.2em] transition-all hover:bg-[#064e3b]">Establish Link</a>
        </div>
    </div>

    {{-- ── MAIN ADMIN ARCHITECTURE ── --}}
    <div id="adminContent" style="display:none" class="min-h-screen bg-[#fbf8f6] flex font-quicksand relative overflow-hidden">

        {{-- Decorative Aurora for Glass SideBar --}}
        <div class="absolute top-0 left-0 w-[400px] h-screen bg-gradient-to-br from-[#DAA520]/5 to-transparent pointer-events-none z-0"></div>

        {{-- Mobile Overlay --}}
        <div id="sidebarOverlay" class="fixed inset-0 bg-black/10 backdrop-blur-sm z-40 lg:hidden hidden" onclick="closeSidebar()"></div>

        {{-- ── COMMAND SIDEBAR ── --}}
        <aside id="sidebar" class="fixed top-0 left-0 z-50 h-full w-80 admin-sidebar flex flex-col transform -translate-x-full lg:translate-x-0 transition-transform duration-500 ease-in-out">
            <div class="p-10 mb-6">
                <div class="flex flex-col items-center gap-4">
                    <img src="{{ asset('images/slogan.png') }}" class="w-48 h-auto shadow-sm">
                    <div class="w-full h-px bg-white/10 mt-4"></div>
                </div>
            </div>

            <nav class="flex-1 px-6 space-y-2">
                <div class="px-4 mb-4 text-[10px] font-black uppercase tracking-[0.3em] text-white/40">Operations</div>
                
                <button onclick="goTab('overview',this)" class="nav-btn active w-full flex items-center gap-4 px-5 py-4 text-[11px] font-black uppercase tracking-widest text-white/60 hover:text-white hover:bg-white/5 cursor-pointer text-left border-none outline-none">
                    <svg class="w-5 h-5 opacity-60" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M3 3h7v7H3zM14 3h7v7h-7zM3 14h7v7H3zM14 14h7v7h-7z"/></svg>
                    Intelligence
                </button>
                
                <button onclick="goTab('campaigns',this)" class="nav-btn w-full flex items-center gap-4 px-5 py-4 text-[11px] font-black uppercase tracking-widest text-white/60 hover:text-white hover:bg-white/5 cursor-pointer text-left border-none outline-none">
                    <svg class="w-5 h-5 opacity-60" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M19 11H5m14 0l-2-2m2 2l-2 2M5 11l2-2m-2 2l2 2"/></svg>
                    Moderation
                </button>
                
                <button onclick="goTab('users',this)" class="nav-btn w-full flex items-center gap-4 px-5 py-4 text-[11px] font-black uppercase tracking-widest text-white/60 hover:text-white hover:bg-white/5 cursor-pointer text-left border-none outline-none">
                    <svg class="w-5 h-5 opacity-60" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M16 21v-2a4 4 0 00-4-4H5a4 4 0 00-4 4v2M8 7a4 4 0 100-8 4 4 0 000 8z"/></svg>
                    Identities
                </button>
                
                <button onclick="goTab('organisations',this)" class="nav-btn w-full flex items-center gap-4 px-5 py-4 text-[11px] font-black uppercase tracking-widest text-white/60 hover:text-white hover:bg-white/5 cursor-pointer text-left border-none outline-none">
                    <svg class="w-5 h-5 opacity-60" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>
                    Partners
                </button>
                
                <button onclick="goTab('categories',this)" class="nav-btn w-full flex items-center gap-4 px-5 py-4 text-[11px] font-black uppercase tracking-widest text-white/60 hover:text-white hover:bg-white/5 cursor-pointer text-left border-none outline-none">
                    <svg class="w-5 h-5 opacity-60" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M7 7h.01M7 3h5c.5 0 1 .2 1.4.6l7 7a2 2 0 010 2.8l-7 7a2 2 0 01-2.8 0l-7-7A2 2 0 013 12V7a4 4 0 014-4z"/></svg>
                    Domains
                </button>
            </nav>

            <div class="p-8 border-t border-white/5">
                <button onclick="ApiClient.logout()" class="w-full flex items-center gap-4 px-5 py-4 rounded-2xl text-[11px] font-black uppercase tracking-widest text-red-500 hover:bg-red-500/10 active:scale-95 transition-all text-left border-none cursor-pointer">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path d="M17 16l4-4m0 0l-4-4m4 4H7"/></svg>
                    Terminate Session
                </button>
            </div>
        </aside>

        {{-- ── WORKSPACE AREA ── --}}
        <div class="lg:ml-80 flex-1 flex flex-col min-w-0 h-screen overflow-y-auto">
            
            {{-- Modern Header --}}
            <header class="sticky top-0 z-40 bg-[#fbf8f6]/80 backdrop-blur-xl h-24 flex items-center justify-between px-10 border-b border-black/5">
                <div class="flex items-center gap-6">
                    <button onclick="openSidebar()" class="p-3 rounded-xl hover:bg-white lg:hidden border border-black/5 cursor-pointer bg-white shadow-sm">
                        <svg class="w-6 h-6 text-[#1A1A1A]" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M4 6h16M4 12h16M4 18h16"/></svg>
                    </button>
                    <div>
                        <h1 id="panelTitle" class="text-2xl font-black text-[#1A1A1A] tracking-tight italic">Intelligence.</h1>
                        <span class="text-[9px] font-black uppercase tracking-[0.3em] text-[#064e3b]">System Operational</span>
                    </div>
                </div>
                
                {{-- Profile Pill --}}
                <div class="flex items-center gap-4 bg-white pl-2 pr-6 py-2 rounded-2xl border border-black/5 shadow-sm">
                    <div id="sbAv" class="w-10 h-10 rounded-xl bg-[#1A1A1A] text-white font-black flex items-center justify-center text-[11px] overflow-hidden uppercase">A</div>
                    <div class="hidden sm:block">
                        <p id="sbName" class="text-[11px] font-black text-[#1A1A1A] uppercase tracking-wider">Admin</p>
                        <p class="text-[9px] text-[#DAA520] font-black uppercase tracking-widest">Master Console</p>
                    </div>
                </div>
            </header>

            {{-- Main Content --}}
            <main class="flex-1 p-10 max-w-7xl w-full mx-auto pb-32">

                {{-- Overview Tabs --}}
                <div id="panel-overview" class="view-panel space-y-10 animate-fade-up">
                    <div class="grid grid-cols-1 lg:grid-cols-2 gap-10">
                        
                        <div class="panel-card overflow-hidden">
                            <div class="px-10 py-8 border-b border-black/5 flex items-center justify-between bg-white">
                                <h3 class="text-[10px] font-black text-gray-400 uppercase tracking-[0.3em]">Pending Verification</h3>
                                <div class="w-2 h-2 rounded-full bg-[#DAA520]"></div>
                            </div>
                            <div id="ovPend" class="divide-y divide-black/5"></div>
                            <div class="p-6 text-center">
                                <button onclick="goTab('campaigns')" class="text-[9px] font-black text-[#064e3b] hover:underline tracking-widest uppercase cursor-pointer border-none bg-transparent">Access Full Moderation Matrix</button>
                            </div>
                        </div>

                        <div class="panel-card overflow-hidden">
                            <div class="px-10 py-8 border-b border-black/5 flex items-center justify-between bg-white">
                                <h3 class="text-[10px] font-black text-gray-400 uppercase tracking-[0.3em]">Partner Requests</h3>
                                <div class="w-2 h-2 rounded-full bg-[#064e3b]"></div>
                            </div>
                            <div id="ovOrgs" class="divide-y divide-black/5"></div>
                            <div class="p-6 text-center">
                                <button onclick="goTab('organisations')" class="text-[9px] font-black text-[#064e3b] hover:underline tracking-widest uppercase cursor-pointer border-none bg-transparent">Explore Partner Network</button>
                            </div>
                        </div>

                    </div>
                </div>

                {{-- Campaigns --}}
                <div id="panel-campaigns" class="hidden view-panel space-y-8 animate-fade-up">
                    <div class="panel-card overflow-hidden">
                        <div id="campWrap" class="min-h-[400px]"></div>
                    </div>
                </div>

                {{-- Users --}}
                <div id="panel-users" class="hidden view-panel space-y-8 animate-fade-up">
                    <div class="panel-card overflow-hidden">
                        <div id="userWrap" class="min-h-[400px]"></div>
                    </div>
                </div>

                {{-- Organisations --}}
                <div id="panel-organisations" class="hidden view-panel space-y-8 animate-fade-up">
                    <div class="panel-card overflow-hidden">
                        <div id="orgWrap" class="min-h-[400px]"></div>
                    </div>
                </div>

                {{-- Categories --}}
                <div id="panel-categories" class="hidden view-panel space-y-10 animate-fade-up">
                    <div class="flex flex-col xl:flex-row gap-10 items-start">
                        
                        <div class="w-full xl:w-[400px] bg-[#1A1A1A] rounded-[3rem] p-12 shadow-2xl relative overflow-hidden group">
                           <div class="absolute inset-0 bg-[#064e3b] translate-y-full group-hover:translate-y-[92%] transition-transform duration-700"></div>
                           <div class="relative z-10">
                                <h3 class="text-2xl font-black text-white mb-2 italic tracking-tight">New Domain.</h3>
                                <p class="text-white/40 text-[10px] mb-10 font-bold uppercase tracking-widest">Expansion Protocol</p>
                                
                                <div class="space-y-6">
                                    <div>
                                        <label class="block text-[9px] font-black text-white/30 uppercase tracking-[0.2em] mb-3">Domain Identity</label>
                                        <input id="catName" type="text" placeholder="e.g. Humanitarian" 
                                            class="w-full bg-white/5 border border-white/10 rounded-2xl px-6 py-4 text-sm font-bold text-white outline-none focus:border-[#DAA520] transition-all">
                                    </div>
                                    <button id="catBtn" onclick="createCat()" 
                                        class="w-full bg-[#DAA520] text-[#1A1A1A] py-5 rounded-2xl font-black text-xs uppercase tracking-[0.2em] transition-all hover:scale-[1.02] active:scale-95 border-none cursor-pointer">
                                        Establish Domain
                                    </button>
                                </div>
                           </div>
                        </div>

                        <div class="flex-1 w-full panel-card overflow-hidden min-h-[500px]">
                            <div class="px-12 py-8 border-b border-black/5 flex items-center justify-between">
                                <h3 class="text-[11px] font-black text-[#1A1A1A] uppercase tracking-[0.2em]">Active Matrix Domains</h3>
                                <div id="catCount" class="text-[10px] font-black text-[#DAA520] bg-[#DAA520]/5 px-3 py-1 rounded-lg">0 Total</div>
                            </div>
                            <div id="catGrid" class="p-8 grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-2 gap-5 text-left"></div>
                        </div>
                    </div>
                </div>

            </main>
        </div>
    </div>

    {{-- Tactical Feedback (Toast) --}}
    <div id="toast" class="fixed bottom-10 right-10 z-[100] bg-[#1A1A1A] text-white px-10 py-5 rounded-2xl text-[10px] font-black uppercase tracking-[0.2em] shadow-2xl transition-all duration-700 opacity-0 translate-y-20 pointer-events-none italic border-l-4 border-[#DAA520]"></div>

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
            overview: 'Intelligence.',
            campaigns: 'Moderation.',
            users: 'Identities.',
            organisations: 'Partners.',
            categories: 'Domains.'
        };

        function goTab(name, btn) {
            document.querySelectorAll('.view-panel').forEach(p => p.classList.add('hidden'));
            const p = document.getElementById('panel-' + name);
            if(p) p.classList.remove('hidden');

            document.getElementById('panelTitle').textContent = VIEW_CONFIG[name] || 'Intelligence.';

            document.querySelectorAll('.nav-btn').forEach(b => b.classList.remove('active'));
            
            if(btn) {
                btn.classList.add('active');
            } else {
                const first = document.querySelector('.nav-btn');
                if(first) first.classList.add('active');
            }
            
            closeSidebar();
        }
        window.goTab = goTab;
    </script>
    <script src="{{ asset('js/admin-dashboard.js') }}"></script>
@endsection
