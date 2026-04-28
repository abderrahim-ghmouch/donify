@php $hide_nav = true; $hide_footer = true; @endphp
@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-[#FAFAF5] font-quicksand text-black flex overflow-hidden selection:bg-emerald-500/30 font-sans">
    
    {{-- High-Intensity Prestige Glows --}}
    <div class="fixed inset-0 pointer-events-none overflow-hidden z-0">
        <div class="absolute -top-[10%] -right-[10%] w-[50%] h-[50%] bg-emerald-500/5 blur-[120px] rounded-full"></div>
        <div class="absolute -bottom-[10%] -left-[10%] w-[50%] h-[50%] bg-amber-500/5 blur-[120px] rounded-full"></div>
    </div>

    {{-- Precision Sidebar --}}
    <aside class="w-72 bg-white border-r-2 border-emerald-500/20 flex flex-col h-screen fixed top-0 left-0 z-50 shadow-2xl shadow-emerald-900/5">
        {{-- Brand Apex --}}
        <div class="p-10 flex flex-col items-center border-b-2 border-emerald-500/10 mb-8">
            <div class="relative group cursor-pointer transition-all duration-500">
                <div class="absolute -inset-4 bg-emerald-500/10 blur-xl rounded-full opacity-0 group-hover:opacity-100 transition-opacity"></div>
                <img src="{{ asset('images/donifylg.png') }}" class="h-10 w-auto relative z-10 opacity-90">
            </div>
            <div class="mt-8 text-[8px] font-black uppercase tracking-[0.5em] text-black font-sans">Protocol Control</div>
        </div>

        {{-- Nav Interface --}}
        <nav class="flex-1 px-4 space-y-1.5 overflow-y-auto [&::-webkit-scrollbar]:w-0">
            <div class="px-6 py-4 text-[9px] font-black uppercase tracking-[0.4em] text-black/20">Operations</div>
            
            <button onclick="showTab('campaigns')" id="btn-campaigns" class="admin-nav-btn group flex items-center justify-between gap-4 w-full px-6 py-4 rounded-xl text-[11px] font-bold uppercase tracking-widest transition-all duration-300 hover:bg-slate-100 text-black bg-slate-50 border-2 border-emerald-500/30">
                <div class="flex items-center gap-4">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path d="M19 11H5m14 0l-2-2m2 2l-2 2M5 11l2-2m-2 2l2 2"/></svg>
                    <span>Missions</span>
                </div>
            </button>

            <button onclick="showTab('users')" id="btn-users" class="admin-nav-btn group flex items-center justify-between gap-4 w-full px-6 py-4 rounded-xl text-[11px] font-bold uppercase tracking-widest transition-all duration-300 hover:bg-slate-100 text-black/40">
                <div class="flex items-center gap-4">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path d="M16 21v-2a4 4 0 00-4-4H5a4 4 0 00-4 4v2M8 7a4 4 0 100-8 4 4 0 000 8z"/></svg>
                    <span>Identities</span>
                </div>
            </button>

            <button onclick="showTab('partners')" id="btn-partners" class="admin-nav-btn group flex items-center justify-between gap-4 w-full px-6 py-4 rounded-xl text-[11px] font-bold uppercase tracking-widest transition-all duration-300 hover:bg-slate-100 text-black/40">
                <div class="flex items-center gap-4">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>
                    <span>Partners</span>
                </div>
            </button>

            <button onclick="showTab('categories')" id="btn-categories" class="admin-nav-btn group flex items-center justify-between gap-4 w-full px-6 py-4 rounded-xl text-[11px] font-bold uppercase tracking-widest transition-all duration-300 hover:bg-slate-100 text-black/40">
                <div class="flex items-center gap-4">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path d="M7 7h.01M7 3h5c.5 0 1 .2 1.4.6l7 7a2 2 0 010 2.8l-7 7a2 2 0 01-2.8 0l-7-7A2 2 0 013 12V7a4 4 0 014-4z"/></svg>
                    <span>Domains</span>
                </div>
            </button>
        </nav>

        {{-- Session End --}}
        <div class="p-8 border-t-2 border-amber-500/5 bg-slate-50/50">
            <button onclick="ApiClient.logout()" class="w-full bg-red-50 text-red-600 border-2 border-red-100 py-4 rounded-2xl text-[10px] font-black uppercase tracking-[0.2em] transition-all hover:bg-red-600 hover:text-white cursor-pointer shadow-sm">Terminate</button>
        </div>
    </aside>

    {{-- Production Environment --}}
    <main class="ml-72 flex-1 p-12 lg:p-20 overflow-y-auto h-screen relative z-10 [&::-webkit-scrollbar]:w-1 [&::-webkit-scrollbar-thumb]:bg-slate-200 [&::-webkit-scrollbar-track]:bg-transparent">
        
        {{-- Header Status --}}
        <header class="flex items-center justify-between mb-20">
            <div class="space-y-2">
                <h1 class="text-xs font-black uppercase tracking-[0.6em] text-black/30">Donify Administrative Layer</h1>
                <div class="text-5xl font-black text-black tracking-tighter">Command Center.</div>
            </div>
            <div class="flex items-center gap-6">
                <div class="px-8 py-4 bg-white border-2 border-emerald-500/30 rounded-2xl flex items-center gap-4 shadow-xl shadow-emerald-900/[0.03]">
                    <div class="w-2.5 h-2.5 rounded-full bg-emerald-500 animate-pulse"></div>
                    <span class="text-[10px] font-black uppercase tracking-[0.2em] text-black">Status: Operational</span>
                </div>
            </div>
        </header>

        {{-- Dynamic Workspace --}}
        <div class="space-y-20">
            
            {{-- Missions Registry --}}
            <section id="tab-campaigns" class="admin-tab space-y-12 animate-in fade-in slide-in-from-bottom-4 duration-1000">
                <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                    <div class="bg-white border-2 border-emerald-500/30 p-12 rounded-2xl space-y-3 shadow-xl shadow-emerald-900/[0.02]">
                        <div class="text-[10px] font-black uppercase tracking-[0.3em] text-black/20">Total Active Missions</div>
                        <div class="text-7xl font-black text-black tracking-tighter tabular-nums">{{ count($campaigns) }}</div>
                    </div>
                </div>

                <div class="bg-white rounded-2xl border-2 border-emerald-500/30 overflow-hidden shadow-2xl shadow-emerald-900/[0.05]">
                    <table class="w-full text-left">
                        <thead class="bg-slate-50 border-b border-amber-500/5">
                            <tr class="text-[10px] font-black uppercase tracking-[0.4em] text-amber-900/20">
                                <th class="px-12 py-10 text-emerald-800">Mission Identity</th>
                                <th class="px-12 py-10">Targeting</th>
                                <th class="px-12 py-10">Status</th>
                                <th class="px-12 py-10 text-right pr-20">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-amber-500/5">
                            @foreach($campaigns as $c)
                            <tr class="group hover:bg-emerald-50/30 transition-all">
                                <td class="px-12 py-12">
                                    <div class="font-black text-2xl text-black group-hover:text-emerald-800 transition-colors tracking-tighter">{{ $c->title }}</div>
                                    <div class="text-[11px] text-amber-900/40 uppercase tracking-[0.2em] mt-2 font-bold italic">Ref ID: {{ substr($c->id, 0, 8) }}</div>
                                </td>
                                <td class="px-12 py-12">
                                    <div class="font-black text-3xl text-[#C5A021] tracking-tighter tabular-nums">{{ number_format($c->target_amount) }} <span class="text-[14px] opacity-60 uppercase ml-1">Mad</span></div>
                                </td>
                                <td class="px-12 py-12">
                                    <span class="inline-flex items-center px-4 py-2 rounded-xl text-[10px] font-black uppercase tracking-widest {{ $c->status == 'active' ? 'bg-emerald-50 text-emerald-700 border-2 border-emerald-200/50' : 'bg-slate-50 text-slate-400 border-2 border-black/5' }}">
                                        {{ $c->status }}
                                    </span>
                                </td>
                                <td class="px-12 py-12 text-right pr-20">
                                    <div class="flex items-center justify-end gap-4">
                                        @if($c->status !== 'active')
                                        <button onclick="approveCampaign({{ $c->id }})" class="bg-black text-white px-8 py-3.5 rounded-xl text-[10px] font-black uppercase tracking-widest hover:bg-zinc-800 transition-all border-none">Accept</button>
                                        @endif
                                        <button onclick="rejectCampaign({{ $c->id }})" class="bg-black text-white px-8 py-3.5 rounded-xl text-[10px] font-black uppercase tracking-widest hover:bg-zinc-800 transition-all border-none">Reject</button>
                                    </div>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </section>

            {{-- Identities Registry --}}
            <section id="tab-users" class="admin-tab hidden space-y-12 animate-in fade-in slide-in-from-bottom-4 duration-1000">
                <div class="bg-white rounded-[3rem] border-2 border-amber-500/10 overflow-hidden shadow-2xl shadow-amber-900/[0.05]">
                    <table class="w-full text-left">
                        <thead class="bg-slate-50 border-b border-amber-500/5">
                            <tr class="text-[10px] font-black uppercase tracking-[0.4em] text-amber-900/20">
                                <th class="px-12 py-10">Entity Name</th>
                                <th class="px-12 py-10">Role Assigned</th>
                                <th class="px-12 py-10 text-right pr-20">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-amber-500/5">
                            @foreach($users as $u)
                            <tr class="hover:bg-emerald-50/30 transition-colors">
                                <td class="px-12 py-12 font-black text-xl text-black tracking-tight italic">{{ $u->first_name }} {{ $u->last_name }}</td>
                                <td class="px-12 py-12 text-[12px] font-black text-emerald-800 uppercase tracking-widest font-sans">{{ $u->role }}</td>
                                <td class="px-12 py-12 text-right pr-20">
                                    <button class="bg-black hover:bg-zinc-800 text-white px-8 py-3.5 rounded-xl text-[10px] font-black uppercase tracking-widest transition-all border-none">Interface</button>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </section>

            {{-- Partner Registry --}}
            <section id="tab-partners" class="admin-tab hidden space-y-12 animate-in fade-in slide-in-from-bottom-4 duration-1000">
                <div class="bg-white rounded-[3rem] border-2 border-amber-500/10 overflow-hidden shadow-2xl shadow-amber-900/[0.05]">
                    <table class="w-full text-left">
                        <thead class="bg-slate-50 border-b border-amber-500/5">
                            <tr class="text-[10px] font-black uppercase tracking-[0.4em] text-amber-900/20">
                                <th class="px-12 py-10">Legal Identity</th>
                                <th class="px-12 py-10">Verification Status</th>
                                <th class="px-12 py-10 text-right pr-20">Commands</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-amber-500/5">
                            @foreach($organisations as $o)
                            <tr class="hover:bg-emerald-50/30 transition-colors">
                                <td class="px-12 py-12 font-black text-2xl text-black uppercase tracking-tighter italic">{{ $o->name }}</td>
                                <td class="px-12 py-12">
                                    <span class="px-5 py-2 rounded-xl text-[10px] font-black uppercase tracking-tighter border {{ $o->is_verified ? 'text-emerald-700 border-emerald-200 bg-emerald-50' : 'text-amber-600 border-amber-100 bg-amber-50' }}">
                                        {{ $o->is_verified ? 'Official' : 'Pending' }}
                                    </span>
                                </td>
                                <td class="px-12 py-12 text-right pr-20">
                                    <div class="flex items-center justify-end gap-4">
                                        @if(!$o->is_verified)
                                        <button onclick="verifyOrg({{ $o->id }})" class="bg-black text-white px-8 py-3.5 rounded-xl text-[10px] font-black uppercase tracking-widest transition-all border-none">Accept</button>
                                        @else
                                        <button onclick="rejectOrg({{ $o->id }})" class="bg-black text-white px-8 py-3.5 rounded-xl text-[10px] font-black uppercase tracking-widest transition-all border-none hover:bg-zinc-800">Reject</button>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </section>

            {{-- Domain Registry --}}
            <section id="tab-categories" class="admin-tab hidden space-y-12 animate-in fade-in slide-in-from-bottom-4 duration-1000">
                <div class="grid grid-cols-1 xl:grid-cols-12 gap-12">
                    <div class="xl:col-span-4 bg-white p-12 rounded-2xl border-2 border-emerald-500/30 space-y-10 shadow-2xl shadow-emerald-900/[0.05]">
                        <div class="space-y-4">
                            <h3 class="text-3xl font-black text-black tracking-tighter leading-none">New Sector.</h3>
                            <p class="text-black/20 text-[10px] uppercase tracking-[0.5em] font-black">Register Expansion Domain</p>
                        </div>
                        <form action="#" class="space-y-8">
                            <div class="space-y-4">
                                <label class="text-[10px] font-black text-black/20 uppercase tracking-[0.4em] ml-2">Sector Label</label>
                                <input type="text" placeholder="e.g. INFRASTRUCTURE" class="w-full bg-slate-50 border-2 border-emerald-500/20 rounded-xl px-8 py-6 text-sm font-bold outline-none focus:border-emerald-500/50 transition-all placeholder:text-slate-300 text-black uppercase tracking-widest">
                            </div>
                            <button class="w-full bg-black text-white py-6 rounded-xl font-black text-[11px] uppercase tracking-[0.5em] shadow-xl shadow-black/10 hover:bg-zinc-800 transition-all">Initialize Sector</button>
                        </form>
                    </div>
                    <div class="xl:col-span-8 bg-white rounded-2xl border-2 border-emerald-500/30 overflow-hidden shadow-2xl shadow-emerald-900/[0.05]">
                        <table class="w-full text-left">
                            <thead class="bg-slate-50 border-b border-amber-500/5">
                                <tr class="text-[10px] font-black uppercase tracking-[0.4em] text-amber-900/20">
                                    <th class="px-12 py-10">Domain Label</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-amber-500/5">
                                @foreach($categories as $cat)
                                <tr class="group hover:bg-emerald-50/30 transition-colors"><td class="px-12 py-10 font-black text-lg text-black group-hover:text-emerald-800 uppercase tracking-widest">{{ $cat->category_name }}</td></tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </section>
        </div>
    </main>
</div>

@endsection
