@extends('layouts.app')

@php 
    $annonces = $annonces ?? collect(); 
    $categoryCounts = $categoryCounts ?? []; 
    $totalCount = $totalCount ?? $annonces->count(); 
    $showAll = $showAll ?? false; 
@endphp

@section('title', 'Epsilon Marketplace | Place de marché nationale n°1 au Togo')

@section('content')
<div class="flex flex-col w-full">

    <!-- ================================================================= -->
    <!-- 1. HERO SECTION (Moderne, Aéré & Épuré)                           -->
    <!-- ================================================================= -->
    <section class="hero-main-section w-full pt-10 pb-16 md:pt-16 md:pb-24 border-b border-outline-variant/20">
        <!-- Arrière-plan de 5 images collées + fondu de lisibilité -->
        @include('layouts.hero_images')

        <div class="hero-section-container">
            <!-- Contenu au premier plan (z-index: 3, max-width: 650px) -->
            <div class="hero-foreground-content">
                <!-- Badge statut national avec point animé -->
                <div class="flex items-center mb-5">
                    <span class="inline-flex items-center gap-2 px-3.5 py-1.5 rounded-full bg-white/95 backdrop-blur-md text-secondary font-semibold text-xs sm:text-sm shadow-sm border border-secondary/20">
                        <span class="w-2 h-2 rounded-full bg-secondary animate-pulse"></span>
                        Place de marché nationale n°1 au Togo
                    </span>
                </div>

                <!-- Titre et sous-titre agrandis & aérés -->
                <div class="mb-8">
                    <h1 class="hero-title text-3xl sm:text-4xl xl:text-5xl font-extrabold text-white tracking-tight leading-[1.15] mb-4">
                        Achetez et vendez près de chez vous <span class="hero-title-highlight text-emerald-400">en toute confiance.</span>
                    </h1>
                    <p class="hero-subtitle text-base sm:text-lg text-slate-100 font-medium leading-relaxed">
                        Des milliers de bonnes affaires vérifiées chaque jour. Transactions directes, locales et sécurisées entre particuliers et commerçants certifiés.
                    </p>
                </div>

                <!-- Barre de recherche flottante premium (100% Opérationnelle) -->
                <form action="{{ route('home') }}" method="GET" class="hero-search-form bg-white p-2 rounded-2xl shadow-[0_8px_30px_rgb(0,0,0,0.06)] mb-6 border border-slate-200/80">
                    <div class="flex flex-col md:flex-row items-center gap-1">
                        <!-- Recherche textuelle -->
                        <div class="hero-search-input-box flex items-center flex-1 w-full px-2 py-2">
                            <span class="material-symbols-outlined text-outline text-[20px] mr-1.5">search</span>
                            <input class="w-full bg-transparent outline-none font-body-md text-xs sm:text-sm text-on-surface placeholder:text-outline" id="hero-input" name="q" value="{{ request('q') }}" placeholder="Que recherchez-vous ?" type="text" />
                        </div>

                        <!-- Séparateur vertical (desktop) -->
                        <div class="hidden md:block w-px h-7 bg-slate-200"></div>

                        <!-- Filtre catégorie -->
                        <div class="flex items-center w-full md:w-auto px-1.5 py-2 flex-shrink-0">
                            <span class="material-symbols-outlined text-outline text-[18px] mr-1">category</span>
                            <select name="categorie" class="bg-transparent outline-none font-medium text-xs text-on-surface cursor-pointer pr-1" aria-label="Toutes catégories">
                                <option value="">Toutes catégories</option>
                                <option value="Véhicules" {{ request('categorie') == 'Véhicules' ? 'selected' : '' }}>Véhicules</option>
                                <option value="Immobilier" {{ request('categorie') == 'Immobilier' ? 'selected' : '' }}>Immobilier</option>
                                <option value="Smartphones & Tech" {{ request('categorie') == 'Smartphones & Tech' ? 'selected' : '' }}>Smartphones & Tech</option>
                                <option value="Mode & Maison" {{ request('categorie') == 'Mode & Maison' ? 'selected' : '' }}>Mode & Maison</option>
                                <option value="Emploi & Services" {{ request('categorie') == 'Emploi & Services' ? 'selected' : '' }}>Emploi & Services</option>
                            </select>
                        </div>

                        <!-- Séparateur vertical (desktop) -->
                        <div class="hidden md:block w-px h-7 bg-slate-200"></div>

                        <!-- Sélecteur de ville -->
                        <div class="flex items-center w-full md:w-auto px-1.5 py-2 flex-shrink-0">
                            <span class="material-symbols-outlined text-outline text-[18px] mr-1">location_on</span>
                            <select name="lieu" class="bg-transparent outline-none font-medium text-xs text-on-surface cursor-pointer pr-1" aria-label="Choisir la ville">
                                <option value="">Tout le Togo</option>
                                <option value="Lomé" {{ request('lieu') == 'Lomé' ? 'selected' : '' }}>Lomé</option>
                                <option value="Kara" {{ request('lieu') == 'Kara' ? 'selected' : '' }}>Kara</option>
                                <option value="Sokodé" {{ request('lieu') == 'Sokodé' ? 'selected' : '' }}>Sokodé</option>
                                <option value="Kpalimé" {{ request('lieu') == 'Kpalimé' ? 'selected' : '' }}>Kpalimé</option>
                                <option value="Atakpamé" {{ request('lieu') == 'Atakpamé' ? 'selected' : '' }}>Atakpamé</option>
                            </select>
                        </div>

                        <!-- Bouton d'action CTA vert émeraude -->
                        <button class="w-full md:w-auto flex items-center justify-center gap-1.5 bg-secondary hover:bg-on-secondary-container text-on-secondary font-semibold text-xs sm:text-sm px-4 py-2.5 rounded-xl shadow-md hover:shadow-lg transition-all cursor-pointer flex-shrink-0" type="submit">
                            <span>Rechercher</span>
                            <span class="material-symbols-outlined text-[17px]">arrow_forward</span>
                        </button>
                    </div>
                </form>

                <!-- Mots-clés tendances (Pills cliquables sur une seule ligne) -->
                <div class="hero-trends-row mb-10">
                    <span class="hero-trends-label text-xs font-semibold text-white flex items-center gap-1 mr-1">
                        <span class="material-symbols-outlined text-[15px] text-emerald-400">trending_up</span> Tendances :
                    </span>
                    <button class="hero-trend-pill bg-white/95 hover:bg-slate-100 rounded-full text-xs font-medium text-primary transition-all border border-slate-200/80 shadow-2xs cursor-pointer" onclick="setSearchTerm('Toyota Corolla')">Toyota Corolla</button>
                    <button class="hero-trend-pill bg-white/95 hover:bg-slate-100 rounded-full text-xs font-medium text-primary transition-all border border-slate-200/80 shadow-2xs cursor-pointer" onclick="setSearchTerm('iPhone 15 Pro')">iPhone 15 Pro</button>
                    <button class="hero-trend-pill bg-white/95 hover:bg-slate-100 rounded-full text-xs font-medium text-primary transition-all border border-slate-200/80 shadow-2xs cursor-pointer" onclick="setSearchTerm('Villa avec piscine')">Villa avec piscine</button>
                    <button class="hero-trend-pill bg-white/95 hover:bg-slate-100 rounded-full text-xs font-medium text-primary transition-all border border-slate-200/80 shadow-2xs cursor-pointer" onclick="setSearchTerm('MacBook Air M2')">MacBook Air M2</button>
                    <button class="hero-trend-pill bg-white/95 hover:bg-slate-100 rounded-full text-xs font-medium text-primary transition-all border border-slate-200/80 shadow-2xs cursor-pointer" onclick="setSearchTerm('Appartement Lomé 2')">Appartement Lomé 2</button>
                </div>
            </div>

            <!-- Métriques de réassurance claires & aérées -->
            <div class="hero-metrics-grid grid grid-cols-1 sm:grid-cols-3 gap-4 md:gap-6 pt-4">
                <div class="flex items-center gap-4 p-4 md:p-5 rounded-2xl bg-white/95 backdrop-blur-sm shadow-sm border border-slate-200/70 hover:shadow-md transition-shadow">
                    <div class="w-12 h-12 rounded-xl bg-secondary-container/40 flex items-center justify-center text-secondary flex-shrink-0">
                        <span class="material-symbols-outlined text-[28px]">inventory_2</span>
                    </div>
                    <div>
                        <p class="font-extrabold text-xl text-primary leading-none">+120 000</p>
                        <p class="text-xs sm:text-sm text-on-surface-variant mt-1">Annonces actives et modérées</p>
                    </div>
                </div>
                <div class="flex items-center gap-4 p-4 md:p-5 rounded-2xl bg-white/95 backdrop-blur-sm shadow-sm border border-slate-200/70 hover:shadow-md transition-shadow">
                    <div class="w-12 h-12 rounded-xl bg-primary-fixed/50 flex items-center justify-center text-primary flex-shrink-0">
                        <span class="material-symbols-outlined text-[28px]">verified_user</span>
                    </div>
                    <div>
                        <p class="font-extrabold text-xl text-primary leading-none">Vendeurs certifiés</p>
                        <p class="text-xs sm:text-sm text-on-surface-variant mt-1">Identité vérifiée à 100%</p>
                    </div>
                </div>
                <div class="flex items-center gap-4 p-4 md:p-5 rounded-2xl bg-white/95 backdrop-blur-sm shadow-sm border border-slate-200/70 hover:shadow-md transition-shadow">
                    <div class="w-12 h-12 rounded-xl bg-secondary-fixed/40 flex items-center justify-center text-secondary flex-shrink-0">
                        <span class="material-symbols-outlined text-[28px]">toll</span>
                    </div>
                    <div>
                        <p class="font-extrabold text-xl text-primary leading-none">100% Gratuit</p>
                        <p class="text-xs sm:text-sm text-on-surface-variant mt-1">Pour déposer et chatter</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- ================================================================= -->
    <!-- 2. CATÉGORIES (Grille moderne & aérée)                            -->
    <!-- ================================================================= -->
    <section class="w-full py-14 md:py-20 bg-surface">
        <div class="max-w-[1360px] mx-auto px-4 sm:px-6 lg:px-10">
            <!-- En-tête de section -->
            <!-- En-tête de section -->
            <div class="flex flex-col sm:flex-row sm:items-end justify-between gap-4 mb-8">
                <div>
                    <span class="text-xs font-bold text-secondary uppercase tracking-widest block mb-1">Navigation directe</span>
                    <h2 class="text-2xl sm:text-3xl font-extrabold text-primary">Explorer par catégorie</h2>
                </div>
                <a class="inline-flex items-center gap-1.5 text-sm font-semibold text-secondary hover:text-on-secondary-container transition-colors group" href="{{ route('home') }}#listing-feed">
                    <span>Voir toutes les annonces ({{ number_format($categoryCounts['total'] ?? 0, 0, ',', ' ') }})</span>
                    <span class="material-symbols-outlined text-[18px] group-hover:translate-x-1 transition-transform">chevron_right</span>
                </a>
            </div>

            <!-- Grille des catégories avec comptages réels BDD -->
            <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-6 gap-4 sm:gap-5">
                <!-- Catégorie 1: Véhicules -->
                <a class="group flex flex-col p-5 bg-white rounded-2xl shadow-sm hover:shadow-lg transition-all duration-200 ease-out hover:scale-105 active:scale-95 border border-slate-200/70" href="{{ route('home', ['categorie' => 'Véhicules']) }}#listing-feed">
                    <div class="w-13 h-13 rounded-xl bg-primary-fixed flex items-center justify-center text-primary mb-4 group-hover:scale-110 transition-transform">
                        <span class="material-symbols-outlined text-[28px]">directions_car</span>
                    </div>
                    <h3 class="font-bold text-base text-primary mb-1">Véhicules</h3>
                    <p class="text-xs text-on-surface-variant line-clamp-1 mb-3">Voitures, motos, pièces</p>
                    <span class="mt-auto text-xs font-semibold text-secondary bg-secondary-container/30 px-2.5 py-1 rounded-full w-max">
                        {{ number_format($categoryCounts['vehicules'] ?? 0, 0, ',', ' ') }} annonces
                    </span>
                </a>

                <!-- Catégorie 2: Immobilier -->
                <a class="group flex flex-col p-5 bg-white rounded-2xl shadow-sm hover:shadow-lg transition-all duration-200 ease-out hover:scale-105 active:scale-95 border border-slate-200/70" href="{{ route('home', ['categorie' => 'Immobilier']) }}#listing-feed">
                    <div class="w-13 h-13 rounded-xl bg-secondary-fixed flex items-center justify-center text-on-secondary-fixed mb-4 group-hover:scale-110 transition-transform">
                        <span class="material-symbols-outlined text-[28px]">apartment</span>
                    </div>
                    <h3 class="font-bold text-base text-primary mb-1">Immobilier</h3>
                    <p class="text-xs text-on-surface-variant line-clamp-1 mb-3">Vente, location, terrains</p>
                    <span class="mt-auto text-xs font-semibold text-secondary bg-secondary-container/30 px-2.5 py-1 rounded-full w-max">
                        {{ number_format($categoryCounts['immo'] ?? 0, 0, ',', ' ') }} annonces
                    </span>
                </a>

                <!-- Catégorie 3: Smartphones & Tech -->
                <a class="group flex flex-col p-5 bg-white rounded-2xl shadow-sm hover:shadow-lg transition-all duration-200 ease-out hover:scale-105 active:scale-95 border border-slate-200/70" href="{{ route('home', ['categorie' => 'Smartphones & Tech']) }}#listing-feed">
                    <div class="w-13 h-13 rounded-xl bg-primary-fixed-dim flex items-center justify-center text-primary mb-4 group-hover:scale-110 transition-transform">
                        <span class="material-symbols-outlined text-[28px]">devices</span>
                    </div>
                    <h3 class="font-bold text-base text-primary mb-1">High-Tech</h3>
                    <p class="text-xs text-on-surface-variant line-clamp-1 mb-3">Smartphones, PC, TV</p>
                    <span class="mt-auto text-xs font-semibold text-secondary bg-secondary-container/30 px-2.5 py-1 rounded-full w-max">
                        {{ number_format($categoryCounts['tech'] ?? 0, 0, ',', ' ') }} annonces
                    </span>
                </a>

                <!-- Catégorie 4: Mode & Beauté -->
                <a class="group flex flex-col p-5 bg-white rounded-2xl shadow-sm hover:shadow-lg transition-all duration-200 ease-out hover:scale-105 active:scale-95 border border-slate-200/70" href="{{ route('home', ['categorie' => 'Mode & Maison']) }}#listing-feed">
                    <div class="w-13 h-13 rounded-xl bg-tertiary-fixed flex items-center justify-center text-tertiary mb-4 group-hover:scale-110 transition-transform">
                        <span class="material-symbols-outlined text-[28px]">apparel</span>
                    </div>
                    <h3 class="font-bold text-base text-primary mb-1">Mode &amp; Beauté</h3>
                    <p class="text-xs text-on-surface-variant line-clamp-1 mb-3">Vêtements, montres</p>
                    <span class="mt-auto text-xs font-semibold text-secondary bg-secondary-container/30 px-2.5 py-1 rounded-full w-max">
                        {{ number_format($categoryCounts['mode_maison'] ?? 0, 0, ',', ' ') }} annonces
                    </span>
                </a>

                <!-- Catégorie 5: Maison & Mobilier -->
                <a class="group flex flex-col p-5 bg-white rounded-2xl shadow-sm hover:shadow-lg transition-all duration-200 ease-out hover:scale-105 active:scale-95 border border-slate-200/70" href="{{ route('home', ['categorie' => 'Mode & Maison']) }}#listing-feed">
                    <div class="w-13 h-13 rounded-xl bg-surface-container-high flex items-center justify-center text-primary mb-4 group-hover:scale-110 transition-transform">
                        <span class="material-symbols-outlined text-[28px]">chair</span>
                    </div>
                    <h3 class="font-bold text-base text-primary mb-1">Maison</h3>
                    <p class="text-xs text-on-surface-variant line-clamp-1 mb-3">Meubles, déco, cuisine</p>
                    <span class="mt-auto text-xs font-semibold text-secondary bg-secondary-container/30 px-2.5 py-1 rounded-full w-max">
                        {{ number_format($categoryCounts['mode_maison'] ?? 0, 0, ',', ' ') }} annonces
                    </span>
                </a>

                <!-- Catégorie 6: Emploi & Services -->
                <a class="group flex flex-col p-5 bg-white rounded-2xl shadow-sm hover:shadow-lg transition-all duration-200 ease-out hover:scale-105 active:scale-95 border border-slate-200/70" href="{{ route('home', ['categorie' => 'Emploi & Services']) }}#listing-feed">
                    <div class="w-13 h-13 rounded-xl bg-secondary-container flex items-center justify-center text-on-secondary-container mb-4 group-hover:scale-110 transition-transform">
                        <span class="material-symbols-outlined text-[28px]">work</span>
                    </div>
                    <h3 class="font-bold text-base text-primary mb-1">Services</h3>
                    <p class="text-xs text-on-surface-variant line-clamp-1 mb-3">Emploi, artisanat, cours</p>
                    <span class="mt-auto text-xs font-semibold text-secondary bg-secondary-container/30 px-2.5 py-1 rounded-full w-max">
                        {{ number_format($categoryCounts['services'] ?? 0, 0, ',', ' ') }} annonces
                    </span>
                </a>
            </div>
        </div>
    </section>

    <!-- ================================================================= -->
    <!-- 3. SECTION PRODUITS (Marge 1cm G/D, Cartes Agrandies, Grille Aérée)-->
    <!-- ================================================================= -->
    <section class="w-full py-14 md:py-20 bg-surface-container-low/70 border-y border-outline-variant/20" id="listing-feed">
        <!-- Conteneur avec marge de 1 cm à gauche et 1 cm à droite (sans modifier haut/bas) -->
        <div class="product-section-wrapper">
            <div class="max-w-[1400px] mx-auto">
                <!-- En-tête des annonces & Onglets de filtrage -->
                <div class="flex flex-col md:flex-row md:items-end justify-between gap-4 mb-10">
                    <div>
                        <div class="flex items-center gap-2 mb-2">
                            <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full bg-secondary text-on-secondary font-semibold text-xs shadow-sm">
                                <span class="material-symbols-outlined text-[14px]">star</span> Sélection du jour
                            </span>
                            <span class="text-xs sm:text-sm text-on-surface-variant font-medium">• Actualisé en temps réel</span>
                        </div>
                        <h2 class="text-2xl sm:text-3xl lg:text-4xl font-extrabold text-primary">Annonces à la une</h2>
                    </div>

                    <!-- Boutons d'onglets catégories (défilement doux sur mobile) -->
                    <div class="flex items-center gap-2 overflow-x-auto pb-1 max-w-full">
                        <button class="tab-btn px-4 py-2.5 rounded-xl font-semibold text-xs sm:text-sm bg-primary text-on-primary transition-all shadow-sm cursor-pointer whitespace-nowrap" onclick="filterCategory('all', this)">Tout</button>
                        <button class="tab-btn px-4 py-2.5 rounded-xl font-semibold text-xs sm:text-sm bg-white text-on-surface hover:bg-slate-100 transition-all border border-slate-200/80 cursor-pointer whitespace-nowrap" onclick="filterCategory('vehicules', this)">Véhicules</button>
                        <button class="tab-btn px-4 py-2.5 rounded-xl font-semibold text-xs sm:text-sm bg-white text-on-surface hover:bg-slate-100 transition-all border border-slate-200/80 cursor-pointer whitespace-nowrap" onclick="filterCategory('immo', this)">Immobilier</button>
                        <button class="tab-btn px-4 py-2.5 rounded-xl font-semibold text-xs sm:text-sm bg-white text-on-surface hover:bg-slate-100 transition-all border border-slate-200/80 cursor-pointer whitespace-nowrap" onclick="filterCategory('tech', this)">High-Tech</button>
                        <button class="tab-btn px-4 py-2.5 rounded-xl font-semibold text-xs sm:text-sm bg-white text-on-surface hover:bg-slate-100 transition-all border border-slate-200/80 cursor-pointer whitespace-nowrap" onclick="filterCategory('maison', this)">Maison</button>
                    </div>
                </div>

                <!-- Grille des produits optimisée : Cartes agrandies, espacement aéré (gap-6 à gap-8) -->
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 lg:gap-8">

                    @forelse($annonces as $ad)
                        @php
                            $catLower = strtolower(trim($ad->categorie ?? ''));
                            $catSlug = match(true) {
                                str_contains($catLower, 'véhicule') || str_contains($catLower, 'vehicule') || str_contains($catLower, 'auto') || str_contains($catLower, 'moto') => 'vehicules',
                                str_contains($catLower, 'immo') => 'immo',
                                str_contains($catLower, 'tech') || str_contains($catLower, 'infor') || str_contains($catLower, 'téléphon') || str_contains($catLower, 'électro') => 'tech',
                                str_contains($catLower, 'maison') || str_contains($catLower, 'mode') || str_contains($catLower, 'meuble') => 'maison',
                                default => 'services'
                            };

                            $photos = is_array($ad->photos) ? $ad->photos : (is_string($ad->photos) ? json_decode($ad->photos, true) ?? [] : []);
                            $photoUrls = array_values(array_map(fn($p) => str_starts_with($p, 'http') ? $p : asset(ltrim($p, '/')), $photos));
                            $coverUrl = !empty($photoUrls) ? $photoUrls[0] : asset('photo/default.png');
                            $photoCount = count($photoUrls);
                        @endphp

                        <div class="listing-item product-card group bg-white rounded-2xl border border-slate-200/80 hover:border-secondary/40 shadow-[0_2px_12px_rgba(15,23,42,0.04)] hover:shadow-[0_16px_32px_rgba(15,23,42,0.09)] transition-all duration-300 hover:-translate-y-1.5 flex flex-col overflow-hidden cursor-pointer" 
                             data-cat="{{ $catSlug }}"
                             data-ad-id="{{ $ad->id }}"
                             data-ad-titre="{{ $ad->titre }}"
                             data-ad-prix="{{ $ad->prix }}"
                             data-ad-photo="{{ $coverUrl }}"
                             data-ad-lieu="{{ $ad->lieu }}"
                             data-ad-categorie="{{ $ad->categorie }}"
                             onclick="handleAdCardClick(this)">
                            <!-- Image / Vignette (Uniquement photos[0]) -->
                            <div class="relative w-full h-56 sm:h-52 md:h-60 overflow-hidden bg-slate-100">
                                <img class="product-card-img w-full h-full object-cover group-hover:scale-105 transition-transform duration-500 ease-out" 
                                     alt="{{ $ad->titre }}" 
                                     src="{{ $coverUrl }}" 
                                     loading="lazy" />
                                
                                <div class="absolute top-3 left-3 flex flex-wrap gap-1.5 pointer-events-none">
                                    <span class="bg-secondary text-white px-2.5 py-1 rounded-lg text-xs font-bold shadow-sm flex items-center gap-1">
                                        {{ $ad->categorie }}
                                    </span>
                                    <span class="bg-white/95 backdrop-blur-md text-primary px-2.5 py-1 rounded-lg text-xs font-semibold shadow-sm">
                                        {{ $ad->etat }}
                                    </span>
                                </div>

                                <!-- Bouton Favoris (Redirige vers login_client si deconnecte) -->
                                <button type="button" class="fav-btn absolute top-3 right-3 w-9 h-9 rounded-full bg-white/90 backdrop-blur-md hover:bg-white flex items-center justify-center text-slate-500 hover:text-error transition-all shadow-sm hover:scale-110 cursor-pointer z-10" onclick="event.stopPropagation(); toggleFav(this);" title="Ajouter aux favoris">
                                    <span class="material-symbols-outlined text-[20px]">favorite</span>
                                </button>

                                <!-- Bouton Photos (Affiche toutes les photos pour tous, connecte ou non) -->
                                <button type="button" 
                                        data-photos="{{ json_encode($photoUrls) }}"
                                        data-titre="{{ $ad->titre }}"
                                        onclick="event.stopPropagation(); openGalleryFromElement(this);"
                                        class="absolute bottom-3 right-3 bg-slate-900/85 hover:bg-secondary text-white text-xs font-bold px-3 py-1.5 rounded-xl backdrop-blur-md shadow-md inline-flex items-center gap-1.5 transition-all cursor-pointer hover:scale-105 z-10">
                                    <span class="material-symbols-outlined text-[16px] text-secondary-fixed">photo_library</span>
                                    <span>Photos ({{ $photoCount }})</span>
                                </button>
                            </div>

                            <!-- Contenu interne avec espacement amélioré -->
                            <div class="p-5 md:p-6 flex flex-col flex-1 justify-between gap-3">
                                <div>
                                    <span class="text-xs font-semibold text-secondary uppercase tracking-wider block mb-1">
                                        {{ $ad->categorie }}
                                    </span>
                                    <h3 class="text-base sm:text-lg font-bold text-primary line-clamp-1 group-hover:text-secondary transition-colors" title="{{ $ad->titre }}">
                                        {{ $ad->titre }}
                                    </h3>
                                    <div class="flex items-baseline gap-1 mt-2">
                                        <span class="text-xl sm:text-2xl font-extrabold text-secondary tracking-tight">
                                            {{ number_format($ad->prix, 0, ',', ' ') }}
                                        </span>
                                        <span class="text-xs font-bold text-slate-500">FCFA</span>
                                    </div>
                                    <p class="text-xs text-on-surface-variant line-clamp-2 mt-2 leading-relaxed">
                                        {{ $ad->description }}
                                    </p>
                                </div>

                                <div class="pt-3 border-t border-slate-100 flex justify-between items-center w-full text-xs text-slate-500">
                                    <div class="flex items-center gap-1.5 truncate">
                                        <span class="flex items-center gap-1 truncate text-slate-600 font-medium" title="{{ $ad->lieu }}">
                                            <span class="material-symbols-outlined text-[15px] text-slate-400">location_on</span>
                                            <span class="truncate">{{ $ad->lieu }}</span>
                                        </span>
                                        @if($ad->user)
                                            <span class="text-slate-300">•</span>
                                            <a href="{{ route('page_client', ['id' => $ad->user_id]) }}" onclick="event.stopPropagation();" class="inline-flex items-center gap-1 font-semibold text-secondary hover:text-primary transition-colors text-xs truncate max-w-[100px]" title="Voir la boutique / profil de {{ $ad->user->prenom }}">
                                                <span class="w-1.5 h-1.5 rounded-full bg-secondary"></span>
                                                <span>{{ $ad->user->prenom }}</span>
                                            </a>
                                        @else
                                            <span class="inline-flex items-center gap-1 font-semibold text-secondary bg-secondary-container/30 px-2 py-0.5 rounded text-xs">
                                                <span class="w-1.5 h-1.5 rounded-full bg-secondary"></span> Particulier
                                            </span>
                                        @endif
                                    </div>
                                    <div class="flex items-center gap-1 text-[11px] font-medium text-slate-400 whitespace-nowrap ml-2 flex-shrink-0" title="{{ $ad->created_at }}">
                                        <span class="material-symbols-outlined text-[13px]">schedule</span>
                                        <span>{{ $ad->formatted_date }}</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="col-span-full py-16 px-6 text-center bg-white rounded-3xl border border-slate-200/80 shadow-sm max-w-xl mx-auto my-6">
                            <div class="w-20 h-20 rounded-2xl bg-secondary-container/30 text-secondary flex items-center justify-center mx-auto mb-5">
                                <span class="material-symbols-outlined text-[40px]">inventory_2</span>
                            </div>
                            <h3 class="text-xl font-extrabold text-primary mb-2">Aucune annonce publiée pour le moment</h3>
                            <p class="text-sm text-on-surface-variant mb-6 leading-relaxed">
                                Soyez le premier à profiter de la marketplace Epsilon pour mettre en vente vos biens et services auprès de milliers d'acheteurs.
                            </p>
                            <a href="{{ route('dashboard', ['tab' => 'publier']) }}" class="inline-flex items-center gap-2 bg-secondary hover:bg-on-secondary-container text-white font-bold text-sm px-6 py-3 rounded-xl shadow-md hover:shadow-lg transition-all">
                                <span class="material-symbols-outlined text-[20px]">add_circle</span>
                                <span>Déposer la première annonce</span>
                            </a>
                        </div>
                    @endforelse
                </div>

                <!-- Message si aucun produit ne correspond au filtre -->
                <div id="no-listings-notice" class="hidden text-center py-16">
                    <span class="material-symbols-outlined text-5xl text-slate-400 mb-2">search_off</span>
                    <p class="text-primary font-bold text-lg">Aucune annonce trouvée dans cette catégorie</p>
                    <p class="text-on-surface-variant text-sm mt-1">Sélectionnez l'onglet "Tout" pour découvrir d'autres opportunités disponibles.</p>
                </div>

                <!-- Bloc Découvrir plus (Menu déroulant interactif & Extension) -->
                <div class="mt-14 flex flex-col items-center justify-center relative" id="discover-more-section">
                    <div class="relative inline-block text-left" id="discover-dropdown-wrapper">
                        <button type="button" 
                                id="discover-more-btn"
                                onclick="toggleDiscoverDropdown()" 
                                class="inline-flex items-center gap-2.5 px-8 py-3.5 bg-white hover:bg-slate-50 text-primary font-bold text-sm sm:text-base rounded-2xl shadow-sm hover:shadow-md transition-all border border-slate-200/80 cursor-pointer group">
                            <span class="material-symbols-outlined text-secondary text-[22px] group-hover:rotate-180 transition-transform duration-300">expand_circle_down</span>
                            <span>Découvrir plus</span>
                            <span class="text-xs font-semibold px-2.5 py-0.5 rounded-full bg-slate-100 text-slate-600 border border-slate-200/60 ml-1">
                                @if($showAll)
                                    Toutes affichées ({{ $totalCount }})
                                @else
                                    {{ min(10, $annonces->count()) }} / {{ $totalCount }}
                                @endif
                            </span>
                            <span class="material-symbols-outlined text-[20px] text-slate-400 group-hover:text-primary transition-transform">expand_more</span>
                        </button>

                        <!-- Menu Déroulant interactif -->
                        <div id="discover-dropdown-menu" class="hidden absolute left-1/2 -translate-x-1/2 mt-2 w-72 sm:w-80 bg-white rounded-2xl shadow-2xl border border-slate-200/80 py-2 z-40 transition-all">
                            <div class="px-4 py-2 border-b border-slate-100 text-[11px] font-bold text-slate-400 uppercase tracking-wider">
                                Options d'affichage ({{ $totalCount }} annonces)
                            </div>
                            
                            <!-- Option 1 : Voir toutes les annonces -->
                            <a href="{{ request()->fullUrlWithQuery(['all' => 1, 'limit' => null]) }}#listing-feed" 
                               class="flex items-center justify-between px-4 py-2.5 text-xs sm:text-sm font-semibold text-slate-800 hover:bg-secondary-container/20 hover:text-secondary transition-colors {{ $showAll ? 'bg-secondary-container/20 text-secondary' : '' }}">
                                <div class="flex items-center gap-2.5">
                                    <span class="material-symbols-outlined text-[18px] text-secondary">view_module</span>
                                    <span>Afficher tout le catalogue</span>
                                </div>
                                <span class="text-[11px] font-bold px-2 py-0.5 rounded bg-secondary-container/40 text-secondary">{{ $totalCount }}</span>
                            </a>

                            <!-- Option 2 : 10 plus récentes (Par défaut) -->
                            <a href="{{ request()->fullUrlWithQuery(['all' => null, 'limit' => null]) }}#listing-feed" 
                               class="flex items-center justify-between px-4 py-2.5 text-xs sm:text-sm font-semibold text-slate-800 hover:bg-slate-50 hover:text-primary transition-colors {{ !$showAll && (!request('limit') || request('limit') == 10) ? 'bg-slate-100 text-primary' : '' }}">
                                <div class="flex items-center gap-2.5">
                                    <span class="material-symbols-outlined text-[18px] text-slate-500">history</span>
                                    <span>10 plus récentes (Par défaut)</span>
                                </div>
                                @if(!$showAll && (!request('limit') || request('limit') == 10))
                                    <span class="material-symbols-outlined text-[18px] text-secondary">check</span>
                                @endif
                            </a>

                            @if($totalCount > 10)
                                <!-- Option 3 : 20 plus récentes -->
                                <a href="{{ request()->fullUrlWithQuery(['limit' => 20, 'all' => null]) }}#listing-feed" 
                                   class="flex items-center justify-between px-4 py-2.5 text-xs sm:text-sm font-semibold text-slate-800 hover:bg-slate-50 hover:text-primary transition-colors {{ request('limit') == 20 ? 'bg-slate-100 text-primary' : '' }}">
                                    <div class="flex items-center gap-2.5">
                                        <span class="material-symbols-outlined text-[18px] text-slate-500">filter_2</span>
                                        <span>20 plus récentes</span>
                                    </div>
                                    @if(request('limit') == 20)
                                        <span class="material-symbols-outlined text-[18px] text-secondary">check</span>
                                    @endif
                                </a>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- ================================================================= -->
    <!-- 4. BANNIÈRE PROMOTIONNELLE & DÉPÔT D'ANNONCE (CTA Banner)         -->
    <!-- ================================================================= -->
    <section class="w-full py-16 md:py-24 bg-surface">
        <div class="max-w-[1360px] mx-auto px-4 sm:px-6 lg:px-10">
            <div class="relative bg-gradient-to-br from-primary via-[#0d1b32] to-primary-container rounded-3xl overflow-hidden shadow-2xl p-6 sm:p-10 md:p-14 text-on-primary border border-primary-fixed-dim/20">
                <!-- Halos lumineux ambiants -->
                <div class="absolute top-0 right-0 w-96 h-96 bg-secondary/20 rounded-full blur-3xl pointer-events-none"></div>
                <div class="absolute -bottom-20 -left-20 w-80 h-80 bg-primary-container/80 rounded-full blur-2xl pointer-events-none"></div>

                <div class="relative z-10 flex flex-col lg:flex-row lg:items-center lg:justify-between gap-8 mb-12">
                    <div class="max-w-xl">
                        <span class="inline-block px-3.5 py-1.5 bg-white/10 backdrop-blur-md text-secondary-fixed font-semibold text-xs uppercase tracking-wider rounded-lg mb-4 border border-white/10">
                            Dépôt ultra rapide &amp; 100% Gratuit
                        </span>
                        <h2 class="text-2xl sm:text-4xl lg:text-5xl font-extrabold text-on-primary mb-4 leading-tight">
                            Donnez une seconde vie à vos objets en 2 minutes.
                        </h2>
                        <p class="text-sm sm:text-base text-slate-300 leading-relaxed">
                            Rejoignez plus de 80 000 vendeurs togolais. Touchez des acheteurs sérieux dès aujourd'hui sans intermédiaire ni commission cachée.
                        </p>
                    </div>
                    <div class="flex flex-col sm:flex-row items-stretch sm:items-center gap-4">
                        <a class="inline-flex items-center justify-center gap-2.5 bg-secondary hover:bg-on-secondary-container text-white font-bold text-base px-8 py-4 rounded-xl shadow-lg hover:shadow-xl transition-all text-center cursor-pointer" href="{{ route('dashboard', ['tab' => 'publier']) }}">
                            <span class="material-symbols-outlined text-[22px]">add_circle</span>
                            <span>Déposer une annonce gratuitement</span>
                        </a>
                    </div>
                </div>

                <!-- Guide en 3 étapes (Aéré et équilibré) -->
                <div class="relative z-10 grid grid-cols-1 md:grid-cols-3 gap-6 sm:gap-8 pt-8 border-t border-white/10">
                    <div class="flex items-start gap-4">
                        <div class="w-11 h-11 rounded-xl bg-secondary text-white flex items-center justify-center font-extrabold text-lg flex-shrink-0 shadow-md">
                            1
                        </div>
                        <div>
                            <h3 class="font-bold text-base text-white mb-1.5">Photographiez votre bien</h3>
                            <p class="text-xs sm:text-sm text-slate-300 leading-relaxed">Prenez 3 photos nettes sous une bonne lumière naturelle avec votre smartphone.</p>
                        </div>
                    </div>
                    <div class="flex items-start gap-4">
                        <div class="w-11 h-11 rounded-xl bg-secondary text-white flex items-center justify-center font-extrabold text-lg flex-shrink-0 shadow-md">
                            2
                        </div>
                        <div>
                            <h3 class="font-bold text-base text-white mb-1.5">Fixez votre juste prix</h3>
                            <p class="text-xs sm:text-sm text-slate-300 leading-relaxed">Rédigez une description claire et indiquez votre ville ou quartier de résidence.</p>
                        </div>
                    </div>
                    <div class="flex items-start gap-4">
                        <div class="w-11 h-11 rounded-xl bg-secondary text-white flex items-center justify-center font-extrabold text-lg flex-shrink-0 shadow-md">
                            3
                        </div>
                        <div>
                            <h3 class="font-bold text-base text-white mb-1.5">Concluez la vente</h3>
                            <p class="text-xs sm:text-sm text-slate-300 leading-relaxed">Échangez via la messagerie instantanée sécurisée et recevez vos fonds en direct.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- ================================================================= -->
    <!-- 5. PILIERS DE SÉCURITÉ & CONFIANCE (Trust Pillars)                -->
    <!-- ================================================================= -->
    <section class="w-full py-16 md:py-24 bg-surface-container-low/60 border-t border-outline-variant/20">
        <div class="max-w-[1360px] mx-auto px-4 sm:px-6 lg:px-10">
            <!-- En-tête -->
            <div class="text-center max-w-2xl mx-auto mb-14">
                <span class="text-xs font-bold text-secondary uppercase tracking-widest block mb-2">Confiance &amp; Sécurité</span>
                <h2 class="text-2xl sm:text-3xl lg:text-4xl font-extrabold text-primary">Pourquoi commercer sur Epsilon ?</h2>
                <p class="text-sm sm:text-base text-on-surface-variant mt-3 leading-relaxed">
                    Nous établissons le nouveau standard de confiance du commerce de proximité grâce à des processus stricts et des outils protecteurs.
                </p>
            </div>

            <!-- Grille des 4 piliers -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                <!-- Pilier 1 -->
                <div class="p-6 md:p-7 bg-white rounded-2xl shadow-sm flex flex-col items-start border border-slate-200/80 hover:shadow-md transition-shadow">
                    <div class="w-13 h-13 rounded-2xl bg-secondary-container/40 text-secondary flex items-center justify-center mb-5">
                        <span class="material-symbols-outlined text-[28px]">payments</span>
                    </div>
                    <h3 class="font-bold text-lg text-primary mb-2">Paiements sécurisés</h3>
                    <p class="text-xs sm:text-sm text-on-surface-variant leading-relaxed">
                        Compatible T-Money, Flooz et cartes bancaires. Les fonds sont protégés jusqu'à validation de la remise en main propre.
                    </p>
                </div>

                <!-- Pilier 2 -->
                <div class="p-6 md:p-7 bg-white rounded-2xl shadow-sm flex flex-col items-start border border-slate-200/80 hover:shadow-md transition-shadow">
                    <div class="w-13 h-13 rounded-2xl bg-primary-fixed/50 text-primary flex items-center justify-center mb-5">
                        <span class="material-symbols-outlined text-[28px]">lock</span>
                    </div>
                    <h3 class="font-bold text-lg text-primary mb-2">Messagerie chiffrée</h3>
                    <p class="text-xs sm:text-sm text-on-surface-variant leading-relaxed">
                        Discutez sans dévoiler votre numéro personnel. Filtre automatique anti-fraude et détection des messages suspects.
                    </p>
                </div>

                <!-- Pilier 3 -->
                <div class="p-6 md:p-7 bg-white rounded-2xl shadow-sm flex flex-col items-start border border-slate-200/80 hover:shadow-md transition-shadow">
                    <div class="w-13 h-13 rounded-2xl bg-secondary-fixed/40 text-secondary flex items-center justify-center mb-5">
                        <span class="material-symbols-outlined text-[28px]">stars</span>
                    </div>
                    <h3 class="font-bold text-lg text-primary mb-2">Profils vérifiés</h3>
                    <p class="text-xs sm:text-sm text-on-surface-variant leading-relaxed">
                        Avis vérifiés post-achat et contrôle systématique des pièces d'identité pour les marchands et boutiques pros.
                    </p>
                </div>

                <!-- Pilier 4 -->
                <div class="p-6 md:p-7 bg-white rounded-2xl shadow-sm flex flex-col items-start border border-slate-200/80 hover:shadow-md transition-shadow">
                    <div class="w-13 h-13 rounded-2xl bg-surface-container-high text-primary flex items-center justify-center mb-5">
                        <span class="material-symbols-outlined text-[28px]">gavel</span>
                    </div>
                    <h3 class="font-bold text-lg text-primary mb-2">Modération 24h/7j</h3>
                    <p class="text-xs sm:text-sm text-on-surface-variant leading-relaxed">
                        Une équipe dédiée veille en continu pour supprimer les contrefaçons et faire respecter nos standards éthiques d'échange.
                    </p>
                </div>
            </div>
        </div>
    </section>

    <!-- ================================================================= -->
    <!-- 6. BARRE D'UTILITAIRES MOBILE FIXE (< 768px - Navigation tactile)  -->
    <!-- ================================================================= -->
    <nav class="md:hidden fixed bottom-0 left-0 right-0 z-50 bg-white/95 backdrop-blur-md border-t border-slate-200/90 py-2 px-3 shadow-[0_-2px_12px_rgba(0,0,0,0.06)]" aria-label="Navigation mobile">
        <div class="max-w-md mx-auto flex items-center justify-around">
            <!-- 1. Accueil -->
            <a href="{{ route('home') }}" class="flex flex-col items-center justify-center text-secondary py-1 px-2 transition-colors">
                <span class="material-symbols-outlined text-[24px]">home</span>
                <span class="text-[11px] font-bold mt-0.5">Accueil</span>
            </a>

            <!-- 2. Explorer -->
            <a href="{{ route('home') }}#listing-feed" class="flex flex-col items-center justify-center text-slate-500 hover:text-primary py-1 px-2 transition-colors">
                <span class="material-symbols-outlined text-[24px]">search</span>
                <span class="text-[11px] font-medium mt-0.5">Explorer</span>
            </a>

            <!-- 3. Déposer (+) Bouton central surélevé -->
            <a href="{{ route('dashboard', ['tab' => 'publier']) }}" class="flex flex-col items-center justify-center -mt-5 group" title="Déposer une annonce">
                <div class="w-12 h-12 rounded-full bg-secondary text-white flex items-center justify-center shadow-lg group-hover:scale-105 transition-transform border-4 border-white">
                    <span class="material-symbols-outlined text-[24px]">add</span>
                </div>
                <span class="text-[11px] font-bold text-secondary mt-0.5">Déposer</span>
            </a>

            <!-- 4. Messages -->
            <a href="{{ route('dashboard') }}" class="relative flex flex-col items-center justify-center text-slate-500 hover:text-primary py-1 px-2 transition-colors">
                <span class="material-symbols-outlined text-[24px]">chat_bubble</span>
                <span class="absolute top-1 right-2 flex items-center justify-center w-4 h-4 bg-secondary text-white font-bold text-[10px] rounded-full shadow-sm">2</span>
                <span class="text-[11px] font-medium mt-0.5">Messages</span>
            </a>

            <!-- 5. Compte -->
            <a href="{{ route('dashboard') }}" class="flex flex-col items-center justify-center text-slate-500 hover:text-primary py-1 px-2 transition-colors">
                <span class="material-symbols-outlined text-[24px]">person</span>
                <span class="text-[11px] font-medium mt-0.5">Compte</span>
            </a>
        </div>
    </nav>

</div>

@push('scripts')
<script>
    function toggleDiscoverDropdown() {
        const menu = document.getElementById('discover-dropdown-menu');
        if (menu) {
            menu.classList.toggle('hidden');
        }
    }

    document.addEventListener('click', function(e) {
        const wrapper = document.getElementById('discover-dropdown-wrapper');
        const menu = document.getElementById('discover-dropdown-menu');
        if (wrapper && menu && !wrapper.contains(e.target)) {
            menu.classList.add('hidden');
        }
    });
</script>
@endpush
@endsection