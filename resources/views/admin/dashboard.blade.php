@php $hide_nav = true; @endphp
@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-[#064e3b] font-quicksand text-white flex overflow-hidden">
    
    {{-- High-Density Green Sidebar --}}
    <aside class="w-80 bg-black/20 backdrop-blur-3xl border-r border-white/10 flex flex-col h-screen fixed top-0 left-0 shadow-2xl">
        <div class="p-16 flex flex-col items-center border-b border-white/5">
            <img src="{{ asset('images/donifylg.png') }}" class="h-12 w-auto mb-6 brightness-0 invert">
            <div class="text-[10px] font-black uppercase tracking-[0.5em] text-white/40">Command Center</div>
        </div>

        <nav class="flex-1 p-8 space-y-3 overflow-y-auto custom-scrollbar">
            <div class="px-6 mb-10 text-[9px] font-black uppercase tracking-[0.6em] text-white/20">Operational Matrix</div>
            
            <button onclick="showTab('campaigns')" id="btn-campaigns" class="admin-nav-btn active group flex items-center gap-5 w-full px-8 py-5 rounded-2xl text-[11px] font-black uppercase tracking-widest transition-all hover:bg-white/10 border border-transparent hover:border-white/10">
                <svg class="w-5 h-5 opacity-40 group-hover:opacity-100 transition-opacity" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M19 11H5m14 0l-2-2m2 2l-2 2M5 11l2-2m-2 2l2 2"/></svg>
                Campaigns
            </button>
            <button onclick="showTab('users')" id="btn-users" class="admin-nav-btn group flex items-center gap-5 w-full px-8 py-5 rounded-2xl text-[11px] font-black uppercase tracking-widest transition-all hover:bg-white/10 border border-transparent hover:border-white/10">
                <svg class="w-5 h-5 opacity-40 group-hover:opacity-100 transition-opacity" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M16 21v-2a4 4 0 00-4-4H5a4 4 0 00-4 4v2M8 7a4 4 0 100-8 4 4 0 000 8z"/></svg>
                Identities
            </button>
            @php 
                $pendingOrgs = $organisations->where('is_verified', false)->count();
            @endphp
            <button onclick="showTab('partners')" id="btn-partners" class="admin-nav-btn group flex items-center justify-between gap-5 w-full px-8 py-5 rounded-2xl text-[11px] font-black uppercase tracking-widest transition-all hover:bg-white/10 border border-transparent hover:border-white/10">
                <div class="flex items-center gap-5 text-left">
                    <svg class="w-5 h-5 opacity-40 group-hover:opacity-100 transition-opacity" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>
                    Partners
                </div>
            </button>
            <button onclick="showTab('categories')" id="btn-categories" class="admin-nav-btn group flex items-center gap-5 w-full px-8 py-5 rounded-2xl text-[11px] font-black uppercase tracking-widest transition-all hover:bg-white/10 border border-transparent hover:border-white/10">
                <svg class="w-5 h-5 opacity-40 group-hover:opacity-100 transition-opacity" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M7 7h.01M7 3h5c.5 0 1 .2 1.4.6l7 7a2 2 0 010 2.8l-7 7a2 2 0 01-2.8 0l-7-7A2 2 0 013 12V7a4 4 0 014-4z"/></svg>
                Categories
            </button>
        </nav>

        <div class="p-10 border-t border-white/5 bg-black/10">
            <button onclick="ApiClient.logout()" class="w-full bg-white text-[#064e3b] py-5 rounded-2xl text-[10px] font-black uppercase tracking-[0.3em] transition-all hover:bg-red-50 hover:text-red-600 shadow-xl cursor-pointer border-none">Terminate Session</button>
        </div>
    </aside>

    {{-- Main Production Workspace --}}
    <main class="ml-80 flex-1 p-20 overflow-y-auto h-screen bg-[#05392d]">
        
        {{-- Campaigns Registry --}}
        <div id="tab-campaigns" class="admin-tab space-y-12 animate-in fade-in slide-in-from-bottom-5 duration-500">
            <div class="flex items-end justify-between">
                <div>
                    <h1 class="text-6xl font-black tracking-tighter mb-2">Missions.</h1>
                    <p class="text-white/40 text-xs font-bold uppercase tracking-[0.3em]">Campaign Registry Statistics</p>
                </div>
                <div class="flex gap-4">
                    <div class="bg-white/5 border border-white/10 px-8 py-4 rounded-2xl">
                        <div class="text-[9px] font-black text-white/30 uppercase tracking-widest">Total Volume</div>
                        <div class="text-xl font-black">{{ count($campaigns) }}</div>
                    </div>
                </div>
            </div>

            <div class="bg-white/5 rounded-[2.5rem] border border-white/10 overflow-hidden backdrop-blur-3xl shadow-2xl">
                <table class="w-full text-left">
                    <thead class="bg-white/5 text-[9px] uppercase tracking-[0.4em] font-black text-white/30">
                        <tr>
                            <th class="px-12 py-8">Operational Name</th>
                            <th class="px-12 py-8">Target Allocation</th>
                            <th class="px-12 py-8">Current Mode</th>
                            <th class="px-12 py-8 text-right">Protocol</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-white/5">
                        @foreach($campaigns as $c)
                        <tr class="hover:bg-white/[0.03] transition-all group border-none">
                            <td class="px-12 py-10 font-black text-sm tracking-tight">{{ $c->title }}</td>
                            <td class="px-12 py-10 font-bold text-xs opacity-60">{{ number_format($c->target_amount) }} <span class="text-[9px]">MAD</span></td>
                            <td class="px-12 py-10">
                                <span class="px-5 py-2 rounded-xl text-[9px] font-black uppercase tracking-widest {{ $c->status == 'active' ? 'bg-emerald-500 text-[#064e3b]' : 'bg-white/10 text-white/60' }}">
                                    {{ $c->status }}
                                </span>
                            </td>
                            <td class="px-12 py-10 text-right space-x-2">
                                @if($c->status !== 'active')
                                <button onclick="approveCampaign({{ $c->id }})" class="bg-emerald-500 text-[#064e3b] hover:bg-emerald-400 px-6 py-3 rounded-xl text-[9px] font-black uppercase tracking-widest transition-all shadow-lg active:scale-95">Approve</button>
                                @endif
                                <button onclick="rejectCampaign({{ $c->id }})" class="bg-red-500/20 text-red-300 hover:bg-red-500 hover:text-white px-6 py-3 rounded-xl text-[9px] font-black uppercase tracking-widest transition-all active:scale-95">Reject</button>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

        {{-- Identities Matrix --}}
        <div id="tab-users" class="admin-tab hidden space-y-12 animate-in fade-in slide-in-from-bottom-5 duration-500">
            <div>
                <h1 class="text-6xl font-black tracking-tighter mb-2">Identities.</h1>
                <p class="text-white/40 text-xs font-bold uppercase tracking-[0.3em]">Access Protocol Management</p>
            </div>
            <div class="bg-white/5 rounded-[2.5rem] border border-white/10 overflow-hidden backdrop-blur-3xl shadow-2xl">
                <table class="w-full text-left">
                    <thead class="bg-white/5 text-[9px] uppercase tracking-[0.4em] font-black text-white/30">
                        <tr>
                            <th class="px-12 py-8">Entity Identity</th>
                            <th class="px-12 py-8">Role Assigned</th>
                            <th class="px-12 py-8">Access Level</th>
                            <th class="px-12 py-8 text-right">Control</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-white/5">
                        @foreach($users as $u)
                        <tr class="hover:bg-white/[0.03] transition-all group border-none">
                            <td class="px-12 py-10 font-black text-sm tracking-tight">{{ $u->first_name }} {{ $u->last_name }}</td>
                            <td class="px-12 py-10 font-bold text-[10px] opacity-40 uppercase tracking-widest">{{ $u->role }}</td>
                            <td class="px-12 py-10">
                                <span class="px-5 py-2 rounded-xl text-[9px] font-black uppercase tracking-widest {{ !$u->is_banned ? 'bg-emerald-500/20 text-emerald-300' : 'bg-red-500/20 text-red-300 border border-red-500/30' }}">
                                    {{ !$u->is_banned ? 'Authorized' : 'Blacklisted' }}
                                </span>
                            </td>
                            <td class="px-12 py-10 text-right">
                                <button class="bg-white/10 hover:bg-white hover:text-[#064e3b] px-6 py-3 rounded-xl text-[9px] font-black uppercase tracking-widest transition-all">Command</button>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

        {{-- Partner Network --}}
        <div id="tab-partners" class="admin-tab hidden space-y-12 animate-in fade-in slide-in-from-bottom-5 duration-500">
            <div class="flex items-end justify-between">
                <div>
                    <h1 class="text-6xl font-black tracking-tighter mb-2">Partners.</h1>
                    <p class="text-white/40 text-xs font-bold uppercase tracking-[0.3em]">Organisation Network Registry</p>
                </div>
            </div>
            <div class="bg-white/5 rounded-[2.5rem] border border-white/10 overflow-hidden backdrop-blur-3xl shadow-2xl">
                <table class="w-full text-left">
                    <thead class="bg-white/5 text-[9px] uppercase tracking-[0.4em] font-black text-white/30">
                        <tr>
                            <th class="px-12 py-8">Legal Entity</th>
                            <th class="px-12 py-8">Verification Root</th>
                            <th class="px-12 py-8 text-right">Interface</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-white/5">
                        @foreach($organisations as $o)
                        <tr class="hover:bg-white/[0.03] transition-all group border-none">
                            <td class="px-12 py-10 font-black text-sm tracking-tight">{{ $o->name }}</td>
                            <td class="px-12 py-10">
                                <span class="px-5 py-2 rounded-xl text-[9px] font-black uppercase tracking-widest {{ $o->is_verified ? 'bg-emerald-500/20 text-emerald-300' : 'bg-white/10 text-white/40' }}">
                                    {{ $o->is_verified ? 'Verified' : 'Verification Required' }}
                                </span>
                            </td>
                            <td class="px-12 py-10 text-right">
                                <div class="flex items-center justify-end gap-3">
                                    @if($o->document_path)
                                    <a href="{{ $o->document_path }}" target="_blank" class="bg-white/5 hover:bg-white/10 px-4 py-3 rounded-xl text-[8px] font-black uppercase tracking-widest transition-all border border-white/5">Doc</a>
                                    @endif
                                    
                                    @if(!$o->is_verified)
                                    <button onclick="verifyOrg({{ $o->id }})" class="bg-emerald-500 text-[#064e3b] hover:bg-emerald-400 px-6 py-3 rounded-xl text-[9px] font-black uppercase tracking-widest transition-all shadow-lg active:scale-95">Verify</button>
                                    @else
                                    <button onclick="rejectOrg({{ $o->id }})" class="bg-red-500/20 text-red-300 hover:bg-red-500 hover:text-white px-6 py-3 rounded-xl text-[9px] font-black uppercase tracking-widest transition-all active:scale-95">Revoke</button>
                                    @endif
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

        {{-- Categories Domain --}}
        <div id="tab-categories" class="admin-tab hidden space-y-12 animate-in fade-in slide-in-from-bottom-5 duration-500">
            <div>
                <h1 class="text-6xl font-black tracking-tighter mb-2">Domains.</h1>
                <p class="text-white/40 text-xs font-bold uppercase tracking-[0.3em]">Operational Sector Expansion</p>
            </div>
            <div class="grid grid-cols-1 xl:grid-cols-12 gap-12">
                <div class="xl:col-span-4 bg-white/5 p-12 rounded-[2.5rem] border border-white/10 backdrop-blur-3xl space-y-10 shadow-2xl">
                    <div class="space-y-2">
                        <h3 class="text-xl font-black">Expansion Protocol</h3>
                        <p class="text-white/30 text-[9px] uppercase tracking-widest font-black">Register New Sector</p>
                    </div>
                    <form action="#" class="space-y-6">
                        <div class="space-y-2">
                            <label class="text-[9px] font-black text-white/20 uppercase tracking-widest ml-1">Identity</label>
                            <input type="text" placeholder="e.g. Healthcare" class="w-full bg-white/5 border border-white/10 rounded-2xl px-6 py-5 text-sm font-bold outline-none focus:border-white transition-all">
                        </div>
                        <button class="w-full bg-white text-[#064e3b] py-5 rounded-2xl font-black text-[10px] uppercase tracking-[0.3em] shadow-xl hover:scale-105 active:scale-95 transition-all">Deploy Domain</button>
                    </form>
                </div>
                <div class="xl:col-span-8 bg-white/5 rounded-[2.5rem] border border-white/10 overflow-hidden backdrop-blur-3xl shadow-2xl">
                    <table class="w-full text-left">
                        <thead class="bg-white/5 text-[9px] uppercase tracking-[0.4em] font-black text-white/30">
                            <tr><th class="px-12 py-8">Domain Identity</th></tr>
                        </thead>
                        <tbody class="divide-y divide-white/5 text-sm font-bold">
                            @foreach($categories as $cat)
                            <tr class="hover:bg-white/[0.03] transition-all"><td class="px-12 py-7 opacity-80">{{ $cat->category_name }}</td></tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </main>
</div>

{{-- Persistent Style Overrides for Active State --}}
<style>
    .admin-nav-btn.active {
        background: rgba(255,255,255,0.1) !important;
        color: white !important;
        border-color: rgba(255,255,255,0.2);
    }
    .admin-nav-btn.active svg {
        opacity: 1;
    }
    ::-webkit-scrollbar { width: 6px; }
    ::-webkit-scrollbar-track { background: transparent; }
    ::-webkit-scrollbar-thumb { background: rgba(255,255,255,0.1); border-radius: 10px; }
</style>

<script>
    function showTab(name) {
        // Hide all tabs
        document.querySelectorAll('.admin-tab').forEach(t => t.classList.add('hidden'));
        // Show target tab
        const target = document.getElementById('tab-' + name);
        if(target) target.classList.remove('hidden');
        
        // Reset nav buttons
        document.querySelectorAll('.admin-nav-btn').forEach(b => b.classList.remove('active'));
        // Activate current button
        const btn = document.getElementById('btn-' + name);
        if(btn) btn.classList.add('active');
    }

    async function verifyOrg(id) {
        try {
            const resp = await fetch(`/api/organisations/${id}/verify`, { 
                method: 'POST',
                headers: { 
                    'Authorization': `Bearer ${localStorage.getItem('donify_token')}`,
                    'Accept': 'application/json'
                }
            });
            if(resp.ok) location.reload();
        } catch(e) { console.error('Verification failed'); }
    }

    async function rejectOrg(id) {
        try {
            const resp = await fetch(`/api/organisations/${id}/reject`, { 
                method: 'POST',
                headers: { 
                    'Authorization': `Bearer ${localStorage.getItem('donify_token')}`,
                    'Accept': 'application/json'
                }
            });
            if(resp.ok) location.reload();
        } catch(e) { console.error('Reject failed'); }
    }

    async function approveCampaign(id) {
        try {
            const resp = await fetch(`/api/campaigns/${id}/approve`, { 
                method: 'POST',
                headers: { 
                    'Authorization': `Bearer ${localStorage.getItem('donify_token')}`,
                    'Accept': 'application/json'
                }
            });
            if(resp.ok) location.reload();
        } catch(e) { console.error('Approve failed'); }
    }

    async function rejectCampaign(id) {
        try {
            const resp = await fetch(`/api/campaigns/${id}/reject`, { 
                method: 'POST',
                headers: { 
                    'Authorization': `Bearer ${localStorage.getItem('donify_token')}`,
                    'Accept': 'application/json'
                }
            });
            if(resp.ok) location.reload();
        } catch(e) { console.error('Reject failed'); }
    }
</script>
@endsection
