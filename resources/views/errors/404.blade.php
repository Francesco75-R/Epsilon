<!DOCTYPE html>
<html lang="fr" class="h-full">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Page Introuvable - 404 | Epsilon Marketplace</title>
    
    <!-- Google Fonts: Plus Jakarta Sans -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    
    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        brand: '#0A1128',
                        accent: '#10B981',
                        'accent-dark': '#006c4a',
                    },
                    fontFamily: {
                        sans: ['"Plus Jakarta Sans"', 'sans-serif'],
                    }
                }
            }
        }
    </script>
</head>
<body class="h-full bg-slate-50 text-slate-800 font-sans antialiased flex flex-col justify-between">

    <!-- En-tête simplifié -->
    <header class="w-full bg-white border-b border-slate-200/80 py-4 px-6 sm:px-10">
        <div class="max-w-7xl mx-auto flex items-center justify-between">
            <a href="{{ route('home') }}" class="flex items-center gap-3 group text-decoration-none">
                <svg width="36" height="36" viewBox="0 0 100 100" fill="none" xmlns="http://www.w3.org/2000/svg" class="transition-transform group-hover:scale-105">
                    <rect width="100" height="100" rx="24" fill="#0A1128" />
                    <path d="M30 35H66C66 37.7614 63.7614 40 61 40H44V49H57C59.7614 49 62 51.2386 62 54C62 56.7614 59.7614 59 57 59H44V68H66C68.7614 68 71 70.2386 71 73C71 75.7614 68.7614 78 66 78H35C31.134 78 28 74.866 28 71V40C28 37.2386 30 35 30 35Z" fill="#FFFFFF" />
                    <circle cx="70" cy="35" r="11" fill="#10B981" />
                    <g transform="translate(52, 47)">
                        <path d="M0 7H15" stroke="#10B981" stroke-width="5" stroke-linecap="round" />
                        <path d="M10 2L15 7L10 12" stroke="#10B981" stroke-width="5" stroke-linecap="round" stroke-linejoin="round" />
                    </g>
                </svg>
                <div class="flex flex-col">
                    <span class="text-xl font-extrabold text-brand tracking-tight leading-tight">Epsilon</span>
                    <span class="text-[10px] uppercase font-bold text-accent tracking-widest leading-none">Marketplace</span>
                </div>
            </a>

            <div class="flex items-center gap-3">
                <a href="{{ route('home') }}" class="text-sm font-semibold text-slate-600 hover:text-brand transition-colors">
                    Accueil
                </a>
                <a href="{{ route('login') }}" class="text-xs sm:text-sm font-semibold px-4 py-2 rounded-xl bg-slate-100 hover:bg-slate-200 text-slate-800 transition-colors">
                    Connexion
                </a>
            </div>
        </div>
    </header>

    <!-- Contenu Principal -->
    <main class="flex-grow flex items-center justify-center px-6 py-16">
        <div class="max-w-xl w-full text-center">
            <!-- Badge 404 -->
            <div class="inline-flex items-center gap-2 px-4 py-1.5 rounded-full bg-emerald-50 text-accent-dark border border-emerald-200/80 font-bold text-xs uppercase tracking-wider mb-6 shadow-sm">
                <span class="w-2 h-2 rounded-full bg-emerald-500 animate-ping"></span>
                Code Erreur HTTP 404 • Ressource Introuvable
            </div>

            <!-- Illustration Stylisée 404 -->
            <div class="relative my-4 select-none">
                <h1 class="text-8xl sm:text-9xl font-black text-slate-200 tracking-tighter">404</h1>
                <div class="absolute inset-0 flex items-center justify-center">
                    <div class="w-20 h-20 rounded-2xl bg-brand text-white flex items-center justify-center shadow-xl rotate-6 border border-slate-700">
                        <svg class="w-10 h-10 text-emerald-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                        </svg>
                    </div>
                </div>
            </div>

            <!-- Titre & Message -->
            <h2 class="text-2xl sm:text-3xl font-extrabold text-slate-900 mt-6 tracking-tight">
                Cette page ou cette annonce n'existe pas.
            </h2>
            <p class="text-slate-600 text-sm sm:text-base mt-3 leading-relaxed max-w-md mx-auto">
                L'URL saisie est peut-être erronée, l'annonce a expiré ou le vendeur a supprimé sa publication.
            </p>

            <!-- Actions -->
            <div class="flex flex-col sm:flex-row items-center justify-center gap-3 mt-8">
                <a href="{{ route('home') }}" class="w-full sm:w-auto inline-flex items-center justify-center gap-2 px-6 py-3.5 rounded-xl bg-brand hover:bg-slate-900 text-white font-bold text-sm shadow-lg shadow-brand/20 transition-all hover:-translate-y-0.5">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
                    </svg>
                    Retour à l'accueil Epsilon
                </a>

                <button onclick="window.history.back()" class="w-full sm:w-auto inline-flex items-center justify-center gap-2 px-5 py-3.5 rounded-xl bg-white hover:bg-slate-100 text-slate-700 font-semibold text-sm border border-slate-300 transition-colors">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                    </svg>
                    Page précédente
                </button>
            </div>
        </div>
    </main>

    <!-- Pied de page -->
    <footer class="w-full py-5 text-center text-xs text-slate-500 border-t border-slate-200 bg-white">
        © {{ date('Y') }} Epsilon Marketplace Togo • Plateforme nationale sécurisée.
    </footer>

</body>
</html>

