<!DOCTYPE html>
<html lang="id" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <title>Undangan Pernikahan - {{ $data['groom']['nickname'] }} & {{ $data['bride']['nickname'] }}</title>
    
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:ital,wght@0,400;0,600;1,400&family=Montserrat:wght@300;400;600&family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    
    <!-- Alpine & Tailwind -->
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://unpkg.com/lucide@latest"></script>
    
    <!-- SEO & WhatsApp Shared Preview -->
    @php
        $shareImage = ($data['og_image'] ?? ($data['cover_image'] ?? ($data['hero_images'][0] ?? 'https://sesarengan.my.id/images/default-share.jpg')));
        if (!empty($shareImage) && !str_starts_with($shareImage, 'http')) {
            $shareImage = url($shareImage);
        }
    @endphp

    <meta name="title" content="Undangan Pernikahan: {{ $data['groom']['nickname'] }} & {{ $data['bride']['nickname'] }}">
    <meta name="description" content="Tanpa mengurangi rasa hormat, kami mengundang Anda untuk hadir di acara pernikahan {{ $data['groom']['name'] }} & {{ $data['bride']['name'] }}">
    
    <meta property="og:type" content="website">
    <meta property="og:url" content="{{ url()->current() }}">
    <meta property="og:title" content="The Wedding of {{ $data['groom']['nickname'] }} & {{ $data['bride']['nickname'] }}">
    <meta property="og:description" content="Klik untuk melihat detail acara & konfirmasi kehadiran.">
    <meta property="og:image" content="{{ $shareImage }}">
    <meta property="og:image:secure_url" content="{{ $shareImage }}">
    <meta property="og:image:type" content="image/jpeg">

    <!-- Twitter Tags -->
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:title" content="The Wedding of {{ $data['groom']['nickname'] }} & {{ $data['bride']['nickname'] }}">
    <meta name="twitter:image" content="{{ $shareImage }}">

    <!-- Schema.org for Google+ / older parsers -->
    <meta itemprop="name" content="The Wedding of {{ $data['groom']['nickname'] }} & {{ $data['bride']['nickname'] }}">
    <meta itemprop="image" content="{{ $shareImage }}">

    <!-- AOS Animate On Scroll -->
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>

    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: {
                        serif: ['"Cormorant Garamond"', 'serif'],
                        sans: ['Poppins', 'sans-serif'],
                        poppins: ['Poppins', 'sans-serif'],
                    },
                    colors: {
                        gold: '#ECAA6D',
                        dark: '#0f0f0f',
                    }
                }
            }
        }
    </script>

    <style>
        body { background-color: #0f0f0f; color: white; margin: 0; padding: 0; overflow-x: hidden; }
        .bg-luxury {
            background-image: linear-gradient(rgba(15, 15, 15, 0.7), rgba(15, 15, 15, 0.9)), url('https://images.unsplash.com/photo-1519225421980-715cb0215aed?ixlib=rb-4.0.3&auto=format&fit=crop&w=2000&q=80');
            background-size: cover;
            background-position: center;
            background-attachment: fixed;
        }
        .hero-slide {
            position: absolute;
            inset: 0;
            background-size: cover;
            background-position: center;
            transition: opacity 1.5s ease-in-out;
        }
        .fade-in { animation: fadeIn 2s ease-in-out forwards; }
        @keyframes fadeIn { from { opacity: 0; transform: translateY(20px); } to { opacity: 1; transform: translateY(0); } }
        
        #particles-js { position: fixed; width: 100%; height: 100%; z-index: 5; top: 0; left: 0; pointer-events: none; }
        .content-z { position: relative; z-index: 10; }
        
        /* Cover Transition */
        .cover-slide-up { transform: translate(-50%, -100%) !important; transition: transform 2.5s cubic-bezier(0.645, 0.045, 0.355, 1); }

        /* Bubble Animation */
        .bubble {
            position: absolute;
            border-radius: 50%;
            background: radial-gradient(circle at 30% 30%, rgba(236, 170, 109, 0.2), rgba(236, 170, 109, 0.05));
            backdrop-filter: blur(5px);
            border: 1px solid rgba(236, 170, 109, 0.2);
            animation: float 2s ease-in-out infinite;
            z-index: 1;
        }
        @keyframes float {
            0%, 100% { transform: translateY(0) translateX(0); }
            50% { transform: translateY(-20px) translateX(10px); }
        }

        /* Hide Scrollbar */
        ::-webkit-scrollbar { display: none; }
        * { -ms-overflow-style: none; scrollbar-width: none; }
    </style>
</head>
<body class="bg-[#0a0a0a] antialiased font-sans flex justify-center min-h-screen">

@php
    \Carbon\Carbon::setLocale('id');
    $hero_images = $data['hero_images'] ?? [
        asset('img/hero/WhatsApp%20Image%202026-03-.jpeg'), 
        asset('img/hero/WhatsApp%20Image%202026-03-26%20at%2021.13.32.jpeg'), 
        asset('img/hero/WhatsApp%20Image%202026-03-26%20at%2021.13.33%20(2).jpeg'), 
        asset('img/hero/WhatsApp%20Image%202026-03-26%20at%2021.13.33.jpeg')
    ];
@endphp

<div x-data="{ open: false, isPlaying: false }" :class="open ? '' : 'overflow-hidden h-screen'" class="w-full max-w-[480px] bg-dark relative min-h-screen shadow-[0_0_50px_rgba(0,0,0,0.5)] flex flex-col overflow-x-hidden">

    <!-- Audio Element -->
    <audio id="song" class="idb-audio-el" preload="metadata" playsinline="" loop="">
        <source src="https://inv.nikustory.com/wp-content/uploads/2026/01/i-will-spend-my-whole-life-loving-you-1710382944-29bb2fc20444b1120cb1484d-mp3cut.net_-1-1.mp3" type="audio/mpeg">
    </audio>

    <!-- Floating Music Button -->
    <div x-show="open" class="fixed bottom-6 left-1/2 -translate-x-1/2 z-[100] w-full max-w-[480px] flex justify-end px-6 pointer-events-none">
        <button @click="isPlaying ? document.getElementById('song').pause() : document.getElementById('song').play(); isPlaying = !isPlaying" class="pointer-events-auto w-12 h-12 bg-white/10 backdrop-blur-md rounded-full border border-white/20 flex items-center justify-center text-gold shadow-[0_0_15px_rgba(212,175,55,0.3)] transition-all hover:scale-110">
            <i data-lucide="music" x-show="!isPlaying" class="w-5 h-5"></i>
            <i data-lucide="pause" x-show="isPlaying" class="w-5 h-5"></i>
        </button>
    </div>

    <!-- Cover Page (Sampul) -->
    <div :class="open ? 'cover-slide-up' : ''" class="fixed inset-y-0 left-1/2 -translate-x-1/2 z-[60] w-full max-w-[480px] flex flex-col items-center justify-center text-center px-6 overflow-hidden bg-cover bg-center" 
         :style="'background-image: url(\'{{ $data['cover_image'] ?? ($data['hero_images'][0] ?? 'https://via.placeholder.com/600x800?text=Wedding+Cover') }}\')'">
        <div class="absolute inset-0 bg-black/40"></div>
        <div class="relative z-10 flex flex-col items-center">
            <h1 class="font-poppins text-[#ECAA6D] text-[42px] font-semibold px-4 tracking-[-2.5px] text-transform: capitalize">
                {{ $data['groom']['nickname'] }} & {{ $data['bride']['nickname'] }}
            </h1>
            
            <div class="my-6">
                <p class="text-[13px] text-white tracking-[3.4px]">Dear :</p>
                <p class="text-[17px] py-[2px] font-[500] font-poppins text-white my-4 capitalize italic">{{ request('to', 'Nama Tamu') }}</p>
                <button @click="open = true; isPlaying = true; document.getElementById('song').play(); openFullscreen();" class="rounded-[4px] bg-white text-[#4B4B4B] transition-all duration-500 hover:bg-transparent hover:text-white">
                    <span class="flex text-[13px] font-[500] py-[10px] px-[18px] tracking-[1px] items-center justify-center gap-2">
                        Buka Undangan
                    </span>
                </button>
            </div>

        </div>
    </div>

    <!-- Particles container (placed here to be fixed behind/above content as needed) -->
    <div id="particles-js" x-show="open"></div>

    <!-- Main Content wrapper -->
    <main x-show="open" style="display: none;" class="relative h-screen bg-dark overflow-y-auto scroll-smooth snap-y snap-mandatory">

        <!-- Section 1 : Hero -->
        <section x-data='{ 
                currentSlide: 0, 
                images: @json($data['hero_images'] ?? []),
                init() { 
                    if(this.images.length > 0) {
                        setInterval(() => { this.currentSlide = (this.currentSlide + 1) % this.images.length }, 4000) 
                    }
                } 
            }' 
            class="relative h-screen flex flex-col items-start justify-end px-6 pb-20 text-left snap-start overflow-hidden bg-dark">
            
            <!-- Slideshow -->
            <template x-if="images.length > 0">
                <template x-for="(img, index) in images" :key="index">
                    <div class="hero-slide" 
                         x-show="currentSlide === index"
                         x-transition:enter="transition ease-out duration-[3000ms]"
                         x-transition:enter-start="opacity-0"
                         x-transition:enter-end="opacity-100"
                         x-transition:leave="transition ease-in duration-[3000ms]"
                         x-transition:leave-start="opacity-100"
                         x-transition:leave-end="opacity-0"
                         :style="'background-image: url(\'' + img + '\')'" 
                         class="absolute inset-0 bg-cover bg-center"></div>
                </template>
            </template>
            <!-- Large Bubbles -->
            <div class="bubble w-64 h-64 -top-10 -left-10 opacity-60"></div>
            <div class="bubble w-80 h-80 -bottom-20 -right-10 opacity-40" style="animation-delay: -4s;"></div>
            
            <div class="absolute inset-0 bg-gradient-to-b from-black/20 via-black/40 to-black/80"></div>
            <div class="relative z-10 max-w-2xl content-z">
                <p class="mb-4 shrink-0" data-aos="fade-down" data-aos-delay="400" data-aos-duration="2500" style="font-family: 'proxima-nova-font', Sans-serif; font-size: 13px; font-weight: 400; letter-spacing: 0px; color: #FFFFFF; text-transform: ;">The Wedding Of</p>
                <h2 class="mt-6 mb-8 whitespace-nowrap" data-aos="fade-right" data-aos-delay="800" data-aos-duration="2500" style="font-family: 'Poppins', Sans-serif; font-size: 42px; font-weight: 600; text-transform: capitalize; letter-spacing: -2.5px; color: #ECAA6D; line-height: 1.1; z-index: 5;">
                    {{ $data['groom']['nickname'] }} & {{ $data['bride']['nickname'] }}
                </h2>
                <div class="w-full h-[2px] bg-white my-4" data-aos="zoom-in" data-aos-delay="1200" data-aos-duration="2500"></div>
                <div class="space-y-1 mb-6" data-aos="fade-up" data-aos-delay="1400" data-aos-duration="2500">
                    <p class="text-gold font-poppins font-semibold tracking-[4px] uppercase text-[15px]">
                        {{ !empty($data['event']['date']) ? \Carbon\Carbon::parse($data['event']['date'])->translatedFormat('l, d F Y') : 'MINGGU, 16 AGUSTUS 2026' }}
                    </p>
                    <p class="text-white font-poppins text-[13px] tracking-[2px] opacity-80 uppercase">
                        The Big Day is Coming!
                    </p>
                </div>
                <p class="text-[13px] md:text-base leading-relaxed text-gray-300 font-poppins" data-aos="fade-up" data-aos-delay="1600" data-aos-duration="2500">
                    “Dan segala sesuatu Kami ciptakan berpasang-pasangan agar kamu mengingat (kebesaran Allah).”<br>
                    <span class="text-[13px] text-white font-semibold mt-2 block not-italic">(QS. Az-Zariyat: 49)</span>
                </p>
            </div>
        </section>

        <!-- Section 2 : Profil Mempelai (Groom) -->
        <section class="relative h-screen flex flex-col items-start justify-end px-6 pb-24 text-left snap-start overflow-hidden bg-cover bg-center" 
                 style="background-image: url('{{ $data['groom']['image'] ?? 'https://images.unsplash.com/photo-1507003211169-0a1dd7228f2d?auto=format&fit=crop&q=80' }}')">
            <div class="absolute inset-0 bg-black/60"></div>
            <div class="relative z-10 max-w-2xl content-z">
                <h4 class="mb-4 font-poppins text-[35px] font-semibold capitalize tracking-[-2px] text-white leading-[1.1]" data-aos="fade-right" data-aos-delay="400" data-aos-duration="2500">
                    {{ $data['groom']['name'] }}
                </h4>
                <div class="w-full h-[2px] bg-white my-4" data-aos="fade-right" data-aos-delay="800" data-aos-duration="2500"></div>
                <p class="text-[13px] md:text-base leading-relaxed text-gray-300 font-poppins mb-6" data-aos="fade-right" data-aos-delay="1200" data-aos-duration="2500">
                    {{ $data['groom']['parents'] }}
                </p>
                <a href="{{ $data['groom']['instagram'] ?? '#' }}" class="inline-flex items-center gap-3 text-white/80 hover:text-gold transition-colors font-poppins text-sm tracking-widest uppercase" data-aos="zoom-in" data-aos-delay="1600" data-aos-duration="2500">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="#ECAA6D" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="w-6 h-6"><rect width="20" height="20" x="2" y="2" rx="5" ry="5"/><path d="M16 11.37A4 4 0 1 1 12.63 8 4 4 0 0 1 16 11.37z"/><line x1="17.5" x2="17.51" y1="6.5" y2="6.5"/></svg>
                </a>
            </div>
        </section>

        <!-- Section 2.5 : Profil Mempelai (Bride) -->
        <section class="relative h-screen flex flex-col items-end justify-end px-6 pb-24 text-right snap-start overflow-hidden bg-cover bg-center" 
                 style="background-image: url('{{ $data['bride']['image'] ?? 'https://images.unsplash.com/photo-1494790108377-be9c29b29330?auto=format&fit=crop&q=80' }}')">
            <div class="absolute inset-0 bg-black/60"></div>
            <div class="relative z-10 max-w-2xl content-z">
                <h4 class="mb-4 font-poppins text-[35px] font-semibold capitalize tracking-[-2px] text-white leading-[1.1]" data-aos="fade-left" data-aos-delay="400" data-aos-duration="2500">
                    {{ $data['bride']['name'] }}
                </h4>
                <div class="w-full h-[2px] bg-white my-4" data-aos="fade-left" data-aos-delay="800" data-aos-duration="2500"></div>
                <p class="text-[13px] md:text-base leading-relaxed text-gray-300 font-poppins mb-6" data-aos="fade-left" data-aos-delay="1200" data-aos-duration="2500">
                    {{ $data['bride']['parents'] }}
                </p>
                <a href="{{ $data['bride']['instagram'] ?? '#' }}" class="inline-flex items-center gap-3 text-white/80 hover:text-gold transition-colors font-poppins text-sm tracking-widest uppercase" data-aos="zoom-in" data-aos-delay="1600" data-aos-duration="2500">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="#ECAA6D" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="w-6 h-6"><rect width="20" height="20" x="2" y="2" rx="5" ry="5"/><path d="M16 11.37A4 4 0 1 1 12.63 8 4 4 0 0 1 16 11.37z"/><line x1="17.5" x2="17.51" y1="6.5" y2="6.5"/></svg>
                </a>
            </div>
        </section>

        <!-- Section 2.7 : Our Love Story -->
        <section class="relative min-h-screen flex flex-col items-center justify-center px-6 py-20 snap-start overflow-hidden bg-cover bg-center" 
                 style="background-image: url('{{ $data['story_bg'] ?? ($data['cover_image'] ?? 'https://images.unsplash.com/photo-1519741497674-611481863552?auto=format&fit=crop&q=80') }}')">
            <div class="absolute inset-0 bg-black/75"></div>
            
            <div class="relative z-10 max-w-2xl w-full translate-z">
                <!-- Integrated Title -->
                <div class="text-right mb-12" data-aos="fade-down" data-aos-duration="2500">
                    <div class="inline-block text-right">
                        <h3 class="font-poppins text-[35px] font-semibold capitalize tracking-[-2px] text-gold leading-tight">Our Love Story</h3>
                        <div class="w-full h-[2px] bg-white mt-8 ml-auto" data-aos="zoom-in" data-aos-delay="400" data-aos-duration="2500"></div>
                    </div>
                </div>

                <div class="space-y-8">
                    @if(isset($data['stories']) && count($data['stories']) > 0)
                        @foreach($data['stories'] as $index => $story)
                            <div class="" data-aos="fade-up" data-aos-delay="{{ 800 + ($index * 400) }}" data-aos-duration="2500">
                                <div class="mb-2">
                                    <h4 class="font-poppins text-[15px] font-medium tracking-[0px] text-white">{{ $story['title'] }}</h4>
                                </div>
                                <p class="text-[13px] leading-relaxed text-white font-normal tracking-[0px] text-left opacity-90" style="font-family: 'proxima-nova-font', Sans-serif;">
                                    {{ $story['content'] ?? $story['description'] }}
                                </p>
                            </div>
                        @endforeach
                    @else
                        <!-- Fallback to default stories if none in DB -->
                        <div class="" data-aos="fade-up" data-aos-delay="800" data-aos-duration="2500">
                            <div class="mb-2">
                                <h4 class="font-poppins text-[15px] font-medium tracking-[0px] text-white">Awal Cerita Kita</h4>
                            </div>
                            <p class="text-[13px] leading-relaxed text-white font-normal tracking-[0px] text-left opacity-90" style="font-family: 'proxima-nova-font', Sans-serif;">
                                Kami berkenalan di Jogja, tepat di Malioboro saat senja 14 Mei 2023, ketika hujan rintik membuat kami berteduh di angkringan yang hangat, obrolan tentang lagu jalanan dan cita-cita sederhana pelan-pelan berubah menjadi keberanian untuk saling tumbuh, hingga kata “pulang” terasa identik dengan menyebut nama yang sama.
                            </p>
                        </div>

                        <div class="" data-aos="fade-up" data-aos-delay="1200" data-aos-duration="2500">
                            <div class="mb-2">
                                <h4 class="font-poppins text-[15px] font-medium tracking-[0px] text-white">Lamaran</h4>
                            </div>
                            <p class="text-[13px] leading-relaxed text-white font-normal tracking-[0px] text-left opacity-90" style="font-family: 'proxima-nova-font', Sans-serif;">
                                Pada 3 Februari 2025, dalam khitbah sederhana di rumah dengan tawa keluarga, aroma teh hangat, dan doa yang khusyuk, ia menyampaikan niat memuliakan, cincin disematkan, restu dipeluk, dan kami sepakat menjaga yang halal sambil menata langkah-langkah ke depan dengan syukur yang tidak putus.
                            </p>
                        </div>

                        <div class="" data-aos="fade-up" data-aos-delay="1600" data-aos-duration="2500">
                            <div class="mb-2">
                                <h4 class="font-poppins text-[15px] font-medium tracking-[0px] text-white">Pernikahan</h4>
                            </div>
                            <p class="text-[13px] leading-relaxed text-white font-normal tracking-[0px] text-left opacity-90" style="font-family: 'proxima-nova-font', Sans-serif;">
                                Bismillah, 16 Agustus 2026 di Yogyakarta kami mengikat janji suci disaksikan orang tua dan sahabat, memohon rahmat Allah agar hari-hari setelahnya menjadi ruang belajar untuk saling menguatkan dan mengasihi, membangun rumah yang tenang, hangat, dan selalu kembali pada doa.
                            </p>
                        </div>
                    @endif
                </div>
            </div>
        </section>

        <!-- Section 3 : Detil Acara -->
        <section class="relative min-h-screen flex flex-col items-center justify-start py-20 px-6 snap-start overflow-hidden bg-cover bg-center" 
                 style="background-image: url('{{ $data['event_bg'] ?? ($data['cover_image'] ?? 'https://images.unsplash.com/photo-1511285560929-80b456fea0bc?auto=format&fit=crop&q=80') }}')">
            <div class="absolute inset-0 bg-black/80"></div>
            
            <div class="relative z-10 w-full max-w-2xl translate-z" data-aos="fade-up">
                <!-- Save The Date -->
                <div class="text-center mb-10" data-aos="fade-down" data-aos-duration="2500">
                    <div class="inline-block">
                        <h3 class="font-poppins text-[35px] font-semibold capitalize tracking-[-2px] text-gold leading-tight">Save The Date</h3>
                        <div class="w-full h-[2px] bg-white my-6 mx-auto" data-aos="zoom-in" data-aos-delay="400" data-aos-duration="2500"></div>
                    </div>

                    <!-- Countdown -->
                    <div class="grid grid-cols-4 gap-4 font-poppins text-white" data-aos="fade-up" data-aos-delay="800" data-aos-duration="2500" x-data="{
                        days: 0, hours: 0, minutes: 0, seconds: 0,
                        target: new Date('{{ $data['event']['date'] ?? '2026-08-16' }} {{ $data['event']['time_akad'] ?? '08:00' }}').getTime(),
                        init() {
                            setInterval(() => {
                                let now = new Date().getTime();
                                let diff = this.target - now;
                                if (diff > 0) {
                                    this.days = Math.floor(diff / (1000 * 60 * 60 * 24));
                                    this.hours = Math.floor((diff % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
                                    this.minutes = Math.floor((diff % (1000 * 60 * 60)) / (1000 * 60));
                                    this.seconds = Math.floor((diff % (1000 * 60)) / 1000);
                                } else {
                                    this.days = 0; this.hours = 0; this.minutes = 0; this.seconds = 0;
                                }
                            }, 1000);
                        }
                    }">
                        <div class="text-center">
                            <span class="text-[30px] font-normal block" x-text="days">0</span>
                            <span class="text-[10px] uppercase tracking-widest opacity-80">Hari</span>
                        </div>
                        <div class="text-center">
                            <span class="text-[30px] font-normal block" x-text="hours">0</span>
                            <span class="text-[10px] uppercase tracking-widest opacity-80">Jam</span>
                        </div>
                        <div class="text-center">
                            <span class="text-[30px] font-normal block" x-text="minutes">0</span>
                            <span class="text-[10px] uppercase tracking-widest opacity-80">Menit</span>
                        </div>
                        <div class="text-center">
                            <span class="text-[30px] font-normal block" x-text="seconds">0</span>
                            <span class="text-[10px] uppercase tracking-widest opacity-80">Detik</span>
                        </div>
                    </div>
                </div>

                <!-- Event Details Section -->
                <div class="space-y-16">
                    <!-- Akad Nikah -->
                    <div class="text-left" data-aos="fade-right" data-aos-delay="1200" data-aos-duration="2500">
                        <div class="inline-block mb-0">
                            <h4 class="font-poppins text-[35px] font-semibold capitalize tracking-[-2px] text-gold leading-tight">Akad Nikah</h4>
                            <div class="w-1/2 h-[2px] bg-white my-6"></div>
                        </div>
                        <div class="font-poppins text-white space-y-2">
                            <p class="font-bold tracking-widest uppercase text-sm font-poppins">{{ !empty($data['event']['date_akad']) ? \Carbon\Carbon::parse($data['event']['date_akad'])->translatedFormat('l, d F Y') : (!empty($data['event']['date']) ? \Carbon\Carbon::parse($data['event']['date'])->translatedFormat('l, d F Y') : 'MINGGU, 16 AGUSTUS 2026') }}</p>
                            <p class="text-xs opacity-80">PUKUL : {{ $data['event']['time_akad'] ?? '08:00' }} WIB</p>
                            <div class="pt-4">
                                <p class="text-[13px] font-medium">Tempat : <span class="font-bold">{{ $data['event']['location_akad_name'] ?? ($data['event']['location'] ?? 'Kediaman Mempelai Wanita') }}</span></p>
                                <p class="text-[12px] opacity-85 leading-relaxed">{{ $data['event']['location_akad_detail'] ?? ($data['event']['address'] ?? 'Ds Pagu, Wates, Kediri, Jawa Timur') }}</p>
                            </div>
                            <a href="{{ $data['event']['maps_akad'] ?? ($data['event']['google_maps_link'] ?? '#') }}" 
                               class="inline-flex items-center gap-2 bg-white/10 backdrop-blur-md px-4 py-2 rounded-full border border-white/20 text-xs font-poppins mt-4 hover:bg-white/20 transition-all">
                                <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="text-gold"><path d="M20 10c0 6-8 12-8 12s-8-6-8-12a8 8 0 0 1 16 0Z"/><circle cx="12" cy="10" r="3"/></svg> Lokasi Acara
                            </a>
                        </div>
                    </div>

                    <!-- Resepsi -->
                    <div class="text-right" data-aos="fade-left" data-aos-delay="1600" data-aos-duration="2500">
                        <div class="inline-block mb-0">
                            <h4 class="font-poppins text-[35px] font-semibold capitalize tracking-[-2px] text-gold leading-tight">Resepsi</h4>
                            <div class="w-1/2 h-[2px] bg-white my-6 ml-auto"></div>
                        </div>
                        <div class="font-poppins text-white space-y-2">
                            <p class="font-bold tracking-widest uppercase text-sm font-poppins">{{ !empty($data['event']['date_resepsi']) ? \Carbon\Carbon::parse($data['event']['date_resepsi'])->translatedFormat('l, d F Y') : (!empty($data['event']['date']) ? \Carbon\Carbon::parse($data['event']['date'])->translatedFormat('l, d F Y') : 'SABTU, 01 AGUSTUS 2026') }}</p>
                            <p class="text-xs opacity-80">PUKUL : {{ $data['event']['time_resepsi'] ?? '10:00' }} WIB - SELESAI</p>
                            <div class="pt-4 text-right">
                                <p class="text-[13px] font-medium">Tempat : <span class="font-bold">{{ $data['event']['location_resepsi_name'] ?? ($data['event']['location'] ?? 'Kediaman Mempelai Wanita') }}</span></p>
                                <p class="text-[12px] opacity-85 leading-relaxed text-right">{{ $data['event']['location_resepsi_detail'] ?? ($data['event']['address'] ?? 'Ds Pagu, Wates, Kediri, Jawa Timur') }}</p>
                            </div>
                            <a href="{{ $data['event']['maps_resepsi'] ?? ($data['event']['google_maps_link'] ?? '#') }}" 
                               class="inline-flex items-center gap-2 bg-white/10 backdrop-blur-md px-4 py-2 rounded-full border border-white/20 text-xs font-poppins mt-4 hover:bg-white/20 transition-all">
                                <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="text-gold"><path d="M20 10c0 6-8 12-8 12s-8-6-8-12a8 8 0 0 1 16 0Z"/><circle cx="12" cy="10" r="3"/></svg> Lokasi Acara
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Section 4 : Our Gallery -->
        <section class="min-h-screen flex flex-col justify-start pt-24 pb-12 px-6 relative z-10 bg-[#0a0a0a]/80 snap-start content-z">
            <!-- Background Gallery (Blurred) -->
            <div class="absolute inset-0 z-0 opacity-20 blur-xl scale-110 pointer-events-none">
                <img src="{{ $data['cover_image'] ?? ($data['gallery'][0] ?? 'https://via.placeholder.com/600x800') }}" class="w-full h-full object-cover">
            </div>

            <div class="max-w-2xl mx-auto w-full relative z-10 text-center">
                <div class="inline-block mb-10" data-aos="fade-down" data-aos-duration="2500">
                    <h3 class="font-poppins text-[35px] font-semibold capitalize tracking-[-2px] text-gold leading-tight">Our Gallery</h3>
                    <div class="w-full h-[2px] bg-white mt-8 mx-auto" data-aos="zoom-in" data-aos-delay="400" data-aos-duration="2500"></div>
                </div>

                <!-- Grid Gallery -->
                <div class="grid grid-cols-3 gap-1 md:gap-2" data-aos="fade-up" data-aos-delay="800" data-aos-duration="2500">
                    @php
                        $gallery_images = $data['gallery'] ?? [
                            asset('img/hero/WhatsApp%20Image%202026-03-.jpeg'), 
                            asset('img/hero/WhatsApp%20Image%202026-03-26%20at%2021.13.32.jpeg'), 
                            asset('img/hero/WhatsApp%20Image%202026-03-26%20at%2021.13.33%20(2).jpeg'), 
                            asset('img/hero/WhatsApp%20Image%202026-03-26%20at%2021.13.33.jpeg'),
                            asset('img/hero/WhatsApp%20Image%202026-03-.jpeg'), 
                            asset('img/hero/WhatsApp%20Image%202026-03-26%20at%2021.13.32.jpeg'), 
                            asset('img/hero/WhatsApp%20Image%202026-03-26%20at%2021.13.33%20(2).jpeg'), 
                            asset('img/hero/WhatsApp%20Image%202026-03-26%20at%2021.13.33.jpeg'),
                            asset('img/hero/WhatsApp%20Image%202026-03-.jpeg')
                        ];
                    @endphp

                    @foreach($gallery_images as $index => $image)
                        <div class="aspect-square overflow-hidden group cursor-pointer" 
                             onclick="window.open('{{ $image }}', '_blank')">
                            <img src="{{ $image }}" alt="Gallery" class="w-full h-full object-cover transition-transform duration-1000 group-hover:scale-110">
                        </div>
                    @endforeach
                </div>
            </div>
        </section>



        <!-- Section 6 : Wedding Gift -->
        <section class="flex flex-col items-center px-6 relative z-10 bg-cover bg-center snap-start content-z transition-all duration-1000" 
                 style="background-image: url('{{ $data['cover_image'] ?? 'https://via.placeholder.com/600x800' }}')"
                 x-data="{ showGifts: false }"
                 :class="showGifts ? 'min-h-screen py-20' : 'h-screen'">
            <div class="absolute inset-0 bg-black/75 backdrop-blur-sm"></div>

            <!-- Top Spacer -->
            <div class="transition-all ease-in-out" 
                 style="transition-duration: 2000ms"
                 :class="showGifts ? 'h-20 flex-none' : 'flex-1'"></div>
            
            <div class="relative z-10 max-w-2xl mx-auto w-full text-center group">
                <div class="inline-block w-full transition-all" style="transition-duration: 2000ms;">
                    <h3 class="font-poppins text-[35px] font-semibold capitalize tracking-[-2px] text-gold leading-tight" data-aos="fade-down" data-aos-duration="2500">Wedding Gift</h3>
                    <div class="w-full h-[1px] bg-white/50 mt-6 mb-8" data-aos="zoom-in" data-aos-delay="400" data-aos-duration="2500"></div>
                    <p class="text-[13px] text-white/90 font-poppins leading-relaxed mb-8 px-4" data-aos="fade-up" data-aos-delay="800" data-aos-duration="2500">
                        Bagi Bapak/Ibu/Saudara/i yang ingin mengirimkan hadiah pernikahan dapat melalui virtual account atau e-wallet di bawah ini:
                    </p>
                    <button @click="showGifts = !showGifts" 
                            data-aos="zoom-in" data-aos-delay="1200" data-aos-duration="2500"
                            class="inline-flex items-center gap-2 bg-white/10 backdrop-blur-md px-8 py-3 rounded-full border border-white/20 text-xs font-poppins text-white hover:bg-white/20 transition-all uppercase tracking-widest shadow-xl">
                        <i data-lucide="gift" class="w-4 h-4"></i> 
                        <span x-text="showGifts ? 'Tutup Detail' : 'Kirim Hadiah'"></span>
                    </button>
                </div>

                <div x-show="showGifts" 
                     x-transition:enter="transition ease-out duration-700 delay-300"
                     x-transition:enter-start="opacity-0 translate-y-10"
                     x-transition:enter-end="opacity-100 translate-y-0"
                     class="space-y-6 mt-12">

                    @if(isset($data['gifts']) && count($data['gifts']) > 0)
                        @foreach($data['gifts'] as $gift)
                            <div class="bg-white/95 rounded-[30px] p-8 text-left shadow-2xl relative overflow-hidden group">
                                <div class="flex justify-between items-start mb-12">
                                    <div class="w-12 h-10 bg-gray-200 rounded-md flex items-center justify-center">
                                        <div class="w-8 h-6 bg-amber-400/50 rounded"></div>
                                    </div>
                                    <div class="text-blue-900 font-bold italic text-xl flex items-center gap-2 uppercase">
                                        {{ $gift['bank_name'] }}
                                    </div>
                                </div>
                                <div class="space-y-1">
                                    <p class="text-2xl font-poppins font-semibold text-gray-800 tracking-wider mb-2">{{ $gift['account_number'] }}</p>
                                    <p class="text-sm font-poppins font-medium text-gray-500 uppercase tracking-widest">{{ $gift['account_name'] }}</p>
                                </div>
                                <button x-data="{ copied: false }" 
                                        @click="navigator.clipboard.writeText('{{ $gift['account_number'] }}'); copied = true; setTimeout(() => copied = false, 2000)"
                                        class="absolute bottom-6 right-6 flex items-center gap-2 px-4 py-2 rounded-xl text-[11px] font-bold transition-all shadow-sm min-w-[80px] justify-center"
                                        :class="copied ? 'bg-green-600 text-white' : 'bg-gray-100 text-gray-700 hover:bg-gold hover:text-white'">
                                    <i data-lucide="copy" class="w-3 h-3" x-show="!copied"></i> 
                                    <i data-lucide="check" class="w-3 h-3" x-show="copied"></i>
                                    <span x-text="copied ? 'Copied!' : 'Copy'"></span>
                                </button>
                            </div>
                        @endforeach
                    @else
                        <!-- Placeholder Cards -->
                        <div class="bg-white/95 rounded-[30px] p-8 text-left shadow-2xl relative overflow-hidden">
                            <div class="flex justify-between items-start mb-12">
                                <div class="w-12 h-10 bg-gray-200 rounded-md flex items-center justify-center">
                                    <div class="w-8 h-6 bg-amber-400/50 rounded"></div>
                                </div>
                                <img src="https://upload.wikimedia.org/wikipedia/commons/5/5c/Bank_Central_Asia.svg" class="h-6 opacity-80" alt="BCA">
                            </div>
                            <div class="space-y-1">
                                <p class="text-2xl font-poppins font-semibold text-gray-800 tracking-wider mb-2">23213123</p>
                                <p class="text-sm font-poppins font-medium text-gray-500 uppercase tracking-widest">ADIBA PUTRI</p>
                            </div>
                            <button x-data="{ copied: false }" 
                                    @click="navigator.clipboard.writeText('23213123'); copied = true; setTimeout(() => copied = false, 2000)"
                                    class="absolute bottom-6 right-6 flex items-center gap-2 px-4 py-2 rounded-xl text-[11px] font-bold transition-all shadow-sm min-w-[80px] justify-center"
                                    :class="copied ? 'bg-blue-600 text-white' : 'bg-gray-100 text-gray-700 hover:bg-blue-900 hover:text-white'">
                                <i data-lucide="copy" class="w-3 h-3" x-show="!copied"></i>
                                <span x-text="copied ? 'Copied!' : 'Copy'"></span>
                            </button>
                        </div>
                    @endif

                    <!-- Physical Gift Card (Hadiah Fisik) -->
                    @if(!empty($data['event']['recipient_address']))
                        <div class="bg-white/95 rounded-[30px] p-8 text-left shadow-2xl relative overflow-hidden group border-2 border-dashed border-purple-200">
                            <div class="flex justify-between items-start mb-8">
                                <div class="w-12 h-12 bg-purple-50 rounded-2xl flex items-center justify-center text-purple-600">
                                    <i data-lucide="gift" class="w-6 h-6"></i>
                                </div>
                                <div class="text-purple-900 font-bold italic text-sm flex items-center gap-2 uppercase tracking-tighter bg-purple-50 px-3 py-1 rounded-full">
                                    Kirim Hadiah Fisik
                                </div>
                            </div>
                            <div class="space-y-4">
                                <div>
                                    <p class="text-[10px] font-bold text-gray-400 uppercase tracking-widest mb-1">Penerima</p>
                                    <p class="text-lg font-poppins font-semibold text-gray-800">{{ $data['event']['recipient_name'] ?? 'Mempelai' }}</p>
                                    <p class="text-xs text-gray-500">{{ $data['event']['recipient_phone'] ?? '' }}</p>
                                </div>
                                <div>
                                    <p class="text-[10px] font-bold text-gray-400 uppercase tracking-widest mb-1">Alamat Pengiriman</p>
                                    <p class="text-sm font-poppins text-gray-600 leading-relaxed italic">
                                        {{ $data['event']['recipient_address'] }}
                                    </p>
                                </div>
                            </div>
                            <button x-data="{ copied: false }" 
                                    @click="navigator.clipboard.writeText('{{ $data['event']['recipient_address'] }}'); copied = true; setTimeout(() => copied = false, 2000)"
                                    class="mt-6 w-full flex items-center gap-2 px-4 py-3 rounded-xl text-xs font-bold transition-all shadow-sm justify-center border border-purple-100"
                                    :class="copied ? 'bg-green-600 text-white' : 'bg-purple-50 text-purple-700 hover:bg-purple-600 hover:text-white'">
                                <i data-lucide="copy" class="w-4 h-4" x-show="!copied"></i>
                                <span x-text="copied ? 'Alamat Tersalin!' : 'Salin Alamat'"></span>
                            </button>
                        </div>
                    @endif

                </div>
            </div>

            <!-- Bottom Spacer -->
            <div class="transition-all ease-in-out overflow-hidden" 
                 style="transition-duration: 2000ms"
                 :class="showGifts ? 'h-0 flex-none' : 'flex-1'"></div>
        </section>

        <!-- Section 7 : RSVP & Guestbook -->
        <section class="min-h-screen flex flex-col justify-center py-20 px-6 relative z-10 bg-cover bg-center snap-start content-z"
                 style="background-image: url('{{ $data['rsvp_bg'] ?? ($data['cover_image'] ?? 'https://images.unsplash.com/photo-1469334031218-e382a71b716b?auto=format&fit=crop&q=80') }}')"
                 x-data='{ 
                    sending: false, 
                    success: false, 
                    name: "", 
                    status: "", 
                    message: "",
                    wishes: {!! json_encode($invitation->rsvps()->latest()->get()->map(function($rsvp) {
                        return [
                            'name' => $rsvp->name,
                            'status' => $rsvp->status,
                            'message' => $rsvp->message,
                            'reply' => $rsvp->reply,
                            'time' => $rsvp->created_at->diffForHumans()
                        ];
                    })) !!}
                 }'>
            <div class="absolute inset-0 bg-black/75 backdrop-blur-sm"></div>
            
            <div class="max-w-2xl mx-auto w-full relative z-10 transition-all duration-1000">
                <div class="text-center mb-12">
                    <div class="inline-block" data-aos="fade-down" data-aos-duration="2500">
                        <h3 class="font-poppins text-[35px] font-semibold capitalize tracking-[-2px] text-gold leading-tight">Konfirmasi Kehadiran</h3>
                        <div class="w-full h-[2px] bg-white my-6 mx-auto" data-aos="zoom-in" data-aos-delay="400" data-aos-duration="2500"></div>
                    </div>
                    <p class="text-[13px] text-white/80 font-poppins" data-aos="fade-up" data-aos-delay="800" data-aos-duration="2500">Mohon konfirmasi kehadiran Anda melalui form di bawah ini:</p>
                </div>

                <div class="space-y-6">
                    <!-- RSVP Form -->
                    <div x-show="success" 
                         x-transition:enter="transition ease-out duration-500"
                         x-transition:enter-start="opacity-0 scale-95"
                         x-transition:enter-end="opacity-100 scale-100"
                         class="bg-gold/10 backdrop-blur-xl p-10 rounded-[2.5rem] border border-gold/30 text-center shadow-2xl">
                        <div class="w-16 h-16 bg-gold rounded-full flex items-center justify-center mx-auto mb-6 text-dark shadow-[0_0_20px_rgba(212,175,55,0.4)]">
                            <i data-lucide="check-circle-2" class="w-10 h-10"></i>
                        </div>
                        <h4 class="text-white font-poppins font-bold text-2xl mb-2">Terima Kasih!</h4>
                        <p class="text-white/60 text-sm max-w-[280px] mx-auto leading-relaxed">Pesan dan doa restu Anda telah masuk ke dalam daftar tamu kami.</p>
                        <button @click="success = false; name=''; status=''; message=''" class="mt-8 bg-white/10 hover:bg-white/20 text-white text-xs font-bold uppercase tracking-[3px] px-8 py-3 rounded-full border border-white/20 transition-all">Kirim Pesan Lainnya</button>
                    </div>

                    <form x-show="!success" 
                          data-aos="fade-up" data-aos-delay="1200" data-aos-duration="2500"
                          @submit.prevent="
                            sending = true;
                            fetch('{{ route('rsvp.store', $invitation->slug) }}', {
                                method: 'POST',
                                headers: {
                                    'Content-Type': 'application/json',
                                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                                    'X-Requested-With': 'XMLHttpRequest'
                                },
                                body: JSON.stringify({ name, status, message })
                            })
                            .then(res => res.json())
                            .then(data => {
                                wishes.unshift({ name, status, message, reply: null, time: 'Baru saja' });
                                success = true;
                                sending = false;
                            })
                            .catch(err => {
                                sending = false;
                                alert('Maaf, terjadi kesalahan saat mengirim pesan.');
                            })
                          "
                          class="space-y-5 bg-white/5 p-8 rounded-[2.5rem] border border-white/10 backdrop-blur-md shadow-2xl">
                        
                        <div class="space-y-4">
                            <div class="relative group">
                                <span class="absolute left-4 top-3.5 text-gold/50 group-focus-within:text-gold transition-colors"><i data-lucide="user" class="w-4 h-4"></i></span>
                                <input type="text" x-model="name" required placeholder="Nama Lengkap" class="w-full bg-white/5 border border-white/10 rounded-2xl pl-11 pr-4 py-3.5 text-sm text-white placeholder:text-gray-500 focus:border-gold outline-none transition-all focus:bg-white/10 font-poppins">
                            </div>

                            <div class="relative group">
                                <span class="absolute left-4 top-3.5 text-gold/50 group-focus-within:text-gold transition-colors"><i data-lucide="user-check" class="w-4 h-4"></i></span>
                                <select x-model="status" required class="w-full bg-white/5 border border-white/10 rounded-2xl pl-11 pr-4 py-3.5 text-sm text-white focus:border-gold outline-none transition-all focus:bg-white/10 font-poppins appearance-none">
                                    <option value="" class="bg-[#1a1a1a]">Konfirmasi Kehadiran</option>
                                    <option value="Hadir" class="bg-[#1a1a1a]">Hadir</option>
                                    <option value="Tidak Hadir" class="bg-[#1a1a1a]">Tidak Hadir</option>
                                </select>
                            </div>

                            <div class="relative group">
                                <textarea x-model="message" placeholder="Tulis doa atau pesan spesial untuk mempelai..." rows="4" class="w-full bg-white/5 border border-white/10 rounded-2xl px-5 py-4 text-sm text-white placeholder:text-gray-500 focus:border-gold outline-none transition-all focus:bg-white/10 font-poppins leading-relaxed"></textarea>
                            </div>
                        </div>

                        <button type="submit" 
                                :disabled="sending"
                                class="w-full bg-gold text-dark font-black py-4 rounded-2xl hover:brightness-110 active:scale-[0.98] transition-all text-xs uppercase tracking-[4px] shadow-[0_10px_25px_rgba(212,175,55,0.3)] flex items-center justify-center gap-3 disabled:opacity-50 group">
                            <span x-show="!sending" class="flex items-center gap-3">
                                Kirim Doa Restu <i data-lucide="sparkles" class="w-5 h-5 transition-transform group-hover:rotate-12 group-hover:scale-110"></i>
                            </span>
                            <span x-show="sending" class="flex items-center gap-3">
                                <svg class="animate-spin h-5 w-5 text-dark" viewBox="0 0 24 24">
                                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                                </svg> Sedang Mengirim...
                            </span>
                        </button>
                    </form>

                    <!-- Wishes List -->
                    <div class="mt-20" data-aos="fade-up" data-aos-delay="1600" data-aos-duration="2500">
                        <div class="flex items-center justify-between mb-8 pb-4 border-b border-white/10">
                            <h4 class="text-white font-poppins font-bold text-xl flex items-center gap-3">
                                <span class="bg-gold/20 text-gold p-2 rounded-lg"><i data-lucide="message-circle" class="w-5 h-5"></i></span> 
                                Ucapan & Doa
                            </h4>
                            <div class="px-4 py-1.5 rounded-full bg-white/5 border border-white/10 text-[10px] text-white/50 font-bold uppercase tracking-widest"><span x-text="wishes.length"></span> Tamu</div>
                        </div>

                        <div class="grid grid-cols-1 gap-6 max-h-[500px] overflow-y-auto pr-4 custom-scrollbar lg:pr-8">
                            <template x-for="(wish, index) in wishes" :key="index">
                                <div class="bg-white/5 backdrop-blur-xl p-6 rounded-[2rem] border border-white/10 group hover:border-gold/30 transition-all duration-500 shadow-xl relative overflow-hidden">
                                    <!-- Subtle Decoration -->
                                    <div class="absolute -top-4 -right-4 w-12 h-12 bg-gold/5 rounded-full blur-xl group-hover:bg-gold/10 transition-all"></div>
                                    
                                    <div class="flex justify-between items-start mb-4">
                                        <div class="flex items-center gap-3">
                                            <div class="w-10 h-10 bg-white/10 rounded-xl flex items-center justify-center font-bold text-gold text-sm border border-white/10" x-text="wish.name.charAt(0)"></div>
                                            <div>
                                                <p class="text-gold font-bold text-sm tracking-tight" x-text="wish.name"></p>
                                                <p class="text-[9px] text-white/30 uppercase tracking-widest mt-0.5" x-text="wish.time"></p>
                                            </div>
                                        </div>
                                        <span class="text-[9px] px-3 py-1 rounded-full font-black uppercase tracking-tighter" 
                                              :class="wish.status == 'Hadir' ? 'bg-emerald-500/20 text-emerald-400 border border-emerald-500/30' : 'bg-white/10 text-white/40 border border-white/10'"
                                              x-text="wish.status">
                                        </span>
                                    </div>
                                    
                                    <div class="relative">
                                        <i data-lucide="quote" class="absolute -top-1 -left-1 w-8 h-8 text-white/5 -z-10 rotate-12"></i>
                                        <p class="text-white/80 text-[13px] leading-relaxed italic pl-2" x-text="wish.message || 'Semoga berbahagia selalu!'"></p>
                                    </div>
                                    
                                    <!-- Host Reply -->
                                    <div x-show="wish.reply" class="mt-6 bg-gold/5 p-4 rounded-2xl border-l-[3px] border-gold shadow-inner">
                                        <div class="flex items-center gap-2 mb-2">
                                            <span class="w-1.5 h-1.5 bg-gold rounded-full shadow-[0_0_5px_#d4af37]"></span>
                                            <p class="text-gold font-black text-[9px] uppercase tracking-[2px]">Balasan Mempelai</p>
                                        </div>
                                        <p class="text-white/70 text-[12px] italic leading-relaxed" x-text="wish.reply"></p>
                                    </div>
                                </div>
                            </template>
                            
                            <div x-show="wishes.length === 0" class="text-center py-20 bg-white/5 rounded-[2rem] border-2 border-dashed border-white/10 opacity-30">
                                <i data-lucide="mail-open" class="w-12 h-12 mx-auto mb-4"></i>
                                <p class="text-sm font-medium">Jadilah yang pertama mengucapkan selamat!</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Section 8 : Closing -->
        <section class="h-screen relative overflow-hidden flex flex-col items-center justify-center snap-start" 
                 x-data='{ 
                    currentSlide: 0, 
                    images: @json($hero_images),
                    init() { 
                        if (this.images.length > 1) {
                            setInterval(() => { this.currentSlide = (this.currentSlide + 1) % this.images.length }, 5000) 
                        }
                    } 
                 }'>
            
            <!-- Background Slideshow (Match Section 1 pattern) -->
            <template x-for="(img, index) in images" :key="index">
                <div class="absolute inset-0 bg-cover bg-center transition-opacity duration-[3000ms] ease-in-out" 
                     x-show="currentSlide === index"
                     x-transition:enter="transition ease-out duration-[3000ms]"
                     x-transition:enter-start="opacity-0"
                     x-transition:enter-end="opacity-100"
                     x-transition:leave="transition ease-in duration-[3000ms]"
                     x-transition:leave-start="opacity-100"
                     x-transition:leave-end="opacity-0"
                     :style="'background-image: url(\'' + img + '\')'">
                    <div class="absolute inset-0 bg-black/65"></div>
                </div>
            </template>

            <!-- Content -->
            <div class="relative z-20 text-center px-8 flex flex-col items-center max-w-lg">
                <h4 class="text-white font-poppins font-bold text-base uppercase tracking-[4px] mb-6" data-aos="fade-down" data-aos-duration="2500">Terima Kasih</h4>
                <p class="text-white/80 text-[13px] leading-relaxed mb-8 font-poppins font-light" data-aos="fade-up" data-aos-delay="500" data-aos-duration="2500">
                    Merupakan suatu kebahagiaan bagi kami jika Anda berkenan hadir di hari bahagia ini. Terima kasih atas segala ucapan, doa, dan perhatian yang diberikan. Sampai jumpa di hari pernikahan kami!
                </p>
                
                <div class="flex flex-col items-center gap-1 mb-8" data-aos="zoom-in" data-aos-delay="1000" data-aos-duration="2500">
                    <span class="text-gold font-poppins text-xl font-semibold tracking-tighter">{{ $data['groom']['nickname'] }} & {{ $data['bride']['nickname'] }}</span>
                    <div class="w-12 h-0.5 bg-white/30"></div>
                </div>
                
                <div class="text-[10px] text-white/40 tracking-[2px] uppercase" data-aos="fade-up" data-aos-delay="1500" data-aos-duration="2500">
                    Made with ❤️ by ilysmzb
                </div>
            </div>
        </section>
    </main>
</div>

    <!-- Particles JS Script -->
    <script src="https://cdn.jsdelivr.net/particles.js/2.0.0/particles.min.js"></script> 
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Particles JS
            particlesJS("particles-js", {
                "particles": {
                    "number": { "value": 15, "density": { "enable": true, "value_area": 800 } },
                    "color": { "value": "#ECAA6D" },
                    "shape": { "type": "circle" },
                    "opacity": { 
                        "value": 0.3, 
                        "random": true, 
                        "anim": { "enable": true, "speed": 0.5, "opacity_min": 0.1, "sync": false } 
                    },
                    "size": { 
                        "value": 35, 
                        "random": true, 
                        "anim": { "enable": true, "speed": 2, "size_min": 10, "sync": false } 
                    },
                    "line_linked": { "enable": false },
                    "move": { 
                        "enable": true, 
                        "speed": 0.8, 
                        "direction": "top", 
                        "random": true, 
                        "straight": false, 
                        "out_mode": "out", 
                        "bounce": false 
                    }
                },
                "interactivity": {
                    "events": { "onhover": { "enable": false }, "onclick": { "enable": false } }
                },
                "retina_detect": true
            });

            // Initialize Lucide
            lucide.createIcons();

            // Initialize AOS with ultra-smooth settings
            AOS.init({
                duration: 2500,
                easing: 'ease-out-quart',
                once: false,
                mirror: true
            });

            // Sync AOS with Scroll Snapping
            const mainScroller = document.querySelector('main');
            if (mainScroller) {
                mainScroller.addEventListener('scroll', () => {
                    AOS.refresh();
                }, { passive: true });
            }
        });
    </script>
    <script>
        function openFullscreen() {
            // Non-aktifkan fullscreen jika sedang di dalam iframe (Dashboard Preview)
            if (window.self !== window.top) return;
            
            let elem = document.documentElement;
            if (elem.requestFullscreen) {
                elem.requestFullscreen().catch(err => console.log(err));
            } else if (elem.webkitRequestFullscreen) { /* Safari */
                elem.webkitRequestFullscreen();
            } else if (elem.msRequestFullscreen) { /* IE11 */
                elem.msRequestFullscreen();
            }
        }
        function openMap(url) {
            const isMobile = /iPhone|iPad|iPod|Android/i.test(navigator.userAgent);
            if (isMobile) {
                window.location.href = url;
            } else {
                window.open(url, '_blank');
            }
        }
    </script>
    <script>lucide.createIcons();</script>
</body>
</html>
