@extends('layouts.admin')

@section('title', 'Klien')
@section('header_title', 'Daftar Klien / Order')

@section('content')
<div class="bg-white rounded-3xl shadow-sm border border-slate-100 overflow-hidden">
    <div class="p-6 md:p-8 flex items-center justify-between border-b border-slate-100">
        <h2 class="text-xl font-bold text-slate-800">Semua Klien Aktif</h2>
        <div class="relative">
            <i data-lucide="search" class="absolute left-3 top-1/2 -translate-y-1/2 w-4 h-4 text-slate-400"></i>
            <input type="text" placeholder="Cari klien..." class="pl-10 pr-4 py-2 border border-slate-200 rounded-lg text-sm focus:ring-2 focus:ring-blue-500 outline-none w-64 bg-slate-50">
        </div>
    </div>
    <div class="overflow-x-auto">
        <table class="w-full text-left border-collapse">
            <thead class="bg-slate-50">
                <tr>
                    <th class="p-4 pl-8 font-semibold text-slate-500 text-sm uppercase tracking-wider">Info Klien</th>
                    <th class="p-4 font-semibold text-slate-500 text-sm uppercase tracking-wider">Template</th>
                    <th class="p-4 font-semibold text-slate-500 text-sm uppercase tracking-wider">URL Publik</th>
                    <th class="p-4 font-semibold text-slate-500 text-sm uppercase tracking-wider text-right pr-8">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-100">
                @forelse($invitations as $inv)
                    <tr class="hover:bg-blue-50/50 transition-colors group">
                        <td class="p-4 pl-8">
                            <div class="flex items-center">
                                <div class="w-10 h-10 rounded-full bg-indigo-100 text-indigo-600 font-bold flex items-center justify-center mr-3">
                                    {{ substr($inv->customer_name, 0, 1) }}
                                </div>
                                <div>
                                    <p class="font-bold text-slate-800">{{ $inv->customer_name }}</p>
                                    <p class="text-xs text-slate-500 flex items-center mt-1">
                                        <i data-lucide="calendar" class="w-3 h-3 mr-1"></i> {{ $inv->created_at->format('d M Y') }}
                                    </p>
                                </div>
                            </div>
                        </td>
                        <td class="p-4">
                            <form action="{{ route('admin.updateTheme', $inv->id) }}" method="POST" class="flex gap-2 items-center">
                                @csrf
                                @method('PUT')
                                <select name="template_id" onchange="this.form.submit()" class="border border-slate-200 rounded-lg px-2 py-1 text-xs font-semibold bg-slate-50 focus:bg-white focus:ring-2 focus:ring-blue-500 outline-none text-slate-700 cursor-pointer hover:bg-slate-100 transition">
                                    <option value="ar019" {{ $inv->template_id == 'ar019' ? 'selected' : '' }}>AR-019 (Luxury)</option>
                                    <option value="luxury10" {{ $inv->template_id == 'luxury10' ? 'selected' : '' }}>Luxury 10 (Minimalist Dark)</option>
                                </select>
                            </form>
                        </td>
                        <td class="p-4">
                            <a href="{{ route('invitation.show', $inv->slug) }}" target="_blank" class="text-blue-600 hover:text-blue-800 font-medium text-sm flex items-center group-hover:underline">
                                /invite/{{ $inv->slug }} <i data-lucide="external-link" class="w-3 h-3 ml-1"></i>
                            </a>
                        </td>
                        <td class="p-4 pr-8 text-right space-x-2">
                            <a href="{{ route('dashboard.show', $inv->access_token) }}" target="_blank" class="inline-flex items-center justify-center px-4 py-2 border border-emerald-200 bg-emerald-50 text-emerald-700 font-medium text-xs rounded-lg hover:bg-emerald-600 hover:text-white transition-all shadow-sm">
                                <i data-lucide="unplug" class="w-3 h-3 mr-1"></i> Dashboard Klien
                            </a>
                            <button class="inline-flex items-center justify-center p-2 border border-red-200 bg-red-50 text-red-600 rounded-lg hover:bg-red-600 hover:text-white transition-all shadow-sm" title="Hapus Klien">
                                <i data-lucide="trash-2" class="w-4 h-4"></i>
                            </button>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4" class="p-12 text-center text-slate-400">
                            <div class="flex flex-col items-center">
                                <i data-lucide="folder-open" class="w-12 h-12 text-slate-200 mb-3"></i>
                                <p class="text-slate-500 mb-1">Belum ada klien terdaftar.</p>
                                <a href="{{ route('admin.index') }}" class="text-sm border border-slate-300 rounded-lg px-4 py-2 mt-2 hover:bg-slate-50 text-slate-700">Buat Undangan Baru</a>
                            </div>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
