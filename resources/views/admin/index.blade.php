@extends('layouts.admin')

@section('title', 'Overview')
@section('header_title', 'Overview Klien')

@section('content')
<!-- Welcome Info -->
<div>
    <h1 class="text-3xl font-bold tracking-tight text-slate-900 mb-2">Halo, Admin 👋</h1>
    <p class="text-slate-500">Kelola pendaftaran akun pelanggan dan lihat seluruh pesanan undangan di platform ini.</p>
</div>

<!-- Stats -->
<div class="grid grid-cols-1 md:grid-cols-3 gap-6">
    <div class="bg-white p-6 rounded-2xl shadow-sm border border-slate-100 flex items-center hover:shadow-lg transition-shadow duration-300">
        <div class="w-14 h-14 rounded-xl bg-blue-50 text-blue-600 flex items-center justify-center mr-4">
            <i data-lucide="users" class="w-7 h-7"></i>
        </div>
        <div>
            <p class="text-sm font-medium text-slate-500">Total Klien</p>
            <h3 class="text-2xl font-bold text-slate-900">{{ $invitations->count() }}</h3>
        </div>
    </div>
    <div class="bg-white p-6 rounded-2xl shadow-sm border border-slate-100 flex items-center hover:shadow-lg transition-shadow duration-300">
        <div class="w-14 h-14 rounded-xl bg-emerald-50 text-emerald-600 flex items-center justify-center mr-4">
            <i data-lucide="check-circle-2" class="w-7 h-7"></i>
        </div>
        <div>
            <p class="text-sm font-medium text-slate-500">Undangan Aktif</p>
            <h3 class="text-2xl font-bold text-slate-900">{{ $invitations->count() }}</h3>
        </div>
    </div>
    <div class="bg-white p-6 rounded-2xl shadow-sm border border-slate-100 flex items-center hover:shadow-lg transition-shadow duration-300">
        <div class="w-14 h-14 rounded-xl bg-amber-50 text-amber-600 flex items-center justify-center mr-4">
            <i data-lucide="layout-template" class="w-7 h-7"></i>
        </div>
        <div>
            <p class="text-sm font-medium text-slate-500">Template Tersedia</p>
            <h3 class="text-2xl font-bold text-slate-900">1</h3>
        </div>
    </div>
</div>

<!-- Form Pendaftaran -->
<div class="bg-white rounded-3xl shadow-sm border border-slate-100 overflow-hidden relative mt-8">
    <div class="absolute top-0 right-0 w-64 h-64 bg-blue-50/50 rounded-bl-full pointer-events-none -z-0"></div>
    <div class="p-8 relative z-10">
        <div class="flex items-center mb-6">
            <div class="10 h-10 w-10 flex items-center justify-center rounded-lg bg-blue-100 text-blue-600 mr-4">
                <i data-lucide="user-plus" class="w-5 h-5"></i>
            </div>
            <h2 class="text-2xl font-bold text-slate-800">Registrasi Klien Baru</h2>
        </div>
        <form action="{{ route('admin.store') }}" method="POST">
            @csrf
            <div class="grid grid-cols-1 lg:grid-cols-5 gap-6 mb-8">
                <div class="lg:col-span-2">
                    <label class="block text-sm font-semibold text-slate-700 mb-2">Nama Klien / Instansi</label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <i data-lucide="user" class="h-4 w-4 text-slate-400"></i>
                        </div>
                        <input type="text" name="customer_name" required placeholder="mis. Budi & Aini" class="w-full border border-slate-200 rounded-xl pl-10 pr-4 py-3 bg-slate-50 focus:bg-white focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none transition-all">
                    </div>
                </div>
                <div class="lg:col-span-2">
                    <label class="block text-sm font-semibold text-slate-700 mb-2">Slug URL Undangan</label>
                    <div class="relative flex items-center">
                        <div class="px-4 py-3 bg-slate-100 border border-r-0 border-slate-200 rounded-l-xl text-slate-500 text-sm whitespace-nowrap">
                            /invite/
                        </div>
                        <input type="text" name="slug" required placeholder="budi-aini" class="w-full border border-slate-200 rounded-r-xl px-4 py-3 bg-slate-50 focus:bg-white focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none transition-all">
                    </div>
                </div>
                <div class="lg:col-span-1">
                    <label class="block text-sm font-semibold text-slate-700 mb-2">Tema Acara</label>
                    <select name="template_id" class="w-full border border-slate-200 rounded-xl px-4 py-3 bg-slate-50 focus:bg-white focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none transition-all cursor-pointer">
                        <option value="ar019">AR-019 (Luxury)</option>
                        <option value="luxury10">Luxury 10 (Minimalist Dark)</option>
                    </select>
                </div>
            </div>
            
            <div class="flex justify-end border-t border-slate-100 pt-6">
                <button type="submit" class="bg-slate-900 text-white font-bold tracking-wide flex items-center px-8 py-3.5 rounded-xl hover:bg-blue-600 transition-all duration-300 shadow-xl hover:shadow-blue-500/30 hover:-translate-y-1">
                    <i data-lucide="zap" class="w-4 h-4 mr-2"></i>
                    Buat Dashboard & Link Undangan Klien
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
