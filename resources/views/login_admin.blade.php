@extends('layouts.auth')

@section('title', 'Epsilon Togo | Portail Administrateur')

@section('content')
<div id="page-login" class="page">

    <div class="ambient-orb orb-1"></div>
    <div class="ambient-orb orb-2"></div>

    <!-- Bouton Retour au site -->
    <a href="{{ route('home') }}" class="login-back">
        <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5">
            <line x1="19" y1="12" x2="5" y2="12" />
            <polyline points="12 19 5 12 12 5" />
        </svg>
        Retour au Marketplace
    </a>

    <div class="login-wrap">

        <!-- ─── CÔTÉ GAUCHE : PRÉSENTATION ESPACE ADMINISTRATION ─── -->
        <div class="login-side">
            <div>
                <div class="login-side-logo">
                    <a href="{{ route('home') }}" style="text-decoration:none; display:flex; align-items:center;">
                        <div class="logo-icon">
                            <svg class="h-8 w-auto object-contain" viewBox="0 0 100 100" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <rect width="100" height="100" rx="24" fill="#0A1128" />
                                <path d="M30 35H66C66 35 66 35 66 35C66 37.7614 63.7614 40 61 40H44V49H57C59.7614 49 62 51.2386 62 54C62 56.7614 59.7614 59 57 59H44V68H66C68.7614 68 71 70.2386 71 73C71 75.7614 68.7614 78 66 78H35C31.134 78 28 74.866 28 71V40C28 37.2386 30 35 30 35Z" fill="#FFFFFF" />
                                <circle cx="70" cy="35" r="11" fill="#10B981" />
                                <g transform="translate(52, 47)">
                                    <path d="M0 7H15" stroke="#10B981" stroke-width="5" stroke-linecap="round" />
                                    <path d="M10 2L15 7L10 12" stroke="#10B981" stroke-width="5" stroke-linecap="round" stroke-linejoin="round" />
                                </g>
                            </svg>
                        </div>
                        <span class="logo-name">Epsilon<small class="uemoa-badge">Administration</small></span>
                    </a>
                </div>

                <div class="trust-chip">
                    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5">
                        <path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z" />
                    </svg>
                    Epsilon Security Core
                </div>

                <h2>Portail d'Administration <em>Sécurisé</em> Epsilon</h2>
                <p class="hero-desc">Console centrale réservée aux administrateurs pour la supervision des annonces, le contrôle anti-fraude et la vérification des comptes vendeurs.</p>

                <!-- 5 Piliers Administration -->
                <div class="trust-items">
                    <div class="trust-item">
                        <div class="trust-icon">
                            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z" />
                            </svg>
                        </div>
                        <div class="trust-text">
                            <h4>Validation des Vendeurs</h4>
                            <p>Contrôle des pièces d'identité et mutation automatique des comptes clients en vendeurs.</p>
                        </div>
                    </div>

                    <div class="trust-item">
                        <div class="trust-icon">
                            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <circle cx="12" cy="12" r="10" />
                                <path d="m9 12 2 2 4-4" />
                            </svg>
                        </div>
                        <div class="trust-text">
                            <h4>Modération des Annonces</h4>
                            <p>Surveillance de la conformité des offres publiées sur l'ensemble du territoire togolais.</p>
                        </div>
                    </div>

                    <div class="trust-item">
                        <div class="trust-icon">
                            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <rect width="18" height="11" x="3" y="11" rx="2" ry="2" />
                                <path d="M7 11V7a5 5 0 0 1 10 0v4" />
                            </svg>
                        </div>
                        <div class="trust-text">
                            <h4>Authentification Chiffrée</h4>
                            <p>Sessions d'administration isolées et protégées contre les accès non autorisés.</p>
                        </div>
                    </div>

                    <div class="trust-item">
                        <div class="trust-icon">
                            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <path d="M22 12h-4l-3 9L9 3l-3 9H2" />
                            </svg>
                        </div>
                        <div class="trust-text">
                            <h4>Supervision en Temps Réel</h4>
                            <p>Suivi de l'activité, des transactions et de la santé du catalogue marketplace.</p>
                        </div>
                    </div>

                    <div class="trust-item">
                        <div class="trust-icon">
                            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2" />
                                <circle cx="9" cy="7" r="4" />
                                <path d="M22 21v-2a4 4 0 0 0-3-3.87" />
                                <path d="M16 3.13a4 4 0 0 1 0 7.75" />
                            </svg>
                        </div>
                        <div class="trust-text">
                            <h4>Équipe Opérationnelle</h4>
                            <p>Gestion collaborative des droits et accès pour l'équipe support Epsilon.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- ─── CÔTÉ DROIT : FORMULAIRES ADMINISTRATEUR ─── -->
        <div class="login-form-side">

            <!-- Données Flash de Laravel pour Javascript & Toasts -->
            @if(session('success'))
            <div id="flash-success-message" data-message="{{ session('success') }}" style="display:none;"></div>
            @endif
            @if(session('error'))
            <div id="flash-error-message" data-message="{{ session('error') }}" style="display:none;"></div>
            @endif
            @if(session('info'))
            <div id="flash-info-message" data-message="{{ session('info') }}" style="display:none;"></div>
            @endif
            @if(isset($errors) && $errors->any())
            <div id="flash-validation-errors" data-errors="{{ e(json_encode($errors->all())) }}" data-tab="{{ session('active_tab', ($errors->has('nom') || $errors->has('prenom') || $errors->has('email') && old('nom') || $errors->has('password_confirmation') ? 'signup' : 'login')) }}" style="display:none;"></div>
            @endif
            @if(session('active_tab'))
            <div id="flash-active-tab" data-tab="{{ session('active_tab') }}" style="display:none;"></div>
            @endif

            <div class="form-header">
                <h3 id="form-heading">Portail Administrateur</h3>
                <p class="sub" id="form-subheading">Accédez à votre console de gestion et validation Epsilon</p>
            </div>

            <div class="tabs-container">
                <div class="tabs">
                    <button class="tab on" id="tab-login" type="button" onclick="slideTo('login')">Connexion Admin</button>
                    <button class="tab" id="tab-signup" type="button" onclick="slideTo('signup')">Nouvel Admin</button>
                    <div class="tab-slider-pill" id="tab-slider-pill"></div>
                </div>
            </div>

            <div class="forms-slider-viewport" id="slider-viewport">
                <div class="forms-slider-track" id="slider-track">

                    <!-- FORMULAIRE 1 : CONNEXION ADMINISTRATEUR -->
                    <div class="form-panel panel-login" id="panel-login">
                        <form id="form-login" action="{{ route('admin.login.post') }}" method="POST">
                            @csrf

                            <div class="form-group">
                                <label class="form-label" for="login-identifier">Email Administrateur</label>
                                <div class="input-wrapper">
                                    <span class="input-icon">✉</span>
                                    <input class="form-input with-icon" id="login-identifier" name="login" type="email" placeholder="admin@domaine.com" value="{{ old('login') }}" required autofocus>
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="form-label" for="login-password">Mot de passe</label>
                                <div class="input-wrapper">
                                    <span class="input-icon">🔒</span>
                                    <input class="form-input with-icon has-toggle" id="login-password" name="password" type="password" placeholder="••••••••" required autocomplete="current-password">
                                    <button type="button" class="btn-toggle-pw" onclick="togglePassword('login-password', this, event)" title="Afficher ou masquer le mot de passe" tabindex="-1">👁</button>
                                </div>
                            </div>

                            <div class="form-options">
                                <div class="form-forgot">
                                    <a href="{{ route('admin.password.request') }}" class="text-xs text-emerald-600 hover:underline">Mot de passe oublié ?</a>
                                </div>
                            </div>

                            <button type="submit" class="form-submit">
                                <span>Se connecter à l'administration</span>
                                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5">
                                    <line x1="5" y1="12" x2="19" y2="12" />
                                    <polyline points="12 5 19 12 12 19" />
                                </svg>
                            </button>

                            <div class="form-bottom">
                                Nouvel Administrateur ?
                                <a href="#" class="link-switch" onclick="slideTo('signup'); return false;">Créer un compte admin</a>
                            </div>
                        </form>
                    </div>

                    <!-- FORMULAIRE 2 : INSCRIPTION ADMINISTRATEUR -->
                    <div class="form-panel panel-signup inactive" id="panel-signup">
                        <form id="form-signup" action="{{ route('admin.register.post') }}" method="POST" onsubmit="return verifpassword(event)">
                            @csrf

                            <div class="form-row">
                                <div class="form-group">
                                    <label class="form-label" for="signup-prenom">Prénom</label>
                                    <input class="form-input" id="signup-prenom" name="prenom" type="text" placeholder="Prénom admin" value="{{ old('prenom') }}" required>
                                </div>
                                <div class="form-group">
                                    <label class="form-label" for="signup-nom">Nom</label>
                                    <input class="form-input" id="signup-nom" name="nom" type="text" placeholder="Nom admin" value="{{ old('nom') }}" required>
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="form-label" for="signup-email">Email professionnel</label>
                                <div class="input-wrapper">
                                    <span class="input-icon">✉</span>
                                    <input type="email" class="form-input with-icon" name="email" id="signup-email" placeholder="admin@domaine.com" value="{{ old('email') }}" required>
                                </div>
                            </div>

                            <div class="form-row">
                                <div class="form-group">
                                    <label class="form-label" for="signup-password">Mot de passe</label>
                                    <div class="input-wrapper">
                                        <input class="form-input has-toggle" id="signup-password" name="password" type="password" placeholder="8+ caractères" required minlength="8" oninput="checkPasswordStrength(this.value); checkPasswordMatch();">
                                        <button type="button" class="btn-toggle-pw" onclick="togglePassword('signup-password', this, event)" title="Afficher ou masquer" tabindex="-1">👁</button>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="form-label" for="signup-confirm">Confirmer</label>
                                    <div class="input-wrapper">
                                        <input class="form-input has-toggle" id="signup-confirm" name="password_confirmation" type="password" placeholder="Répéter" required minlength="8" oninput="checkPasswordMatch();">
                                        <button type="button" class="btn-toggle-pw" onclick="togglePassword('signup-confirm', this, event)" title="Afficher ou masquer" tabindex="-1">👁</button>
                                    </div>
                                </div>
                            </div>

                            <!-- Jauge de sécurité du mot de passe -->
                            <div class="strength-container" style="margin-top:-6px; margin-bottom:12px;">
                                <div class="strength-bar">
                                    <div id="strength-fill" class="strength-fill"></div>
                                </div>
                                <div class="strength-meta">
                                    <span id="strength-label" class="strength-label">Entrez au moins 8 caractères</span>
                                    <span id="pw-match-badge" class="pw-match-badge"></span>
                                </div>
                            </div>

                            <button type="submit" class="form-submit">
                                <span>Créer le compte Administrateur</span>
                            </button>

                            <div class="form-bottom">
                                Vous possédez déjà un compte admin ?
                                <a href="#" class="link-switch" onclick="slideTo('login'); return false;">Se connecter</a>
                            </div>
                        </form>
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>

<script>
    // Surcharge des textes dynamiques du slider spécifiquement pour l'Administration
    window.addEventListener('DOMContentLoaded', () => {
        const originalSlideTo = window.slideTo;

        window.slideTo = function(target) {
            originalSlideTo(target);

            const heading = document.getElementById('form-heading');
            const subheading = document.getElementById('form-subheading');

            if (target === 'signup') {
                if (heading) heading.textContent = "Créer un compte Administrateur";
                if (subheading) subheading.textContent = "Enregistrement d'un nouvel administrateur Epsilon";
            } else {
                if (heading) heading.textContent = "Portail Administrateur";
                if (subheading) subheading.textContent = "Accédez à votre console de gestion et validation Epsilon";
            }
        };

        // Si la session demande l'onglet login (ex: après inscription admin réussie)
        const flashActiveTab = document.getElementById('flash-active-tab');
        if (flashActiveTab && flashActiveTab.dataset.tab === 'login') {
            window.slideTo('login');
        }
    });
</script>
@endsection