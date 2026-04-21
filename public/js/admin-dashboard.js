// ── Donify Admin Console JS 4.0 ────────────────────────────
let AC = [], AU = [], ACAT = [], AORG_ALL = [];

document.addEventListener('DOMContentLoaded', async () => {
    const splash = (id) => { document.getElementById('adminLoading').style.display = 'none'; if(id) { document.getElementById(id).style.display = 'flex'; } };
    if (!ApiClient.isAuthenticated()) return splash('adminGuest');
    
    let u;
    try { u = await ApiClient.request('/auth/me'); } catch { return splash('adminGuest'); }
    if (u.role !== 'admin') return splash('adminWrongRole');

    document.getElementById('adminLoading').style.display = 'none';
    document.getElementById('adminContent').style.display = 'flex';
    
    // Header UI
    document.getElementById('sbName').textContent = `${u.first_name || ''} ${u.last_name || ''}`;
    const av = document.getElementById('sbAv');
    if (u.images?.url) av.innerHTML = `<img src="${u.images.url}" class="w-full h-full object-cover">`;
    else av.textContent = (u.first_name || 'A')[0].toUpperCase();

    await Promise.all([loadUsers(false), loadCamps(false), loadOrgs(false), loadCats()]);
    renderOV();
});

// ── Loaders ────────────────────────────────────────────
async function loadUsers(r = true) {
    try {
        const res = await ApiClient.request('/users'); 
        AU = res.data || res || [];
        if(r) renderUT();
    } catch { tst('User sync failed', 'error'); }
}

async function loadCamps(r = true) {
    try {
        const res = await ApiClient.request('/campaigns/all'); 
        AC = res.data || res || [];
        if(r) renderCT();
    } catch { tst('Campaign sync failed', 'error'); }
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
    } catch { tst('Partner sync failed', 'error'); }
}

async function loadCats() {
    try {
        const res = await ApiClient.request('/categories'); 
        ACAT = res.data || res || [];
        renderCatG();
    } catch { tst('Category sync failed', 'error'); }
}

// ── Renders ───────────────────────────────────────────
function renderOV() {
    const cp = AC.filter(c => c.status === 'pending').slice(0, 5);
    document.getElementById('ovPend').innerHTML = cp.length 
        ? cp.map(c => ovItem(c.id, c.title, c.user?.first_name, c.images?.[0]?.url, 'approveC', 'rejectC', 'Approve')).join('')
        : empty('All campaigns processed.');

    const op = AORG_ALL.filter(o => !o.is_verified).slice(0, 5);
    document.getElementById('ovOrgs').innerHTML = op.length
        ? op.map(o => ovItem(o.id, o.name, o.email, o.logo, 'verifyOrg', 'rejectOrg', 'Verify')).join('')
        : empty('No partners pending.');
}

function renderCT() {
    document.getElementById('campWrap').innerHTML = tbl(
        ['Campaign', 'Target', 'Status', 'Magic'],
        (AC || []).map(c => [
            `<div class="flex items-center gap-4 text-left">${thumb(c.images?.[0]?.url, c.title)}<div><div class="font-bold text-black text-xs">${x(c.title)}</div><div class="text-[9px] text-slate-400 font-bold uppercase tracking-widest">${x(c.category?.category_name || 'Cause')}</div></div></div>`,
            `<div class="font-bold text-black text-[11px]">$${fmt(c.target_amount)}</div>`,
            badge(c.status),
            c.status === 'pending' 
                ? btnGrp(c.id, 'approveC', 'rejectC', 'Approve')
                : `<span class="text-[9px] font-black text-slate-200 uppercase tracking-widest">${c.status}</span>`
        ])
    );
}

function renderUT() {
    const wrap = document.getElementById('userWrap'); if(!wrap) return;
    wrap.innerHTML = tbl(
        ['Identity', 'Role', 'Status', 'Magic'],
        (AU || []).map(u => [
            `<div class="flex items-center gap-4 text-left">${thumb(u.images?.url, u.first_name)}<div><div class="font-bold text-black text-xs">${x(u.first_name + ' ' + u.last_name)}</div><div class="text-[9px] text-slate-400 font-medium">${x(u.email)}</div></div></div>`,
            `<div class="text-[9px] font-black uppercase tracking-widest text-[#059669]">${u.role}</div>`,
            u.is_banned ? badge('cancelled', 'Banned') : badge('active', 'Safe'),
            u.role === 'admin' ? '-' : (u.is_banned ? mBtn(u.id, 'unbanU', 'Unban', '#059669') : mBtn(u.id, 'banU', 'Ban', '#f59e0b'))
        ])
    );
}

function renderOT() {
    document.getElementById('orgWrap').innerHTML = tbl(
        ['Partner Entity', 'Status', 'Magic'],
        (AORG_ALL || []).map(o => [
            `<div class="flex items-center gap-4 text-left font-bold text-black text-xs tracking-tight">${thumb(o.logo, o.name)}${x(o.name)}</div>`,
            badge(o.is_verified ? 'active' : 'pending', o.is_verified ? 'Verified' : 'Waitlist'),
            !o.is_verified ? btnGrp(o.id, 'verifyOrg', 'rejectOrg', 'Verify') : '-'
        ])
    );
}

function renderCatG() {
    const e = document.getElementById('catCount'); if(e) e.textContent = `${ACAT.length} Items`;
    document.getElementById('catGrid').innerHTML = (ACAT || []).map(c => `
        <div class="flex items-center justify-between bg-slate-50/50 border border-slate-100 rounded-lg px-5 py-4 transition-all duration-300 hover:scale-[1.02] group">
            <span class="font-bold text-black text-xs">${x(c.category_name)}</span>
            <button onclick="deleteCat(${c.id},this)" class="opacity-0 group-hover:opacity-100 p-2 text-red-400 hover:text-red-600 transition-all border-none cursor-pointer bg-transparent">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path d="M6 18L18 6M6 6l12 12"/></svg>
            </button>
        </div>
    `).join('');
}

// ── Actions ────────────────────────────────────────────
async function act(id, btn, ep, mut, msg) {
    if(btn) { btn.disabled = true; btn.style.opacity = '0.5'; }
    try {
        await ApiClient.request(ep, { method: 'POST' });
        mut(id); tst(msg);
    } catch { tst('Matrix error', 'error'); }
    finally { if(btn) { btn.disabled = false; btn.style.opacity = '1'; } }
}

window.approveC  = (id, b) => act(id, b, `/campaigns/${id}/approve`, i => { const c=AC.find(x=>x.id===i); if(c) c.status='active'; renderCT(); renderOV(); }, 'Authorized');
window.rejectC   = (id, b) => act(id, b, `/campaigns/${id}/reject`,  i => { const c=AC.find(x=>x.id===i); if(c) c.status='cancelled'; renderCT(); renderOV(); }, 'Rejected');
window.banU      = (id, b) => act(id, b, `/users/${id}/ban`,          i => { const u=AU.find(x=>x.id===i); if(u) u.is_banned=true; renderUT(); }, 'Locked');
window.unbanU    = (id, b) => act(id, b, `/users/${id}/unban`,        i => { const u=AU.find(x=>x.id===i); if(u) u.is_banned=false; renderUT(); }, 'Unlocked');
window.verifyOrg = (id, b) => act(id, b, `/organisations/${id}/verify`, i => { const o=AORG_ALL.find(x=>x.id===i); if(o) o.is_verified=true; renderOT(); renderOV(); }, 'Verified');
window.rejectOrg = (id, b) => act(id, b, `/organisations/${id}/reject`, i => { AORG_ALL = AORG_ALL.filter(x=>x.id!==i); renderOT(); renderOV(); }, 'Removed');

window.createCat = async () => {
    const input = document.getElementById('catName');
    const n = input.value.trim(); if(!n) return;
    const btn = document.getElementById('catBtn'); btn.disabled = true;
    try {
        await ApiClient.request('/categories', { method: 'POST', body: JSON.stringify({ category_name: n }) });
        input.value = ''; await loadCats(); tst('Success');
    } finally { btn.disabled = false; }
};

window.deleteCat = async (id, btn) => {
    if(!confirm('Delete domain?')) return;
    try { await ApiClient.request(`/categories/${id}`, { method: 'DELETE' }); ACAT = ACAT.filter(x=>x.id!==id); renderCatG(); tst('Deleted'); } catch(e){}
};

// ── Components ─────────────────────────────────────────
function tbl(hs, rs) {
    if(!rs.length) return empty('No data available in this matrix.');
    return `
        <div class="overflow-x-auto"><table class="w-full border-collapse">
            <thead>
                <tr class="bg-slate-50/50 border-b border-slate-100">
                    ${hs.map(h => `<th class="px-8 py-5 text-left text-[9px] font-black uppercase tracking-widest text-slate-400">${h}</th>`).join('')}
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-50">
                ${rs.map(r => `
                    <tr class="hover:bg-slate-50/30 transition-all">
                        ${r.map(c => `<td class="px-8 py-6 text-xs align-middle">${c}</td>`).join('')}
                    </tr>
                `).join('')}
            </tbody>
        </table></div>
    `;
}

function ovItem(id, t, s, img, ok, no, okT) {
    return `
        <div class="px-8 py-5 flex items-center justify-between hover:bg-slate-50/50 transition-all group">
            <div class="flex items-center gap-4">
                ${thumb(img, t)}
                <div>
                    <div class="font-bold text-black text-xs leading-tight">${x(t)}</div>
                    <div class="text-[9px] text-slate-400 font-bold uppercase tracking-widest mt-0.5">${x(s || 'Owner')}</div>
                </div>
            </div>
            <div class="flex gap-2">
                <button onclick="${ok}(${id},this)" class="bg-black text-white px-4 py-2 rounded-lg text-[10px] font-bold transition-all duration-300 hover:scale-[1.05] active:scale-95 border-none cursor-pointer">${okT}</button>
                <button onclick="${no}(${id},this)" class="bg-white text-slate-300 hover:text-red-500 border border-slate-100 px-3 py-2 rounded-lg transition-all cursor-pointer">X</button>
            </div>
        </div>
    `;
}

function mBtn(id, fn, t, color) {
    return `<button onclick="${fn}(${id},this)" class="bg-white border text-[10px] font-bold px-4 py-2 rounded-lg transition-all duration-300 hover:scale-[1.02] active:scale-95 cursor-pointer shadow-sm" style="color:${color}; border-color: ${color}20">${t}</button>`;
}

function btnGrp(id, ok, no, okT) {
    return `<div class="flex gap-2">${mBtn(id, ok, okT, '#059669')}${mBtn(id, no, 'Reject', '#ef4444')}</div>`;
}

function badge(s, over) {
    const c = s==='pending' ? 'text-amber-600 bg-amber-50' : (s==='active' ? 'text-emerald-600 bg-emerald-50' : 'text-red-500 bg-red-50');
    return `<span class="px-2.5 py-1 rounded-md text-[9px] font-bold uppercase tracking-widest ${c}">${over || s}</span>`;
}

function thumb(u, t) {
    const cls = "w-10 h-10 rounded-lg bg-slate-100 border border-slate-200 object-cover shrink-0 flex items-center justify-center font-bold text-slate-400 text-xs";
    return u ? `<img src="${u}" class="${cls}">` : `<div class="${cls}">${(t||'?')[0].toUpperCase()}</div>`;
}

// ── Utils ──────────────────────────────────────────────
function x(s) { const d=document.createElement('div'); d.innerText=s || ''; return d.innerHTML; }
function fmt(n) { return Number(n || 0).toLocaleString(); }
function empty(m) { return `<div class="p-12 text-center text-slate-300 font-bold text-[10px] tracking-widest uppercase">${m}</div>`; }

function tst(m, tp = 'success') {
    const t = document.getElementById('toast'); t.textContent = m;
    t.className = `fixed bottom-10 right-10 z-[100] ${tp=='error'?'bg-red-500':'bg-black'} text-white px-8 py-4 rounded-lg text-xs font-bold shadow-2xl translate-y-0 opacity-100 transition-all duration-500 pointer-events-none`;
    setTimeout(() => { t.style.opacity = '0'; t.style.transform = 'translateY(80px)'; }, 4000);
}
