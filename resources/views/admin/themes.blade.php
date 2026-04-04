@extends('layouts.admin')

@section('title', 'Tema & Template')
@section('header_title', 'Tema / Template')

@section('content')
<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
    
    <!-- Theme Card -->
    <div class="bg-white rounded-3xl shadow-sm border border-slate-100 overflow-hidden hover:shadow-xl transition-shadow duration-300 group">
        <div class="aspect-[3/4] bg-slate-100 relative overflow-hidden">
            <div class="absolute inset-0 bg-gradient-to-t from-slate-900/60 to-transparent z-10"></div>
            <img src="https://images.unsplash.com/photo-1541250848049-b4f7146120ef?auto=format&fit=crop&q=80&w=600" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-700">
            <div class="absolute bottom-4 left-4 z-20">
                <span class="bg-blue-600 text-white text-[10px] font-bold uppercase tracking-widest px-3 py-1 rounded-full mb-2 inline-block">Best Seller</span>
                <h3 class="text-white font-bold text-xl">Luxury Art Forest</h3>
            </div>
        </div>
        <div class="p-6">
            <div class="flex justify-between items-center mb-4">
                <p class="text-xs font-semibold text-slate-500 uppercase tracking-widest">ID: AR019</p>
                <div class="flex px-2 py-1 bg-emerald-50 text-emerald-600 rounded text-xs font-bold items-center"><i data-lucide="check" class="w-3 h-3 mr-1"></i> Aktif</div>
            </div>
            <p class="text-slate-600 text-sm mb-6 leading-relaxed">Template elegan bernuansa hutan artistik dengan efek slide animasi dan pemutar musik bawaan.</p>
            <a href="{{ route('invitation.demo', 'ar019') }}" target="_blank" class="w-full py-2.5 border border-slate-200 rounded-xl text-slate-700 font-semibold hover:bg-slate-50 transition flex justify-center items-center text-sm">
                <i data-lucide="eye" class="w-4 h-4 mr-2"></i> Preview Template
            </a>
        </div>
    </div>

    <!-- Theme Card: Luxury 10 Minimalist -->
    <div class="bg-white rounded-3xl shadow-sm border border-slate-100 overflow-hidden hover:shadow-xl transition-shadow duration-300 group">
        <div class="aspect-[3/4] bg-slate-100 relative overflow-hidden">
            <div class="absolute inset-0 bg-gradient-to-t from-slate-900/60 to-transparent z-10"></div>
            <img src="https://inv.nikustory.com/wp-content/uploads/2026/02/TEMA-LUXURY-10-FOTO.jpg" onerror="this.src='https://images.unsplash.com/photo-1519225421980-715cb0215aed?ixlib=rb-4.0.3&auto=format&fit=crop&w=600&q=80'" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-700">
            <div class="absolute bottom-4 left-4 z-20">
                <span class="bg-amber-500 text-white text-[10px] font-bold uppercase tracking-widest px-3 py-1 rounded-full mb-2 inline-block">New Arrival</span>
                <h3 class="text-white font-bold text-xl">Minimalist Dark</h3>
            </div>
        </div>
        <div class="p-6">
            <div class="flex justify-between items-center mb-4">
                <p class="text-xs font-semibold text-slate-500 uppercase tracking-widest">ID: LUXURY10</p>
                <div class="flex px-2 py-1 bg-emerald-50 text-emerald-600 rounded text-xs font-bold items-center"><i data-lucide="check" class="w-3 h-3 mr-1"></i> Aktif</div>
            </div>
            <p class="text-slate-600 text-sm mb-6 leading-relaxed">Tema elegan bernuansa hitam & emas minimalis dengan efek hujan bintang yang mewah.</p>
            <a href="{{ route('invitation.demo', 'luxury10') }}" target="_blank" class="w-full py-2.5 border border-slate-200 rounded-xl text-slate-700 font-semibold hover:bg-slate-50 transition flex justify-center items-center text-sm">
                <i data-lucide="eye" class="w-4 h-4 mr-2"></i> Preview Template
            </a>
        </div>
    </div>

    <!-- Add New Theme Card Placeholder -->
    <div class="border-2 border-dashed border-slate-200 rounded-3xl flex flex-col items-center justify-center p-8 bg-slate-50/50 hover:bg-white transition-colors cursor-pointer group min-h-[400px]">
        <div class="w-16 h-16 rounded-full bg-blue-50 flex items-center justify-center text-blue-500 mb-4 group-hover:scale-110 transition-transform shadow-sm">
            <i data-lucide="plus" class="w-8 h-8"></i>
        </div>
        <h3 class="text-lg font-bold text-slate-800 mb-1">Tambah Tema Baru</h3>
        <p class="text-sm text-slate-500 text-center">Buat dan upload template blade baru untuk klien Anda.</p>
    </div>

</div>
@endsection
