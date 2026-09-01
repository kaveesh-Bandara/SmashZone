/**
 * SmashZone - Badminton Accessories Category JavaScript
 * 11 Real-World Accessories products mapped 1-to-1 to images in images/products/accesories/
 * Homepage Product Card Design & Fully Working Clear All Filters Button.
 */

document.addEventListener('DOMContentLoaded', () => {
  let accessoriesData = [
    // 1. Yonex BG66 Ultimax String Reel (200m) (a1.png)
    {
      id: 601,
      brand: 'Yonex',
      name: 'Yonex BG66 Ultimax String Reel (200m)',
      category: 'String Reel',
      feature: '0.65mm Gauge',
      price: 34500,
      oldPrice: 39000,
      badge: 'PRO CHOICE',
      badgeClass: 'badge-hot',
      rating: 5.0,
      reviews: 145,
      image: 'images/products/accesories/a1.png',
      desc: 'High-intensity nylon core string reel with thin 0.65mm gauge delivering maximum repulsion and crisp hitting sound.'
    },
    // 2. Yonex Aerosonic Badminton String Reel (Neon Blue)
    {
      id: 602,
      brand: 'Yonex',
      name: 'Yonex Aerosonic Badminton String Reel (Neon Blue)',
      category: 'String Reel',
      feature: '0.65mm Gauge',
      price: 24000,
      oldPrice: 29000,
      badge: 'BESTSELLER',
      badgeClass: 'badge-sale',
      rating: 5.0,
      reviews: 180,
      image: 'images/products/accesories/a2.jpeg',
      desc: 'High-intensity nylon core string reel with thin 0.65mm gauge delivering maximum repulsion and crisp hitting sound.'
    },
    // 3. Li-Ning GP1000 Overgrip Box (10-Pack Assorted) (a3.jpeg)
    {
      id: 603,
      brand: 'Li-Ning',
      name: 'Li-Ning GP1000 Overgrip Box (10-Pack Assorted)',
      category: 'Overgrips',
      feature: '0.6mm Perforated',
      price: 5900,
      oldPrice: 6800,
      badge: 'VALUE PACK',
      badgeClass: 'badge-sale',
      rating: 4.8,
      reviews: 88,
      image: 'images/products/accesories/a3.jpeg',
      desc: 'Durable polyurethane overgrips with micro-perforations for fast moisture absorption.'
    },
    // 4. Victor AC018 Cotton Sweat Headband Black (a4.jpeg)
    {
      id: 604,
      brand: 'Victor',
      name: 'Victor AC018 Cotton Sweat Headband Black',
      category: 'Headband / Wristband',
      feature: 'Elastic Terry Cotton',
      price: 2800,
      oldPrice: 2900,
      badge: 'POPULAR',
      badgeClass: 'badge-new',
      rating: 4.8,
      reviews: 56,
      image: 'images/products/accesories/a4.jpeg',
      desc: 'High density absorbent cotton headband preventing sweat from trickling into player eyes.'
    },
    // 5. Maxbolt Grip Powder (Specialized Chalk)
    {
      id: 605,
      brand: 'Maxbolt',
      name: 'Maxbolt Grip Powder (Specialized Chalk)',
      category: 'Grip Powder',
      feature: '',
      price: 2200,
      oldPrice: 2700,
      badge: 'SWEAT SHIELD',
      badgeClass: 'badge-hot',
      rating: 4.9,
      reviews: 67,
      image: 'images/products/accesories/a5.jpeg',
      desc: 'This composition uses a steep 45-degree angle to connect the product to its function.'
    },
    // 6. Vector Sports Stringing Care Kit (Brushes & Awl)
    {
      id: 606,
      brand: 'Victor',
      name: 'Victor Sports Stringing Care Kit (Brushes & Awl)',
      category: 'Care Kit',
      feature: '',
      price: 3200,
      oldPrice: 3800,
      badge: 'ANTI-SLIP',
      badgeClass: 'badge-hot',
      rating: 4.9,
      reviews: 72,
      image: 'images/products/accesories/a6.jpeg',
      desc: 'These require presentation of specific brush densities and ergonomic designs tailored for racket frames, demonstrating technical string care.'
    },
    // 7. Yonex Super Grap AC102 (3-Pack Roll)
    {
      id: 607,
      brand: 'Yonex',
      name: 'Yonex Super Grap AC102 (3-Pack Roll)',
      category: 'Overgrips',
      feature: '0.6mm Perforated',
      price: 2800,
      oldPrice: 3400,
      badge: 'COURT STYLE',
      badgeClass: 'badge-new',
      rating: 4.7,
      reviews: 39,
      image: 'images/products/accesories/a7.jpeg',
      desc: 'Durable polyurethane overgrips with micro-perforations for fast moisture absorption.'
    },
    // 8. Maxbolt Power Powder (Refill Bag)
    {
      id: 608,
      brand: 'Maxbolt',
      name: 'Maxbolt Power Powder (Refill Bag)',
      category: 'Grip powder',
      feature: '',
      price: 2900,
      oldPrice: 3500,
      badge: '',
      badgeClass: 'badge-sale',
      rating: 4.9,
      reviews: 94,
      image: 'images/products/accesories/a8.jpeg',
      desc: 'specialized powder must appear dry and particulate, similar to the bottle (image_67.png),'
    },
    // 9. Vector Sports Tournament Whistle & Band (Neon)(a9.jpeg)
    {
      id: 609,
      brand: 'Vector',
      name: 'Victor Sports Tournament Whistle & Band (Neon)',
      category: 'String Reel',
      feature: '0.65mm 3D Braid',
      price: 31000,
      oldPrice: 36000,
      badge: 'REPULSION POWER',
      badgeClass: 'badge-hot',
      rating: 4.8,
      reviews: 58,
      image: 'images/products/accesories/a9.jpeg',
      desc: 'The product must look specialized. The neon band must appear functional and highly elastic, while the metal whistle must be sharp and precise'
    },
    // 10. Li-Ning GC100 Towel Grip Roll (Yellow)(a10.jpeg)
    {
      id: 610,
      brand: 'Li-Ning',
      name: 'Li-Ning GC100 Towel Grip Roll (Yellow)',
      category: 'Grips',
      feature: '',
      price: 2100,
      oldPrice: 2600,
      badge: 'FRAME GUARD',
      badgeClass: 'badge-new',
      rating: 4.7,
      reviews: 43,
      image: 'images/products/accesories/a10.jpeg',
      desc: 'Towel grips must look fibrous, absorbent, and fuzzy, contrasting sharply with tacky polyurethane grips.'
    },
    // 11. Yonex Super Grap Overgrip 30-Pack Reel White (a11.png)
    {
      id: 611,
      brand: 'Yonex',
      name: 'Yonex Super Grap Overgrip 30-Pack Reel White',
      category: 'Overgrips',
      feature: '30-Grip Bulk Reel',
      price: 16500,
      oldPrice: 19500,
      badge: 'CLUB BULK PACK',
      badgeClass: 'badge-sale',
      rating: 5.0,
      reviews: 126,
      image: 'images/products/accesories/a11.png',
      desc: '30-grip mega reel container of genuine AC102EX Super Grap for tournament players and club stringers.'
    }
  ];

  let activeFilters = {
    brands: [],
    categories: [],
    maxPrice: 40000,
    search: '',
    sort: 'featured'
  };

  let cart = [];
  let wishlist = [];

  const accGrid = document.getElementById('accGrid');
  const accCount = document.getElementById('accCount');
  const priceSlider = document.getElementById('priceSlider');
  const priceDisplay = document.getElementById('priceDisplay');
  const accSearchInput = document.getElementById('accSearchInput');
  const sortSelect = document.getElementById('sortSelect');
  const activeFiltersBar = document.getElementById('activeFiltersBar');

  function formatLKR(num) { return 'Rs. ' + num.toLocaleString('en-US'); }

  function getFilteredAccessories() {
    return accessoriesData.filter(item => {
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
    const list = getFilteredAccessories();

    // Update Counter
    if (accCount) accCount.textContent = list.length;

    // Render Active Badges Bar
    renderActiveBadges();

    if (!accGrid) return;

    if (list.length === 0) {
      accGrid.innerHTML = `
        <div class="col-12 text-center py-5">
          <i class="bi bi-funnel display-1 text-muted opacity-50 mb-3"></i>
          <h4 class="fw-bold text-navy">No Badminton Accessories Match Your Filter</h4>
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
    accGrid.innerHTML = list.map(item => {
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
              <span class="racket-spec-tag">${item.feature}</span>
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
    accGrid.querySelectorAll('.btn-add-cart').forEach(b => {
      b.onclick = (e) => addToCart(parseInt(e.currentTarget.getAttribute('data-id')));
    });

    accGrid.querySelectorAll('.btn-quick-view').forEach(b => {
      b.onclick = (e) => openQuickView(parseInt(e.currentTarget.getAttribute('data-id')));
    });

    accGrid.querySelectorAll('.wishlist-toggle-btn').forEach(b => {
      b.onclick = (e) => toggleWishlist(parseInt(e.currentTarget.getAttribute('data-id')));
    });
  }

  function renderActiveBadges() {
    if (!activeFiltersBar) return;
    const badges = [];

    activeFilters.brands.forEach(b => badges.push({ type: 'brand', val: b, label: `Brand: ${b}` }));
    activeFilters.categories.forEach(c => badges.push({ type: 'category', val: c, label: `Type: ${c}` }));

    if (activeFilters.maxPrice < 40000) {
      badges.push({ type: 'maxPrice', val: 40000, label: `Max: ${formatLKR(activeFilters.maxPrice)}` });
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
      activeFilters.maxPrice = 40000;
      if (priceSlider) priceSlider.value = 40000;
      if (priceDisplay) priceDisplay.textContent = formatLKR(40000);
    } else if (type === 'search') {
      activeFilters.search = '';
      if (accSearchInput) accSearchInput.value = '';
    }
    renderGrid();
  }

  function resetAllFilters() {
    activeFilters = {
      brands: [],
      categories: [],
      maxPrice: 40000,
      search: '',
      sort: 'featured'
    };

    document.querySelectorAll('.brandCheck, .categoryCheck').forEach(cb => cb.checked = false);
    if (priceSlider) priceSlider.value = 40000;
    if (priceDisplay) priceDisplay.textContent = formatLKR(40000);
    if (accSearchInput) accSearchInput.value = '';
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
  if (accSearchInput) {
    accSearchInput.oninput = (e) => {
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
    const item = accessoriesData.find(a => a.id === id);
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
          <small>Explore our accessories category to add products.</small>
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
    const item = accessoriesData.find(a => a.id === id);
    if (!item) return;

    document.getElementById('quickViewImage').src = item.image;
    document.getElementById('quickViewCategory').textContent = item.brand;
    document.getElementById('quickViewTitle').textContent = item.name;
    document.getElementById('quickViewPrice').textContent = formatLKR(item.price);
    document.getElementById('quickViewOldPrice').textContent = formatLKR(item.oldPrice);
    document.getElementById('quickViewDesc').textContent = `${item.desc} Accessory Type: ${item.category}, Key Feature: ${item.feature}.`;

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
  fetch('api/get_products.php?category=accessories')
    .then(res => res.json())
    .then(data => {
      if (data.status === 'success' && data.products && data.products.length > 0) {
        accessoriesData = data.products.map(p => ({
          id: p.id,
          brand: p.brand,
          name: p.name,
          category: p.spec_1 || 'Overgrips',
          feature: p.spec_2 || 'High Tacky',
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
    .catch(err => console.log('Static fallback active for accessories'));

  // INITIAL RENDER
  renderGrid();
});
