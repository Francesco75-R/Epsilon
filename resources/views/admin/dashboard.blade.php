<!DOCTYPE html>
<html class="light" lang="fr">

<head>
    <meta charset="utf-8" />
    <meta content="width=device-width, initial-scale=1.0" name="viewport" />
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Tableau de bord Administrateur | Epsilon</title>

    <script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet" />
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&display=swap" rel="stylesheet" />

    <script>
        tailwind.config = {
            darkMode: "class",
            theme: {
                extend: {
                    colors: {
                        "primary": "#0A1128",
                        "secondary": "#006c4a",
                        "surface": "#f7f9fb",
                    },
                    fontFamily: {
                        sans: ["Plus Jakarta Sans", "sans-serif"]
                    }
                }
            }
        };
    </script>
</head>

<body class="bg-surface font-sans text-slate-900 antialiased min-h-screen flex flex-col">

    <!-- Header supérieur Administration -->
    <header class="h-16 bg-white/95 backdrop-blur-md sticky top-0 z-30 border-b border-slate-200/80 px-4 sm:px-6 lg:px-8 flex items-center justify-between">
        <div class="flex items-center gap-3">
            <a href="{{ route('admin.dashboard') }}" class="flex items-center gap-2.5 group">
                <svg class="h-8 w-auto object-contain" viewBox="0 0 100 100" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <rect width="100" height="100" rx="24" fill="#0A1128" />
                    <path d="M30 35H66C66 35 66 35 66 35C66 37.7614 63.7614 40 61 40H44V49H57C59.7614 49 62 51.2386 62 54C62 56.7614 59.7614 59 57 59H44V68H66C68.7614 68 71 70.2386 71 73C71 75.7614 68.7614 78 66 78H35C31.134 78 28 74.866 28 71V40C28 37.2386 30 35 30 35Z" fill="#FFFFFF" />
                    <circle cx="70" cy="35" r="11" fill="#10B981" />
                    <g transform="translate(52, 47)">
                        <path d="M0 7H15" stroke="#10B981" stroke-width="5" stroke-linecap="round" />
                        <path d="M10 2L15 7L10 12" stroke="#10B981" stroke-width="5" stroke-linecap="round" stroke-linejoin="round" />
                    </g>
                </svg>
                <div class="flex flex-col">
                    <span class="font-extrabold text-lg tracking-tight text-primary leading-none">Epsilon</span>
                    <span class="text-[10px] font-bold text-emerald-600 tracking-wider uppercase">Console Admin</span>
                </div>
            </a>
            <span class="text-slate-300 hidden sm:inline">|</span>
            <span class="text-xs font-bold uppercase tracking-wider text-emerald-800 bg-emerald-50 px-2.5 py-1 rounded-full hidden sm:inline-flex items-center gap-1.5">
                <span class="w-2 h-2 rounded-full bg-emerald-500 animate-pulse"></span>
                <span>Session Administrateur Sécurisée</span>
            </span>
        </div>

        <div class="flex items-center gap-4">
            <div class="hidden sm:flex flex-col text-right">
                <span class="text-xs font-bold text-slate-800">{{ Auth::guard('admin')->user()->prenom }} {{ Auth::guard('admin')->user()->nom }}</span>
                <span class="text-[11px] text-slate-400">{{ Auth::guard('admin')->user()->email }}</span>
            </div>

            <!-- Bouton Déconnexion Administrateur -->
            <form action="{{ route('admin.logout') }}" method="POST">
                @csrf
                <button type="submit" class="inline-flex items-center gap-1.5 text-xs font-bold text-red-600 hover:text-red-700 bg-red-50 hover:bg-red-100 px-3.5 py-2 rounded-xl transition-all cursor-pointer" title="Se déconnecter de l'administration">
                    <span class="material-symbols-outlined text-[18px]">logout</span>
                    <span class="hidden sm:inline">Déconnexion</span>
                </button>
            </form>
        </div>
    </header>

    <!-- Contenu Principal -->
    <main class="flex-1 max-w-7xl w-full mx-auto px-4 sm:px-6 lg:px-8 py-8 space-y-6">

        @if(session('success'))
        <div class="p-4 rounded-2xl bg-emerald-50 border border-emerald-200 text-emerald-800 flex items-start gap-3 shadow-sm">
            <span class="material-symbols-outlined text-emerald-600 text-[22px] flex-shrink-0 mt-0.5">check_circle</span>
            <div>
                <h3 class="text-sm font-extrabold text-emerald-900">Succès</h3>
                <p class="text-xs text-emerald-700 mt-0.5">{{ session('success') }}</p>
            </div>
        </div>
        @endif

        @if(session('error'))
        <div class="p-4 rounded-2xl bg-red-50 border border-red-200 text-red-800 flex items-start gap-3 shadow-sm">
            <span class="material-symbols-outlined text-red-600 text-[22px] flex-shrink-0 mt-0.5">error</span>
            <div>
                <h3 class="text-sm font-extrabold text-red-900">Information</h3>
                <p class="text-xs text-red-700 mt-0.5">{{ session('error') }}</p>
            </div>
        </div>
        @endif

        <!-- Bannière de bienvenue -->
        <div class="bg-gradient-to-br from-primary to-slate-900 text-white rounded-3xl p-6 sm:p-8 shadow-lg relative overflow-hidden">
            <div class="relative z-10 flex flex-col sm:flex-row sm:items-center justify-between gap-4">
                <div class="space-y-2 max-w-2xl">
                    <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-emerald-500/20 border border-emerald-400/30 text-emerald-300 text-xs font-bold">
                        <span class="material-symbols-outlined text-[16px]">admin_panel_settings</span>
                        <span>Console Administrateur</span>
                    </div>
                    <h1 class="text-2xl sm:text-3xl font-extrabold tracking-tight">
                        Bonjour, {{ Auth::guard('admin')->user()->prenom }} {{ Auth::guard('admin')->user()->nom }} !
                    </h1>
                    <p class="text-xs sm:text-sm text-slate-300 leading-relaxed">
                        Bienvenue dans votre espace d'administration Epsilon. Vous pouvez superviser la plateforme, contrôler les comptes et valider les demandes de vérification des vendeurs.
                    </p>
                </div>

                <div class="flex-shrink-0">
                    <span class="inline-flex items-center gap-2 px-4 py-2.5 rounded-2xl bg-emerald-500 text-slate-950 font-extrabold text-xs shadow">
                        <span class="material-symbols-outlined text-[20px]">verified_user</span>
                        <span>Administrateur Actif</span>
                    </span>
                </div>
            </div>
        </div>

        <!-- Section de Gestion des Vérifications Vendeurs -->
        <div class="bg-white rounded-2xl border border-slate-200/80 shadow-sm p-6 space-y-4">
            <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-3 pb-4 border-b border-slate-100">
                <div>
                    <h2 class="text-lg font-extrabold text-slate-900">Demandes de vérification Vendeur</h2>
                    <p class="text-xs text-slate-500">Validez les dossiers des clients pour leur permettre de publier des annonces sur Epsilon.</p>
                </div>
                @php
                    $pendingCount = \App\Models\Verification::where('status', 'En cours')->count();
                @endphp
                <span class="px-3 py-1 rounded-full text-xs font-bold bg-amber-100 text-amber-800 w-max">
                    {{ $pendingCount }} demande(s) en attente
                </span>
            </div>

            @php
                $verifications = \App\Models\Verification::with('user')->latest()->get();
            @endphp

            @if($verifications->isEmpty())
            <div class="py-10 text-center text-slate-400 text-sm">
                <span class="material-symbols-outlined text-4xl mb-2 text-slate-300">inbox</span>
                <p>Aucune demande de vérification enregistrée pour le moment.</p>
            </div>
            @else
            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse text-xs">
                    <thead>
                        <tr class="text-slate-400 uppercase tracking-wider border-b border-slate-100 pb-2">
                            <th class="py-2.5 px-3">Date</th>
                            <th class="py-2.5 px-3">Utilisateur</th>
                            <th class="py-2.5 px-3">Selfie</th>
                            <th class="py-2.5 px-3">Carte d'identité</th>
                            <th class="py-2.5 px-3">Statut actuel</th>
                            <th class="py-2.5 px-3 text-right">Actions de validation</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100">
                        @foreach($verifications as $v)
                        <tr class="hover:bg-slate-50/70 transition-colors">
                            <td class="py-3 px-3 text-slate-500 whitespace-nowrap">
                                {{ $v->created_at?->format('d/m/Y H:i') }}
                            </td>
                            <td class="py-3 px-3">
                                <div class="font-bold text-slate-900">{{ $v->user?->prenom }} {{ $v->user?->nom }}</div>
                                <div class="text-[11px] text-slate-400">{{ $v->user?->email }}</div>
                            </td>
                            <td class="py-3 px-3">
                                @if($v->photo && file_exists(public_path($v->photo)))
                                <a href="{{ asset($v->photo) }}" target="_blank" class="inline-flex items-center gap-1 font-bold text-emerald-600 hover:underline">
                                    <span class="material-symbols-outlined text-[16px]">visibility</span>
                                    <span>Voir Selfie</span>
                                </a>
                                @else
                                <span class="text-slate-400">Non disponible</span>
                                @endif
                            </td>
                            <td class="py-3 px-3">
                                @if($v->carte && file_exists(public_path($v->carte)))
                                <a href="{{ asset($v->carte) }}" target="_blank" class="inline-flex items-center gap-1 font-bold text-emerald-600 hover:underline">
                                    <span class="material-symbols-outlined text-[16px]">badge</span>
                                    <span>Voir Carte</span>
                                </a>
                                @else
                                <span class="text-slate-400">Non disponible</span>
                                @endif
                            </td>
                            <td class="py-3 px-3">
                                <span class="px-2.5 py-0.5 rounded-full text-[11px] font-bold
                                    {{ $v->isVerifiedStatus() ? 'bg-emerald-100 text-emerald-800' : (in_array(mb_strtolower($v->status), ['rejeté', 'rejete', 'rejected']) ? 'bg-red-100 text-red-800' : 'bg-amber-100 text-amber-800') }}">
                                    {{ $v->status }}
                                </span>
                            </td>
                            <td class="py-3 px-3 text-right whitespace-nowrap">
                                @if(!$v->isVerifiedStatus())
                                <div class="inline-flex items-center gap-2">
                                    <form action="{{ route('verification.valider', $v->id) }}" method="POST" onsubmit="return confirm('Confirmez-vous la validation de cette pièce d\'identité ? Le client deviendra automatiquement Vendeur et recevra un e-mail de félicitations.');">
                                        @csrf
                                        <button type="submit" class="px-3 py-1.5 rounded-lg bg-emerald-600 hover:bg-emerald-700 text-white font-bold text-xs shadow-sm transition-all cursor-pointer">
                                            ✓ Valider Vendeur
                                        </button>
                                    </form>
                                    <form action="{{ route('verification.rejeter', $v->id) }}" method="POST" onsubmit="return confirm('Rejeter cette demande ? Un e-mail d\'information sera envoyé au client.');">
                                        @csrf
                                        <button type="submit" class="px-2.5 py-1.5 rounded-lg bg-red-100 hover:bg-red-200 text-red-700 font-bold text-xs transition-all cursor-pointer">
                                            ✕ Rejeter
                                        </button>
                                    </form>
                                </div>
                                @else
                                <div class="inline-flex items-center gap-3">
                                    <span class="text-emerald-700 font-semibold text-xs flex items-center gap-1">
                                        <span class="material-symbols-outlined text-[16px]">check_circle</span>
                                        <span>Compte Vendeur Activé</span>
                                    </span>
                                    <form action="{{ route('verification.rejeter', $v->id) }}" method="POST" onsubmit="return confirm('Êtes-vous sûr de vouloir révoquer ce statut Vendeur ? Un e-mail de notification sera envoyé au client.');">
                                        @csrf
                                        <button type="submit" class="px-2 py-1 rounded bg-slate-100 hover:bg-red-50 text-slate-500 hover:text-red-600 text-[11px] font-semibold border border-slate-200 transition-all cursor-pointer" title="Révoquer / Rejeter">
                                            Révoquer
                                        </button>
                                    </form>
                                </div>
                                @endif
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            @endif
        </div>
    </main>

</body>

</html>

