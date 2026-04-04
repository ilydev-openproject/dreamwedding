<!DOCTYPE html>
<html lang="id" class="scroll-smooth">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>The Wedding of Arumi & Rendy</title>
    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    <!-- Alpine.js -->
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <!-- Lucide Icons -->
    <script src="https://unpkg.com/lucide@latest"></script>
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Cinzel:wght@400;600;700&family=Great+Vibes&family=Montserrat:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <style>
        .font-cinzel { font-family: 'Cinzel', serif; }
        .font-script { font-family: 'Great Vibes', cursive; font-size: 1.25em; }
        .font-montserrat { font-family: 'Montserrat', sans-serif; }
        
        .text-accent { color: #31626c; }
        .bg-accent { background-color: #31626c; }
        .border-accent { border-color: #31626c; }
        
        .bg-forest {
            background-image: linear-gradient(rgba(255,255,255,0.85), rgba(255,255,255,0.9)), url('https://images.unsplash.com/photo-1505236858219-8359eb29e325?auto=format&fit=crop&q=80&w=800');
            background-size: cover;
            background-position: center;
            background-attachment: fixed;
        }

        /* Alpine Slide Up Transition */
        .slide-up-leave-active { transition: all 1.5s cubic-bezier(0.77, 0, 0.175, 1); }
        .slide-up-leave-top { transform: translateY(-120%); opacity: 0; }
        
        [x-cloak] { display: none !important; }
        #particles-js { position: absolute; width: 100%; height: 100%; z-index: 0; top: 0; left: 0; pointer-events: none; }
    </style>
</head>
<body class="antialiased bg-gray-100 flex justify-center w-full min-h-screen">

    <!-- Desktop Container constraints to Mobile View (480px) -->
    <div x-data="invitationData()" class="w-full lg:w-[480px] h-[100dvh] bg-white relative overflow-x-hidden lg:shadow-2xl font-montserrat bg-forest" style="transform: translateZ(0);">
        
        <!-- COVER PAGE OVERLAY -->
        <div x-show="!isOpen" 
             x-transition:leave="slide-up-leave-active"
             x-transition:leave-start="transform translateY(0); opacity: 1;"
             x-transition:leave-end="slide-up-leave-top"
             class="absolute inset-0 z-50 flex flex-col items-center justify-center bg-white bg-forest">
             
            <div class="relative z-10 text-center px-6 flex flex-col items-center">
                
                <!-- Circle Frame -->
                <div class="w-40 h-40 sm:w-48 sm:h-48 border border-[#7a7a7a]/40 rounded-full flex items-center justify-center mb-8 p-2">
                    <div class="w-full h-full border border-[#31626c]/30 rounded-full flex items-center justify-center bg-white/50 backdrop-blur-sm">
                        <div class="text-center">
                            <p class="text-[10px] tracking-widest uppercase font-montserrat text-gray-500 mb-1">Wedding Of</p>
                            <h1 class="text-3xl sm:text-4xl font-cinzel font-semibold text-black">A & R</h1>
                        </div>
                    </div>
                </div>

                <p class="text-xs uppercase tracking-[0.2em] font-montserrat text-gray-500 mb-2">The Wedding Of</p>
                <h1 class="text-5xl sm:text-6xl font-script mb-8 text-black drop-shadow-sm">Arumi & Rendy</h1>

                <div class="bg-white/60 px-8 py-4 rounded-lg backdrop-blur-sm mb-12 shadow-sm border border-gray-100">
                    <p class="text-[10px] font-montserrat text-gray-500 mb-1">Kepada Yth.</p>
                    <p class="text-sm font-cinzel font-bold text-black border-b border-gray-300 pb-1 mb-1">Tamu Undangan</p>
                    <p class="text-[10px] font-montserrat text-gray-500">di Tempat</p>
                </div>

                <button @click="openInvitation()" class="bg-accent text-white px-8 py-3.5 rounded-full text-[11px] font-bold tracking-[0.2em] uppercase transition-all shadow-xl hover:shadow-2xl hover:scale-105 flex items-center">
                    <i data-lucide="mail" class="w-4 h-4 mr-2"></i> Buka Undangan
                </button>
            </div>
        </div>

        <!-- MAIN SCROLLABLE CONTENT -->
        <div class="w-full h-full overflow-y-auto overflow-x-hidden relative">
            <!-- Particles container -->
            <div id="particles-js"></div>
            
            <!-- 1. HERO SECTION -->
            <section class="min-h-[85vh] flex flex-col items-center justify-center p-8 text-center relative pt-20">
                <p class="text-xs uppercase tracking-[0.3em] text-gray-500 mb-6">We Are Getting Married</p>
                
                <div class="w-56 h-72 sm:w-64 sm:h-80 rounded-t-full bg-gray-100 mb-8 overflow-hidden border-[6px] border-white shadow-xl relative">
                    <img src="https://images.unsplash.com/photo-1541250848049-b4f7146120ef?auto=format&fit=crop&q=80&w=600" class="w-full h-full object-cover">
                </div>

                <h1 class="text-5xl font-script text-black mb-4">Arumi & Rendy</h1>
                <div class="text-sm font-cinzel font-semibold tracking-widest text-black border-t border-b border-gray-300 py-3 px-6 mt-2">
                    18 Februari 2024
                </div>
            </section>

            <!-- 2. AR-RUM 21 -->
            <section class="py-24 px-8 text-center">
                <i data-lucide="leaf" class="w-8 h-8 mx-auto mb-6 text-gray-400 opacity-60"></i>
                <p class="text-sm text-black italic leading-loose font-cinzel max-w-sm mx-auto mb-6">
                    “Dan di antara tanda-tanda (kebesaran)-Nya ialah Dia menciptakan pasangan-pasangan untukmu dari jenismu sendiri, agar kamu cenderung dan merasa tenteram kepadanya.”
                </p>
                <p class="text-[10px] font-bold text-gray-500 uppercase tracking-[0.2em]">QS. Ar-Rum 21</p>
            </section>

            <!-- 3. PROFIL -->
            <section class="py-24 px-6 text-center">
                <div class="flex flex-col gap-16 items-center">
                    <!-- Bride -->
                    <div class="flex flex-col items-center">
                        <div class="w-48 h-56 rounded-[20px] bg-gray-100 overflow-hidden mb-8 shadow-lg">
                            <img src="https://images.unsplash.com/photo-1621786032087-03487f97576a?auto=format&fit=crop&q=80&w=400" class="w-full h-full object-cover">
                        </div>
                        <h3 class="text-2xl font-cinzel font-bold text-black mb-2">Arumi Shalwa Affandi, M.Pd.</h3>
                        <p class="text-[11px] text-gray-500 tracking-wide max-w-[250px] mx-auto leading-relaxed">Putri dari Bapak Muhammad Miswanto & Ibu Siti Sarmi</p>
                    </div>

                    <div class="text-5xl font-script text-accent -my-4">&amp;</div>

                    <!-- Groom -->
                    <div class="flex flex-col items-center">
                        <div class="w-48 h-56 rounded-[20px] bg-gray-100 overflow-hidden mb-8 shadow-lg">
                            <img src="https://images.unsplash.com/photo-1550091582-7aa7b06cb860?auto=format&fit=crop&q=80&w=400" class="w-full h-full object-cover">
                        </div>
                        <h3 class="text-2xl font-cinzel font-bold text-black mb-2">Rendy Hanif, S.Pd., S.E.</h3>
                        <p class="text-[11px] text-gray-500 tracking-wide max-w-[250px] mx-auto leading-relaxed">Putra dari Bapak Azwir Hanif & Ibu Rosda Hasim</p>
                    </div>
                </div>
            </section>

            <!-- 4. FOOTER -->
            <footer class="py-20 text-center bg-[#111] text-white">
                <p class="text-[10px] uppercase tracking-[0.3em] text-gray-500 mb-8">Terima Kasih</p>
                <p class="text-xs italic font-cinzel text-gray-400 max-w-xs mx-auto mb-8 leading-relaxed">
                    Atas kehadiran dan do’a restu dari Bapak/Ibu/Saudara/i sekalian, kami mengucapkan terima kasih.
                </p>
                <h3 class="text-4xl font-script">Arumi & Rendy</h3>
            </footer>
            
        </div>
        
        <!-- Floating Audio Player Button -->
        <button @click="toggleAudio()" class="absolute bottom-6 right-6 w-12 h-12 bg-white/90 backdrop-blur-md rounded-full flex items-center justify-center shadow-xl border border-gray-200 z-40 text-black hover:scale-105 transition-transform">
            <template x-if="isPlaying">
                <i data-lucide="pause" class="w-4 h-4"></i>
            </template>
            <template x-if="!isPlaying">
                <i data-lucide="play" class="w-4 h-4 ml-1"></i>
            </template>
        </button>
        <audio x-ref="bgMusic" loop>
             <source src="https://www.soundhelix.com/examples/mp3/SoundHelix-Song-1.mp3" type="audio/mpeg">
        </audio>

    </div>

    <!-- Init Alpine Data -->
    <script>
        function invitationData() {
            return {
                isOpen: false,
                isPlaying: false,
                openInvitation() {
                    this.isOpen = true;
                    this.isPlaying = true;
                    this.$refs.bgMusic.play().catch(e => console.log('Audio error:', e));
                },
                toggleAudio() {
                    this.isPlaying = !this.isPlaying;
                    if(this.isPlaying) this.$refs.bgMusic.play();
                    else this.$refs.bgMusic.pause();
                }
            }
        }
        // Init Lucide Icons
        lucide.createIcons();
    </script>
    <!-- Particles JS Script -->
    <script src="https://cdn.jsdelivr.net/particles.js/2.0.0/particles.min.js"></script> 
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            particlesJS("particles-js", {
                "particles": {
                    "number": { "value": 15, "density": { "enable": true, "value_area": 800 } },
                    "color": { "value": "#31626c" },
                    "shape": { "type": "circle" },
                    "opacity": { 
                        "value": 0.2, 
                        "random": true, 
                        "anim": { "enable": true, "speed": 0.5, "opacity_min": 0.1, "sync": false } 
                    },
                    "size": { 
                        "value": 30, 
                        "random": true, 
                        "anim": { "enable": true, "speed": 2, "size_min": 5, "sync": false } 
                    },
                    "line_linked": { "enable": false },
                    "move": { 
                        "enable": true, 
                        "speed": 1, 
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
        });
    </script>
</body>
</html>
