/**
 * SmashZone - Badminton Rackets Category JavaScript
 * 17 Real-World Racket Products mapped 1-to-1 to user-supplied images in images/products/rackets/
 * Homepage Product Card Design & Fully Functional Clear All Filters Button.
 */

document.addEventListener('DOMContentLoaded', () => {
  let racketsData = [
    // 1. Yonex Astrox 100ZZ Kurenai (r1.png)
    {
      id: 101,
      brand: 'Yonex',
      name: 'Yonex Astrox 100ZZ Kurenai',
      level: 'Advanced',
      price: 84500,
      oldPrice: 94000,
      badge: 'PRO CHOICE',
      badgeClass: 'badge-hot',
      rating: 5.0,
      reviews: 98,
      balance: 'Head Heavy',
      flex: 'Extra Stiff',
      weight: '4U (83g)',
      tension: '28 lbs',
      image: 'images/products/rackets/r1.png',
      desc: 'Flagship Astrox 100ZZ with Hyper Slim Shaft and Namd graphite for steep smashes.'
    },
    // 2. Yonex Nanoflare 800 Game (r2.png)
    {
      id: 102,
      brand: 'Yonex',
      name: 'Yonex Nanoflare 800 Game',
      level: 'Intermediate',
      price: 42900,
      oldPrice: 48000,
      badge: 'POPULAR',
      badgeClass: 'badge-new',
      rating: 4.8,
      reviews: 64,
      balance: 'Head Light',
      flex: 'Medium',
      weight: '4U (83g)',
      tension: '27 lbs',
      image: 'images/products/rackets/r2.png',
      desc: 'Lightning-fast drive rallies and rapid court movements.'
    },
    // 3. Li-Ning Axforce 90 Max Dragon (r3.png)
    {
      id: 103,
      brand: 'Li-Ning',
      name: 'Li-Ning Axforce 90 Max Dragon',
      level: 'Advanced',
      price: 78500,
      oldPrice: 86000,
      badge: 'FLAGSHIP',
      badgeClass: 'badge-hot',
      rating: 5.0,
      reviews: 82,
      balance: 'Head Heavy',
      flex: 'Stiff',
      weight: '4U (83g)',
      tension: '31 lbs',
      image: 'images/products/rackets/r3.png',
      desc: 'Built with M50 super high-elastic carbon fiber for explosive power.'
    },
    // 4. Li-Ning 3D Calibar 900B (r4.png)
    {
      id: 104,
      brand: 'Li-Ning',
      name: 'Li-Ning 3D Calibar 900B',
      level: 'Advanced',
      price: 62000,
      oldPrice: 69000,
      badge: 'TOP RATED',
      badgeClass: 'badge-new',
      rating: 4.9,
      reviews: 59,
      balance: 'Even Balance',
      flex: 'Stiff',
      weight: '3U (87g)',
      tension: '30 lbs',
      image: 'images/products/rackets/r4.png',
      desc: '3D Calibar geometric airflow frame reduces air resistance.'
    },
    // 5. Hundred Battle 600 Power (r5.png)
    {
      id: 105,
      brand: 'Hundred',
      name: 'Hundred Battle 600 Power',
      level: 'Advanced',
      price: 38500,
      oldPrice: 44000,
      badge: 'POWER SMASH',
      badgeClass: 'badge-hot',
      rating: 4.9,
      reviews: 51,
      balance: 'Head Heavy',
      flex: 'Stiff',
      weight: '3U (86g)',
      tension: '32 lbs',
      image: 'images/products/rackets/r5.png',
      desc: 'VaporShaft XS technology delivers maximum kinetic transfer.'
    },
    // 6. Wish Fusion 990 Graphite (r6.png)
    {
      id: 106,
      brand: 'Wish',
      name: 'Wish Fusion 990 Graphite',
      level: 'Intermediate',
      price: 18900,
      oldPrice: 22500,
      badge: 'GREAT VALUE',
      badgeClass: 'badge-sale',
      rating: 4.7,
      reviews: 46,
      balance: 'Even Balance',
      flex: 'Medium',
      weight: '4U (83g)',
      tension: '26 lbs',
      image: 'images/products/rackets/r6.png',
      desc: 'Full graphite construction for smooth control.'
    },
    // 7. Maxbolt Black Woven Edition (r7.png)
    {
      id: 107,
      brand: 'Maxbolt',
      name: 'Maxbolt Black Woven Edition',
      level: 'Advanced',
      price: 52000,
      oldPrice: 59000,
      badge: 'WOVEN TECH',
      badgeClass: 'badge-hot',
      rating: 4.9,
      reviews: 67,
      balance: 'Head Heavy',
      flex: 'Stiff',
      weight: '4U (83g)',
      tension: '35 lbs',
      image: 'images/products/rackets/r7.png',
      desc: 'Japanese Woven Graphite for 35 lbs high tension.'
    },
    // 8. Yonex Arcsaber 11 Pro (r8.jpeg)
    {
      id: 108,
      brand: 'Yonex',
      name: 'Yonex Arcsaber 11 Pro',
      level: 'Advanced',
      price: 79000,
      oldPrice: 87500,
      badge: 'BESTSELLER',
      badgeClass: 'badge-sale',
      rating: 4.9,
      reviews: 92,
      balance: 'Even Balance',
      flex: 'Stiff',
      weight: '3U (88g)',
      tension: '28 lbs',
      image: 'images/products/rackets/r8.jpeg',
      desc: 'Decisive shuttle control and surgical precision pin-point drop shots.'
    },
    // 9. Li-Ning Halbertec 8000 (r9.jpeg)
    {
      id: 109,
      brand: 'Li-Ning',
      name: 'Li-Ning Halbertec 8000',
      level: 'Intermediate',
      price: 46500,
      oldPrice: 52000,
      badge: 'NEW ARRIVAL',
      badgeClass: 'badge-new',
      rating: 4.8,
      reviews: 41,
      balance: 'Head Heavy',
      flex: 'Medium',
      weight: '4U (84g)',
      tension: '30 lbs',
      image: 'images/products/rackets/r9.jpeg',
      desc: 'Balanced control and high-modulus carbon tubing.'
    },
    // 10. Hundred Atomic X 90 (r10.jpeg)
    {
      id: 110,
      brand: 'Hundred',
      name: 'Hundred Atomic X 90',
      level: 'Intermediate',
      price: 24500,
      oldPrice: 28900,
      badge: 'BESTSELLER',
      badgeClass: 'badge-sale',
      rating: 4.8,
      reviews: 71,
      balance: 'Even Balance',
      flex: 'Medium',
      weight: '4U (82g)',
      tension: '30 lbs',
      image: 'images/products/rackets/r10.jpeg',
      desc: 'Atomic power carbon build for speed and flat drives.'
    },
    // 11. Maxbolt Gallant Tour (r11.jpeg)
    {
      id: 111,
      brand: 'Maxbolt',
      name: 'Maxbolt Gallant Tour',
      level: 'Advanced',
      price: 44500,
      oldPrice: 51000,
      badge: 'PRO SMASH',
      badgeClass: 'badge-new',
      rating: 4.9,
      reviews: 50,
      balance: 'Head Heavy',
      flex: 'Extra Stiff',
      weight: '3U (87g)',
      tension: '35 lbs',
      image: 'images/products/rackets/r11.jpeg',
      desc: 'Heavy-duty attack racquet with boxed frame profile.'
    },
    // 12. Yonex Muscle Power 29 Light (r12.jpeg)
    {
      id: 112,
      brand: 'Yonex',
      name: 'Yonex Muscle Power 29 Light',
      level: 'Beginner',
      price: 16500,
      oldPrice: 19500,
      badge: 'VALUE',
      badgeClass: 'badge-new',
      rating: 4.7,
      reviews: 43,
      balance: 'Even Balance',
      flex: 'Flexible',
      weight: '4U (83g)',
      tension: '24 lbs',
      image: 'images/products/rackets/r12.jpeg',
      desc: 'Durable isometric frame with forgiving sweet spot.'
    },
    // 13. Li-Ning Windstorm 72 Ultra-Light (r13.jpeg)
    {
      id: 113,
      brand: 'Li-Ning',
      name: 'Li-Ning Windstorm 72 Ultra-Light',
      level: 'Intermediate',
      price: 29900,
      oldPrice: 34500,
      badge: 'FEATHER LIGHT',
      badgeClass: 'badge-sale',
      rating: 4.9,
      reviews: 112,
      balance: 'Head Heavy',
      flex: 'Flexible',
      weight: '6U (72g)',
      tension: '30 lbs',
      image: 'images/products/rackets/r13.jpeg',
      desc: 'Ultra-lightweight 72g frame for fast net intercepts.'
    },
    // 14. Hundred N-Force 100 Attack (r14.jpeg)
    {
      id: 114,
      brand: 'Hundred',
      name: 'Hundred N-Force 100 Attack',
      level: 'Intermediate',
      price: 19500,
      oldPrice: 23000,
      badge: '-15%',
      badgeClass: 'badge-sale',
      rating: 4.7,
      reviews: 38,
      balance: 'Head Heavy',
      flex: 'Medium',
      weight: '4U (83g)',
      tension: '32 lbs',
      image: 'images/products/rackets/r14.jpeg',
      desc: 'Heavy-head offensive design supporting string tension up to 32 lbs.'
    },
    // 15. Wish Alumtec 317 Set (r15.jpeg)
    {
      id: 115,
      brand: 'Wish',
      name: 'Wish Alumtec 317 Set',
      level: 'Beginner',
      price: 8500,
      oldPrice: 10500,
      badge: 'BUDGET STARTER',
      badgeClass: 'badge-sale',
      rating: 4.5,
      reviews: 55,
      balance: 'Head Light',
      flex: 'Flexible',
      weight: '5U (90g)',
      tension: '20 lbs',
      image: 'images/products/rackets/r15.jpeg',
      desc: 'Durable aluminum-steel set for casual practice.'
    },
    // 16. Maxbolt Woven Tech 90 (r16.jpeg)
    {
      id: 116,
      brand: 'Maxbolt',
      name: 'Maxbolt Woven Tech 90',
      level: 'Intermediate',
      price: 29500,
      oldPrice: 34000,
      badge: 'BESTSELLER',
      badgeClass: 'badge-sale',
      rating: 4.8,
      reviews: 58,
      balance: 'Even Balance',
      flex: 'Medium',
      weight: '4U (83g)',
      tension: '33 lbs',
      image: 'images/products/rackets/r16.jpeg',
      desc: 'Snappy frame rebound and high tension capacity.'
    },
    // 17. Wish X-Caliber 500 (r17.jpeg)
    {
      id: 117,
      brand: 'Wish',
      name: 'Wish X-Caliber 500',
      level: 'Intermediate',
      price: 21500,
      oldPrice: 25000,
      badge: 'HOT DEAL',
      badgeClass: 'badge-hot',
      rating: 4.8,
      reviews: 40,
      balance: 'Head Heavy',
      flex: 'Medium',
      weight: '4U (84g)',
      tension: '26 lbs',
      image: 'images/products/rackets/r17.jpeg',
      desc: 'Aero-dynamic frame with vibration dampening.'
    }
  ];

  let activeFilters = {
    brands: [],
    levels: [],
    balance: [],
    priceRanges: [],
    maxPrice: 100000,
    search: '',
    sort: 'featured'
  };

  let cart = [];
  let wishlist = [];

  const racketGrid = document.getElementById('racketGrid');
  const racketCount = document.getElementById('racketCount');
  const priceSlider = document.getElementById('priceSlider');
  const priceDisplay = document.getElementById('priceDisplay');
  const racketSearchInput = document.getElementById('racketSearchInput');
  const sortSelect = document.getElementById('sortSelect');
  const activeFiltersBar = document.getElementById('activeFiltersBar');

  function formatLKR(num) { return 'Rs. ' + num.toLocaleString('en-US'); }

  function getFilteredRackets() {
    return racketsData.filter(item => {
      // Filter Brands
      if (activeFilters.brands.length > 0 && !activeFilters.brands.includes(item.brand)) return false;
      
      // Filter Levels
      if (activeFilters.levels.length > 0 && !activeFilters.levels.includes(item.level)) return false;

      // Filter Balance
      if (activeFilters.balance.length > 0 && !activeFilters.balance.includes(item.balance)) return false;

      // Price Slider
      if (item.price > activeFilters.maxPrice) return false;

      // Price Presets
      if (activeFilters.priceRanges.length > 0) {
        let matchPrice = false;
        if (activeFilters.priceRanges.includes('budget') && item.price < 20000) matchPrice = true;
        if (activeFilters.priceRanges.includes('mid') && item.price >= 20000 && item.price <= 45000) matchPrice = true;
        if (activeFilters.priceRanges.includes('high') && item.price > 45000 && item.price <= 75000) matchPrice = true;
        if (activeFilters.priceRanges.includes('pro') && item.price > 75000) matchPrice = true;
        if (!matchPrice) return false;
      }

      // Search Query
      if (activeFilters.search) {
        const q = activeFilters.search.toLowerCase();
        if (!item.name.toLowerCase().includes(q) && !item.brand.toLowerCase().includes(q)) return false;
      }

      return true;
    }).sort((a, b) => {
      if (activeFilters.sort === 'price-low') return a.price - b.price;
      if (activeFilters.sort === 'price-high') return b.price - a.price;
      if (activeFilters.sort === 'rating') return b.rating - a.rating;
      if (activeFilters.sort === 'newest') return b.id - a.id;
      return 0;
    });
  }

  function renderRacketGrid() {
    const list = getFilteredRackets();

    // Update Counter
    if (racketCount) racketCount.textContent = list.length;

    // Render Active Badges Bar
    renderActiveFiltersBar();

    if (!racketGrid) return;

    if (list.length === 0) {
      racketGrid.innerHTML = `
        <div class="col-12 text-center py-5">
          <i class="bi bi-funnel display-1 text-muted opacity-50 mb-3"></i>
          <h4 class="fw-bold text-navy">No Badminton Rackets Found</h4>
          <p class="text-muted mb-3">Try adjusting your filters, price range slider, or search term.</p>
          <button id="noResultsResetBtn" class="btn btn-brand-orange rounded-pill px-4">
            <i class="bi bi-arrow-counterclockwise me-1"></i> Reset All Filters
          </button>
        </div>
      `;
      document.getElementById('noResultsResetBtn')?.addEventListener('click', resetAllFilters);
      return;
    }

    // Render Exact Homepage Card HTML Markup
    racketGrid.innerHTML = list.map(item => {
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
              <span class="racket-spec-tag tag-heavy">${item.balance}</span>
              <span class="racket-spec-tag">${item.level}</span>
              <span class="racket-spec-tag">${item.weight}</span>
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

    // Attach Event Listeners to Buttons
    racketGrid.querySelectorAll('.btn-add-cart').forEach(b => {
      b.onclick = (e) => addToCart(parseInt(e.currentTarget.getAttribute('data-id')));
    });

    racketGrid.querySelectorAll('.btn-quick-view').forEach(b => {
      b.onclick = (e) => openQuickView(parseInt(e.currentTarget.getAttribute('data-id')));
    });

    racketGrid.querySelectorAll('.wishlist-toggle-btn').forEach(b => {
      b.onclick = (e) => toggleWishlist(parseInt(e.currentTarget.getAttribute('data-id')));
    });
  }

  function renderActiveFiltersBar() {
    if (!activeFiltersBar) return;
    const badges = [];

    activeFilters.brands.forEach(b => badges.push({ type: 'brand', val: b, label: `Brand: ${b}` }));
    activeFilters.levels.forEach(l => badges.push({ type: 'level', val: l, label: `Level: ${l}` }));
    activeFilters.balance.forEach(bal => badges.push({ type: 'balance', val: bal, label: `Balance: ${bal}` }));
    activeFilters.priceRanges.forEach(p => badges.push({ type: 'priceRange', val: p, label: `Price: ${p}` }));

    if (activeFilters.maxPrice < 100000) {
      badges.push({ type: 'maxPrice', val: 100000, label: `Max: ${formatLKR(activeFilters.maxPrice)}` });
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
        removeSingleFilter(type, val);
      };
    });
  }

  function removeSingleFilter(type, val) {
    if (type === 'brand') {
      activeFilters.brands = activeFilters.brands.filter(b => b !== val);
      document.querySelectorAll(`.brandCheck[value="${val}"]`).forEach(c => c.checked = false);
    } else if (type === 'level') {
      activeFilters.levels = activeFilters.levels.filter(l => l !== val);
      document.querySelectorAll(`.levelCheck[value="${val}"]`).forEach(c => c.checked = false);
    } else if (type === 'balance') {
      activeFilters.balance = activeFilters.balance.filter(b => b !== val);
      document.querySelectorAll(`.balanceCheck[value="${val}"]`).forEach(c => c.checked = false);
    } else if (type === 'priceRange') {
      activeFilters.priceRanges = activeFilters.priceRanges.filter(p => p !== val);
      document.querySelectorAll(`.priceCheck[value="${val}"]`).forEach(c => c.checked = false);
    } else if (type === 'maxPrice') {
      activeFilters.maxPrice = 100000;
      if (priceSlider) priceSlider.value = 100000;
      if (priceDisplay) priceDisplay.textContent = formatLKR(100000);
    } else if (type === 'search') {
      activeFilters.search = '';
      if (racketSearchInput) racketSearchInput.value = '';
    }
    renderRacketGrid();
  }

  // CLEAR ALL FILTERS FUNCTIONALITY
  function resetAllFilters() {
    activeFilters = {
      brands: [],
      levels: [],
      balance: [],
      priceRanges: [],
      maxPrice: 100000,
      search: '',
      sort: 'featured'
    };

    // 1. Uncheck all checkboxes
    document.querySelectorAll('.brandCheck, .levelCheck, .balanceCheck, .priceCheck').forEach(cb => {
      cb.checked = false;
    });

    // 2. Reset price slider
    if (priceSlider) priceSlider.value = 100000;
    if (priceDisplay) priceDisplay.textContent = formatLKR(100000);

    // 3. Reset search inputs
    if (racketSearchInput) racketSearchInput.value = '';

    // 4. Reset sort select
    if (sortSelect) sortSelect.value = 'featured';

    // 5. Re-render
    renderRacketGrid();
  }

  // CONNECT CLEAR ALL BUTTONS
  document.getElementById('clearFiltersBtn')?.addEventListener('click', resetAllFilters);
  document.getElementById('mobileClearFiltersBtn')?.addEventListener('click', resetAllFilters);

  // BRAND CHECKBOX LISTENERS
  document.querySelectorAll('.brandCheck').forEach(cb => {
    cb.onchange = (e) => {
      const val = e.target.value;
      if (e.target.checked) {
        if (!activeFilters.brands.includes(val)) activeFilters.brands.push(val);
      } else {
        activeFilters.brands = activeFilters.brands.filter(b => b !== val);
      }
      renderRacketGrid();
    };
  });

  // LEVEL CHECKBOX LISTENERS
  document.querySelectorAll('.levelCheck').forEach(cb => {
    cb.onchange = (e) => {
      const val = e.target.value;
      if (e.target.checked) {
        if (!activeFilters.levels.includes(val)) activeFilters.levels.push(val);
      } else {
        activeFilters.levels = activeFilters.levels.filter(l => l !== val);
      }
      renderRacketGrid();
    };
  });

  // BALANCE CHECKBOX LISTENERS
  document.querySelectorAll('.balanceCheck').forEach(cb => {
    cb.onchange = (e) => {
      const val = e.target.value;
      if (e.target.checked) {
        if (!activeFilters.balance.includes(val)) activeFilters.balance.push(val);
      } else {
        activeFilters.balance = activeFilters.balance.filter(b => b !== val);
      }
      renderRacketGrid();
    };
  });

  // PRICE PRESET CHECKBOX LISTENERS
  document.querySelectorAll('.priceCheck').forEach(cb => {
    cb.onchange = (e) => {
      const val = e.target.value;
      if (e.target.checked) {
        if (!activeFilters.priceRanges.includes(val)) activeFilters.priceRanges.push(val);
      } else {
        activeFilters.priceRanges = activeFilters.priceRanges.filter(p => p !== val);
      }
      renderRacketGrid();
    };
  });

  // PRICE SLIDER INPUT
  if (priceSlider) {
    priceSlider.oninput = (e) => {
      activeFilters.maxPrice = parseInt(e.target.value);
      if (priceDisplay) priceDisplay.textContent = formatLKR(activeFilters.maxPrice);
      renderRacketGrid();
    };
  }

  // SEARCH INPUT
  if (racketSearchInput) {
    racketSearchInput.oninput = (e) => {
      activeFilters.search = e.target.value.trim();
      renderRacketGrid();
    };
  }

  // SORT SELECT
  if (sortSelect) {
    sortSelect.onchange = (e) => {
      activeFilters.sort = e.target.value;
      renderRacketGrid();
    };
  }

  // ADD TO CART FUNCTIONALITY
  function addToCart(id) {
    const item = racketsData.find(r => r.id === id);
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
          <small>Explore our rackets category to add equipment.</small>
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

  // WISHLIST TOGGLE FUNCTIONALITY
  function toggleWishlist(id) {
    const idx = wishlist.indexOf(id);
    if (idx > -1) wishlist.splice(idx, 1);
    else wishlist.push(id);
    renderRacketGrid();
  }

  // QUICK VIEW MODAL FUNCTIONALITY
  function openQuickView(id) {
    const item = racketsData.find(r => r.id === id);
    if (!item) return;

    document.getElementById('quickViewImage').src = item.image;
    document.getElementById('quickViewCategory').textContent = item.brand;
    document.getElementById('quickViewTitle').textContent = item.name;
    document.getElementById('quickViewPrice').textContent = formatLKR(item.price);
    document.getElementById('quickViewOldPrice').textContent = formatLKR(item.oldPrice);
    document.getElementById('quickViewDesc').textContent = `${item.desc} Specifications: ${item.balance} Balance, ${item.flex} Flex, ${item.weight} Weight, Max String Tension: ${item.tension}.`;

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
  fetch('api/get_products.php?category=rackets')
    .then(res => res.json())
    .then(data => {
      if (data.status === 'success' && data.products && data.products.length > 0) {
        racketsData = data.products.map(p => ({
          id: p.id,
          brand: p.brand,
          name: p.name,
          level: p.spec_2 || 'Intermediate',
          price: p.price,
          oldPrice: p.oldPrice || p.price,
          badge: p.badge || 'NEW',
          badgeClass: p.badgeClass || 'badge-new',
          rating: p.rating || 5.0,
          reviews: p.reviews || 50,
          balance: p.spec_1 || 'Even Balance',
          flex: p.spec_2 || 'Medium',
          weight: p.spec_3 || '4U (83g)',
          tension: '28 lbs',
          image: p.image,
          desc: p.desc || p.description
        }));
        renderRacketGrid();
      }
    })
    .catch(err => console.log('Static fallback active for rackets'));

  // INITIAL RENDER
  renderRacketGrid();
});
