/**
 * Epsilon Marketplace - Client-side Interactions (Public Standalone)
 * Gestion des favoris, recherche, galerie photos et formulaire flottant "Mettre au panier"
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

// -------------------------------------------------------------
// 1. Bouton Favoris (♡)
// -------------------------------------------------------------
function toggleFav(btn) {
    if (!btn) return;

    // Si le visiteur n'est pas connecté, redirection immédiate vers la page de connexion client
    if (!window.isUserLoggedIn) {
        showToast("Veuillez vous connecter pour ajouter cette annonce à vos favoris.", "error");
        setTimeout(() => {
            window.location.href = window.loginUrl || '/login';
        }, 800);
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

// -------------------------------------------------------------
// 2. Clic sur la Carte d'Annonce (Redirection si déconnecté / Panier si connecté)
// -------------------------------------------------------------
function handleAdCardClick(card) {
    if (!card) return;

    // Si non connecté : redirection immédiate vers login_client
    if (!window.isUserLoggedIn) {
        showToast("Veuillez vous connecter pour voir l'annonce et ajouter au panier.", "info");
        setTimeout(() => {
            window.location.href = window.loginUrl || '/login';
        }, 600);
        return;
    }

    // Si connecté : ouverture du formulaire flottant "Mettre au panier"
    const id = card.getAttribute('data-ad-id') || '';
    const titre = card.getAttribute('data-ad-titre') || 'Produit Epsilon';
    const prix = parseFloat(card.getAttribute('data-ad-prix')) || 0;
    const photo = card.getAttribute('data-ad-photo') || '';
    const lieu = card.getAttribute('data-ad-lieu') || 'Togo';
    const categorie = card.getAttribute('data-ad-categorie') || 'Annonce';

    openAddToCartModal({ id, titre, prix, photo, lieu, categorie });
}

// -------------------------------------------------------------
// 3. Formulaire Flottant : Ajouter au Panier
// -------------------------------------------------------------
let currentCartItem = null;
let currentCartQuantity = 1;

function openAddToCartModal(item) {
    currentCartItem = item;
    currentCartQuantity = 1;

    const modal = document.getElementById('add-to-cart-modal');
    if (!modal) return;

    // Remplissage des données
    const titleEl = document.getElementById('cart-modal-title');
    const catEl = document.getElementById('cart-modal-cat') || document.getElementById('cart-modal-category');
    const lieuEl = document.getElementById('cart-modal-lieu') || document.getElementById('cart-modal-location');
    const imgEl = document.getElementById('cart-modal-img') || document.getElementById('cart-modal-photo');
    const priceEl = document.getElementById('cart-modal-price');
    const qtyEl = document.getElementById('cart-modal-qty');
    const totalEl = document.getElementById('cart-modal-total');

    if (titleEl) titleEl.innerText = item.titre;
    if (catEl) catEl.innerText = item.categorie;
    if (lieuEl) lieuEl.innerText = item.lieu;
    if (imgEl) imgEl.src = item.photo || (window.assetBaseUrl + 'photo/default.png');
    if (priceEl) priceEl.innerText = formatNumber(item.prix);
    if (qtyEl) {
        if (qtyEl.tagName === 'INPUT') qtyEl.value = currentCartQuantity;
        else qtyEl.innerText = currentCartQuantity;
    }
    if (totalEl) totalEl.innerText = formatNumber(item.prix * currentCartQuantity);

    modal.style.display = 'flex';
    modal.classList.remove('hidden');
}

function closeAddToCartModal(e) {
    if (e && e.target && e.target.id !== 'add-to-cart-modal' && !e.target.closest('button')) {
        return;
    }
    const modal = document.getElementById('add-to-cart-modal');
    if (modal) {
        modal.style.display = 'none';
        modal.classList.add('hidden');
    }
}

function changeCartQuantity(delta) {
    currentCartQuantity = Math.max(1, currentCartQuantity + delta);
    const qtyEl = document.getElementById('cart-modal-qty');
    const totalEl = document.getElementById('cart-modal-total');

    if (qtyEl) {
        if (qtyEl.tagName === 'INPUT') qtyEl.value = currentCartQuantity;
        else qtyEl.innerText = currentCartQuantity;
    }
    if (totalEl && currentCartItem) {
        totalEl.innerText = formatNumber(currentCartItem.prix * currentCartQuantity);
    }
}

function confirmAddToCart() {
    if (!currentCartItem) return;

    try {
        let cart = JSON.parse(localStorage.getItem('epsilon_cart') || '[]');
        const existingIdx = cart.findIndex(p => p.id === currentCartItem.id);

        if (existingIdx > -1) {
            cart[existingIdx].quantity += currentCartQuantity;
        } else {
            cart.push({
                id: currentCartItem.id,
                titre: currentCartItem.titre,
                prix: currentCartItem.prix,
                photo: currentCartItem.photo,
                lieu: currentCartItem.lieu,
                categorie: currentCartItem.categorie,
                quantity: currentCartQuantity,
            });
        }

        localStorage.setItem('epsilon_cart', JSON.stringify(cart));
        updateCartHeaderBadge();

        closeAddToCartModal();
        showToast(`"${currentCartItem.titre}" (x${currentCartQuantity}) a été ajouté à votre panier avec succès !`, 'success');
    } catch (err) {
        console.error('Erreur ajout panier:', err);
        showToast('Article ajouté au panier !');
        closeAddToCartModal();
    }
}

function updateCartHeaderBadge() {
    try {
        const cart = JSON.parse(localStorage.getItem('epsilon_cart') || '[]');
        const totalQty = cart.reduce((acc, item) => acc + (item.quantity || 1), 0);
        const badges = document.querySelectorAll('.header-cart-count');
        badges.forEach(b => {
            b.innerText = totalQty;
            if (totalQty > 0) {
                b.classList.remove('hidden');
            } else {
                b.classList.add('hidden');
            }
        });
    } catch (e) {}
}

function openCartPreview() {
    try {
        const cart = JSON.parse(localStorage.getItem('epsilon_cart') || '[]');
        if (cart.length === 0) {
            showToast("Votre panier est actuellement vide.", "info");
            return;
        }
        const totalItems = cart.reduce((acc, it) => acc + (it.quantity || 1), 0);
        const totalPrice = cart.reduce((acc, it) => acc + (it.prix * (it.quantity || 1)), 0);
        showToast(`Votre panier contient ${totalItems} article(s) (${formatNumber(totalPrice)} FCFA).`, "success");
    } catch (e) {
        showToast("Votre panier est vide.", "info");
    }
}

function formatNumber(num) {
    return new Intl.NumberFormat('fr-FR').format(num);
}

// -------------------------------------------------------------
// 4. Filtrage Catégories
// -------------------------------------------------------------
function filterCategory(category, button) {
    const buttons = document.querySelectorAll('.tab-btn');
    buttons.forEach(b => {
        b.className = 'tab-btn px-4 py-2.5 rounded-xl font-semibold text-xs sm:text-sm bg-white text-on-surface hover:bg-slate-100 transition-all border border-slate-200/80 cursor-pointer whitespace-nowrap';
    });

    if (button) {
        button.className = 'tab-btn px-4 py-2.5 rounded-xl font-semibold text-xs sm:text-sm bg-primary text-on-primary transition-all shadow-sm cursor-pointer whitespace-nowrap';
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

// -------------------------------------------------------------
// 5. Notifications Toast
// -------------------------------------------------------------
function showToast(message, type = 'success') {
    let toast = document.getElementById('toast-notification');
    if (!toast) {
        toast = document.createElement('div');
        toast.id = 'toast-notification';
        document.body.appendChild(toast);
    }

    const isError = (type === 'error');
    const isInfo = (type === 'info');
    
    let bgClass = 'bg-primary text-on-primary border-white/10';
    let icon = 'check_circle';
    let iconColor = 'text-secondary-fixed';

    if (isError) {
        bgClass = 'bg-red-900/95 text-white border-red-500/40';
        icon = 'error';
        iconColor = 'text-red-400';
    } else if (isInfo) {
        bgClass = 'bg-slate-900/95 text-white border-slate-700';
        icon = 'info';
        iconColor = 'text-emerald-400';
    }

    toast.className = `fixed bottom-20 md:bottom-6 right-6 z-[200] flex items-center gap-2.5 px-4 py-3 rounded-2xl ${bgClass} shadow-2xl text-sm font-semibold transition-all duration-300 opacity-0 translate-y-4 pointer-events-none border`;
    toast.innerHTML = `<span class="material-symbols-outlined text-[20px] ${iconColor}">${icon}</span><span>${message}</span>`;
    
    toast.classList.remove('opacity-0', 'translate-y-4', 'pointer-events-none');
    toast.classList.add('opacity-100', 'translate-y-0');

    setTimeout(() => {
        toast.classList.add('opacity-0', 'translate-y-4', 'pointer-events-none');
        toast.classList.remove('opacity-100', 'translate-y-0');
    }, 2800);
}

// -------------------------------------------------------------
// 6. Galerie Photos / Lightbox (Peu importe connecté ou pas)
// -------------------------------------------------------------
let currentGalleryPhotos = [];
let currentGalleryIndex = 0;

function openPhotoGallery(photos, title) {
    if (!photos || photos.length === 0) {
        showToast('Aucune photo disponible pour cette annonce.', 'info');
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
    if (modal) {
        modal.style.display = 'flex';
        modal.classList.remove('hidden');
    }
}

function closePhotoGallery() {
    const modal = document.getElementById('gallery-lightbox-modal');
    if (modal) {
        modal.style.display = 'none';
        modal.classList.add('hidden');
    }
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
            thumb.onclick = (e) => {
                if (e) e.stopPropagation();
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

function openGalleryFromElement(el) {
    if (!el) return;
    try {
        let rawPhotos = el.getAttribute('data-photos');
        let photos = [];
        if (rawPhotos) {
            if (typeof rawPhotos === 'string') {
                const cleaned = rawPhotos.replace(/&quot;/g, '"').replace(/&#039;/g, "'").replace(/&amp;/g, '&');
                photos = JSON.parse(cleaned);
                if (typeof photos === 'string') {
                    photos = JSON.parse(photos);
                }
            } else if (Array.isArray(rawPhotos)) {
                photos = rawPhotos;
            }
        }
        const title = el.getAttribute('data-titre') || el.getAttribute('alt') || 'Galerie photos';
        openPhotoGallery(photos, title);
    } catch (e) {
        console.error('Erreur ouverture galerie photos:', e);
    }
}

// Navigation au clavier pour la galerie
document.addEventListener('keydown', (e) => {
    const gallery = document.getElementById('gallery-lightbox-modal');
    if (gallery && gallery.style.display !== 'none' && !gallery.classList.contains('hidden')) {
        if (e.key === 'ArrowRight') nextGalleryPhoto();
        else if (e.key === 'ArrowLeft') prevGalleryPhoto();
        else if (e.key === 'Escape') closePhotoGallery();
    }

    const cartModal = document.getElementById('add-to-cart-modal');
    if (cartModal && cartModal.style.display !== 'none' && !cartModal.classList.contains('hidden')) {
        if (e.key === 'Escape') closeAddToCartModal();
    }
});

// Initialisation au chargement de la page
document.addEventListener('DOMContentLoaded', () => {
    updateCartHeaderBadge();
});

// Exposition globale des fonctions
window.setSearchTerm = setSearchTerm;
window.toggleFav = toggleFav;
window.filterCategory = filterCategory;
window.toggleMobileSearch = toggleMobileSearch;
window.showToast = showToast;
window.handleAdCardClick = handleAdCardClick;
window.openAddToCartModal = openAddToCartModal;
window.closeAddToCartModal = closeAddToCartModal;
window.changeCartQuantity = changeCartQuantity;
window.confirmAddToCart = confirmAddToCart;
window.updateCartHeaderBadge = updateCartHeaderBadge;
window.openCartPreview = openCartPreview;
window.openPhotoGallery = openPhotoGallery;
window.openGalleryFromElement = openGalleryFromElement;
window.closePhotoGallery = closePhotoGallery;
window.nextGalleryPhoto = nextGalleryPhoto;
window.prevGalleryPhoto = prevGalleryPhoto;
