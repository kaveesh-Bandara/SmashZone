/**
 * SmashZone - Badminton Shoes Category JavaScript
 * 14 Real-World Court Shoes products mapped 1-to-1 to images in images/products/shoes/
 * Homepage Product Card Design & Fully Working Clear All Filters Button.
 */

document.addEventListener('DOMContentLoaded', () => {
  let shoesData = [
    // 1. Yonex Power Cushion 65Z3 White/Tiger (sh1.png)
    {
      id: 301,
      brand: 'Yonex',
      name: 'Yonex Power Cushion 65Z3 White/Tiger',
      sole: 'Power Cushion+',
      fit: 'Men',
      price: 45900,
      oldPrice: 52000,
      badge: 'PRO CHOICE',
      badgeClass: 'badge-hot',
      rating: 5.0,
      reviews: 86,
      image: 'images/products/shoes/sh1.png',
      desc: 'World champion choice featuring Power Cushion+ shock absorption and Radial Blade high-traction outsole.'
    },
    // 2. Asics Gel-Blade 8 Court White/Blue (sh2.png)
    {
      id: 302,
      brand: 'Asics',
      name: 'Asics Gel-Blade 8 Court White/Blue',
      sole: 'GEL Technology',
      fit: 'Unisex',
      price: 36500,
      oldPrice: 41000,
      badge: 'POPULAR',
      badgeClass: 'badge-sale',
      rating: 4.9,
      reviews: 92,
      image: 'images/products/shoes/sh2.png',
      desc: 'Rearfoot GEL cushioning with X-GUIDANCE flex grooves for rapid diagonal court movements.'
    },
    // 3. Yonex Aerus Z2 Ultra-Light Cyan (sh3.png)
    {
      id: 303,
      brand: 'Yonex',
      name: 'Yonex Aerus Z2 Ultra-Light Cyan',
      sole: 'Feather Bounce',
      fit: 'Unisex',
      price: 48500,
      oldPrice: 54000,
      badge: 'LIGHTEST',
      badgeClass: 'badge-new',
      rating: 4.9,
      reviews: 62,
      image: 'images/products/shoes/sh3.png',
      desc: 'Yonex lightest badminton shoe at 240g engineered for ultra-fast footwork and jump smashes.'
    },
    // 4. Yonex Power Cushion 65Z3 Red Edition (sh4.png)
    {
      id: 304,
      brand: 'Yonex',
      name: 'Yonex Power Cushion 65Z3 Red Edition',
      sole: 'Power Cushion+',
      fit: 'Men',
      price: 46900,
      oldPrice: 53000,
      badge: 'TOURNAMENT',
      badgeClass: 'badge-hot',
      rating: 5.0,
      reviews: 78,
      image: 'images/products/shoes/sh4.png',
      desc: 'Tournament edition 65Z3 with Power Graphite Sheet for midfoot stability during high impact landings.'
    },
    // 5. Li-Ning Ranger VI Pro Red/Black (sh5.jpeg)
    {
      id: 305,
      brand: 'Li-Ning',
      name: 'Li-Ning Ranger VI Pro Red/Black',
      sole: 'BounSe+ Rubber',
      fit: 'Men',
      price: 39500,
      oldPrice: 44000,
      badge: 'BESTSELLER',
      badgeClass: 'badge-sale',
      rating: 4.9,
      reviews: 54,
      image: 'images/products/shoes/sh5.jpeg',
      desc: 'Carbon fiber arch support plate paired with non-marking gum rubber sole for aggressive lunges.'
    },
    // 6. Li-Ning Saga II SE Stability (sh6.jpeg)
    {
      id: 306,
      brand: 'Li-Ning',
      name: 'Li-Ning Saga II SE Stability',
      sole: 'Cushion Foam',
      fit: 'Unisex',
      price: 31000,
      oldPrice: 35000,
      badge: 'HIGH STABILITY',
      badgeClass: 'badge-sale',
      rating: 4.8,
      reviews: 41,
      image: 'images/products/shoes/sh6.jpeg',
      desc: 'Lateral claw TPU stabilizer preventing ankle rolls during fast direction changes on wood/mat courts.'
    },
    // 7. Victor P9200III Crown Collection (sh7.jpeg)
    {
      id: 307,
      brand: 'Victor',
      name: 'Victor P9200III Crown Collection',
      sole: 'EnergyMax 3.0',
      fit: 'Men',
      price: 46000,
      oldPrice: 51500,
      badge: 'SUPREME CUSHION',
      badgeClass: 'badge-hot',
      rating: 5.0,
      reviews: 79,
      image: 'images/products/shoes/sh7.jpeg',
      desc: 'Heavy cushion shock absorbing heel pod designed for maximum knee protection during jumping smashes.'
    },
    // 8. Victor A970ACE All-Around Speed (sh8.jpeg)
    {
      id: 308,
      brand: 'Victor',
      name: 'Victor A970ACE All-Around Speed',
      sole: 'HYPEREVA Foam',
      fit: 'Women',
      price: 42000,
      oldPrice: 47000,
      badge: 'NEW',
      badgeClass: 'badge-new',
      rating: 4.8,
      reviews: 35,
      image: 'images/products/shoes/sh8.jpeg',
      desc: 'HYPEREVA lightweight foam mid-sole wrapped in durable micro-fiber PU leather upper.'
    },
    // 9. Mizuno Wave Claw 2 Special Edition (sh9.jpeg)
    {
      id: 309,
      brand: 'Mizuno',
      name: 'Mizuno Wave Claw 2 Special Edition',
      sole: 'Mizuno Wave',
      fit: 'Men',
      price: 44000,
      oldPrice: 49000,
      badge: 'POWER GRIP',
      badgeClass: 'badge-hot',
      rating: 4.9,
      reviews: 58,
      image: 'images/products/shoes/sh9.jpeg',
      desc: 'Wave plate technology disperses impact forces evenly while maintaining maximum court response.'
    },
    // 10. Yonex Power Cushion Eclipsion Z3 (sh10.jpeg)
    {
      id: 310,
      brand: 'Yonex',
      name: 'Yonex Power Cushion Eclipsion Z3',
      sole: 'Radial Blade',
      fit: 'Women',
      price: 49900,
      oldPrice: 55000,
      badge: 'FLAGSHIP',
      badgeClass: 'badge-hot',
      rating: 5.0,
      reviews: 48,
      image: 'images/products/shoes/sh10.png',
      desc: 'Semi-one-piece sole structure providing unmatched lateral stability and court grip.'
    },
    // 11. Li-Ning Halberd V Junior Court (sh11.jpeg)
    {
      id: 311,
      brand: 'Li-Ning',
      name: 'Li-Ning Halberd V Junior Court',
      sole: 'Non-Marking Gum',
      fit: 'Junior',
      price: 18500,
      oldPrice: 22000,
      badge: 'JUNIOR PICK',
      badgeClass: 'badge-sale',
      rating: 4.7,
      reviews: 29,
      image: 'images/products/shoes/sh11.jpeg',
      desc: 'Specialized junior support shoe featuring extra toe anti-abrasion rubber guards for young players.'
    },
    // 12. Yonex Court Trace All-Court Black (sh12.jpeg)
    {
      id: 312,
      brand: 'Yonex',
      name: 'Yonex Court Trace All-Court Black',
      sole: 'Hexagrip Sole',
      fit: 'Men',
      price: 29500,
      oldPrice: 34000,
      badge: 'ALL COURT',
      badgeClass: 'badge-new',
      rating: 4.7,
      reviews: 36,
      image: 'images/products/shoes/sh12.jpeg',
      desc: 'Hexagrip sole pattern provides 3% more grip and is 20% lighter than standard sole materials.'
    },
    // 13. Victor S82 Speed Series Gold (sh13.jpeg)
    {
      id: 313,
      brand: 'Victor',
      name: 'Victor S82 Speed Series Gold',
      sole: 'V-Durable+',
      fit: 'Unisex',
      price: 43500,
      oldPrice: 48500,
      badge: 'SPEED TECH',
      badgeClass: 'badge-hot',
      rating: 4.9,
      reviews: 51,
      image: 'images/products/shoes/sh13.jpeg',
      desc: 'Carbon Power sheet provides midfoot torsional rigidity and instant energy return.'
    },
    // 14. Asics Gel-Rocket 10 Indoor Blue (sh14.jpeg)
    {
      id: 314,
      brand: 'Asics',
      name: 'Asics Gel-Rocket 10 Indoor Blue',
      sole: 'Trusstic System',
      fit: 'Men',
      price: 24500,
      oldPrice: 28000,
      badge: 'VALUE CHOICE',
      badgeClass: 'badge-sale',
      rating: 4.8,
      reviews: 104,
      image: 'images/products/shoes/sh14.jpeg',
      desc: 'Multi-purpose indoor court shoe with Trusstic technology for midfoot support during quick cuts.'
    }
  ];

  let activeFilters = {
    brands: [],
    fits: [],
    maxPrice: 60000,
    search: '',
    sort: 'featured'
  };

  let cart = [];
  let wishlist = [];

  const shoesGrid = document.getElementById('shoesGrid');
  const shoesCount = document.getElementById('shoesCount');
  const priceSlider = document.getElementById('priceSlider');
  const priceDisplay = document.getElementById('priceDisplay');
  const shoesSearchInput = document.getElementById('shoesSearchInput');
  const sortSelect = document.getElementById('sortSelect');
  const activeFiltersBar = document.getElementById('activeFiltersBar');

  function formatLKR(num) { return 'Rs. ' + num.toLocaleString('en-US'); }

  function getFilteredShoes() {
    return shoesData.filter(item => {
      // Brand Filter
      if (activeFilters.brands.length > 0 && !activeFilters.brands.includes(item.brand)) return false;

      // Fit Filter
      if (activeFilters.fits.length > 0 && !activeFilters.fits.includes(item.fit)) return false;

      // Price Slider Filter
      if (item.price > activeFilters.maxPrice) return false;

      // Search Query Filter
      if (activeFilters.search) {
        const q = activeFilters.search.toLowerCase();
        if (!item.name.toLowerCase().includes(q) && !item.brand.toLowerCase().includes(q) && !item.sole.toLowerCase().includes(q)) return false;
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
    const list = getFilteredShoes();

    // Update Counter
    if (shoesCount) shoesCount.textContent = list.length;

    // Render Active Filter Badges
    renderActiveBadges();

    if (!shoesGrid) return;

    if (list.length === 0) {
      shoesGrid.innerHTML = `
        <div class="col-12 text-center py-5">
          <i class="bi bi-funnel display-1 text-muted opacity-50 mb-3"></i>
          <h4 class="fw-bold text-navy">No Court Shoes Match Your Filter</h4>
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
    shoesGrid.innerHTML = list.map(item => {
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
              <span class="racket-spec-tag tag-speed">${item.sole}</span>
              <span class="racket-spec-tag">${item.fit} Fit</span>
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
    shoesGrid.querySelectorAll('.btn-add-cart').forEach(b => {
      b.onclick = (e) => addToCart(parseInt(e.currentTarget.getAttribute('data-id')));
    });

    shoesGrid.querySelectorAll('.btn-quick-view').forEach(b => {
      b.onclick = (e) => openQuickView(parseInt(e.currentTarget.getAttribute('data-id')));
    });

    shoesGrid.querySelectorAll('.wishlist-toggle-btn').forEach(b => {
      b.onclick = (e) => toggleWishlist(parseInt(e.currentTarget.getAttribute('data-id')));
    });
  }

  function renderActiveBadges() {
    if (!activeFiltersBar) return;
    const badges = [];

    activeFilters.brands.forEach(b => badges.push({ type: 'brand', val: b, label: `Brand: ${b}` }));
    activeFilters.fits.forEach(f => badges.push({ type: 'fit', val: f, label: `Fit: ${f}` }));

    if (activeFilters.maxPrice < 60000) {
      badges.push({ type: 'maxPrice', val: 60000, label: `Max: ${formatLKR(activeFilters.maxPrice)}` });
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
    } else if (type === 'fit') {
      activeFilters.fits = activeFilters.fits.filter(f => f !== val);
      document.querySelectorAll(`.fitCheck[value="${val}"]`).forEach(c => c.checked = false);
    } else if (type === 'maxPrice') {
      activeFilters.maxPrice = 60000;
      if (priceSlider) priceSlider.value = 60000;
      if (priceDisplay) priceDisplay.textContent = formatLKR(60000);
    } else if (type === 'search') {
      activeFilters.search = '';
      if (shoesSearchInput) shoesSearchInput.value = '';
    }
    renderGrid();
  }

  function resetAllFilters() {
    activeFilters = {
      brands: [],
      fits: [],
      maxPrice: 60000,
      search: '',
      sort: 'featured'
    };

    document.querySelectorAll('.brandCheck, .fitCheck').forEach(cb => cb.checked = false);
    if (priceSlider) priceSlider.value = 60000;
    if (priceDisplay) priceDisplay.textContent = formatLKR(60000);
    if (shoesSearchInput) shoesSearchInput.value = '';
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

  // FIT CHECKBOXES
  document.querySelectorAll('.fitCheck').forEach(cb => {
    cb.onchange = (e) => {
      const val = e.target.value;
      if (e.target.checked) {
        if (!activeFilters.fits.includes(val)) activeFilters.fits.push(val);
      } else {
        activeFilters.fits = activeFilters.fits.filter(f => f !== val);
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
  if (shoesSearchInput) {
    shoesSearchInput.oninput = (e) => {
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
    const item = shoesData.find(s => s.id === id);
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
          <small>Explore our shoes category to add products.</small>
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
    const item = shoesData.find(s => s.id === id);
    if (!item) return;

    document.getElementById('quickViewImage').src = item.image;
    document.getElementById('quickViewCategory').textContent = item.brand;
    document.getElementById('quickViewTitle').textContent = item.name;
    document.getElementById('quickViewPrice').textContent = formatLKR(item.price);
    document.getElementById('quickViewOldPrice').textContent = formatLKR(item.oldPrice);
    document.getElementById('quickViewDesc').textContent = `${item.desc} Sole Technology: ${item.sole}, Gender Fit: ${item.fit} Court Fit.`;

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
  fetch('api/get_products.php?category=shoes')
    .then(res => res.json())
    .then(data => {
      if (data.status === 'success' && data.products && data.products.length > 0) {
        shoesData = data.products.map(p => ({
          id: p.id,
          brand: p.brand,
          name: p.name,
          sole: p.spec_1 || 'Power Cushion+',
          fit: p.spec_2 || 'Unisex Fit',
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
    .catch(err => console.log('Static fallback active for shoes'));

  // INITIAL RENDER
  renderGrid();
});
