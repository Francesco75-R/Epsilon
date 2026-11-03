/**
 * Epsilon Marketplace - Client-side Interactions (Public Standalone)
 * Follows design.json and DESIGN.md specifications
 */

function setSearchTerm(term) {
    const heroInput = document.getElementById('hero-input');
    const headerInput = document.getElementById('header-search-input');
    
    if (heroInput) {
        heroInput.value = term;
        heroInput.focus();
    } else if (headerInput) {
        headerInput.value = term;
        headerInput.focus();
    }
}

function toggleFav(btn) {
    if (!btn) return;

    // Exigence 9 : Visiteurs Non Connectés (@guest)
    // Clic sur le bouton Like / Favoris (♡) : Interrompre l'action et rediriger vers la page de connexion avec une notification Toast.
    if (!window.isUserLoggedIn) {
        showToast("Veuillez vous connecter pour ajouter cette annonce à vos favoris.", "error");
        setTimeout(() => {
            window.location.href = window.loginUrl || '/login';
        }, 1200);
        return;
    }

    const icon = btn.querySelector('.material-symbols-outlined');
    const favCountBadge = document.getElementById('fav-count-badge');
    const isFav = btn.classList.contains('text-error') || btn.classList.contains('active');

    if (isFav) {
        btn.classList.remove('text-error', 'active');
        btn.classList.add('text-on-surface-variant');
        if (icon) icon.style.fontVariationSettings = "'FILL' 0";
        if (favCountBadge) {
            let count = parseInt(favCountBadge.textContent || '1', 10);
            favCountBadge.textContent = Math.max(0, count - 1);
        }
        showToast("Annonce retirée de vos favoris");
    } else {
        btn.classList.add('text-error', 'active');
        btn.classList.remove('text-on-surface-variant');
        if (icon) icon.style.fontVariationSettings = "'FILL' 1";
        if (favCountBadge) {
            let count = parseInt(favCountBadge.textContent || '0', 10);
            favCountBadge.textContent = count + 1;
        }
        showToast("Annonce ajoutée à vos favoris !");
    }
}

function filterCategory(category, button) {
    const buttons = document.querySelectorAll('.tab-btn');
    buttons.forEach(b => {
        b.className = 'tab-btn px-4 py-2 rounded-lg font-label-lg text-label-lg bg-surface-container-lowest text-on-surface hover:bg-surface-container transition-all cursor-pointer whitespace-nowrap';
    });

    if (button) {
        button.className = 'tab-btn px-4 py-2 rounded-lg font-label-lg text-label-lg bg-primary text-on-primary transition-all shadow-sm cursor-pointer whitespace-nowrap';
    }

    const items = document.querySelectorAll('.listing-item');
    let visibleCount = 0;
    items.forEach(item => {
        const itemCat = item.getAttribute('data-cat');
        if (category === 'all' || itemCat === category) {
            item.style.display = 'flex';
            visibleCount++;
        } else {
            item.style.display = 'none';
        }
    });

    const emptyNotice = document.getElementById('no-listings-notice');
    if (emptyNotice) {
        emptyNotice.style.display = visibleCount === 0 ? 'block' : 'none';
    }
}

function toggleMobileSearch() {
    const mobileSearchBar = document.getElementById('mobile-search-bar');
    if (mobileSearchBar) {
        mobileSearchBar.classList.toggle('hidden');
        const input = mobileSearchBar.querySelector('input');
        if (input && !mobileSearchBar.classList.contains('hidden')) {
            input.focus();
        }
    }
}

function showToast(message, type = 'success') {
    let toast = document.getElementById('toast-notification');
    if (!toast) {
        toast = document.createElement('div');
        toast.id = 'toast-notification';
        document.body.appendChild(toast);
    }

    const isError = (type === 'error');
    toast.className = `fixed bottom-20 md:bottom-6 right-6 z-50 flex items-center gap-2.5 px-4 py-3 rounded-2xl ${isError ? 'bg-red-900/95 text-white' : 'bg-primary text-on-primary'} shadow-2xl text-sm font-semibold transition-all duration-300 opacity-0 translate-y-4 pointer-events-none border ${isError ? 'border-red-500/40' : 'border-white/10'}`;

    const icon = isError ? 'error' : 'check_circle';
    const iconColor = isError ? 'text-red-400' : 'text-secondary-fixed';

    toast.innerHTML = `<span class="material-symbols-outlined text-[20px] ${iconColor}">${icon}</span><span>${message}</span>`;
    toast.classList.remove('opacity-0', 'translate-y-4', 'pointer-events-none');
    toast.classList.add('opacity-100', 'translate-y-0');

    setTimeout(() => {
        toast.classList.add('opacity-0', 'translate-y-4', 'pointer-events-none');
        toast.classList.remove('opacity-100', 'translate-y-0');
    }, 2800);
}

// Global exposure
window.setSearchTerm = setSearchTerm;
window.toggleFav = toggleFav;
window.filterCategory = filterCategory;
window.toggleMobileSearch = toggleMobileSearch;
window.showToast = showToast;

// Fermeture du dropdown profil lors d'un clic en dehors
window.addEventListener('click', (e) => {
    const userMenu = document.getElementById('user-menu-wrapper');
    const userDropdown = document.getElementById('user-dropdown-menu');
    if (userMenu && userDropdown && !userMenu.contains(e.target)) {
        userDropdown.classList.add('hidden');
    }

    const indexMenu = document.getElementById('user-menu-wrapper-index');
    const indexDropdown = document.getElementById('user-dropdown-index');
    if (indexMenu && indexDropdown && !indexMenu.contains(e.target)) {
        indexDropdown.classList.add('hidden');
    }
});

// -------------------------------------------------------------
// Galerie Photos / Lightbox (Bouton "Photos" sur les cartes)
// -------------------------------------------------------------
let currentGalleryPhotos = [];
let currentGalleryIndex = 0;

function openPhotoGallery(photos, title) {
    if (!photos || photos.length === 0) {
        showToast('Aucune photo disponible pour cette annonce.');
        return;
    }

    // Normalisation des URLs des photos
    const baseUrl = (window.assetBaseUrl || '/').replace(/\/+$/, '') + '/';
    currentGalleryPhotos = photos.map(p => {
        if (!p) return baseUrl + 'photo/default.png';
        if (p.startsWith('http://') || p.startsWith('https://')) return p;
        return baseUrl + p.replace(/^\/+/, '');
    });

    currentGalleryIndex = 0;
    const titleEl = document.getElementById('gallery-title');
    if (titleEl) titleEl.innerText = title || 'Galerie photos';
    
    updateGalleryUI();

    const modal = document.getElementById('gallery-lightbox-modal');
    if (modal) modal.classList.remove('hidden');
}

function closePhotoGallery() {
    const modal = document.getElementById('gallery-lightbox-modal');
    if (modal) modal.classList.add('hidden');
}

function updateGalleryUI() {
    const mainImg = document.getElementById('gallery-main-img');
    const counter = document.getElementById('gallery-counter');
    const strip = document.getElementById('gallery-thumbnails-strip');

    if (!mainImg || currentGalleryPhotos.length === 0) return;

    mainImg.src = currentGalleryPhotos[currentGalleryIndex];
    if (counter) counter.innerText = `Photo ${currentGalleryIndex + 1} / ${currentGalleryPhotos.length}`;

    if (strip) {
        strip.innerHTML = '';
        currentGalleryPhotos.forEach((src, idx) => {
            const thumb = document.createElement('img');
            thumb.src = src;
            thumb.className = `w-14 h-14 object-cover rounded-xl cursor-pointer transition-all border-2 ${idx === currentGalleryIndex ? 'border-secondary scale-105' : 'border-transparent opacity-60 hover:opacity-100'}`;
            thumb.onclick = () => {
                currentGalleryIndex = idx;
                updateGalleryUI();
            };
            strip.appendChild(thumb);
        });
    }
}

function nextGalleryPhoto() {
    if (currentGalleryPhotos.length <= 1) return;
    currentGalleryIndex = (currentGalleryIndex + 1) % currentGalleryPhotos.length;
    updateGalleryUI();
}

function prevGalleryPhoto() {
    if (currentGalleryPhotos.length <= 1) return;
    currentGalleryIndex = (currentGalleryIndex - 1 + currentGalleryPhotos.length) % currentGalleryPhotos.length;
    updateGalleryUI();
}

document.addEventListener('keydown', (e) => {
    const gallery = document.getElementById('gallery-lightbox-modal');
    if (gallery && !gallery.classList.contains('hidden')) {
        if (e.key === 'ArrowRight') nextGalleryPhoto();
        else if (e.key === 'ArrowLeft') prevGalleryPhoto();
        else if (e.key === 'Escape') closePhotoGallery();
    }
});

function openGalleryFromElement(el) {
    if (!el) return;
    try {
        const rawPhotos = el.getAttribute('data-photos');
        const photos = rawPhotos ? JSON.parse(rawPhotos) : [];
        const title = el.getAttribute('data-titre') || el.getAttribute('alt') || 'Galerie photos';
        openPhotoGallery(photos, title);
    } catch (e) {
        console.error('Erreur ouverture galerie photos:', e);
    }
}

window.openPhotoGallery = openPhotoGallery;
window.openGalleryFromElement = openGalleryFromElement;
window.closePhotoGallery = closePhotoGallery;
window.nextGalleryPhoto = nextGalleryPhoto;
window.prevGalleryPhoto = prevGalleryPhoto;


