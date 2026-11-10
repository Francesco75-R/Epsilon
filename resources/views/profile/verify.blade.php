<!DOCTYPE html>
<html class="light" lang="fr">

<head>
    <meta charset="utf-8" />
    <meta content="width=device-width, initial-scale=1.0" name="viewport" />
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Vérification du Compte Vendeur | Epsilon Marketplace</title>

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

    <!-- Barre de navigation supérieure -->
    <header class="h-16 bg-white/95 backdrop-blur-md sticky top-0 z-30 border-b border-slate-200/80 px-4 sm:px-6 lg:px-8 flex items-center justify-between">
        <div class="flex items-center gap-3">
            <a href="{{ route('dashboard') }}" class="flex items-center gap-2.5 group">
                <svg class="h-8 w-auto object-contain" viewBox="0 0 100 100" fill="none" xmlns="http://www.w3.org/2000/svg">
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
            <span class="text-slate-300 hidden sm:inline">|</span>
            <span class="text-xs font-bold uppercase tracking-wider text-emerald-700 bg-emerald-50 px-2.5 py-1 rounded-full hidden sm:inline-block">
                Vérification d'identité Vendeur
            </span>
        </div>

        <a href="{{ route('dashboard', ['tab' => 'profil']) }}" class="inline-flex items-center gap-1.5 text-xs font-bold text-slate-700 hover:text-emerald-700 bg-slate-100 hover:bg-slate-200 px-3.5 py-2 rounded-xl transition-all">
            <span class="material-symbols-outlined text-[18px]">arrow_back</span>
            <span>Retour au Dashboard</span>
        </a>
    </header>

    <!-- Contenu principal -->
    <main class="flex-1 max-w-4xl w-full mx-auto px-4 sm:px-6 py-8 sm:py-10 space-y-6">

        <!-- Alertes Flash (Erreur de restriction ou Succès) -->
        @if(session('error'))
        <div class="p-4 rounded-2xl bg-red-50 border border-red-200 text-red-800 flex items-start gap-3 shadow-sm">
            <span class="material-symbols-outlined text-red-600 text-[22px] flex-shrink-0 mt-0.5">gpp_maybe</span>
            <div>
                <h3 class="text-sm font-extrabold text-red-900">Accès restreint aux comptes Vendeurs vérifiés</h3>
                <p class="text-xs text-red-700 mt-0.5">{{ session('error') }}</p>
            </div>
        </div>
        @endif

        @if(session('success'))
        <div class="p-4 rounded-2xl bg-emerald-50 border border-emerald-200 text-emerald-800 flex items-start gap-3 shadow-sm">
            <span class="material-symbols-outlined text-emerald-600 text-[22px] flex-shrink-0 mt-0.5">check_circle</span>
            <div>
                <h3 class="text-sm font-extrabold text-emerald-900">Opération réussie</h3>
                <p class="text-xs text-emerald-700 mt-0.5">{{ session('success') }}</p>
            </div>
        </div>
        @endif

        @if($errors->any())
        <div class="p-4 rounded-2xl bg-red-50 border border-red-200 text-red-800 shadow-sm">
            <div class="flex items-center gap-2 font-extrabold text-sm mb-1.5 text-red-900">
                <span class="material-symbols-outlined text-[20px] text-red-600">error</span>
                <span>Veuillez corriger les erreurs suivantes :</span>
            </div>
            <ul class="list-disc list-inside text-xs space-y-1 text-red-700">
                @foreach($errors->all() as $err)
                <li>{{ $err }}</li>
                @endforeach
            </ul>
        </div>
        @endif

        <!-- En-tête de la page -->
        <div class="bg-gradient-to-br from-primary to-slate-900 text-white rounded-3xl p-6 sm:p-8 shadow-lg relative overflow-hidden">
            <div class="relative z-10 flex flex-col sm:flex-row sm:items-center justify-between gap-4">
                <div class="space-y-2 max-w-xl">
                    <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-emerald-500/20 border border-emerald-400/30 text-emerald-300 text-xs font-bold">
                        <span class="material-symbols-outlined text-[16px]">verified_user</span>
                        <span>Mutation Compte Client → Compte Vendeur</span>
                    </div>
                    <h1 class="text-2xl sm:text-3xl font-extrabold tracking-tight">Vérifiez votre identité</h1>
                    <p class="text-xs sm:text-sm text-slate-300 leading-relaxed">
                        Pour garantir la sécurité des transactions sur Epsilon Marketplace et débloquer la publication d'annonces, veuillez fournir une photo claire de votre visage (selfie) ainsi qu'une photo lisible de votre pièce d'identité.
                    </p>
                </div>

                <div class="flex-shrink-0">
                    @if(($user->profil ?? 'client') === 'vendeur')
                    <span class="inline-flex items-center gap-1.5 px-4 py-2 rounded-2xl bg-emerald-500 text-slate-950 font-extrabold text-xs shadow">
                        <span class="material-symbols-outlined text-[18px]">verified</span>
                        <span>Compte Vendeur Actif</span>
                    </span>
                    @else
                    <span class="inline-flex items-center gap-1.5 px-4 py-2 rounded-2xl bg-amber-400/20 border border-amber-400/40 text-amber-300 font-bold text-xs">
                        <span class="material-symbols-outlined text-[18px]">person</span>
                        <span>Statut actuel : Compte Client</span>
                    </span>
                    @endif
                </div>
            </div>
        </div>

        <!-- État de la dernière demande si existante -->
        @if($latestVerification)
        <div class="bg-white rounded-2xl p-5 border border-slate-200/80 shadow-sm flex flex-col sm:flex-row sm:items-center justify-between gap-4">
            <div class="flex items-start gap-3.5">
                @if($latestVerification->isVerifiedStatus())
                <div class="w-11 h-11 rounded-xl bg-emerald-50 text-emerald-600 flex items-center justify-center flex-shrink-0">
                    <span class="material-symbols-outlined text-[24px]">verified</span>
                </div>
                <div>
                    <h3 class="text-sm font-bold text-slate-900">Dernière demande : Vérifiée (<code class="text-emerald-700 font-bold">{{ $latestVerification->status }}</code>)</h3>
                    <p class="text-xs text-slate-500 mt-0.5">
                        Soumise le {{ $latestVerification->created_at?->format('d/m/Y à H:i') }}
                        @if($latestVerification->verified_at)
                        • Validée le {{ $latestVerification->verified_at->format('d/m/Y à H:i') }}
                        @endif
                    </p>
                </div>
                @elseif(in_array(mb_strtolower($latestVerification->status), ['rejeté', 'rejete', 'rejected']))
                <div class="w-11 h-11 rounded-xl bg-red-50 text-red-600 flex items-center justify-center flex-shrink-0">
                    <span class="material-symbols-outlined text-[24px]">cancel</span>
                </div>
                <div>
                    <h3 class="text-sm font-bold text-slate-900">Dernière demande : Rejetée</h3>
                    <p class="text-xs text-slate-500 mt-0.5">Veuillez soumettre à nouveau des photos nettes et lisibles ci-dessous.</p>
                </div>
                @else
                <div class="w-11 h-11 rounded-xl bg-amber-50 text-amber-600 flex items-center justify-center flex-shrink-0">
                    <span class="material-symbols-outlined text-[24px]">hourglass_top</span>
                </div>
                <div>
                    <h3 class="text-sm font-bold text-slate-900">Demande en cours de vérification (<code class="text-amber-700 font-bold">{{ $latestVerification->status }}</code>)</h3>
                    <p class="text-xs text-slate-500 mt-0.5">Dossier enregistré le {{ $latestVerification->created_at?->format('d/m/Y à H:i') }}. Votre profil passera automatiquement en <strong>Vendeur</strong> dès validation.</p>
                </div>
                @endif
            </div>
            <span class="px-3 py-1 rounded-full text-xs font-bold w-max
                {{ $latestVerification->isVerifiedStatus() ? 'bg-emerald-100 text-emerald-800' : (in_array(mb_strtolower($latestVerification->status), ['rejeté', 'rejete', 'rejected']) ? 'bg-red-100 text-red-800' : 'bg-amber-100 text-amber-800') }}">
                {{ $latestVerification->status }}
            </span>
        </div>
        @endif

        <!-- Formulaire de téléversement des justificatifs -->
        <form action="{{ route('verification.store') }}" method="POST" enctype="multipart/form-data" class="bg-white rounded-3xl border border-slate-200/80 shadow-sm p-6 sm:p-8 space-y-8" id="verification-form">
            @csrf

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

                <!-- 1. Champ Selfie (Photo claire du visage) -->
                <div class="flex flex-col justify-between rounded-2xl border-2 border-dashed border-slate-200 hover:border-emerald-500/60 bg-slate-50/50 p-5 transition-all" id="card-photo">
                    <div class="space-y-3">
                        <div class="flex items-center justify-between">
                            <span class="inline-flex items-center gap-1.5 text-xs font-extrabold uppercase tracking-wider text-emerald-700 bg-emerald-50 px-2.5 py-1 rounded-lg">
                                <span class="material-symbols-outlined text-[16px]">face</span>
                                <span>Étape 1 • Selfie</span>
                            </span>
                            <span class="text-[11px] font-semibold text-slate-400">Max 10 Mo</span>
                        </div>

                        <h2 class="text-base font-extrabold text-slate-900">Photo claire du visage <span class="text-red-500">*</span></h2>
                        <p class="text-xs text-slate-500 leading-relaxed">
                            Prenez un selfie récent, visage découvert et bien éclairé, sans lunettes de soleil ni chapeau.
                            <strong class="text-slate-700 block mt-1">Formats acceptés : JPG, JPEG, PNG, WEBP uniquement.</strong>
                        </p>
                    </div>

                    <!-- Zone de prévisualisation Selfie -->
                    <div class="my-4 relative w-full h-52 rounded-xl bg-white border border-slate-200/80 overflow-hidden flex flex-col items-center justify-center cursor-pointer group" onclick="document.getElementById('input-photo').click()">
                        <img id="preview-photo" src="" alt="Aperçu Selfie" class="w-full h-full object-cover hidden" />
                        <div id="placeholder-photo" class="flex flex-col items-center justify-center text-center p-4">
                            <div class="w-12 h-12 rounded-2xl bg-emerald-50 text-emerald-600 flex items-center justify-center mb-2 group-hover:scale-110 transition-transform">
                                <span class="material-symbols-outlined text-[28px]">photo_camera</span>
                            </div>
                            <span class="text-xs font-bold text-slate-700">Cliquez pour choisir votre selfie</span>
                            <span class="text-[11px] text-slate-400 mt-0.5">Image JPG, PNG ou WEBP (Max 10 Mo)</span>
                        </div>
                    </div>

                    <div>
                        <input type="file" name="photo" id="input-photo" accept="image/jpeg,image/png,image/jpg,image/webp" required class="block w-full text-xs text-slate-600 file:mr-3 file:py-2 file:px-4 file:rounded-xl file:border-0 file:text-xs file:font-bold file:bg-emerald-50 file:text-emerald-700 hover:file:bg-emerald-100 cursor-pointer" />
                        @error('photo')
                        <p class="text-xs text-red-600 font-semibold mt-1.5">{{ $message }}</p>
                        @enderror
                        <p id="error-photo-js" class="text-xs text-red-600 font-semibold mt-1.5 hidden"></p>
                    </div>
                </div>

                <!-- 2. Champ Carte d'identité (Image uniquement, interdiction stricte des PDF) -->
                <div class="flex flex-col justify-between rounded-2xl border-2 border-dashed border-slate-200 hover:border-emerald-500/60 bg-slate-50/50 p-5 transition-all" id="card-carte">
                    <div class="space-y-3">
                        <div class="flex items-center justify-between">
                            <span class="inline-flex items-center gap-1.5 text-xs font-extrabold uppercase tracking-wider text-emerald-700 bg-emerald-50 px-2.5 py-1 rounded-lg">
                                <span class="material-symbols-outlined text-[16px]">badge</span>
                                <span>Étape 2 • Pièce d'identité</span>
                            </span>
                            <span class="text-[11px] font-bold text-red-600 bg-red-50 px-2 py-0.5 rounded-md">PDF Interdit</span>
                        </div>

                        <h2 class="text-base font-extrabold text-slate-900">Photo de la carte d'identité <span class="text-red-500">*</span></h2>
                        <p class="text-xs text-slate-500 leading-relaxed">
                            Importez une photo nette et lisible de votre Carte Nationale d'Identité, Passeport ou Carte d'électeur.
                            <strong class="text-red-600 block mt-1">Image uniquement (JPG, PNG, WEBP) — Les fichiers PDF sont strictement interdits (Max 10 Mo).</strong>
                        </p>
                    </div>

                    <!-- Zone de prévisualisation Carte -->
                    <div class="my-4 relative w-full h-52 rounded-xl bg-white border border-slate-200/80 overflow-hidden flex flex-col items-center justify-center cursor-pointer group" onclick="document.getElementById('input-carte').click()">
                        <img id="preview-carte" src="" alt="Aperçu Carte d'identité" class="w-full h-full object-contain bg-slate-900/5 hidden" />
                        <div id="placeholder-carte" class="flex flex-col items-center justify-center text-center p-4">
                            <div class="w-12 h-12 rounded-2xl bg-emerald-50 text-emerald-600 flex items-center justify-center mb-2 group-hover:scale-110 transition-transform">
                                <span class="material-symbols-outlined text-[28px]">id_card</span>
                            </div>
                            <span class="text-xs font-bold text-slate-700">Cliquez pour choisir la photo de la carte</span>
                            <span class="text-[11px] text-slate-400 mt-0.5">Image JPG, PNG ou WEBP uniquement (Max 10 Mo)</span>
                        </div>
                    </div>

                    <div>
                        <input type="file" name="carte" id="input-carte" accept="image/jpeg,image/png,image/jpg,image/webp" required class="block w-full text-xs text-slate-600 file:mr-3 file:py-2 file:px-4 file:rounded-xl file:border-0 file:text-xs file:font-bold file:bg-emerald-50 file:text-emerald-700 hover:file:bg-emerald-100 cursor-pointer" />
                        @error('carte')
                        <p class="text-xs text-red-600 font-semibold mt-1.5">{{ $message }}</p>
                        @enderror
                        <p id="error-carte-js" class="text-xs text-red-600 font-semibold mt-1.5 hidden"></p>
                    </div>
                </div>

            </div>

            <!-- Note de confidentialité & Bouton de soumission -->
            <div class="pt-4 border-t border-slate-100 flex flex-col sm:flex-row sm:items-center justify-between gap-4">
                <div class="flex items-start gap-2.5 text-xs text-slate-500 max-w-md">
                    <span class="material-symbols-outlined text-emerald-600 text-[18px] flex-shrink-0 mt-0.5">lock</span>
                    <span>Vos documents sont chiffrés et utilisés exclusivement par l'équipe Epsilon pour certifier votre statut de Vendeur.</span>
                </div>

                <div class="flex items-center gap-3 self-end sm:self-auto">
                    <a href="{{ route('dashboard', ['tab' => 'profil']) }}" class="px-5 py-3 rounded-xl border border-slate-200 text-xs font-bold text-slate-600 hover:bg-slate-50 transition-all">
                        Annuler
                    </a>
                    <button type="submit" class="inline-flex items-center gap-2 px-6 py-3 bg-emerald-600 hover:bg-emerald-700 text-white font-bold text-xs sm:text-sm rounded-xl shadow-md hover:shadow-lg transition-all active:scale-[0.98] cursor-pointer">
                        <span class="material-symbols-outlined text-[18px]">verified_user</span>
                        <span>Envoyer ma demande de vérification</span>
                    </button>
                </div>
            </div>
        </form>
    </main>

    <script>
        const allowedMimeTypes = ['image/jpeg', 'image/png', 'image/jpg', 'image/webp'];
        const maxFileSize = 10 * 1024 * 1024; // 10 Mo

        function setupImagePreview(inputId, previewId, placeholderId, errorId) {
            const input = document.getElementById(inputId);
            const preview = document.getElementById(previewId);
            const placeholder = document.getElementById(placeholderId);
            const errorEl = document.getElementById(errorId);

            if (!input) return;

            input.addEventListener('change', function(e) {
                errorEl.classList.add('hidden');
                errorEl.textContent = '';

                if (!e.target.files || !e.target.files[0]) {
                    preview.classList.add('hidden');
                    placeholder.classList.remove('hidden');
                    return;
                }

                const file = e.target.files[0];

                // Interdiction stricte des PDF et formats non-image
                if (file.type === 'application/pdf' || file.name.toLowerCase().endsWith('.pdf') || !allowedMimeTypes.includes(file.type)) {
                    errorEl.textContent = 'Format interdit : veuillez sélectionner uniquement une image (JPG, PNG ou WEBP). Les fichiers PDF sont strictement refusés.';
                    errorEl.classList.remove('hidden');
                    input.value = '';
                    preview.classList.add('hidden');
                    placeholder.classList.remove('hidden');
                    return;
                }

                if (file.size > maxFileSize) {
                    errorEl.textContent = 'Le fichier dépasse la taille maximale autorisée de 10 Mo.';
                    errorEl.classList.remove('hidden');
                    input.value = '';
                    preview.classList.add('hidden');
                    placeholder.classList.remove('hidden');
                    return;
                }

                const reader = new FileReader();
                reader.onload = function(evt) {
                    preview.src = evt.target.result;
                    preview.classList.remove('hidden');
                    placeholder.classList.add('hidden');
                };
                reader.readAsDataURL(file);
            });
        }

        setupImagePreview('input-photo', 'preview-photo', 'placeholder-photo', 'error-photo-js');
        setupImagePreview('input-carte', 'preview-carte', 'placeholder-carte', 'error-carte-js');
    </script>
</body>

</html>

