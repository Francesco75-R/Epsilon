<!-- ================================================================= -->
<!-- HEADER PRINCIPAL (Réorganisé, Moderne & Harmonieux)               -->
<!-- ================================================================= -->
<header class="fixed top-0 left-0 right-0 z-50 bg-white/95 backdrop-blur-xl border-b border-slate-200/80 shadow-[0_1px_12px_rgba(15,23,42,0.04)]">
    <div class="h-20 max-w-[1360px] mx-auto px-4 sm:px-6 lg:px-8 flex items-center justify-between gap-4 lg:gap-6">
        
        <!-- 1. GAUCHE: Logo officiel Epsilon & Navigation desktop -->
        <div class="flex items-center gap-6 lg:gap-8 flex-shrink-0">
            <!-- Logo & Marque -->
            <a class="flex items-center gap-3 group" href="{{ url('/') }}" aria-label="Epsilon Accueil">
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

        <!-- 2. CENTRE: Barre de recherche intégrée (Desktop & Tablette) -->
        <div class="hidden md:flex flex-1 max-w-2xl items-center bg-slate-100/90 hover:bg-slate-100/100 rounded-2xl p-1.5 shadow-[0_1px_3px_rgba(15,23,42,0.04)] border border-slate-200/80 transition-all focus-within:border-secondary focus-within:bg-white focus-within:ring-2 focus-within:ring-secondary/20">
            <!-- Champ recherche textuelle -->
            <div class="flex items-center flex-1 px-3">
                <span class="material-symbols-outlined text-slate-400 text-[20px] mr-2">search</span>
                <input id="header-search-input" class="w-full bg-transparent border-none outline-none text-sm text-slate-900 placeholder:text-slate-400" placeholder="Que recherchez-vous ?" type="text" onkeyup="if(event.key === 'Enter') { document.getElementById('listing-feed')?.scrollIntoView({behavior: 'smooth'}); }" />
            </div>

            <!-- Séparateur vertical -->
            <div class="h-6 w-px bg-slate-200"></div>

            <!-- Sélecteur de catégorie -->
            <div class="flex items-center px-2">
                <select class="bg-transparent border-none outline-none text-xs font-medium text-slate-600 cursor-pointer pr-2 hover:text-primary transition-colors" aria-label="Catégories">
                    <option value="">Toutes catégories</option>
                    <option value="vehicules">Véhicules</option>
                    <option value="immo">Immobilier</option>
                    <option value="tech">Smartphones & Tech</option>
                    <option value="maison">Mode & Maison</option>
                    <option value="services">Emploi & Services</option>
                </select>
            </div>

            <!-- Séparateur vertical -->
            <div class="h-6 w-px bg-slate-200"></div>

            <!-- Sélecteur de localisation -->
            <div class="flex items-center px-2">
                <span class="material-symbols-outlined text-slate-400 text-[18px] mr-1">location_on</span>
                <select class="bg-transparent border-none outline-none text-xs font-medium text-slate-600 cursor-pointer hover:text-primary transition-colors" aria-label="Localisation">
                    <option value="">Tout le Togo</option>
                    <option value="lome">Lomé</option>
                    <option value="kara">Kara</option>
                    <option value="sokode">Sokodé</option>
                    <option value="kpalime">Kpalimé</option>
                    <option value="atakpame">Atakpamé</option>
                </select>
            </div>

            <!-- Bouton de validation de recherche -->
            <button class="flex items-center justify-center bg-secondary hover:bg-on-secondary-container text-white p-2.5 rounded-xl shadow-sm hover:scale-105 transition-all ml-1 flex-shrink-0 cursor-pointer" type="button" onclick="document.getElementById('listing-feed')?.scrollIntoView({behavior: 'smooth'})" aria-label="Lancer la recherche">
                <span class="material-symbols-outlined text-[19px]">search</span>
            </button>
        </div>

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
            <a class="hidden sm:inline-flex items-center gap-2 bg-secondary hover:bg-on-secondary-container text-white font-bold text-sm px-4 py-2.5 rounded-xl shadow-md hover:shadow-lg transition-all" href="#" title="Déposer une annonce">
                <span class="material-symbols-outlined text-[20px]">add_circle</span>
                <span>Déposer une annonce</span>
            </a>

            <!-- Avatar profil utilisateur -->
            <a class="flex items-center pl-1 group" href="#" title="Mon Compte" aria-label="Mon Compte">
                <div class="w-9 h-9 rounded-full bg-primary flex items-center justify-center text-white shadow-sm ring-2 ring-slate-100 group-hover:ring-secondary/40 transition-all">
                    <span class="material-symbols-outlined text-[20px]">person</span>
                </div>
            </a>
        </div>
    </div>

    <!-- Tiroir de recherche pour mobile (< 768px) -->
    <div id="mobile-search-bar" class="hidden md:hidden px-4 py-3 bg-slate-50 border-t border-slate-200">
        <div class="flex items-center bg-white rounded-xl p-2 shadow-sm border border-slate-200">
            <span class="material-symbols-outlined text-slate-400 text-[20px] mr-2">search</span>
            <input class="w-full bg-transparent border-none outline-none text-sm text-slate-900 placeholder:text-slate-400" placeholder="Rechercher sur Epsilon..." type="text" onkeyup="if(event.key === 'Enter') { setSearchTerm(this.value); document.getElementById('listing-feed')?.scrollIntoView({behavior: 'smooth'}); }" />
            <button class="bg-secondary text-white p-2 rounded-lg flex-shrink-0 ml-1.5" type="button" onclick="document.getElementById('listing-feed')?.scrollIntoView({behavior: 'smooth'})">
                <span class="material-symbols-outlined text-[18px]">arrow_forward</span>
            </button>
        </div>
    </div>
</header>
