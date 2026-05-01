/**
 * ============================================================
 *  script.js — Donify Unified Frontend Interactions
 * ============================================================
 *  This file contains ALL client-side JS for the platform.
 *  Each section is guarded so it only runs on the relevant page.
 *  Depends on: api-client.js (must be loaded before this file)
 * ============================================================
 */


/* ============================================================
 *  SECTION 1 — GLOBAL: Navbar, Mobile Menu, Auth UI State
 *  Runs on every page via the main app layout.
 * ============================================================ */

// Navbar shrink on scroll
window.addEventListener('scroll', () => {
    const nav = document.getElementById('navbar');
    if (!nav) return;
    if (window.scrollY > 50) {
        nav.classList.remove('py-4');
        nav.classList.add('py-2');
    } else {
        nav.classList.remove('py-2');
        nav.classList.add('py-4');
    }
});

// Mobile menu open / close
const mobileMenuOpen  = document.getElementById('mobile-menu-open');
const mobileMenuClose = document.getElementById('mobile-menu-close');
const mobileMenu      = document.getElementById('mobile-menu');

mobileMenuOpen?.addEventListener('click',  () => mobileMenu.classList.remove('translate-x-full'));
mobileMenuClose?.addEventListener('click', () => mobileMenu.classList.add('translate-x-full'));

/**
 * updateAuthUI
 * Shows/hides guest vs authenticated UI elements and populates
 * the user's name and avatar across all pages.
 */
function updateAuthUI() {
    const hide = el => { if (el) { el.classList.add('hidden'); el.classList.remove('inline-flex'); } };
    const show = el => { if (el) { el.classList.remove('hidden'); el.classList.add('inline-flex'); } };

    const guestEls      = document.querySelectorAll('.auth-guest');
    const userEls       = document.querySelectorAll('.auth-user');
    const userNameEls   = document.querySelectorAll('.user-name');
    const userAvatarEl  = document.getElementById('userAvatar');
    const dashLink      = document.getElementById('navDashboardLink');
    const adminLink     = document.getElementById('navAdminLink');

    if (ApiClient.isAuthenticated()) {
        const user = ApiClient.getUser();
        guestEls.forEach(el => el.classList.add('hidden'));
        userEls.forEach(el => el.classList.remove('hidden'));
        userNameEls.forEach(el => el.textContent = user.first_name);

        if (user.images?.url && userAvatarEl) {
            userAvatarEl.innerHTML = `<img src="${user.images.url}" class="w-full h-full object-cover">`;
        }

        // Role-based nav links
        if (user.role === 'porter' || user.role === 'organisation') {
            show(dashLink); hide(adminLink);
        } else if (user.role === 'admin') {
            hide(dashLink); show(adminLink);
        } else {
            hide(dashLink); hide(adminLink);
        }
    } else {
        guestEls.forEach(el => el.classList.remove('hidden'));
        userEls.forEach(el => el.classList.add('hidden'));
        hide(dashLink); hide(adminLink);
    }
}

/**
 * handleLogout
 * Called by the logout button's onclick attribute.
 */
function handleLogout() {
    ApiClient.logout();
}

// Run auth UI update on every page load
document.addEventListener('DOMContentLoaded', () => {
    updateAuthUI();

    // Admin guard: admins are not allowed on the public-facing site
    if (ApiClient.isAuthenticated()) {
        const user = ApiClient.getUser();
        if (user?.role === 'admin') {
            const path = window.location.pathname;
            if (!path.startsWith('/admin') && path !== '/logout') {
                window.location.href = '/admin';
            }
        }
    }
});


/* ============================================================
 *  SECTION 2 — AUTH: Login Form
 *  Page guard: #loginForm
 * ============================================================ */

document.addEventListener('DOMContentLoaded', () => {
    const loginForm = document.getElementById('loginForm');
    if (!loginForm) return; // Not the login page — skip

    loginForm.addEventListener('submit', async (e) => {
        e.preventDefault();

        const email    = document.getElementById('email').value;
        const password = document.getElementById('password').value;
        const btn      = document.getElementById('loginBtn');
        const errorDiv = document.getElementById('loginError');

        btn.disabled  = true;
        btn.innerHTML = '<span class="flex items-center justify-center text-[10px]"><svg class="animate-spin h-3 w-3 mr-2" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg> SIGNING IN...</span>';
        errorDiv.classList.add('hidden');

        try {
            await ApiClient.login(email, password);
            window.location.href = '/campaigns';
        } catch (error) {
            const message = error.error || 'Invalid email or password. Please try again.';
            errorDiv.textContent = message;
            errorDiv.classList.remove('hidden');
            btn.disabled  = false;
            btn.innerHTML = 'SIGN IN';
        }
    });
});


/* ============================================================
 *  SECTION 3 — AUTH: User Registration Form
 *  Page guard: #registerForm
 * ============================================================ */

document.addEventListener('DOMContentLoaded', () => {
    const registerForm = document.getElementById('registerForm');
    if (!registerForm) return; // Not the register page — skip

    // Image preview before upload
    document.getElementById('image')?.addEventListener('change', function (e) {
        const preview = document.getElementById('imagePreview');
        const file    = e.target.files[0];
        if (file && preview) {
            const reader = new FileReader();
            reader.onload = ev => {
                preview.innerHTML = `<img src="${ev.target.result}" class="w-full h-full object-cover">`;
                preview.classList.remove('border-dashed');
                preview.classList.add('border-solid', 'border-[#064e3b]');
            };
            reader.readAsDataURL(file);
        }
    });

    // Registration form submit
    registerForm.addEventListener('submit', async (e) => {
        e.preventDefault();
        const btn      = document.getElementById('registerBtn');
        const errorDiv = document.getElementById('registerError');

        const formData = new FormData();
        formData.append('first_name', document.getElementById('first_name').value);
        formData.append('last_name',  document.getElementById('last_name').value);
        formData.append('email',      document.getElementById('email').value);
        formData.append('password',   document.getElementById('password').value);
        formData.append('role',       document.getElementById('role').value);
        const img = document.getElementById('image')?.files[0];
        if (img) formData.append('image', img);

        btn.disabled  = true;
        btn.innerHTML = '<span class="flex items-center justify-center text-[10px]"><svg class="animate-spin h-3 w-3 mr-2" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg> PROCESSING...</span>';
        errorDiv.classList.add('hidden');

        try {
            await ApiClient.register(formData);
            await ApiClient.login(
                document.getElementById('email').value,
                document.getElementById('password').value
            );
            window.location.href = '/campaigns';
        } catch (error) {
            const message = error.message || (error.errors ? Object.values(error.errors)[0][0] : 'Registration failed.');
            errorDiv.textContent = message;
            errorDiv.classList.remove('hidden');
            btn.disabled  = false;
            btn.innerHTML = 'CREATE ACCOUNT';
        }
    });
});


/* ============================================================
 *  SECTION 4 — AUTH: User Profile Page
 *  Page guard: #profilePage
 * ============================================================ */

/**
 * setAvatar
 * Shows the user's avatar image or falls back to the SVG placeholder.
 * @param {string|null} url
 */
function setAvatar(url) {
    const img      = document.getElementById('heroAvatarImg');
    const fallback = document.getElementById('heroAvatarFallback');
    if (!img) return;
    if (url) {
        img.src = url;
        img.classList.remove('hidden');
        fallback?.classList.add('hidden');
    } else {
        img.classList.add('hidden');
        fallback?.classList.remove('hidden');
    }
}

document.addEventListener('DOMContentLoaded', async () => {
    if (!document.getElementById('profilePage')) return; // Not the profile page — skip

    const loading = document.getElementById('profileLoading');
    const page    = document.getElementById('profilePage');

    if (!ApiClient.isAuthenticated()) { window.location.href = '/login'; return; }

    try {
        const user = await ApiClient.request('/auth/me');
        if (user.role === 'admin') { window.location.href = '/admin'; return; }

        loading.style.display = 'none';
        page.style.display    = 'block';

        document.getElementById('heroName').textContent  = `${user.first_name || ''} ${user.last_name || ''}`;
        document.getElementById('heroEmail').textContent = user.email || '—';
        document.getElementById('editFirstName').value   = user.first_name || '';
        document.getElementById('editLastName').value    = user.last_name  || '';
        document.getElementById('editEmail').value       = user.email      || '';
        document.getElementById('editRole').value        = (user.role || 'Contributor').toUpperCase();
        setAvatar(user.images?.url || null);
    } catch (e) { window.location.href = '/login'; }

    // Profile update form: saves name and email via PUT /auth/profile
    document.getElementById('profileForm')?.addEventListener('submit', async (e) => {
        e.preventDefault();
        const btn     = document.getElementById('saveProfileBtn');
        const success = document.getElementById('settingsSuccess');
        btn.disabled    = true;
        btn.textContent = 'Verifying Identity...';
        try {
            const updated = await ApiClient.request('/auth/profile', {
                method: 'PUT',
                body: JSON.stringify({
                    first_name: document.getElementById('editFirstName').value,
                    last_name:  document.getElementById('editLastName').value,
                    email:      document.getElementById('editEmail').value,
                })
            });
            const u = updated.user || updated;
            ApiClient.setUser(u);
            document.getElementById('heroName').textContent = `${u.first_name || ''} ${u.last_name || ''}`;
            success.classList.remove('hidden');
            setTimeout(() => success.classList.add('hidden'), 3000);
        } catch { showPorterToast('SYNC FAILURE.'); }
        finally { btn.disabled = false; btn.textContent = 'Verify Identity'; }
    });

    // Avatar upload: sends the selected image to /auth/avatar
    document.getElementById('avatarUploadInput')?.addEventListener('change', async (e) => {
        const file = e.target.files[0];
        if (!file) return;
        const fd = new FormData();
        fd.append('image', file);
        try {
            const res  = await ApiClient.request('/auth/avatar', { method: 'POST', body: fd, headers: { 'Content-Type': null } });
            setAvatar(res.url);
            const user = ApiClient.getUser();
            if (user) { user.images = { url: res.url }; ApiClient.setUser(user); }
        } catch { showPorterToast('UPLOAD FAILED.'); }
    });
});


/* ============================================================
 *  SECTION 5 — CAMPAIGNS INDEX: Discovery, Filter, Paginate
 *  Page guard: #searchInput
 * ============================================================ */

document.addEventListener('DOMContentLoaded', async () => {
    if (!document.getElementById('searchInput')) return; // Not the campaigns index — skip

    const PAGE_SIZE = 9;
    let allCampaigns = [];
    let filtered     = [];
    let categories   = [];
    let activeCat    = 'all';
    let searchQ      = '';
    let currentPage  = 1;
    let favIds       = new Set();

    await Promise.all([loadCampaigns(), loadCategories(), loadFavourites()]);
    applyFilters();

    // Debounced search input
    let timer;
    document.getElementById('searchInput').addEventListener('input', e => {
        clearTimeout(timer);
        timer = setTimeout(() => {
            searchQ = e.target.value.trim().toLowerCase();
            currentPage = 1;
            applyFilters();
        }, 350);
    });

    // Category pills
    document.getElementById('categoryFilters')?.addEventListener('click', e => {
        const pill = e.target.closest('[data-cat]');
        if (!pill) return;
        activeCat = pill.dataset.cat;
        document.querySelectorAll('[data-cat]').forEach(p => {
            p.classList.toggle('bg-[#1A1A1A]',  p.dataset.cat === activeCat);
            p.classList.toggle('text-white',      p.dataset.cat === activeCat);
            p.classList.toggle('bg-white',        p.dataset.cat !== activeCat);
            p.classList.toggle('text-[#1A1A1A]',  p.dataset.cat !== activeCat);
        });
        currentPage = 1;
        applyFilters();
    });

    /**
     * loadCampaigns
     * Fetches all approved campaigns from the API.
     */
    async function loadCampaigns() {
        try {
            const res = await ApiClient.request('/campaigns?status=active&per_page=200');
            allCampaigns = res.data || res || [];
        } catch { allCampaigns = []; }
    }

    /**
     * loadCategories
     * Fetches category list and builds the filter pill bar.
     */
    async function loadCategories() {
        try {
            const res = await fetch('/api/categories', { headers: { Accept: 'application/json' } });
            const json = await res.json();
            categories = json.data || json || [];
            buildCategoryPills();
        } catch {}
    }

    /**
     * loadFavourites
     * Loads the authenticated user's favourite campaign IDs.
     * Silently skips if the user is not logged in.
     */
    async function loadFavourites() {
        if (!ApiClient.isAuthenticated()) return;
        try {
            const res = await ApiClient.getFavourites();
            const list = res.data || res || [];
            favIds = new Set(list.map(f => f.campaign_id || f.campaign?.id).filter(Boolean));
        } catch {}
    }

    function buildCategoryPills() {
        const container = document.getElementById('categoryFilters');
        if (!container) return;
        categories.forEach(c => {
            const btn = document.createElement('button');
            btn.dataset.cat = c.id;
            btn.textContent = c.name || c.category_name;
            btn.className   = 'px-5 py-2 rounded-full font-black text-[10px] uppercase tracking-widest border border-black/10 bg-white text-[#1A1A1A] transition-all hover:bg-[#1A1A1A] hover:text-white cursor-pointer whitespace-nowrap';
            container.appendChild(btn);
        });
    }

    /**
     * applyFilters
     * Filters allCampaigns by search query and active category,
     * then re-renders the current page.
     */
    function applyFilters() {
        filtered = allCampaigns.filter(c => {
            const matchesCat    = activeCat === 'all' || String(c.category_id) === String(activeCat);
            const matchesSearch = !searchQ  || (c.title || '').toLowerCase().includes(searchQ) || (c.description || '').toLowerCase().includes(searchQ);
            return matchesCat && matchesSearch;
        });
        renderPage();
    }

    /**
     * renderPage
     * Renders the current paginated slice of filtered campaigns into the grid.
     */
    function renderPage() {
        const grid     = document.getElementById('campaignsGrid');
        const skeleton = document.getElementById('skeletonGrid');
        const empty    = document.getElementById('emptyState');
        const meta     = document.getElementById('paginationMeta');
        const prevBtn  = document.getElementById('prevPage');
        const nextBtn  = document.getElementById('nextPage');
        const totalPgs = Math.ceil(filtered.length / PAGE_SIZE) || 1;

        skeleton?.classList.add('hidden');

        if (!filtered.length) {
            grid.innerHTML = '';
            grid.classList.add('hidden');
            empty?.classList.remove('hidden');
            if (meta) meta.textContent = 'No results';
            if (prevBtn) prevBtn.disabled = true;
            if (nextBtn) nextBtn.disabled = true;
            return;
        }

        empty?.classList.add('hidden');
        grid.classList.remove('hidden');

        const start  = (currentPage - 1) * PAGE_SIZE;
        const slice  = filtered.slice(start, start + PAGE_SIZE);

        grid.innerHTML = slice.map((c, i) => campaignCard(c, i)).join('');
        if (meta) meta.textContent = `Page ${currentPage} of ${totalPgs} · ${filtered.length} missions`;
        if (prevBtn) prevBtn.disabled = currentPage === 1;
        if (nextBtn) nextBtn.disabled = currentPage === totalPgs;

        // Animate new cards in
        grid.querySelectorAll('.campaign-intel-card').forEach((el, i) => {
            el.style.opacity         = '0';
            el.style.transform       = 'translateY(20px)';
            el.style.transition      = `opacity 0.4s ease ${i * 60}ms, transform 0.4s ease ${i * 60}ms`;
            requestAnimationFrame(() => { el.style.opacity = '1'; el.style.transform = 'translateY(0)'; });
        });
    }

    /**
     * campaignCard
     * Builds the HTML string for a single campaign card.
     */
    function campaignCard(c) {
        const pct    = Math.min(100, ((c.current_amount || 0) / Math.max(1, c.target_amount || 1)) * 100).toFixed(1);
        const img    = c.images?.[0]?.url || c.image_url || null;
        const cat    = c.category ? (c.category.name || c.category.category_name || '') : 'Mission';
        const isFav  = favIds.has(c.id);

        return `
        <div class="campaign-intel-card group bg-white rounded-xl overflow-hidden border border-black/5 hover:border-[#064e3b] transition-all duration-700 shadow-sm hover:shadow-2xl flex flex-col h-full relative cursor-pointer" onclick="window.location='/campaigns/${c.id}'">
            <div class="relative h-64 overflow-hidden bg-zinc-50 border-b border-black/[0.03]">
                ${img
                    ? `<img class="w-full h-full object-cover transition-transform duration-1000 group-hover:scale-110" src="${img}" alt="${escHtml(c.title)}">`
                    : `<div class="w-full h-full flex items-center justify-center text-gray-200"><svg class="h-20 w-20" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg></div>`
                }
                <div class="absolute top-6 left-6 px-4 py-1.5 rounded-full bg-black/80 backdrop-blur-md text-[#059669] text-[8px] font-black uppercase tracking-widest border border-[#059669]/20 shadow-xl">
                    ${escHtml(cat)}
                </div>
                <button onclick="event.stopPropagation(); toggleFav(this, ${c.id})"
                    class="fav-btn absolute top-6 right-6 p-3 rounded-xl backdrop-blur-md transition-all border z-30
                    ${isFav ? 'bg-[#FFD700]/20 border-[#FFD700]/30 text-[#FFD700]' : 'bg-white/20 border-white/20 text-white/60 hover:text-[#FFD700]'}">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="${isFav ? 'currentColor' : 'none'}" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.382-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z"/>
                    </svg>
                </button>
            </div>
            <div class="p-10 flex-grow flex flex-col bg-[#fbf8f6] border-t border-black/[0.02]">
                <div class="flex items-center gap-2 mb-3">
                    <span class="text-[9px] font-black text-emerald-600 uppercase tracking-[0.2em] italic">Project Lead:</span>
                    <span class="text-[10px] font-bold text-[#1A1A1A] uppercase tracking-wider italic underline decoration-emerald-500/30 underline-offset-4">
                        ${escHtml(c.user ? c.user.name || `${c.user.first_name} ${c.user.last_name}` : 'Institutional Partner')}
                    </span>
                </div>
                <h3 class="text-2xl font-black text-[#1A1A1A] mb-8 tracking-tighter leading-tight group-hover:text-[#064e3b] transition-colors line-clamp-2" style="min-height:3.5rem;">
                    ${escHtml(c.title)}.
                </h3>
                <div class="mt-auto space-y-6">
                    <div class="space-y-3">
                        <div class="flex justify-between items-baseline mb-2">
                            <span class="text-xl font-black text-[#1A1A1A] tracking-tighter">${fmtNum(c.current_amount || 0)} MAD</span>
                            <span class="text-[10px] text-gray-400 font-bold uppercase tracking-widest">of ${fmtNum(c.target_amount || 0)} MAD</span>
                        </div>
                        <div class="w-full h-2 rounded-full bg-black/5 overflow-hidden border border-black/5">
                            <div class="h-full bg-[#059669] rounded-full transition-all duration-1000" style="width:${pct}%"></div>
                        </div>
                    </div>
                    <div class="block w-full py-5 rounded-xl bg-[#1A1A1A] text-white text-center text-[10px] font-black uppercase tracking-widest hover:bg-[#064e3b] transition-all transform hover:-translate-y-1 shadow-xl active:scale-95">
                        View Details →
                    </div>
                </div>
            </div>
        </div>`;
    }

    /**
     * toggleFav
     * Toggles the favourite state of a campaign card on the index page.
     * @param {HTMLElement} btn — the star button element
     * @param {number} id — campaign ID
     */
    window.toggleFav = async function (btn, id) {
        if (!ApiClient.isAuthenticated()) { window.location.href = '/login'; return; }
        try {
            await ApiClient.toggleFavourite(id);
            const active = favIds.has(id);
            if (active) { favIds.delete(id); } else { favIds.add(id); }
            const svg = btn.querySelector('svg');
            if (svg) svg.setAttribute('fill', favIds.has(id) ? 'currentColor' : 'none');
            btn.classList.toggle('bg-[#FFD700]/20', favIds.has(id));
            btn.classList.toggle('text-[#FFD700]',  favIds.has(id));
        } catch { console.error('Favourite toggle failed'); }
    };

    // Pagination controls
    document.getElementById('prevPage')?.addEventListener('click', () => { if (currentPage > 1) { currentPage--; renderPage(); } });
    document.getElementById('nextPage')?.addEventListener('click', () => {
        if (currentPage < Math.ceil(filtered.length / PAGE_SIZE)) { currentPage++; renderPage(); }
    });
});


/* ============================================================
 *  SECTION 6 — CAMPAIGN SHOW: Donation Flow & Payment Toast
 *  Page guard: #campaignData (the data-bridge div)
 * ============================================================ */

document.addEventListener('DOMContentLoaded', () => {
    const campaignData = document.getElementById('campaignData');
    if (!campaignData) return; // Not the campaign show page — skip

    const campaignId  = campaignData.dataset.campaignId;
    const donateBtn   = document.getElementById('donateBtn');
    const amountInput = document.getElementById('donationAmount');
    const msg         = document.getElementById('donationMessage');

    // Show payment status if Stripe redirected back with a query param
    const params = new URLSearchParams(window.location.search);
    if (params.get('payment') === 'success') {
        confirmDonation(params.get('session_id'));
    } else if (params.get('payment') === 'cancel') {
        showPaymentMsg(msg, 'Pledge Cancelled. No funds were transferred.', 'cancel');
    }

    async function confirmDonation(sessionId) {
        if (!sessionId) {
            showPaymentMsg(msg, 'Payment session missing. Please contact support.', 'cancel');
            return;
        }

        try {
            const res = await ApiClient.request(`/campaigns/${campaignId}/donations/confirm`, {
                method: 'POST',
                body: JSON.stringify({ session_id: sessionId })
            });

            const campaign = res.data?.campaign || res.data || null;
            const amount = campaign?.current_amount ?? null;
            const target = campaign?.target_amount ?? null;

            showPaymentMsg(msg, 'Verification Successful. Contribution finalized.', 'success');

            if (amount !== null) {
                const amountEl = document.getElementById('currentAmountDisplay');
                if (amountEl) amountEl.textContent = `${fmtNum(amount)} MAD`;
            }

            if (amount !== null && target) {
                const pct = Math.min(100, (Number(amount) / Math.max(1, Number(target))) * 100);
                const bar = document.getElementById('campaignProgressBar');
                const pctEl = document.getElementById('campaignPercent');
                if (bar) bar.style.width = `${pct}%`;
                if (pctEl) pctEl.textContent = `${pct.toFixed(1)}% Efficient`;
            }
        } catch (err) {
            showPaymentMsg(msg, err.message || 'Could not confirm the payment yet.', 'cancel');
        }
    }

    // Donate button — initiates the Stripe Checkout session
    donateBtn?.addEventListener('click', async () => {
        if (!ApiClient.isAuthenticated()) { window.location.href = '/login'; return; }

        const amount = amountInput?.value;
        if (!amount || amount < 10) {
            showPaymentMsg(msg, 'Please enter a valid amount. Minimum 10 MAD.', 'cancel');
            return;
        }

        donateBtn.disabled  = true;
        donateBtn.innerHTML = 'Authorizing...';
        msg.classList.add('hidden');

        try {
            const res = await ApiClient.request(`/campaigns/${campaignId}/donate`, {
                method: 'POST',
                body:   JSON.stringify({ amount })
            });
            if (res.checkout_url) {
                showPaymentMsg(msg, 'Connecting to Secure Gateway...', 'info');
                window.location.href = res.checkout_url;
            } else { throw new Error('Could not establish secure session.'); }
        } catch (err) {
            showPaymentMsg(msg, err.message || 'Donation failed. Please try again.', 'cancel');
            donateBtn.disabled  = false;
            donateBtn.innerHTML = 'Initiate Support →';
        }
    });

    // Allow Enter key in amount input
    amountInput?.addEventListener('keypress', e => { if (e.key === 'Enter') donateBtn.click(); });
});

/**
 * showPaymentMsg
 * Applies the correct styling class to the payment status message element.
 * @param {HTMLElement} el
 * @param {string} text
 * @param {'success'|'cancel'|'info'} type
 */
function showPaymentMsg(el, text, type) {
    if (!el) return;
    el.textContent = text;
    el.classList.remove('hidden');
    const base = 'text-center text-[9px] font-black uppercase tracking-widest mt-4';
    el.className = type === 'success' ? `${base} text-emerald-400 animate-pulse`
                 : type === 'cancel'  ? `${base} text-rose-400`
                 :                      `${base} text-white/60`;
}


/* ============================================================
 *  SECTION 7 — FAVOURITES: Watchlist Page
 *  Page guard: #favCount
 * ============================================================ */

document.addEventListener('DOMContentLoaded', async () => {
    if (!document.getElementById('favCount')) return; // Not the favourites page — skip

    if (!ApiClient.isAuthenticated()) { window.location.href = '/login'; return; }

    let favourites = [];

    /**
     * loadWatchlist
     * Fetches the user's saved campaigns and renders them.
     */
    async function loadWatchlist() {
        try {
            const res  = await ApiClient.getFavourites();
            favourites = (res.data || res || []).map(f => f.campaign).filter(Boolean);
            document.getElementById('favCount').textContent = favourites.length;
            renderWatchlist();
        } catch { showEmptyWatchlist(); }
    }

    function renderWatchlist() {
        const grid     = document.getElementById('campaignsGrid');
        const skeleton = document.getElementById('skeletonGrid');
        const empty    = document.getElementById('emptyState');

        skeleton.classList.add('hidden');
        if (!favourites.length) { showEmptyWatchlist(); return; }

        grid.innerHTML = favourites.map(c => watchlistCard(c)).join('');
        grid.classList.remove('hidden');
        empty.classList.add('hidden');
    }

    function showEmptyWatchlist() {
        document.getElementById('skeletonGrid').classList.add('hidden');
        document.getElementById('campaignsGrid').classList.add('hidden');
        document.getElementById('emptyState').classList.remove('hidden');
    }

    /** watchlistCard — renders a single favourited campaign card */
    function watchlistCard(c) {
        const pct = Math.min(100, ((c.current_amount || 0) / Math.max(1, c.target_amount || 1)) * 100).toFixed(1);
        const img = c.images?.[0]?.url || c.image_url || null;
        const cat = c.category ? (c.category.name || c.category.category_name || '') : 'Mission';

        return `
        <div class="campaign-intel-card group bg-white rounded-xl overflow-hidden border border-black/5 hover:border-[#064e3b] transition-all duration-700 shadow-sm hover:shadow-2xl flex flex-col h-full relative cursor-pointer" onclick="window.location='/campaigns/${c.id}'">
            <div class="relative h-64 overflow-hidden bg-zinc-50 border-b border-black/[0.03]">
                ${img ? `<img class="w-full h-full object-cover transition-transform duration-1000 group-hover:scale-110" src="${img}" alt="${escHtml(c.title)}">` : `<div class="w-full h-full flex items-center justify-center text-gray-200"><svg class="h-20 w-20" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg></div>`}
                <div class="absolute top-6 left-6 px-4 py-1.5 rounded-full bg-black/80 backdrop-blur-md text-[#059669] text-[8px] font-black uppercase tracking-widest border border-[#059669]/20 shadow-xl">${escHtml(cat)}</div>
                <button onclick="event.stopPropagation(); removeFromWatchlist(event, ${c.id})" class="absolute top-6 right-6 p-3 rounded-xl backdrop-blur-md transition-all border border-[#FFD700]/30 bg-[#FFD700]/20 text-[#FFD700] hover:bg-[#FFD700]/40 z-30">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="currentColor" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.382-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z"/></svg>
                </button>
            </div>
            <div class="p-10 flex-grow flex flex-col bg-[#fbf8f6] border-t border-black/[0.02]">
                <div class="flex items-center gap-2 mb-3">
                    <span class="text-[9px] font-black text-emerald-600 uppercase tracking-[0.2em] italic">Project Lead:</span>
                    <span class="text-[10px] font-bold text-[#1A1A1A] uppercase tracking-wider italic underline decoration-emerald-500/30 underline-offset-4">
                        ${escHtml(c.user ? c.user.name || `${c.user.first_name} ${c.user.last_name}` : 'Institutional Partner')}
                    </span>
                </div>
                <h3 class="text-2xl font-black text-[#1A1A1A] mb-8 tracking-tighter leading-tight group-hover:text-[#064e3b] transition-colors line-clamp-2" style="min-height:3.5rem;">${escHtml(c.title)}.</h3>
                <div class="mt-auto space-y-6">
                    <div class="space-y-3">
                        <div class="flex justify-between items-baseline mb-2">
                            <span class="text-xl font-black text-[#1A1A1A] tracking-tighter">${fmtNum(c.current_amount || 0)} MAD</span>
                            <span class="text-[10px] text-gray-400 font-bold uppercase tracking-widest">of ${fmtNum(c.target_amount || 0)} MAD</span>
                        </div>
                        <div class="w-full h-2 rounded-full bg-black/5 overflow-hidden border border-black/5">
                            <div class="h-full bg-[#059669] rounded-full transition-all duration-1000" style="width:${pct}%"></div>
                        </div>
                    </div>
                    <div class="block w-full py-5 rounded-xl bg-[#1A1A1A] text-white text-center text-[10px] font-black uppercase tracking-widest hover:bg-[#064e3b] transition-all transform hover:-translate-y-1 shadow-xl active:scale-95">View Details →</div>
                </div>
            </div>
        </div>`;
    }


    /**
     * removeFromWatchlist
     * Removes one campaign from the watchlist via toggleFavourite API call.
     */
    window.removeFromWatchlist = async function (event, id) {
        event.preventDefault();
        if (!confirm('Remove this mission from your watchlist?')) return;
        try {
            await ApiClient.toggleFavourite(id);
            favourites = favourites.filter(c => c.id !== id);
            document.getElementById('favCount').textContent = favourites.length;
            renderWatchlist();
        } catch { showPorterToast('ACTION FAILED.'); }
    };

    await loadWatchlist();
});


/* ============================================================
 *  SECTION 8 — PORTER DASHBOARD: Mission Registry & Modal
 *  Page guard: #myCampaignsList
 * ============================================================ */

document.addEventListener('DOMContentLoaded', async () => {
    if (!document.getElementById('myCampaignsList')) return; // Not the porter dashboard — skip

    if (!ApiClient.isAuthenticated()) { window.location.href = '/login'; return; }
    const user = ApiClient.getUser();
    document.getElementById('heroName').textContent = (user.first_name || 'Porter').toUpperCase();

    await Promise.all([loadPorterCategories(), loadPorterCampaigns(), loadPorterPayoutStatus()]);

    document.getElementById('stripeConnectBtn')?.addEventListener('click', async () => {
        const btn = document.getElementById('stripeConnectBtn');
        btn.disabled = true;
        btn.textContent = 'Opening Stripe...';
        try {
            const res = await ApiClient.request('/payouts/stripe/onboarding', { method: 'POST' });
            window.location.href = res.url;
        } catch (err) {
            showPorterToast(err.message || 'STRIPE LINK FAILED.');
            btn.disabled = false;
            btn.textContent = 'Connect Stripe';
        }
    });

    // Image preview for the modal's upload zone
    const imageInput = document.getElementById('cImages');
    const gallery    = document.getElementById('galleryPreview');
    const dropText   = document.getElementById('dropText');

    imageInput?.addEventListener('change', () => {
        gallery.innerHTML = '';
        const file = imageInput.files[0];
        if (file) {
            dropText.textContent = 'ASSET READY.';
            dropText.className   = 'text-[11px] font-black text-emerald-600 uppercase tracking-[0.5em] text-center px-6';
            const reader = new FileReader();
            reader.onload = e => { gallery.innerHTML = `<img src="${e.target.result}" class="w-full h-full object-cover">`; };
            reader.readAsDataURL(file);
        } else {
            dropText.textContent = 'Deploy Asset (+)';
            dropText.className   = 'text-[11px] font-black text-amber-900/20 uppercase tracking-[0.5em] text-center px-6';
            gallery.innerHTML    = `<span class="text-[10px] font-black text-amber-900/10 uppercase tracking-[0.4em]">Asset Buffer Empty</span>`;
        }
    });

    // Campaign creation form inside the modal
    document.getElementById('createCampaignForm')?.addEventListener('submit', async (e) => {
        e.preventDefault();
        const btn = document.getElementById('submitBtn');
        const fd  = new FormData();

        fd.append('title',         document.getElementById('cTitle').value.trim());
        fd.append('description',   document.getElementById('cDesc').value.trim());
        fd.append('category_id',   document.getElementById('cCategory').value);
        fd.append('target_amount', document.getElementById('cTarget').value);
        fd.append('start_date',    document.getElementById('cStartDate').value);
        fd.append('end_date',      document.getElementById('cEndDate').value);
        if (imageInput?.files[0]) fd.append('image', imageInput.files[0]);

        if (!fd.get('title') || !fd.get('category_id')) { showPorterToast('PROTOCOL INCOMPLETE.'); return; }

        btn.disabled = true; btn.textContent = 'EXECUTING...';
        try {
            await ApiClient.request('/campaigns', { method: 'POST', body: fd, headers: { 'Content-Type': null } });
            e.target.reset();
            gallery.innerHTML    = '';
            dropText.textContent = 'Deploy Asset (+)';
            closeMissionModal();
            showPorterToast('MISSION LOGGED TO REGISTRY.');
            await loadPorterCampaigns();
        } catch (err) {
            showPorterToast(err.message || 'TRANSMISSION FAILURE.');
            btn.disabled = false; btn.textContent = 'Confirm Mission';
        }
    });
});

/** openMissionModal — opens the sliding campaign creation modal */
function openMissionModal() {
    const modal     = document.getElementById('missionModal');
    const container = document.getElementById('modalContainer');
    modal.classList.remove('hidden');
    setTimeout(() => {
        modal.classList.replace('opacity-0', 'opacity-100');
        container.classList.replace('translate-y-20', 'translate-y-0');
        container.classList.replace('scale-[0.98]', 'scale-100');
        container.classList.replace('opacity-0', 'opacity-100');
    }, 10);
    document.body.style.overflow = 'hidden';
}

/** closeMissionModal — closes the campaign creation modal with animation */
function closeMissionModal() {
    const modal     = document.getElementById('missionModal');
    const container = document.getElementById('modalContainer');
    modal.classList.replace('opacity-100', 'opacity-0');
    container.classList.replace('translate-y-0', 'translate-y-20');
    container.classList.replace('scale-100', 'scale-[0.98]');
    container.classList.replace('opacity-100', 'opacity-0');
    setTimeout(() => { modal.classList.add('hidden'); document.body.style.overflow = ''; }, 500);
}

/** loadPorterPayoutStatus — checks whether Stripe Express is ready for transfers */
async function loadPorterPayoutStatus() {
    const statusEl = document.getElementById('stripeConnectStatus');
    const btn = document.getElementById('stripeConnectBtn');
    if (!statusEl || !btn) return;

    try {
        const res = await ApiClient.request('/payouts/stripe/status');
        const status = res.data || {};

        if (status.ready) {
            statusEl.textContent = 'Stripe connected. Payouts enabled.';
            btn.textContent = 'Manage / Refresh Stripe';
            btn.classList.remove('bg-emerald-900');
            btn.classList.add('bg-black');
        } else if (status.connected) {
            statusEl.textContent = 'Stripe connected. Finish onboarding.';
            btn.textContent = 'Finish Stripe Setup';
        } else {
            statusEl.textContent = 'Stripe not connected.';
            btn.textContent = 'Connect Stripe';
        }
    } catch {
        statusEl.textContent = 'Could not check Stripe payout status.';
    }
}

/** loadPorterCategories — populates the category select in the deploy modal */
async function loadPorterCategories() {
    try {
        const json = await (await fetch('/api/categories', { headers: { Accept: 'application/json' } })).json();
        const sel  = document.getElementById('cCategory');
        (json.data || json || []).forEach(c => {
            const opt = document.createElement('option');
            opt.value = c.id;
            opt.textContent = (c.name || c.category_name).toUpperCase();
            sel.appendChild(opt);
        });
    } catch {}
}

/** loadPorterCampaigns — fetches and renders the porter's own campaign list */
async function loadPorterCampaigns() {
    try {
        const res  = await ApiClient.request('/my-campaigns');
        renderPorterRegistry(res.data || res || []);
    } catch {}
}

function renderPorterRegistry(list) {
    const el = document.getElementById('myCampaignsList');
    const totalRaisedEl = document.getElementById('porterTotalRaised');
    const campaignCountEl = document.getElementById('porterCampaignCount');
    const donationCountEl = document.getElementById('porterDonationCount');

    const totalRaised = list.reduce((sum, c) => sum + Number(c.current_amount || 0), 0);
    const donationCount = list.reduce((sum, c) => sum + Number(c.donations_count || 0), 0);

    if (totalRaisedEl) totalRaisedEl.textContent = `${fmtNum(totalRaised)} MAD`;
    if (campaignCountEl) campaignCountEl.textContent = `${list.length}`;
    if (donationCountEl) donationCountEl.textContent = `${donationCount}`;

    if (!list.length) {
        el.innerHTML = `<div class="py-32 text-center bg-white rounded-[3.5rem] border border-amber-500/5 shadow-xl"><p class="text-amber-900/10 font-black text-[12px] uppercase tracking-[0.8em] font-sans">Registry Stream Depleted.</p></div>`;
        return;
    }
    el.innerHTML = list.map(c => {
        const statusClass = c.status === 'active' ? 'text-emerald-700 border-emerald-200 bg-emerald-50' : 'text-slate-400 border-slate-100 bg-slate-50';
        const img = c.images?.[0]?.url || null;
        const progress = Math.min(100, (Number(c.current_amount || 0) / Math.max(1, Number(c.target_amount || 1))) * 100).toFixed(1);
        const availableForPayout = Number(c.available_for_payout || 0);
        return `
        <div class="group bg-white p-12 rounded-2xl border-2 border-emerald-500/20 flex items-center gap-16 shadow-xl transition-all duration-700 hover:shadow-2xl hover:border-emerald-500/40 font-sans">
            <div class="w-24 h-24 rounded-xl bg-slate-50 overflow-hidden flex-shrink-0 border-2 border-emerald-500/20">
                ${img ? `<img src="${img}" class="w-full h-full object-cover">` : `<div class="w-full h-full flex items-center justify-center text-slate-200"><svg class="h-10 w-10" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14"/></svg></div>`}
            </div>
            <div class="flex-grow min-w-0 space-y-4">
                <div class="flex items-center gap-6">
                    <span class="text-[11px] font-black uppercase tracking-[0.3em] ${statusClass} px-6 py-2.5 rounded-lg border-2 border-emerald-500/30">${c.status}.</span>
                    <span class="text-[12px] text-black/30 font-black uppercase tracking-[0.4em] italic opacity-60">${new Date(c.created_at).toLocaleDateString()}</span>
                </div>
                <h3 class="text-5xl font-black text-black tracking-tighter truncate leading-none">${escHtml(c.title)}</h3>
            </div>
            <div class="flex items-center gap-20 flex-shrink-0">
                <div class="text-right space-y-3">
                    <span class="text-7xl font-black text-black tracking-tighter tabular-nums block">${Number(c.current_amount || 0).toLocaleString()} <span class="text-[14px] text-emerald-600 uppercase tracking-[0.5em]">MAD</span></span>
                    <div class="w-64 h-2 rounded-full bg-black/5 overflow-hidden ml-auto">
                        <div class="h-full bg-emerald-500 rounded-full" style="width:${progress}%"></div>
                    </div>
                </div>
                <div class="flex flex-col gap-3">
                    <a href="/campaigns/${c.id}" class="px-12 py-6 rounded-lg bg-black text-[11px] font-black text-white hover:bg-zinc-800 uppercase tracking-[0.6em] transition-all shadow-xl text-center">INTERFACE</a>
                    ${availableForPayout > 0 ? `<button onclick="requestCampaignPayout(${c.id}, ${availableForPayout})" class="px-12 py-5 rounded-lg bg-emerald-900 text-[10px] font-black text-white hover:bg-emerald-950 uppercase tracking-[0.35em] transition-all shadow-lg">PAYOUT ${availableForPayout.toLocaleString()} MAD</button>` : `<span class="text-center text-[9px] font-black uppercase tracking-[0.35em] text-black/25">No payable balance</span>`}
                </div>
            </div>
        </div>`;
    }).join('');
}

/** requestCampaignPayout — transfers completed unpaid campaign funds to the porter's Stripe account */
async function requestCampaignPayout(campaignId, amount) {
    if (!confirm(`Request payout of ${Number(amount).toLocaleString()} MAD for this campaign?`)) return;

    try {
        await ApiClient.request(`/campaigns/${campaignId}/payout`, {
            method: 'POST',
            body: JSON.stringify({ amount })
        });
        showPorterToast('PAYOUT TRANSFER CREATED.');
        await Promise.all([loadPorterPayoutStatus(), loadPorterCampaigns()]);
    } catch (err) {
        showPorterToast(err.message || 'PAYOUT FAILED.');
    }
}

/**
 * showPorterToast
 * Displays a temporary floating toast notification on the porter dashboard.
 */
function showPorterToast(msg) {
    const t = document.createElement('div');
    t.className = 'fixed bottom-16 left-1/2 -translate-x-1/2 z-[200] bg-black text-white px-16 py-6 rounded-[2rem] text-[11px] font-black uppercase tracking-[0.5em] shadow-3xl flex items-center gap-8 transition-all duration-700 opacity-0 translate-y-12 border-2 border-white/10';
    t.innerHTML = `<div class="w-3.5 h-3.5 rounded-full bg-emerald-300 animate-pulse"></div><span>${msg}</span>`;
    document.body.appendChild(t);
    setTimeout(() => { t.classList.replace('opacity-0', 'opacity-100'); t.classList.replace('translate-y-12', 'translate-y-0'); }, 10);
    setTimeout(() => { t.classList.replace('opacity-100', 'opacity-0'); t.classList.replace('translate-y-0', 'translate-y-12'); setTimeout(() => t.remove(), 700); }, 4000);
}


/* ============================================================
 *  SECTION 9 — ORGANISATION REGISTER: Institutional Form
 *  Page guard: #orgRegisterForm
 * ============================================================ */

document.addEventListener('DOMContentLoaded', () => {
    const orgForm = document.getElementById('orgRegisterForm');
    if (!orgForm) return; // Not the org register page — skip

    orgForm.addEventListener('submit', async (e) => {
        e.preventDefault();
        const btn      = document.getElementById('registerBtn');
        const errorDiv = document.getElementById('registerError');

        const fd = new FormData();
        fd.append('name',        document.getElementById('name').value);
        fd.append('email',       document.getElementById('email').value);
        fd.append('password',    document.getElementById('password').value);
        fd.append('description', document.getElementById('description').value);
        fd.append('phone',       document.getElementById('phone').value);
        fd.append('address',     document.getElementById('address').value);
        const logo = document.getElementById('logo')?.files[0];
        if (logo) fd.append('logo', logo);
        const doc = document.getElementById('document')?.files[0];
        if (doc) fd.append('document', doc);

        btn.disabled  = true;
        btn.innerHTML = '<span class="flex items-center justify-center animate-pulse tracking-widest">INITIALIZING PROTOCOL...</span>';
        errorDiv.classList.add('hidden');

        try {
            await ApiClient.registerOrganisation(fd);
            showPorterToast('APPLICATION DEPLOYED.');
            setTimeout(() => { window.location.href = '/'; }, 1400);
        } catch (error) {
            const msg = error.message || (error.errors ? Object.values(error.errors)[0][0] : 'Validation failure.');
            errorDiv.textContent = msg;
            errorDiv.classList.remove('hidden');
            btn.disabled  = false;
            btn.innerHTML = 'COMPLETE REGISTRATION';
        }
    });
});


/* ============================================================
 *  SECTION 10 — ADMIN DASHBOARD: Tabs & Action Buttons
 *  Page guard: .admin-tab
 * ============================================================ */

/**
 * showTab
 * Switches the visible admin panel tab and updates nav active state.
 * Called via onclick attributes in admin/dashboard.blade.php.
 * @param {string} name — one of 'campaigns', 'users', 'partners', 'categories'
 */
function showTab(name) {
    document.querySelectorAll('.admin-tab').forEach(t => t.classList.add('hidden'));
    document.getElementById('tab-' + name)?.classList.remove('hidden');

    document.querySelectorAll('.admin-nav-btn').forEach(btn => {
        btn.classList.remove('bg-slate-50', 'text-black', 'border-2', 'border-emerald-500/30');
        btn.classList.add('text-black/40');
    });
    const activeBtn = document.getElementById('btn-' + name);
    if (activeBtn) {
        activeBtn.classList.remove('text-black/40');
        activeBtn.classList.add('bg-slate-50', 'text-black', 'border-2', 'border-emerald-500/30');
    }
}

/**
 * adminPost
 * Shared authenticated POST helper used by all admin action functions.
 * @param {string} url
 */
function adminPost(url) {
    return fetch(url, {
        method: 'POST',
        headers: {
            Authorization: `Bearer ${localStorage.getItem('donify_token')}`,
            Accept: 'application/json'
        }
    });
}

/** verifyOrg — grants verified status to a partner organisation */
async function verifyOrg(id) {
    try { if ((await adminPost(`/api/organisations/${id}/verify`)).ok) location.reload(); }
    catch { console.error('Verification failed'); }
}

/** rejectOrg — revokes verified status from a partner organisation */
async function rejectOrg(id) {
    try { if ((await adminPost(`/api/organisations/${id}/reject`)).ok) location.reload(); }
    catch { console.error('Reject org failed'); }
}

/** approveCampaign — sets a campaign status to active */
async function approveCampaign(id) {
    try { if ((await adminPost(`/api/campaigns/${id}/approve`)).ok) location.reload(); }
    catch { console.error('Approve failed'); }
}

/** rejectCampaign — rejects a campaign that is pending review */
async function rejectCampaign(id) {
    try { if ((await adminPost(`/api/campaigns/${id}/reject`)).ok) location.reload(); }
    catch { console.error('Reject campaign failed'); }
}


/* ============================================================
 *  SHARED UTILITIES — used by multiple sections above
 * ============================================================ */

/**
 * fmtNum
 * Formats a number with locale-aware thousand separators.
 * @param {number} n
 * @returns {string}
 */
function fmtNum(n) { return Number(n).toLocaleString('en-US'); }

/**
 * escHtml
 * Escapes a string for safe insertion into innerHTML.
 * @param {string} str
 * @returns {string}
 */
function escHtml(str) {
    const d = document.createElement('div');
    d.appendChild(document.createTextNode(str || ''));
    return d.innerHTML;
}
