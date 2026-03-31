/* ============================================================
   Prestige Corporate Gifts — Main JavaScript
   ============================================================ */
(function () {
    'use strict';

    /* ------ Products Data ------ */
    const products = [
        { id: 1, name: 'Executive Leather Notebook', category: 'executive', price: 285, min: 25, icon: 'fa-book', badge: 'bestseller' },
        { id: 2, name: 'Wireless Power Bank 10000mAh', category: 'tech', price: 195, min: 50, icon: 'fa-battery-full', badge: 'new' },
        { id: 3, name: 'Stainless Steel Travel Tumbler', category: 'drinkware', price: 125, min: 30, icon: 'fa-mug-hot', badge: '' },
        { id: 4, name: 'Branded Polo Shirt', category: 'apparel', price: 165, min: 50, icon: 'fa-shirt', badge: '' },
        { id: 5, name: 'Bamboo Desk Organiser', category: 'eco', price: 210, min: 20, icon: 'fa-leaf', badge: 'eco' },
        { id: 6, name: 'Gourmet Gift Hamper', category: 'hampers', price: 650, min: 10, icon: 'fa-gift', badge: 'premium' },
        { id: 7, name: 'Bluetooth Speaker', category: 'tech', price: 175, min: 30, icon: 'fa-volume-up', badge: '' },
        { id: 8, name: 'Parker Pen Set', category: 'executive', price: 420, min: 15, icon: 'fa-pen-fancy', badge: 'premium' }
    ];

    /* ------ Cart State ------ */
    let cart = JSON.parse(localStorage.getItem('pcg_cart') || '[]');

    /* ------ DOM Refs ------ */
    const $ = (sel, ctx) => (ctx || document).querySelector(sel);
    const $$ = (sel, ctx) => [...(ctx || document).querySelectorAll(sel)];

    const cartOverlay = $('.cart-overlay');
    const cartSidebar = $('.cart-sidebar');
    const cartItemsEl = $('.cart-items');
    const cartCountEls = $$('.cart-count');
    const cartSubtotalEl = $('#cart-subtotal');
    const searchModal = $('.search-modal');
    const searchInput = $('#search-input');
    const searchResults = $('.search-results');
    const navbar = $('.navbar');
    const navMenu = $('.nav-menu');
    const hamburger = $('.hamburger');
    const backToTop = $('.back-to-top');
    const filterTabs = $$('.filter-tab');
    const productCards = $$('.product-card');

    /* ========== Cart Functions ========== */
    function saveCart() {
        localStorage.setItem('pcg_cart', JSON.stringify(cart));
    }

    function updateCartUI() {
        /* Count badge */
        const total = cart.reduce((s, i) => s + i.qty, 0);
        cartCountEls.forEach(el => {
            el.textContent = total;
            el.classList.add('bump');
            setTimeout(() => el.classList.remove('bump'), 400);
        });

        /* Subtotal */
        const subtotal = cart.reduce((s, i) => s + i.price * i.qty, 0);
        if (cartSubtotalEl) cartSubtotalEl.textContent = 'R' + subtotal.toLocaleString();

        /* Items HTML */
        if (!cartItemsEl) return;
        if (cart.length === 0) {
            cartItemsEl.innerHTML = `
                <div class="cart-empty">
                    <i class="fas fa-shopping-bag"></i>
                    <p>Your cart is empty</p>
                    <button class="btn btn-sm btn-outline" onclick="document.querySelector('.cart-overlay').click()">Browse Products</button>
                </div>`;
            return;
        }
        cartItemsEl.innerHTML = cart.map(item => `
            <div class="cart-item" data-id="${item.id}">
                <div class="cart-item-image"><i class="fas ${item.icon}"></i></div>
                <div class="cart-item-details">
                    <div class="cart-item-name">${escapeHtml(item.name)}</div>
                    <div class="cart-item-meta">R${item.price} x <strong>${item.qty}</strong> = R${(item.price * item.qty).toLocaleString()}</div>
                </div>
                <button class="cart-item-remove" data-id="${item.id}" title="Remove"><i class="fas fa-times"></i></button>
            </div>`).join('');
    }

    function escapeHtml(str) {
        const div = document.createElement('div');
        div.textContent = str;
        return div.innerHTML;
    }

    function addToCart(id) {
        const product = products.find(p => p.id === id);
        if (!product) return;
        const card = $(`.product-card[data-id="${id}"]`);
        const qtyInput = card ? $('input.qty-input', card) : null;
        const qty = qtyInput ? Math.max(1, parseInt(qtyInput.value, 10) || 1) : 1;

        const existing = cart.find(i => i.id === id);
        if (existing) {
            existing.qty += qty;
        } else {
            cart.push({ id: product.id, name: product.name, price: product.price, qty, icon: product.icon });
        }
        saveCart();
        updateCartUI();

        /* Feedback */
        if (card) {
            const btn = $('.btn-add-cart', card);
            if (btn) {
                const orig = btn.innerHTML;
                btn.classList.add('added');
                btn.innerHTML = '<i class="fas fa-check"></i> Added';
                setTimeout(() => { btn.classList.remove('added'); btn.innerHTML = orig; }, 1200);
            }
        }
    }

    function removeFromCart(id) {
        cart = cart.filter(i => i.id !== id);
        saveCart();
        updateCartUI();
    }

    function clearCart() {
        cart = [];
        saveCart();
        updateCartUI();
    }

    /* ========== Cart Sidebar ========== */
    function openCart() {
        cartOverlay.classList.add('active');
        cartSidebar.classList.add('active');
        document.body.style.overflow = 'hidden';
    }

    function closeCart() {
        cartOverlay.classList.remove('active');
        cartSidebar.classList.remove('active');
        document.body.style.overflow = '';
    }

    /* ========== Search ========== */
    function openSearch() {
        searchModal.classList.add('active');
        setTimeout(() => searchInput && searchInput.focus(), 200);
        document.body.style.overflow = 'hidden';
    }

    function closeSearch() {
        searchModal.classList.remove('active');
        document.body.style.overflow = '';
        if (searchInput) searchInput.value = '';
        if (searchResults) searchResults.innerHTML = '';
    }

    function doSearch(query) {
        if (!searchResults) return;
        const q = query.toLowerCase().trim();
        if (!q) { searchResults.innerHTML = ''; return; }
        const hits = products.filter(p => p.name.toLowerCase().includes(q) || p.category.includes(q));
        if (hits.length === 0) {
            searchResults.innerHTML = '<p style="padding:16px;color:#94a3b8;text-align:center;">No products found</p>';
            return;
        }
        searchResults.innerHTML = hits.map(p => `
            <div class="search-result-item" data-id="${p.id}">
                <div class="result-icon"><i class="fas ${p.icon}"></i></div>
                <div class="result-info">
                    <strong>${escapeHtml(p.name)}</strong>
                    <span>R${p.price} · Min ${p.min} units</span>
                </div>
            </div>`).join('');
    }

    /* ========== Product Filters ========== */
    function filterProducts(category) {
        filterTabs.forEach(t => t.classList.toggle('active', t.dataset.category === category));
        productCards.forEach(card => {
            const show = category === 'all' || card.dataset.category === category;
            card.classList.toggle('hidden', !show);
        });
    }

    /* ========== Qty Controls ========== */
    function initQtyControls() {
        $$('.qty-btn').forEach(btn => {
            btn.addEventListener('click', () => {
                const card = btn.closest('.product-card') || btn.closest('.qty-control');
                const input = $('input.qty-input', card.closest('.product-actions') || card);
                if (!input) return;
                const min = parseInt(input.min, 10) || 1;
                let val = parseInt(input.value, 10) || min;
                if (btn.classList.contains('qty-minus')) val = Math.max(min, val - 1);
                else val += 1;
                input.value = val;
            });
        });
    }

    /* ========== Navbar Scroll ========== */
    function handleScroll() {
        if (navbar) navbar.classList.toggle('scrolled', window.scrollY > 20);
        if (backToTop) backToTop.classList.toggle('visible', window.scrollY > 600);

        /* Active nav link */
        const sections = $$('section[id]');
        let current = '';
        sections.forEach(sec => {
            const top = sec.offsetTop - 120;
            if (window.scrollY >= top) current = sec.id;
        });
        $$('.nav-link').forEach(link => {
            link.classList.toggle('active', link.getAttribute('href') === '#' + current);
        });
    }

    /* ========== Event Delegation ========== */
    document.addEventListener('click', e => {
        const target = e.target;

        /* Cart toggle */
        if (target.closest('.cart-toggle')) { openCart(); return; }
        if (target.closest('.cart-close') || target === cartOverlay) { closeCart(); return; }

        /* Search toggle */
        if (target.closest('.search-toggle')) { openSearch(); return; }
        if (target.closest('.search-close') || (target === searchModal)) { closeSearch(); return; }

        /* Add to cart */
        if (target.closest('.btn-add-cart')) {
            const card = target.closest('.product-card');
            if (card) addToCart(parseInt(card.dataset.id, 10));
            return;
        }

        /* Remove from cart */
        if (target.closest('.cart-item-remove')) {
            removeFromCart(parseInt(target.closest('.cart-item-remove').dataset.id, 10));
            return;
        }

        /* Clear cart */
        if (target.closest('.clear-cart')) { clearCart(); return; }

        /* Filter tabs */
        if (target.closest('.filter-tab')) {
            filterProducts(target.closest('.filter-tab').dataset.category);
            return;
        }

        /* Hamburger */
        if (target.closest('.hamburger')) {
            navMenu.classList.toggle('active');
            return;
        }

        /* Search result -> scroll & close */
        if (target.closest('.search-result-item')) {
            const id = parseInt(target.closest('.search-result-item').dataset.id, 10);
            const card = $(`.product-card[data-id="${id}"]`);
            closeSearch();
            if (card) card.scrollIntoView({ behavior: 'smooth', block: 'center' });
            return;
        }

        /* Back to top */
        if (target.closest('.back-to-top')) {
            window.scrollTo({ top: 0, behavior: 'smooth' });
            return;
        }

        /* Close mobile nav on link click */
        if (target.closest('.nav-link') && navMenu) {
            navMenu.classList.remove('active');
        }
    });

    /* Search input */
    if (searchInput) {
        searchInput.addEventListener('input', () => doSearch(searchInput.value));
    }

    /* Escape key */
    document.addEventListener('keydown', e => {
        if (e.key === 'Escape') {
            closeCart();
            closeSearch();
        }
    });

    /* Contact form demo */
    const contactForm = $('#contact-form');
    if (contactForm) {
        contactForm.addEventListener('submit', e => {
            e.preventDefault();
            const btn = $('button[type="submit"]', contactForm);
            const orig = btn.innerHTML;
            btn.innerHTML = '<i class="fas fa-check"></i> Message Sent!';
            btn.disabled = true;
            setTimeout(() => { btn.innerHTML = orig; btn.disabled = false; contactForm.reset(); }, 2500);
        });
    }

    /* Quote button */
    $$('.quote-btn, .btn-quote').forEach(btn => {
        btn.addEventListener('click', () => {
            if (cart.length === 0) {
                openCart();
                return;
            }
            const summary = cart.map(i => `${i.name} x${i.qty}`).join(', ');
            const total = cart.reduce((s, i) => s + i.price * i.qty, 0);
            alert(`Demo — Quote Request\n\nItems: ${summary}\nEstimated Total: R${total.toLocaleString()}\n\nIn a live site, this would submit your quote request.`);
        });
    });

    /* ========== Init ========== */
    window.addEventListener('scroll', handleScroll, { passive: true });
    handleScroll();
    initQtyControls();
    updateCartUI();
})();
