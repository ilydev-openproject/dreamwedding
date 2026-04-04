<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>DreamWedding | @yield('title', 'Admin Dashboard')</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://unpkg.com/lucide@latest"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <style>
        body { font-family: 'Inter', sans-serif; }
        .glass-panel { background: rgba(255, 255, 255, 0.7); backdrop-filter: blur(16px); }
    </style>
</head>
<body class="bg-slate-50 text-slate-800 min-h-screen flex overflow-x-hidden" x-data="{ sidebarOpen: false }">

    <!-- Mobile Header -->
    <div class="md:hidden fixed top-0 left-0 right-0 h-16 bg-slate-900 z-30 flex items-center justify-between px-4">
        <div class="flex items-center">
            <i data-lucide="crown" class="text-amber-400 w-5 h-5 mr-2"></i>
            <span class="text-white font-bold tracking-wide">DreamWedding</span>
        </div>
        <button @click="sidebarOpen = !sidebarOpen" class="text-slate-300 hover:text-white">
            <i data-lucide="menu" class="w-6 h-6"></i>
        </button>
    </div>

    <!-- Sidebar Overlay for mobile -->
    <div x-show="sidebarOpen" x-transition.opacity class="fixed inset-0 bg-slate-900/50 z-40 md:hidden" @click="sidebarOpen = false" x-cloak></div>

    <!-- Sidebar -->
    <aside :class="sidebarOpen ? 'translate-x-0' : '-translate-x-full'" class="transform transition-transform duration-300 md:translate-x-0 fixed md:sticky top-0 left-0 w-64 bg-slate-900 text-slate-300 flex-shrink-0 flex flex-col shadow-2xl z-50 h-[100dvh]">
        <div class="h-16 md:h-20 flex items-center justify-between px-6 md:px-8 border-b border-slate-800">
            <i data-lucide="crown" class="text-amber-400 w-6 h-6 mr-3"></i>
            <span class="text-white font-bold text-lg tracking-wide">DreamWedding</span>
            <!-- Mobile close button -->
            <button @click="sidebarOpen = false" class="md:hidden text-slate-400 hover:text-white">
                <i data-lucide="x" class="w-5 h-5"></i>
            </button>
        </div>
        <nav class="flex-1 py-6 px-4 space-y-2 overflow-y-auto">
            <a href="{{ route('admin.index') }}" class="flex items-center px-4 py-3 rounded-xl transition font-medium {{ request()->routeIs('admin.index') ? 'bg-blue-600/10 text-blue-400' : 'hover:bg-slate-800 hover:text-white group' }}">
                <i data-lucide="layout-dashboard" class="w-5 h-5 mr-3 {{ request()->routeIs('admin.index') ? '' : 'group-hover:text-blue-400 transition-colors' }}"></i> Dashboard
            </a>
            <a href="{{ route('admin.clients') }}" class="flex items-center px-4 py-3 rounded-xl transition font-medium {{ request()->routeIs('admin.clients') ? 'bg-blue-600/10 text-blue-400' : 'hover:bg-slate-800 hover:text-white group' }}">
                <i data-lucide="users" class="w-5 h-5 mr-3 {{ request()->routeIs('admin.clients') ? '' : 'group-hover:text-blue-400 transition-colors' }}"></i> Klien
            </a>
            <a href="{{ route('admin.themes') }}" class="flex items-center px-4 py-3 rounded-xl transition font-medium {{ request()->routeIs('admin.themes') ? 'bg-blue-600/10 text-blue-400' : 'hover:bg-slate-800 hover:text-white group' }}">
                <i data-lucide="paint-bucket" class="w-5 h-5 mr-3 {{ request()->routeIs('admin.themes') ? '' : 'group-hover:text-blue-400 transition-colors' }}"></i> Tema / Template
            </a>
            <a href="{{ route('admin.settings') }}" class="flex items-center px-4 py-3 rounded-xl transition font-medium {{ request()->routeIs('admin.settings') ? 'bg-blue-600/10 text-blue-400' : 'hover:bg-slate-800 hover:text-white group' }}">
                <i data-lucide="settings" class="w-5 h-5 mr-3 {{ request()->routeIs('admin.settings') ? '' : 'group-hover:text-blue-400 transition-colors' }}"></i> Pengaturan
            </a>
        </nav>
        <div class="p-6 border-t border-slate-800">
            <div class="flex items-center">
                <div class="w-10 h-10 rounded-full bg-gradient-to-tr from-blue-500 to-purple-500 flex items-center justify-center text-white font-bold shadow-lg">AD</div>
                <div class="ml-3">
                    <p class="text-sm font-semibold text-white">Administrator</p>
                    <p class="text-xs text-slate-500">Super Admin</p>
                </div>
            </div>
        </div>
    </aside>

    <!-- Main Content -->
    <main class="flex-1 w-full min-w-0 flex flex-col pt-16 md:pt-0 min-h-screen">
        <!-- Header -->
        <header class="h-16 md:h-20 glass-panel border-b border-white/50 px-4 md:px-8 flex items-center justify-between sticky top-16 md:top-0 z-10 shadow-sm">
            <h2 class="text-xl font-semibold text-slate-800">@yield('header_title', 'Overview')</h2>
            <div class="flex items-center gap-4">
                <button class="w-10 h-10 rounded-full bg-white shadow-sm flex items-center justify-center text-slate-500 hover:text-blue-600 transition hover:shadow-md">
                    <i data-lucide="bell" class="w-5 h-5"></i>
                </button>
            </div>
        </header>

        <div class="p-4 md:p-8 w-full max-w-7xl mx-auto space-y-8 flex-1">
            @if(session('success'))
                <div class="bg-emerald-50 border border-emerald-200 text-emerald-800 px-4 py-3 rounded-2xl shadow-sm flex items-start">
                    <i data-lucide="check-circle" class="w-5 h-5 mr-3 mt-0.5 flex-shrink-0 text-emerald-600"></i>
                    <span class="font-medium text-sm md:text-base">{!! session('success') !!}</span>
                </div>
            @endif

            @yield('content')
        </div>
    </main>
    
    <script>
        lucide.createIcons();
    </script>
</body>
</html>
