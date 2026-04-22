// ── Donify Admin Console JS 7.0 (Luxury Raja Standard) ───────────────────────────
let AC = [], AU = [], ACAT = [], AORG_ALL = [];

document.addEventListener('DOMContentLoaded', async () => {
    const splash = (id) => { document.getElementById('adminLoading').style.display = 'none'; if(id) { document.getElementById(id).style.display = 'flex'; } };
    if (!ApiClient.isAuthenticated()) return splash('adminGuest');
    
    let u;
    try { u = await ApiClient.request('/auth/me'); } catch { return splash('adminGuest'); }
    if (u.role !== 'admin') return splash('adminGuest');

    document.getElementById('adminLoading').style.display = 'none';
    document.getElementById('adminContent').style.display = 'flex';
    
    // Header UI
    document.getElementById('sbName').textContent = `${u.first_name || ''} ${u.last_name || ''}`;
    const av = document.getElementById('sbAv');
    if (u.images?.url) av.innerHTML = `<img src="${u.images.url}" class="w-full h-full object-cover">`;
    else av.textContent = (u.first_name || 'A')[0].toUpperCase();

    await Promise.all([loadUsers(true), loadCamps(true), loadOrgs(true), loadCats()]);
    renderOV();
});

// ── Loaders ────────────────────────────────────────────
async function loadUsers(r = true) {
    try {
        const res = await ApiClient.request('/users'); 
        AU = res.data || res || [];
        if(r) renderUT();
    } catch { tst('Operational error: User sync failed', 'error'); }
}

async function loadCamps(r = true) {
    try {
        const res = await ApiClient.request('/campaigns/all'); 
        AC = res.data || res || [];
        if(r) renderCT();
    } catch { tst('Operational error: Campaign sync failed', 'error'); }
}

async function loadOrgs(r = true) {
    try {
        const [p, a] = await Promise.all([
            ApiClient.request('/organisations/pending').catch(() => ({data:[]})),
            ApiClient.request('/organisations').catch(() => ({data:[]}))
        ]);
        const pOrgs = p.data || p || [];
        const seen = new Set();
        AORG_ALL = [...pOrgs, ...(a.data || a || [])].filter(o => !seen.has(o.id) && seen.add(o.id));
        if(r) renderOT();
    } catch { tst('Operational error: Partner sync failed', 'error'); }
}

async function loadCats() {
    try {
        const res = await ApiClient.request('/categories'); 
        ACAT = res.data || res || [];
        renderCatG();
    } catch { tst('Operational error: Domain sync failed', 'error'); }
}

// ── Renders ───────────────────────────────────────────
function renderOV() {
    const cp = AC.filter(c => c.status === 'pending').slice(0, 5);
    document.getElementById('ovPend').innerHTML = cp.length 
        ? cp.map(c => ovItem(c.id, c.title, (c.user?.first_name || 'Anonymous'), c.images?.[0]?.url, 'approveC', 'rejectC', 'Authorize')).join('')
        : empty('Neutralized: No pending verifications.');

    const op = AORG_ALL.filter(o => !o.is_verified).slice(0, 5);
    document.getElementById('ovOrgs').innerHTML = op.length
        ? op.map(o => ovItem(o.id, o.name, o.email, o.logo, 'verifyOrg', 'rejectOrg', 'Verify Partner')).join('')
        : empty('Neutralized: Partner waitlist clear.');
}

function renderCT() {
    document.getElementById('campWrap').innerHTML = tbl(
        ['Campaign Cause', 'Target', 'Status', 'Actions'],
        (AC || []).map(c => [
            `<div class="flex items-center gap-5 text-left">${thumb(c.images?.[0]?.url, c.title)}<div><div class="font-black text-[#1A1A1A] text-sm italic tracking-tight">${x(c.title)}</div><div class="text-[9px] text-gray-400 font-black uppercase tracking-[0.2em] mt-1">${x(c.category?.category_name || 'Legacy Cause')}</div></div></div>`,
            `<div class="font-black text-[#1A1A1A] text-sm">${fmt(c.target_amount)}</div>`,
            badge(c.status),
            c.status === 'pending' 
                ? btnGrp(c.id, 'approveC', 'rejectC', 'Authorize')
                : (c.status === 'active' 
                    ? mBtn(c.id, 'rejectC', 'De-Authorize', '#ef4444') 
                    : mBtn(c.id, 'approveC', 'Re-Authorize', '#064e3b'))
        ])
    );
}

function renderUT() {
    const wrap = document.getElementById('userWrap'); if(!wrap) return;
    wrap.innerHTML = tbl(
        ['Identity', 'Role', 'Security Status', 'Actions'],
        (AU || []).map(u => [
            `<div class="flex items-center gap-5 text-left">${thumb(u.images?.url, u.first_name)}<div><div class="font-black text-[#1A1A1A] text-sm italic tracking-tight">${x(u.first_name + ' ' + u.last_name)}</div><div class="text-[10px] text-gray-400 font-bold italic">${x(u.email)}</div></div></div>`,
            `<div class="text-[10px] font-black uppercase tracking-widest text-[#064e3b] italic">${u.role}</div>`,
            u.is_banned ? badge('cancelled', 'BANNED') : badge('active', 'VERIFIED'),
            u.role === 'admin' ? '-' : (u.is_banned ? mBtn(u.id, 'unbanU', 'Unlock', '#064e3b') : mBtn(u.id, 'banU', 'Restrict', '#DAA520'))
        ])
    );
}

function renderOT() {
    document.getElementById('orgWrap').innerHTML = tbl(
        ['Partner Entity', 'Credentials', 'Actions'],
        (AORG_ALL || []).map(o => [
            `<div class="flex items-center gap-5 text-left font-black text-[#1A1A1A] text-sm italic tracking-tight">${thumb(o.logo, o.name)}${x(o.name)}</div>`,
            badge(o.is_verified ? 'active' : 'pending', o.is_verified ? 'OFFICIAL PARTNER' : 'VERIFICATION REQUIRED'),
            !o.is_verified ? btnGrp(o.id, 'verifyOrg', 'rejectOrg', 'Authorize Partner') : '-'
        ])
    );
}

function renderCatG() {
    const e = document.getElementById('catCount'); if(e) e.textContent = `${ACAT.length} Total Domains`;
    document.getElementById('catGrid').innerHTML = (ACAT || []).map(c => `
        <div class="flex items-center justify-between bg-white border border-black/5 rounded-2xl px-6 py-4 transition-all duration-500 hover:shadow-lg group">
            <span class="font-black text-[#1A1A1A] text-xs uppercase tracking-widest italic">${x(c.category_name)}</span>
            <button onclick="deleteCat(${c.id},this)" class="opacity-0 group-hover:opacity-100 p-2 text-red-300 hover:text-red-500 transition-all border-none cursor-pointer bg-transparent">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="3" viewBox="0 0 24 24"><path d="M6 18L18 6M6 6l12 12"/></svg>
            </button>
        </div>
    `).join('');
}

// ── Actions ────────────────────────────────────────────
async function act(id, btn, ep, mut, msg) {
    if(btn) { btn.disabled = true; btn.style.opacity = '0.5'; }
    try {
        await ApiClient.request(ep, { method: 'POST' });
        mut(id); tst(`${msg}: Completed`);
    } catch { tst('Operational error: Action denied', 'error'); }
    finally { if(btn) { btn.disabled = false; btn.style.opacity = '1'; } }
}

window.approveC  = (id, b) => act(id, b, `/campaigns/${id}/approve`, i => { const c=AC.find(x=>x.id===i); if(c) c.status='active'; renderCT(); renderOV(); }, 'Authorization Granted');
window.rejectC   = (id, b) => act(id, b, `/campaigns/${id}/reject`,  i => { const c=AC.find(x=>x.id===i); if(c) c.status='cancelled'; renderCT(); renderOV(); }, 'Authorization Denied');
window.banU      = (id, b) => act(id, b, `/users/${id}/ban`,          i => { const u=AU.find(x=>x.id===i); if(u) u.is_banned=true; renderUT(); }, 'Credentials Locked');
window.unbanU    = (id, b) => act(id, b, `/users/${id}/unban`,        i => { const u=AU.find(x=>x.id===i); if(u) u.is_banned=false; renderUT(); }, 'Credentials Restored');
window.verifyOrg = (id, b) => act(id, b, `/organisations/${id}/verify`, i => { const o=AORG_ALL.find(x=>x.id===i); if(o) o.is_verified=true; renderOT(); renderOV(); }, 'Partner Authorized');
window.rejectOrg = (id, b) => act(id, b, `/organisations/${id}/reject`, i => { AORG_ALL = AORG_ALL.filter(x=>x.id!==i); renderOT(); renderOV(); }, 'Partner Decoupled');

window.createCat = async () => {
    const input = document.getElementById('catName');
    const n = input.value.trim(); if(!n) return;
    const btn = document.getElementById('catBtn'); btn.disabled = true;
    try {
        await ApiClient.request('/categories', { method: 'POST', body: JSON.stringify({ category_name: n }) });
        input.value = ''; await loadCats(); tst('New Domain Established');
    } finally { btn.disabled = false; }
};

window.deleteCat = async (id, btn) => {
    if(!confirm('Decommission this domain?')) return;
    try { await ApiClient.request(`/categories/${id}`, { method: 'DELETE' }); ACAT = ACAT.filter(x=>x.id!==id); renderCatG(); tst('Domain Decommissioned'); } catch(e){}
};

// ── Components ─────────────────────────────────────────
function tbl(hs, rs) {
    if(!rs.length) return empty('The matrix is currently empty.');
    return `
        <div class="overflow-x-auto"><table class="w-full border-collapse">
            <thead class="bg-black/5">
                <tr class="border-b border-black/5">
                    ${hs.map(h => `<th class="px-10 py-6 text-left text-[10px] font-black uppercase tracking-[0.4em] text-gray-400">${h}</th>`).join('')}
                </tr>
            </thead>
            <tbody class="divide-y divide-black/5">
                ${rs.map(r => `
                    <tr class="hover:bg-white/40 transition-all duration-300">
                        ${r.map(c => `<td class="px-10 py-8 text-xs align-middle text-[#1A1A1A] font-medium tracking-tight">${c}</td>`).join('')}
                    </tr>
                `).join('')}
            </tbody>
        </table></div>
    `;
}

function ovItem(id, t, s, img, ok, no, okT) {
    return `
        <div class="px-10 py-6 flex items-center justify-between hover:bg-white/40 transition-all group">
            <div class="flex items-center gap-5">
                ${thumb(img, t)}
                <div>
                    <div class="font-black text-[#1A1A1A] text-sm leading-tight">${x(t)}</div>
                    <div class="text-[9px] text-gray-400 font-black uppercase tracking-[0.2em] mt-1.5">${x(s || 'Primary Instance')}</div>
                </div>
            </div>
            <div class="flex gap-4">
                <button onclick="${ok}(${id},this)" class="bg-[#1A1A1A] hover:bg-[#064e3b] text-white px-6 py-3 rounded-xl text-[10px] font-black tracking-widest uppercase transition-all duration-300 hover:scale-[1.05] active:scale-95 border-none cursor-pointer shadow-lg shadow-black/10">${okT}</button>
                <button onclick="${no}(${id},this)" class="bg-white text-gray-300 hover:text-red-500 border border-black/5 px-4 py-3 rounded-xl transition-all cursor-pointer shadow-sm">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="3" viewBox="0 0 24 24"><path d="M6 18L18 6M6 6l12 12"/></svg>
                </button>
            </div>
        </div>
    `;
}

function mBtn(id, fn, t, color) {
    return `<button onclick="${fn}(${id},this)" class="bg-white border-2 text-[10px] font-black uppercase tracking-widest px-6 py-3 rounded-xl transition-all duration-300 hover:scale-[1.05] active:scale-95 cursor-pointer shadow-sm hover:shadow-md" style="color:${color}; border-color: ${color}20">${t}</button>`;
}

function btnGrp(id, ok, no, okT) {
    return `<div class="flex gap-3">${mBtn(id, ok, okT, '#064e3b')}${mBtn(id, no, 'Deny', '#ef4444')}</div>`;
}

function badge(s, over) {
    const c = s==='pending' ? 'text-amber-500 bg-amber-500/10' : (s==='active' ? 'text-[#064e3b] bg-[#064e3b]/10' : 'text-red-500 bg-red-50');
    return `<span class="px-4 py-2 rounded-xl text-[9px] font-black uppercase tracking-[0.15em] ${c}">${over || s}</span>`;
}

function thumb(u, t) {
    const cls = "w-12 h-12 rounded-2xl bg-black/5 border border-black/5 object-cover shrink-0 flex items-center justify-center font-black text-gray-400 text-sm shadow-sm";
    return u ? `<img src="${u}" class="${cls}">` : `<div class="${cls}">${(t||'?')[0].toUpperCase()}</div>`;
}

// ── Utils ──────────────────────────────────────────────
function x(s) { const d=document.createElement('div'); d.innerText=s || ''; return d.innerHTML; }
function fmt(n) { return '$' + Number(n || 0).toLocaleString(); }
function empty(m) { return `<div class="p-20 text-center text-gray-200 font-black text-[12px] tracking-[0.3em] uppercase italic">${m}</div>`; }

function tst(m, tp = 'success') {
    const t = document.getElementById('toast'); t.textContent = m;
    t.className = `fixed bottom-10 right-10 z-[100] ${tp=='error'?'bg-red-500':'bg-[#1A1A1A]'} text-white px-10 py-5 rounded-2xl text-[10px] font-black uppercase tracking-[0.2em] shadow-2xl transition-all duration-700 opacity-100 translate-y-0 pointer-events-none italic border-l-4 border-[#DAA520]`;
    setTimeout(() => { t.style.opacity = '0'; t.style.transform = 'translateY(80px)'; }, 4000);
}
