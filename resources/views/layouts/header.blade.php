<!-- ================================================================= -->
<!-- HEADER PRINCIPAL (Réorganisé, Moderne & Harmonieux)               -->
<!-- ================================================================= -->
<header class="fixed top-0 left-0 right-0 z-50 bg-white/95 backdrop-blur-xl border-b border-slate-200/80 shadow-[0_1px_12px_rgba(15,23,42,0.04)]">
    <div class="h-20 max-w-[1360px] mx-auto px-4 sm:px-6 lg:px-8 flex items-center justify-between gap-4 lg:gap-6">

        <!-- 1. GAUCHE: Logo officiel Epsilon & Navigation desktop -->
        <div class="flex items-center gap-6 lg:gap-8 flex-shrink-0">
            <!-- Logo & Marque -->
            <a class="flex items-center gap-3 group" href="{{ url('/') }}" aria-label="Epsilon Accueil">
                <svg class="h-8 w-auto object-contain" viewBox="0 0 100 100" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <!-- Fond Bleu Marine -->
                    <rect width="100" height="100" rx="24" fill="#0A1128" />

                    <!-- Lettre E en Blanc -->
                    <path d="M30 35H66C66 35 66 35 66 35C66 37.7614 63.7614 40 61 40H44V49H57C59.7614 49 62 51.2386 62 54C62 56.7614 59.7614 59 57 59H44V68H66C68.7614 68 71 70.2386 71 73C71 75.7614 68.7614 78 66 78H35C31.134 78 28 74.866 28 71V40C28 37.2386 30 35 30 35Z" fill="#FFFFFF" />

                    <!-- Pastille Verte -->
                    <circle cx="70" cy="35" r="11" fill="#10B981" />

                    <!-- Flèche Verte -->
                    <g transform="translate(52, 47)">
                        <path d="M0 7H15" stroke="#10B981" stroke-width="5" stroke-linecap="round" />
                        <path d="M10 2L15 7L10 12" stroke="#10B981" stroke-width="5" stroke-linecap="round" stroke-linejoin="round" />
                    </g>
                </svg>
                <div class="flex flex-col">
                    <span class="font-extrabold text-2xl tracking-tight text-primary leading-none">Epsilon</span>
                    <span class="text-[10px] font-semibold text-secondary uppercase tracking-widest leading-tight mt-0.5">Marketplace</span>
                </div>
            </a>

            <!-- Liens de navigation (Grand écran) -->
            <nav class="hidden xl:flex items-center gap-1.5" aria-label="Menu principal">
                <a aria-current="page" class="px-3.5 py-2 rounded-xl text-sm font-bold bg-slate-100 text-primary transition-all" href="{{ url('/') }}">
                    Accueil
                </a>
                <a class="px-3.5 py-2 rounded-xl text-sm font-medium text-slate-600 hover:text-primary hover:bg-slate-50 transition-all" href="#listing-feed">
                    Explorer
                </a>
                <a class="px-3.5 py-2 rounded-xl text-sm font-medium text-slate-600 hover:text-primary hover:bg-slate-50 transition-all" href="#">
                    Boutiques Pro
                </a>
            </nav>
        </div>

        <!-- 2. CENTRE: Barre de recherche intégrée (Desktop & Tablette - 100% Opérationnelle) -->
        <form action="{{ route('home') }}" method="GET" class="hidden md:flex flex-1 max-w-2xl items-center bg-slate-100/90 hover:bg-slate-100/100 rounded-2xl p-1.5 shadow-[0_1px_3px_rgba(15,23,42,0.04)] border border-slate-200/80 transition-all focus-within:border-secondary focus-within:bg-white focus-within:ring-2 focus-within:ring-secondary/20">
            <!-- Champ recherche textuelle -->
            <div class="flex items-center flex-1 px-3">
                <span class="material-symbols-outlined text-slate-400 text-[20px] mr-2">search</span>
                <input id="header-search-input" name="q" value="{{ request('q') }}" class="w-full bg-transparent border-none outline-none text-sm text-slate-900 placeholder:text-slate-400" placeholder="Que recherchez-vous ? (ex: Toyota, iPhone...)" type="text" />
            </div>

            <!-- Séparateur vertical -->
            <div class="h-6 w-px bg-slate-200"></div>

            <!-- Sélecteur de catégorie -->
            <div class="flex items-center px-2">
                <select name="categorie" class="bg-transparent border-none outline-none text-xs font-medium text-slate-600 cursor-pointer pr-2 hover:text-primary transition-colors" aria-label="Catégories">
                    <option value="">Toutes catégories</option>
                    <option value="Véhicules" {{ request('categorie') == 'Véhicules' ? 'selected' : '' }}>Véhicules</option>
                    <option value="Immobilier" {{ request('categorie') == 'Immobilier' ? 'selected' : '' }}>Immobilier</option>
                    <option value="Smartphones & Tech" {{ request('categorie') == 'Smartphones & Tech' ? 'selected' : '' }}>Smartphones & Tech</option>
                    <option value="Mode & Maison" {{ request('categorie') == 'Mode & Maison' ? 'selected' : '' }}>Mode & Maison</option>
                    <option value="Emploi & Services" {{ request('categorie') == 'Emploi & Services' ? 'selected' : '' }}>Emploi & Services</option>
                </select>
            </div>

            <!-- Séparateur vertical -->
            <div class="h-6 w-px bg-slate-200"></div>

            <!-- Sélecteur de localisation -->
            <div class="flex items-center px-2">
                <span class="material-symbols-outlined text-slate-400 text-[18px] mr-1">location_on</span>
                <select name="lieu" class="bg-transparent border-none outline-none text-xs font-medium text-slate-600 cursor-pointer hover:text-primary transition-colors" aria-label="Localisation">
                    <option value="">Tout le Togo</option>
                    <option value="Lomé" {{ request('lieu') == 'Lomé' ? 'selected' : '' }}>Lomé</option>
                    <option value="Kara" {{ request('lieu') == 'Kara' ? 'selected' : '' }}>Kara</option>
                    <option value="Sokodé" {{ request('lieu') == 'Sokodé' ? 'selected' : '' }}>Sokodé</option>
                    <option value="Kpalimé" {{ request('lieu') == 'Kpalimé' ? 'selected' : '' }}>Kpalimé</option>
                    <option value="Atakpamé" {{ request('lieu') == 'Atakpamé' ? 'selected' : '' }}>Atakpamé</option>
                </select>
            </div>

            <!-- Bouton de validation de recherche (Loupe) -->
            <button type="submit" class="flex items-center justify-center bg-secondary hover:bg-on-secondary-container text-white p-2.5 rounded-xl shadow-sm hover:scale-105 transition-all ml-1 flex-shrink-0 cursor-pointer" aria-label="Lancer la recherche">
                <span class="material-symbols-outlined text-[19px]">search</span>
            </button>
        </form>

        <!-- 3. DROITE: Actions utilisateur, Favoris, Messagerie, Bouton CTA & Profil -->
        <div class="flex items-center gap-2.5 sm:gap-3 flex-shrink-0">
            <!-- Bouton recherche sur mobile (déploie la barre mobile) -->
            <button class="md:hidden p-2.5 rounded-xl hover:bg-slate-100 text-slate-600 transition-colors flex items-center justify-center" type="button" onclick="toggleMobileSearch()" aria-label="Ouvrir la recherche mobile">
                <span class="material-symbols-outlined text-[22px]">search</span>
            </button>

            <!-- Favoris avec badge interactif -->
            <a class="relative p-2.5 rounded-xl hover:bg-slate-100 hover:text-primary text-slate-600 transition-colors flex items-center justify-center" href="#listing-feed" title="Mes Favoris" aria-label="Mes Favoris">
                <span class="material-symbols-outlined text-[22px]">favorite</span>
                <span id="fav-count-badge" class="absolute top-1.5 right-1.5 flex items-center justify-center w-4 h-4 bg-error text-white font-bold text-[10px] rounded-full shadow-sm">3</span>
            </a>

            <!-- Messagerie instantanée avec badge -->
            <a class="relative p-2.5 rounded-xl hover:bg-slate-100 hover:text-primary text-slate-600 transition-colors flex items-center justify-center" href="#" title="Messagerie" aria-label="Messagerie">
                <span class="material-symbols-outlined text-[22px]">chat_bubble</span>
                <span class="absolute top-1.5 right-1.5 flex items-center justify-center w-4 h-4 bg-secondary text-white font-bold text-[10px] rounded-full shadow-sm">2</span>
            </a>

            <!-- Bouton Déposer une annonce (CTA mis en valeur) -->
            <a class="hidden sm:inline-flex items-center gap-2 bg-secondary hover:bg-on-secondary-container text-white font-bold text-sm px-4 py-2.5 rounded-xl shadow-md hover:shadow-lg transition-all" href="{{ route('dashboard', ['tab' => 'publier']) }}" title="Déposer une annonce">
                <span class="material-symbols-outlined text-[20px]">add_circle</span>
                <span>Déposer une annonce</span>
            </a>

            <!-- Avatar profil utilisateur avec photo réelle via son ID -->
            @php
            $clientId = Auth::id();
            $client = $client ?? ($clientId ? \App\Models\User::find($clientId) : null);
            @endphp

            @if($client)
            <div class="relative group" id="user-menu-wrapper">
                <button type="button" class="flex items-center gap-2 pl-1 group cursor-pointer focus:outline-none" onclick="document.getElementById('user-dropdown-menu').classList.toggle('hidden')" aria-label="Menu Mon Compte">
                    @if($client->photo && file_exists(public_path($client->photo)))
                    <img src="{{ asset($client->photo) }}" alt="{{ $client->prenom }}" class="w-9 h-9 rounded-full object-cover shadow-sm ring-2 ring-secondary group-hover:ring-secondary/70 transition-all">
                    @else
                    <div class="w-9 h-9 rounded-full bg-secondary flex items-center justify-center text-white font-bold text-sm shadow-sm ring-2 ring-slate-100 group-hover:ring-secondary/40 transition-all">
                        {{ strtoupper(substr($client->prenom ?? 'U', 0, 1)) }}
                    </div>
                    @endif
                    <span class="hidden lg:inline text-xs font-semibold text-slate-700 max-w-[100px] truncate">{{ $client->prenom }}</span>
                    <span class="material-symbols-outlined text-[16px] text-slate-400 group-hover:text-slate-600 transition-transform">expand_more</span>
                </button>

                <!-- Dropdown Profil -->
                <div id="user-dropdown-menu" class="hidden absolute right-0 mt-2 w-56 bg-white rounded-2xl shadow-xl border border-slate-100 py-2 z-50 transition-all">
                    <div class="px-4 py-3 border-b border-slate-100 flex items-center gap-3">
                        @if($client->photo && file_exists(public_path($client->photo)))
                        <img src="{{ asset($client->photo) }}" alt="{{ $client->prenom }}" class="w-10 h-10 rounded-full object-cover ring-2 ring-secondary/30">
                        @else
                        <div class="w-10 h-10 rounded-full bg-secondary flex items-center justify-center text-white font-bold text-base">
                            {{ strtoupper(substr($client->prenom ?? 'U', 0, 1)) }}
                        </div>
                        @endif
                        <div class="flex-1 overflow-hidden">
                            <p class="text-xs font-bold text-slate-800 truncate">{{ $client->prenom }} {{ $client->nom }}</p>
                            <p class="text-[11px] text-slate-500 truncate">{{ $client->email }}</p>
                        </div>
                    </div>
                    <a href="{{ route('dashboard') }}" class="flex items-center gap-2.5 px-4 py-2.5 text-xs font-semibold text-slate-700 hover:bg-slate-50 hover:text-secondary transition-colors">
                        <span class="material-symbols-outlined text-[18px]">dashboard</span>
                        <span>Mon Espace Membre</span>
                    </a>
                    <a href="{{ route('dashboard', ['tab' => 'mes-annonces']) }}" class="flex items-center gap-2.5 px-4 py-2.5 text-xs font-semibold text-slate-700 hover:bg-slate-50 hover:text-secondary transition-colors">
                        <span class="material-symbols-outlined text-[18px]">inventory_2</span>
                        <span>Mes Annonces</span>
                    </a>
                    <a href="{{ route('page_client') }}" class="flex items-center gap-2.5 px-4 py-2.5 text-xs font-semibold text-slate-700 hover:bg-slate-50 hover:text-secondary transition-colors">
                        <span class="material-symbols-outlined text-[18px]">account_circle</span>
                        <span>Profil Public Vendeur</span>
                    </a>
                    <form action="{{ route('logout') }}" method="POST" class="border-t border-slate-100 mt-1 pt-1">
                        @csrf
                        <button type="submit" class="w-full flex items-center gap-2.5 px-4 py-2 text-xs font-semibold text-red-600 hover:bg-red-50 transition-colors text-left cursor-pointer">
                            <span class="material-symbols-outlined text-[18px]">logout</span>
                            <span>Déconnexion</span>
                        </button>
                    </form>
                </div>
            </div>
            @else
            <a class="inline-flex items-center gap-2 bg-secondary hover:bg-on-secondary-container text-white font-bold text-sm px-4 py-2.5 rounded-xl shadow-md hover:shadow-lg transition-all" href="{{ route('login') }}" title="Se connecter">
                <span class="material-symbols-outlined text-[20px]">person</span>
                <span>Se connecter</span>
            </a>
            @endif
        </div>
    </div>

    <!-- Tiroir de recherche pour mobile (< 768px) -->
    <div id="mobile-search-bar" class="hidden md:hidden px-4 py-3 bg-slate-50 border-t border-slate-200">
        <form action="{{ route('home') }}" method="GET" class="flex items-center bg-white rounded-xl p-2 shadow-sm border border-slate-200">
            <span class="material-symbols-outlined text-slate-400 text-[20px] mr-2">search</span>
            <input name="q" value="{{ request('q') }}" class="w-full bg-transparent border-none outline-none text-sm text-slate-900 placeholder:text-slate-400" placeholder="Rechercher sur Epsilon..." type="text" />
            <button type="submit" class="bg-secondary text-white p-2 rounded-lg flex-shrink-0 ml-1.5" aria-label="Valider">
                <span class="material-symbols-outlined text-[18px]">arrow_forward</span>
            </button>
        </form>
    </div>
</header>

<script>
    document.addEventListener('click', function(event) {
        const wrapper = document.getElementById('user-menu-wrapper');
        const menu = document.getElementById('user-dropdown-menu');
        if (menu && wrapper && !wrapper.contains(event.target)) {
            menu.classList.add('hidden');
        }
    });
</script>