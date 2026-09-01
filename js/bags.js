/**
 * SmashZone - Badminton Bags Category JavaScript
 * 7 Real-World Tour Bags products mapped 1-to-1 to images in images/products/bags/
 * Homepage Product Card Design & Fully Working Clear All Filters Button.
 */

document.addEventListener('DOMContentLoaded', () => {
  let bagsData = [
    // 1. Yonex Pro Stand-up Thermo Bag 92231 (b1.png)
    {
      id: 501,
      brand: 'Yonex',
      name: 'Yonex Pro Stand-up Thermo Bag 92231',
      category: 'Thermo 6-Racket Bag',
      capacity: '6 Rackets + Gear',
      price: 38500,
      oldPrice: 44000,
      badge: 'PRO CHOICE',
      badgeClass: 'badge-hot',
      rating: 5.0,
      reviews: 98,
      image: 'images/products/bags/b1.png',
      desc: 'Climate protective Thermo-Guard lining keeps racket strings and frames safe from heat and humidity.'
    },
    // 2. Li-Ning National Team 9-Racket Tournament Bag (b2.jpeg)
    {
      id: 502,
      brand: 'Li-Ning',
      name: 'Li-Ning National Team 9-Racket Tournament Bag',
      category: 'Tour 9-Racket Bag',
      capacity: '9 Rackets + Shoes',
      price: 42000,
      oldPrice: 48000,
      badge: 'TOURNAMENT',
      badgeClass: 'badge-hot',
      rating: 4.9,
      reviews: 74,
      image: 'images/products/bags/b2.jpeg',
      desc: 'Professional tour bag with dual cushioned shoulder straps, shoe tunnel, and wet clothes compartment.'
    },
    // 3. Victor Supreme Thermo 6-Racket Bag Black/Gold (b3.jpeg)
    {
      id: 503,
      brand: 'Victor',
      name: 'Victor Supreme Thermo 6-Racket Bag Black/Gold',
      category: 'Thermo 6-Racket Bag',
      capacity: '6 Rackets',
      price: 32500,
      oldPrice: 37000,
      badge: 'BESTSELLER',
      badgeClass: 'badge-sale',
      rating: 4.9,
      reviews: 61,
      image: 'images/products/bags/b3.jpeg',
      desc: 'Thermal foil insulation chamber with high-density polyester wear resistant fabric.'
    },
    // 4. Hundred Tour Series 6-Racket Bag Red/Black (b4.jpeg)
    {
      id: 504,
      brand: 'Hundred',
      name: 'Hundred Tour Series 6-Racket Bag Red/Black',
      category: 'Thermo 6-Racket Bag',
      capacity: '6 Rackets',
      price: 24900,
      oldPrice: 29000,
      badge: 'VALUE CHAMP',
      badgeClass: 'badge-sale',
      rating: 4.8,
      reviews: 43,
      image: 'images/products/bags/b4.jpeg',
      desc: 'Multi-compartment racket bag with dedicated accessory organizer and padded backpack straps.'
    },
    // 5. Li-Ning Professional Duffel Tournament Bag Blue (b5.jpeg)
    {
      id: 505,
      brand: 'Li-Ning',
      name: 'Li-Ning Professional Duffel Tournament Bag Blue',
      category: 'Tour Duffel Bag',
      capacity: '6 Rackets + Apparel',
      price: 29500,
      oldPrice: 34000,
      badge: 'NEW ARRIVAL',
      badgeClass: 'badge-new',
      rating: 4.8,
      reviews: 38,
      image: 'images/products/bags/b5.jpeg',
      desc: 'Wide-opening barrel duffel design featuring waterproof base layer and ventilated shoe pocket.'
    },
    // 6. Victor Rectangular Tournament Racket Bag (b6.jpeg)
    {
      id: 506,
      brand: 'Victor',
      name: 'Victor Rectangular Tournament Racket Bag',
      category: 'Tour 9-Racket Bag',
      capacity: '9 Rackets',
      price: 36900,
      oldPrice: 41500,
      badge: 'POPULAR',
      badgeClass: 'badge-sale',
      rating: 4.9,
      reviews: 52,
      image: 'images/products/bags/b6.jpeg',
      desc: 'Rectangular upright standing shape engineered for maximum court bench space saving.'
    },
    // 7. Yonex Pro Badminton Backpack 92212 (b7.png)
    {
      id: 507,
      brand: 'Yonex',
      name: 'Yonex Pro Badminton Backpack 92212',
      category: 'Racket Backpack',
      capacity: '2 Rackets + Laptop',
      price: 26500,
      oldPrice: 30000,
      badge: 'FEATHER LIGHT',
      badgeClass: 'badge-new',
      rating: 5.0,
      reviews: 87,
      image: 'images/products/bags/b7.png',
      desc: 'Ergonomic padded shoulder harness with dedicated padded racket sleeve and separate bottom shoe compartment.'
    }
  ];

  let activeFilters = {
    brands: [],
    categories: [],
    maxPrice: 50000,
    search: '',
    sort: 'featured'
  };

  let cart = [];
  let wishlist = [];

  const bagsGrid = document.getElementById('bagsGrid');
  const bagsCount = document.getElementById('bagsCount');
  const priceSlider = document.getElementById('priceSlider');
  const priceDisplay = document.getElementById('priceDisplay');
  const bagsSearchInput = document.getElementById('bagsSearchInput');
  const sortSelect = document.getElementById('sortSelect');
  const activeFiltersBar = document.getElementById('activeFiltersBar');

  function formatLKR(num) { return 'Rs. ' + num.toLocaleString('en-US'); }

  function getFilteredBags() {
    return bagsData.filter(item => {
      // Brand Filter
      if (activeFilters.brands.length > 0 && !activeFilters.brands.includes(item.brand)) return false;

      // Category Filter
      if (activeFilters.categories.length > 0 && !activeFilters.categories.includes(item.category)) return false;

      // Price Slider Filter
      if (item.price > activeFilters.maxPrice) return false;

      // Search Query Filter
      if (activeFilters.search) {
        const q = activeFilters.search.toLowerCase();
        if (!item.name.toLowerCase().includes(q) && !item.brand.toLowerCase().includes(q) && !item.category.toLowerCase().includes(q)) return false;
      }

      return true;
    }).sort((a, b) => {
      if (activeFilters.sort === 'price-low') return a.price - b.price;
      if (activeFilters.sort === 'price-high') return b.price - a.price;
      if (activeFilters.sort === 'rating') return b.rating - a.rating;
      return 0;
    });
  }

  function renderGrid() {
    const list = getFilteredBags();

    // Update Counter
    if (bagsCount) bagsCount.textContent = list.length;

    // Render Active Badges Bar
    renderActiveBadges();

    if (!bagsGrid) return;

    if (list.length === 0) {
      bagsGrid.innerHTML = `
        <div class="col-12 text-center py-5">
          <i class="bi bi-funnel display-1 text-muted opacity-50 mb-3"></i>
          <h4 class="fw-bold text-navy">No Badminton Bags Match Your Filter</h4>
          <p class="text-muted mb-3">Try adjusting your filters or price slider.</p>
          <button id="noResultsResetBtn" class="btn btn-brand-orange rounded-pill px-4">
            <i class="bi bi-arrow-counterclockwise me-1"></i> Reset All Filters
          </button>
        </div>
      `;
      document.getElementById('noResultsResetBtn')?.addEventListener('click', resetAllFilters);
      return;
    }

    // Render Exact Homepage Card Markup
    bagsGrid.innerHTML = list.map(item => {
      const isLiked = wishlist.includes(item.id);
      return `
        <div class="col-sm-6 col-xl-4 product-grid-item">
          <div class="product-card">
            <span class="product-badge ${item.badgeClass}">${item.badge}</span>
            <button class="wishlist-toggle-btn ${isLiked ? 'active text-danger' : ''}" data-id="${item.id}" aria-label="Add to Wishlist">
              <i class="bi ${isLiked ? 'bi-heart-fill' : 'bi-heart'}"></i>
            </button>

            <div class="product-img-container">
              <img src="${item.image}" alt="${item.name}" loading="lazy">
              <div class="quick-view-overlay">
                <button class="btn-quick-view" data-id="${item.id}">
                  <i class="bi bi-eye"></i> Quick View
                </button>
              </div>
            </div>

            <div class="product-category">${item.brand}</div>
            <h4 class="product-name" title="${item.name}">${item.name}</h4>

            <div class="racket-specs-bar">
              <span class="racket-spec-tag tag-speed">${item.category}</span>
              <span class="racket-spec-tag">${item.capacity}</span>
            </div>

            <div class="product-rating">
              <i class="bi bi-star-fill text-warning"></i>
              <i class="bi bi-star-fill text-warning"></i>
              <i class="bi bi-star-fill text-warning"></i>
              <i class="bi bi-star-fill text-warning"></i>
              <i class="bi bi-star-fill text-warning"></i>
              <span class="rating-count">(${item.reviews})</span>
            </div>

            <div class="product-price-row">
              <span class="current-price">${formatLKR(item.price)}</span>
              <span class="old-price">${formatLKR(item.oldPrice)}</span>
            </div>

            <button class="btn-add-cart" data-id="${item.id}">
              <i class="bi bi-cart-plus"></i> Add to Cart
            </button>
          </div>
        </div>
      `;
    }).join('');

    // Attach Event Listeners
    bagsGrid.querySelectorAll('.btn-add-cart').forEach(b => {
      b.onclick = (e) => addToCart(parseInt(e.currentTarget.getAttribute('data-id')));
    });

    bagsGrid.querySelectorAll('.btn-quick-view').forEach(b => {
      b.onclick = (e) => openQuickView(parseInt(e.currentTarget.getAttribute('data-id')));
    });

    bagsGrid.querySelectorAll('.wishlist-toggle-btn').forEach(b => {
      b.onclick = (e) => toggleWishlist(parseInt(e.currentTarget.getAttribute('data-id')));
    });
  }

  function renderActiveBadges() {
    if (!activeFiltersBar) return;
    const badges = [];

    activeFilters.brands.forEach(b => badges.push({ type: 'brand', val: b, label: `Brand: ${b}` }));
    activeFilters.categories.forEach(c => badges.push({ type: 'category', val: c, label: `Type: ${c}` }));

    if (activeFilters.maxPrice < 50000) {
      badges.push({ type: 'maxPrice', val: 50000, label: `Max: ${formatLKR(activeFilters.maxPrice)}` });
    }

    if (activeFilters.search) {
      badges.push({ type: 'search', val: '', label: `Search: "${activeFilters.search}"` });
    }

    if (badges.length === 0) {
      activeFiltersBar.innerHTML = '';
      activeFiltersBar.style.display = 'none';
      return;
    }

    activeFiltersBar.style.display = 'flex';
    activeFiltersBar.innerHTML = `
      <span class="small fw-bold text-muted me-2 align-self-center">Active Filters:</span>
      ${badges.map(b => `
        <span class="badge bg-white text-navy border shadow-sm p-2 d-inline-flex align-items-center gap-1">
          ${b.label}
          <i class="bi bi-x-circle-fill text-orange cursor-pointer remove-filter-badge" data-type="${b.type}" data-val="${b.val}"></i>
        </span>
      `).join('')}
      <button id="barClearAllBtn" class="btn btn-sm btn-link text-orange text-decoration-none fw-bold ms-auto p-0">Clear All</button>
    `;

    document.getElementById('barClearAllBtn')?.addEventListener('click', resetAllFilters);

    activeFiltersBar.querySelectorAll('.remove-filter-badge').forEach(icon => {
      icon.onclick = (e) => {
        const type = e.currentTarget.getAttribute('data-type');
        const val = e.currentTarget.getAttribute('data-val');
        removeSingleBadge(type, val);
      };
    });
  }

  function removeSingleBadge(type, val) {
    if (type === 'brand') {
      activeFilters.brands = activeFilters.brands.filter(b => b !== val);
      document.querySelectorAll(`.brandCheck[value="${val}"]`).forEach(c => c.checked = false);
    } else if (type === 'category') {
      activeFilters.categories = activeFilters.categories.filter(c => c !== val);
      document.querySelectorAll(`.categoryCheck[value="${val}"]`).forEach(c => c.checked = false);
    } else if (type === 'maxPrice') {
      activeFilters.maxPrice = 50000;
      if (priceSlider) priceSlider.value = 50000;
      if (priceDisplay) priceDisplay.textContent = formatLKR(50000);
    } else if (type === 'search') {
      activeFilters.search = '';
      if (bagsSearchInput) bagsSearchInput.value = '';
    }
    renderGrid();
  }

  function resetAllFilters() {
    activeFilters = {
      brands: [],
      categories: [],
      maxPrice: 50000,
      search: '',
      sort: 'featured'
    };

    document.querySelectorAll('.brandCheck, .categoryCheck').forEach(cb => cb.checked = false);
    if (priceSlider) priceSlider.value = 50000;
    if (priceDisplay) priceDisplay.textContent = formatLKR(50000);
    if (bagsSearchInput) bagsSearchInput.value = '';
    if (sortSelect) sortSelect.value = 'featured';

    renderGrid();
  }

  // CONNECT CLEAR BUTTONS
  document.getElementById('clearFiltersBtn')?.addEventListener('click', resetAllFilters);
  document.getElementById('mobileClearFiltersBtn')?.addEventListener('click', resetAllFilters);

  // BRAND CHECKBOXES
  document.querySelectorAll('.brandCheck').forEach(cb => {
    cb.onchange = (e) => {
      const val = e.target.value;
      if (e.target.checked) {
        if (!activeFilters.brands.includes(val)) activeFilters.brands.push(val);
      } else {
        activeFilters.brands = activeFilters.brands.filter(b => b !== val);
      }
      renderGrid();
    };
  });

  // CATEGORY CHECKBOXES
  document.querySelectorAll('.categoryCheck').forEach(cb => {
    cb.onchange = (e) => {
      const val = e.target.value;
      if (e.target.checked) {
        if (!activeFilters.categories.includes(val)) activeFilters.categories.push(val);
      } else {
        activeFilters.categories = activeFilters.categories.filter(c => c !== val);
      }
      renderGrid();
    };
  });

  // PRICE SLIDER
  if (priceSlider) {
    priceSlider.oninput = (e) => {
      activeFilters.maxPrice = parseInt(e.target.value);
      if (priceDisplay) priceDisplay.textContent = formatLKR(activeFilters.maxPrice);
      renderGrid();
    };
  }

  // SEARCH INPUT
  if (bagsSearchInput) {
    bagsSearchInput.oninput = (e) => {
      activeFilters.search = e.target.value.trim();
      renderGrid();
    };
  }

  // SORT SELECT
  if (sortSelect) {
    sortSelect.onchange = (e) => {
      activeFilters.sort = e.target.value;
      renderGrid();
    };
  }

  // ADD TO CART
  function addToCart(id) {
    const item = bagsData.find(b => b.id === id);
    if (typeof window.smashZoneAddToCart === 'function') {
      window.smashZoneAddToCart(id, 1, item).then(() => {
        window.location.href = 'cart.php';
      }).catch(() => {});
    }
  }

  function renderCartDrawer() {
    const cartCountTitle = document.getElementById('cartCountTitle');
    const cartDrawerItems = document.getElementById('cartDrawerItems');
    const cartSubtotal = document.getElementById('cartSubtotal');
    const cartTotal = document.getElementById('cartTotal');
    const cartBadgeDesktop = document.getElementById('cartBadgeDesktop');
    const cartBadgeMobile = document.getElementById('cartBadgeMobile');

    const totalQty = cart.reduce((sum, item) => sum + item.qty, 0);
    const subtotal = cart.reduce((sum, item) => sum + (item.price * item.qty), 0);

    if (cartCountTitle) cartCountTitle.textContent = totalQty;
    if (cartBadgeDesktop) cartBadgeDesktop.textContent = totalQty;
    if (cartBadgeMobile) cartBadgeMobile.textContent = totalQty;

    if (cartSubtotal) cartSubtotal.textContent = formatLKR(subtotal);
    if (cartTotal) cartTotal.textContent = formatLKR(subtotal);

    if (!cartDrawerItems) return;

    if (cart.length === 0) {
      cartDrawerItems.innerHTML = `
        <div class="text-center py-5 text-muted">
          <i class="bi bi-bag-x display-3 mb-3 text-secondary"></i>
          <p class="mb-1 fw-bold text-dark">Your SmashZone cart is empty.</p>
          <small>Explore our bags category to add products.</small>
        </div>
      `;
      return;
    }

    cartDrawerItems.innerHTML = cart.map(item => `
      <div class="cart-item-row d-flex align-items-center gap-3 py-2 border-bottom">
        <img src="${item.image}" alt="${item.name}" style="width: 55px; height: 55px; object-fit: contain;" class="rounded border p-1 bg-light">
        <div class="flex-grow-1">
          <div class="fw-bold text-dark small text-truncate" style="max-width: 170px;">${item.name}</div>
          <div class="text-primary font-semibold small">${formatLKR(item.price)} × ${item.qty}</div>
        </div>
        <div class="d-flex align-items-center gap-1">
          <button class="btn btn-sm btn-outline-secondary py-0 px-2 btn-qty-minus" data-id="${item.id}">-</button>
          <span class="small fw-bold px-1">${item.qty}</span>
          <button class="btn btn-sm btn-outline-secondary py-0 px-2 btn-qty-plus" data-id="${item.id}">+</button>
          <button class="btn btn-sm text-danger ms-1 btn-cart-remove" data-id="${item.id}"><i class="bi bi-trash"></i></button>
        </div>
      </div>
    `).join('');

    cartDrawerItems.querySelectorAll('.btn-qty-minus').forEach(b => {
      b.onclick = (e) => {
        const id = parseInt(e.currentTarget.getAttribute('data-id'));
        const idx = cart.findIndex(c => c.id === id);
        if (idx > -1) {
          if (cart[idx].qty > 1) cart[idx].qty -= 1;
          else cart.splice(idx, 1);
          renderCartDrawer();
        }
      };
    });

    cartDrawerItems.querySelectorAll('.btn-qty-plus').forEach(b => {
      b.onclick = (e) => {
        const id = parseInt(e.currentTarget.getAttribute('data-id'));
        const idx = cart.findIndex(c => c.id === id);
        if (idx > -1) {
          cart[idx].qty += 1;
          renderCartDrawer();
        }
      };
    });

    cartDrawerItems.querySelectorAll('.btn-cart-remove').forEach(b => {
      b.onclick = (e) => {
        const id = parseInt(e.currentTarget.getAttribute('data-id'));
        cart = cart.filter(c => c.id !== id);
        renderCartDrawer();
      };
    });
  }

  function toggleWishlist(id) {
    const idx = wishlist.indexOf(id);
    if (idx > -1) wishlist.splice(idx, 1);
    else wishlist.push(id);
    renderGrid();
  }

  function openQuickView(id) {
    const item = bagsData.find(b => b.id === id);
    if (!item) return;

    document.getElementById('quickViewImage').src = item.image;
    document.getElementById('quickViewCategory').textContent = item.brand;
    document.getElementById('quickViewTitle').textContent = item.name;
    document.getElementById('quickViewPrice').textContent = formatLKR(item.price);
    document.getElementById('quickViewOldPrice').textContent = formatLKR(item.oldPrice);
    document.getElementById('quickViewDesc').textContent = `${item.desc} Bag Type: ${item.category}, Capacity: ${item.capacity}.`;

    const addBtn = document.getElementById('quickViewAddCartBtn');
    if (addBtn) {
      addBtn.onclick = () => {
        addToCart(item.id);
        const modalElem = document.getElementById('quickViewModal');
        if (modalElem) bootstrap.Modal.getInstance(modalElem)?.hide();
      };
    }

    const modalElem = document.getElementById('quickViewModal');
    if (modalElem) {
      const bsModal = bootstrap.Modal.getInstance(modalElem) || new bootstrap.Modal(modalElem);
      bsModal.show();
    }
  }

  // FETCH DYNAMIC DATA FROM MYSQL DATABASE
  fetch('api/get_products.php?category=bags')
    .then(res => res.json())
    .then(data => {
      if (data.status === 'success' && data.products && data.products.length > 0) {
        bagsData = data.products.map(p => ({
          id: p.id,
          brand: p.brand,
          name: p.name,
          category: p.spec_1 || 'Thermo 6-Racket Bag',
          capacity: p.spec_2 || '6 Rackets + Gear',
          price: p.price,
          oldPrice: p.oldPrice || p.price,
          badge: p.badge || 'NEW',
          badgeClass: p.badgeClass || 'badge-new',
          rating: p.rating || 5.0,
          reviews: p.reviews || 50,
          image: p.image,
          desc: p.desc || p.description
        }));
        if (typeof renderGrid === 'function') renderGrid();
      }
    })
    .catch(err => console.log('Static fallback active for bags'));

  // INITIAL RENDER
  renderGrid();
});
