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

function showToast(message) {
    let toast = document.getElementById('toast-notification');
    if (!toast) {
        toast = document.createElement('div');
        toast.id = 'toast-notification';
        toast.className = 'fixed bottom-20 md:bottom-6 right-6 z-50 flex items-center gap-2 px-4 py-3 rounded-xl bg-primary text-on-primary shadow-xl text-sm font-medium transition-all duration-300 opacity-0 translate-y-4 pointer-events-none';
        document.body.appendChild(toast);
    }

    toast.innerHTML = `<span class="material-symbols-outlined text-[18px] text-secondary-fixed">check_circle</span><span>${message}</span>`;
    toast.classList.remove('opacity-0', 'translate-y-4', 'pointer-events-none');
    toast.classList.add('opacity-100', 'translate-y-0');

    setTimeout(() => {
        toast.classList.add('opacity-0', 'translate-y-4', 'pointer-events-none');
        toast.classList.remove('opacity-100', 'translate-y-0');
    }, 2400);
}

// Global exposure
window.setSearchTerm = setSearchTerm;
window.toggleFav = toggleFav;
window.filterCategory = filterCategory;
window.toggleMobileSearch = toggleMobileSearch;
window.showToast = showToast;
