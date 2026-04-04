@extends('layouts.admin')

@section('title', 'Pengaturan')
@section('header_title', 'Konfigurasi Sistem')

@section('content')
<div class="max-w-3xl">
    <div class="bg-white rounded-3xl shadow-sm border border-slate-100 p-8 md:p-10 mb-8">
        <div class="flex items-center mb-6">
            <div class="w-12 h-12 rounded-xl bg-slate-100 flex items-center justify-center text-slate-600 mr-5">
                <i data-lucide="building-2" class="w-6 h-6"></i>
            </div>
            <div>
                <h2 class="text-2xl font-bold text-slate-800">Profil Bisnis</h2>
                <p class="text-slate-500 text-sm">Informasi utama untuk nama di dashboard.</p>
            </div>
        </div>

        <form class="space-y-6">
            <div>
                <label class="block text-sm font-semibold text-slate-700 mb-2">Nama Platform / Bisnis</label>
                <input type="text" value="DreamWedding" class="w-full border border-slate-200 rounded-xl px-4 py-3 bg-slate-50 focus:bg-white focus:ring-2 focus:ring-blue-500 outline-none transition-all">
            </div>
            <div>
                <label class="block text-sm font-semibold text-slate-700 mb-2">Email Kontak Support</label>
                <input type="email" value="support@dreamwedding.test" class="w-full border border-slate-200 rounded-xl px-4 py-3 bg-slate-50 focus:bg-white focus:ring-2 focus:ring-blue-500 outline-none transition-all">
            </div>
            
            <button type="button" class="bg-blue-600 text-white font-semibold py-3 px-8 rounded-xl shadow-lg hover:-translate-y-1 transition duration-300">
                Simpan Profil
            </button>
        </form>
    </div>

    <!-- Security Panel -->
    <div class="bg-white rounded-3xl shadow-sm border border-slate-100 p-8 md:p-10 border-l-4 border-l-amber-500">
        <div class="flex items-center justify-between mb-4">
            <div class="flex items-center">
                <i data-lucide="shield-check" class="text-amber-500 w-6 h-6 mr-3"></i>
                <h3 class="font-bold text-lg text-slate-800">Keamanan Magic Link</h3>
            </div>
            <span class="px-3 py-1 bg-amber-50 text-amber-600 rounded-full text-xs font-bold uppercase tracking-widest">Aktif</span>
        </div>
        <p class="text-slate-600 text-sm leading-relaxed">
            Sistem Anda menggunakan Magic Link Token sepanjang 40 karakter unik untuk pelindungan akses langsung klien ke formulir. Akses langsung klien aman dan tidak dapat ditebak.
        </p>
    </div>
</div>
@endsection
