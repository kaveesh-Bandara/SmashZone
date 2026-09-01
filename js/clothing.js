/**
 * SmashZone - Badminton Clothing & Apparel Category JavaScript
 * 16 Real-World Apparel products mapped 1-to-1 to images in images/products/clothings/
 * Homepage Product Card Design & Fully Working Clear All Filters Button.
 */

document.addEventListener('DOMContentLoaded', () => {
  let clothingData = [
    // 1. Yonex Pro Tournament Crew Jersey Red (c1.png)
    {
      id: 401,
      brand: 'Yonex',
      name: 'Yonex Pro Tournament Crew Jersey Red',
      category: 'Match Jersey',
      gender: 'Men',
      price: 12500,
      oldPrice: 14500,
      badge: 'PRO SERIES',
      badgeClass: 'badge-hot',
      rating: 4.9,
      reviews: 64,
      image: 'images/products/clothings/c1.png',
      desc: 'VERYCOOL dry technology lowers body heat by 3°C with micro-mesh ventilation panels.'
    },
    // 2. Li-Ning China National Team Match Tee (c2.png)
    {
      id: 402,
      brand: 'Li-Ning',
      name: 'Li-Ning China National Team Match Tee',
      category: 'Match Jersey',
      gender: 'Unisex',
      price: 13800,
      oldPrice: 16000,
      badge: 'NATIONAL TEAM',
      badgeClass: 'badge-new',
      rating: 5.0,
      reviews: 82,
      image: 'images/products/clothings/c2.png',
      desc: 'AT-DRY fast drying technology rapidly wicks sweat during intensive multi-set matches.'
    },
    // 3. Yonex Tournament Performance Cap White (c3.png)
    {
      id: 403,
      brand: 'Yonex',
      name: 'Yonex Tournament Performance Cap White',
      category: 'Cap / Visor',
      gender: 'Unisex',
      price: 4200,
      oldPrice: 5000,
      badge: 'SUN PROTECT',
      badgeClass: 'badge-sale',
      rating: 4.8,
      reviews: 76,
      image: 'images/products/clothings/c3.png',
      desc: 'Lightweight UV reduction sports cap with internal absorbent sweatband lining.'
    },
    // 4. Yonex High Elastic Match Shorts Black (c4.jpeg)
    {
      id: 404,
      brand: 'Yonex',
      name: 'Yonex High Elastic Match Shorts Black',
      category: 'Court Shorts',
      gender: 'Men',
      price: 8900,
      oldPrice: 10500,
      badge: 'BESTSELLER',
      badgeClass: 'badge-sale',
      rating: 4.8,
      reviews: 51,
      image: 'images/products/clothings/c4.jpeg',
      desc: 'Anti-static lightweight woven stretch shorts with ball storage pockets and elastic waist.'
    },
    // 5. Victor Crown Pro Stretch Court Shorts (c5.jpeg)
    {
      id: 405,
      brand: 'Victor',
      name: 'Victor Crown Pro Stretch Court Shorts',
      category: 'Court Shorts',
      gender: 'Unisex',
      price: 9200,
      oldPrice: 10800,
      badge: 'STRETCH FIT',
      badgeClass: 'badge-new',
      rating: 4.7,
      reviews: 39,
      image: 'images/products/clothings/c5.jpeg',
      desc: 'Moisture management 4-way stretch fabric engineered for wide foot split lunges.'
    },
    // 6. Victor Sleeveless Training Vest Yellow (c6.jpeg)
    {
      id: 406,
      brand: 'Victor',
      name: 'Victor Sleeveless Training Vest Yellow',
      category: 'Sleeveless Vest',
      gender: 'Men',
      price: 7800,
      oldPrice: 9000,
      badge: 'NEW',
      badgeClass: 'badge-new',
      rating: 4.8,
      reviews: 34,
      image: 'images/products/clothings/c6.jpeg',
      desc: 'Zero shoulder friction design allowing full overhead smash swings and shoulder motion.'
    },
    // 7. Hundred Vapor Cool Agility Vest Blue (c7.jpeg)
    {
      id: 407,
      brand: 'Hundred',
      name: 'Hundred Vapor Cool Agility Vest Blue',
      category: 'Sleeveless Vest',
      gender: 'Men',
      price: 6200,
      oldPrice: 7400,
      badge: 'HOT DEAL',
      badgeClass: 'badge-sale',
      rating: 4.7,
      reviews: 29,
      image: 'images/products/clothings/c7.jpeg',
      desc: 'VaporCool mesh ventilation panel on back for continuous airflow during high intensity drills.'
    },
    // 8. Yonex 3D Ergo Cushion Socks (Pack of 3) (c8.jpeg)
    {
      id: 408,
      brand: 'Yonex',
      name: 'Yonex 3D Ergo Cushion Socks (Pack of 3)',
      category: 'Court Socks',
      gender: 'Unisex',
      price: 3900,
      oldPrice: 4800,
      badge: '3D CUSHION',
      badgeClass: 'badge-hot',
      rating: 5.0,
      reviews: 112,
      image: 'images/products/clothings/c8.jpeg',
      desc: 'Ankle support pod and reinforced Achilles heel cushion to absorb hard court impacts.'
    },
    // 9. Li-Ning Thick Towel Sole Socks Pair (c9.jpeg)
    {
      id: 409,
      brand: 'Li-Ning',
      name: 'Li-Ning Thick Towel Sole Socks Pair',
      category: 'Court Socks',
      gender: 'Unisex',
      price: 2400,
      oldPrice: 3000,
      badge: 'HIGH VALUE',
      badgeClass: 'badge-sale',
      rating: 4.8,
      reviews: 85,
      image: 'images/products/clothings/c9.jpeg',
      desc: 'Heavy cotton terry towel sole prevents shoe slippage during sudden court stopping movements.'
    },
    // 10. SmashZone Official Club Jersey White/Cyan (c10.jpeg)
    {
      id: 410,
      brand: 'SmashZone',
      name: 'SmashZone Official Club Jersey White/Cyan',
      category: 'Match Jersey',
      gender: 'Unisex',
      price: 5800,
      oldPrice: 6900,
      badge: 'EXCLUSIVE',
      badgeClass: 'badge-hot',
      rating: 4.9,
      reviews: 94,
      image: 'images/products/clothings/c10.jpeg',
      desc: 'Signature SmashZone team apparel with micro-honeycomb breathable mesh fabric.'
    },
    // 11. Li-Ning Breathable Mesh Court Cap Navy (c11.jpeg)
    {
      id: 411,
      brand: 'Li-Ning',
      name: 'Li-Ning Breathable Mesh Court Cap Navy',
      category: 'Cap / Visor',
      gender: 'Unisex',
      price: 3800,
      oldPrice: 4500,
      badge: 'POPULAR',
      badgeClass: 'badge-new',
      rating: 4.7,
      reviews: 48,
      image: 'images/products/clothings/c11.jpeg',
      desc: 'Ultra-lightweight mesh side panels keep head cool during sunny outdoor or indoor court games.'
    },
    // 12. Hundred Power Motion Training Shorts (c12.jpeg)
    {
      id: 412,
      brand: 'Hundred',
      name: 'Hundred Power Motion Training Shorts',
      category: 'Court Shorts',
      gender: 'Men',
      price: 6500,
      oldPrice: 7800,
      badge: 'VALUE PICK',
      badgeClass: 'badge-sale',
      rating: 4.6,
      reviews: 43,
      image: 'images/products/clothings/c12.jpeg',
      desc: 'Quick dry polyester fabric with zipper side pockets and ergonomic side hem slits.'
    },
    // 13. Victor Crown Pro Sun Visor Black (c13.jpeg)
    {
      id: 413,
      brand: 'Victor',
      name: 'Victor Crown Pro Sun Visor Black',
      category: 'Cap / Visor',
      gender: 'Women',
      price: 3900,
      oldPrice: 4600,
      badge: 'NEW',
      badgeClass: 'badge-new',
      rating: 4.7,
      reviews: 26,
      image: 'images/products/clothings/c13.jpeg',
      desc: 'Open top sun visor providing glare protection without restricting overhead head heat dissipation.'
    },
    // 14. Yonex Pro Sleeveless Match Top Red (c14.jpeg)
    {
      id: 414,
      brand: 'Yonex',
      name: 'Yonex Pro Sleeveless Match Top Red',
      category: 'Sleeveless Vest',
      gender: 'Men',
      price: 9500,
      oldPrice: 11000,
      badge: 'PRO SERIES',
      badgeClass: 'badge-hot',
      rating: 4.9,
      reviews: 37,
      image: 'images/products/clothings/c14.jpeg',
      desc: 'Tournament grade sleeveless match shirt with Polygiene anti-odor treatment.'
    },
    // 15. Victor High-Density Ankle Socks (Pack of 3) (c15.jpeg)
    {
      id: 415,
      brand: 'Victor',
      name: 'Victor High-Density Ankle Socks (Pack of 3)',
      category: 'Court Socks',
      gender: 'Unisex',
      price: 3500,
      oldPrice: 4200,
      badge: 'COMFORT PACK',
      badgeClass: 'badge-sale',
      rating: 4.8,
      reviews: 59,
      image: 'images/products/clothings/c15.jpeg',
      desc: 'High density elastic arch support band reduces foot fatigue during long training sessions.'
    },
    // 16. Yonex Women Team Skort with Inner Short (c16.jpeg)
    {
      id: 416,
      brand: 'Yonex',
      name: 'Yonex Women Team Skort with Inner Short',
      category: 'Court Skort',
      gender: 'Women',
      price: 11200,
      oldPrice: 13000,
      badge: 'ELEGANT FIT',
      badgeClass: 'badge-new',
      rating: 4.9,
      reviews: 29,
      image: 'images/products/clothings/c16.jpeg',
      desc: 'Badminton match skort featuring built-in compression inner shorts for total freedom of motion.'
    }
  ];

  let activeFilters = {
    brands: [],
    categories: [],
    maxPrice: 20000,
    search: '',
    sort: 'featured'
  };

  let cart = [];
  let wishlist = [];

  const clothingGrid = document.getElementById('clothingGrid');
  const clothingCount = document.getElementById('clothingCount');
  const priceSlider = document.getElementById('priceSlider');
  const priceDisplay = document.getElementById('priceDisplay');
  const clothingSearchInput = document.getElementById('clothingSearchInput');
  const sortSelect = document.getElementById('sortSelect');
  const activeFiltersBar = document.getElementById('activeFiltersBar');

  function formatLKR(num) { return 'Rs. ' + num.toLocaleString('en-US'); }

  function getFilteredClothing() {
    return clothingData.filter(item => {
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
    const list = getFilteredClothing();

    // Update Counter
    if (clothingCount) clothingCount.textContent = list.length;

    // Render Active Filter Badges
    renderActiveBadges();

    if (!clothingGrid) return;

    if (list.length === 0) {
      clothingGrid.innerHTML = `
        <div class="col-12 text-center py-5">
          <i class="bi bi-funnel display-1 text-muted opacity-50 mb-3"></i>
          <h4 class="fw-bold text-navy">No Badminton Apparel Match Your Filter</h4>
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
    clothingGrid.innerHTML = list.map(item => {
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
              <span class="racket-spec-tag">${item.gender}</span>
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
    clothingGrid.querySelectorAll('.btn-add-cart').forEach(b => {
      b.onclick = (e) => addToCart(parseInt(e.currentTarget.getAttribute('data-id')));
    });

    clothingGrid.querySelectorAll('.btn-quick-view').forEach(b => {
      b.onclick = (e) => openQuickView(parseInt(e.currentTarget.getAttribute('data-id')));
    });

    clothingGrid.querySelectorAll('.wishlist-toggle-btn').forEach(b => {
      b.onclick = (e) => toggleWishlist(parseInt(e.currentTarget.getAttribute('data-id')));
    });
  }

  function renderActiveBadges() {
    if (!activeFiltersBar) return;
    const badges = [];

    activeFilters.brands.forEach(b => badges.push({ type: 'brand', val: b, label: `Brand: ${b}` }));
    activeFilters.categories.forEach(c => badges.push({ type: 'category', val: c, label: `Type: ${c}` }));

    if (activeFilters.maxPrice < 20000) {
      badges.push({ type: 'maxPrice', val: 20000, label: `Max: ${formatLKR(activeFilters.maxPrice)}` });
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
      activeFilters.maxPrice = 20000;
      if (priceSlider) priceSlider.value = 20000;
      if (priceDisplay) priceDisplay.textContent = formatLKR(20000);
    } else if (type === 'search') {
      activeFilters.search = '';
      if (clothingSearchInput) clothingSearchInput.value = '';
    }
    renderGrid();
  }

  function resetAllFilters() {
    activeFilters = {
      brands: [],
      categories: [],
      maxPrice: 20000,
      search: '',
      sort: 'featured'
    };

    document.querySelectorAll('.brandCheck, .categoryCheck').forEach(cb => cb.checked = false);
    if (priceSlider) priceSlider.value = 20000;
    if (priceDisplay) priceDisplay.textContent = formatLKR(20000);
    if (clothingSearchInput) clothingSearchInput.value = '';
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
  if (clothingSearchInput) {
    clothingSearchInput.oninput = (e) => {
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
    const item = clothingData.find(c => c.id === id);
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
          <small>Explore our clothing category to add products.</small>
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
    const item = clothingData.find(c => c.id === id);
    if (!item) return;

    document.getElementById('quickViewImage').src = item.image;
    document.getElementById('quickViewCategory').textContent = item.brand;
    document.getElementById('quickViewTitle').textContent = item.name;
    document.getElementById('quickViewPrice').textContent = formatLKR(item.price);
    document.getElementById('quickViewOldPrice').textContent = formatLKR(item.oldPrice);
    document.getElementById('quickViewDesc').textContent = `${item.desc} Apparel Category: ${item.category}, Gender Fit: ${item.gender}.`;

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
  fetch('api/get_products.php?category=clothing')
    .then(res => res.json())
    .then(data => {
      if (data.status === 'success' && data.products && data.products.length > 0) {
        clothingData = data.products.map(p => ({
          id: p.id,
          brand: p.brand,
          name: p.name,
          category: p.spec_1 || 'Match Jersey',
          gender: p.spec_2 || 'Unisex',
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
    .catch(err => console.log('Static fallback active for clothing'));

  // INITIAL RENDER
  renderGrid();
});
