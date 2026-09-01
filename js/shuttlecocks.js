/**
 * SmashZone - Badminton Shuttlecocks Category JavaScript
 * 9 Real-World Shuttlecock products mapped 1-to-1 to images in images/products/Shuttlecocks/
 * Homepage Product Card Design & Fully Working Clear All Filters Button.
 */

document.addEventListener('DOMContentLoaded', () => {
  let shuttlecocksData = [
    // 1. Yonex Aero-Sensa 50 (s1.png)
    {
      id: 201,
      brand: 'Yonex',
      name: 'Yonex Aero-Sensa 50 (AS-50)',
      type: 'Feather',
      speed: 'Speed 77',
      usage: 'BWF Tournament',
      price: 18500,
      oldPrice: 21000,
      badge: 'BWF APPROVED',
      badgeClass: 'badge-hot',
      rating: 5.0,
      reviews: 128,
      image: 'images/products/Shuttlecocks/s1.png',
      desc: 'Official BWF Grade 1 goose feather shuttlecock engineered for international tournament play.'
    },
    // 2. Yonex Aero-Sensa 30 (s2.png)
    {
      id: 202,
      brand: 'Yonex',
      name: 'Yonex Aero-Sensa 30 (AS-30)',
      type: 'Feather',
      speed: 'Speed 77',
      usage: 'Club Play',
      price: 14200,
      oldPrice: 16500,
      badge: 'BESTSELLER',
      badgeClass: 'badge-sale',
      rating: 4.9,
      reviews: 95,
      image: 'images/products/Shuttlecocks/s2.png',
      desc: 'Tournament class goose feather shuttlecock with stable flight trajectory and high durability.'
    },
    // 3. Yonex Mavis 350 Nylon (s3.png)
    {
      id: 203,
      brand: 'Yonex',
      name: 'Yonex Mavis 350 Nylon (Pack of 6)',
      type: 'Nylon',
      speed: 'Speed 77',
      usage: 'Practice & Club',
      price: 6800,
      oldPrice: 7900,
      badge: 'HIGH DURABILITY',
      badgeClass: 'badge-new',
      rating: 4.8,
      reviews: 140,
      image: 'images/products/Shuttlecocks/s3.png',
      desc: 'Worlds leading synthetic shuttlecock with patented Wing Ribbon technology for feather-like flight.'
    },
    // 4. Li-Ning G900 Grand Prix Feather (s4.jpeg)
    {
      id: 204,
      brand: 'Li-Ning',
      name: 'Li-Ning G900 Grand Prix Feather',
      type: 'Feather',
      speed: 'Speed 77',
      usage: 'BWF Tournament',
      price: 17900,
      oldPrice: 19800,
      badge: 'NATIONAL TEAM',
      badgeClass: 'badge-hot',
      rating: 4.9,
      reviews: 64,
      image: 'images/products/Shuttlecocks/s4.jpeg',
      desc: 'Official match shuttlecock used by the China National Badminton Team in international play.'
    },
    // 5. Li-Ning A+300 Premium Feather (s5.jpeg)
    {
      id: 205,
      brand: 'Li-Ning',
      name: 'Li-Ning A+300 Premium Feather',
      type: 'Feather',
      speed: 'Speed 76',
      usage: 'Club Play',
      price: 12800,
      oldPrice: 14500,
      badge: 'POPULAR',
      badgeClass: 'badge-sale',
      rating: 4.8,
      reviews: 58,
      image: 'images/products/Shuttlecocks/s5.jpeg',
      desc: 'Selected premium duck feather shuttlecock offering exceptional flight consistency for club matches.'
    },
    // 6. Victor Master No. 1 Feather (s6.jpeg)
    {
      id: 206,
      brand: 'Victor',
      name: 'Victor Master No. 1 Feather',
      type: 'Feather',
      speed: 'Speed 77',
      usage: 'BWF Tournament',
      price: 16900,
      oldPrice: 18900,
      badge: 'TOP RATED',
      badgeClass: 'badge-hot',
      rating: 4.9,
      reviews: 73,
      image: 'images/products/Shuttlecocks/s6.jpeg',
      desc: 'BWF certified tournament goose shuttlecock with high-density natural cork base.'
    },
    // 7. Victor Carbosonic CS-No1 Synthetic (s7.jpeg)
    {
      id: 207,
      brand: 'Victor',
      name: 'Victor Carbosonic CS-No1 Synthetic',
      type: 'Nylon',
      speed: 'Speed 77',
      usage: 'Practice',
      price: 7500,
      oldPrice: 8800,
      badge: 'CARBON TECH',
      badgeClass: 'badge-new',
      rating: 4.7,
      reviews: 36,
      image: 'images/products/Shuttlecocks/s7.jpeg',
      desc: 'Revolutionary carbon foam feather stem structure delivering 300% longer practice lifespan.'
    },
    // 8. RSL Tourney No. 1 Feather (s8.jpeg)
    {
      id: 208,
      brand: 'RSL',
      name: 'RSL Tourney No. 1 Feather',
      type: 'Feather',
      speed: 'Speed 77',
      usage: 'BWF Tournament',
      price: 15800,
      oldPrice: 17900,
      badge: 'LEGENDARY',
      badgeClass: 'badge-sale',
      rating: 5.0,
      reviews: 110,
      image: 'images/products/Shuttlecocks/s8.jpeg',
      desc: 'World renowned tournament shuttlecock engineered for maximum flight precision and durability.'
    },
    // 9. Carlton AG 50 Tournament Feather (s9.jpeg)
    {
      id: 209,
      brand: 'Carlton',
      name: 'Carlton AG 50 Tournament Feather',
      type: 'Feather',
      speed: 'Speed 77',
      usage: 'BWF Tournament',
      price: 14900,
      oldPrice: 16800,
      badge: 'NEW',
      badgeClass: 'badge-new',
      rating: 4.7,
      reviews: 29,
      image: 'images/products/Shuttlecocks/s9.jpeg',
      desc: 'British-engineered tournament feather shuttlecocks featuring anti-fracture feather spine alignment.'
    }
  ];

  let activeFilters = {
    brands: [],
    types: [],
    usage: [],
    maxPrice: 25000,
    search: '',
    sort: 'featured'
  };

  let cart = [];
  let wishlist = [];

  const shuttleGrid = document.getElementById('shuttleGrid');
  const shuttleCount = document.getElementById('shuttleCount');
  const priceSlider = document.getElementById('priceSlider');
  const priceDisplay = document.getElementById('priceDisplay');
  const shuttleSearchInput = document.getElementById('shuttleSearchInput');
  const sortSelect = document.getElementById('sortSelect');
  const activeFiltersBar = document.getElementById('activeFiltersBar');

  function formatLKR(num) { return 'Rs. ' + num.toLocaleString('en-US'); }

  function getFilteredShuttles() {
    return shuttlecocksData.filter(item => {
      // Brand Filter
      if (activeFilters.brands.length > 0 && !activeFilters.brands.includes(item.brand)) return false;

      // Type Filter (Feather vs Nylon)
      if (activeFilters.types.length > 0 && !activeFilters.types.includes(item.type)) return false;

      // Usage Filter
      if (activeFilters.usage.length > 0 && !activeFilters.usage.includes(item.usage)) return false;

      // Price Slider Filter
      if (item.price > activeFilters.maxPrice) return false;

      // Search Query Filter
      if (activeFilters.search) {
        const q = activeFilters.search.toLowerCase();
        if (!item.name.toLowerCase().includes(q) && !item.brand.toLowerCase().includes(q) && !item.type.toLowerCase().includes(q)) return false;
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
    const list = getFilteredShuttles();

    // Update Shuttle Count
    if (shuttleCount) shuttleCount.textContent = list.length;

    // Render Active Filter Badges
    renderActiveBadges();

    if (!shuttleGrid) return;

    if (list.length === 0) {
      shuttleGrid.innerHTML = `
        <div class="col-12 text-center py-5">
          <i class="bi bi-funnel display-1 text-muted opacity-50 mb-3"></i>
          <h4 class="fw-bold text-navy">No Shuttlecocks Match Your Filter</h4>
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
    shuttleGrid.innerHTML = list.map(item => {
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
              <span class="racket-spec-tag tag-speed">${item.type}</span>
              <span class="racket-spec-tag">${item.speed}</span>
              <span class="racket-spec-tag">${item.usage}</span>
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
    shuttleGrid.querySelectorAll('.btn-add-cart').forEach(b => {
      b.onclick = (e) => addToCart(parseInt(e.currentTarget.getAttribute('data-id')));
    });

    shuttleGrid.querySelectorAll('.btn-quick-view').forEach(b => {
      b.onclick = (e) => openQuickView(parseInt(e.currentTarget.getAttribute('data-id')));
    });

    shuttleGrid.querySelectorAll('.wishlist-toggle-btn').forEach(b => {
      b.onclick = (e) => toggleWishlist(parseInt(e.currentTarget.getAttribute('data-id')));
    });
  }

  function renderActiveBadges() {
    if (!activeFiltersBar) return;
    const badges = [];

    activeFilters.brands.forEach(b => badges.push({ type: 'brand', val: b, label: `Brand: ${b}` }));
    activeFilters.types.forEach(t => badges.push({ type: 'type', val: t, label: `Type: ${t}` }));
    activeFilters.usage.forEach(u => badges.push({ type: 'usage', val: u, label: `Usage: ${u}` }));

    if (activeFilters.maxPrice < 25000) {
      badges.push({ type: 'maxPrice', val: 25000, label: `Max: ${formatLKR(activeFilters.maxPrice)}` });
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
    } else if (type === 'type') {
      activeFilters.types = activeFilters.types.filter(t => t !== val);
      document.querySelectorAll(`.typeCheck[value="${val}"]`).forEach(c => c.checked = false);
    } else if (type === 'usage') {
      activeFilters.usage = activeFilters.usage.filter(u => u !== val);
      document.querySelectorAll(`.usageCheck[value="${val}"]`).forEach(c => c.checked = false);
    } else if (type === 'maxPrice') {
      activeFilters.maxPrice = 25000;
      if (priceSlider) priceSlider.value = 25000;
      if (priceDisplay) priceDisplay.textContent = formatLKR(25000);
    } else if (type === 'search') {
      activeFilters.search = '';
      if (shuttleSearchInput) shuttleSearchInput.value = '';
    }
    renderGrid();
  }

  function resetAllFilters() {
    activeFilters = {
      brands: [],
      types: [],
      usage: [],
      maxPrice: 25000,
      search: '',
      sort: 'featured'
    };

    document.querySelectorAll('.brandCheck, .typeCheck, .usageCheck').forEach(cb => cb.checked = false);
    if (priceSlider) priceSlider.value = 25000;
    if (priceDisplay) priceDisplay.textContent = formatLKR(25000);
    if (shuttleSearchInput) shuttleSearchInput.value = '';
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

  // TYPE CHECKBOXES
  document.querySelectorAll('.typeCheck').forEach(cb => {
    cb.onchange = (e) => {
      const val = e.target.value;
      if (e.target.checked) {
        if (!activeFilters.types.includes(val)) activeFilters.types.push(val);
      } else {
        activeFilters.types = activeFilters.types.filter(t => t !== val);
      }
      renderGrid();
    };
  });

  // USAGE CHECKBOXES
  document.querySelectorAll('.usageCheck').forEach(cb => {
    cb.onchange = (e) => {
      const val = e.target.value;
      if (e.target.checked) {
        if (!activeFilters.usage.includes(val)) activeFilters.usage.push(val);
      } else {
        activeFilters.usage = activeFilters.usage.filter(u => u !== val);
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
  if (shuttleSearchInput) {
    shuttleSearchInput.oninput = (e) => {
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
    const item = shuttlecocksData.find(s => s.id === id);
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
          <small>Explore our shuttlecocks category to add products.</small>
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
    const item = shuttlecocksData.find(s => s.id === id);
    if (!item) return;

    document.getElementById('quickViewImage').src = item.image;
    document.getElementById('quickViewCategory').textContent = item.brand;
    document.getElementById('quickViewTitle').textContent = item.name;
    document.getElementById('quickViewPrice').textContent = formatLKR(item.price);
    document.getElementById('quickViewOldPrice').textContent = formatLKR(item.oldPrice);
    document.getElementById('quickViewDesc').textContent = `${item.desc} Specifications: ${item.type} Shuttlecock, Speed Rating: ${item.speed}, Tournament Grade: ${item.usage}.`;

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
  fetch('api/get_products.php?category=shuttlecocks')
    .then(res => res.json())
    .then(data => {
      if (data.status === 'success' && data.products && data.products.length > 0) {
        shuttlecocksData = data.products.map(p => ({
          id: p.id,
          brand: p.brand,
          name: p.name,
          type: p.spec_1 || 'Feather',
          speed: p.spec_2 || 'Speed 77',
          use: p.spec_3 || 'Tournament',
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
    .catch(err => console.log('Static fallback active for shuttlecocks'));

  // INITIAL RENDER
  renderGrid();
});
