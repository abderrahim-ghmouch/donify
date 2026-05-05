@php
    $hide_nav = true;
    $hide_footer = true;
@endphp
@extends('layouts.app')

@section('content')
    <div class="min-h-screen bg-gradient-to-r from-[#0a7558] to-[#042f2e] font-quicksand text-black flex overflow-hidden">

        {{-- Atmospheric blobs --}}
        <div class="fixed inset-0 pointer-events-none overflow-hidden z-0">
            <div class="absolute -top-[10%] -right-[10%] w-[50%] h-[50%] bg-[#064e3b]/8 blur-[120px] rounded-full"></div>
            <div class="absolute -bottom-[10%] -left-[10%] w-[50%] h-[50%] bg-amber-400/10 blur-[120px] rounded-full"></div>
        </div>

        {{-- Sidebar --}}
        <aside
            class="w-80 bg-gradient-to-l from-[#0a7558] to-[#042f2e] border-r-2 border-[#996515] flex flex-col h-screen fixed top-0 left-0 z-50 shadow-2xl">
            {{-- Brand --}}
            <div class="p-12 flex flex-col items-center border-b border-[#996515]/30 mb-8 relative">
                <div class="absolute inset-0 bg-[#996515]/5 blur-xl"></div>
                <img src="{{ asset('images/donifylg.png') }}"
                    class="h-14 w-auto brightness-0 invert opacity-90 relative z-10 drop-shadow-lg">
                <div class="mt-8 text-sm font-black uppercase tracking-[0.5em] text-[#996515] relative z-10">Admin Console
                </div>
                <div class="mt-2 text-md text-white/40 font-semibold">Control Panel</div>
            </div>

            {{-- Navigation --}}
            <nav class="flex-1 px-6 space-y-2 overflow-y-auto">
                <button onclick="switchTab('campaigns')" data-tab="campaigns"
                    class="sidebar-nav-item w-full flex items-center gap-4 px-6 py-4 rounded-xl text-white/70 hover:text-[#996515] transition-all duration-200">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2.5">
                        <path d="M19 11H5m14 0l-2-2m2 2l-2 2M5 11l2-2m-2 2l2 2" />
                    </svg>
                    <span class="text-sm font-bold tracking-wider">Campaigns</span>
                </button>

                <button onclick="switchTab('users')" data-tab="users"
                    class="sidebar-nav-item w-full flex items-center gap-4 px-6 py-4 rounded-xl text-white/70 hover:text-[#996515] transition-all duration-200">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                        <path d="M16 21v-2a4 4 0 00-4-4H5a4 4 0 00-4 4v2M8 7a4 4 0 100-8 4 4 0 000 8z" />
                    </svg>
                    <span class="text-sm font-bold tracking-wider">Users</span>
                </button>

                <button onclick="switchTab('partners')" data-tab="partners"
                    class="sidebar-nav-item w-full flex items-center gap-4 px-6 py-4 rounded-xl text-white/70 hover:text-[#996515] transition-all duration-200">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                        <path
                            d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                    </svg>
                    <span class="text-sm font-bold tracking-wider">Organizations</span>
                </button>

                <button onclick="switchTab('categories')" data-tab="categories"
                    class="sidebar-nav-item w-full flex items-center gap-4 px-6 py-4 rounded-xl text-white/70 hover:text-[#996515] transition-all duration-200">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                        <path
                            d="M7 7h.01M7 3h5c.5 0 1 .2 1.4.6l7 7a2 2 0 010 2.8l-7 7a2 2 0 01-2.8 0l-7-7A2 2 0 013 12V7a4 4 0 014-4z" />
                    </svg>
                    <span class="text-sm font-bold tracking-wider">Categories</span>
                </button>
            </nav>

            {{-- Logout --}}
            <div class="p-6 border-t border-[#996515]/30">
                <button onclick="ApiClient.logout()"
                    class="w-full flex items-center justify-center gap-3 py-4 rounded-xl text-white font-bold hover:text-[#996515] transition-all duration-200">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                    </svg>
                    <span class="text-sm font-bold uppercase tracking-wider">Logout</span>
                </button>
            </div>
        </aside>

        {{-- Main Content --}}
        <main class="ml-80 flex-1 p-12 lg:p-16 overflow-y-auto h-screen relative z-10">
            <header class="flex items-center justify-between mb-16">
                <div>
                    <h1 class="text-md font-black uppercase tracking-[0.5em] text-white/60 mb-2">Welcome Back Admin</h1>
                </div>
            </header>

            <div class="space-y-16">
                {{-- Campaigns Tab --}}
                <section id="tab-campaigns" class="admin-tab space-y-10">
                    <div
                        class="border border-[#996515] rounded-2xl overflow-hidden bg-[#042f2e]/70 shadow-2xl shadow-[#996515]/20">
                        <table class="w-full text-left">
                            <thead class="bg-[#064e3b]/50 border-b-2 border-[#996515]/20">
                                <tr class="text-xs font-black uppercase tracking-[0.2em] text-[#996515]">
                                    <th class="px-8 py-6">Campaign</th>
                                    <th class="px-8 py-6">Creator</th>
                                    <th class="px-8 py-6">Category</th>
                                    <th class="px-8 py-6">Target</th>
                                    <th class="px-8 py-6">Raised</th>
                                    <th class="px-8 py-6">Status</th>
                                    <th class="px-8 py-6 text-right">Actions</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-[#996515]/10" id="campaigns-tbody">
                                @foreach ($campaigns as $c)
                                    <tr class="hover:bg-[#064e3b]/30 transition-colors" id="campaign-{{ $c->id }}">
                                        <td class="px-8 py-6">
                                            <div class="font-bold text-base text-white">{{ $c->title }}</div>
                                            <div class="text-xs text-white/40 mt-1">{{ $c->created_at->format('M d, Y') }}
                                            </div>
                                        </td>
                                        <td class="px-8 py-6">
                                            <div class="text-sm text-white/80">
                                                @if ($c->user)
                                                    {{ $c->user->first_name }} {{ $c->user->last_name }}
                                                @elseif($c->organisation)
                                                    {{ $c->organisation->name }}
                                                @else
                                                    N/A
                                                @endif
                                            </div>
                                        </td>
                                        <td class="px-8 py-6">
                                            <div class="text-xs text-white/60">{{ $c->category->category_name ?? 'N/A' }}
                                            </div>
                                        </td>
                                        <td class="px-8 py-6">
                                            <div class="font-bold text-lg text-[#996515]">
                                                ${{ number_format($c->target_amount) }}</div>
                                        </td>
                                        <td class="px-8 py-6">
                                            <div class="font-bold text-lg text-emerald-400">
                                                ${{ number_format($c->current_amount) }}</div>
                                            <div class="text-xs text-white/40">
                                                {{ $c->target_amount > 0 ? round(($c->current_amount / $c->target_amount) * 100, 1) : 0 }}%
                                            </div>
                                        </td>
                                        <td class="px-8 py-6">
                                            <span
                                                class="text-sm font-bold text-white campaign-status">{{ strtoupper($c->status) }}</span>
                                        </td>
                                        <td class="px-8 py-6 text-right">
                                            <div class="flex items-center justify-end gap-2 campaign-actions">
                                                @if ($c->status !== 'active')
                                                    <button onclick="approveCampaign('{{ $c->id }}')"
                                                        class="px-4 py-2 bg-black text-white text-xs font-bold rounded-lg hover:bg-gray-800 transition-all uppercase tracking-wider">Approve</button>
                                                @endif
                                                <button onclick="rejectCampaign('{{ $c->id }}')"
                                                    class="px-4 py-2 bg-black text-white text-xs font-bold rounded-lg hover:bg-gray-800 transition-all uppercase tracking-wider">Reject</button>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </section>

                {{-- Users Tab --}}
                <section id="tab-users" class="admin-tab hidden space-y-10">
                    <div
                        class="border border-[#996515] rounded-2xl overflow-hidden bg-[#042f2e]/70 shadow-2xl shadow-[#996515]/20">
                        <table class="w-full text-left">
                            <thead class="bg-[#064e3b]/50 border-b-2 border-[#996515]/20">
                                <tr class="text-xs font-black uppercase tracking-[0.2em] text-[#996515]">
                                    <th class="px-8 py-6">Name</th>
                                    <th class="px-8 py-6">Email</th>
                                    <th class="px-8 py-6">Role</th>
                                    <th class="px-8 py-6">Status</th>
                                    <th class="px-8 py-6 text-right">Actions</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-[#996515]/10">
                                @foreach ($users as $u)
                                    <tr class="hover:bg-[#064e3b]/30 transition-colors" id="user-{{ $u->id }}">
                                        <td class="px-8 py-6 font-bold text-base text-white">{{ $u->first_name }}
                                            {{ $u->last_name }}</td>
                                        <td class="px-8 py-6 text-sm text-white/60">{{ $u->email }}</td>
                                        <td class="px-8 py-6">
                                            <span class="text-sm font-bold text-white">{{ strtoupper($u->role) }}</span>
                                        </td>
                                        <td class="px-8 py-6">
                                            <span
                                                class="text-xs font-bold {{ $u->is_banned ? 'text-red-400' : 'text-emerald-400' }}">{{ $u->is_banned ? 'BANNED' : 'ACTIVE' }}</span>
                                        </td>
                                        <td class="px-8 py-6 text-right">
                                            <button
                                                onclick="banUser({{ $u->id }}, {{ $u->is_banned ? 'false' : 'true' }})"
                                                class="px-4 py-2 bg-black text-white text-xs font-bold rounded-lg hover:bg-gray-800 transition-all uppercase tracking-wider user-ban-btn">
                                                {{ $u->is_banned ? 'Unban' : 'Ban' }}
                                            </button>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </section>

                {{-- Organizations Tab --}}
                <section id="tab-partners" class="admin-tab hidden space-y-10">
                    <div
                        class="border border-[#996515] rounded-2xl overflow-hidden bg-[#042f2e]/70 shadow-2xl shadow-[#996515]/20">
                        <table class="w-full text-left">
                            <thead class="bg-[#064e3b]/50 border-b-2 border-[#996515]/20">
                                <tr class="text-xs font-black uppercase tracking-[0.2em] text-[#996515]">
                                    <th class="px-8 py-6">Organization</th>
                                    <th class="px-8 py-6">Email</th>
                                    <th class="px-8 py-6">Phone</th>
                                    <th class="px-8 py-6">Status</th>
                                    <th class="px-8 py-6">Document</th>
                                    <th class="px-8 py-6 text-right">Actions</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-[#996515]/10">
                                @foreach ($organisations as $o)
                                    <tr class="hover:bg-[#064e3b]/30 transition-colors" id="org-{{ $o->id }}">
                                        <td class="px-8 py-6 font-bold text-base text-white">{{ $o->name }}</td>
                                        <td class="px-8 py-6 text-sm text-white/60">{{ $o->email }}</td>
                                        <td class="px-8 py-6 text-sm text-white/60">{{ $o->phone }}</td>
                                        <td class="px-8 py-6">
                                            <span
                                                class="text-sm font-bold text-white org-status">{{ $o->is_verified ? 'VERIFIED' : 'PENDING' }}</span>
                                        </td>
                                        <td class="px-8 py-6">
                                            @if ($o->verificationDocument)
                                                <button onclick="viewDocument('{{ $o->verificationDocument->url }}')"
                                                    class="px-4 py-2 bg-[#996515] text-white text-xs font-bold rounded-lg hover:bg-[#996515]/80 transition-all uppercase tracking-wider flex items-center gap-2">
                                                    <svg class="w-4 h-4" fill="none" stroke="currentColor"
                                                        stroke-width="2" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                                    </svg>
                                                    View
                                                </button>
                                            @else
                                                <span class="text-xs text-white/40">No document</span>
                                            @endif
                                        </td>
                                        <td class="px-8 py-6 text-right">
                                            <div class="flex items-center justify-end gap-2 org-actions">
                                                @if (!$o->is_verified)
                                                    <button onclick="verifyOrg({{ $o->id }})"
                                                        class="px-4 py-2 bg-black text-white text-xs font-bold rounded-lg hover:bg-gray-800 transition-all uppercase tracking-wider">Verify</button>
                                                @else
                                                    <button onclick="rejectOrg({{ $o->id }})"
                                                        class="px-4 py-2 bg-black text-white text-xs font-bold rounded-lg hover:bg-gray-800 transition-all uppercase tracking-wider">Remoke</button>
                                                @endif
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </section>

                {{-- Categories Tab --}}
                <section id="tab-categories" class="admin-tab hidden space-y-10">
                    <div class="grid grid-cols-1 xl:grid-cols-12 gap-8">
                        <div
                            class="xl:col-span-4 bg-[#042f2e]/70 p-10 rounded-2xl border border-[#996515] shadow-2xl shadow-[#996515]/20">
                            <div class="mb-8">
                                <h3 class="text-2xl font-black text-white tracking-tight mb-2">New Category</h3>
                                <p class="text-xs text-white/50 uppercase tracking-wider font-bold">Add a new category</p>
                            </div>
                            <div class="space-y-6">
                                <div class="space-y-3">
                                    <label class="text-xs font-black text-[#996515] uppercase tracking-wider">Category
                                        Name</label>
                                    <input type="text" id="new-category-name" placeholder="e.g. Education"
                                        class="w-full bg-[#064e3b]/30 border-2 border-[#996515]/30 rounded-xl px-6 py-4 text-sm font-bold outline-none focus:border-[#996515] transition-all placeholder:text-white/30 text-white">
                                </div>
                                <button onclick="createCategory()" id="create-category-btn"
                                    class="px-4 py-4 bg-black text-white text-xs font-bold rounded-lg hover:bg-gray-800 transition-all uppercase tracking-wider w-full">Create
                                    Category</button>
                                <div id="category-message" class="hidden text-xs font-bold"></div>
                            </div>
                        </div>
                        <div
                            class="xl:col-span-8 border border-[#996515] rounded-2xl overflow-hidden bg-[#042f2e]/70 shadow-2xl shadow-[#996515]/20">
                            <table class="w-full text-left">
                                <thead class="bg-[#064e3b]/50 border-b-2 border-[#996515]/20">
                                    <tr class="text-xs font-black uppercase tracking-[0.2em] text-[#996515]">
                                        <th class="px-8 py-6">Category Name</th>
                                        <th class="px-8 py-6 text-right">Actions</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-[#996515]/10" id="categories-tbody">
                                    @foreach ($categories as $cat)
                                        <tr class="hover:bg-[#064e3b]/30 transition-colors"
                                            id="category-{{ $cat->id }}">
                                            <td class="px-8 py-6 font-bold text-base text-white">{{ $cat->category_name }}
                                            </td>
                                            <td class="px-8 py-6 text-right">
                                                <button onclick="deleteCategory({{ $cat->id }})"
                                                    class="px-4 py-2 bg-red-900 text-white text-xs font-bold rounded-lg hover:bg-red-800 transition-all uppercase tracking-wider">Delete</button>
                                            </td>
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
        // Auth guard
        if (!ApiClient.isAuthenticated()) {
            window.location.href = '/login';
        } else {
            const user = ApiClient.getUser();
            if (user?.role !== 'admin') {
                window.location.href = '/campaigns';
            }
        }

        // Tab switching function
        function switchTab(tabName) {
            // Hide all tabs
            document.querySelectorAll('.admin-tab').forEach(tab => {
                tab.classList.add('hidden');
            });

            // Show selected tab
            document.getElementById('tab-' + tabName).classList.remove('hidden');

            // Reset all nav items to default state
            document.querySelectorAll('.sidebar-nav-item').forEach(item => {
                item.classList.remove('text-[#996515]', 'bg-[#996515]/10', 'border-l-4', 'border-[#996515]');
                item.classList.add('text-white/70');
            });

            // Highlight active nav item
            const activeItem = document.querySelector(`[data-tab="${tabName}"]`);
            if (activeItem) {
                activeItem.classList.remove('text-white/70');
                activeItem.classList.add('text-[#996515]', 'bg-[#996515]/10', 'border-l-4', 'border-[#996515]');
            }

            // Save to localStorage
            localStorage.setItem('admin_active_tab', tabName);
        }

        window.addEventListener('DOMContentLoaded', () => {
            const savedTab = localStorage.getItem('admin_active_tab') || 'campaigns';
            switchTab(savedTab);
        });

        // Create category function
        async function createCategory() {
            const input = document.getElementById('new-category-name');
            const btn = document.getElementById('create-category-btn');
            const msg = document.getElementById('category-message');
            const categoryName = input.value.trim();

            msg.classList.add('hidden');

            if (!categoryName) {
                msg.textContent = 'Category name is required';
                msg.className = 'text-red-400 text-xs font-bold';
                msg.classList.remove('hidden');
                return;
            }

            btn.disabled = true;
            btn.textContent = 'Creating...';

            try {
                const response = await ApiClient.post('/categories', {
                    category_name: categoryName
                });

                if (response.status === 'success' && response.data) {
                    input.value = '';
                    const tbody = document.getElementById('categories-tbody');
                    const newRow = document.createElement('tr');
                    newRow.id = `category-${response.data.id}`;
                    newRow.className = 'hover:bg-[#064e3b]/30 transition-colors';
                    newRow.innerHTML = `
                        <td class="px-8 py-6 font-bold text-base text-white">${response.data.category_name}</td>
                        <td class="px-8 py-6 text-right">
                            <button onclick="deleteCategory(${response.data.id})" class="px-4 py-2 bg-red-900 text-white text-xs font-bold rounded-lg hover:bg-red-800 transition-all uppercase tracking-wider">Delete</button>
                        </td>
                    `;
                    tbody.appendChild(newRow);
                    msg.textContent = 'Category created successfully!';
                    msg.className = 'text-emerald-400 text-xs font-bold';
                    msg.classList.remove('hidden');
                    setTimeout(() => msg.classList.add('hidden'), 3000);
                }
            } catch (error) {
                let errorMessage = 'Failed to create category';
                if (error.errors && error.errors.category_name) {
                    errorMessage = error.errors.category_name[0];
                } else if (error.message) {
                    errorMessage = error.message;
                }
                msg.textContent = errorMessage;
                msg.className = 'text-red-400 text-xs font-bold';
                msg.classList.remove('hidden');
            } finally {
                btn.disabled = false;
                btn.textContent = 'Create Category';
            }
        }

        // Campaign functions
        async function approveCampaign(id) {
            try {
                const response = await ApiClient.post(`/campaigns/${id}/approve`);
                if (response.status === 'success') {
                    const row = document.getElementById('campaign-' + id);
                    row.querySelector('.campaign-status').textContent = 'ACTIVE';
                    row.querySelector('.campaign-actions').innerHTML =
                        `<button onclick="rejectCampaign('${id}')" class="px-4 py-2 bg-black text-white text-xs font-bold rounded-lg hover:bg-gray-800 transition-all uppercase tracking-wider">Reject</button>`;
                }
            } catch (error) {
                console.error('Failed to approve campaign:', error);
            }
        }

        async function rejectCampaign(id) {
            try {
                const response = await ApiClient.post(`/campaigns/${id}/reject`);
                if (response.status === 'success') {
                    document.getElementById('campaign-' + id).remove();
                }
            } catch (error) {
                console.error('Failed to reject campaign:', error);
            }
        }

        // Organization functions
        async function verifyOrg(id) {
            try {
                const response = await ApiClient.post(`/organisations/${id}/verify`);
                if (response.status === 'success') {
                    const row = document.getElementById('org-' + id);
                    row.querySelector('.org-status').textContent = 'VERIFIED';
                    row.querySelector('.org-actions').innerHTML =
                        `<button onclick="rejectOrg(${id})" class="px-4 py-2 bg-black text-white text-xs font-bold rounded-lg hover:bg-gray-800 transition-all  tracking-wider">Remove</button>`;
                }
            } catch (error) {
                console.error('Failed to verify organization:', error);
            }
        }

        async function rejectOrg(id) {
            try {
                const response = await ApiClient.post(`/organisations/${id}/reject`);
                if (response.status === 'success') {
                    const row = document.getElementById('org-' + id);
                    row.querySelector('.org-status').textContent = 'PENDING';
                    row.querySelector('.org-actions').innerHTML =
                        `<button onclick="verifyOrg(${id})" class="px-4 py-2 bg-black text-white text-xs font-bold rounded-lg hover:bg-gray-800 transition-all uppercase tracking-wider">Verify</button>`;
                }
            } catch (error) {
                console.error('Failed to revoke organization:', error);
            }
        }

        // User functions
        async function banUser(id, shouldBan) {
            const action = shouldBan ? 'ban' : 'unban';
            try {
                const response = await ApiClient.post(`/users/${id}/${action}`);
                if (response.status === 'success' || response.message) {
                    const row = document.getElementById('user-' + id);
                    const button = row.querySelector('.user-ban-btn');
                    button.textContent = shouldBan ? 'Unban' : 'Ban';
                    button.onclick = () => banUser(id, !shouldBan);
                }
            } catch (error) {
                console.error(`Failed to ${action} user:`, error);
            }
        }

        // Delete category function
        async function deleteCategory(id) {
            try {
                const response = await ApiClient.delete(`/categories/${id}`);
                if (response.status === 'success') {
                    document.getElementById('category-' + id).remove();
                }
            } catch (error) {
                console.error('Failed to delete category:', error);
            }
        }
        window.deleteCategory = deleteCategory;

        // View document function
        function viewDocument(url) {
            // Create modal
            const modal = document.createElement('div');
            modal.className = 'fixed inset-0 z-[200] flex items-center justify-center bg-black/90 backdrop-blur-sm';
            modal.onclick = (e) => {
                if (e.target === modal) modal.remove();
            };

            const isPdf = url.toLowerCase().endsWith('.pdf');

            modal.innerHTML = `
                <div class="relative max-w-6xl max-h-[90vh] bg-[#042f2e] rounded-2xl border-2 border-[#996515] shadow-2xl overflow-hidden">
                    <div class="flex items-center justify-between p-6 border-b border-[#996515]/30">
                        <h3 class="text-xl font-black text-white uppercase tracking-wider">Verification Document</h3>
                        <button onclick="this.closest('.fixed').remove()" class="text-white/60 hover:text-white transition-all p-2 hover:bg-white/10 rounded-lg">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                            </svg>
                        </button>
                    </div>
                    <div class="p-6 overflow-auto max-h-[calc(90vh-100px)]">
                        ${isPdf
                            ? `<iframe src="${url}" class="w-full h-[70vh] rounded-lg border border-[#996515]/30"></iframe>`
                            : `<img src="${url}" alt="Verification Document" class="max-w-full h-auto rounded-lg border border-[#996515]/30">`
                        }
                    </div>
                    <div class="p-6 border-t border-[#996515]/30 flex justify-end">
                        <a href="${url}" target="_blank" class="px-6 py-3 bg-[#996515] text-white text-xs font-bold rounded-lg hover:bg-[#996515]/80 transition-all uppercase tracking-wider flex items-center gap-2">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14" />
                            </svg>
                            Open in New Tab
                        </a>
                    </div>
                </div>
            `;

            document.body.appendChild(modal);
        }
    </script>
@endsection
