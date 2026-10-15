@extends('layouts.auth')

@section('title', 'Epsilon Togo | Connexion & Inscription')

@section('content')
<div id="page-login" class="page">

    <div class="ambient-orb orb-1"></div>
    <div class="ambient-orb orb-2"></div>

    <!-- Bouton Retour au site -->
    <a href="{{ url('/') }}" class="login-back">
        <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5">
            <line x1="19" y1="12" x2="5" y2="12" />
            <polyline points="12 19 5 12 12 5" />
        </svg>
        Retour aux annonces
    </a>

    <div class="login-wrap">

        <!-- ─── CÔTÉ GAUCHE : PRÉSENTATION TRUST EPSILON TOGO ─── -->
        <div class="login-side">
            <div>
                <div class="login-side-logo">
                    <a href="{{ url('/') }}" style="text-decoration:none; display:flex; align-items:center;">
                        <div class="logo-icon">
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
                        </div>
                        <span class="logo-name">Epsilon<small class="uemoa-badge">Marketplace</small></span>
                    </a>
                </div>

                <div class="trust-chip">
                    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5">
                        <path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z" />
                    </svg>
                    Epsilon Trust Engine
                </div>

                <h2>La plateforme n°1 d'annonces <em>vérifiées</em> au Togo</h2>
                <p class="hero-desc">Rejoignez plus de 150 000 particuliers et professionnels qui achètent et vendent en toute sérénité chaque jour.</p>

                <!-- 5 Piliers de confiance avec icônes SVG adaptées -->
                <div class="trust-items">
                    <div class="trust-item">
                        <div class="trust-icon">
                            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <path d="M4.5 16.5c-1.5 1.26-2 5-2 5s3.74-.5 5-2c.71-.84.7-2.13-.09-2.91a2.18 2.18 0 0 0-2.91-.09z" />
                                <path d="m12 15-3-3a22 22 0 0 1 2-3.95A12.88 12.88 0 0 1 22 2c0 2.72-.78 7.5-3.05 11a22.35 22.35 0 0 1-3.95 2z" />
                            </svg>
                        </div>
                        <div class="trust-text">
                            <h4>Publication instantanée</h4>
                            <p>Déposez et modifiez vos annonces en 2 clics avec photos haute résolution.</p>
                        </div>
                    </div>

                    <div class="trust-item">
                        <div class="trust-icon">
                            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z" />
                            </svg>
                        </div>
                        <div class="trust-text">
                            <h4>Messagerie chiffrée intégrée</h4>
                            <p>Négociez et concluez en direct sans exposer votre numéro personnel.</p>
                        </div>
                    </div>

                    <div class="trust-item">
                        <div class="trust-icon">
                            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <path d="M20.84 4.61a5.5 5.5 0 0 0-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 0 0-7.78 7.78l1.06 1.06L12 21.23l7.78-7.78 1.06-1.06a5.5 5.5 0 0 0 0-7.78z" />
                            </svg>
                        </div>
                        <div class="trust-text">
                            <h4>Alertes &amp; Favoris synchronisés</h4>
                            <p>Recevez les baisses de prix et opportunités à Lomé, Kara et région.</p>
                        </div>
                    </div>

                    <div class="trust-item">
                        <div class="trust-icon">
                            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <path d="M22 11.08V12a10 10 0 1 1-5.93-9.14" />
                                <polyline points="22 4 12 14.01 9 11.01" />
                            </svg>
                        </div>
                        <div class="trust-text">
                            <h4>Profil Vendeur Vérifié</h4>
                            <p>Obtenez un badge certifié pour accélérer vos ventes jusqu'à 3x plus vite.</p>
                        </div>
                    </div>

                    <div class="trust-item">
                        <div class="trust-icon">
                            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z" />
                            </svg>
                        </div>
                        <div class="trust-text">
                            <h4>Protection &amp; Modération 24/7</h4>
                            <p>Contrôle anti-fraude rigoureux et équipe support basée à Lomé.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- ─── CÔTÉ DROIT : FORMULAIRES UTILISATEUR ─── -->
        <div class="login-form-side">

            <div class="form-header">
                <h3 id="form-heading">Bienvenue sur Epsilon</h3>
                <p class="sub" id="form-subheading">Accédez à votre espace membre pour gérer vos annonces</p>
            </div>

            <div class="tabs-container">
                <div class="tabs">
                    <button class="tab on" id="tab-login" type="button" onclick="slideTo('login')">Connexion</button>
                    <button class="tab" id="tab-signup" type="button" onclick="slideTo('signup')">Créer un compte</button>
                    <div class="tab-slider-pill" id="tab-slider-pill"></div>
                </div>
            </div>

            <div class="forms-slider-viewport" id="slider-viewport">
                <div class="forms-slider-track" id="slider-track">

                    <!-- FORMULAIRE 1 : CONNEXION UTILISATEUR -->
                    <div class="form-panel panel-login" id="panel-login">
                        <form id="form-login" action="{{ route('login') }}" method="POST">
                            @csrf

                            <div class="form-group">
                                <label class="form-label">Email ou Numéro de téléphone</label>
                                <div class="input-wrapper">
                                    <span class="input-icon">✉</span>
                                    <input class="form-input with-icon" name="login" type="text" placeholder="ex: +228 90000000 ou email" required>
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="form-label">Mot de passe</label>
                                <div class="input-wrapper">
                                    <span class="input-icon">🔒</span>
                                    <input class="form-input with-icon" id="login-password" name="password" type="password" placeholder="••••••••" required>
                                </div>
                            </div>

                            <div class="form-options">
                                <label style="display:flex; align-items:center; gap:6px; cursor:pointer;">
                                    <input type="checkbox" name="remember"> Rester connecté
                                </label>
                                <div class="form-forgot">
                                    <a href="#">Mot de passe oublié ?</a>
                                </div>
                            </div>

                            <button type="submit" class="form-submit">
                                <span>Se connecter</span>
                                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5">
                                    <line x1="5" y1="12" x2="19" y2="12" />
                                    <polyline points="12 5 19 12 12 19" />
                                </svg>
                            </button>

                            <div class="form-bottom">
                                Nouveau sur Epsilon ?
                                <a href="#" class="link-switch" onclick="slideTo('signup'); return false;">S'inscrire gratuitement</a>
                            </div>
                        </form>
                    </div>

                    <!-- FORMULAIRE 2 : INSCRIPTION MEMBRE / PRO -->
                    <div class="form-panel panel-signup inactive" id="panel-signup">
                        <form id="form-signup" action="" method="POST">
                            @csrf

                            <div class="form-row">
                                <div class="form-group">
                                    <label class="form-label">Prénom</label>
                                    <input class="form-input" name="firstname" type="text" placeholder="Kodjo" required>
                                </div>
                                <div class="form-group">
                                    <label class="form-label">Nom</label>
                                    <input class="form-input" name="lastname" type="text" placeholder="Mensah" required>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="form-label">Email</label>
                                <input type="email" class="form-input" name="email" id="email">
                            </div>
                            <div class="form-group">
                                <label class="form-label">Numéro de Téléphone</label>
                                <div class="input-wrapper">
                                    <span class="input-icon">📞</span>
                                    <input class="form-input with-icon" name="phone" type="tel" placeholder="+228 90 00 00 00" required>
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="form-label">Adresse</label>
                                <input class="form-input" type="text" name="adresse" id="adresse" require>
                            </div>
                            <div class="form-group">
                                <label class="form-label">Genre</label>
                                <select class="form-input" name="ville" required style="cursor:pointer;">
                                    <option value="">choisir un genre</option>
                                    <option value="Homme">Homme</option>
                                    <option value="Femme">Femme</option>
                                </select>
                            </div>

                            <div class="form-group">
                                <label class="form-label">photo de profil</label>
                                <input class="form-input" type="file" name="photo" id="photo" accept="image/*" required>
                            </div>

                            <div class="form-row">
                                <div class="form-group">
                                    <label class="form-label">Mot de passe</label>
                                    <input class="form-input" name="password" type="password" placeholder="8+ car." required minlength="8">
                                </div>
                                <div class="form-group">
                                    <label class="form-label">Confirmer</label>
                                    <input class="form-input" name="password_confirmation" type="password" placeholder="Répéter" required minlength="8">
                                </div>
                            </div>

                            <button type="submit" class="form-submit">
                                <span>Créer mon compte Epsilon</span>
                            </button>

                            <div class="form-bottom">
                                Déjà membre ?
                                <a href="#" class="link-switch" onclick="slideTo('login'); return false;">Se connecter</a>
                            </div>
                        </form>
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>
@endsection