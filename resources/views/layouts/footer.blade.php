<!-- ================================================================= -->
<!-- FOOTER PRINCIPAL (Moderne, Aéré, Harmonieux & Professionnel)      -->
<!-- ================================================================= -->
<footer class="w-full bg-slate-900 text-slate-300 mt-20 border-t border-slate-800">
    <div class="max-w-[1360px] mx-auto px-4 sm:px-6 lg:px-8 py-16 lg:py-20">

        <!-- Grille principale à 5 colonnes sur desktop, 2 sur tablette, 1 sur mobile -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-5 gap-10 lg:gap-12 mb-16">

            <!-- Colonne 1 : Identité & Marque Epsilon -->
            <div class="lg:col-span-1">
                <div class="flex items-center gap-3 mb-4">
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
                    <span class="font-extrabold text-2xl text-white tracking-tight">Epsilon</span>
                </div>
                <p class="text-xs sm:text-sm text-slate-400 mb-6 leading-relaxed">
                    La marketplace de référence pour acheter, vendre et échanger en toute sécurité au Togo et dans la sous-région.
                </p>
                <!-- Réseaux sociaux & Liens -->
                <div class="flex items-center gap-2.5">
                    <a class="w-9 h-9 rounded-xl bg-slate-800/80 hover:bg-secondary text-slate-300 hover:text-white flex items-center justify-center transition-all cursor-pointer shadow-sm" href="#" title="Site Web" aria-label="Site Web">
                        <span class="material-symbols-outlined text-[19px]">public</span>
                    </a>
                    <a class="w-9 h-9 rounded-xl bg-slate-800/80 hover:bg-secondary text-slate-300 hover:text-white flex items-center justify-center transition-all cursor-pointer shadow-sm" href="#" title="Partager" aria-label="Partager">
                        <span class="material-symbols-outlined text-[19px]">share</span>
                    </a>
                    <a class="w-9 h-9 rounded-xl bg-slate-800/80 hover:bg-secondary text-slate-300 hover:text-white flex items-center justify-center transition-all cursor-pointer shadow-sm" href="#" title="Nous écrire" aria-label="Nous écrire">
                        <span class="material-symbols-outlined text-[19px]">mail</span>
                    </a>
                </div>
            </div>

            <!-- Colonne 2 : À propos -->
            <div>
                <h4 class="text-xs font-bold text-white uppercase tracking-wider mb-4">À propos</h4>
                <ul class="space-y-3">
                    <li><a class="text-xs sm:text-sm text-slate-400 hover:text-white transition-colors" href="#">Qui sommes-nous ?</a></li>
                    <li><a class="text-xs sm:text-sm text-slate-400 hover:text-white transition-colors" href="#">Carrières &amp; Recrutement</a></li>
                    <li><a class="text-xs sm:text-sm text-slate-400 hover:text-white transition-colors" href="#">Espace Presse</a></li>
                    <li><a class="text-xs sm:text-sm text-slate-400 hover:text-white transition-colors" href="#">Engagements RSE &amp; Éthique</a></li>
                </ul>
            </div>

            <!-- Colonne 3 : Sécurité & Conseils -->
            <div>
                <h4 class="text-xs font-bold text-white uppercase tracking-wider mb-4">Sécurité &amp; Conseils</h4>
                <ul class="space-y-3">
                    <li><a class="text-xs sm:text-sm text-slate-400 hover:text-white transition-colors" href="#">Conseils d'achat sécurisé</a></li>
                    <li><a class="text-xs sm:text-sm text-slate-400 hover:text-white transition-colors" href="#">Éviter les arnaques</a></li>
                    <li><a class="text-xs sm:text-sm text-slate-400 hover:text-white transition-colors" href="#">Garantie de paiement</a></li>
                    <li><a class="text-xs sm:text-sm text-slate-400 hover:text-white transition-colors" href="#">Centre d'aide &amp; FAQ</a></li>
                </ul>
            </div>

            <!-- Colonne 4 : Catégories Populaires -->
            <div>
                <h4 class="text-xs font-bold text-white uppercase tracking-wider mb-4">Catégories Populaires</h4>
                <ul class="space-y-3">
                    <li><a class="text-xs sm:text-sm text-slate-400 hover:text-white transition-colors" href="#listing-feed" onclick="filterCategory('vehicules', document.querySelectorAll('.tab-btn')[1])">Véhicules d'occasion</a></li>
                    <li><a class="text-xs sm:text-sm text-slate-400 hover:text-white transition-colors" href="#listing-feed" onclick="filterCategory('immo', document.querySelectorAll('.tab-btn')[2])">Immobilier &amp; Terrains</a></li>
                    <li><a class="text-xs sm:text-sm text-slate-400 hover:text-white transition-colors" href="#listing-feed" onclick="filterCategory('tech', document.querySelectorAll('.tab-btn')[3])">Smartphones &amp; Tech</a></li>
                    <li><a class="text-xs sm:text-sm text-slate-400 hover:text-white transition-colors" href="#listing-feed" onclick="filterCategory('maison', document.querySelectorAll('.tab-btn')[4])">Mode &amp; Équipement Maison</a></li>
                    <li><a class="text-xs sm:text-sm text-slate-400 hover:text-white transition-colors" href="#listing-feed">Offres d'emploi &amp; Services</a></li>
                </ul>
            </div>

            <!-- Colonne 5 : Contact & Protection Acheteur -->
            <div>
                <h4 class="text-xs font-bold text-white uppercase tracking-wider mb-4">Assistance &amp; Confiance</h4>
                <ul class="space-y-3 mb-6">
                    <li><a class="text-xs sm:text-sm text-slate-400 hover:text-white transition-colors" href="#">Support client 7j/7</a></li>
                    <li><a class="text-xs sm:text-sm text-slate-400 hover:text-white transition-colors" href="#">Signaler un abus</a></li>
                    <li><a class="text-xs sm:text-sm text-slate-400 hover:text-white transition-colors" href="#">Nous contacter</a></li>
                </ul>

                <!-- Badge Protection Acheteur -->
                <div class="p-4 bg-slate-800/80 rounded-2xl border border-slate-700">
                    <span class="text-xs font-bold text-secondary-fixed flex items-center gap-1.5">
                        <span class="material-symbols-outlined text-[18px]">verified_user</span> Protection Acheteur
                    </span>
                    <p class="text-[11px] text-slate-400 mt-1 leading-normal">
                        Transactions vérifiées et fonds sécurisés jusqu'à confirmation de la remise en main propre.
                    </p>
                </div>
            </div>
        </div>

        <!-- Sous-footer : Devises, Droits & Mentions Légales -->
        <div class="pt-8 border-t border-slate-800 flex flex-col md:flex-row items-center justify-between gap-4 text-xs text-slate-400">
            <!-- Sélecteur de pays/devise -->
            <div class="flex items-center gap-4">
                <div class="flex items-center gap-1.5 bg-slate-800 px-3 py-1.5 rounded-xl border border-slate-700">
                    <span class="material-symbols-outlined text-[16px] text-slate-400">language</span>
                    <select class="bg-transparent border-none outline-none text-xs text-slate-300 cursor-pointer" aria-label="Devise et région">
                        <option class="bg-slate-900 text-white" value="tg">Togo (XOF - FCFA)</option>
                        <option class="bg-slate-900 text-white" value="fr">France (EUR - €)</option>
                        <option class="bg-slate-900 text-white" value="bj">Bénin (XOF - FCFA)</option>
                        <option class="bg-slate-900 text-white" value="ci">Côte d'Ivoire (XOF - FCFA)</option>
                    </select>
                </div>
                <p>© 2026 Epsilon Marketplace. Tous droits réservés.</p>
            </div>

            <!-- Liens légaux -->
            <div class="flex flex-wrap items-center gap-5">
                <a class="hover:text-white transition-colors" href="#">CGU</a>
                <a class="hover:text-white transition-colors" href="#">Confidentialité</a>
                <a class="hover:text-white transition-colors" href="#">Cookies</a>
                <a class="hover:text-white transition-colors" href="#">Mentions légales</a>
            </div>
        </div>
    </div>
</footer>