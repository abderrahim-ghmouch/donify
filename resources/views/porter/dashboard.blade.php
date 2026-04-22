@extends('layouts.app')

@section('content')

{{-- Porter Command Dashboard (Ultra-Premium Glass Modal) --}}
<div class="min-h-screen bg-[#fbf8f6] font-quicksand relative overflow-hidden flex flex-col">
    
    {{-- Classic Linear Gradient: Bottom to Top --}}
    <div class="absolute inset-0 bg-gradient-to-t from-[#064e3b]/15 via-transparent to-transparent pointer-events-none z-0"></div>

    {{-- Hero Section --}}
    <section class="relative pt-40 pb-16 px-8 z-10 text-center">
        <div class="max-w-7xl mx-auto flex flex-col items-center animate-show">
            <h1 class="text-6xl md:text-8xl font-black text-[#1A1A1A] leading-tight mb-4 tracking-tighter">
                Campaign Dashboard.
            </h1>
            <h2 class="text-2xl font-bold text-[#996515] tracking-tight mb-16">
                Welcome, <span id="heroName" class="text-[#1A1A1A]">Porter</span>.
            </h2>
            
            <button onclick="openMissionModal()" class="px-14 py-6 bg-[#1A1A1A] text-white rounded-xl text-[10px] font-black uppercase tracking-[0.4em] hover:bg-black transition-all shadow-[0_20px_50px_rgba(0,0,0,0.2)] active:scale-95 transform">
                + Spread Hope.
            </button>
        </div>
    </section>

    {{-- Main Workspace --}}
    <section class="relative z-10 px-8 pb-32">
        <div class="max-w-6xl mx-auto">
            <div class="border-b-2 border-black/5 pb-8 mb-10 flex items-center justify-between">
                <h3 class="text-xs font-black text-[#1A1A1A] uppercase tracking-[0.4em]">Campaign Registry.</h3>
            </div>
            <div class="flex flex-col gap-5" id="myCampaignsList">
                {{-- Skeleton List --}}
                @for($i=0;$i<4;$i++)
                <div class="bg-white h-28 rounded-xl border border-black/5 animate-pulse shadow-sm"></div>
                @endfor
            </div>
        </div>
    </section>

    {{-- Premium Modern Modal: Unified Production Console --}}
    <div id="missionModal" class="fixed inset-0 z-[100] hidden opacity-0 transition-opacity duration-500 flex items-center justify-center p-4">
        {{-- High-Intensity Backdrop Blur --}}
        <div class="absolute inset-0 bg-[#064e3b]/10 backdrop-blur-xl transition-all" onclick="closeMissionModal()"></div>
        
        {{-- Refined Support Console: Expanded to 4xl for breathing room --}}
        <div class="relative w-full max-w-4xl bg-[#fdfdfd]/98 backdrop-blur-3xl rounded-xl border border-black/5 shadow-[0_40px_100px_-20px_rgba(0,0,0,0.15)] transform transition-all duration-500 translate-y-10 scale-95 opacity-0 overflow-hidden font-quicksand" id="modalContainer">
            
            {{-- Modular Header: Softer look --}}
            <div class="relative flex flex-col items-center p-8 border-b border-black/5 bg-white text-center">
                <img src="{{ asset('images/donifylg.png') }}" alt="Donify Logo" class="h-10 w-auto mb-4 opacity-80">
                <h5 class="text-3xl font-bold text-[#1A1A1A] tracking-tight">Spread a Little Joy Today.</h5>
                <p class="text-xs font-semibold text-[#996515] uppercase tracking-[0.3em] mt-2">Together, let's make a difference</p>
                
                <button onclick="closeMissionModal()" class="absolute top-8 right-8 w-10 h-10 rounded-xl hover:bg-black/5 flex items-center justify-center transition-all group">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-300 group-hover:text-black transition-colors" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M6 18L18 6M6 6l12 12"/></svg>
                </button>
            </div>

            {{-- Split Form Body to Break White Space --}}
            <div class="p-0 max-h-[80vh] overflow-y-auto">
                <form id="createCampaignForm" class="grid grid-cols-1 md:grid-cols-12">
                    
                    {{-- Left Column: Core Narrative --}}
                    <div class="md:col-span-12 lg:col-span-7 p-10 space-y-7 bg-white">
                        <div class="space-y-2 text-label">
                            <label class="text-xs font-bold text-[#996515] uppercase tracking-widest pl-1">Mission Title</label>
                            <input type="text" id="cTitle" placeholder="Give your mission a name..."
                                class="w-full bg-white border border-black/10 rounded-xl outline-none py-4 px-6 text-lg font-medium text-[#1A1A1A] focus:border-[#996515] focus:shadow-[0_10px_30px_rgba(153,101,21,0.08)] transition-all">
                        </div>

                        <div class="space-y-2 text-label">
                            <label class="text-xs font-bold text-[#996515] uppercase tracking-widest pl-1">Description</label>
                            <textarea id="cDesc" placeholder="Tell the story of how you'll help..."
                                class="w-full bg-white border border-black/10 rounded-xl outline-none py-4 px-6 text-base font-medium text-[#1A1A1A] focus:border-[#996515] focus:shadow-[0_10px_30px_rgba(153,101,21,0.08)] transition-all h-48 resize-none leading-relaxed"></textarea>
                        </div>
                    </div>

                    {{-- Right Column: Setup (Breaking white space with neutral tint) --}}
                    <div class="md:col-span-12 lg:col-span-5 p-10 space-y-7 bg-[#fbf8f6] border-l border-black/5">
                        <div class="space-y-2 text-label">
                            <label class="text-xs font-bold text-[#996515] uppercase tracking-widest pl-1">Select Sector</label>
                            <select id="cCategory" class="w-full bg-white border border-black/10 rounded-xl outline-none py-4 px-6 text-sm font-bold text-[#1A1A1A] focus:border-[#996515] transition-all cursor-pointer">
                                <option value="">SELECT CATEGORY</option>
                            </select>
                        </div>
                        
                        <div class="space-y-2 text-label">
                            <label class="text-xs font-bold text-[#996515] uppercase tracking-widest pl-1">Target Amount (MAD)</label>
                            <input type="number" id="cTarget" placeholder="Amount needed"
                                class="w-full bg-white border border-black/10 rounded-xl outline-none py-4 px-6 text-lg font-bold text-[#1A1A1A] focus:border-[#996515] transition-all">
                        </div>

                        <div class="grid grid-cols-2 gap-4">
                            <div class="space-y-2 text-label">
                                <label class="text-xs font-bold text-[#996515] uppercase tracking-widest pl-1">Start Date</label>
                                <input type="date" id="cStartDate" 
                                    class="w-full bg-white border border-black/10 rounded-xl outline-none py-4 px-4 text-xs font-medium text-[#1A1A1A] focus:border-[#996515] transition-all">
                            </div>
                            <div class="space-y-2 text-label">
                                <label class="text-xs font-bold text-[#996515] uppercase tracking-widest pl-1">End Date</label>
                                <input type="date" id="cEndDate" 
                                    class="w-full bg-white border border-black/10 rounded-xl outline-none py-4 px-4 text-xs font-medium text-[#1A1A1A] focus:border-[#996515] transition-all">
                            </div>
                        </div>

                        <div class="space-y-2">
                            <label class="text-xs font-bold text-[#996515] uppercase tracking-widest pl-1">Cover Image</label>
                            <label class="block relative cursor-pointer group">
                                <input type="file" id="cImages" class="absolute inset-0 opacity-0 z-10" accept="image/*">
                                <div class="w-full py-5 border-2 border-dashed border-black/10 rounded-xl flex flex-col items-center justify-center transition-all group-hover:border-[#996515] bg-white hover:bg-gray-50">
                                    <p id="dropText" class="text-[10px] font-bold text-gray-400 uppercase tracking-widest group-hover:text-[#996515]">Choose a photo (+)</p>
                                </div>
                            </label>
                        </div>
                    </div>

                    {{-- Footer --}}
                    <div class="md:col-span-12 p-10 bg-white border-t border-black/5 flex flex-col items-center gap-8">
                        <div id="galleryPreview" class="h-28 w-28 rounded-xl bg-[#fdfdfd] border border-black/5 overflow-hidden shadow-sm flex items-center justify-center group relative cursor-pointer" onclick="document.getElementById('cImages').click()">
                            <span class="text-[8px] font-bold text-gray-300 uppercase tracking-widest text-center">Preview Area</span>
                        </div>

                        <button type="submit" id="submitBtn" class="px-20 py-6 bg-[#1A1A1A] text-white rounded-xl text-xs font-bold uppercase tracking-[0.4em] hover:bg-black transition-all shadow-xl active:scale-95 transform">
                            Confirm Mission.
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<style>
    /* Hide Spinners */
    input[type=number]::-webkit-inner-spin-button, input[type=number]::-webkit-outer-spin-button { -webkit-appearance: none; margin: 0; }
    input[type=number] { -moz-appearance: textfield; }

    .mission-row { background: #ffffff; transition: all 0.4s ease; }
    .mission-row:hover { transform: translateY(-4px); box-shadow: 0 15px 40px rgba(0,0,0,0.05); }

    /* Modal Super-Transitions */
    #missionModal.visible { display: flex; opacity: 1; }
    #missionModal.visible #modalContainer { 
        transform: translateY(0) scale(1); 
        opacity: 1; 
    }

    .animate-show { animation: show 0.8s cubic-bezier(0.16, 1, 0.3, 1) both; }
    @keyframes show { from { opacity:0; transform: translateY(20px); } to { opacity:1; transform: translateY(0); } }
    
    .text-label label { display: block; }
    .scrollbar-hide::-webkit-scrollbar { display: none; }
    .scrollbar-hide { -ms-overflow-style: none; scrollbar-width: none; }
</style>

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
    modal.classList.remove('hidden');
    setTimeout(() => {
        modal.classList.add('visible');
    }, 10);
    document.body.style.overflow = 'hidden';
}

function closeMissionModal() {
    const modal = document.getElementById('missionModal');
    modal.classList.remove('visible');
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
        el.innerHTML = `<div class="py-24 text-center bg-white rounded-2xl border border-black/5"><p class="text-gray-300 font-bold text-[10px] uppercase tracking-widest">Registry Neutral.</p></div>`;
        return;
    }

    el.innerHTML = list.map(c => {
        const pct = Math.min(100, ((c.current_amount||0)/Math.max(1,c.target_amount||1))*100).toFixed(0);
        const statusColor = c.status === 'active' ? 'text-emerald-500' : 'text-amber-500';
        const img = c.images && c.images[0] ? c.images[0].url : null;
        
        return `
        <div class="mission-row p-6 rounded-2xl border border-black/5 flex items-center gap-6 shadow-sm">
            <div class="w-14 h-14 rounded-xl bg-gray-50 overflow-hidden flex-shrink-0 border border-black/5">
                ${img ? `<img src="${img}" class="w-full h-full object-cover">` : `<div class="w-full h-full flex items-center justify-center text-gray-200"><svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14"/></svg></div>`}
            </div>
            <div class="flex-grow min-w-0">
                <div class="flex items-center gap-4 mb-1">
                    <span class="text-[8px] font-black uppercase tracking-widest ${statusColor} bg-current/5 px-2.5 py-1 rounded-md">${c.status}.</span>
                    <span class="text-[9px] text-gray-400 font-bold uppercase tracking-widest leading-none">${new Date(c.created_at).toLocaleDateString()}</span>
                </div>
                <h3 class="text-lg font-black text-[#1A1A1A] tracking-tighter truncate leading-none">${escHtml(c.title)}</h3>
            </div>
            <div class="flex items-center gap-8 flex-shrink-0">
                <div class="flex flex-col items-end">
                    <span class="text-2xl font-black text-[#1A1A1A] tracking-tighter">${Number(c.current_amount||0).toLocaleString()} <span class="text-[9px] text-[#059669]">MAD</span></span>
                </div>
                <a href="/campaigns/${c.id}" class="text-[9px] font-black text-[#1A1A1A] hover:text-[#059669] uppercase tracking-widest underline underline-offset-8 decoration-black/10 hover:decoration-current transition-all">Report</a>
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
        dropText.textContent = `IMAGE READY.`;
        const reader = new FileReader();
        reader.onload = e => {
            gallery.innerHTML = `<img src="${e.target.result}" class="w-full h-full object-cover">`;
        };
        reader.readAsDataURL(file);
    } else {
        dropText.textContent = 'GALLERY (+)';
        gallery.innerHTML = `<span class="text-[8px] font-black text-gray-200 uppercase tracking-widest">No Image</span>`;
    }
});

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

    if (!fd.get('title') || !fd.get('category_id')) { alert('Protocol incomplete.'); return; }

    btn.disabled = true; btn.textContent = 'TRANSMITTING...';

    try {
        await ApiClient.request('/campaigns', { method: 'POST', body: fd, headers: { 'Content-Type': null } });
        closeMissionModal();
        alert('MISSION DEPLOYED.');
        window.location.reload();
    } catch(err) {
        alert(err.message || 'Transmition failed.');
        btn.disabled = false; btn.textContent = 'Confirm.';
    }
});

function escHtml(s) { const d = document.createElement('div'); d.appendChild(document.createTextNode(s||'')); return d.innerHTML; }
</script>
@endsection
