@extends('layouts.app')

@section('title', 'Epsilon Marketplace | Place de marché nationale n°1 au Togo')

@section('content')
<div class="flex flex-col w-full">

    <!-- ================================================================= -->
    <!-- 1. HERO SECTION (Moderne, Aéré & Épuré)                           -->
    <!-- ================================================================= -->
    <section class="relative w-full bg-gradient-to-b from-surface-container-low via-surface-container-lowest to-surface overflow-hidden pt-10 pb-16 md:pt-16 md:pb-24 border-b border-outline-variant/20">
        <!-- Halos lumineux ambiants -->
        <div class="absolute -top-32 -left-20 w-96 h-96 bg-primary-fixed/25 rounded-full blur-3xl pointer-events-none"></div>
        <div class="absolute top-10 right-0 w-[36rem] h-[36rem] bg-secondary-fixed/25 rounded-full blur-3xl pointer-events-none"></div>

        <div class="max-w-[1360px] mx-auto px-4 sm:px-6 lg:px-10 relative z-10">
            <!-- Badge statut national avec point animé -->
            <div class="flex items-center mb-6">
                <span class="inline-flex items-center gap-2 px-3.5 py-1.5 rounded-full bg-white/90 backdrop-blur-md text-secondary font-semibold text-xs sm:text-sm shadow-sm border border-secondary/20">
                    <span class="w-2 h-2 rounded-full bg-secondary animate-pulse"></span>
                    Place de marché nationale n°1 au Togo
                </span>
            </div>

            <!-- Titre et sous-titre agrandis & aérés -->
            <div class="max-w-4xl mb-10">
                <h1 class="text-3xl sm:text-5xl lg:text-6xl font-extrabold text-primary tracking-tight leading-[1.15] mb-4">
                    Achetez et vendez près de chez vous <span class="text-secondary">en toute confiance.</span>
                </h1>
                <p class="text-base sm:text-lg lg:text-xl text-on-surface-variant max-w-2xl leading-relaxed">
                    Des milliers de bonnes affaires vérifiées chaque jour. Transactions directes, locales et sécurisées entre particuliers et commerçants certifiés.
                </p>
            </div>

            <!-- Barre de recherche flottante premium -->
            <div class="bg-white p-2.5 sm:p-3 rounded-2xl shadow-[0_8px_30px_rgb(0,0,0,0.06)] max-w-4xl mb-8 border border-slate-200/80">
                <div class="flex flex-col md:flex-row items-center gap-2">
                    <!-- Recherche textuelle -->
                    <div class="flex items-center flex-1 w-full px-3 py-2.5">
                        <span class="material-symbols-outlined text-outline text-[22px] mr-2.5">search</span>
                        <input class="w-full bg-transparent outline-none font-body-md text-sm sm:text-base text-on-surface placeholder:text-outline" id="hero-input" placeholder="Que recherchez-vous ? (ex: iPhone 15, Toyota, Studio...)" type="text" onkeyup="if(event.key === 'Enter') { document.getElementById('listing-feed')?.scrollIntoView({behavior: 'smooth'}); }" />
                    </div>

                    <!-- Séparateur vertical (desktop) -->
                    <div class="hidden md:block w-px h-8 bg-slate-200"></div>

                    <!-- Filtre catégorie -->
                    <div class="flex items-center w-full md:w-auto px-3 py-2.5">
                        <span class="material-symbols-outlined text-outline text-[20px] mr-2">category</span>
                        <select class="bg-transparent outline-none font-medium text-xs sm:text-sm text-on-surface cursor-pointer pr-3" aria-label="Toutes catégories">
                            <option value="">Toutes catégories</option>
                            <option value="vehicules">Véhicules</option>
                            <option value="immo">Immobilier</option>
                            <option value="tech">Smartphones & Tech</option>
                            <option value="maison">Mode & Maison</option>
                            <option value="services">Emploi & Services</option>
                        </select>
                    </div>

                    <!-- Séparateur vertical (desktop) -->
                    <div class="hidden md:block w-px h-8 bg-slate-200"></div>

                    <!-- Sélecteur de ville -->
                    <div class="flex items-center w-full md:w-auto px-3 py-2.5">
                        <span class="material-symbols-outlined text-outline text-[20px] mr-2">location_on</span>
                        <select class="bg-transparent outline-none font-medium text-xs sm:text-sm text-on-surface cursor-pointer pr-3" aria-label="Choisir la ville">
                            <option>Tout le Togo</option>
                            <option>Lomé (Grand Lomé)</option>
                            <option>Kara</option>
                            <option>Sokodé</option>
                            <option>Kpalimé</option>
                            <option>Atakpamé</option>
                        </select>
                    </div>

                    <!-- Bouton d'action CTA vert émeraude -->
                    <button class="w-full md:w-auto flex items-center justify-center gap-2 bg-secondary hover:bg-on-secondary-container text-on-secondary font-semibold text-sm sm:text-base px-6 py-3.5 rounded-xl shadow-md hover:shadow-lg transition-all cursor-pointer flex-shrink-0" onclick="document.getElementById('listing-feed')?.scrollIntoView({behavior: 'smooth'})" type="button">
                        <span>Rechercher</span>
                        <span class="material-symbols-outlined text-[18px]">arrow_forward</span>
                    </button>
                </div>
            </div>

            <!-- Mots-clés tendances (Pills cliquables) -->
            <div class="flex flex-wrap items-center gap-2 mb-10">
                <span class="text-xs sm:text-sm font-semibold text-on-surface-variant flex items-center gap-1 mr-1">
                    <span class="material-symbols-outlined text-[16px] text-secondary">trending_up</span> Tendances :
                </span>
                <button class="px-3.5 py-1.5 bg-white hover:bg-slate-100 rounded-full text-xs sm:text-sm font-medium text-primary transition-all border border-slate-200/80 shadow-2xs cursor-pointer" onclick="setSearchTerm('Toyota Corolla')">Toyota Corolla</button>
                <button class="px-3.5 py-1.5 bg-white hover:bg-slate-100 rounded-full text-xs sm:text-sm font-medium text-primary transition-all border border-slate-200/80 shadow-2xs cursor-pointer" onclick="setSearchTerm('iPhone 15 Pro')">iPhone 15 Pro</button>
                <button class="px-3.5 py-1.5 bg-white hover:bg-slate-100 rounded-full text-xs sm:text-sm font-medium text-primary transition-all border border-slate-200/80 shadow-2xs cursor-pointer" onclick="setSearchTerm('Villa avec piscine')">Villa avec piscine</button>
                <button class="px-3.5 py-1.5 bg-white hover:bg-slate-100 rounded-full text-xs sm:text-sm font-medium text-primary transition-all border border-slate-200/80 shadow-2xs cursor-pointer" onclick="setSearchTerm('MacBook Air M2')">MacBook Air M2</button>
                <button class="px-3.5 py-1.5 bg-white hover:bg-slate-100 rounded-full text-xs sm:text-sm font-medium text-primary transition-all border border-slate-200/80 shadow-2xs cursor-pointer" onclick="setSearchTerm('Appartement Lomé 2')">Appartement Lomé 2</button>
            </div>

            <!-- Métriques de réassurance claires & aérées -->
            <div class="grid grid-cols-1 sm:grid-cols-3 gap-4 md:gap-6 pt-4">
                <div class="flex items-center gap-4 p-4 md:p-5 rounded-2xl bg-white/95 shadow-sm border border-slate-200/70 hover:shadow-md transition-shadow">
                    <div class="w-12 h-12 rounded-xl bg-secondary-container/40 flex items-center justify-center text-secondary flex-shrink-0">
                        <span class="material-symbols-outlined text-[28px]">inventory_2</span>
                    </div>
                    <div>
                        <p class="font-extrabold text-xl text-primary leading-none">+120 000</p>
                        <p class="text-xs sm:text-sm text-on-surface-variant mt-1">Annonces actives et modérées</p>
                    </div>
                </div>
                <div class="flex items-center gap-4 p-4 md:p-5 rounded-2xl bg-white/95 shadow-sm border border-slate-200/70 hover:shadow-md transition-shadow">
                    <div class="w-12 h-12 rounded-xl bg-primary-fixed/50 flex items-center justify-center text-primary flex-shrink-0">
                        <span class="material-symbols-outlined text-[28px]">verified_user</span>
                    </div>
                    <div>
                        <p class="font-extrabold text-xl text-primary leading-none">Vendeurs certifiés</p>
                        <p class="text-xs sm:text-sm text-on-surface-variant mt-1">Identité vérifiée à 100%</p>
                    </div>
                </div>
                <div class="flex items-center gap-4 p-4 md:p-5 rounded-2xl bg-white/95 shadow-sm border border-slate-200/70 hover:shadow-md transition-shadow">
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
            <div class="flex flex-col sm:flex-row sm:items-end justify-between gap-4 mb-8">
                <div>
                    <span class="text-xs font-bold text-secondary uppercase tracking-widest block mb-1">Navigation directe</span>
                    <h2 class="text-2xl sm:text-3xl font-extrabold text-primary">Explorer par catégorie</h2>
                </div>
                <a class="inline-flex items-center gap-1.5 text-sm font-semibold text-secondary hover:text-on-secondary-container transition-colors group" href="#listing-feed">
                    <span>Voir toutes les catégories (24)</span>
                    <span class="material-symbols-outlined text-[18px] group-hover:translate-x-1 transition-transform">chevron_right</span>
                </a>
            </div>

            <!-- Grille des 6 catégories -->
            <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-6 gap-4 sm:gap-5">
                <!-- Catégorie 1: Véhicules -->
                <a class="group flex flex-col p-5 bg-white rounded-2xl shadow-sm hover: text-white font-bold text-sm px-4 py-2.5 rounded-xl shadow-md hover:shadow-lg transition-all duration-200 ease-out hover:scale-105 active:scale-95" href="#listing-feed" onclick="filterCategory('vehicules', document.querySelectorAll('.tab-btn')[1])">
                    <div class="w-13 h-13 rounded-xl bg-primary-fixed flex items-center justify-center text-primary mb-4 group-hover:scale-110 transition-transform">
                        <span class="material-symbols-outlined text-[28px]">directions_car</span>
                    </div>
                    <h3 class="font-bold text-base text-primary mb-1">Véhicules</h3>
                    <p class="text-xs text-on-surface-variant line-clamp-1 mb-3">Voitures, motos, pièces</p>
                    <span class="mt-auto text-xs font-semibold text-secondary bg-secondary-container/30 px-2.5 py-1 rounded-full w-max">
                        18 420 annonces
                    </span>
                </a>

                <!-- Catégorie 2: Immobilier -->
                <a class="group flex flex-col p-5 bg-white rounded-2xl shadow-sm hover: text-white font-bold text-sm px-4 py-2.5 rounded-xl shadow-md hover:shadow-lg transition-all duration-200 ease-out hover:scale-105 active:scale-95" href="#listing-feed" onclick="filterCategory('immo', document.querySelectorAll('.tab-btn')[2])">
                    <div class="w-13 h-13 rounded-xl bg-secondary-fixed flex items-center justify-center text-on-secondary-fixed mb-4 group-hover:scale-110 transition-transform">
                        <span class="material-symbols-outlined text-[28px]">apartment</span>
                    </div>
                    <h3 class="font-bold text-base text-primary mb-1">Immobilier</h3>
                    <p class="text-xs text-on-surface-variant line-clamp-1 mb-3">Vente, location, terrains</p>
                    <span class="mt-auto text-xs font-semibold text-secondary bg-secondary-container/30 px-2.5 py-1 rounded-full w-max">
                        9 850 annonces
                    </span>
                </a>

                <!-- Catégorie 3: Électronique & High-Tech -->
                <a class="group flex flex-col p-5 bg-white rounded-2xl shadow-sm hover: text-white font-bold text-sm px-4 py-2.5 rounded-xl shadow-md hover:shadow-lg transition-all duration-200 ease-out hover:scale-105 active:scale-95" href="#listing-feed" onclick="filterCategory('tech', document.querySelectorAll('.tab-btn')[3])">
                    <div class="w-13 h-13 rounded-xl bg-primary-fixed-dim flex items-center justify-center text-primary mb-4 group-hover:scale-110 transition-transform">
                        <span class="material-symbols-outlined text-[28px]">devices</span>
                    </div>
                    <h3 class="font-bold text-base text-primary mb-1">Électronique</h3>
                    <p class="text-xs text-on-surface-variant line-clamp-1 mb-3">Smartphones, PC, TV</p>
                    <span class="mt-auto text-xs font-semibold text-secondary bg-secondary-container/30 px-2.5 py-1 rounded-full w-max">
                        24 130 annonces
                    </span>
                </a>

                <!-- Catégorie 4: Mode & Beauté -->
                <a class="group flex flex-col p-5 bg-white rounded-2xl shadow-sm hover: text-white font-bold text-sm px-4 py-2.5 rounded-xl shadow-md hover:shadow-lg transition-all duration-200 ease-out hover:scale-105 active:scale-95" href="#listing-feed">
                    <div class="w-13 h-13 rounded-xl bg-tertiary-fixed flex items-center justify-center text-tertiary mb-4 group-hover:scale-110 transition-transform">
                        <span class="material-symbols-outlined text-[28px]">apparel</span>
                    </div>
                    <h3 class="font-bold text-base text-primary mb-1">Mode &amp; Beauté</h3>
                    <p class="text-xs text-on-surface-variant line-clamp-1 mb-3">Vêtements, montres</p>
                    <span class="mt-auto text-xs font-semibold text-secondary bg-secondary-container/30 px-2.5 py-1 rounded-full w-max">
                        15 200 annonces
                    </span>
                </a>

                <!-- Catégorie 5: Maison & Mobilier -->
                <a class="group flex flex-col p-5 bg-white rounded-2xl shadow-sm hover: text-white font-bold text-sm px-4 py-2.5 rounded-xl shadow-md hover:shadow-lg transition-all duration-200 ease-out hover:scale-105 active:scale-95" href="#listing-feed" onclick="filterCategory('maison', document.querySelectorAll('.tab-btn')[4])">
                    <div class="w-13 h-13 rounded-xl bg-surface-container-high flex items-center justify-center text-primary mb-4 group-hover:scale-110 transition-transform">
                        <span class="material-symbols-outlined text-[28px]">chair</span>
                    </div>
                    <h3 class="font-bold text-base text-primary mb-1">Maison</h3>
                    <p class="text-xs text-on-surface-variant line-clamp-1 mb-3">Meubles, déco, cuisine</p>
                    <span class="mt-auto text-xs font-semibold text-secondary bg-secondary-container/30 px-2.5 py-1 rounded-full w-max">
                        12 700 annonces
                    </span>
                </a>

                <!-- Catégorie 6: Emploi & Services -->
                <a class="group flex flex-col p-5 bg-white rounded-2xl shadow-sm hover: text-white font-bold text-sm px-4 py-2.5 rounded-xl shadow-md hover:shadow-lg transition-all duration-200 ease-out hover:scale-105 active:scale-95" href="#listing-feed">
                    <div class="w-13 h-13 rounded-xl bg-secondary-container flex items-center justify-center text-on-secondary-container mb-4 group-hover:scale-110 transition-transform">
                        <span class="material-symbols-outlined text-[28px]">work</span>
                    </div>
                    <h3 class="font-bold text-base text-primary mb-1">Services</h3>
                    <p class="text-xs text-on-surface-variant line-clamp-1 mb-3">Emploi, artisanat, cours</p>
                    <span class="mt-auto text-xs font-semibold text-secondary bg-secondary-container/30 px-2.5 py-1 rounded-full w-max">
                        6 340 annonces
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
        <div class="product-section-wrapper" style="margin-left: 1cm; margin-right: 1cm;">
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

                    <!-- Carte 1: Toyota RAV4 -->
                    <div class="listing-item product-card group bg-white rounded-2xl border border-slate-200/80 hover:border-secondary/40 shadow-[0_2px_12px_rgba(15,23,42,0.04)] hover:shadow-[0_16px_32px_rgba(15,23,42,0.09)] transition-all duration-300 hover:-translate-y-1.5 flex flex-col overflow-hidden" data-cat="vehicules">
                        <!-- Image agrandie -->
                        <div class="relative w-full h-56 sm:h-52 md:h-60 overflow-hidden bg-slate-100">
                            <img class="product-card-img w-full h-full object-cover group-hover:scale-105 transition-transform duration-500 ease-out" alt="Toyota RAV4 2021 AWD Boîte Auto" src="https://lh3.googleusercontent.com/aida-public/AB6AXuAodb_3vGNYkwNoDN9jLWqta21OPu6w17feuzjNl_fAWfHdU8F4_hBWLp2P5uuLQdMUpv4SyfL4UU45X_IuUxAnz7bsyjbY4gh1-0C1bKqTJVy_55-DlxwDlRCR6KWtM3CZ3-ryAic7gH9mB6ulAcAIPJMvHnIWsG6ahnBuRsOlNvCg07hy--lwRgLCV2HQvoOfwtMzy0BEuYOOBgfNQjxf6eoR849xWaqig60M_YA2qFFfZL7X83wv" loading="lazy" />
                            <div class="absolute top-3 left-3 flex gap-2">
                                <span class="bg-secondary text-white px-3 py-1 rounded-lg text-xs font-bold shadow-sm flex items-center gap-1">
                                    <span class="material-symbols-outlined text-[14px]">bolt</span> Sponsorisé
                                </span>
                                <span class="bg-white/95 backdrop-blur-md text-primary px-2.5 py-1 rounded-lg text-xs font-semibold shadow-sm">
                                    Occasion
                                </span>
                            </div>
                            <button class="fav-btn absolute top-3 right-3 w-9 h-9 rounded-full bg-white/90 backdrop-blur-md hover:bg-white flex items-center justify-center text-slate-500 hover:text-error transition-all shadow-sm hover:scale-110 cursor-pointer" onclick="toggleFav(this)" title="Ajouter aux favoris">
                                <span class="material-symbols-outlined text-[20px]">favorite</span>
                            </button>
                        </div>
                        <!-- Contenu interne avec espacement amélioré (p-5 / p-6) -->
                        <div class="p-5 md:p-6 flex flex-col flex-1 justify-between gap-3">
                            <div>
                                <span class="text-xs font-semibold text-secondary uppercase tracking-wider block mb-1">Véhicules</span>
                                <h3 class="text-base sm:text-lg font-bold text-primary line-clamp-1 group-hover:text-secondary transition-colors">
                                    Toyota RAV4 2021 AWD Boîte Auto
                                </h3>
                                <div class="flex items-baseline gap-1 mt-2">
                                    <span class="text-xl sm:text-2xl font-extrabold text-secondary tracking-tight">16 500 000</span>
                                    <span class="text-xs font-bold text-slate-500">FCFA</span>
                                </div>
                            </div>
                            <div class="pt-3 border-t border-slate-100 flex items-center justify-between text-xs sm:text-sm text-slate-500">
                                <span class="flex items-center gap-1.5 truncate">
                                    <span class="material-symbols-outlined text-[16px] text-slate-400">location_on</span> Lomé, Agoè
                                </span>
                                <span class="inline-flex items-center gap-1 font-semibold text-secondary bg-secondary-container/30 px-2 py-0.5 rounded text-xs">
                                    <span class="w-1.5 h-1.5 rounded-full bg-secondary"></span> Pro
                                </span>
                            </div>
                        </div>
                    </div>

                    <!-- Carte 2: iPhone 15 Pro Max -->
                    <div class="listing-item product-card group bg-white rounded-2xl border border-slate-200/80 hover:border-secondary/40 shadow-[0_2px_12px_rgba(15,23,42,0.04)] hover:shadow-[0_16px_32px_rgba(15,23,42,0.09)] transition-all duration-300 hover:-translate-y-1.5 flex flex-col overflow-hidden" data-cat="tech">
                        <!-- Image agrandie -->
                        <div class="relative w-full h-56 sm:h-52 md:h-60 overflow-hidden bg-slate-100">
                            <img class="product-card-img w-full h-full object-cover group-hover:scale-105 transition-transform duration-500 ease-out" alt="iPhone 15 Pro Max 256GB Titane" src="https://lh3.googleusercontent.com/aida-public/AB6AXuC5E5-OmSho5aQXPxZGBor15KdAcX2nNwcHF-omlpF9RO6DYeFgxdJhF-SJt-b8XSi5ge1p2KcMmqrpFc7bpmZAYx7C4UkcqfHowA3wFcy1tMmTa6zyXmlCdB3Q0hTpxoZnfi78FzYCJleYJnHgXGp0_okG716OHcPwmYWpem7reygKYIQHWNLjR3ckCJbjPux8MzUVOMfs9WJat7AGGc1y_SXJLXijWvfAsEIEXIJM0kaDYTIvSc5w" loading="lazy" />
                            <div class="absolute top-3 left-3 flex gap-2">
                                <span class="bg-error text-white px-3 py-1 rounded-lg text-xs font-bold shadow-sm flex items-center gap-1">
                                    <span class="material-symbols-outlined text-[14px]">alarm</span> Urgent
                                </span>
                                <span class="bg-white/95 backdrop-blur-md text-primary px-2.5 py-1 rounded-lg text-xs font-semibold shadow-sm">
                                    Neuf
                                </span>
                            </div>
                            <button class="fav-btn absolute top-3 right-3 w-9 h-9 rounded-full bg-white/90 backdrop-blur-md hover:bg-white flex items-center justify-center text-slate-500 hover:text-error transition-all shadow-sm hover:scale-110 cursor-pointer" onclick="toggleFav(this)" title="Ajouter aux favoris">
                                <span class="material-symbols-outlined text-[20px]">favorite</span>
                            </button>
                        </div>
                        <!-- Contenu interne avec espacement amélioré -->
                        <div class="p-5 md:p-6 flex flex-col flex-1 justify-between gap-3">
                            <div>
                                <span class="text-xs font-semibold text-secondary uppercase tracking-wider block mb-1">High-Tech</span>
                                <h3 class="text-base sm:text-lg font-bold text-primary line-clamp-1 group-hover:text-secondary transition-colors">
                                    iPhone 15 Pro Max 256GB Titane
                                </h3>
                                <div class="flex items-baseline gap-1 mt-2">
                                    <span class="text-xl sm:text-2xl font-extrabold text-secondary tracking-tight">780 000</span>
                                    <span class="text-xs font-bold text-slate-500">FCFA</span>
                                </div>
                            </div>
                            <div class="pt-3 border-t border-slate-100 flex items-center justify-between text-xs sm:text-sm text-slate-500">
                                <span class="flex items-center gap-1.5 truncate">
                                    <span class="material-symbols-outlined text-[16px] text-slate-400">location_on</span> Lomé, Tokoin
                                </span>
                                <span class="text-xs text-slate-400">Il y a 1h</span>
                            </div>
                        </div>
                    </div>

                    <!-- Carte 3: Villa duplex -->
                    <div class="listing-item product-card group bg-white rounded-2xl border border-slate-200/80 hover:border-secondary/40 shadow-[0_2px_12px_rgba(15,23,42,0.04)] hover:shadow-[0_16px_32px_rgba(15,23,42,0.09)] transition-all duration-300 hover:-translate-y-1.5 flex flex-col overflow-hidden" data-cat="immo">
                        <!-- Image agrandie -->
                        <div class="relative w-full h-56 sm:h-52 md:h-60 overflow-hidden bg-slate-100">
                            <img class="product-card-img w-full h-full object-cover group-hover:scale-105 transition-transform duration-500 ease-out" alt="Villa duplex 5 pièces avec jardin" src="https://lh3.googleusercontent.com/aida-public/AB6AXuCW0-PIMuH6jSyzOY-_eJUAy3tXxoCUJq7vxlOI4J3-yDpK5wuYVvKxZxjZhB6ICuPPCGjGJIQgVrd_QISmp1h7WkzHXUJwT0c1NazIGWehSg2pe7X8NhNgElRQGAw6Ik3QgKbMkjvg1A8kY9RJS1u3_lcg0iohUXnryxUt912B890gaB1s81I-oms6foF0IKo1tgIF11vU2zDNUQDXXjs8BWuEV7xg3C7udWDVSxH-NA9rU6cKMn2-" loading="lazy" />
                            <div class="absolute top-3 left-3 flex gap-2">
                                <span class="bg-secondary text-white px-3 py-1 rounded-lg text-xs font-bold shadow-sm flex items-center gap-1">
                                    <span class="material-symbols-outlined text-[14px]">bolt</span> Sponsorisé
                                </span>
                            </div>
                            <button class="fav-btn absolute top-3 right-3 w-9 h-9 rounded-full bg-white/90 backdrop-blur-md hover:bg-white flex items-center justify-center text-slate-500 hover:text-error transition-all shadow-sm hover:scale-110 cursor-pointer" onclick="toggleFav(this)" title="Ajouter aux favoris">
                                <span class="material-symbols-outlined text-[20px]">favorite</span>
                            </button>
                        </div>
                        <!-- Contenu interne avec espacement amélioré -->
                        <div class="p-5 md:p-6 flex flex-col flex-1 justify-between gap-3">
                            <div>
                                <span class="text-xs font-semibold text-secondary uppercase tracking-wider block mb-1">Immobilier</span>
                                <h3 class="text-base sm:text-lg font-bold text-primary line-clamp-1 group-hover:text-secondary transition-colors">
                                    Villa duplex 5 pièces avec piscine
                                </h3>
                                <div class="flex items-baseline gap-1 mt-2">
                                    <span class="text-xl sm:text-2xl font-extrabold text-primary tracking-tight">65 000 000</span>
                                    <span class="text-xs font-bold text-slate-500">FCFA</span>
                                </div>
                            </div>
                            <div class="pt-3 border-t border-slate-100 flex items-center justify-between text-xs sm:text-sm text-slate-500">
                                <span class="flex items-center gap-1.5 truncate">
                                    <span class="material-symbols-outlined text-[16px] text-slate-400">location_on</span> Baguida Plage
                                </span>
                                <span class="text-xs font-bold text-secondary bg-secondary-container/30 px-2 py-0.5 rounded">Vérifié</span>
                            </div>
                        </div>
                    </div>

                    <!-- Carte 4: MacBook Pro M3 -->
                    <div class="listing-item product-card group bg-white rounded-2xl border border-slate-200/80 hover:border-secondary/40 shadow-[0_2px_12px_rgba(15,23,42,0.04)] hover:shadow-[0_16px_32px_rgba(15,23,42,0.09)] transition-all duration-300 hover:-translate-y-1.5 flex flex-col overflow-hidden" data-cat="tech">
                        <!-- Image agrandie -->
                        <div class="relative w-full h-56 sm:h-52 md:h-60 overflow-hidden bg-slate-100">
                            <img class="product-card-img w-full h-full object-cover group-hover:scale-105 transition-transform duration-500 ease-out" alt="MacBook Pro 14 M3 Pro 18GB" src="https://lh3.googleusercontent.com/aida-public/AB6AXuANnywcqkUmvlYTZwgrDs4Osb0aFUL2f88G8jF2XH56CzNHewn9ZYCkWcZ9QTRSiqBMPZ1CxrnHOQejWepkjtAXPk8A4rlCU8jnwfnx323Mlizzoqq3lGShulTzaVUd4vphh_jR6LJFXllPgybJvC5wYSZ9rXHDbtxMLixNmizGUxZX0aYp-4RpAMD6FfD6QYfAG569DJCon1aBeHF46P5FZ1KLPO8QqsI2U9HpUlWZjCjTadRXbgRD" loading="lazy" />
                            <div class="absolute top-3 left-3">
                                <span class="bg-white/95 backdrop-blur-md text-primary px-2.5 py-1 rounded-lg text-xs font-semibold shadow-sm">
                                    Comme neuf
                                </span>
                            </div>
                            <button class="fav-btn absolute top-3 right-3 w-9 h-9 rounded-full bg-white/90 backdrop-blur-md hover:bg-white flex items-center justify-center text-slate-500 hover:text-error transition-all shadow-sm hover:scale-110 cursor-pointer" onclick="toggleFav(this)" title="Ajouter aux favoris">
                                <span class="material-symbols-outlined text-[20px]">favorite</span>
                            </button>
                        </div>
                        <!-- Contenu interne avec espacement amélioré -->
                        <div class="p-5 md:p-6 flex flex-col flex-1 justify-between gap-3">
                            <div>
                                <span class="text-xs font-semibold text-secondary uppercase tracking-wider block mb-1">Informatique</span>
                                <h3 class="text-base sm:text-lg font-bold text-primary line-clamp-1 group-hover:text-secondary transition-colors">
                                    MacBook Pro 14" M3 Pro 18GB
                                </h3>
                                <div class="flex items-baseline gap-1 mt-2">
                                    <span class="text-xl sm:text-2xl font-extrabold text-secondary tracking-tight">1 350 000</span>
                                    <span class="text-xs font-bold text-slate-500">FCFA</span>
                                </div>
                            </div>
                            <div class="pt-3 border-t border-slate-100 flex items-center justify-between text-xs sm:text-sm text-slate-500">
                                <span class="flex items-center gap-1.5 truncate">
                                    <span class="material-symbols-outlined text-[16px] text-slate-400">location_on</span> Centre-Ville
                                </span>
                                <span class="text-xs text-slate-400">Il y a 3h</span>
                            </div>
                        </div>
                    </div>

                    <!-- Carte 5: Salon d'angle velours -->
                    <div class="listing-item product-card group bg-white rounded-2xl border border-slate-200/80 hover:border-secondary/40 shadow-[0_2px_12px_rgba(15,23,42,0.04)] hover:shadow-[0_16px_32px_rgba(15,23,42,0.09)] transition-all duration-300 hover:-translate-y-1.5 flex flex-col overflow-hidden" data-cat="maison">
                        <!-- Image agrandie -->
                        <div class="relative w-full h-56 sm:h-52 md:h-60 overflow-hidden bg-slate-100">
                            <img class="product-card-img w-full h-full object-cover group-hover:scale-105 transition-transform duration-500 ease-out" alt="Salon d'angle velours moderne 6 pl." src="https://lh3.googleusercontent.com/aida-public/AB6AXuB6GGcD2BSTLPkAz0zkycry01Vqes8kghNo_xOZEwaC0tchZ8s_IjSxVfs6Tt4WLcupjX3MCB464Dk4Hz9qPGydNpHQ7pulUeTSM8ycy6j_GfEs9UGsne4lvSHR_QqLlxIGxKzxpXrxgGwpbqWTwB0p-7Vp9MI8_xcNoZobSQOH8npTo6Afr3VD4qCcuu2-IPH_mTkCA6PaTNY147mLS5lzqyl-S9iJPI3VndbpnpSqYrlL7xsfmMkE" loading="lazy" />
                            <div class="absolute top-3 left-3">
                                <span class="bg-white/95 backdrop-blur-md text-primary px-2.5 py-1 rounded-lg text-xs font-semibold shadow-sm">
                                    Neuf en atelier
                                </span>
                            </div>
                            <button class="fav-btn absolute top-3 right-3 w-9 h-9 rounded-full bg-white/90 backdrop-blur-md hover:bg-white flex items-center justify-center text-slate-500 hover:text-error transition-all shadow-sm hover:scale-110 cursor-pointer" onclick="toggleFav(this)" title="Ajouter aux favoris">
                                <span class="material-symbols-outlined text-[20px]">favorite</span>
                            </button>
                        </div>
                        <!-- Contenu interne avec espacement amélioré -->
                        <div class="p-5 md:p-6 flex flex-col flex-1 justify-between gap-3">
                            <div>
                                <span class="text-xs font-semibold text-secondary uppercase tracking-wider block mb-1">Maison</span>
                                <h3 class="text-base sm:text-lg font-bold text-primary line-clamp-1 group-hover:text-secondary transition-colors">
                                    Salon d'angle velours moderne 6 pl.
                                </h3>
                                <div class="flex items-baseline gap-1 mt-2">
                                    <span class="text-xl sm:text-2xl font-extrabold text-secondary tracking-tight">320 000</span>
                                    <span class="text-xs font-bold text-slate-500">FCFA</span>
                                </div>
                            </div>
                            <div class="pt-3 border-t border-slate-100 flex items-center justify-between text-xs sm:text-sm text-slate-500">
                                <span class="flex items-center gap-1.5 truncate">
                                    <span class="material-symbols-outlined text-[16px] text-slate-400">location_on</span> Hedzranawoé
                                </span>
                                <span class="text-xs text-slate-400">Il y a 4h</span>
                            </div>
                        </div>
                    </div>

                    <!-- Carte 6: PS5 Slim Edition -->
                    <div class="listing-item product-card group bg-white rounded-2xl border border-slate-200/80 hover:border-secondary/40 shadow-[0_2px_12px_rgba(15,23,42,0.04)] hover:shadow-[0_16px_32px_rgba(15,23,42,0.09)] transition-all duration-300 hover:-translate-y-1.5 flex flex-col overflow-hidden" data-cat="tech">
                        <!-- Image agrandie -->
                        <div class="relative w-full h-56 sm:h-52 md:h-60 overflow-hidden bg-slate-100">
                            <img class="product-card-img w-full h-full object-cover group-hover:scale-105 transition-transform duration-500 ease-out" alt="Sony PS5 Slim + 2 Manettes" src="https://lh3.googleusercontent.com/aida-public/AB6AXuB8SBB_TaZYkJ8_MWHFOqEsgUaOPFtnqTn7AtPeCJ3cqbDDKf34pVeXT4GkaQwIk4oMVOfXy0evzXiozhmOi7k95sy63_6LTxjRvx8Yv7Cp0FSMDypSaVMxSJwbAATgz5PpKKUrYEvqXeKHAgyZUEPqA0QK_OovzZyDtqYnAxr4bJGykFtSeP7xclBLhYcqulrme4necEwCBJRfObZvqDEtWMF37LBtQEWpO_aL0avkjpnYaIOis9Qu" loading="lazy" />
                            <div class="absolute top-3 left-3 flex gap-2">
                                <span class="bg-error text-white px-3 py-1 rounded-lg text-xs font-bold shadow-sm flex items-center gap-1">
                                    <span class="material-symbols-outlined text-[14px]">alarm</span> Urgent
                                </span>
                            </div>
                            <button class="fav-btn absolute top-3 right-3 w-9 h-9 rounded-full bg-white/90 backdrop-blur-md hover:bg-white flex items-center justify-center text-slate-500 hover:text-error transition-all shadow-sm hover:scale-110 cursor-pointer" onclick="toggleFav(this)" title="Ajouter aux favoris">
                                <span class="material-symbols-outlined text-[20px]">favorite</span>
                            </button>
                        </div>
                        <!-- Contenu interne avec espacement amélioré -->
                        <div class="p-5 md:p-6 flex flex-col flex-1 justify-between gap-3">
                            <div>
                                <span class="text-xs font-semibold text-secondary uppercase tracking-wider block mb-1">Gaming</span>
                                <h3 class="text-base sm:text-lg font-bold text-primary line-clamp-1 group-hover:text-secondary transition-colors">
                                    Sony PS5 Slim + 2 Manettes
                                </h3>
                                <div class="flex items-baseline gap-1 mt-2">
                                    <span class="text-xl sm:text-2xl font-extrabold text-secondary tracking-tight">390 000</span>
                                    <span class="text-xs font-bold text-slate-500">FCFA</span>
                                </div>
                            </div>
                            <div class="pt-3 border-t border-slate-100 flex items-center justify-between text-xs sm:text-sm text-slate-500">
                                <span class="flex items-center gap-1.5 truncate">
                                    <span class="material-symbols-outlined text-[16px] text-slate-400">location_on</span> Adidogomé
                                </span>
                                <span class="text-xs text-slate-400">Il y a 5h</span>
                            </div>
                        </div>
                    </div>

                    <!-- Carte 7: Moto Yamaha MT-07 -->
                    <div class="listing-item product-card group bg-white rounded-2xl border border-slate-200/80 hover:border-secondary/40 shadow-[0_2px_12px_rgba(15,23,42,0.04)] hover:shadow-[0_16px_32px_rgba(15,23,42,0.09)] transition-all duration-300 hover:-translate-y-1.5 flex flex-col overflow-hidden" data-cat="vehicules">
                        <!-- Image agrandie -->
                        <div class="relative w-full h-56 sm:h-52 md:h-60 overflow-hidden bg-slate-100">
                            <img class="product-card-img w-full h-full object-cover group-hover:scale-105 transition-transform duration-500 ease-out" alt="Moto Yamaha MT-07 ABS 2022" src="https://lh3.googleusercontent.com/aida-public/AB6AXuBWtb2TsKDfZ0_AhHB-rzKvU39fPZEYqZ3EKK6e3oKYXS3upyAye_47WwSfHs_0XHQuNdkZTykhRLRs9X-r6KQXkqJoscaI7SjP6sGfhzY5zhlRbx00pSdomMOMBF-4vAywCzEti_pOnhxkHGOlGfz8dDTktzo3igKypm7UHtS1bjsRUQJEX2BScLlYspgq2AOSDIjPCS2hkjVYrNYroJpMiQWguYqv0xBFgVrkZxWRAnxu6U6BRTN9" loading="lazy" />
                            <div class="absolute top-3 left-3">
                                <span class="bg-white/95 backdrop-blur-md text-primary px-2.5 py-1 rounded-lg text-xs font-semibold shadow-sm">
                                    Excellent état
                                </span>
                            </div>
                            <button class="fav-btn absolute top-3 right-3 w-9 h-9 rounded-full bg-white/90 backdrop-blur-md hover:bg-white flex items-center justify-center text-slate-500 hover:text-error transition-all shadow-sm hover:scale-110 cursor-pointer" onclick="toggleFav(this)" title="Ajouter aux favoris">
                                <span class="material-symbols-outlined text-[20px]">favorite</span>
                            </button>
                        </div>
                        <!-- Contenu interne avec espacement amélioré -->
                        <div class="p-5 md:p-6 flex flex-col flex-1 justify-between gap-3">
                            <div>
                                <span class="text-xs font-semibold text-secondary uppercase tracking-wider block mb-1">Motos</span>
                                <h3 class="text-base sm:text-lg font-bold text-primary line-clamp-1 group-hover:text-secondary transition-colors">
                                    Moto Yamaha MT-07 ABS 2022
                                </h3>
                                <div class="flex items-baseline gap-1 mt-2">
                                    <span class="text-xl sm:text-2xl font-extrabold text-secondary tracking-tight">4 200 000</span>
                                    <span class="text-xs font-bold text-slate-500">FCFA</span>
                                </div>
                            </div>
                            <div class="pt-3 border-t border-slate-100 flex items-center justify-between text-xs sm:text-sm text-slate-500">
                                <span class="flex items-center gap-1.5 truncate">
                                    <span class="material-symbols-outlined text-[16px] text-slate-400">location_on</span> Bè-Kpota
                                </span>
                                <span class="text-xs text-slate-400">Il y a 6h</span>
                            </div>
                        </div>
                    </div>

                    <!-- Carte 8: Seiko Diver -->
                    <div class="listing-item product-card group bg-white rounded-2xl border border-slate-200/80 hover:border-secondary/40 shadow-[0_2px_12px_rgba(15,23,42,0.04)] hover:shadow-[0_16px_32px_rgba(15,23,42,0.09)] transition-all duration-300 hover:-translate-y-1.5 flex flex-col overflow-hidden" data-cat="tech">
                        <!-- Image agrandie -->
                        <div class="relative w-full h-56 sm:h-52 md:h-60 overflow-hidden bg-slate-100">
                            <img class="product-card-img w-full h-full object-cover group-hover:scale-105 transition-transform duration-500 ease-out" alt="Montre Seiko Prospex Auto 200m" src="https://lh3.googleusercontent.com/aida-public/AB6AXuAOpJcwEl8oWxsQ08emdXGUo8x9pIOj1ugllp6dudCYFWNGl6pfHo4y9gQ3JKCHqhccJlFcnj7T799-jHOPbygUZ3Iukkq_7vtFq15hRlcF6nTPs_0Oi1EOWMZA9Be9eYEomQCM1uwa1hzA0U5IVN12N2O-e9Ll4ba0uytijmEyRkqoEY99APzWy8sekDHPg1AEu_P0JIyl7TgIZUsa87om4ZurjYSmolBGh2Gc35BuWopDL7Iii6iI" loading="lazy" />
                            <div class="absolute top-3 left-3">
                                <span class="bg-white/95 backdrop-blur-md text-primary px-2.5 py-1 rounded-lg text-xs font-semibold shadow-sm">
                                    Boîte d'origine
                                </span>
                            </div>
                            <button class="fav-btn absolute top-3 right-3 w-9 h-9 rounded-full bg-white/90 backdrop-blur-md hover:bg-white flex items-center justify-center text-slate-500 hover:text-error transition-all shadow-sm hover:scale-110 cursor-pointer" onclick="toggleFav(this)" title="Ajouter aux favoris">
                                <span class="material-symbols-outlined text-[20px]">favorite</span>
                            </button>
                        </div>
                        <!-- Contenu interne avec espacement amélioré -->
                        <div class="p-5 md:p-6 flex flex-col flex-1 justify-between gap-3">
                            <div>
                                <span class="text-xs font-semibold text-secondary uppercase tracking-wider block mb-1">Montres</span>
                                <h3 class="text-base sm:text-lg font-bold text-primary line-clamp-1 group-hover:text-secondary transition-colors">
                                    Montre Seiko Prospex Auto 200m
                                </h3>
                                <div class="flex items-baseline gap-1 mt-2">
                                    <span class="text-xl sm:text-2xl font-extrabold text-secondary tracking-tight">210 000</span>
                                    <span class="text-xs font-bold text-slate-500">FCFA</span>
                                </div>
                            </div>
                            <div class="pt-3 border-t border-slate-100 flex items-center justify-between text-xs sm:text-sm text-slate-500">
                                <span class="flex items-center gap-1.5 truncate">
                                    <span class="material-symbols-outlined text-[16px] text-slate-400">location_on</span> Nyékonakpoè
                                </span>
                                <span class="text-xs text-slate-400">Il y a 7h</span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Message si aucun produit ne correspond au filtre -->
                <div id="no-listings-notice" class="hidden text-center py-16">
                    <span class="material-symbols-outlined text-5xl text-slate-400 mb-2">search_off</span>
                    <p class="text-primary font-bold text-lg">Aucune annonce trouvée dans cette catégorie</p>
                    <p class="text-on-surface-variant text-sm mt-1">Sélectionnez l'onglet "Tout" pour découvrir d'autres opportunités disponibles.</p>
                </div>

                <!-- Bouton de découverte -->
                <div class="mt-14 flex justify-center">
                    <a class="inline-flex items-center gap-2 px-8 py-3.5 bg-white hover:bg-slate-50 text-primary font-bold text-sm sm:text-base rounded-xl shadow-sm hover:shadow-md transition-all border border-slate-200/80 cursor-pointer" href="#">
                        <span>Découvrir plus de 45 000 annonces</span>
                        <span class="material-symbols-outlined text-[20px]">expand_more</span>
                    </a>
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
                        <a class="inline-flex items-center justify-center gap-2.5 bg-secondary hover:bg-on-secondary-container text-white font-bold text-base px-8 py-4 rounded-xl shadow-lg hover:shadow-xl transition-all text-center cursor-pointer" href="#">
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
            <a href="{{ url('/') }}" class="flex flex-col items-center justify-center text-secondary py-1 px-2 transition-colors">
                <span class="material-symbols-outlined text-[24px]">home</span>
                <span class="text-[11px] font-bold mt-0.5">Accueil</span>
            </a>

            <!-- 2. Explorer -->
            <a href="#listing-feed" class="flex flex-col items-center justify-center text-slate-500 hover:text-primary py-1 px-2 transition-colors">
                <span class="material-symbols-outlined text-[24px]">search</span>
                <span class="text-[11px] font-medium mt-0.5">Explorer</span>
            </a>

            <!-- 3. Déposer (+) Bouton central surélevé -->
            <a href="#" class="flex flex-col items-center justify-center -mt-5 group" title="Déposer une annonce">
                <div class="w-12 h-12 rounded-full bg-secondary text-white flex items-center justify-center shadow-lg group-hover:scale-105 transition-transform border-4 border-white">
                    <span class="material-symbols-outlined text-[24px]">add</span>
                </div>
                <span class="text-[11px] font-bold text-secondary mt-0.5">Déposer</span>
            </a>

            <!-- 4. Messages -->
            <a href="#" class="relative flex flex-col items-center justify-center text-slate-500 hover:text-primary py-1 px-2 transition-colors">
                <span class="material-symbols-outlined text-[24px]">chat_bubble</span>
                <span class="absolute top-1 right-2 flex items-center justify-center w-4 h-4 bg-secondary text-white font-bold text-[10px] rounded-full shadow-sm">2</span>
                <span class="text-[11px] font-medium mt-0.5">Messages</span>
            </a>

            <!-- 5. Compte -->
            <a href="#" class="flex flex-col items-center justify-center text-slate-500 hover:text-primary py-1 px-2 transition-colors">
                <span class="material-symbols-outlined text-[24px]">person</span>
                <span class="text-[11px] font-medium mt-0.5">Compte</span>
            </a>
        </div>
    </nav>

</div>
@endsection