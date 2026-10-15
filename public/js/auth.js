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

    // Recalcul de la hauteur
    setTimeout(updateViewportHeight, 50);
}

// Afficher / Masquer le mot de passe
function togglePassword(inputId, btn) {
    const input = document.getElementById(inputId);
    if (!input) return;
    if (input.type === 'password') {
        input.type = 'text';
        btn.textContent = '🙈';
    } else {
        input.type = 'password';
        btn.textContent = '👁';
    }
}

// Jauge de force du mot de passe
function checkPasswordStrength(password) {
    const fill = document.getElementById('strength-fill');
    const label = document.getElementById('strength-label');
    if (!fill || !label) return;

    let score = 0;
    if (password.length >= 8) score++;
    if (/[A-Z]/.test(password)) score++;
    if (/[0-9]/.test(password)) score++;
    if (/[^A-Za-z0-9]/.test(password)) score++;

    if (password.length === 0) {
        fill.style.width = '0%';
        label.textContent = 'Entrez au moins 8 caractères';
        label.style.color = 'var(--slate)';
    } else if (score <= 1) {
        fill.style.width = '25%';
        fill.style.backgroundColor = '#EF4444';
        label.textContent = 'Mot de passe faible (ajoutez chiffres et majuscules)';
        label.style.color = '#EF4444';
    } else if (score === 2) {
        fill.style.width = '50%';
        fill.style.backgroundColor = '#F59E0B';
        label.textContent = 'Mot de passe moyen';
        label.style.color = '#F59E0B';
    } else if (score === 3) {
        fill.style.width = '75%';
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

// Système de notification Toast
function showToast(type, title, message) {
    const container = document.getElementById('toast-container');
    if (!container) return;

    const toast = document.createElement('div');
    toast.className = `toast ${type}`;
    toast.innerHTML = `
        <div class="toast-icon">${type === 'success' ? '✓' : (type === 'error' ? '✕' : 'ℹ')}</div>
        <div class="toast-content">
            <div class="toast-title">${title}</div>
            <div class="toast-desc">${message}</div>
        </div>
        <button class="toast-close" onclick="this.parentElement.remove()">×</button>
    `;
    container.appendChild(toast);

    setTimeout(() => {
        toast.style.animation = 'toastOut 0.4s ease forwards';
        setTimeout(() => toast.remove(), 400);
    }, 4500);
}

// Initialisation au chargement de la page
window.addEventListener('DOMContentLoaded', () => {
    updateViewportHeight();
    window.addEventListener('resize', updateViewportHeight);

    // Notifications automatiques selon les paramètres d'URL (erreurs Laravel)
    const urlParams = new URLSearchParams(window.location.search);
    if (urlParams.get('registered') === '1') {
        showToast('success', 'Bienvenue !', 'Votre compte Epsilon a été créé avec succès.');
    } else if (urlParams.get('error') === 'auth') {
        showToast('error', 'Erreur d\'accès', 'Identifiants incorrects. Veuillez réessayer.');
    }
});