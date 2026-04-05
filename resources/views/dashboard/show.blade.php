<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Dashboard Klien - {{ $invitation->customer_name }}</title>
    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    <!-- Alpine.js -->
    <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <style>
        [x-cloak] { display: none !important; }
        
        /* Premium Liquid Fill Animation */
        .liquid-container {
            position: relative;
            width: 80px;
            height: 80px;
            border-radius: 50%;
            border: 4px solid #fff;
            overflow: hidden;
            background: #f3f4f6;
            box-shadow: 0 0 20px rgba(0,0,0,0.1);
        }
        .liquid-wave {
            position: absolute;
            top: 100%;
            left: -50%;
            width: 200%;
            height: 200%;
            background: linear-gradient(180deg, #3b82f6 0%, #2563eb 100%);
            border-radius: 40%;
            animation: rotate_wave 4s linear infinite;
            transition: top 3s ease-out;
        }
        .liquid-filling .liquid-wave {
            top: 10%;
        }
        @keyframes rotate_wave {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
        }
        .animate-bounce-in {
            animation: bounceIn 0.5s cubic-bezier(0.68, -0.55, 0.265, 1.55);
        }
        @keyframes bounceIn {
            0% { opacity: 0; transform: scale(0.3); }
            50% { opacity: 1; transform: scale(1.05); }
            70% { transform: scale(0.9); }
            100% { transform: scale(1); }
        }
    </style>
</head>
<script>
    function dashboardData() {
        return {
            activeTab: 'profile',
            showPreview: false,
            isSidebarOpen: false,
            inviteUrl: "{{ route('invitation.show', $invitation->slug) }}",
            guests: @json($invitation->content['guests'] ?? []),
            cover_image: "{{ $invitation->content['cover_image'] ?? '' }}",
            groom_image: @json($invitation->content['groom']['image'] ?? ''),
            bride_image: '{{ $invitation->content['bride']['image'] ?? '' }}',
            og_image: '{{ $invitation->content['og_image'] ?? '' }}',
            hero_images: @json($invitation->content['hero_images'] ?? []),
            gallery_images: @json($invitation->content['gallery'] ?? []),
            
            heroPreviews: [],
            galleryPreviews: [],
            coverPreview: null,
            groomPreview: null,
            bridePreview: null,
            ogPreview: null,
            isUploading: false,
            
            newName: '',
            newPhone: '',
            search: '',
            init() {
                if (window.location.hash) {
                    this.activeTab = window.location.hash.slice(1);
                }
            },
            handleFile(event, type) {
                const files = event.target.files;
                if (!files.length) return;
                
                if (type === 'cover') this.coverPreview = URL.createObjectURL(files[0]);
                if (type === 'groom') this.groomPreview = URL.createObjectURL(files[0]);
                if (type === 'bride') this.bridePreview = URL.createObjectURL(files[0]);
                if (type === 'og') this.ogPreview = URL.createObjectURL(files[0]);
                
                if (type === 'hero' || type === 'gallery') {
                    const previews = [];
                    for (let i = 0; i < files.length; i++) {
                        previews.push(URL.createObjectURL(files[i]));
                    }
                    if(type === 'hero') this.heroPreviews = previews;
                    if(type === 'gallery') this.galleryPreviews = previews;
                }
            },
            removeHero(index) {
                this.hero_images.splice(index, 1);
            },
            removeGallery(index) {
                this.gallery_images.splice(index, 1);
            },
            addGuest() {
                if (this.newName.trim() === '') return;
                this.guests.push({ name: this.newName, phone: this.newPhone });
                this.newName = '';
                this.newPhone = '';
            },
            removeGuest(index) {
                this.guests.splice(index, 1);
            },
            removeHero(index) {
                this.hero_images.splice(index, 1);
            sendWA(guest) {
                const guestUrl = `${this.inviteUrl}?to=${encodeURIComponent(guest.name)}`;
                const bride = @json($invitation->content['bride']['name'] ?? 'Bride');
                const groom = @json($invitation->content['groom']['name'] ?? 'Groom');
                
                // Jurus Pamungkas: Pisahkan part yang bermasalah dalam kode HEX URL murni
                const subject = '%F0%9F%93%A9%20UNDANGAN%20PERNIKAHAN%20%F0%9F%93%A9';
                
                const messageBody = `*Kepada Yth.*
*Bapak/Ibu/Saudara/i*
*${guest.name}*

Assalamualaikum Warahmatullahi Wabarakatuh

Dengan memohon rahmat dan ridho Allah SWT, perkenankan kami mengundang Bapak/Ibu/Saudara/i untuk menghadiri acara pernikahan kami.

Untuk informasi detail mengenai acara, silahkan kunjungi link :
${guestUrl}

Merupakan suatu kebahagiaan bagi kami apabila Bapak/Ibu/Saudara/i berkenan hadir dan memberikan doa restu kepada kami.

Wassalamualaikum Warahmatullahi Wabarakatuh

Terima Kasih.

*Kami yang berbahagia,*
*${groom} & ${bride}*`;

                const textOutput = subject + '%0A%0A' + encodeURIComponent(messageBody);
                
                let waLink = `https://wa.me/?text=${textOutput}`;
                if (guest.phone) {
                    const cleanPhone = guest.phone.replace(/\D/g, '');
                    const finalPhone = cleanPhone.startsWith('0') ? '62' + cleanPhone.slice(1) : cleanPhone;
                    waLink = `https://wa.me/${finalPhone}?text=${textOutput}`;
                }
                
                window.open(waLink, '_blank');
            }
        }
    }
</script>

<style>
    [x-cloak] { display: none !important; }
</style>

<body class="bg-gray-50 text-gray-800 font-sans h-screen overflow-hidden" 
      x-data="dashboardData()" 
      x-init="init()" 
      @hashchange.window="activeTab = window.location.hash.slice(1) || 'profile'">
    
    <div class="flex h-full w-full relative">
        <!-- Mobile Sidebar Overlay -->
        <div x-show="isSidebarOpen" 
             x-transition:enter="transition ease-out duration-300"
             x-transition:enter-start="opacity-0"
             x-transition:enter-end="opacity-100"
             x-transition:leave="transition ease-in duration-200"
             x-transition:leave-start="opacity-100"
             x-transition:leave-end="opacity-0"
             @click="isSidebarOpen = false"
             class="fixed inset-0 bg-black/40 backdrop-blur-sm z-[110] lg:hidden"></div>

        <!-- Sidebar Navigation -->
        <aside :class="isSidebarOpen ? 'translate-x-0' : '-translate-x-full lg:translate-x-0'"
               class="fixed top-0 left-0 w-72 h-full bg-white/90 backdrop-blur-xl border-r border-gray-100 z-[120] lg:relative lg:w-64 lg:z-10 transition-transform duration-300 ease-in-out flex flex-col shadow-2xl lg:shadow-none">
            
            <div class="p-8 border-b border-gray-50 flex flex-col gap-1">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 bg-indigo-600 rounded-xl flex items-center justify-center text-white shadow-lg shadow-indigo-100">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                    </div>
                    <div>
                        <h1 class="font-bold text-lg text-gray-900 leading-none">Editor</h1>
                        <p class="text-[10px] text-gray-400 font-bold uppercase tracking-widest mt-1">Wedding App</p>
                    </div>
                    <button @click="isSidebarOpen = false" class="lg:hidden ml-auto p-2 text-gray-400">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                    </button>
                </div>
            </div>
            
            <nav class="flex-1 overflow-y-auto p-4 lg:p-6 space-y-2">
                <!-- Nav Items -->
                <button @click="activeTab = 'profile'; window.location.hash = 'profile'; if(window.innerWidth < 1024) isSidebarOpen = false" 
                        :class="activeTab === 'profile' ? 'bg-indigo-600 text-white shadow-lg shadow-indigo-100' : 'text-gray-500 hover:bg-gray-50'"
                        class="w-full flex items-center gap-4 px-4 py-3.5 rounded-2xl transition-all duration-300 active:scale-95 group">
                    <div :class="activeTab === 'profile' ? 'bg-white/20' : 'bg-gray-100 group-hover:bg-white transition-colors'" class="w-9 h-9 rounded-xl flex items-center justify-center">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path></svg>
                    </div>
                    <span class="text-sm font-bold tracking-tight">Mempelai</span>
                </button>
                
                <button @click="activeTab = 'event'; window.location.hash = 'event'; if(window.innerWidth < 1024) isSidebarOpen = false" 
                        :class="activeTab === 'event' ? 'bg-amber-500 text-white shadow-lg shadow-amber-100' : 'text-gray-500 hover:bg-gray-50'"
                        class="w-full flex items-center gap-4 px-4 py-3.5 rounded-2xl transition-all duration-300 active:scale-95 group">
                    <div :class="activeTab === 'event' ? 'bg-white/20' : 'bg-gray-100 group-hover:bg-white transition-colors'" class="w-9 h-9 rounded-xl flex items-center justify-center">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                    </div>
                    <span class="text-sm font-bold tracking-tight">Acara</span>
                </button>

                <button @click="activeTab = 'story'; window.location.hash = 'story'; if(window.innerWidth < 1024) isSidebarOpen = false" 
                        :class="activeTab === 'story' ? 'bg-purple-600 text-white shadow-lg shadow-purple-100' : 'text-gray-500 hover:bg-gray-50'"
                        class="w-full flex items-center gap-4 px-4 py-3.5 rounded-2xl transition-all duration-300 active:scale-95 group">
                    <div :class="activeTab === 'story' ? 'bg-white/20' : 'bg-gray-100 group-hover:bg-white transition-colors'" class="w-9 h-9 rounded-xl flex items-center justify-center">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"></path></svg>
                    </div>
                    <span class="text-sm font-bold tracking-tight">Love Story</span>
                </button>

                <button @click="activeTab = 'media'; window.location.hash = 'media'; if(window.innerWidth < 1024) isSidebarOpen = false" 
                        :class="activeTab === 'media' ? 'bg-rose-500 text-white shadow-lg shadow-rose-100' : 'text-gray-500 hover:bg-gray-50'"
                        class="w-full flex items-center gap-4 px-4 py-3.5 rounded-2xl transition-all duration-300 active:scale-95 group">
                    <div :class="activeTab === 'media' ? 'bg-white/20' : 'bg-gray-100 group-hover:bg-white transition-colors'" class="w-9 h-9 rounded-xl flex items-center justify-center">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                    </div>
                    <span class="text-sm font-bold tracking-tight">Media</span>
                </button>

                <button @click="activeTab = 'gift'; window.location.hash = 'gift'; if(window.innerWidth < 1024) isSidebarOpen = false" 
                        :class="activeTab === 'gift' ? 'bg-indigo-500 text-white shadow-lg shadow-indigo-100' : 'text-gray-500 hover:bg-gray-50'"
                        class="w-full flex items-center gap-4 px-4 py-3.5 rounded-2xl transition-all duration-300 active:scale-95 group">
                    <div :class="activeTab === 'gift' ? 'bg-white/20' : 'bg-gray-100 group-hover:bg-white transition-colors'" class="w-9 h-9 rounded-xl flex items-center justify-center">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    </div>
                    <span class="text-sm font-bold tracking-tight">Kado</span>
                </button>

                <button @click="activeTab = 'guests_list'; window.location.hash = 'guests_list'; if(window.innerWidth < 1024) isSidebarOpen = false" 
                        :class="activeTab === 'guests_list' ? 'bg-cyan-600 text-white shadow-lg shadow-cyan-100' : 'text-gray-500 hover:bg-gray-50'"
                        class="w-full flex items-center gap-4 px-4 py-3.5 rounded-2xl transition-all duration-300 active:scale-95 group">
                    <div :class="activeTab === 'guests_list' ? 'bg-white/20' : 'bg-gray-100 group-hover:bg-white transition-colors'" class="w-9 h-9 rounded-xl flex items-center justify-center">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
                    </div>
                    <span class="text-sm font-bold tracking-tight">Daftar Tamu</span>
                </button>

                <button @click="activeTab = 'guest'; window.location.hash = 'guest'; if(window.innerWidth < 1024) isSidebarOpen = false" 
                        :class="activeTab === 'guest' ? 'bg-emerald-500 text-white shadow-lg shadow-emerald-100' : 'text-gray-500 hover:bg-gray-50'"
                        class="w-full flex items-center gap-4 px-4 py-3.5 rounded-2xl transition-all duration-300 active:scale-95 group">
                    <div :class="activeTab === 'guest' ? 'bg-white/20' : 'bg-gray-100 group-hover:bg-white transition-colors'" class="w-9 h-9 rounded-xl flex items-center justify-center">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z"></path></svg>
                    </div>
                    <span class="text-sm font-bold tracking-tight">Ucapan</span>
                </button>
            </nav>

            <div class="p-4 lg:p-6 border-t border-gray-50" x-show="activeTab !== 'guest' && activeTab !== 'guests_list'">
                <button type="submit" form="main-form" class="w-full bg-gray-900 text-white font-bold py-4 rounded-2xl hover:bg-black transition-all shadow-xl active:scale-95">
                    Simpan Perubahan
                </button>
            </div>
        </aside>

        <!-- Main Workspace -->
        <div class="flex-1 flex flex-col h-full bg-white relative overflow-hidden">
            <!-- Header Mobile Only -->
            <div class="lg:hidden p-5 bg-white border-b border-gray-50 flex items-center justify-between sticky top-0 z-20">
                <div class="flex items-center gap-4">
                    <button @click="isSidebarOpen = true" class="p-2.5 bg-gray-50 rounded-xl text-gray-900 border border-gray-100 shadow-sm">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path></svg>
                    </button>
                    <h1 class="font-bold text-gray-900 tracking-tight">Workspace</h1>
                </div>
                <button @click="showPreview = true" class="bg-indigo-600 text-white px-5 py-2.5 rounded-xl text-xs font-bold shadow-xl shadow-indigo-100 active:scale-95 transition-all">
                    Lihat Preview
                </button>
            </div>

            <!-- Scrollable Form Container -->
            <div class="flex-1 overflow-y-auto p-4 lg:p-12 pb-32 lg:pb-12 shadow-inner">
                <div class="max-w-2xl mx-auto">
                    <!-- Tab Header Deskripsi -->
                    <div class="mb-8">
                        <template x-if="activeTab === 'profile'">
                            <div>
                                <h2 class="text-2xl font-bold text-gray-900">Informasi Mempelai</h2>
                                <p class="text-gray-500 text-sm mt-1">Lengkapi nama lengkap, nama panggilan, dan data orang tua kedua mempelai.</p>
                            </div>
                        </template>
                        <template x-if="activeTab === 'event'">
                            <div>
                                <h2 class="text-2xl font-bold text-gray-900">Detail Acara</h2>
                                <p class="text-gray-500 text-sm mt-1">Atur waktu, lokasi, dan link Google Maps untuk Akad serta Resepsi.</p>
                            </div>
                        </template>
                        <template x-if="activeTab === 'story'">
                            <div>
                                <h2 class="text-2xl font-bold text-gray-900">Perjalanan Cinta</h2>
                                <p class="text-gray-500 text-sm mt-1">Tambahkan momen-momen indah perjalanan cinta kalian berdua.</p>
                            </div>
                        </template>
                        <template x-if="activeTab === 'media'">
                            <div>
                                <h2 class="text-2xl font-bold text-gray-900">Galeri & Media</h2>
                                <p class="text-gray-500 text-sm mt-1">Kelola foto latar belakang (hero) dan foto-foto di galeri undangan.</p>
                            </div>
                        </template>
                        <template x-if="activeTab === 'gift'">
                            <div>
                                <h2 class="text-2xl font-bold text-gray-900">Tanda Kasih (Hadiah)</h2>
                                <p class="text-gray-500 text-sm mt-1">Atur nomor rekening dan alamat pengiriman kado fisik.</p>
                            </div>
                        </template>
                        <template x-if="activeTab === 'guest'">
                            <div>
                                <h2 class="text-2xl font-bold text-gray-900">Ucapan & Konfirmasi</h2>
                                <p class="text-gray-500 text-sm mt-1">Lihat dan kelola ucapan doa restu dari para tamu undangan.</p>
                            </div>
                        </template>
                        <template x-if="activeTab === 'guests_list'">
                            <div>
                                <h2 class="text-2xl font-bold text-gray-900">Daftar Nama Tamu</h2>
                                <p class="text-gray-500 text-sm mt-1">Kelola daftar tamu dan bagikan link undangan personal via WhatsApp.</p>
                            </div>
                        </template>
                    </div>

                    @if(session('success'))
                        <div class="mb-8 bg-emerald-50 border border-emerald-200 text-emerald-700 px-5 py-4 rounded-xl shadow-sm text-sm" role="alert">
                            <strong>Berhasil!</strong> {{ session('success') }}
                        </div>
                    @endif

                    <form id="main-form" :action="'{{ route('dashboard.update', $invitation->access_token) }}#' + activeTab" method="POST" enctype="multipart/form-data" class="space-y-8" @submit="isUploading = true">
                        @csrf
                        
                        <!-- TAB: PROFIL -->
                        <div x-show="activeTab === 'profile'" class="space-y-6">
                            <!-- Area Mempelai Pria -->
                            <div class="bg-gray-50 p-6 rounded-2xl border border-gray-100">
                                <h3 class="font-bold text-lg mb-4 text-gray-900 flex items-center">
                                    <span class="w-8 h-8 rounded-full bg-blue-100 text-blue-600 flex items-center justify-center mr-3 text-sm">#1</span>
                                    Mempelai Pria
                                </h3>
                                <div class="space-y-4">
                                    <div>
                                        <label class="block text-sm font-semibold text-gray-700 mb-1">Nama Panggilan</label>
                                        <input type="text" name="groom_nickname" value="{{ $invitation->content['groom']['nickname'] ?? '' }}" placeholder="mis. Budi" class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-blue-500 outline-none">
                                    </div>
                                    <div>
                                        <label class="block text-sm font-semibold text-gray-700 mb-1">Nama Lengkap & Gelar</label>
                                        <input type="text" name="groom_name" value="{{ $invitation->content['groom']['name'] ?? '' }}" placeholder="mis. Budi Santoso, S.Kom" class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-blue-500 outline-none">
                                    </div>
                                    <div>
                                        <label class="block text-sm font-semibold text-gray-700 mb-1">Nama Orang Tua</label>
                                        <input type="text" name="groom_parents" value="{{ $invitation->content['groom']['parents'] ?? '' }}" placeholder="mis. Putra dari Bpk. X dan Ibu Y" class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-blue-500 outline-none">
                                    </div>
                                </div>
                            </div>

                            <!-- Area Mempelai Wanita -->
                            <div class="bg-gray-50 p-6 rounded-2xl border border-gray-100">
                                <h3 class="font-bold text-lg mb-4 text-gray-900 flex items-center">
                                    <span class="w-8 h-8 rounded-full bg-pink-100 text-pink-600 flex items-center justify-center mr-3 text-sm">#2</span>
                                    Mempelai Wanita
                                </h3>
                                <div class="space-y-4">
                                    <div>
                                        <label class="block text-sm font-semibold text-gray-700 mb-1">Nama Panggilan</label>
                                        <input type="text" name="bride_nickname" value="{{ $invitation->content['bride']['nickname'] ?? '' }}" placeholder="mis. Astri" class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-blue-500 outline-none">
                                    </div>
                                    <div>
                                        <label class="block text-sm font-semibold text-gray-700 mb-1">Nama Lengkap & Gelar</label>
                                        <input type="text" name="bride_name" value="{{ $invitation->content['bride']['name'] ?? '' }}" placeholder="mis. Astri Lestari, S.E" class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-blue-500 outline-none">
                                    </div>
                                    <div>
                                        <label class="block text-sm font-semibold text-gray-700 mb-1">Nama Orang Tua</label>
                                        <input type="text" name="bride_parents" value="{{ $invitation->content['bride']['parents'] ?? '' }}" placeholder="mis. Putri dari Bpk. Z dan Ibu W" class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-blue-500 outline-none">
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- TAB: ACARA -->
                        <div x-show="activeTab === 'event'" class="space-y-6">
                            <div class="bg-gray-50 p-6 rounded-2xl border border-gray-100">
                                <h3 class="font-bold text-lg mb-4 text-gray-900 flex items-center">
                                    <span class="w-8 h-8 rounded-full bg-amber-100 text-amber-600 flex items-center justify-center mr-3 text-sm">#3</span>
                                    Detail Acara Utama
                                </h3>
                                <div class="space-y-4">
                                    <div>
                                        <label class="block text-sm font-semibold text-gray-700 mb-1">Tanggal (Masehi)</label>
                                        <input type="date" name="event_date" value="{{ $invitation->content['event']['date'] ?? '' }}" class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-blue-500 outline-none">
                                    </div>
                                    <div>
                                        <label class="block text-sm font-semibold text-gray-700 mb-1">Tanggal (Hijriah/Opsional)</label>
                                        <input type="text" name="event_date_hijri" value="{{ $invitation->content['event']['date_hijri'] ?? '' }}" placeholder="mis. AHAD, 14 SAFAR 1448 H" class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-blue-500 outline-none">
                                    </div>
                                </div>

                                <h4 class="font-bold text-md mt-8 mb-4 text-gray-700 border-b pb-2">Detail Akad Nikah</h4>
                                <div class="space-y-4">
                                    <div>
                                        <label class="block text-sm font-semibold text-gray-700 mb-1">Waktu Akad</label>
                                        <input type="time" name="event_time_akad" value="{{ $invitation->content['event']['time_akad'] ?? '' }}" class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-blue-500 outline-none">
                                    </div>
                                    <div>
                                        <label class="block text-sm font-semibold text-gray-700 mb-1">Nama Tempat/Gedung</label>
                                        <input type="text" name="event_location_akad_name" value="{{ $invitation->content['event']['location_akad_name'] ?? '' }}" placeholder="mis. Masjid Al-Barokah" class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-blue-500 outline-none">
                                    </div>
                                    <div class="grid grid-cols-2 gap-4">
                                        <div>
                                            <label class="block text-sm font-semibold text-gray-700 mb-1">Detail Alamat</label>
                                            <input type="text" name="event_location_akad_detail" value="{{ $invitation->content['event']['location_akad_detail'] ?? '' }}" placeholder="mis. Jl. Melati No 5" class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-blue-500 outline-none">
                                        </div>
                                        <div>
                                            <label class="block text-sm font-semibold text-gray-700 mb-1">Kota/Kec</label>
                                            <input type="text" name="event_location_akad_city" value="{{ $invitation->content['event']['location_akad_city'] ?? '' }}" placeholder="mis. Kediri, Jatim" class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-blue-500 outline-none">
                                        </div>
                                    </div>
                                    <div>
                                        <label class="block text-sm font-semibold text-gray-700 mb-1">Link Google Maps</label>
                                        <input type="text" name="event_maps_akad" value="{{ $invitation->content['event']['maps_akad'] ?? '' }}" placeholder="mis. https://goo.gl/maps/..." class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-blue-500 outline-none">
                                    </div>
                                </div>

                                <h4 class="font-bold text-md mt-8 mb-4 text-gray-700 border-b pb-2">Detail Resepsi</h4>
                                <div class="space-y-4">
                                    <div>
                                        <label class="block text-sm font-semibold text-gray-700 mb-1">Waktu Resepsi</label>
                                        <input type="time" name="event_time_resepsi" value="{{ $invitation->content['event']['time_resepsi'] ?? '' }}" class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-blue-500 outline-none">
                                    </div>
                                    <div>
                                        <label class="block text-sm font-semibold text-gray-700 mb-1">Nama Tempat/Gedung</label>
                                        <input type="text" name="event_location_resepsi_name" value="{{ $invitation->content['event']['location_resepsi_name'] ?? '' }}" placeholder="mis. Ballroom Grand Aston" class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-blue-500 outline-none">
                                    </div>
                                    <div class="grid grid-cols-2 gap-4">
                                        <div>
                                            <label class="block text-sm font-semibold text-gray-700 mb-1">Detail Alamat</label>
                                            <input type="text" name="event_location_resepsi_detail" value="{{ $invitation->content['event']['location_resepsi_detail'] ?? '' }}" placeholder="mis. Jl. Jend. Sudirman No 8" class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-blue-500 outline-none">
                                        </div>
                                        <div>
                                            <label class="block text-sm font-semibold text-gray-700 mb-1">Kota/Kec</label>
                                            <input type="text" name="event_location_resepsi_city" value="{{ $invitation->content['event']['location_resepsi_city'] ?? '' }}" placeholder="mis. Jakarta Pusat" class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-blue-500 outline-none">
                                        </div>
                                    </div>
                                    <div>
                                        <label class="block text-sm font-semibold text-gray-700 mb-1">Link Google Maps</label>
                                        <input type="text" name="event_maps_resepsi" value="{{ $invitation->content['event']['maps_resepsi'] ?? '' }}" placeholder="mis. https://goo.gl/maps/..." class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-blue-500 outline-none">
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- TAB: STORY -->
                        <div x-show="activeTab === 'story'" class="space-y-6">
                            <div class="bg-gray-50 p-6 rounded-2xl border border-gray-100"
                                x-data="{ 
                                    stories: {{ json_encode($invitation->content['stories'] ?? [['title' => '', 'description' => '']]) }} 
                                }">
                                <div class="flex justify-between items-center mb-4">
                                    <h3 class="font-bold text-lg text-gray-900 flex items-center">
                                        <span class="w-8 h-8 rounded-full bg-purple-100 text-purple-600 flex items-center justify-center mr-3 text-sm">#4</span>
                                        Our Love Story (Cerita Cintamu)
                                    </h3>
                                    <button type="button" @click="stories.push({title: '', description: ''})" 
                                            class="text-xs bg-purple-600 text-white px-3 py-1.5 rounded-lg hover:bg-purple-700 transition flex items-center gap-1">
                                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                                        Tambah Momen
                                    </button>
                                </div>
                                <div class="space-y-4">
                                    <template x-for="(story, index) in stories" :key="index">
                                        <div class="bg-white p-4 rounded-xl border border-gray-200 relative group shadow-sm transition-all hover:border-purple-200">
                                            <button type="button" @click="stories.splice(index, 1)" 
                                                    class="absolute -top-2 -right-2 bg-red-500 text-white w-6 h-6 rounded-full flex items-center justify-center shadow-lg opacity-0 group-hover:opacity-100 transition-opacity z-10 hover:bg-red-600">
                                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                                            </button>
                                            <div class="space-y-4">
                                                <div>
                                                    <label class="block text-[10px] font-bold text-gray-400 uppercase mb-1">Judul Momen</label>
                                                    <input type="text" :name="'stories['+index+'][title]'" x-model="story.title" placeholder="Awal Kenal" class="w-full border border-gray-200 rounded-lg px-4 py-2 focus:ring-2 focus:ring-purple-500 outline-none text-sm">
                                                </div>
                                                <div>
                                                    <label class="block text-[10px] font-bold text-gray-400 uppercase mb-1">Isi Cerita</label>
                                                    <textarea :name="'stories['+index+'][description]'" x-model="story.description || story.content" rows="3" placeholder="Ceritakan momen ini..." class="w-full border border-gray-200 rounded-lg px-4 py-2 focus:ring-2 focus:ring-purple-500 outline-none text-sm"></textarea>
                                                </div>
                                            </div>
                                        </div>
                                    </template>
                                </div>
                            </div>
                        </div>

                        <!-- TAB: MEDIA -->
                        <div x-show="activeTab === 'media'" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                            <!-- Liquid Loader Overlay -->
                            <div x-show="isUploading" x-transition x-cloak class="fixed inset-0 bg-white/80 backdrop-blur-md z-[200] flex flex-col items-center justify-center">
                                <div class="liquid-container liquid-filling mb-4">
                                    <div class="liquid-wave"></div>
                                </div>
                                <p class="text-blue-600 font-bold animate-pulse">Sedang Mengisi Air... (Mengunggah Foto)</p>
                            </div>

                            <!-- 1. COVER IMAGE (Single) -->
                            <div class="bg-white p-6 rounded-3xl border border-gray-100 shadow-xl flex flex-col">
                                <h3 class="font-bold text-lg mb-4 flex items-center gap-3">
                                    <span class="w-8 h-8 rounded-xl bg-orange-100 text-orange-600 flex items-center justify-center text-xs">01</span>
                                    Foto Cover Utama
                                </h3>
                                <div class="flex-1 space-y-4">
                                    <div class="relative group aspect-[4/3] rounded-2xl overflow-hidden bg-gray-50 border-2 border-dashed border-gray-200">
                                        <img :src="coverPreview || cover_image || 'https://via.placeholder.com/400x300?text=No+Cover'" class="w-full h-full object-cover">
                                        <input type="file" name="cover_file" class="hidden" id="cover_upload" @change="handleFile($event, 'cover')">
                                        <label for="cover_upload" class="absolute inset-0 bg-black/40 opacity-0 group-hover:opacity-100 transition-opacity flex flex-col items-center justify-center cursor-pointer text-white">
                                            <svg class="w-8 h-8 mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z"></path></svg>
                                            <span class="text-xs font-bold uppercase">Ganti Cover</span>
                                        </label>
                                    </div>
                                    <input type="text" name="cover_image" x-model="cover_image" class="w-full bg-gray-50 border border-gray-100 rounded-xl px-4 py-2 text-[10px] font-mono outline-none focus:ring-2 focus:ring-orange-500" placeholder="Atau Link URL Cover...">
                                </div>
                            </div>

                            <!-- 2. GROOM PHOTO (Single) -->
                            <div class="bg-white p-6 rounded-3xl border border-gray-100 shadow-xl flex flex-col">
                                <h3 class="font-bold text-lg mb-4 flex items-center gap-3">
                                    <span class="w-8 h-8 rounded-xl bg-blue-100 text-blue-600 flex items-center justify-center text-xs">02</span>
                                    Foto Pengantin Pria
                                </h3>
                                <div class="flex-1 space-y-4">
                                    <div class="relative group aspect-square rounded-2xl overflow-hidden bg-gray-50 border-2 border-dashed border-gray-200 w-3/4 mx-auto">
                                        <img :src="groomPreview || groom_image || 'https://via.placeholder.com/300?text=Groom'" class="w-full h-full object-cover">
                                        <input type="file" name="groom_file" class="hidden" id="groom_upload" @change="handleFile($event, 'groom')">
                                        <label for="groom_upload" class="absolute inset-0 bg-black/40 opacity-0 group-hover:opacity-100 transition-opacity flex flex-col items-center justify-center cursor-pointer text-white">
                                            <svg class="w-8 h-8 mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path></svg>
                                            <span class="text-xs font-bold">Ganti Foto</span>
                                        </label>
                                    </div>
                                    <input type="text" name="groom_image" x-model="groom_image" class="w-full bg-gray-50 border border-gray-100 rounded-xl px-4 py-2 text-[10px] font-mono outline-none focus:ring-2 focus:ring-blue-500" placeholder="Link URL Foto Pria...">
                                </div>
                            </div>

                            <!-- 3. BRIDE PHOTO (Single) -->
                            <div class="bg-white p-6 rounded-3xl border border-gray-100 shadow-xl flex flex-col">
                                <h3 class="font-bold text-lg mb-4 flex items-center gap-3">
                                    <span class="w-8 h-8 rounded-xl bg-rose-100 text-rose-600 flex items-center justify-center text-xs">03</span>
                                    Foto Pengantin Wanita
                                </h3>
                                <div class="flex-1 space-y-4">
                                    <div class="relative group aspect-square rounded-2xl overflow-hidden bg-gray-50 border-2 border-dashed border-gray-200 w-3/4 mx-auto">
                                        <img :src="bridePreview || bride_image || 'https://via.placeholder.com/300?text=Bride'" class="w-full h-full object-cover">
                                        <input type="file" name="bride_file" class="hidden" id="bride_upload" @change="handleFile($event, 'bride')">
                                        <label for="bride_upload" class="absolute inset-0 bg-black/40 opacity-0 group-hover:opacity-100 transition-opacity flex flex-col items-center justify-center cursor-pointer text-white">
                                            <svg class="w-8 h-8 mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path></svg>
                                            <span class="text-xs font-bold">Ganti Foto</span>
                                        </label>
                                    </div>
                                    <input type="text" name="bride_image" x-model="bride_image" class="w-full bg-gray-50 border border-gray-100 rounded-xl px-4 py-2 text-[10px] font-mono outline-none focus:ring-2 focus:ring-rose-500" placeholder="Link URL Foto Wanita...">
                                </div>
                            </div>

                            <!-- 4. SLIDESHOW (Multiple) -->
                            <div class="bg-white p-6 rounded-3xl border border-gray-100 shadow-xl lg:col-span-1">
                                <h3 class="font-bold text-lg mb-4 flex items-center gap-3">
                                    <span class="w-8 h-8 rounded-xl bg-purple-100 text-purple-600 flex items-center justify-center text-xs">04</span>
                                    Slideshow Utama
                                </h3>
                                <div class="space-y-4">
                                    <div class="border-2 border-dashed border-purple-100 rounded-2xl p-6 text-center hover:bg-purple-50/50 transition-all cursor-pointer relative group">
                                        <input type="file" name="slideshow_files[]" id="slideshow_input" multiple class="absolute inset-0 opacity-0 cursor-pointer" @change="handleFile($event, 'hero')">
                                        <div class="w-10 h-10 bg-purple-50 text-purple-500 rounded-full flex items-center justify-center mx-auto mb-2 group-hover:scale-110 transition-transform">
                                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                                        </div>
                                        <span class="text-[10px] font-bold text-purple-600 uppercase tracking-tighter">Tambah Slideshow</span>
                                        <template x-if="heroPreviews.length > 0">
                                            <p class="text-[8px] text-emerald-500 mt-2 font-bold" x-text="'+ ' + heroPreviews.length + ' foto baru dipilih'"></p>
                                        </template>
                                    </div>
                                    <div class="grid grid-cols-2 md:grid-cols-3 gap-2 p-2 bg-gray-50/50 rounded-2xl">
                                        <template x-for="(img, idx) in hero_images" :key="idx">
                                            <div class="relative aspect-square rounded-xl overflow-hidden group border-2 border-white shadow-sm transition-all hover:border-purple-300">
                                                <img :src="img" class="w-full h-full object-cover">
                                                <div class="absolute inset-0 bg-red-600/60 opacity-0 group-hover:opacity-100 transition-opacity flex items-center justify-center">
                                                    <button type="button" @click="hero_images.splice(idx, 1)" class="w-8 h-8 bg-white text-red-500 rounded-full flex items-center justify-center shadow-lg transform scale-75 group-hover:scale-100 transition-transform">
                                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                                    </button>
                                                </div>
                                                <!-- Send as both to be safe -->
                                                <input type="hidden" name="slideshow_images[]" :value="img">
                                                <input type="hidden" name="hero_images[]" :value="img">
                                            </div>
                                        </template>
                                        <template x-if="hero_images.length === 0">
                                            <div class="col-span-full py-8 text-center text-[10px] text-gray-300 italic">Belum ada slideshow Bos...</div>
                                        </template>
                                    </div>
                                </div>
                            </div>

                            <!-- 6. OG IMAGE (Thumbnail Share) -->
                            <div class="bg-white p-6 rounded-3xl border border-gray-100 shadow-xl flex flex-col">
                                <h3 class="font-bold text-lg mb-4 flex items-center gap-3">
                                    <span class="w-8 h-8 rounded-xl bg-emerald-100 text-emerald-600 flex items-center justify-center text-xs">06</span>
                                    OG Image (WA/FB Preview)
                                </h3>
                                <div class="flex-1 space-y-4">
                                    <div class="relative group aspect-[1.91/1] rounded-2xl overflow-hidden bg-gray-50 border-2 border-dashed border-gray-200">
                                        <img :src="ogPreview || og_image || 'https://via.placeholder.com/600x315?text=Share+Preview'" class="w-full h-full object-cover">
                                        <input type="file" name="og_file" class="hidden" id="og_upload" @change="handleFile($event, 'og')">
                                        <label for="og_upload" class="absolute inset-0 bg-black/40 opacity-0 group-hover:opacity-100 transition-opacity flex flex-col items-center justify-center cursor-pointer text-white">
                                            <svg class="w-8 h-8 mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                                            <span class="text-xs font-bold font-poppins capitalize">Ganti Thumbnail</span>
                                        </label>
                                    </div>
                                    <input type="text" name="og_image" x-model="og_image" class="w-full bg-gray-50 border border-gray-100 rounded-xl px-4 py-2 text-[10px] font-mono outline-none focus:ring-2 focus:ring-emerald-500" placeholder="Atau Link URL Preview...">
                                    <p class="text-[9px] text-gray-400 italic text-center">Rasio ideal 1.91:1 (cth: 1200x630px)</p>
                                </div>
                            </div>

                            <!-- 5. GALLERY (Full Width at Bottom) -->
                            <div class="bg-white p-8 rounded-3xl border border-gray-100 shadow-xl lg:col-span-3 mt-4 overflow-hidden relative">
                                <div class="absolute top-0 right-0 w-32 h-32 bg-cyan-50 rounded-full -mr-16 -mt-16 opacity-30"></div>
                                <h3 class="font-bold text-xl mb-6 flex items-center gap-3 relative z-10">
                                    <span class="w-10 h-10 rounded-2xl bg-cyan-600 text-white flex items-center justify-center text-sm shadow-lg shadow-cyan-100">05</span>
                                    Galeri Foto Koleksi (Tampilan Besar)
                                </h3>
                                
                                <div class="grid grid-cols-1 md:grid-cols-4 gap-8">
                                    <!-- Upload Button Area -->
                                    <div class="md:col-span-1">
                                        <div class="border-2 border-dashed border-cyan-200 rounded-[2rem] p-8 text-center hover:bg-cyan-50/50 transition-all cursor-pointer relative h-full flex flex-col items-center justify-center bg-gray-50/30 group">
                                            <input type="file" name="gallery_files[]" multiple class="absolute inset-0 opacity-0 cursor-pointer" @change="handleFile($event, 'gallery')">
                                            <div class="w-16 h-16 bg-white text-cyan-500 rounded-2xl flex items-center justify-center mb-4 shadow-sm group-hover:scale-110 transition-transform">
                                                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                                            </div>
                                            <p class="text-xs font-black text-cyan-600 uppercase tracking-widest">Tambah Foto</p>
                                            <p class="text-[10px] text-gray-400 mt-2">Bisa pilih banyak sekaligus Bos</p>
                                        </div>
                                    </div>

                                    <!-- Grid Gallery (Jumbo) -->
                                    <div class="md:col-span-3">
                                        <div class="grid grid-cols-3 sm:grid-cols-4 md:grid-cols-5 lg:grid-cols-6 gap-4 overflow-y-auto max-h-[500px] pr-2 custom-scrollbar">
                                            <template x-for="(img, idx) in gallery_images" :key="img">
                                                <div class="relative aspect-[3/4] rounded-[1.5rem] overflow-hidden group border-4 border-white shadow-lg hover:shadow-cyan-200 transition-all duration-300">
                                                    <img :src="img" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-700">
                                                    <div class="absolute inset-0 bg-gradient-to-t from-black/60 via-transparent to-transparent opacity-0 group-hover:opacity-100 transition-opacity flex items-end justify-center pb-4">
                                                        <button type="button" @click="removeGallery(idx)" class="w-10 h-10 bg-red-500 text-white rounded-full flex items-center justify-center shadow-2xl hover:bg-red-600 transition-colors transform translate-y-4 group-hover:translate-y-0 duration-300">
                                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                                        </button>
                                                    </div>
                                                    <input type="hidden" name="gallery_images[]" :value="img">
                                                </div>
                                            </template>
                                            <div x-show="gallery_images.length === 0" class="col-span-full py-20 text-center bg-gray-50 rounded-[2rem] border-2 border-dashed border-gray-100 text-gray-300 italic">
                                                Belum ada foto galeri Bos...
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- TAB: KADO -->
                        <div x-show="activeTab === 'gift'" class="space-y-6">
                            <div class="bg-gray-50 p-6 rounded-2xl border border-gray-100" 
                                x-data="{ 
                                    gifts: {{ json_encode($invitation->content['gifts'] ?? [['bank_name' => '', 'account_number' => '', 'account_name' => '']]) }} 
                                }">
                                <div class="flex justify-between items-center mb-4">
                                    <h3 class="font-bold text-lg text-gray-900 flex items-center">
                                        <span class="w-8 h-8 rounded-full bg-indigo-100 text-indigo-600 flex items-center justify-center mr-3 text-sm">#7</span>
                                        Digital Gift (Rekening/E-Wallet)
                                    </h3>
                                    <button type="button" @click="gifts.push({bank_name: '', account_number: '', account_name: ''})" 
                                            class="text-xs bg-indigo-600 text-white px-3 py-1.5 rounded-lg hover:bg-indigo-700 transition flex items-center gap-1">
                                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                                        Tambah Rekening
                                    </button>
                                </div>
                                <div class="space-y-4">
                                    <template x-for="(gift, index) in gifts" :key="index">
                                        <div class="bg-white p-4 rounded-xl border border-gray-200 relative group shadow-sm transition-all hover:border-indigo-200">
                                            <button type="button" @click="gifts.splice(index, 1)" 
                                                    class="absolute -top-2 -right-2 bg-red-500 text-white w-6 h-6 rounded-full flex items-center justify-center shadow-lg opacity-0 group-hover:opacity-100 transition-opacity z-10 hover:bg-red-600">
                                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                                            </button>
                                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                                <div class="md:col-span-2">
                                                    <label class="block text-[10px] font-bold text-gray-400 uppercase mb-1">Bank / E-Wallet</label>
                                                    <input type="text" :name="'gifts['+index+'][bank_name]'" x-model="gift.bank_name" placeholder="BCA" class="w-full border border-gray-200 rounded-lg px-4 py-2 focus:ring-2 focus:ring-indigo-500 outline-none text-sm">
                                                </div>
                                                <input type="text" :name="'gifts['+index+'][account_number]'" x-model="gift.account_number" placeholder="No Rekening" class="w-full border border-gray-200 rounded-lg px-4 py-2 focus:ring-2 focus:ring-indigo-500 outline-none text-sm">
                                                <input type="text" :name="'gifts['+index+'][account_name]'" x-model="gift.account_name" placeholder="Nama Pemilik" class="w-full border border-gray-200 rounded-lg px-4 py-2 focus:ring-2 focus:ring-indigo-500 outline-none text-sm">
                                            </div>
                                        </div>
                                    </template>
                                </div>
                            </div>

                            <div class="bg-gray-50 p-6 rounded-2xl border border-gray-100">
                                <h3 class="font-bold text-lg mb-4 text-gray-900 flex items-center">
                                    <span class="w-8 h-8 rounded-full bg-purple-100 text-purple-600 flex items-center justify-center mr-3 text-sm">#8</span>
                                    Alamat Pengiriman Kado (Fisik)
                                </h3>
                                <div class="space-y-4">
                                    <input type="text" name="event[recipient_name]" value="{{ $invitation->content['event']['recipient_name'] ?? '' }}" placeholder="Nama Penerima" class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-blue-500 outline-none">
                                    <input type="text" name="event[recipient_phone]" value="{{ $invitation->content['event']['recipient_phone'] ?? '' }}" placeholder="No. HP" class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-blue-500 outline-none">
                                    <textarea name="event[recipient_address]" rows="3" class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-blue-500 outline-none" placeholder="Alamat Lengkap">{{ $invitation->content['event']['recipient_address'] ?? '' }}</textarea>
                                </div>
                            </div>
                        </div>

                        <!-- Tombol Simpan Mobile -->
                        <div class="lg:hidden pt-8" x-show="activeTab !== 'guest' && activeTab !== 'guests_list'">
                             <button type="submit" class="w-full bg-gray-900 text-white font-bold py-5 rounded-2xl shadow-xl active:scale-95 transition-all">Simpan Perubahan</button>
                        </div>

                        <!-- TAB: GUEST LIST (Management) -->
                        <div x-show="activeTab === 'guests_list'" class="space-y-8" x-cloak>
                            
                            <!-- Add Guest Form -->
                            <div class="bg-cyan-50 border border-cyan-100 p-8 rounded-[2.5rem] shadow-sm">
                                <h4 class="font-bold text-cyan-900 mb-6 flex items-center gap-3 text-sm uppercase tracking-wider">
                                    <div class="w-8 h-8 bg-cyan-600 text-white rounded-xl flex items-center justify-center shadow-lg shadow-cyan-100">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4"></path></svg>
                                    </div>
                                    Tambah Tamu Baru
                                </h4>
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                    <div class="space-y-1">
                                        <label class="text-[10px] font-black text-cyan-700 uppercase ml-2">Nama Lengkap</label>
                                        <input type="text" x-model="newName" placeholder="mis. Budi Santoso" class="w-full bg-white border-2 border-cyan-100 rounded-2xl px-6 py-4 text-sm focus:ring-4 focus:ring-cyan-500/10 focus:border-cyan-500 outline-none transition-all shadow-inner">
                                    </div>
                                    <div class="space-y-1">
                                        <label class="text-[10px] font-black text-cyan-700 uppercase ml-2">Nomor WhatsApp</label>
                                        <div class="flex gap-2">
                                            <input type="text" x-model="newPhone" placeholder="mis. 08123456..." class="flex-1 bg-white border-2 border-cyan-100 rounded-2xl px-6 py-4 text-sm focus:ring-4 focus:ring-cyan-500/10 focus:border-cyan-500 outline-none transition-all shadow-inner">
                                            <button @click="addGuest()" type="button" class="bg-cyan-600 text-white px-8 rounded-2xl font-black hover:bg-cyan-700 transition active:scale-95 shadow-lg shadow-cyan-200">Tambah</button>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Guest List Table -->
                            <div class="bg-white border border-gray-100 rounded-[2.5rem] shadow-xl overflow-hidden">
                                <div class="p-8 border-b border-gray-50 flex flex-col md:flex-row items-center justify-between gap-4 bg-gray-50/30">
                                    <div class="relative w-full md:w-80">
                                        <span class="absolute left-5 top-3.5 text-gray-300"><svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg></span>
                                        <input type="text" x-model="search" placeholder="Cari nama tamu..." class="w-full bg-white border border-gray-200 rounded-2xl pl-12 pr-6 py-3.5 text-sm outline-none focus:ring-4 focus:ring-cyan-500/10 focus:border-cyan-500">
                                    </div>
                                    <div class="flex items-center gap-3">
                                        <span class="text-[10px] font-black text-gray-400 uppercase tracking-widest bg-white px-5 py-2.5 rounded-full border border-gray-100 shadow-sm">
                                            Koleksi Tamu: <span class="text-cyan-600" x-text="guests.length"></span>
                                        </span>
                                    </div>
                                </div>

                                <div class="overflow-x-auto">
                                    <table class="w-full text-left border-collapse">
                                        <thead>
                                            <tr class="bg-gray-50/50">
                                                <th class="px-8 py-5 text-[10px] font-black text-gray-400 uppercase tracking-widest border-b border-gray-100">Informasi Tamu</th>
                                                <th class="px-8 py-5 text-[10px] font-black text-gray-400 uppercase tracking-widest border-b border-gray-100">WhatsApp</th>
                                                <th class="px-8 py-5 text-[10px] font-black text-gray-400 uppercase tracking-widest border-b border-gray-100 text-right">Tindakan</th>
                                            </tr>
                                        </thead>
                                        <tbody class="divide-y divide-gray-50">
                                            <template x-for="(guest, index) in guests" :key="index">
                                                <tr x-show="guest.name.toLowerCase().includes((typeof search !== 'undefined' ? search : '').toLowerCase())" class="hover:bg-cyan-50/30 transition-all group">
                                                    <input type="hidden" :name="'guests['+index+'][name]'" :value="guest.name">
                                                    <input type="hidden" :name="'guests['+index+'][phone]'" :value="guest.phone">
                                                    
                                                    <td class="px-8 py-5">
                                                        <div class="flex items-center gap-4">
                                                            <div class="w-10 h-10 rounded-xl bg-cyan-100 text-cyan-700 flex items-center justify-center font-black text-xs shadow-sm group-hover:scale-110 transition-transform" x-text="guest.name.charAt(0)"></div>
                                                            <span class="font-bold text-gray-900" x-text="guest.name"></span>
                                                        </div>
                                                    </td>
                                                    <td class="px-8 py-5 text-gray-500 text-sm font-mono" x-text="guest.phone || '-'"></td>
                                                    <td class="px-8 py-5 text-right">
                                                        <div class="flex items-center justify-end gap-3">
                                                            <button @click="sendWA(guest)" type="button" class="bg-emerald-500 hover:bg-emerald-600 text-white p-3 rounded-xl transition shadow-lg shadow-emerald-100 active:scale-90">
                                                                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413Z"/></svg>
                                                            </button>
                                                            <button @click="removeGuest(index)" type="button" class="bg-gray-50 text-gray-300 hover:text-red-500 hover:bg-red-50 p-3 rounded-xl transition border border-gray-100 flex items-center justify-center">
                                                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                                            </button>
                                                        </div>
                                                    </td>
                                                </tr>
                                            </template>
                                        </tbody>
                                    </table>
                                </div>
                                
                                <template x-if="guests.length === 0">
                                    <div class="text-center py-20">
                                        <div class="w-20 h-20 bg-gray-50 rounded-3xl flex items-center justify-center mx-auto mb-4 border border-dashed border-gray-200">
                                            <svg class="w-10 h-10 text-gray-200" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
                                        </div>
                                        <p class="text-gray-400 text-sm font-medium italic">Belum ada tamu yang terdaftar.</p>
                                    </div>
                                </template>
                            </div>

                            <!-- Manual Save for Guest List -->
                            <div class="mt-8 flex flex-col items-center gap-4 py-8 border-t border-gray-100">
                                 <button type="submit" class="w-full bg-cyan-600 text-white font-black py-5 rounded-[2rem] shadow-2xl shadow-cyan-200 hover:bg-cyan-700 active:scale-[0.98] transition-all flex items-center justify-center gap-4 text-lg">
                                     <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M8 7H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-3m-1 4l-3 3m0 0l-3-3m3 3V4"></path></svg>
                                     Simpan Data Tamu Selamanya
                                 </button>
                                 <div class="bg-amber-50 text-amber-700 px-6 py-2 rounded-full text-[10px] font-black uppercase tracking-widest border border-amber-100">
                                     💡 Perubahan tidak akan tersimpan jika tidak klik tombol biru di atas
                                 </div>
                            </div>
                        </div>
                    </form>

                    <!-- TAB: GUEST (Management) -->
                    <div x-show="activeTab === 'guest'" class="space-y-8" x-cloak>
                        <div class="flex items-center justify-between">
                            <div>
                                <h3 class="font-bold text-2xl text-gray-900 flex items-center gap-3">
                                    <svg class="w-7 h-7 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z"></path></svg>
                                    Statistik & Daftar Ucapan
                                </h3>
                                <p class="text-sm text-gray-500 mt-1">Kelola doa restu dan konfirmasi kehadiran tamu.</p>
                            </div>
                        </div>

                        <!-- Stats Overview -->
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                            <div class="bg-blue-50 p-5 rounded-3xl border border-blue-100 flex items-center gap-4 transition-transform hover:scale-[1.02]">
                                <div class="w-12 h-12 bg-blue-100 text-blue-600 rounded-2xl flex items-center justify-center shadow-sm">
                                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"></path></svg>
                                </div>
                                <div>
                                    <p class="text-[10px] font-bold text-blue-400 uppercase tracking-widest">Total Pesan</p>
                                    <p class="text-2xl font-black text-blue-900 leading-none">{{ count($invitation->rsvps) }}</p>
                                </div>
                            </div>
                            <div class="bg-emerald-50 p-5 rounded-3xl border border-emerald-100 flex items-center gap-4 transition-transform hover:scale-[1.02]">
                                <div class="w-12 h-12 bg-emerald-100 text-emerald-600 rounded-2xl flex items-center justify-center shadow-sm">
                                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                </div>
                                <div>
                                    <p class="text-[10px] font-bold text-emerald-400 uppercase tracking-widest">Tamu Hadir</p>
                                    <p class="text-2xl font-black text-emerald-900 leading-none">{{ $invitation->rsvps()->where('status', 'Hadir')->count() }}</p>
                                </div>
                            </div>
                            <div class="bg-amber-50 p-5 rounded-3xl border border-amber-100 flex items-center gap-4 transition-transform hover:scale-[1.02]">
                                <div class="w-12 h-12 bg-amber-100 text-amber-600 rounded-2xl flex items-center justify-center shadow-sm">
                                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path></svg>
                                </div>
                                <div>
                                    <p class="text-[10px] font-bold text-amber-400 uppercase tracking-widest">Absen/Lainnya</p>
                                    <p class="text-2xl font-black text-amber-900 leading-none">{{ $invitation->rsvps()->where('status', '!=', 'Hadir')->count() }}</p>
                                </div>
                            </div>
                        </div>

                        <div class="space-y-4 pb-32">
                            @forelse($invitation->rsvps()->latest()->get() as $rsvp)
                                <div class="bg-white border border-gray-100 rounded-3xl p-6 shadow-sm relative transition-all hover:border-indigo-100 hover:shadow-md">
                                    <div class="absolute top-0 right-0">
                                        <span class="px-4 py-2 rounded-bl-3xl text-[10px] font-bold uppercase tracking-wider {{ $rsvp->status == 'Hadir' ? 'bg-emerald-100 text-emerald-700' : 'bg-rose-100 text-rose-700' }}">
                                            {{ $rsvp->status }}
                                        </span>
                                    </div>

                                    <div class="flex items-start gap-4 mb-6">
                                        <div class="w-12 h-12 bg-gray-50 rounded-[1.25rem] flex items-center justify-center font-black text-gray-400 border border-gray-100">
                                            {{ substr($rsvp->name, 0, 1) }}
                                        </div>
                                        <div>
                                            <h4 class="font-bold text-gray-900">{{ $rsvp->name }}</h4>
                                            <p class="text-[10px] text-gray-400 font-bold uppercase mt-0.5 tracking-tight">{{ $rsvp->created_at->diffForHumans() }}</p>
                                        </div>
                                    </div>

                                    <div class="bg-slate-50/50 rounded-2xl p-5 mb-6 italic text-sm text-gray-600 border-l-4 border-indigo-400 leading-relaxed">
                                        "{{ $rsvp->message }}"
                                    </div>

                                    <div x-data="{ replyText: '{{ $rsvp->reply ?? '' }}', saving: false, saved: false, showDelete: false }">
                                        <div class="flex items-center gap-2">
                                            <div class="relative flex-1">
                                                <input type="text" x-model="replyText" placeholder="Balas ke tamu ini..." 
                                                       class="w-full bg-gray-50 border-gray-100 rounded-2xl px-5 py-3.5 text-xs focus:ring-2 focus:ring-indigo-500 outline-none transition-all placeholder:text-gray-300">
                                                <div class="absolute right-2 top-1.5 flex gap-1">
                                                    <button @click="saving = true; fetch('{{ route('rsvp.reply', $rsvp->id) }}', { method: 'PATCH', headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': '{{ csrf_token() }}', 'X-Requested-With': 'XMLHttpRequest' }, body: JSON.stringify({ reply: replyText }) }).then(() => { saving = false; saved = true; setTimeout(() => saved = false, 3000); })"
                                                            :disabled="saving"
                                                            class="bg-indigo-600 text-white px-4 h-9 rounded-xl text-[10px] font-bold hover:bg-black transition-all flex items-center gap-2 shadow-sm">
                                                        <span x-show="!saving && !saved">Balas</span>
                                                        <span x-show="saving" class="w-3 h-3 border-2 border-white/30 border-t-white rounded-full animate-spin"></span>
                                                        <span x-show="saved">✓ Oke</span>
                                                    </button>
                                                </div>
                                            </div>
                                            <button @click="showDelete = !showDelete" class="w-12 h-12 rounded-2xl bg-gray-50 text-gray-300 hover:text-red-500 hover:bg-red-50 transition border border-gray-100 flex items-center justify-center">
                                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                            </button>
                                        </div>

                                        <!-- Confirm Delete Popup-style -->
                                        <div x-show="showDelete" 
                                             x-transition:enter="transition ease-out duration-300"
                                             x-transition:enter-start="opacity-0 translate-y-2"
                                             x-transition:enter-end="opacity-100 translate-y-0"
                                             class="mt-3 p-4 bg-red-50 border border-red-100 rounded-2xl flex items-center justify-between animate-pulse-slow">
                                            <div class="flex items-center gap-3">
                                                <div class="w-8 h-8 rounded-lg bg-red-100 text-red-600 flex items-center justify-center"><svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path></svg></div>
                                                <span class="text-[10px] font-bold text-red-800 uppercase tracking-tight">Hapus pesan selamanya?</span>
                                            </div>
                                            <div class="flex gap-2">
                                                <form action="{{ route('rsvp.destroy', $rsvp->id) }}" method="POST">
                                                    @csrf @method('DELETE')
                                                    <button type="submit" class="bg-red-600 text-white text-[10px] font-bold uppercase px-4 py-2 rounded-xl shadow-md">Ya, Hapus</button>
                                                </form>
                                                <button @click="showDelete = false" class="text-[10px] text-gray-500 font-bold uppercase px-4 py-2">Batal</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @empty
                                <div class="text-center py-20 bg-gray-50 rounded-[3rem] border-2 border-dashed border-gray-200">
                                    <div class="w-16 h-16 bg-white rounded-2xl flex items-center justify-center mx-auto mb-4 shadow-sm border border-gray-100">
                                        <svg class="w-8 h-8 text-gray-200" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z"></path></svg>
                                    </div>
                                    <p class="text-gray-400 text-sm italic">Belum ada ucapan yang masuk.</p>
                                </div>
                            @endforelse
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Preview Column (Desktop Right / Mobile Overlay) -->
        <div :class="showPreview ? 'fixed inset-0 z-[110] flex' : 'hidden lg:flex'" 
             class="w-full h-screen lg:relative lg:w-[480px] lg:h-full bg-slate-900 border-l border-slate-800 ">
            
            <!-- Close Preview Mobile -->
            <button @click="showPreview = false" class="lg:hidden absolute top-4 left-4 z-[120] bg-white/20 backdrop-blur-md text-white px-4 py-2 rounded-full font-bold text-xs">
                Tutup Preview
            </button>

            <div class="absolute top-4 right-4 z-50 bg-black/50 text-white px-4 py-2.5 rounded-full text-[10px] font-bold tracking-widest uppercase border border-white/20 shadow-2xl flex items-center backdrop-blur-md">
                <span class="w-2 h-2 rounded-full bg-emerald-500 mr-2 shadow-[0_0_8px_rgba(16,185,129,1)] animate-pulse"></span>
                Live Preview
            </div>

            <iframe 
                src="{{ route('invitation.show', $invitation->slug) }}" 
                class="w-full h-full border-none shadow-[0_0_50px_rgba(0,0,0,0.5)]">
            </iframe>
        </div>
    </div>

</body>
</html>
