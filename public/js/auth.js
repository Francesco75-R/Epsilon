let currentTab = 'login';

// Ajustement dynamique de la hauteur du conteneur selon le formulaire actif
function updateViewportHeight() {
    const viewport = document.getElementById('slider-viewport');
    const activePanel = (currentTab === 'login')
        ? document.getElementById('panel-login')
        : document.getElementById('panel-signup');

    if (viewport && activePanel) {
        viewport.style.height = activePanel.scrollHeight + 'px';
    }
}

// Animation de défilement horizontal entre Connexion et Inscription
function slideTo(target) {
    if (currentTab === target && target !== 'initial') return;
    currentTab = target;

    const track = document.getElementById('slider-track');
    const panelLogin = document.getElementById('panel-login');
    const panelSignup = document.getElementById('panel-signup');
    const tabLogin = document.getElementById('tab-login');
    const tabSignup = document.getElementById('tab-signup');
    const pill = document.getElementById('tab-slider-pill');
    const heading = document.getElementById('form-heading');
    const subheading = document.getElementById('form-subheading');

    if (target === 'signup') {
        // Défilement vers la gauche (Inscription)
        if (track) track.style.transform = 'translateX(-50%)';
        if (panelLogin) panelLogin.classList.add('inactive');
        if (panelSignup) panelSignup.classList.remove('inactive');

        if (tabLogin) tabLogin.classList.remove('on');
        if (tabSignup) tabSignup.classList.add('on');
        if (pill) pill.style.transform = 'translateX(100%)';

        if (heading && subheading) {
            heading.style.opacity = '0';
            subheading.style.opacity = '0';
            setTimeout(() => {
                heading.textContent = "Créer un compte Epsilon";
                subheading.textContent = "Rejoignez la communauté et publiez vos annonces gratuitement";
                heading.style.opacity = '1';
                subheading.style.opacity = '1';
            }, 150);
        }
    } else {
        // Défilement vers la droite (Connexion)
        if (track) track.style.transform = 'translateX(0%)';
        if (panelSignup) panelSignup.classList.add('inactive');
        if (panelLogin) panelLogin.classList.remove('inactive');

        if (tabSignup) tabSignup.classList.remove('on');
        if (tabLogin) tabLogin.classList.add('on');
        if (pill) pill.style.transform = 'translateX(0%)';

        if (heading && subheading) {
            heading.style.opacity = '0';
            subheading.style.opacity = '0';
            setTimeout(() => {
                heading.textContent = "Bienvenue sur Epsilon";
                subheading.textContent = "Accédez à votre espace membre pour gérer vos annonces";
                heading.style.opacity = '1';
                subheading.style.opacity = '1';
            }, 150);
        }
    }

    // Recalcul de la hauteur après transition
    setTimeout(updateViewportHeight, 50);
    setTimeout(updateViewportHeight, 300);
}

// Afficher / Masquer le mot de passe
function togglePassword(inputId, btn, event) {
    if (event) {
        event.preventDefault();
        event.stopPropagation();
    } else if (window.event) {
        window.event.preventDefault();
        window.event.stopPropagation();
    }

    const input = document.getElementById(inputId);
    if (!input) return;

    if (input.type === 'password') {
        input.type = 'text';
        btn.textContent = '🙈';
        btn.setAttribute('aria-label', 'Masquer le mot de passe');
        btn.setAttribute('title', 'Masquer le mot de passe');
    } else {
        input.type = 'password';
        btn.textContent = '👁';
        btn.setAttribute('aria-label', 'Afficher le mot de passe');
        btn.setAttribute('title', 'Afficher le mot de passe');
    }

    // Maintient le focus sur l'input pour la fluidité utilisateur
    input.focus();
}

// Jauge de force du mot de passe
function checkPasswordStrength(password) {
    const fill = document.getElementById('strength-fill');
    const label = document.getElementById('strength-label');
    if (!fill || !label) return;

    if (!password || password.length === 0) {
        fill.style.width = '0%';
        fill.style.backgroundColor = '#E2E8F0';
        label.textContent = 'Entrez au moins 8 caractères';
        label.style.color = 'var(--slate)';
        return;
    }

    let score = 0;
    if (password.length >= 8) score++;
    if (/[a-z]/.test(password) && /[A-Z]/.test(password)) score++;
    if (/[0-9]/.test(password)) score++;
    if (/[^A-Za-z0-9]/.test(password)) score++;

    if (password.length < 8) {
        fill.style.width = '20%';
        fill.style.backgroundColor = '#EF4444';
        label.textContent = 'Trop court (minimum 8 caractères requis)';
        label.style.color = '#EF4444';
    } else if (score <= 1) {
        fill.style.width = '35%';
        fill.style.backgroundColor = '#EF4444';
        label.textContent = 'Faible (ajoutez majuscules et chiffres)';
        label.style.color = '#EF4444';
    } else if (score === 2) {
        fill.style.width = '60%';
        fill.style.backgroundColor = '#F59E0B';
        label.textContent = 'Moyen (ajoutez des symboles spéciaux)';
        label.style.color = '#F59E0B';
    } else if (score === 3) {
        fill.style.width = '85%';
        fill.style.backgroundColor = '#10B981';
        label.textContent = 'Bon mot de passe';
        label.style.color = '#10B981';
    } else {
        fill.style.width = '100%';
        fill.style.backgroundColor = '#059669';
        label.textContent = 'Mot de passe ultra sécurisé ✨';
        label.style.color = '#059669';
    }
}

// Vérification dynamique de la correspondance des deux mots de passe en temps réel
function checkPasswordMatch() {
    const passwordInput = document.getElementById("signup-password");
    const confirmInput = document.getElementById("signup-confirm");
    const badge = document.getElementById("pw-match-badge");

    if (!passwordInput || !confirmInput) return true;

    const pw = passwordInput.value;
    const cpw = confirmInput.value;

    if (!cpw) {
        if (badge) {
            badge.textContent = '';
            badge.className = 'pw-match-badge';
        }
        confirmInput.classList.remove('input-valid', 'input-invalid');
        return true;
    }

    if (pw === cpw) {
        confirmInput.classList.remove('input-invalid');
        confirmInput.classList.add('input-valid');
        if (badge) {
            badge.textContent = '✓ Mots de passe identiques';
            badge.className = 'pw-match-badge match-ok';
        }
        return true;
    } else {
        confirmInput.classList.remove('input-valid');
        confirmInput.classList.add('input-invalid');
        if (badge) {
            badge.textContent = '✕ Ne correspond pas';
            badge.className = 'pw-match-badge match-ko';
        }
        return false;
    }
}

// Vérification stricte lors de la soumission du formulaire d'inscription
function verifpassword(event) {
    const passwordInput = document.getElementById("signup-password");
    const confirmInput = document.getElementById("signup-confirm");

    if (!passwordInput || !confirmInput) return true;

    const password = passwordInput.value;
    const confirm = confirmInput.value;

    // 1. Vérification de la longueur minimale
    if (password.length < 8) {
        if (event && event.preventDefault) event.preventDefault();
        showToast('error', 'Mot de passe trop court', 'Le mot de passe doit comporter au moins 8 caractères.');
        passwordInput.focus();
        return false;
    }

    // 2. Vérification de l'égalité
    if (password !== confirm) {
        if (event && event.preventDefault) event.preventDefault();
        showToast('error', 'Erreur de mot de passe', 'Les deux mots de passe ne sont pas identiques.');
        confirmInput.classList.add('input-invalid');
        confirmInput.focus();
        return false;
    }

    return true;
}

// Système de notification Toast moderne avec animations et barre de progression
function showToast(type, title, message) {
    const container = document.getElementById('toast-container');
    if (!container) return;

    const toast = document.createElement('div');
    toast.className = `toast ${type}`;

    let iconSymbol = 'ℹ';
    if (type === 'success') iconSymbol = '✓';
    else if (type === 'error') iconSymbol = '✕';
    else if (type === 'info') iconSymbol = 'ℹ';

    toast.innerHTML = `
        <div class="toast-icon">${iconSymbol}</div>
        <div class="toast-content">
            <div class="toast-title">${title}</div>
            <div class="toast-desc">${message}</div>
        </div>
        <button type="button" class="toast-close" aria-label="Fermer la notification">×</button>
        <div class="toast-progress"><div class="toast-progress-bar"></div></div>
    `;

    // Gestion de la fermeture manuelle au clic
    const closeBtn = toast.querySelector('.toast-close');
    if (closeBtn) {
        closeBtn.onclick = () => {
            toast.style.animation = 'toastOut 0.35s cubic-bezier(0.16, 1, 0.3, 1) forwards';
            setTimeout(() => toast.remove(), 350);
        };
    }

    container.appendChild(toast);

    // Disparition automatique fluide après 5 secondes
    setTimeout(() => {
        if (toast.parentElement) {
            toast.style.animation = 'toastOut 0.4s cubic-bezier(0.16, 1, 0.3, 1) forwards';
            setTimeout(() => {
                if (toast.parentElement) toast.remove();
            }, 400);
        }
    }, 5000);
}

// Initialisation au chargement du DOM
window.addEventListener('DOMContentLoaded', () => {
    updateViewportHeight();
    window.addEventListener('resize', updateViewportHeight);

    // 1. Écouteurs pour la vérification instantanée des mots de passe
    const signupPw = document.getElementById('signup-password');
    const signupConfirm = document.getElementById('signup-confirm');

    if (signupPw) {
        signupPw.addEventListener('input', () => {
            checkPasswordStrength(signupPw.value);
            checkPasswordMatch();
        });
    }

    if (signupConfirm) {
        signupConfirm.addEventListener('input', checkPasswordMatch);
    }

    // 2. Traitement des messages Flash transmis par Laravel
    const successElement = document.getElementById('flash-success-message');
    const errorElement = document.getElementById('flash-error-message');
    const infoElement = document.getElementById('flash-info-message');
    const validationErrorsElement = document.getElementById('flash-validation-errors');
    const activeTabElement = document.getElementById('flash-active-tab');

    // Bascule d'onglet si spécifiée
    let targetTab = null;
    if (activeTabElement && activeTabElement.dataset.tab) {
        targetTab = activeTabElement.dataset.tab;
    }

    if (successElement && successElement.dataset.message) {
        showToast('success', 'Succès !', successElement.dataset.message);
    }

    if (errorElement && errorElement.dataset.message) {
        showToast('error', 'Attention', errorElement.dataset.message);
    }

    if (infoElement && infoElement.dataset.message) {
        showToast('info', 'Information', infoElement.dataset.message);
    }

    if (validationErrorsElement && validationErrorsElement.dataset.errors) {
        try {
            const errors = JSON.parse(validationErrorsElement.dataset.errors);
            if (Array.isArray(errors) && errors.length > 0) {
                // Affiche chaque erreur avec un léger décalage visuel
                errors.forEach((err, idx) => {
                    setTimeout(() => {
                        showToast('error', 'Erreur de validation', err);
                    }, idx * 250);
                });
            }
            if (validationErrorsElement.dataset.tab) {
                targetTab = validationErrorsElement.dataset.tab;
            }
        } catch (e) {
            console.error('Erreur lecture validation errors:', e);
        }
    }

    // Fallback: Paramètres d'URL (ex: ?success=1 ou ?tab=signup)
    const urlParams = new URLSearchParams(window.location.search);
    if (urlParams.get('success')) {
        showToast('success', 'Bienvenue !', 'Votre compte Epsilon a été créé avec succès.');
        targetTab = 'login';
    } else if (urlParams.get('error')) {
        showToast('error', 'Erreur d\'accès', 'Identifiants incorrects. Veuillez réessayer.');
    }
    if (urlParams.get('tab') === 'signup') {
        targetTab = 'signup';
    }

    // Appliquer le basculement d'onglet vers signup ou login
    if (targetTab === 'signup') {
        slideTo('signup');
    } else {
        slideTo('login');
    }
});