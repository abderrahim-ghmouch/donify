@php
    $hide_nav = true;
    $hide_footer = true;
@endphp
@extends('layouts.app')

@section('content')
    <div class="min-h-screen bg-[#2b6243]  font-quicksand text-black flex overflow-hidden">

        {{-- Atmospheric blobs --}}
        <div class="fixed inset-0 pointer-events-none overflow-hidden z-0">
            <div class="absolute -top-[10%] -right-[10%] w-[50%] h-[50%] bg-[#064e3b]/8 blur-[120px] rounded-full"></div>
            <div class="absolute -bottom-[10%] -left-[10%] w-[50%] h-[50%] bg-amber-400/10 blur-[120px] rounded-full"></div>
        </div>

        {{-- Sidebar --}}
        <aside class="w-80 bg-gradient-to-b from-[#0a7558] to-[#042f2e] border-r-2 border-[#996515] flex flex-col h-screen fixed top-0 left-0 z-50 shadow-2xl">
            {{-- Brand --}}
            <div class="p-12 flex flex-col items-center border-b border-[#996515]/30 mb-8 relative">
                <div class="absolute inset-0 bg-[#996515]/5 blur-xl"></div>
                <img src="{{ asset('images/donifylg.png') }}" class="h-14 w-auto brightness-0 invert opacity-90 relative z-10 drop-shadow-lg">
                <div class="mt-8 text-sm font-black uppercase tracking-[0.5em] text-[#996515] relative z-10">Admin Console</div>
                <div class="mt-2 text-md text-white/40 font-semibold">Control Panel</div>
            </div>

            {{-- Navigation --}}
            <nav class="flex-1 px-6 space-y-2 overflow-y-auto">
                <button onclick="showTab('campaigns')" id="btn-campaigns" class="admin-nav-btn flex items-center gap-4 w-full px-6 py-4 rounded-xl transition-all duration-200 text-white/70">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path d="M19 11H5m14 0l-2-2m2 2l-2 2M5 11l2-2m-2 2l2 2"/></svg>
                    <span class="text-sm font-bold  t">Campaigns</span>
                </button>

                <button onclick="showTab('users')" id="btn-users" class="admin-nav-btn flex items-center gap-4 w-full px-6 py-4 rounded-xl transition-all duration-200 text-white/70">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path d="M16 21v-2a4 4 0 00-4-4H5a4 4 0 00-4 4v2M8 7a4 4 0 100-8 4 4 0 000 8z"/></svg>
                    <span class="text-sm font-bold  tracking-wider">Users</span>
                </button>

                <button onclick="showTab('partners')" id="btn-partners" class="admin-nav-btn flex items-center gap-4 w-full px-6 py-4 rounded-xl transition-all duration-200 text-white/70">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>
                    <span class="text-sm font-bold  tracking-wider">Organizations</span>
                </button>

                <button onclick="showTab('categories')" id="btn-categories" class="admin-nav-btn flex items-center gap-4 w-full px-6 py-4 rounded-xl transition-all duration-200 text-white/70">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path d="M7 7h.01M7 3h5c.5 0 1 .2 1.4.6l7 7a2 2 0 010 2.8l-7 7a2 2 0 01-2.8 0l-7-7A2 2 0 013 12V7a4 4 0 014-4z"/></svg>
                    <span class="text-sm font-bold  tracking-wider">Categories</span>
                </button>
            </nav>

            {{-- Logout --}}
            <div class="p-6 border-t border-[#996515]/30">
                <button onclick="ApiClient.logout()" class="flex items-center justify-center gap-3 w-full py-4 rounded-xl transition-all duration-200 bg-red-500/10 text-red-300 border border-red-400/20 hover:bg-red-500/20 hover:text-white hover:border-red-400/40">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/></svg>
                    <span class="text-sm font-bold uppercase tracking-wider">Logout</span>
                </button>
            </div>
        </aside>

        {{-- Main Content --}}
        <main class="ml-80 flex-1 p-12 lg:p-16 overflow-y-auto h-screen relative z-10 bg-gardiant-to-t from-[#064e3b] to-[#042f2e]">

            {{-- Header --}}
            <header class="flex items-center justify-between mb-16">
                <div>
                    <h1 class="text-md font-black uppercase tracking-[0.5em] text-[#1A1A1A]/40 mb-2">welcome back Our Admin</h1>

                </div>

            </header>

            {{-- tabs --}}
            <div class="space-y-16 bg-gradient-to-tr from-green-400">

                {{-- campaign tab --}}
                <section id="tab-campaigns" class="admin-tab space-y-10">
                    <div class="bg-gradient-to-br from-[#064e3b] to-[#042f2e] rounded-lg border border-black overflow-hidden shadow-lg">
                        <table class="w-full text-left">
                            <thead class="bg-[#996515]/20 border-b border-[#996515]/30">
                                <tr class="text-xs font-black uppercase tracking-wider text-[#996515]">
                                    <th class="px-8 py-6">Campaign</th>
                                    <th class="px-8 py-6">Target</th>
                                    <th class="px-8 py-6">Status</th>
                                    <th class="px-8 py-6 text-right">Actions</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-[#996515]/10">
                                @foreach ($campaigns as $c)
                                    <tr class="hover:bg-[#064e3b]/40 transition-colors" id="campaign-{{ $c->id }}">
                                        <td class="px-8 py-6">
                                            <div class="font-black text-lg text-white tracking-tight">{{ $c->title }}</div>
                                            <div class="text-xs text-white/40 uppercase tracking-wider mt-1">ID: {{ substr($c->id, 0, 8) }}</div>
                                        </td>
                                        <td class="px-8 py-6">
                                            <div class="font-black text-2xl text-[#996515] tracking-tighter">${{ number_format($c->target_amount) }}</div>
                                        </td>
                                        <td class="px-8 py-6">
                                            <span class="inline-flex px-3 py-1.5 rounded-lg text-xs font-black uppercase tracking-wider bg-black/20 text-white border border-black">
                                                {{ $c->status }}
                                            </span>
                                        </td>
                                        <td class="px-8 py-6 text-right" id="campaign-row-{{ $c->id }}">
                                            <div class="flex items-center justify-end gap-3">
                                                @if ($c->status !== 'active')
                                                    <button onclick="approveCampaign({{ $c->id }})" class="bg-black/20 text-white border border-black px-6 py-2.5 rounded-lg text-xs font-black uppercase tracking-wider hover:bg-black/30 transition-all">Approve</button>
                                                @endif
                                                <button onclick="rejectCampaign({{ $c->id }})" class="bg-black/20 text-white border border-black px-6 py-2.5 rounded-lg text-xs font-black uppercase tracking-wider hover:bg-black/30 transition-all">Reject</button>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </section>

                {{-- user ab --}}
                <section id="tab-users" class="admin-tab hidden space-y-10">
                    <div class="bg-gradient-to-br from-[#064e3b] to-[#042f2e] rounded-lg border border-black overflow-hidden shadow-lg">
                        <table class="w-full text-left">
                            <thead class="bg-[#996515]/20 border-b border-[#996515]/30">
                                <tr class="text-xs font-black uppercase tracking-wider text-[#996515]">
                                    <th class="px-8 py-6">Name</th>
                                    <th class="px-8 py-6">Role</th>
                                    <th class="px-8 py-6 text-right">Actions</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-[#996515]/10">
                                @foreach ($users as $u)
                                    <tr class="hover:bg-[#064e3b]/40 transition-colors">
                                        <td class="px-8 py-6 font-black text-lg text-white">{{ $u->first_name }} {{ $u->last_name }}</td>
                                        <td class="px-8 py-6 text-sm font-black text-[#996515] uppercase tracking-wider">{{ $u->role }}</td>
                                        <td class="px-8 py-6 text-right">
                                            <button class="bg-black/20 text-white border border-black px-6 py-2.5 rounded-lg text-xs font-black uppercase tracking-wider hover:bg-black/30 transition-all">Manage</button>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </section>

                {{-- blassa dial l organisation --}}
                <section id="tab-partners" class="admin-tab hidden space-y-10">
                    <div class="bg-gradient-to-br from-[#064e3b] to-[#042f2e] rounded-lg border border-black overflow-hidden shadow-lg">
                        <table class="w-full text-left">
                            <thead class="bg-[#996515]/20 border-b border-[#996515]/30">
                                <tr class="text-xs font-black uppercase tracking-wider text-[#996515]">
                                    <th class="px-8 py-6">Organization</th>
                                    <th class="px-8 py-6">Status</th>
                                    <th class="px-8 py-6 text-right">Actions</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-[#996515]/10">
                                @foreach ($organisations as $o)
                                    <tr class="hover:bg-[#064e3b]/40 transition-colors" id="org-{{ $o->id }}">
                                        <td class="px-8 py-6 font-black text-lg text-white uppercase tracking-tight">{{ $o->name }}</td>
                                        <td class="px-8 py-6">
                                            <span class="px-3 py-1.5 rounded-lg text-xs font-black uppercase tracking-wider bg-black/20 text-white border border-black">
                                                {{ $o->is_verified ? 'Verified' : 'Pending' }}
                                            </span>
                                        </td>
                                        <td class="px-8 py-6 text-right" id="org-row-{{ $o->id }}">
                                            <div class="flex items-center justify-end gap-3">
                                                @if (!$o->is_verified)
                                                    <button onclick="verifyOrg({{ $o->id }})" class="bg-black/20 text-white border border-black px-6 py-2.5 rounded-lg text-xs font-black uppercase tracking-wider hover:bg-black/30 transition-all">Verify</button>
                                                @else
                                                    <button onclick="rejectOrg({{ $o->id }})" class="bg-black/20 text-white border border-black px-6 py-2.5 rounded-lg text-xs font-black uppercase tracking-wider hover:bg-black/30 transition-all">Revoke</button>
                                                @endif
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </section>

                {{-- blassa dial categroy  --}}
                <section id="tab-categories" class="admin-tab hidden space-y-10">
                    <div class="grid grid-cols-1 xl:grid-cols-12 gap-8">
                        <div class="xl:col-span-4 bg-gradient-to-br from-[#064e3b] to-[#042f2e] p-10 rounded-lg border border-black shadow-lg">
                            <div class="mb-8">
                                <h3 class="text-2xl font-black text-white tracking-tight mb-2">New Category</h3>
                                <p class="text-xs text-white/40 uppercase tracking-wider font-bold">Add a new category</p>
                            </div>
                            <form action="#" class="space-y-6">
                                <div class="space-y-3">
                                    <label class="text-xs font-black text-[#996515] uppercase tracking-wider">Category Name</label>
                                    <input type="text" placeholder="e.g. Education" class="w-full bg-[#042f2e] border border-[#996515]/30 rounded-xl px-6 py-4 text-sm font-bold outline-none focus:border-[#996515]/60 transition-all placeholder:text-white/30 text-white">
                                </div>
                                <button class="w-full bg-black text-white py-4 rounded-lg font-black text-xs uppercase tracking-wider hover:bg-black/80 transition-all border border-black">Create Category</button>
                            </form>
                        </div>
                        <div class="xl:col-span-8 bg-gradient-to-br from-[#064e3b] to-[#042f2e] rounded-lg border border-black overflow-hidden shadow-lg">
                            <table class="w-full text-left">
                                <thead class="bg-[#996515]/20 border-b border-[#996515]/30">
                                    <tr class="text-xs font-black uppercase tracking-wider text-[#996515]">
                                        <th class="px-8 py-6">Category Name</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-[#996515]/10">
                                    @foreach ($categories as $cat)
                                        <tr class="hover:bg-[#064e3b]/40 transition-colors">
                                            <td class="px-8 py-6 font-black text-base text-white uppercase tracking-wide">{{ $cat->category_name }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </section>
            </div>
        </main>
    </div>

    <script>
        function showTab(tabName) {
            document.querySelectorAll('.admin-tab').forEach(tab => tab.classList.add('hidden'));
            document.getElementById('tab-' + tabName).classList.remove('hidden');

            document.querySelectorAll('.admin-nav-btn').forEach(btn => {
                btn.className = 'admin-nav-btn flex items-center gap-4 w-full px-6 py-4 rounded-xl transition-all duration-200 text-white/70';
            });

            document.getElementById('btn-' + tabName).className = 'admin-nav-btn flex items-center gap-4 w-full px-6 py-4 rounded-xl transition-all duration-200 text-[#996515] bg-[#996515]/10 border-l-4 border-[#996515]';
        }

        window.addEventListener('DOMContentLoaded', () => showTab('campaigns'));

        async function approveCampaign(id) {
            try {
                const response = await ApiClient.post(`/api/campaigns/${id}/approve`);
                if (response.status === 'success') {
                    location.reload();
                }
            } catch (error) {
                alert('Failed to approve campaign');
            }
        }

        async function rejectCampaign(id) {
            if (!confirm('Are you sure you want to reject this campaign?')) return;
            try {
                const response = await ApiClient.post(`/api/campaigns/${id}/reject`);
                if (response.status === 'success') {
                    document.getElementById('campaign-' + id).remove();
                }
            } catch (error) {
                alert('Failed to reject campaign');
            }
        }

        async function verifyOrg(id) {
            try {
                const response = await ApiClient.post(`/api/organisations/${id}/verify`);
                if (response.status === 'success') {
                    location.reload();
                }
            } catch (error) {
                alert('Failed to verify organization');
            }
        }

        async function rejectOrg(id) {
            if (!confirm('Are you sure you want to revoke this organization?')) return;
            try {
                const response = await ApiClient.post(`/api/organisations/${id}/reject`);
                if (response.status === 'success') {
                    document.getElementById('org-' + id).remove();
                }
            } catch (error) {
                alert('Failed to revoke organization');
            }
        }
    </script>
@endsection
