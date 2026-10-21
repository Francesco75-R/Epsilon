<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="h-full">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=5.0">
    <meta name="description" content="Epsilon Marketplace - Achetez et vendez près de chez vous au Togo en toute sécurité. Des milliers de bonnes affaires vérifiées chaque jour.">
    <title>@yield('title', 'Epsilon Marketplace | Place de marché nationale n°1 au Togo')</title>

    <!-- Google Fonts: Plus Jakarta Sans & Material Symbols -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" rel="stylesheet">

    <!-- Styles de base & Section Produits -->
    <style>
        @layer base {

            html,
            body {
                margin: 0;
                padding: 0;
            }

            body {
                overscroll-behavior-y: none;
            }
        }

        /* Marge spécifique de 1 cm à gauche et 1 cm à droite pour les produits */
        .product-section-wrapper {
            margin-left: 1cm;
            margin-right: 1cm;
            box-sizing: border-box;
        }

        /* Cartes produits agrandies & modernes */
        .product-card {
            min-height: 440px;
            transition: transform 0.28s cubic-bezier(0.16, 1, 0.3, 1), box-shadow 0.28s cubic-bezier(0.16, 1, 0.3, 1), border-color 0.28s ease;
        }

        .product-card:hover {
            transform: translateY(-6px);
        }

        .product-card-img {
            height: 230px;
            transition: transform 0.45s cubic-bezier(0.16, 1, 0.3, 1);
        }

        .product-card:hover .product-card-img {
            transform: scale(1.05);
        }

        /* Barre d'utilitaires mobile : dégagement inférieur */
        @media (max-width: 767px) {
            body {
                padding-bottom: 72px;
            }
        }
    </style>

    <!-- Standalone CSS fallback pour WAMP / Apache -->
    <link rel="stylesheet" href="{{ asset('css/marketplace.css') }}">

    @if (file_exists(public_path('build/manifest.json')) || file_exists(public_path('hot')))
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @else
    <!-- Tailwind CSS CDN avec configuration du design system -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script id="tailwind-config">
        tailwind.config = {
            darkMode: "class",
            theme: {
                extend: {
                    colors: {
                        "primary": "#091426",
                        "primary-container": "#1e293b",
                        "on-primary": "#ffffff",
                        "on-primary-container": "#8590a6",
                        "primary-fixed": "#d8e3fb",
                        "primary-fixed-dim": "#bcc7de",
                        "on-primary-fixed": "#111c2d",
                        "on-primary-fixed-variant": "#3c475a",
                        "inverse-primary": "#bcc7de",
                        "secondary": "#006c4a",
                        "secondary-container": "#82f5c1",
                        "on-secondary": "#ffffff",
                        "on-secondary-container": "#00714e",
                        "secondary-fixed": "#85f8c4",
                        "secondary-fixed-dim": "#68dba9",
                        "on-secondary-fixed": "#002114",
                        "on-secondary-fixed-variant": "#005137",
                        "tertiary": "#0b0054",
                        "tertiary-container": "#1a008e",
                        "on-tertiary": "#ffffff",
                        "on-tertiary-container": "#8580ff",
                        "tertiary-fixed": "#e3dfff",
                        "tertiary-fixed-dim": "#c3c0ff",
                        "on-tertiary-fixed": "#100069",
                        "on-tertiary-fixed-variant": "#372abf",
                        "surface": "#f7f9fb",
                        "surface-dim": "#d8dadc",
                        "surface-bright": "#f7f9fb",
                        "surface-variant": "#e0e3e5",
                        "surface-container-lowest": "#ffffff",
                        "surface-container-low": "#f2f4f6",
                        "surface-container": "#eceef0",
                        "surface-container-high": "#e6e8ea",
                        "surface-container-highest": "#e0e3e5",
                        "on-surface": "#191c1e",
                        "on-surface-variant": "#45474c",
                        "inverse-surface": "#2d3133",
                        "inverse-on-surface": "#eff1f3",
                        "outline": "#75777d",
                        "outline-variant": "#c5c6cd",
                        "surface-tint": "#545f73",
                        "background": "#f7f9fb",
                        "on-background": "#191c1e",
                        "error": "#ba1a1a",
                        "error-container": "#ffdad6",
                        "on-error": "#ffffff",
                        "on-error-container": "#93000a"
                    },
                    borderRadius: {
                        "sm": "0.25rem",
                        "DEFAULT": "0.5rem",
                        "md": "0.75rem",
                        "lg": "1rem",
                        "xl": "1.5rem",
                        "2xl": "1rem",
                        "3xl": "1.5rem",
                        "full": "9999px"
                    },
                    spacing: {
                        "gutter": "1.25rem",
                        "gutter-desktop": "1.5rem",
                        "margin": "1rem",
                        "margin-tablet": "1.5rem",
                        "margin-desktop": "2.5rem"
                    },
                    fontFamily: {
                        sans: ["Plus Jakarta Sans", "sans-serif"]
                    }
                }
            }
        };
    </script>
    @endif

    @stack('styles')
</head>

<body class="bg-surface font-sans text-on-surface antialiased flex flex-col min-h-screen">
    <!-- Header Navigation Principal (situé dans layouts) -->
    @include('layouts.header')

    <!-- Contenu Principal -->
    <main class="w-full pt-20 bg-surface flex-grow">
        @yield('content')
    </main>

    <!-- Footer Principal (situé dans layouts) -->
    @include('layouts.footer')

    <!-- ================================================================= -->
    <!-- MODALE UNIVERSELLE : GALERIE / LIGHTBOX PHOTOS SUR LES CARTES     -->
    <!-- ================================================================= -->
    <div id="gallery-lightbox-modal" class="fixed inset-0 z-[100] bg-black/90 backdrop-blur-md flex flex-col justify-between p-4 sm:p-6 hidden">
        <!-- Top bar de la galerie -->
        <div class="flex items-center justify-between text-white max-w-5xl mx-auto w-full">
            <div class="flex items-center gap-3">
                <span class="material-symbols-outlined text-secondary-fixed text-[24px]">photo_library</span>
                <div>
                    <h4 id="gallery-title" class="font-bold text-sm sm:text-base text-white truncate max-w-[280px] sm:max-w-md">Galerie photos</h4>
                    <span id="gallery-counter" class="text-xs text-slate-400">Photo 1 / 1</span>
                </div>
            </div>
            <button type="button" onclick="closePhotoGallery()" class="w-10 h-10 rounded-full bg-white/10 hover:bg-white/25 flex items-center justify-center transition-colors text-white cursor-pointer" title="Fermer la galerie (Echap)">
                <span class="material-symbols-outlined text-[24px]">close</span>
            </button>
        </div>

        <!-- Centre : Image en grand avec flèches précédente / suivante -->
        <div class="relative flex-1 flex items-center justify-center max-w-5xl mx-auto w-full my-4 overflow-hidden">
            <button type="button" id="gallery-prev-btn" onclick="prevGalleryPhoto()" class="absolute left-2 z-10 w-12 h-12 rounded-full bg-black/50 hover:bg-black/80 text-white flex items-center justify-center transition-all cursor-pointer" title="Précédente">
                <span class="material-symbols-outlined text-[28px]">chevron_left</span>
            </button>

            <img id="gallery-main-img" src="" alt="Vue agrandie" class="max-h-[68vh] max-w-full object-contain rounded-2xl shadow-2xl transition-all duration-200">

            <button type="button" id="gallery-next-btn" onclick="nextGalleryPhoto()" class="absolute right-2 z-10 w-12 h-12 rounded-full bg-black/50 hover:bg-black/80 text-white flex items-center justify-center transition-all cursor-pointer" title="Suivante">
                <span class="material-symbols-outlined text-[28px]">chevron_right</span>
            </button>
        </div>

        <!-- Bas : Barre de miniatures (Thumbnails) -->
        <div id="gallery-thumbnails-strip" class="flex items-center justify-center gap-2 max-w-3xl mx-auto w-full overflow-x-auto py-2">
            <!-- Rempli dynamiquement -->
        </div>
    </div>

    <!-- Configuration globale Auth & Routes JS -->
    <script>
        window.isUserLoggedIn = {{ Auth::check() ? 'true' : 'false' }};
        window.loginUrl = "{{ route('login') }}";
    </script>

    <!-- Scripts Client -->
    <script src="{{ asset('js/marketplace.js') }}"></script>
    @stack('scripts')
</body>

</html>