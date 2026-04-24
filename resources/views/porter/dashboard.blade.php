@extends('layouts.app')

@section('content')

{{-- Porter Command Dashboard (Luxury Raja Light) --}}
<div class="min-h-screen bg-[#FAFAF5] font-quicksand relative overflow-hidden flex flex-col text-black selection:bg-emerald-500/ font-sans">
    
    {{-- Atmospheric Depth Prestige --}}
    <div class="fixed inset-0 pointer-events-none overflow-hidden z-0">
        <div class="absolute -top-[10%] -right-[5%] w-[70%] h-[70%] bg-emerald-500/5 blur-[180px] rounded-full opacity-40"></div>
        <div class="absolute -bottom-[20%] -left-[10%] w-[60%] h-[60%] bg-amber-500/5 blur-[150px] rounded-full opacity-40"></div>
    </div>

    {{-- Hero Section --}}
    <section class="relative pt-40 pb-24 px-8 z-10 text-center">
        <div class="max-w-7xl mx-auto flex flex-col items-center">
            <div class="relative group mb-12 cursor-pointer transition-all duration-700">
                <div class="absolute -inset-6 bg-emerald-500/5 blur-2xl rounded-full opacity-0 group-hover:opacity-100 transition-opacity"></div>
                <img src="{{ asset('images/donifylg.png') }}" alt="Donify Logo" class="h-24 w-auto relative z-10 opacity-90 transition-all duration-500">
            </div>
            
            <h1 class="text-7xl md:text-9xl font-black text-black leading-none mb-8 tracking-tighter">
                Registry.
            </h1>
            <div class="flex flex-col items-center gap-6 mb-24">
                <div class="h-[1px] w-16 bg-amber-500/20"></div>
                <h2 class="text-xs font-black text-black uppercase tracking-[1em] ml-[1em]">
                    Entity: <span id="heroName" class="text-black font-black tracking-widest">...</span>
                </h2>
            </div>
            
            <button onclick="openMissionModal()" class="group relative px-20 py-8 bg-black text-white rounded-xl text-[11px] font-black uppercase tracking-[0.6em] transition-all shadow-3xl shadow-black/20 overflow-hidden">
                <div class="absolute inset-0 bg-[#C5A021] translate-y-full group-hover:translate-y-0 transition-transform duration-500"></div>
                <span class="relative z-10">Launch The Campaign</span>
            </button>
        </div>
    </section>

    {{-- Main Workspace --}}
    <section class="relative z-10 px-8 pb-40">
        <div class="max-w-6xl mx-auto">
            <div class="flex items-center justify-between mb-16 px-10">
                <div class="space-y-2">
                    <h3 class="text-[10px] font-black text-black/40 uppercase tracking-[0.6em]">Global Distribution Stream</h3>
                    <div class="h-1.5 w-10 bg-black rounded-full"></div>
                </div>
                <div class="flex items-center gap-4 border-b-2 border-amber-500/20 pb-2">
                    <div class="w-1.5 h-1.5 rounded-full bg-emerald-500 animate-pulse"></div>
                    <div class="text-[10px] font-black text-emerald-800 uppercase tracking-widest leading-none">Status: Security Cleared</div>
                </div>
            </div>

            <div class="flex flex-col gap-10" id="myCampaignsList">
                {{-- Skeleton List --}}
                @for($i=0;$i<3;$i++)
                <div class="bg-white h-40 rounded-2xl border-2 border-emerald-500/10 animate-pulse shadow-sm"></div>
                @endfor
            </div>
        </div>
    </section>

    {{-- Modern Modal Console --}}
    <div id="missionModal" class="fixed inset-0 z-[100] hidden opacity-0 transition-all duration-500 flex items-center justify-center p-4 md:p-8">
        {{-- Prestige Backdrop --}}
        <div class="absolute inset-0 bg-[#FAFAF5]/80 backdrop-blur-xl transition-all" onclick="closeMissionModal()"></div>
        
        {{-- Console Interface --}}
        <div class="relative w-full max-w-6xl bg-white rounded-2xl border-2 border-emerald-500/30 shadow-[0_60px_120px_rgba(6,78,59,0.15)] transform transition-all duration-700 translate-y-20 scale-[0.98] opacity-0 overflow-hidden" id="modalContainer">
            
            {{-- Modular Header --}}
            <div class="relative flex flex-col items-center p-16 lg:p-24 border-b-2 border-emerald-500/10 bg-[#FAFAF5]/50 text-center">
                <div class="text-[11px] font-black uppercase tracking-[0.8em] text-black mb-8 ml-[0.8em]">Mission Deployment Interface</div>
                <h5 class="text-6xl md:text-8xl font-black text-black tracking-tighter mb-4 leading-none">Deploy.</h5>
                
                <button onclick="closeMissionModal()" class="absolute top-12 right-12 w-16 h-16 rounded-full bg-slate-50 hover:bg-slate-200 flex items-center justify-center transition-all group border-2 border-slate-100">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-slate-300 group-hover:text-black transition-colors" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M6 18L18 6M6 6l12 12"/></svg>
                </button>
            </div>

            {{-- Form Body --}}
            <div class="p-0 max-h-[70vh] overflow-y-auto [&::-webkit-scrollbar]:w-1.5 [&::-webkit-scrollbar-thumb]:bg-emerald-100 bg-white">
                <form id="createCampaignForm" class="grid grid-cols-1 lg:grid-cols-12 text-slate-800 font-sans">
                    
                    {{-- Left Column: Core Narrative --}}
                    <div class="lg:col-span-7 p-12 lg:p-24 space-y-16">
                        <div class="space-y-6">
                            <label class="text-[11px] font-black text-black/20 uppercase tracking-[0.5em] ml-2 font-sans">Mission Identification</label>
                            <input type="text" id="cTitle" placeholder="PROJECT LABEL"
                                class="w-full bg-slate-50 border-2 border-emerald-500/10 rounded-xl outline-none py-8 px-12 text-2xl font-black text-black placeholder:text-slate-200 focus:border-black/30 transition-all uppercase tracking-widest font-sans">
                        </div>

                        <div class="space-y-6">
                            <label class="text-[11px] font-black text-black/20 uppercase tracking-[0.5em] ml-2 font-sans">Deployment Roadmap</label>
                            <textarea id="cDesc" placeholder="SUMMARY PROTOCOL..."
                                class="w-full bg-slate-50 border-2 border-emerald-500/10 rounded-xl outline-none py-10 px-12 text-base font-medium text-slate-600 placeholder:text-slate-200 focus:border-black/30 h-72 resize-none leading-relaxed uppercase tracking-wider font-sans"></textarea>
                        </div>
                    </div>

                    {{-- Right Column: Config --}}
                    <div class="lg:col-span-5 p-12 lg:p-24 space-y-16 bg-slate-50/50 border-l-2 border-emerald-500/10 font-sans">
                        <div class="space-y-6">
                            <label class="text-[11px] font-black text-black/20 uppercase tracking-[0.5em] ml-2">Sector Domain</label>
                            <select id="cCategory" class="w-full bg-white border-2 border-emerald-500/10 rounded-xl outline-none py-8 px-12 text-[12px] font-black text-black focus:border-black/30 transition-all hover:bg-slate-50 cursor-pointer uppercase tracking-widest font-sans">
                                <option value="">SELECT DOMAIN</option>
                            </select>
                        </div>
                        
                        <div class="space-y-6">
                            <label class="text-[11px] font-black text-black/20 uppercase tracking-[0.5em] ml-2">Budget Target (MAD)</label>
                            <input type="number" id="cTarget" placeholder="000,000"
                                class="w-full bg-white border-2 border-emerald-500/10 rounded-xl outline-none py-8 px-12 text-7xl font-black text-[#C5A021] placeholder:text-amber-100 focus:border-black/30 transition-all font-sans tracking-tighter">
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-10">
                            <div class="space-y-6">
                                <label class="text-[11px] font-black text-black/20 uppercase tracking-[0.5em] ml-2">Active From</label>
                                <input type="date" id="cStartDate" 
                                    class="w-full bg-white border-2 border-emerald-500/10 rounded-xl outline-none py-6 px-10 text-[12px] font-black text-black focus:border-black/30 transition-all uppercase font-sans">
                            </div>
                            <div class="space-y-6">
                                <label class="text-[11px] font-black text-black/20 uppercase tracking-[0.5em] ml-2">Active To</label>
                                <input type="date" id="cEndDate" 
                                    class="w-full bg-white border-2 border-emerald-500/10 rounded-xl outline-none py-6 px-10 text-[12px] font-black text-black focus:border-black/30 transition-all uppercase font-sans">
                            </div>
                        </div>

                        <div class="space-y-8">
                            <label class="text-[11px] font-black text-black/20 uppercase tracking-[0.5em] ml-2 font-sans">Mission Asset</label>
                            <label class="block relative cursor-pointer group">
                                <input type="file" id="cImages" class="absolute inset-0 opacity-0 z-10" accept="image/*">
                                <div class="w-full py-12 border-2 border-dashed border-amber-500/10 rounded-[2.5rem] flex flex-col items-center justify-center transition-all group-hover:border-black/30 bg-white hover:bg-slate-50/20">
                                    <p id="dropText" class="text-[11px] font-black text-black/20 uppercase tracking-[0.5em] group-hover:text-black text-center px-6 transition-colors font-sans">Deploy Asset (+)</p>
                                </div>
                            </label>
                        </div>
                    </div>

                    {{-- Actions --}}
                    <div class="lg:col-span-12 p-16 lg:p-24 bg-slate-50/50 border-t-2 border-emerald-500/10 flex flex-col items-center gap-16">
                        <div id="galleryPreview" class="h-44 w-72 rounded-xl bg-white border-2 border-emerald-500/30 overflow-hidden shadow-3xl flex items-center justify-center group relative cursor-pointer ring-8 ring-transparent hover:ring-black/5 transition-all" onclick="document.getElementById('cImages').click()">
                            <span class="text-[10px] font-black text-black/10 uppercase tracking-[0.4em] font-sans">Asset Buffer Empty</span>
                        </div>

                        <button type="submit" id="submitBtn" class="w-full md:w-auto px-32 py-10 bg-black text-white rounded-xl text-[12px] font-black uppercase tracking-[0.8em] hover:bg-zinc-800 transition-all shadow-[0_25px_50px_rgba(0,0,0,0.2)] transform font-sans">
                            Confirm Mission
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
document.addEventListener('DOMContentLoaded', async () => {
    if (!ApiClient.isAuthenticated()) { window.location.href = '/login'; return; }
    const user = ApiClient.getUser();
    document.getElementById('heroName').textContent = (user.first_name || 'Porter').toUpperCase();
    await Promise.all([loadCategories(), loadOverview()]);
});

function openMissionModal() {
    const modal = document.getElementById('missionModal');
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

function closeMissionModal() {
    const modal = document.getElementById('missionModal');
    const container = document.getElementById('modalContainer');
    modal.classList.replace('opacity-100', 'opacity-0');
    container.classList.replace('translate-y-0', 'translate-y-20');
    container.classList.replace('scale-100', 'scale-[0.98]');
    container.classList.replace('opacity-100', 'opacity-0');
    setTimeout(() => {
        modal.classList.add('hidden');
        document.body.style.overflow = '';
    }, 500);
}

async function loadCategories() {
    try {
        const res = await fetch('/api/categories', { headers: { 'Accept': 'application/json' } });
        const json = await res.json();
        const cats = json.data || json || [];
        const sel = document.getElementById('cCategory');
        cats.forEach(c => {
            const opt = document.createElement('option');
            opt.value = c.id;
            opt.textContent = (c.name || c.category_name).toUpperCase();
            sel.appendChild(opt);
        });
    } catch(e) {}
}

async function loadOverview() {
    try {
        const res = await ApiClient.request('/my-campaigns');
        const list = res.data || res || [];
        renderRegistryList(list);
    } catch(e) {}
}

function renderRegistryList(list) {
    const el = document.getElementById('myCampaignsList');
    if (!list.length) {
        el.innerHTML = `<div class="py-32 text-center bg-white rounded-[3.5rem] border border-amber-500/5 shadow-xl"><p class="text-amber-900/10 font-black text-[12px] uppercase tracking-[0.8em] font-sans">Registry Stream Depleted.</p></div>`;
        return;
    }

    el.innerHTML = list.map(c => {
        const statusColor = c.status === 'active' ? 'text-emerald-700 border-emerald-200 bg-emerald-50' : 'text-slate-400 border-slate-100 bg-slate-50';
        const img = c.images && c.images[0] ? c.images[0].url : null;
        
        return `
        <div class="group bg-white p-12 rounded-2xl border-2 border-emerald-500/20 flex items-center gap-16 shadow-xl shadow-emerald-900/[0.02] transition-all duration-700 hover:shadow-2xl hover:border-emerald-500/40 font-sans">
            <div class="w-24 h-24 rounded-xl bg-slate-50 overflow-hidden flex-shrink-0 border-2 border-emerald-500/20 ring-[0.5rem] ring-transparent transition-all">
                ${img ? `<img src="${img}" class="w-full h-full object-cover">` : `<div class="w-full h-full flex items-center justify-center text-slate-200"><svg class="h-10 w-10" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14"/></svg></div>`}
            </div>
            <div class="flex-grow min-w-0 space-y-4">
                <div class="flex items-center gap-6">
                    <span class="text-[11px] font-black uppercase tracking-[0.3em] ${statusColor} px-6 py-2.5 rounded-lg border-2 border-emerald-500/30">${c.status}.</span>
                    <span class="text-[12px] text-black/30 font-black uppercase tracking-[0.4em] font-sans italic opacity-60">${new Date(c.created_at).toLocaleDateString()}</span>
                </div>
                <h3 class="text-5xl font-black text-black tracking-tighter truncate leading-none">${escHtml(c.title)}</h3>
            </div>
            <div class="flex items-center gap-20 flex-shrink-0">
                <div class="flex flex-col items-end">
                    <span class="text-7xl font-black text-black tracking-tighter tabular-nums">${Number(c.current_amount||0).toLocaleString()} <span class="text-[14px] text-emerald-600 uppercase tracking-[0.5em] mb-3 ml-2">MAD</span></span>
                </div>
                <a href="/campaigns/${c.id}" class="px-12 py-6 rounded-lg bg-black text-[11px] font-black text-white hover:bg-zinc-800 uppercase tracking-[0.6em] transition-all border-none shadow-xl">
                    INTERFACE
                </a>
            </div>
        </div>`;
    }).join('');
}

const imageInput = document.getElementById('cImages');
const gallery    = document.getElementById('galleryPreview');
const dropText   = document.getElementById('dropText');

imageInput.addEventListener('change', () => {
    gallery.innerHTML = '';
    const file = imageInput.files[0];
    if (file) {
        dropText.textContent = `ASSET READY.`;
        dropText.className = "text-[11px] font-black text-emerald-600 uppercase tracking-[0.5em] text-center px-6";
        const reader = new FileReader();
        reader.onload = e => {
            gallery.innerHTML = `<img src="${e.target.result}" class="w-full h-full object-cover">`;
        };
        reader.readAsDataURL(file);
    } else {
        dropText.textContent = 'Deploy Asset (+)';
        dropText.className = "text-[11px] font-black text-amber-900/20 uppercase tracking-[0.5em] text-center px-6";
        gallery.innerHTML = `<span class="text-[10px] font-black text-amber-900/10 uppercase tracking-[0.4em]">Asset Buffer Empty</span>`;
    }
});

function showToast(msg) {
    const t = document.createElement('div');
    t.className = 'fixed bottom-16 left-1/2 -translate-x-1/2 z-[200] bg-black text-white px-16 py-6 rounded-[2rem] text-[11px] font-black uppercase tracking-[0.5em] shadow-3xl flex items-center gap-8 transition-all duration-700 opacity-0 translate-y-12 border-2 border-white/10';
    t.innerHTML = `<div class="w-3.5 h-3.5 rounded-full bg-emerald-300 animate-pulse"></div><span class="font-sans">${msg}</span>`;
    document.body.appendChild(t);
    setTimeout(() => {
        t.classList.replace('opacity-0', 'opacity-100');
        t.classList.replace('translate-y-12', 'translate-y-0');
    }, 10);
    setTimeout(() => {
        t.classList.replace('opacity-100', 'opacity-0');
        t.classList.replace('translate-y-0', 'translate-y-12');
        setTimeout(() => t.remove(), 700);
    }, 4000);
}

document.getElementById('createCampaignForm').addEventListener('submit', async (e) => {
    e.preventDefault();
    const btn = document.getElementById('submitBtn');
    const fd = new FormData();
    
    fd.append('title', document.getElementById('cTitle').value.trim());
    fd.append('description', document.getElementById('cDesc').value.trim());
    fd.append('category_id', document.getElementById('cCategory').value);
    fd.append('target_amount', document.getElementById('cTarget').value);
    fd.append('start_date', document.getElementById('cStartDate').value);
    fd.append('end_date', document.getElementById('cEndDate').value);
    
    const file = imageInput.files[0];
    if (file) { fd.append('image', file); }

    if (!fd.get('title') || !fd.get('category_id')) { showToast('PROTOCOL INCOMPLETE.'); return; }

    btn.disabled = true; btn.textContent = 'EXECUTING...';

    try {
        await ApiClient.request('/campaigns', { method: 'POST', body: fd, headers: { 'Content-Type': null } });
        e.target.reset();
        gallery.innerHTML = '';
        dropText.textContent = 'Deploy Asset (+)';
        closeMissionModal();
        showToast('MISSION LOGGED TO REGISTRY.');
        await loadOverview();
    } catch(err) {
        showToast(err.message || 'TRANSMISSION FAILURE.');
        btn.disabled = false; btn.textContent = 'Confirm Mission';
    }
});

function escHtml(s) { const d = document.createElement('div'); d.appendChild(document.createTextNode(s||'')); return d.innerHTML; }
</script>
@endsection
