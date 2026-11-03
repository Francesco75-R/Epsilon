@php
$errors = $errors ?? new \Illuminate\Support\ViewErrorBag;
$user = $user ?? Auth::user();
$myAnnonces = $myAnnonces ?? collect();
@endphp
<!DOCTYPE html>
<html lang="fr" class="h-full">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Espace Membre - Epsilon Marketplace</title>

    <!-- Google Fonts & Material Symbols -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet" />
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" rel="stylesheet" />

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

        /* Masquer scrollbar par défaut pour look d'application épuré */
        .no-scrollbar::-webkit-scrollbar {
            display: none;
        }

        .no-scrollbar {
            -ms-overflow-style: none;
            scrollbar-width: none;
        }

        /* Animation des drag & drop et transitions */
        .thumb-dragging {
            opacity: 0.45;
            transform: scale(0.96);
            border-style: dashed !important;
            border-color: #059669 !important;
        }

        .thumb-drag-over {
            transform: scale(1.05);
            box-shadow: 0 0 0 3px #10b981 !important;
        }

        /* Animation Toasts */
        @keyframes toastIn {
            from {
                transform: translateX(110%);
                opacity: 0;
            }

            to {
                transform: translateX(0);
                opacity: 1;
            }
        }

        @keyframes toastOut {
            from {
                transform: translateX(0);
                opacity: 1;
            }

            to {
                transform: translateX(110%);
                opacity: 0;
            }
        }

        .animate-toast-in {
            animation: toastIn 0.35s cubic-bezier(0.16, 1, 0.3, 1) forwards;
        }

        .animate-toast-out {
            animation: toastOut 0.3s ease forwards;
        }

        /* Style personnalisé pour le sélecteur de genre du profil */
        .profile-select-wrapper {
            position: relative;
            display: flex;
            align-items: center;
        }

        .profile-select-icon-left {
            position: absolute;
            left: 0.875rem;
            top: 50%;
            transform: translateY(-50%);
            color: #94a3b8;
            pointer-events: none;
            display: flex;
            align-items: center;
            transition: color 0.2s ease;
        }

        .profile-select-chevron {
            position: absolute;
            right: 0.875rem;
            top: 50%;
            transform: translateY(-50%);
            color: #94a3b8;
            pointer-events: none;
            display: flex;
            align-items: center;
            transition: transform 0.2s ease, color 0.2s ease;
        }

        .profile-select-field {
            appearance: none;
            -webkit-appearance: none;
            -moz-appearance: none;
            cursor: pointer;
        }

        .profile-select-wrapper:focus-within .profile-select-icon-left,
        .profile-select-wrapper:focus-within .profile-select-chevron {
            color: #059669;
        }

        .profile-select-wrapper:focus-within .profile-select-chevron {
            transform: translateY(-50%) rotate(180deg);
        }

        .profile-select-field option {
            background-color: #ffffff;
            color: #1e293b;
            font-weight: 500;
            padding: 8px 12px;
        }
    </style>

    <script src="https://cdn.tailwindcss.com"></script>
    <script id="tailwind-config">
        tailwind.config = {
            darkMode: "class",
            theme: {
                extend: {
                    colors: {
                        "primary": "#0A1128",
                        "primary-container": "#131b2e",
                        "on-primary": "#ffffff",
                        "secondary": "#006c4a",
                        "secondary-container": "#82f5c1",
                        "on-secondary": "#ffffff",
                        "surface": "#f7f9fb",
                        "surface-container": "#eceef0",
                        "surface-container-low": "#f2f4f6",
                        "surface-container-high": "#e6e8ea",
                        "surface-container-highest": "#e0e3e5",
                        "surface-container-lowest": "#ffffff",
                        "on-surface": "#191c1e",
                        "on-surface-variant": "#45464d",
                        "error": "#ba1a1a",
                        "error-container": "#ffdad6",
                    },
                    fontFamily: {
                        sans: ["Plus Jakarta Sans", "sans-serif"]
                    }
                }
            }
        };
    </script>
</head>

<body class="bg-surface font-sans text-on-surface antialiased min-h-screen flex flex-col">

    <!-- Notifications Flottantes (Toasts) -->
    <div id="toast-container" class="fixed top-5 right-5 z-[100] flex flex-col gap-3 pointer-events-none max-w-sm w-full"></div>

    @if(session('success'))
    <div id="flash-success" data-message="{{ session('success') }}" class="hidden"></div>
    @endif
    @if(session('error'))
    <div id="flash-error" data-message="{{ session('error') }}" class="hidden"></div>
    @endif

    <!-- Overlay Mobile pour la Sidebar -->
    <div class="fixed inset-0 bg-primary/40 z-40 hidden lg:hidden" id="sidebar-backdrop" onclick="toggleSidebar()"></div>

    <!-- ================================================================= -->
    <!-- SIDEBAR MEMBRE GAUCHE                                              -->
    <!-- ================================================================= -->
    <aside class="fixed left-0 top-0 bottom-0 w-64 bg-surface-container-lowest z-50 flex flex-col justify-between shadow-[0_1px_8px_rgba(0,0,0,0.06)] border-r border-slate-200/80 transition-transform duration-300 -translate-x-full lg:translate-x-0" id="member-sidebar">
        <div class="flex flex-col">
            <!-- Logo & Marque Epsilon -->
            <div class="p-5 border-b border-slate-100 flex items-center justify-between">
                <a href="{{ route('home') }}" class="flex items-center gap-2.5 group">
                    <svg class="h-7 w-auto object-contain" viewBox="0 0 100 100" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <rect width="100" height="100" rx="24" fill="#0A1128" />
                        <path d="M30 35H66C66 35 66 35 66 35C66 37.7614 63.7614 40 61 40H44V49H57C59.7614 49 62 51.2386 62 54C62 56.7614 59.7614 59 57 59H44V68H66C68.7614 68 71 70.2386 71 73C71 75.7614 68.7614 78 66 78H35C31.134 78 28 74.866 28 71V40C28 37.2386 30 35 30 35Z" fill="#FFFFFF" />
                        <circle cx="70" cy="35" r="11" fill="#10B981" />
                        <g transform="translate(52, 47)">
                            <path d="M0 7H15" stroke="#10B981" stroke-width="5" stroke-linecap="round" />
                            <path d="M10 2L15 7L10 12" stroke="#10B981" stroke-width="5" stroke-linecap="round" stroke-linejoin="round" />
                        </g>
                    </svg>
                    <span class="font-extrabold text-xl tracking-tight text-primary">Epsilon</span>
                </a>
                <button type="button" class="lg:hidden text-slate-400 hover:text-slate-600" onclick="toggleSidebar()">
                    <span class="material-symbols-outlined text-[20px]">close</span>
                </button>
            </div>

            <!-- Profil Utilisateur dans la Sidebar -->
            <div class="p-5 flex items-center gap-3 bg-slate-50/70 border-b border-slate-100">
                <div class="relative flex-shrink-0">
                    @if(Auth::user()->photo && file_exists(public_path(Auth::user()->photo)))
                    <img src="{{ asset(Auth::user()->photo) }}" alt="{{ Auth::user()->prenom }}" class="w-12 h-12 rounded-full object-cover ring-2 ring-emerald-500/40 shadow-sm">
                    @else
                    <div class="w-12 h-12 rounded-full bg-secondary text-white font-bold flex items-center justify-center text-base shadow-sm ring-2 ring-emerald-100">
                        {{ strtoupper(substr(Auth::user()->prenom ?? 'U', 0, 1)) }}
                    </div>
                    @endif
                    <div class="absolute bottom-0 right-0 w-3.5 h-3.5 rounded-full bg-emerald-500 ring-2 ring-white"></div>
                </div>
                <div class="flex flex-col min-w-0">
                    <span class="font-bold text-sm text-on-surface truncate">{{ Auth::user()->prenom }} {{ Auth::user()->nom }}</span>
                    <span class="text-[11px] font-semibold text-emerald-700 bg-emerald-50 px-2 py-0.5 rounded-full w-max mt-0.5">Membre Vérifié</span>
                </div>
            </div>

            <!-- Bouton CTA principal : Publier une annonce -->
            <div class="p-4">
                <button type="button" onclick="switchDashboardTab('publier')" class="w-full flex items-center justify-center gap-2 py-2.5 px-4 bg-emerald-600 hover:bg-emerald-700 text-white rounded-xl font-bold text-sm shadow-sm transition-all hover:shadow active:scale-[0.98]">
                    <span class="material-symbols-outlined text-[20px]">add_circle</span>
                    <span>Publier une annonce</span>
                </button>
            </div>

            <!-- Menu de navigation -->
            <nav class="flex flex-col gap-1 px-3" id="sidebar-nav">
                <button type="button" onclick="switchDashboardTab('profil')" id="nav-btn-profil" class="flex items-center gap-3 px-3.5 py-2.5 rounded-xl text-sm font-medium text-slate-600 hover:bg-slate-50 hover:text-primary transition-all">
                    <span class="material-symbols-outlined text-[22px]">person</span>
                    <span>Mon Profil</span>
                </button>
                <button type="button" onclick="switchDashboardTab('dashboard')" id="nav-btn-dashboard" class="flex items-center gap-3 px-3.5 py-2.5 rounded-xl text-sm font-semibold transition-all bg-emerald-50 text-emerald-800">
                    <span class="material-symbols-outlined text-[22px]">dashboard</span>
                    <span>Tableau de bord</span>
                </button>

                <button type="button" onclick="switchDashboardTab('mes-annonces')" id="nav-btn-mes-annonces" class="flex items-center justify-between px-3.5 py-2.5 rounded-xl text-sm font-medium text-slate-600 hover:bg-slate-50 hover:text-primary transition-all">
                    <div class="flex items-center gap-3">
                        <span class="material-symbols-outlined text-[22px]">inventory_2</span>
                        <span>Mes annonces</span>
                    </div>
                    <span class="bg-slate-100 text-slate-700 text-xs font-bold px-2 py-0.5 rounded-full" id="sidebar-ad-count">{{ $myAnnonces->count() }}</span>
                </button>

                <button type="button" onclick="switchDashboardTab('publier')" id="nav-btn-publier" class="flex items-center gap-3 px-3.5 py-2.5 rounded-xl text-sm font-medium text-slate-600 hover:bg-slate-50 hover:text-primary transition-all">
                    <span class="material-symbols-outlined text-[22px]">post_add</span>
                    <span>Créer une annonce</span>
                </button>

                <a href="{{ route('page_client') }}" class="flex items-center gap-3 px-3.5 py-2.5 rounded-xl text-sm font-medium text-slate-600 hover:bg-slate-50 hover:text-primary transition-all">
                    <span class="material-symbols-outlined text-[22px]">person</span>
                    <span>Ma page client public</span>
                </a>

                <!-- <a href="{{ route('home') }}" class="flex items-center gap-3 px-3.5 py-2.5 rounded-xl text-sm font-medium text-slate-600 hover:bg-slate-50 hover:text-primary transition-all">
                    <span class="material-symbols-outlined text-[22px]">storefront</span>
                    <span>Marketplace public</span>
                </a> -->
            </nav>
        </div>

        <!-- Déconnexion en bas de la sidebar -->
        <div class="p-4 border-t border-slate-100">
            <form action="{{ route('logout') }}" method="POST">
                @csrf
                <button type="submit" class="w-full flex items-center gap-2.5 px-3.5 py-2.5 rounded-xl text-sm font-semibold text-red-600 hover:bg-red-50 transition-colors text-left cursor-pointer">
                    <span class="material-symbols-outlined text-[20px]">logout</span>
                    <span>Se déconnecter</span>
                </button>
            </form>
        </div>
    </aside>

    <!-- ================================================================= -->
    <!-- CONTENU PRINCIPAL + TOPBAR                                        -->
    <!-- ================================================================= -->
    <div class="lg:pl-64 flex flex-col flex-1 min-h-screen">

        <!-- Header supérieur -->
        <header class="h-16 bg-white/90 backdrop-blur-md sticky top-0 z-30 flex items-center justify-between px-4 sm:px-6 lg:px-8 border-b border-slate-200/80">
            <div class="flex items-center gap-3">
                <button class="lg:hidden p-2 text-slate-600 hover:bg-slate-100 rounded-xl" onclick="toggleSidebar()" type="button" aria-label="Ouvrir le menu">
                    <span class="material-symbols-outlined text-[24px]">menu</span>
                </button>
                <div class="flex items-center gap-2">
                    <span class="text-xs font-bold uppercase tracking-wider text-emerald-700 bg-emerald-50 px-2.5 py-1 rounded-full">Espace Membre</span>
                    <span class="text-slate-300 hidden sm:inline">|</span>
                    <span class="text-sm font-semibold text-slate-700 hidden sm:inline">Bienvenue, {{ Auth::user()->prenom }}</span>
                </div>
            </div>

            <div class="flex items-center gap-3">
                <a href="{{ route('home') }}" class="hidden sm:inline-flex items-center gap-1.5 text-xs font-semibold text-slate-600 hover:text-emerald-700 bg-slate-100 hover:bg-slate-200/80 px-3 py-1.5 rounded-xl transition-all">
                    <span class="material-symbols-outlined text-[16px]">home</span>
                    <span>Accueil Public</span>
                </a>

                <!-- Avatar Profil Header -->
                <a href="{{ route('page_client') }}" class="flex items-center gap-2 pl-1 group" title="Voir ma page client">
                    @if(Auth::user()->photo && file_exists(public_path(Auth::user()->photo)))
                    <img src="{{ asset(Auth::user()->photo) }}" alt="{{ Auth::user()->prenom }}" class="w-8 h-8 rounded-full object-cover ring-2 ring-emerald-500/30">
                    @else
                    <div class="w-8 h-8 rounded-full bg-secondary text-white font-bold flex items-center justify-center text-xs">
                        {{ strtoupper(substr(Auth::user()->prenom ?? 'U', 0, 1)) }}
                    </div>
                    @endif
                    <span class="hidden md:inline text-xs font-bold text-slate-800">{{ Auth::user()->prenom }}</span>
                </a>
            </div>
        </header>

        <!-- Main Body -->
        <main class="flex-1 p-4 sm:p-6 lg:p-8 max-w-7xl w-full mx-auto">

            <!-- ================================================================= -->
            <!-- ONGLET 1 : TABLEAU DE BORD (STATS & KPIS)                         -->
            <!-- ================================================================= -->
            <div id="tab-content-dashboard" class="space-y-6">
                <!-- Bannière d'accueil -->
                <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 bg-white p-6 rounded-2xl border border-slate-200/80 shadow-sm">
                    <div>
                        <div class="flex items-center gap-2 text-emerald-700 text-xs font-bold uppercase tracking-wider mb-1">
                            <span class="w-2 h-2 rounded-full bg-emerald-500 animate-pulse"></span>
                            <span>Session Active • Compte Vérifié</span>
                        </div>
                        <h1 class="text-2xl sm:text-3xl font-extrabold text-slate-900 tracking-tight">Bonjour, {{ Auth::user()->prenom }} !</h1>
                        <p class="text-sm text-slate-500 mt-1">Gérez facilement vos annonces, suivez vos performances et publiez de nouvelles offres en quelques clics.</p>
                    </div>
                    <div class="flex items-center gap-2.5 flex-shrink-0">
                        <button type="button" onclick="switchDashboardTab('publier')" class="inline-flex items-center gap-2 bg-emerald-600 hover:bg-emerald-700 text-white font-bold text-sm px-4 py-2.5 rounded-xl shadow-sm hover:shadow transition-all">
                            <span class="material-symbols-outlined text-[18px]">add_circle</span>
                            <span>Publier une annonce</span>
                        </button>
                    </div>
                </div>

                <!-- 4 Cartes Statistiques (KPIs) -->
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 sm:gap-5">
                    <!-- KPI 1 : Annonces Actives -->
                    <div class="bg-white rounded-2xl p-5 border border-slate-200/80 shadow-sm flex flex-col justify-between hover:shadow-md transition-shadow cursor-pointer" onclick="switchDashboardTab('mes-annonces')">
                        <div class="flex items-start justify-between">
                            <span class="text-xs font-semibold text-slate-500 uppercase tracking-wider">Annonces actives</span>
                            <div class="w-10 h-10 rounded-xl bg-emerald-50 text-emerald-600 flex items-center justify-center">
                                <span class="material-symbols-outlined text-[22px]">inventory_2</span>
                            </div>
                        </div>
                        <div class="mt-3">
                            <span class="text-3xl font-extrabold text-slate-900">{{ $myAnnonces->count() }}</span>
                        </div>
                        <div class="mt-2 flex items-center gap-1.5 text-xs text-emerald-600 font-semibold">
                            <span class="material-symbols-outlined text-[16px]">check_circle</span>
                            <span>En ligne sur Epsilon</span>
                        </div>
                    </div>

                    <!-- KPI 2 : Vues Estimées -->
                    <div class="bg-white rounded-2xl p-5 border border-slate-200/80 shadow-sm flex flex-col justify-between hover:shadow-md transition-shadow">
                        <div class="flex items-start justify-between">
                            <span class="text-xs font-semibold text-slate-500 uppercase tracking-wider">Vues totales</span>
                            <div class="w-10 h-10 rounded-xl bg-blue-50 text-blue-600 flex items-center justify-center">
                                <span class="material-symbols-outlined text-[22px]">visibility</span>
                            </div>
                        </div>
                        <div class="mt-3">
                            <span class="text-3xl font-extrabold text-slate-900">{{ $myAnnonces->count() * 142 + 28 }}</span>
                        </div>
                        <div class="mt-2 flex items-center gap-1 text-xs text-blue-600 font-semibold">
                            <span class="material-symbols-outlined text-[16px]">trending_up</span>
                            <span>+18.4% cette semaine</span>
                        </div>
                    </div>

                    <!-- KPI 3 : Messages Reçus -->
                    <div class="bg-white rounded-2xl p-5 border border-slate-200/80 shadow-sm flex flex-col justify-between hover:shadow-md transition-shadow">
                        <div class="flex items-start justify-between">
                            <span class="text-xs font-semibold text-slate-500 uppercase tracking-wider">Messages reçus</span>
                            <div class="w-10 h-10 rounded-xl bg-purple-50 text-purple-600 flex items-center justify-center">
                                <span class="material-symbols-outlined text-[22px]">chat</span>
                            </div>
                        </div>
                        <div class="mt-3">
                            <span class="text-3xl font-extrabold text-slate-900">{{ $myAnnonces->count() * 4 + 2 }}</span>
                        </div>
                        <div class="mt-2 flex items-center gap-1.5 text-xs text-purple-700 font-semibold">
                            <span class="w-2 h-2 rounded-full bg-purple-500 animate-ping"></span>
                            <span>Direct sur WhatsApp & Web</span>
                        </div>
                    </div>

                    <!-- KPI 4 : Localisation & Portée -->
                    <div class="bg-white rounded-2xl p-5 border border-slate-200/80 shadow-sm flex flex-col justify-between hover:shadow-md transition-shadow">
                        <div class="flex items-start justify-between">
                            <span class="text-xs font-semibold text-slate-500 uppercase tracking-wider">Région principale</span>
                            <div class="w-10 h-10 rounded-xl bg-amber-50 text-amber-600 flex items-center justify-center">
                                <span class="material-symbols-outlined text-[22px]">location_on</span>
                            </div>
                        </div>
                        <div class="mt-3">
                            <span class="text-xl font-bold text-slate-900 truncate">{{ Auth::user()->adresse ?: 'Togo National' }}</span>
                        </div>
                        <div class="mt-2 flex items-center gap-1 text-xs text-amber-700 font-semibold">
                            <span>Diffusion partout au Togo</span>
                        </div>
                    </div>
                </div>

                <!-- Grille principale : Dernières annonces + Conseils -->
                <div class="grid grid-cols-1 lg:grid-cols-12 gap-6 items-start">
                    <!-- Colonne 8/12 : Mes dernières annonces -->
                    <div class="lg:col-span-8 bg-white rounded-2xl p-6 border border-slate-200/80 shadow-sm space-y-4">
                        <div class="flex items-center justify-between pb-3 border-b border-slate-100">
                            <div class="flex items-center gap-2.5">
                                <h2 class="text-lg font-bold text-slate-900">Mes dernières annonces</h2>
                                <span class="text-xs font-bold text-emerald-700 bg-emerald-50 px-2 py-0.5 rounded-full">{{ $myAnnonces->count() }} au total</span>
                            </div>
                            <button type="button" onclick="switchDashboardTab('mes-annonces')" class="text-xs font-bold text-emerald-600 hover:text-emerald-700 inline-flex items-center gap-1">
                                <span>Voir tout</span>
                                <span class="material-symbols-outlined text-[16px]">chevron_right</span>
                            </button>
                        </div>

                        @if($myAnnonces->isEmpty())
                        <div class="py-12 flex flex-col items-center justify-center text-center">
                            <div class="w-16 h-16 rounded-2xl bg-emerald-50 text-emerald-600 flex items-center justify-center mb-3">
                                <span class="material-symbols-outlined text-[32px]">add_business</span>
                            </div>
                            <h3 class="text-base font-bold text-slate-800">Aucune annonce publiée pour le moment</h3>
                            <p class="text-xs text-slate-500 max-w-sm mt-1 mb-4">Créez votre première annonce en moins de 2 minutes pour la rendre visible à des milliers d'acheteurs.</p>
                            <button type="button" onclick="switchDashboardTab('publier')" class="bg-emerald-600 hover:bg-emerald-700 text-white font-bold text-xs px-4 py-2.5 rounded-xl transition-all shadow-sm">
                                + Publier ma première annonce
                            </button>
                        </div>
                        @else
                        <div class="overflow-x-auto">
                            <table class="w-full text-left border-collapse">
                                <thead>
                                    <tr class="text-[11px] font-bold text-slate-400 uppercase tracking-wider border-b border-slate-100 pb-2">
                                        <th class="py-2.5 px-3">Annonce</th>
                                        <th class="py-2.5 px-3">Catégorie</th>
                                        <th class="py-2.5 px-3">Prix</th>
                                        <th class="py-2.5 px-3">Statut</th>
                                        <th class="py-2.5 px-3 text-right">Actions</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-slate-100 text-sm">
                                    @foreach($myAnnonces->take(4) as $item)
                                    <tr class="hover:bg-slate-50/70 transition-colors">
                                        <td class="py-3 px-3">
                                            <div class="flex items-center gap-3">
                                                @php
                                                $cover = is_array($item->photos) && count($item->photos) > 0 ? asset($item->photos[0]) : asset('photo/default.png');
                                                @endphp
                                                <img src="{{ $cover }}" alt="{{ $item->titre }}" class="w-12 h-12 rounded-xl object-cover border border-slate-200/70 flex-shrink-0">
                                                <div class="min-w-0">
                                                    <div class="font-bold text-slate-900 truncate max-w-[200px]">{{ $item->titre }}</div>
                                                    <div class="text-xs text-slate-400 truncate">{{ $item->lieu }} • {{ $item->formatted_date }}</div>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="py-3 px-3 text-xs text-slate-600 font-medium">{{ $item->categorie }}</td>
                                        <td class="py-3 px-3 font-extrabold text-emerald-700 whitespace-nowrap">{{ number_format($item->prix, 0, ',', ' ') }} FCFA</td>
                                        <td class="py-3 px-3">
                                            <span class="inline-flex items-center gap-1 px-2.5 py-0.5 rounded-full text-[11px] font-bold bg-emerald-50 text-emerald-700">
                                                <span class="w-1.5 h-1.5 rounded-full bg-emerald-500"></span> En ligne
                                            </span>
                                        </td>
                                        <td class="py-3 px-3 text-right whitespace-nowrap">
                                            <div class="inline-flex items-center gap-1.5">
                                                <!-- Bouton Photos Modal -->
                                                <button type="button" data-photos="{{ e(json_encode($item->photos)) }}" data-titre="{{ $item->titre }}" onclick="openGalleryFromElement(this)" class="px-2.5 py-1 text-xs font-bold text-emerald-700 bg-emerald-50 hover:bg-emerald-100 rounded-lg inline-flex items-center gap-1 transition-colors" title="Voir les photos de l'annonce">
                                                    <span class="material-symbols-outlined text-[15px]">photo_library</span>
                                                    <span>Photos ({{ is_array($item->photos) ? count($item->photos) : 0 }})</span>
                                                </button>
                                            </div>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        @endif
                    </div>

                    <!-- Colonne 4/12 : Conseils & Actions Rapides -->
                    <div class="lg:col-span-4 space-y-5">
                        <!-- Carte Conseil Epsilon -->
                        <div class="bg-gradient-to-br from-emerald-800 to-teal-950 text-white rounded-2xl p-5 shadow-sm relative overflow-hidden">
                            <div class="flex items-center gap-2 text-emerald-300 text-xs font-bold uppercase tracking-wider mb-2">
                                <span class="material-symbols-outlined text-[18px]">tips_and_updates</span>
                                <span>Conseil Epsilon</span>
                            </div>
                            <h3 class="text-base font-bold mb-2">Multipliez vos ventes par 3</h3>
                            <p class="text-xs text-emerald-100/90 leading-relaxed mb-4">
                                Ajoutez jusqu'à <strong>5 photos réelles</strong> sous plusieurs angles et placez la photo la plus lumineuse en <strong>1ère position (Couverture)</strong> grâce au glisser-déposer.
                            </p>
                            <button type="button" onclick="switchDashboardTab('publier')" class="w-full bg-emerald-500 hover:bg-emerald-400 text-slate-950 font-bold text-xs py-2 px-3 rounded-xl transition-colors shadow-sm">
                                Déposer une annonce maintenant
                            </button>
                        </div>

                        <!-- Raccourcis utiles -->
                        <div class="bg-white rounded-2xl p-5 border border-slate-200/80 shadow-sm space-y-3">
                            <h4 class="text-xs font-bold text-slate-400 uppercase tracking-wider">Raccourcis Espace Membre</h4>
                            <div class="space-y-1.5">
                                <a href="{{ route('page_client') }}" class="flex items-center justify-between p-2.5 rounded-xl hover:bg-slate-50 transition-colors text-xs font-semibold text-slate-700">
                                    <span class="flex items-center gap-2">
                                        <span class="material-symbols-outlined text-[18px] text-emerald-600">account_circle</span>
                                        <span>Consulter mon profil public</span>
                                    </span>
                                    <span class="material-symbols-outlined text-[16px] text-slate-400">arrow_forward</span>
                                </a>
                                <button type="button" onclick="switchDashboardTab('mes-annonces')" class="w-full flex items-center justify-between p-2.5 rounded-xl hover:bg-slate-50 transition-colors text-xs font-semibold text-slate-700 text-left">
                                    <span class="flex items-center gap-2">
                                        <span class="material-symbols-outlined text-[18px] text-emerald-600">inventory_2</span>
                                        <span>Gérer toutes mes annonces</span>
                                    </span>
                                    <span class="material-symbols-outlined text-[16px] text-slate-400">arrow_forward</span>
                                </button>
                                <a href="{{ route('home') }}" class="flex items-center justify-between p-2.5 rounded-xl hover:bg-slate-50 transition-colors text-xs font-semibold text-slate-700">
                                    <span class="flex items-center gap-2">
                                        <span class="material-symbols-outlined text-[18px] text-emerald-600">storefront</span>
                                        <span>Voir le marketplace Togo</span>
                                    </span>
                                    <span class="material-symbols-outlined text-[16px] text-slate-400">arrow_forward</span>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- ================================================================= -->
            <!-- ONGLET 2 : MES ANNONCES (FILTRAGE STRICT USER_ID = AUTH::ID())     -->
            <!-- ================================================================= -->
            <div id="tab-content-mes-annonces" class="hidden space-y-6">
                <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 bg-white p-5 rounded-2xl border border-slate-200/80 shadow-sm">
                    <div>
                        <div class="flex items-center gap-2">
                            <h1 class="text-2xl font-extrabold text-slate-900 tracking-tight">Mes annonces</h1>
                            <span class="px-2.5 py-0.5 rounded-full text-xs font-bold bg-emerald-100 text-emerald-800">{{ $myAnnonces->count() }} annonces</span>
                        </div>
                        <p class="text-xs text-slate-500 mt-1">Seules les annonces créées avec votre compte sont affichées ici.</p>
                    </div>
                    <button type="button" onclick="switchDashboardTab('publier')" class="inline-flex items-center gap-2 bg-emerald-600 hover:bg-emerald-700 text-white font-bold text-xs sm:text-sm px-4 py-2.5 rounded-xl shadow-sm transition-all">
                        <span class="material-symbols-outlined text-[18px]">add_circle</span>
                        <span>Nouvelle annonce</span>
                    </button>
                </div>

                @if($myAnnonces->isEmpty())
                <div class="bg-white rounded-2xl p-12 text-center border border-slate-200/80 shadow-sm max-w-md mx-auto">
                    <div class="w-16 h-16 rounded-full bg-slate-100 text-slate-400 flex items-center justify-center mx-auto mb-4">
                        <span class="material-symbols-outlined text-[32px]">inventory_2</span>
                    </div>
                    <h2 class="text-lg font-bold text-slate-800 mb-1">Vous n'avez aucune annonce active</h2>
                    <p class="text-xs text-slate-500 mb-5 leading-relaxed">
                        Vous n'avez pas encore publié de produit ou service. Cliquez ci-dessous pour déposer votre première offre gratuitement.
                    </p>
                    <button type="button" onclick="switchDashboardTab('publier')" class="bg-emerald-600 hover:bg-emerald-700 text-white font-bold text-sm px-5 py-2.5 rounded-xl shadow-sm transition-all">
                        Publier une annonce maintenant
                    </button>
                </div>
                @else
                <!-- Grille des cartes produits du membre -->
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-5">
                    @foreach($myAnnonces as $ad)
                    <div class="bg-white rounded-2xl border border-slate-200/80 hover:border-emerald-500/40 shadow-sm hover:shadow-lg transition-all duration-300 flex flex-col overflow-hidden group">
                        <!-- Vignette / Image de couverture (Uniquement photos[0]) -->
                        <div class="relative w-full h-48 bg-slate-100 overflow-hidden">
                            @php
                            $cover = is_array($ad->photos) && count($ad->photos) > 0 ? asset($ad->photos[0]) : asset('photo/default.png');
                            $countPhotos = is_array($ad->photos) ? count($ad->photos) : 0;
                            @endphp
                            <img src="{{ $cover }}" alt="{{ $ad->titre }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500 ease-out" loading="lazy">

                            <!-- Badges d'état & Catégorie -->
                            <div class="absolute top-2.5 left-2.5 flex flex-wrap gap-1.5">
                                <span class="bg-white/95 backdrop-blur-md text-slate-800 text-[11px] font-bold px-2 py-0.5 rounded-md shadow-sm">
                                    {{ $ad->etat }}
                                </span>
                                <span class="bg-emerald-700/90 backdrop-blur-md text-white text-[11px] font-bold px-2 py-0.5 rounded-md shadow-sm">
                                    {{ $ad->categorie }}
                                </span>
                            </div>

                            <!-- Bouton "Photos" flottant sur la carte -->
                            <button type="button" data-photos="{{ e(json_encode($ad->photos)) }}" data-titre="{{ $ad->titre }}" onclick="openGalleryFromElement(this)" class="absolute bottom-2.5 right-2.5 bg-slate-900/85 hover:bg-emerald-600 text-white text-xs font-bold px-2.5 py-1 rounded-lg backdrop-blur-md shadow-sm inline-flex items-center gap-1.5 transition-all cursor-pointer">
                                <span class="material-symbols-outlined text-[16px]">photo_library</span>
                                <span>Photos ({{ $countPhotos }})</span>
                            </button>
                        </div>

                        <!-- Détails de l'annonce -->
                        <div class="p-4 flex flex-col flex-1 justify-between gap-3">
                            <div>
                                <h3 class="font-bold text-base text-slate-900 line-clamp-1 group-hover:text-emerald-700 transition-colors">
                                    {{ $ad->titre }}
                                </h3>
                                <div class="flex items-baseline gap-1 mt-1.5">
                                    <span class="text-xl font-extrabold text-emerald-700">{{ number_format($ad->prix, 0, ',', ' ') }}</span>
                                    <span class="text-xs font-bold text-slate-400">FCFA</span>
                                </div>
                                <p class="text-xs text-slate-500 line-clamp-2 mt-2 leading-relaxed">
                                    {{ $ad->description }}
                                </p>
                            </div>

                            <!-- Footer de la carte -->
                            <div class="pt-3 border-t border-slate-100 flex justify-between items-center w-full text-xs text-slate-500">
                                <div class="flex items-center gap-1 truncate text-slate-600 font-medium" title="{{ $ad->lieu }}">
                                    <span class="material-symbols-outlined text-[15px] text-slate-400">location_on</span>
                                    <span class="truncate">{{ $ad->lieu }}</span>
                                </div>
                                <div class="flex items-center gap-2 flex-shrink-0 ml-2">
                                    <span class="flex items-center gap-1 text-[11px] font-medium text-slate-400 whitespace-nowrap" title="{{ $ad->created_at }}">
                                        <span class="material-symbols-outlined text-[13px]">schedule</span>
                                        <span>{{ $ad->formatted_date }}</span>
                                    </span>
                                    <!-- Formulaire de suppression -->
                                    <form action="{{ route('annonces.destroy', $ad->id) }}" method="POST" onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer cette annonce ?');" class="inline-flex">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-red-500 hover:text-red-700 font-bold inline-flex items-center p-1 rounded hover:bg-red-50 transition-colors" title="Supprimer l'annonce">
                                            <span class="material-symbols-outlined text-[18px]">delete</span>
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
                @endif
            </div>

            <!-- ================================================================= -->
            <!-- ONGLET 3 : PUBLIER UNE ANNONCE (STEPPER + DRAG & DROP + PREVIEW)    -->
            <!-- ================================================================= -->
            <div id="tab-content-publier" class="hidden space-y-6">
                <!-- En-tête -->
                <div class="bg-white p-6 rounded-2xl border border-slate-200/80 shadow-sm flex flex-col sm:flex-row sm:items-center justify-between gap-3">
                    <div>
                        <div class="flex items-center gap-2 text-xs font-bold text-emerald-700 uppercase tracking-wider mb-1">
                            <span>Formulaire Express</span>
                            <span>•</span>
                            <span>3 Étapes Simples</span>
                        </div>
                        <h1 class="text-2xl font-extrabold text-slate-900 tracking-tight">Publier une nouvelle annonce</h1>
                        <p class="text-xs text-slate-500 mt-1">Remplissez les détails, ajoutez jusqu'à 5 photos et prévisualisez avant mise en ligne.</p>
                    </div>
                    <button type="button" onclick="switchDashboardTab('mes-annonces')" class="text-xs font-bold text-slate-600 hover:text-emerald-700 bg-slate-100 hover:bg-slate-200/80 px-3.5 py-2 rounded-xl transition-all self-start sm:self-auto">
                        ← Retour à mes annonces
                    </button>
                </div>

                <!-- Form Card avec Stepper -->
                <div class="bg-white rounded-2xl border border-slate-200/80 shadow-sm overflow-hidden">
                    <!-- Stepper Bar Horizontale -->
                    <div class="px-4 sm:px-8 pt-6 pb-4 bg-slate-50/70 border-b border-slate-100">
                        <div class="relative flex items-center justify-between max-w-xl mx-auto">
                            <!-- Barre d'arrière plan -->
                            <div class="absolute top-1/2 left-0 right-0 h-1 bg-slate-200 -translate-y-1/2 z-0"></div>
                            <!-- Barre active -->
                            <div id="progress-bar-fill" class="absolute top-1/2 left-0 h-1 bg-emerald-600 -translate-y-1/2 z-0 transition-all duration-300" style="width: 0%;"></div>

                            <!-- Nœud Étape 1 -->
                            <div class="relative z-10 flex flex-col items-center cursor-pointer group" onclick="goToStep(1)">
                                <div id="step-node-1" class="w-10 h-10 rounded-full flex items-center justify-center font-bold text-xs bg-emerald-600 text-white shadow ring-4 ring-emerald-100 transition-all">
                                    <span class="material-symbols-outlined text-[20px]" id="step-icon-1">description</span>
                                </div>
                                <span id="step-text-1" class="text-xs font-bold text-emerald-800 mt-2 transition-colors">1. Informations</span>
                            </div>

                            <!-- Nœud Étape 2 -->
                            <div class="relative z-10 flex flex-col items-center cursor-pointer group" onclick="goToStep(2)">
                                <div id="step-node-2" class="w-10 h-10 rounded-full flex items-center justify-center font-bold text-xs bg-slate-200 text-slate-500 transition-all">
                                    <span class="material-symbols-outlined text-[20px]" id="step-icon-2">photo_library</span>
                                </div>
                                <span id="step-text-2" class="text-xs font-medium text-slate-500 mt-2 transition-colors">2. Photos (Max 5)</span>
                            </div>

                            <!-- Nœud Étape 3 -->
                            <div class="relative z-10 flex flex-col items-center cursor-pointer group" onclick="goToStep(3)">
                                <div id="step-node-3" class="w-10 h-10 rounded-full flex items-center justify-center font-bold text-xs bg-slate-200 text-slate-500 transition-all">
                                    <span class="material-symbols-outlined text-[20px]" id="step-icon-3">payments</span>
                                </div>
                                <span id="step-text-3" class="text-xs font-medium text-slate-500 mt-2 transition-colors">3. Prix & Confirmation</span>
                            </div>
                        </div>
                    </div>

                    <!-- Bannière d'alerte validation étape -->
                    <div id="step-validation-banner" class="hidden mx-6 mt-4 p-3.5 rounded-xl bg-red-50 border border-red-200 text-red-700 text-xs flex items-center gap-2">
                        <span class="material-symbols-outlined text-[18px]">error</span>
                        <span id="step-validation-message">Veuillez renseigner les champs obligatoires.</span>
                    </div>

                    <!-- FORMULAIRE PRINCIPAL DE PUBLICATION -->
                    <form id="form-publier-annonce" action="{{ route('annonces.store') }}" method="POST" enctype="multipart/form-data" class="w-full">
                        @csrf
                        <!-- Input réel pour l'upload (alimenté en direct dans le bon ordre par le DataTransfer) -->
                        <input type="file" name="photos[]" id="real-photos-input" multiple accept="image/jpeg,image/png,image/jpg,image/webp" class="hidden">

                        <!-- Slider Conteneur des 3 Étapes -->
                        <div class="relative overflow-hidden w-full">
                            <div id="steps-slider" class="flex w-[300%] transition-transform duration-500 ease-in-out">

                                <!-- ==================================================== -->
                                <!-- ÉTAPE 1 : DÉTAILS GÉNÉRAUX                           -->
                                <!-- ==================================================== -->
                                <div class="w-1/3 p-6 sm:p-8 space-y-6 flex-shrink-0">
                                    <div class="border-b border-slate-100 pb-3 flex items-center justify-between">
                                        <div>
                                            <h2 class="text-lg font-bold text-slate-900">1. Détails généraux de l'article</h2>
                                            <p class="text-xs text-slate-500">Indiquez les informations de base pour faciliter la recherche.</p>
                                        </div>
                                        <span class="text-xs font-semibold text-emerald-700 bg-emerald-50 px-2.5 py-1 rounded-full">Étape 1 sur 3</span>
                                    </div>

                                    <div class="space-y-4 max-w-2xl">
                                        <!-- Titre -->
                                        <div>
                                            <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5" for="input-titre">
                                                Titre de l'annonce <span class="text-red-500">*</span>
                                            </label>
                                            <input type="text" id="input-titre" name="titre" value="{{ old('titre') }}" placeholder="ex: Toyota RAV4 2021, iPhone 14 Pro, Villa Meublée..." class="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm text-slate-900 focus:bg-white focus:outline-none focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-600 transition-all" required>
                                        </div>

                                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                                            <!-- Catégorie -->
                                            <div>
                                                <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5" for="input-categorie">
                                                    Catégorie <span class="text-red-500">*</span>
                                                </label>
                                                <select id="input-categorie" name="categorie" class="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm text-slate-900 focus:bg-white focus:outline-none focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-600 transition-all cursor-pointer" required>
                                                    <option value="" disabled selected>Sélectionner une catégorie</option>
                                                    <option value="Véhicules" {{ old('categorie') == 'Véhicules' ? 'selected' : '' }}>Véhicules (Voitures, Motos...)</option>
                                                    <option value="Immobilier" {{ old('categorie') == 'Immobilier' ? 'selected' : '' }}>Immobilier (Vente, Location...)</option>
                                                    <option value="Smartphones & Tech" {{ old('categorie') == 'Smartphones & Tech' ? 'selected' : '' }}>Smartphones & High-Tech</option>
                                                    <option value="Mode & Maison" {{ old('categorie') == 'Mode & Maison' ? 'selected' : '' }}>Mode, Beauté & Maison</option>
                                                    <option value="Emploi & Services" {{ old('categorie') == 'Emploi & Services' ? 'selected' : '' }}>Emploi & Prestations de Services</option>
                                                </select>
                                            </div>

                                            <!-- Lieu / Emplacement -->
                                            <div>
                                                <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5" for="input-lieu">
                                                    Emplacement / Lieu <span class="text-red-500">*</span>
                                                </label>
                                                <input type="text" id="input-lieu" name="lieu" value="{{ old('lieu') }}" placeholder="ex: Lomé (Agoè), Kara, Cotonou..." class="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm text-slate-900 focus:bg-white focus:outline-none focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-600 transition-all" required>
                                            </div>
                                        </div>

                                        <!-- État / Condition -->
                                        <div>
                                            <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">
                                                État du produit <span class="text-red-500">*</span>
                                            </label>
                                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-3" id="condition-options">
                                                <label class="flex items-center gap-3 p-3.5 rounded-xl border-2 border-emerald-600 bg-emerald-50/30 cursor-pointer transition-all" id="label-etat-neuf">
                                                    <input type="radio" name="etat" value="Neuf" checked onchange="updateEtatUI()" class="text-emerald-600 focus:ring-emerald-500 h-4 w-4">
                                                    <div>
                                                        <span class="block font-bold text-xs text-slate-900">Neuf (Jamais utilisé)</span>
                                                        <span class="block text-[11px] text-slate-500">Sous emballage ou scellé</span>
                                                    </div>
                                                </label>
                                                <label class="flex items-center gap-3 p-3.5 rounded-xl border border-slate-200 bg-white hover:bg-slate-50 cursor-pointer transition-all" id="label-etat-usage">
                                                    <input type="radio" name="etat" value="Usagé" onchange="updateEtatUI()" class="text-emerald-600 focus:ring-emerald-500 h-4 w-4">
                                                    <div>
                                                        <span class="block font-bold text-xs text-slate-900">Usagé / Occasion</span>
                                                        <span class="block text-[11px] text-slate-500">En bon état de fonctionnement</span>
                                                    </div>
                                                </label>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="pt-4 border-t border-slate-100 flex justify-end">
                                        <button type="button" onclick="validateAndNext(1)" class="bg-emerald-600 hover:bg-emerald-700 text-white font-bold text-sm px-6 py-2.5 rounded-xl inline-flex items-center gap-2 shadow-sm transition-all">
                                            <span>Suivant : Photos</span>
                                            <span class="material-symbols-outlined text-[18px]">arrow_forward</span>
                                        </button>
                                    </div>
                                </div>

                                <!-- ==================================================== -->
                                <!-- ÉTAPE 2 : PHOTOS & GLISSER-DÉPOSER (MAX 5 PHOTOS)    -->
                                <!-- ==================================================== -->
                                <div class="w-1/3 p-6 sm:p-8 space-y-6 flex-shrink-0">
                                    <div class="border-b border-slate-100 pb-3 flex items-center justify-between">
                                        <div>
                                            <h2 class="text-lg font-bold text-slate-900">2. Galerie photos (Maximum 5 photos)</h2>
                                            <p class="text-xs text-slate-500">Glissez-déposez pour réorganiser : la 1ère photo sera votre couverture d'affiche.</p>
                                        </div>
                                        <span class="text-xs font-semibold text-emerald-700 bg-emerald-50 px-2.5 py-1 rounded-full">Étape 2 sur 3</span>
                                    </div>

                                    <!-- Zone d'Upload Drag & Drop -->
                                    <div class="space-y-4">
                                        <div id="dropzone" class="border-2 border-dashed border-slate-300 hover:border-emerald-500 bg-slate-50 hover:bg-emerald-50/20 rounded-2xl p-6 text-center transition-all cursor-pointer flex flex-col items-center justify-center group">
                                            <input type="file" id="picker-file-input" multiple accept="image/jpeg,image/png,image/jpg,image/webp" class="hidden" onchange="handleFileSelect(event)">
                                            <div class="w-14 h-14 rounded-2xl bg-emerald-100/70 text-emerald-700 flex items-center justify-center mb-2.5 group-hover:scale-110 transition-transform">
                                                <span class="material-symbols-outlined text-[32px]">cloud_upload</span>
                                            </div>
                                            <p class="text-sm font-bold text-slate-800">
                                                Cliquez pour parcourir ou glissez vos photos ici
                                            </p>
                                            <p class="text-xs text-slate-500 mt-1">
                                                Formats JPG, PNG, WEBP • Max 5 Mo par image • <strong>5 photos maximum</strong>
                                            </p>
                                        </div>

                                        <!-- Indicateur compteur de photos -->
                                        <div class="flex items-center justify-between">
                                            <div class="text-xs font-bold text-slate-700">
                                                Photos sélectionnées (<span id="photo-count-badge">0</span>/5)
                                            </div>
                                            <div class="text-[11px] text-slate-500 flex items-center gap-1">
                                                <span class="material-symbols-outlined text-[14px] text-emerald-600">pan_tool</span>
                                                <span>Astuce : Glissez les vignettes pour changer l'ordre</span>
                                            </div>
                                        </div>

                                        <!-- Grille des vignettes interactives avec réorganisation Drag & Drop -->
                                        <div id="thumbnails-grid" class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-5 gap-3.5 min-h-[110px] p-2 bg-slate-50/50 rounded-xl border border-slate-200/60">
                                            <!-- Sera rempli dynamiquement par JS -->
                                        </div>
                                    </div>

                                    <div class="pt-4 border-t border-slate-100 flex justify-between items-center">
                                        <button type="button" onclick="goToStep(1)" class="px-5 py-2.5 rounded-xl border border-slate-200 text-xs font-bold text-slate-700 hover:bg-slate-50 inline-flex items-center gap-1.5 transition-colors">
                                            <span class="material-symbols-outlined text-[18px]">arrow_back</span>
                                            <span>Précédent</span>
                                        </button>
                                        <button type="button" onclick="validateAndNext(2)" class="bg-emerald-600 hover:bg-emerald-700 text-white font-bold text-sm px-6 py-2.5 rounded-xl inline-flex items-center gap-2 shadow-sm transition-all">
                                            <span>Suivant : Prix & Description</span>
                                            <span class="material-symbols-outlined text-[18px]">arrow_forward</span>
                                        </button>
                                    </div>
                                </div>

                                <!-- ==================================================== -->
                                <!-- ÉTAPE 3 : PRIX & DESCRIPTION FINALE                  -->
                                <!-- ==================================================== -->
                                <div class="w-1/3 p-6 sm:p-8 space-y-6 flex-shrink-0">
                                    <div class="border-b border-slate-100 pb-3 flex items-center justify-between">
                                        <div>
                                            <h2 class="text-lg font-bold text-slate-900">3. Prix & Description détaillée</h2>
                                            <p class="text-xs text-slate-500">Fixez votre montant en FCFA et décrivez précisément votre produit.</p>
                                        </div>
                                        <span class="text-xs font-semibold text-emerald-700 bg-emerald-50 px-2.5 py-1 rounded-full">Étape 3 sur 3</span>
                                    </div>

                                    <div class="grid grid-cols-1 lg:grid-cols-12 gap-6 items-start">
                                        <!-- Formulaire prix & desc (7 col) -->
                                        <div class="lg:col-span-7 space-y-4">
                                            <!-- Prix -->
                                            <div>
                                                <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5" for="input-prix">
                                                    Prix de vente souhaité <span class="text-red-500">*</span>
                                                </label>
                                                <div class="relative flex items-center">
                                                    <input type="number" id="input-prix" name="prix" min="0" placeholder="ex: 150000" oninput="updateLiveRecap()" class="w-full pl-3.5 pr-20 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm text-slate-900 focus:bg-white focus:outline-none focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-600 transition-all font-bold" required>
                                                    <span class="absolute right-2 px-2.5 py-1 bg-slate-200 text-slate-700 rounded-lg text-xs font-bold">
                                                        FCFA
                                                    </span>
                                                </div>
                                            </div>

                                            <!-- Description -->
                                            <div>
                                                <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5" for="input-description">
                                                    Description complète <span class="text-red-500">*</span>
                                                </label>
                                                <textarea id="input-description" name="description" rows="5" oninput="updateLiveRecap()" placeholder="Décrivez l'état, la provenance, les accessoires fournis, et vos disponibilités pour la remise en mains propres..." class="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm text-slate-900 focus:bg-white focus:outline-none focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-600 transition-all" required></textarea>
                                                <div class="flex justify-between items-center mt-1 text-[11px] text-slate-400">
                                                    <span>Minimum 10 caractères</span>
                                                    <span id="char-counter">0 car.</span>
                                                </div>
                                            </div>
                                        </div>

                                        <!-- Aperçu direct dans la carte latérale (5 col) -->
                                        <div class="lg:col-span-5 bg-slate-50 p-4 rounded-2xl border border-slate-200/80 space-y-3">
                                            <div class="flex items-center justify-between border-b border-slate-200 pb-2">
                                                <span class="text-xs font-bold uppercase tracking-wider text-slate-700 flex items-center gap-1">
                                                    <span class="material-symbols-outlined text-[16px] text-emerald-600">visibility</span>
                                                    <span>Aperçu en direct</span>
                                                </span>
                                                <span class="text-[10px] font-bold uppercase bg-emerald-100 text-emerald-800 px-2 py-0.5 rounded">Brouillon</span>
                                            </div>

                                            <div class="space-y-2 text-xs">
                                                <div>
                                                    <span class="text-slate-400 block text-[11px]">Titre</span>
                                                    <p class="font-bold text-slate-900 text-sm truncate" id="recap-title">Titre en attente...</p>
                                                </div>
                                                <div class="grid grid-cols-2 gap-2">
                                                    <div>
                                                        <span class="text-slate-400 block text-[11px]">Catégorie</span>
                                                        <p class="font-semibold text-slate-800 truncate" id="recap-category">-</p>
                                                    </div>
                                                    <div>
                                                        <span class="text-slate-400 block text-[11px]">Lieu</span>
                                                        <p class="font-semibold text-slate-800 truncate" id="recap-location">-</p>
                                                    </div>
                                                </div>
                                                <div class="pt-2 border-t border-slate-200">
                                                    <span class="text-slate-400 block text-[11px]">Prix</span>
                                                    <p class="text-lg font-extrabold text-emerald-700" id="recap-price">0 FCFA</p>
                                                </div>
                                                <div class="pt-2 border-t border-slate-200">
                                                    <span class="text-slate-400 block text-[11px]">Description</span>
                                                    <p class="text-slate-600 italic line-clamp-3" id="recap-desc">"Aucune description saisie..."</p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="pt-4 border-t border-slate-100 flex justify-between items-center">
                                        <button type="button" onclick="goToStep(2)" class="px-5 py-2.5 rounded-xl border border-slate-200 text-xs font-bold text-slate-700 hover:bg-slate-50 inline-flex items-center gap-1.5 transition-colors">
                                            <span class="material-symbols-outlined text-[18px]">arrow_back</span>
                                            <span>Précédent</span>
                                        </button>
                                        <!-- Ouvre d'abord la Modale d'Aperçu avant Publication -->
                                        <button type="button" onclick="openPreSubmitModal()" class="bg-emerald-600 hover:bg-emerald-700 text-white font-extrabold text-sm sm:text-base px-8 py-3 rounded-xl inline-flex items-center gap-2.5 shadow-md hover:shadow-lg transition-all active:scale-[0.98]">
                                            <span class="material-symbols-outlined text-[20px]">preview</span>
                                            <span>Publier l'annonce</span>
                                        </button>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </form>
                </div>
            </div>

            <!-- ================================================================= -->
            <!-- ONGLET 4 : MON PROFIL (CONSULTATION ET ÉDITION DONNÉES MEMBRE)    -->
            <!-- ================================================================= -->
            <div id="tab-content-profil" class="hidden space-y-6">
                <!-- En-tête de section -->
                <div class="bg-white p-6 rounded-2xl border border-slate-200/80 shadow-sm flex flex-col sm:flex-row sm:items-center justify-between gap-4">
                    <div>
                        <div class="flex items-center gap-2.5">
                            <h1 class="text-2xl font-extrabold text-slate-900 tracking-tight">Mon Profil</h1>
                            <span class="px-2.5 py-0.5 rounded-full text-xs font-bold bg-emerald-100 text-emerald-800">
                                @if(Auth::user()->email_verified_at)
                                ✓ Compte Vérifié
                                @else
                                En attente de vérification
                                @endif
                            </span>
                        </div>
                        <p class="text-xs text-slate-500 mt-1">Consultez et modifiez vos informations personnelles ainsi que votre photo de profil.</p>
                    </div>

                    <a href="{{ route('page_client') }}" class="inline-flex items-center gap-2 px-4 py-2 bg-slate-100 hover:bg-slate-200 text-slate-700 font-bold text-xs rounded-xl transition-all">
                        <span class="material-symbols-outlined text-[18px]">visibility</span>
                        <span>Voir mon profil public</span>
                    </a>
                </div>

                @if($errors->any())
                <div class="p-4 rounded-xl bg-red-50 border border-red-200 text-red-800 text-sm">
                    <div class="font-bold mb-1">Des erreurs sont survenues :</div>
                    <ul class="list-disc list-inside text-xs space-y-0.5">
                        @foreach($errors->all() as $err)
                        <li>{{ $err }}</li>
                        @endforeach
                    </ul>
                </div>
                @endif

                <form action="{{ route('profile.update') }}" method="POST" enctype="multipart/form-data" class="bg-white rounded-2xl border border-slate-200/80 shadow-sm p-6 sm:p-8 space-y-8" id="profile-form">
                    @csrf

                    <!-- Section Photo de Profil -->
                    <div class="flex flex-col sm:flex-row sm:items-center gap-6 pb-6 border-b border-slate-100">
                        <div class="relative w-28 h-28 flex-shrink-0 mx-auto sm:mx-0">
                            <div class="w-28 h-28 rounded-full overflow-hidden ring-4 ring-emerald-500/30 bg-slate-100 shadow-md flex items-center justify-center">
                                @if(Auth::user()->photo && file_exists(public_path(Auth::user()->photo)))
                                <img id="profile-preview-img" src="{{ asset(Auth::user()->photo) }}" alt="{{ Auth::user()->prenom }}" class="w-full h-full object-cover">
                                @else
                                <img id="profile-preview-img" src="" alt="Aperçu" class="w-full h-full object-cover hidden">
                                <div id="profile-avatar-fallback" class="w-full h-full bg-secondary text-white font-extrabold flex items-center justify-center text-3xl">
                                    {{ strtoupper(substr(Auth::user()->prenom ?? 'U', 0, 1)) }}
                                </div>
                                @endif
                            </div>
                            <label for="profile-photo-input" class="absolute bottom-1 right-1 w-9 h-9 rounded-full bg-emerald-600 hover:bg-emerald-700 text-white flex items-center justify-center shadow-lg cursor-pointer transition-transform hover:scale-110 ring-2 ring-white" title="Changer la photo de profil">
                                <span class="material-symbols-outlined text-[18px]">photo_camera</span>
                            </label>
                            <input type="file" id="profile-photo-input" name="photo" accept="image/jpeg,image/png,image/webp,image/jpg" class="hidden">
                        </div>

                        <div class="space-y-1.5 text-center sm:text-left">
                            <h3 class="font-bold text-slate-800 text-base">Photo de profil</h3>
                            <p class="text-xs text-slate-500 leading-relaxed max-w-md">
                                Téléchargez une photo nette de vous ou de votre logo professionnel. Formats acceptés : JPG, PNG, WEBP (Max 5 Mo). L'ancienne photo sera automatiquement remplacée dans <code>public/photo</code>.
                            </p>
                            <div class="pt-1">
                                <button type="button" onclick="document.getElementById('profile-photo-input').click()" class="text-xs font-bold text-emerald-700 hover:text-emerald-800 bg-emerald-50 hover:bg-emerald-100 px-3 py-1.5 rounded-lg transition-colors">
                                    Choisir une nouvelle photo
                                </button>
                                <span id="profile-file-name" class="text-xs text-slate-500 ml-2 italic"></span>
                            </div>
                        </div>
                    </div>

                    <!-- Champs d'information personnelle -->
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                        <!-- Nom -->
                        <div class="space-y-1.5">
                            <label for="profile_nom" class="block text-xs font-bold text-slate-700 uppercase tracking-wider">
                                Nom <span class="text-red-500">*</span>
                            </label>
                            <div class="relative">
                                <input type="text" id="profile_nom" name="nom" value="{{ old('nom', Auth::user()->nom) }}" required maxlength="60" class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:border-emerald-500 focus:ring-2 focus:ring-emerald-200 outline-none text-sm font-medium transition-all text-slate-800 bg-slate-50/50 focus:bg-white" placeholder="Votre nom de famille">
                            </div>
                        </div>

                        <!-- Prénom -->
                        <div class="space-y-1.5">
                            <label for="profile_prenom" class="block text-xs font-bold text-slate-700 uppercase tracking-wider">
                                Prénom <span class="text-red-500">*</span>
                            </label>
                            <div class="relative">
                                <input type="text" id="profile_prenom" name="prenom" value="{{ old('prenom', Auth::user()->prenom) }}" required maxlength="60" class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:border-emerald-500 focus:ring-2 focus:ring-emerald-200 outline-none text-sm font-medium transition-all text-slate-800 bg-slate-50/50 focus:bg-white" placeholder="Votre prénom">
                            </div>
                        </div>

                        <!-- Téléphone -->
                        <div class="space-y-1.5">
                            <label for="profile_telephone" class="block text-xs font-bold text-slate-700 uppercase tracking-wider">
                                Numéro de téléphone <span class="text-red-500">*</span>
                            </label>
                            <div class="relative">
                                <span class="absolute left-3.5 top-1/2 -translate-y-1/2 text-slate-400">
                                    <span class="material-symbols-outlined text-[18px]">call</span>
                                </span>
                                <input type="tel" id="profile_telephone" name="telephone" value="{{ old('telephone', Auth::user()->telephone) }}" required maxlength="35" class="w-full pl-11 pr-4 py-3 rounded-xl border border-slate-200 focus:border-emerald-500 focus:ring-2 focus:ring-emerald-200 outline-none text-sm font-medium transition-all text-slate-800 bg-slate-50/50 focus:bg-white" placeholder="Ex: +228 90 00 00 00">
                            </div>
                        </div>

                        <!-- Adresse -->
                        <div class="space-y-1.5">
                            <label for="profile_adresse" class="block text-xs font-bold text-slate-700 uppercase tracking-wider">
                                Adresse / Quartier / Ville <span class="text-red-500">*</span>
                            </label>
                            <div class="relative">
                                <span class="absolute left-3.5 top-1/2 -translate-y-1/2 text-slate-400">
                                    <span class="material-symbols-outlined text-[18px]">location_on</span>
                                </span>
                                <input type="text" id="profile_adresse" name="adresse" value="{{ old('adresse', Auth::user()->adresse) }}" required maxlength="255" class="w-full pl-11 pr-4 py-3 rounded-xl border border-slate-200 focus:border-emerald-500 focus:ring-2 focus:ring-emerald-200 outline-none text-sm font-medium transition-all text-slate-800 bg-slate-50/50 focus:bg-white" placeholder="Ex: Tokoin Doumasséssé, Lomé, Togo">
                            </div>
                        </div>
                        <!-- Genre -->
                        <div class="space-y-1.5 sm:col-span-2">
                            <label for="profile_genre" class="block text-xs font-bold text-slate-700 uppercase tracking-wider">
                                Genre <span class="text-red-500">*</span>
                            </label>
                            @php
                                $currentGenre = old('genre', Auth::user()->genre);
                            @endphp
                            <div class="profile-select-wrapper relative">
                                <span class="profile-select-icon-left">
                                    <span class="material-symbols-outlined text-[18px]">person</span>
                                </span>
                                <select name="genre" id="profile_genre" class="profile-select-field w-full pl-11 pr-10 py-3 rounded-xl border border-slate-200 hover:border-slate-300 focus:border-emerald-500 focus:ring-2 focus:ring-emerald-200 outline-none text-sm font-medium transition-all text-slate-800 bg-slate-50/50 focus:bg-white" required>
                                    <option value="" disabled {{ empty($currentGenre) ? 'selected' : '' }}>Sélectionnez votre genre</option>
                                    <option value="Masculin" {{ in_array($currentGenre, ['Masculin', 'Homme']) ? 'selected' : '' }}>Masculin</option>
                                    <option value="Féminin" {{ in_array($currentGenre, ['Féminin', 'Femme']) ? 'selected' : '' }}>Féminin</option>
                                </select>
                                <span class="profile-select-chevron">
                                    <span class="material-symbols-outlined text-[20px]">expand_more</span>
                                </span>
                            </div>
                        </div>
                        <!-- Adresse e-mail (Lecture seule) -->
                        <div class="space-y-1.5 sm:col-span-2">
                            <label class="block text-xs font-bold text-slate-500 uppercase tracking-wider">
                                Adresse e-mail (Compte Epsilon)
                            </label>
                            <div class="flex items-center justify-between px-4 py-3 rounded-xl bg-slate-100 border border-slate-200 text-sm text-slate-600">
                                <div class="flex items-center gap-2.5">
                                    <span class="material-symbols-outlined text-[18px] text-slate-400">mail</span>
                                    <span class="font-medium">{{ Auth::user()->email }}</span>
                                </div>
                                <span class="text-xs font-bold text-emerald-700 bg-emerald-50 px-2.5 py-0.5 rounded-full">
                                    {{ Auth::user()->email_verified_at ? 'Email vérifié' : 'Non vérifié' }}
                                </span>
                            </div>
                            <p class="text-[11px] text-slate-400">L'adresse e-mail est liée à la sécurité de votre compte et ne peut être modifiée que via le support.</p>
                        </div>
                    </div>

                    <!-- Bouton de soumission -->
                    <div class="pt-4 border-t border-slate-100 flex items-center justify-end">
                        <button type="submit" class="w-full sm:w-auto inline-flex items-center justify-center gap-2 bg-emerald-600 hover:bg-emerald-700 text-white font-bold text-sm px-6 py-3 rounded-xl shadow-sm transition-all hover:shadow active:scale-[0.98]">
                            <span class="material-symbols-outlined text-[18px]">save</span>
                            <span>Enregistrer les modifications</span>
                        </button>
                    </div>
                </form>
            </div>

        </main>
    </div>

    <!-- ================================================================= -->
    <!-- MODALE 1 : APERÇU AVANT PUBLICATION ("PRE-SUBMIT MODAL")           -->
    <!-- ================================================================= -->
    <div id="presubmit-modal" class="fixed inset-0 z-50 bg-slate-950/70 backdrop-blur-sm flex items-center justify-center p-4 hidden">
        <div class="bg-white rounded-3xl max-w-xl w-full p-6 sm:p-8 shadow-2xl border border-slate-100 flex flex-col max-h-[90vh] overflow-y-auto no-scrollbar animate-scale-up">

            <div class="flex items-center justify-between pb-3 border-b border-slate-100">
                <div class="flex items-center gap-2">
                    <span class="w-8 h-8 rounded-xl bg-emerald-100 text-emerald-700 flex items-center justify-center">
                        <span class="material-symbols-outlined text-[20px]">visibility</span>
                    </span>
                    <h3 class="text-lg font-extrabold text-slate-900">Aperçu avant publication</h3>
                </div>
                <button type="button" onclick="closePreSubmitModal()" class="text-slate-400 hover:text-slate-700">
                    <span class="material-symbols-outlined text-[22px]">close</span>
                </button>
            </div>

            <!-- Carte Visuelle de l'annonce prête à paraître -->
            <div class="mt-4 bg-slate-50 rounded-2xl border border-slate-200/80 overflow-hidden">
                <!-- Image de Couverture principale -->
                <div class="relative w-full h-56 bg-slate-200">
                    <img id="modal-cover-img" src="" alt="Couverture" class="w-full h-full object-cover">
                    <div class="absolute top-3 left-3 flex gap-2">
                        <span id="modal-etat-badge" class="bg-white/95 backdrop-blur-md text-slate-800 text-xs font-bold px-2.5 py-1 rounded-lg shadow-sm">Neuf</span>
                        <span id="modal-categorie-badge" class="bg-emerald-700 text-white text-xs font-bold px-2.5 py-1 rounded-lg shadow-sm">Catégorie</span>
                    </div>
                    <span id="modal-photos-count" class="absolute bottom-3 right-3 bg-slate-900/80 text-white text-xs font-bold px-2.5 py-1 rounded-lg backdrop-blur-md">
                        3 photos
                    </span>
                </div>

                <!-- Contenu dans la modale -->
                <div class="p-5 space-y-3">
                    <h4 id="modal-title" class="text-lg font-extrabold text-slate-900">Titre de l'annonce</h4>

                    <div class="flex items-baseline gap-1">
                        <span id="modal-price" class="text-2xl font-black text-emerald-700">0</span>
                        <span class="text-xs font-bold text-slate-400">FCFA</span>
                    </div>

                    <div class="flex items-center gap-1.5 text-xs text-slate-500 pt-1">
                        <span class="material-symbols-outlined text-[16px] text-slate-400">location_on</span>
                        <span id="modal-location">Lieu</span>
                        <span>• Vendeur : {{ Auth::user()->prenom }} {{ Auth::user()->nom }}</span>
                    </div>

                    <div class="pt-3 border-t border-slate-200">
                        <span class="text-xs font-bold text-slate-700 uppercase tracking-wider block mb-1">Description</span>
                        <p id="modal-description" class="text-xs text-slate-600 leading-relaxed whitespace-pre-line bg-white p-3 rounded-xl border border-slate-200/60 max-h-32 overflow-y-auto">
                            Description ici...
                        </p>
                    </div>
                </div>
            </div>

            <!-- Boutons d'Action : Modifier ou Confirmer & Publier -->
            <div class="mt-6 flex flex-col sm:flex-row items-center justify-end gap-3 pt-4 border-t border-slate-100">
                <button type="button" onclick="closePreSubmitModal()" class="w-full sm:w-auto px-5 py-2.5 rounded-xl border border-slate-200 text-slate-700 text-xs font-bold hover:bg-slate-50 transition-colors">
                    Modifier
                </button>
                <button type="button" id="btn-modal-confirm-submit" onclick="submitConfirmedListing()" class="w-full sm:w-auto px-6 py-2.5 rounded-xl bg-emerald-600 hover:bg-emerald-700 text-white text-xs font-bold inline-flex items-center justify-center gap-2 shadow-sm transition-all">
                    <span class="material-symbols-outlined text-[18px]">rocket_launch</span>
                    <span>Confirmer et Publier</span>
                </button>
            </div>

        </div>
    </div>

    <!-- ================================================================= -->
    <!-- MODALE 2 : GALERIE / LIGHTBOX PHOTOS SUR LES CARTES PRODUITS      -->
    <!-- ================================================================= -->
    <div id="gallery-lightbox-modal" class="fixed inset-0 z-50 bg-black/90 backdrop-blur-md flex flex-col justify-between p-4 sm:p-6 hidden">
        <!-- Top bar de la galerie -->
        <div class="flex items-center justify-between text-white max-w-5xl mx-auto w-full">
            <div class="flex items-center gap-3">
                <span class="material-symbols-outlined text-emerald-400 text-[24px]">photo_library</span>
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
        <div id="gallery-thumbnails-strip" class="flex items-center justify-center gap-2 max-w-3xl mx-auto w-full overflow-x-auto py-2 no-scrollbar">
            <!-- Rempli en direct -->
        </div>
    </div>

    <!-- ================================================================= -->
    <!-- JAVASCRIPT DU DASHBOARD & GESTION DRAG & DROP PHOTO               -->
    <!-- ================================================================= -->
    <script>
        // -------------------------------------------------------------
        // 1. Navigation Onglets (Dashboard / Mes Annonces / Publier)
        // -------------------------------------------------------------
        function toggleSidebar() {
            const sidebar = document.getElementById('member-sidebar');
            const backdrop = document.getElementById('sidebar-backdrop');
            sidebar.classList.toggle('-translate-x-full');
            backdrop.classList.toggle('hidden');
        }

        function switchDashboardTab(tabName) {
            const tabs = ['dashboard', 'mes-annonces', 'publier', 'profil'];
            tabs.forEach(t => {
                const el = document.getElementById('tab-content-' + t);
                const btn = document.getElementById('nav-btn-' + t);
                if (el) el.classList.add('hidden');
                if (btn) {
                    btn.classList.remove('bg-emerald-50', 'text-emerald-800');
                    btn.classList.add('text-slate-600');
                }
            });

            const activeContent = document.getElementById('tab-content-' + tabName);
            const activeBtn = document.getElementById('nav-btn-' + tabName);
            if (activeContent) activeContent.classList.remove('hidden');
            if (activeBtn) {
                activeBtn.classList.add('bg-emerald-50', 'text-emerald-800');
                activeBtn.classList.remove('text-slate-600');
            }

            // Fermeture mobile
            document.getElementById('member-sidebar').classList.add('-translate-x-full');
            document.getElementById('sidebar-backdrop').classList.add('hidden');

            window.location.hash = tabName;
            window.scrollTo({
                top: 0,
                behavior: 'smooth'
            });
        }

        // -------------------------------------------------------------
        // 2. Stepper Formulaire Publier (Étape 1, 2, 3)
        // -------------------------------------------------------------
        let currentStep = 1;
        const totalSteps = 3;

        function updateStepperUI() {
            const slider = document.getElementById('steps-slider');
            const fill = document.getElementById('progress-bar-fill');
            slider.style.transform = `translateX(-${(currentStep - 1) * (100 / totalSteps)}%)`;
            const fillPercent = ((currentStep - 1) / (totalSteps - 1)) * 100;
            fill.style.width = `${fillPercent}%`;

            for (let i = 1; i <= totalSteps; i++) {
                const node = document.getElementById(`step-node-${i}`);
                const text = document.getElementById(`step-text-${i}`);
                const icon = document.getElementById(`step-icon-${i}`);

                if (i < currentStep) {
                    node.className = 'w-10 h-10 rounded-full flex items-center justify-center font-bold text-xs bg-emerald-600 text-white shadow ring-2 ring-emerald-200 transition-all';
                    icon.innerText = 'check';
                    text.className = 'text-xs font-bold text-emerald-700 mt-2 transition-colors';
                } else if (i === currentStep) {
                    node.className = 'w-10 h-10 rounded-full flex items-center justify-center font-bold text-xs bg-emerald-600 text-white shadow ring-4 ring-emerald-100 transition-all';
                    icon.innerText = i === 1 ? 'description' : (i === 2 ? 'photo_library' : 'payments');
                    text.className = 'text-xs font-bold text-slate-900 mt-2 transition-colors';
                } else {
                    node.className = 'w-10 h-10 rounded-full flex items-center justify-center font-bold text-xs bg-slate-200 text-slate-500 transition-all';
                    icon.innerText = i === 1 ? 'description' : (i === 2 ? 'photo_library' : 'payments');
                    text.className = 'text-xs font-medium text-slate-400 mt-2 transition-colors';
                }
            }
        }

        function showStepError(msg) {
            const banner = document.getElementById('step-validation-banner');
            const label = document.getElementById('step-validation-message');
            label.innerText = msg;
            banner.classList.remove('hidden');
            banner.scrollIntoView({
                behavior: 'smooth',
                block: 'nearest'
            });
        }

        function hideStepError() {
            document.getElementById('step-validation-banner').classList.add('hidden');
        }

        function validateStep(step) {
            hideStepError();
            if (step === 1) {
                const titre = document.getElementById('input-titre').value.trim();
                const cat = document.getElementById('input-categorie').value;
                const lieu = document.getElementById('input-lieu').value.trim();
                if (!titre) {
                    showStepError("Veuillez saisir le titre de votre annonce.");
                    document.getElementById('input-titre').focus();
                    return false;
                }
                if (!cat) {
                    showStepError("Veuillez sélectionner une catégorie.");
                    document.getElementById('input-categorie').focus();
                    return false;
                }
                if (!lieu) {
                    showStepError("Veuillez indiquer un emplacement ou lieu.");
                    document.getElementById('input-lieu').focus();
                    return false;
                }
                return true;
            } else if (step === 2) {
                if (uploadedPhotos.length === 0) {
                    showStepError("Veuillez ajouter au moins 1 photo pour illustrer votre produit.");
                    return false;
                }
                return true;
            }
            return true;
        }

        function validateAndNext(step) {
            if (validateStep(step)) {
                currentStep = step + 1;
                updateStepperUI();
                updateLiveRecap();
            }
        }

        function goToStep(step) {
            if (step > currentStep) {
                for (let s = currentStep; s < step; s++) {
                    if (!validateStep(s)) return;
                }
            }
            hideStepError();
            currentStep = step;
            updateStepperUI();
            updateLiveRecap();
        }

        function updateEtatUI() {
            const radios = document.getElementsByName('etat');
            let val = 'Neuf';
            radios.forEach(r => {
                if (r.checked) val = r.value;
            });

            const neufLabel = document.getElementById('label-etat-neuf');
            const usageLabel = document.getElementById('label-etat-usage');

            if (val === 'Neuf') {
                neufLabel.className = 'flex items-center gap-3 p-3.5 rounded-xl border-2 border-emerald-600 bg-emerald-50/30 cursor-pointer transition-all';
                usageLabel.className = 'flex items-center gap-3 p-3.5 rounded-xl border border-slate-200 bg-white hover:bg-slate-50 cursor-pointer transition-all';
            } else {
                usageLabel.className = 'flex items-center gap-3 p-3.5 rounded-xl border-2 border-emerald-600 bg-emerald-50/30 cursor-pointer transition-all';
                neufLabel.className = 'flex items-center gap-3 p-3.5 rounded-xl border border-slate-200 bg-white hover:bg-slate-50 cursor-pointer transition-all';
            }
            updateLiveRecap();
        }

        // -------------------------------------------------------------
        // 3. Upload Interactif & Réorganisation Drag & Drop (Max 5 photos)
        // -------------------------------------------------------------
        // Structure: [ { id, file, dataUrl } ]
        let uploadedPhotos = [];
        let dragSourceIndex = null;

        const dropzone = document.getElementById('dropzone');
        const pickerInput = document.getElementById('picker-file-input');

        dropzone.addEventListener('click', () => pickerInput.click());

        ['dragenter', 'dragover'].forEach(name => {
            dropzone.addEventListener(name, (e) => {
                e.preventDefault();
                dropzone.classList.add('border-emerald-600', 'bg-emerald-50/50');
            });
        });
        ['dragleave', 'drop'].forEach(name => {
            dropzone.addEventListener(name, (e) => {
                e.preventDefault();
                dropzone.classList.remove('border-emerald-600', 'bg-emerald-50/50');
            });
        });

        dropzone.addEventListener('drop', (e) => {
            e.preventDefault();
            if (e.dataTransfer.files && e.dataTransfer.files.length > 0) {
                processFiles(e.dataTransfer.files);
            }
        });

        function handleFileSelect(e) {
            if (e.target.files && e.target.files.length > 0) {
                processFiles(e.target.files);
                e.target.value = ''; // Reset pour permettre de re-sélectionner
            }
        }

        function processFiles(files) {
            const maxAllowed = 5;
            const remaining = maxAllowed - uploadedPhotos.length;

            if (remaining <= 0) {
                showToast('error', 'Limite atteinte', 'Vous avez déjà sélectionné le maximum de 5 photos.');
                return;
            }

            const incoming = Array.from(files).filter(f => f.type.startsWith('image/'));
            if (incoming.length === 0) {
                showToast('error', 'Format invalide', 'Veuillez sélectionner uniquement des images (JPG, PNG, WEBP).');
                return;
            }

            if (incoming.length > remaining) {
                showToast('info', 'Information', `Seules ${remaining} photo(s) ont été ajoutées pour respecter la limite de 5.`);
            }

            const toAdd = incoming.slice(0, remaining);

            toAdd.forEach(file => {
                const reader = new FileReader();
                reader.onload = (e) => {
                    uploadedPhotos.push({
                        id: 'photo_' + Date.now() + '_' + Math.random().toString(36).substr(2, 9),
                        file: file,
                        dataUrl: e.target.result
                    });
                    renderThumbnails();
                };
                reader.readAsDataURL(file);
            });
        }

        function removePhoto(index) {
            uploadedPhotos.splice(index, 1);
            renderThumbnails();
        }

        function renderThumbnails() {
            const grid = document.getElementById('thumbnails-grid');
            const badge = document.getElementById('photo-count-badge');
            badge.innerText = uploadedPhotos.length;

            grid.innerHTML = '';

            uploadedPhotos.forEach((item, index) => {
                const card = document.createElement('div');
                card.draggable = true;
                card.dataset.index = index;
                card.className = 'relative group rounded-xl overflow-hidden border border-slate-200 bg-white aspect-square shadow-sm cursor-grab active:cursor-grabbing transition-transform select-none';

                // Image
                const img = document.createElement('img');
                img.src = item.dataUrl;
                img.className = 'w-full h-full object-cover pointer-events-none';
                card.appendChild(img);

                // Badge Couverture si 1ère position
                if (index === 0) {
                    const cov = document.createElement('span');
                    cov.className = 'absolute top-1.5 left-1.5 bg-emerald-600 text-white font-extrabold text-[10px] px-2 py-0.5 rounded shadow';
                    cov.innerText = '★ Couverture';
                    card.appendChild(cov);
                } else {
                    const pos = document.createElement('span');
                    pos.className = 'absolute top-1.5 left-1.5 bg-slate-900/70 text-white font-bold text-[10px] w-5 h-5 rounded-full flex items-center justify-center';
                    pos.innerText = index + 1;
                    card.appendChild(pos);
                }

                // Bouton croix rouge de suppression (X)
                const delBtn = document.createElement('button');
                delBtn.type = 'button';
                delBtn.className = 'absolute top-1.5 right-1.5 w-6 h-6 rounded-full bg-red-600 hover:bg-red-700 text-white flex items-center justify-center font-bold text-xs shadow-md transition-transform hover:scale-110';
                delBtn.innerHTML = '✕';
                delBtn.title = 'Supprimer cette photo';
                delBtn.onclick = (e) => {
                    e.stopPropagation();
                    removePhoto(index);
                };
                card.appendChild(delBtn);

                // Événements Drag & Drop pour réordonner
                card.addEventListener('dragstart', (e) => {
                    dragSourceIndex = index;
                    card.classList.add('thumb-dragging');
                    e.dataTransfer.effectAllowed = 'move';
                });

                card.addEventListener('dragend', () => {
                    card.classList.remove('thumb-dragging');
                    document.querySelectorAll('.thumb-drag-over').forEach(el => el.classList.remove('thumb-drag-over'));
                });

                card.addEventListener('dragover', (e) => {
                    e.preventDefault();
                    card.classList.add('thumb-drag-over');
                });

                card.addEventListener('dragleave', () => {
                    card.classList.remove('thumb-drag-over');
                });

                card.addEventListener('drop', (e) => {
                    e.preventDefault();
                    card.classList.remove('thumb-drag-over');
                    const targetIndex = index;
                    if (dragSourceIndex !== null && dragSourceIndex !== targetIndex) {
                        const moved = uploadedPhotos.splice(dragSourceIndex, 1)[0];
                        uploadedPhotos.splice(targetIndex, 0, moved);
                        renderThumbnails();
                        showToast('info', 'Réorganisation', 'L\'ordre des photos a été mis à jour.');
                    }
                });

                grid.appendChild(card);
            });

            // Bouton carré "Ajouter" si moins de 5 photos
            if (uploadedPhotos.length < 5) {
                const addBox = document.createElement('button');
                addBox.type = 'button';
                addBox.onclick = () => pickerInput.click();
                addBox.className = 'border-2 border-dashed border-slate-300 hover:border-emerald-500 rounded-xl aspect-square flex flex-col items-center justify-center text-slate-400 hover:text-emerald-700 hover:bg-emerald-50/20 transition-all';
                addBox.innerHTML = `
                    <span class="material-symbols-outlined text-[26px]">add_photo_alternate</span>
                    <span class="text-[11px] font-bold mt-1">+ Ajouter</span>
                `;
                grid.appendChild(addBox);
            }

            // Synchronisation de l'input réel avec DataTransfer
            syncRealFileInput();
            updateLiveRecap();
        }

        function syncRealFileInput() {
            const dt = new DataTransfer();
            uploadedPhotos.forEach(p => dt.items.add(p.file));
            document.getElementById('real-photos-input').files = dt.files;
        }

        // -------------------------------------------------------------
        // 4. Live Recap Étape 3
        // -------------------------------------------------------------
        function updateLiveRecap() {
            const titre = document.getElementById('input-titre').value.trim();
            const cat = document.getElementById('input-categorie').value;
            const lieu = document.getElementById('input-lieu').value.trim();
            const prix = document.getElementById('input-prix').value;
            const desc = document.getElementById('input-description').value;

            document.getElementById('recap-title').innerText = titre || 'Titre en attente...';
            document.getElementById('recap-category').innerText = cat || 'Non spécifiée';
            document.getElementById('recap-location').innerText = lieu || 'Non spécifié';

            if (prix) {
                document.getElementById('recap-price').innerText = new Intl.NumberFormat('fr-FR').format(prix) + ' FCFA';
            } else {
                document.getElementById('recap-price').innerText = '0 FCFA';
            }

            document.getElementById('recap-desc').innerText = desc ? `"${desc.slice(0, 120)}${desc.length > 120 ? '...' : ''}"` : '"Aucune description saisie..."';
            document.getElementById('char-counter').innerText = `${desc.length} car.`;
        }

        // -------------------------------------------------------------
        // 5. Pre-Submit Modal (Aperçu avant Publication)
        // -------------------------------------------------------------
        function openPreSubmitModal() {
            if (!validateStep(1)) {
                goToStep(1);
                return;
            }
            if (!validateStep(2)) {
                goToStep(2);
                return;
            }

            const prix = document.getElementById('input-prix').value;
            const desc = document.getElementById('input-description').value.trim();

            if (!prix || prix < 0) {
                showStepError("Veuillez indiquer le montant du prix en FCFA.");
                document.getElementById('input-prix').focus();
                return;
            }
            if (!desc || desc.length < 10) {
                showStepError("Veuillez renseigner une description détaillée (au moins 10 caractères).");
                document.getElementById('input-description').focus();
                return;
            }

            // Alimentation des informations dans la modale
            const titre = document.getElementById('input-titre').value.trim();
            const cat = document.getElementById('input-categorie').value;
            const lieu = document.getElementById('input-lieu').value.trim();

            const radios = document.getElementsByName('etat');
            let etatVal = 'Neuf';
            radios.forEach(r => {
                if (r.checked) etatVal = r.value;
            });

            document.getElementById('modal-title').innerText = titre;
            document.getElementById('modal-categorie-badge').innerText = cat;
            document.getElementById('modal-etat-badge').innerText = etatVal;
            document.getElementById('modal-location').innerText = lieu;
            document.getElementById('modal-price').innerText = new Intl.NumberFormat('fr-FR').format(prix);
            document.getElementById('modal-description').innerText = desc;
            document.getElementById('modal-photos-count').innerText = `${uploadedPhotos.length} photo(s)`;

            // Image de couverture = uploadedPhotos[0]
            const coverImg = document.getElementById('modal-cover-img');
            if (uploadedPhotos.length > 0) {
                coverImg.src = uploadedPhotos[0].dataUrl;
            }

            // Ouverture de la modale
            document.getElementById('presubmit-modal').classList.remove('hidden');
        }

        function closePreSubmitModal() {
            document.getElementById('presubmit-modal').classList.add('hidden');
        }

        function submitConfirmedListing() {
            const btn = document.getElementById('btn-modal-confirm-submit');
            btn.disabled = true;
            btn.innerHTML = `<span class="material-symbols-outlined text-[18px] animate-spin">sync</span><span>Publication en cours...</span>`;

            // Envoi effectif du formulaire vers annonces.store
            syncRealFileInput();
            document.getElementById('form-publier-annonce').submit();
        }

        // -------------------------------------------------------------
        // 6. Galerie Photos / Lightbox (Bouton "Photos" sur les cartes)
        // -------------------------------------------------------------
        let currentGalleryPhotos = [];
        let currentGalleryIndex = 0;

        function openPhotoGallery(photos, title) {
            if (!photos || photos.length === 0) {
                showToast('info', 'Photos', 'Aucune photo supplémentaire pour cette annonce.');
                return;
            }

            // Traitement des chemins : s'il s'agit de strings relatives
            const assetBaseUrl = "{{ asset('') }}";
            currentGalleryPhotos = photos.map(p => {
                if (p.startsWith('http://') || p.startsWith('https://')) return p;
                return assetBaseUrl + p;
            });

            currentGalleryIndex = 0;
            document.getElementById('gallery-title').innerText = title || 'Galerie photos';
            updateGalleryUI();

            document.getElementById('gallery-lightbox-modal').classList.remove('hidden');
        }

        function openGalleryFromElement(el) {
            if (!el) return;
            try {
                const rawPhotos = el.getAttribute('data-photos');
                const photos = rawPhotos ? JSON.parse(rawPhotos) : [];
                const title = el.getAttribute('data-titre') || el.getAttribute('alt') || 'Galerie photos';
                openPhotoGallery(photos, title);
            } catch (e) {
                console.error('Erreur galerie:', e);
            }
        }

        function closePhotoGallery() {
            document.getElementById('gallery-lightbox-modal').classList.add('hidden');
        }

        function updateGalleryUI() {
            const mainImg = document.getElementById('gallery-main-img');
            const counter = document.getElementById('gallery-counter');
            const strip = document.getElementById('gallery-thumbnails-strip');

            mainImg.src = currentGalleryPhotos[currentGalleryIndex];
            counter.innerText = `Photo ${currentGalleryIndex + 1} / ${currentGalleryPhotos.length}`;

            // Miniatures
            strip.innerHTML = '';
            currentGalleryPhotos.forEach((src, idx) => {
                const thumb = document.createElement('img');
                thumb.src = src;
                thumb.className = `w-14 h-14 object-cover rounded-xl cursor-pointer transition-all border-2 ${idx === currentGalleryIndex ? 'border-emerald-500 scale-105' : 'border-transparent opacity-60 hover:opacity-100'}`;
                thumb.onclick = () => {
                    currentGalleryIndex = idx;
                    updateGalleryUI();
                };
                strip.appendChild(thumb);
            });
        }

        function nextGalleryPhoto() {
            if (currentGalleryPhotos.length <= 1) return;
            currentGalleryIndex = (currentGalleryIndex + 1) % currentGalleryPhotos.length;
            updateGalleryUI();
        }

        function prevGalleryPhoto() {
            if (currentGalleryPhotos.length <= 1) return;
            currentGalleryIndex = (currentGalleryIndex - 1 + currentGalleryPhotos.length) % currentGalleryPhotos.length;
            updateGalleryUI();
        }

        // Touches clavier pour la galerie (Flèche gauche / droite / Echap)
        document.addEventListener('keydown', (e) => {
            const gallery = document.getElementById('gallery-lightbox-modal');
            if (gallery && !gallery.classList.contains('hidden')) {
                if (e.key === 'ArrowRight') nextGalleryPhoto();
                else if (e.key === 'ArrowLeft') prevGalleryPhoto();
                else if (e.key === 'Escape') closePhotoGallery();
            }
        });

        // -------------------------------------------------------------
        // 7. Système Toasts
        // -------------------------------------------------------------
        function showToast(type, title, message) {
            const container = document.getElementById('toast-container');
            const toast = document.createElement('div');
            toast.className = 'pointer-events-auto p-4 rounded-2xl shadow-xl border flex items-start gap-3 bg-white text-slate-800 animate-toast-in';

            let icon = 'check_circle';
            let iconColor = 'text-emerald-600 bg-emerald-50';
            if (type === 'error') {
                icon = 'error';
                iconColor = 'text-red-600 bg-red-50';
            } else if (type === 'info') {
                icon = 'info';
                iconColor = 'text-blue-600 bg-blue-50';
            }

            toast.innerHTML = `
                <div class="w-8 h-8 rounded-xl ${iconColor} flex items-center justify-center flex-shrink-0">
                    <span class="material-symbols-outlined text-[20px]">${icon}</span>
                </div>
                <div class="flex-1 min-w-0">
                    <h5 class="text-xs font-bold text-slate-900">${title}</h5>
                    <p class="text-xs text-slate-500 mt-0.5 leading-relaxed">${message}</p>
                </div>
                <button type="button" class="text-slate-400 hover:text-slate-600" onclick="this.parentElement.remove()">
                    <span class="material-symbols-outlined text-[18px]">close</span>
                </button>
            `;

            container.appendChild(toast);
            setTimeout(() => {
                toast.classList.remove('animate-toast-in');
                toast.classList.add('animate-toast-out');
                setTimeout(() => toast.remove(), 300);
            }, 4500);
        }

        // -------------------------------------------------------------
        // 8. Initialisation au chargement de la page
        // -------------------------------------------------------------
        document.addEventListener('DOMContentLoaded', () => {
            renderThumbnails();
            updateStepperUI();
            updateLiveRecap();

            // Gestion des Toasts issus de sessions flash Laravel
            const flashSuccess = document.getElementById('flash-success');
            if (flashSuccess && flashSuccess.dataset.message) {
                showToast('success', 'Succès', flashSuccess.dataset.message);
            }
            const flashError = document.getElementById('flash-error');
            if (flashError && flashError.dataset.message) {
                showToast('error', 'Erreur', flashError.dataset.message);
            }

            // Gestion de l'ancre ou onglet dans l'URL
            const urlParams = new URLSearchParams(window.location.search);
            const tabParam = urlParams.get('tab');
            const hash = window.location.hash.replace('#', '');

            if (tabParam === 'publier' || hash === 'publier') {
                switchDashboardTab('publier');
            } else if (tabParam === 'mes-annonces' || hash === 'mes-annonces') {
                switchDashboardTab('mes-annonces');
            } else if (tabParam === 'profil' || hash === 'profil') {
                switchDashboardTab('profil');
            } else {
                switchDashboardTab('dashboard');
            }

            // Prévisualisation en direct de la photo de profil sélectionnée
            const profilePhotoInput = document.getElementById('profile-photo-input');
            if (profilePhotoInput) {
                profilePhotoInput.addEventListener('change', function(e) {
                    if (e.target.files && e.target.files[0]) {
                        const file = e.target.files[0];
                        const reader = new FileReader();
                        reader.onload = function(evt) {
                            const img = document.getElementById('profile-preview-img');
                            const fallback = document.getElementById('profile-avatar-fallback');
                            if (img) {
                                img.src = evt.target.result;
                                img.classList.remove('hidden');
                            }
                            if (fallback) fallback.classList.add('hidden');
                        };
                        reader.readAsDataURL(file);
                        const nameEl = document.getElementById('profile-file-name');
                        if (nameEl) nameEl.textContent = file.name;
                    }
                });
            }
        });
    </script>
</body>

</html>