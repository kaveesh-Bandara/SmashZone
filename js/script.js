/**
 * SmashZone - Professional Badminton E-Commerce Homepage JavaScript
 * Interactive functionality: Cart, Search, Wishlist, Filter, Modals, Timers
 */

document.addEventListener('DOMContentLoaded', () => {
  // ------------------------------------------------------------------------
  // 1. STATE & DATA INITIALIZATION
  // ------------------------------------------------------------------------
  let cart = [];
  let wishlist = new Set();

  const productsData = [
    {
      id: 1,
      name: 'SmashZone Pro X900 Racket',
      category: 'rackets',
      price: 54900.00,
      oldPrice: 62000.00,
      badge: 'NEW',
      badgeClass: 'badge-new',
      rating: 4.9,
      reviews: 48,
      image: 'images/products/new/r1.png',
      desc: 'High-modulus carbon fiber frame with head-heavy balance for explosive smash power. Engineered for aggressive tournament players.'
    },
    {
      id: 2,
      name: 'Professional Feather Shuttlecock',
      category: 'shuttlecocks',
      price: 9800.00,
      oldPrice: 11500.00,
      badge: 'BESTSELLER',
      badgeClass: 'badge-sale',
      rating: 5.0,
      reviews: 112,
      image: 'images/products/new/s4.jpeg',
      desc: 'Grade-A goose feather shuttlecocks with natural cork base. Premium flight stability and superior rally durability.'
    },
    {
      id: 3,
      name: 'Carbon Performance Racket',
      category: 'rackets',
      price: 42500.00,
      oldPrice: 49000.00,
      badge: '-15%',
      badgeClass: 'badge-sale',
      rating: 4.8,
      reviews: 36,
      image: 'images/products/new/r8.jpeg',
      desc: 'Even-balance aero frame offering fast handling and crisp control. Perfect all-around choice for club players.'
    },
    {
      id: 4,
      name: 'Elite Badminton Shoes',
      category: 'shoes',
      price: 34500.00,
      oldPrice: 39000.00,
      badge: 'HOT',
      badgeClass: 'badge-hot',
      rating: 4.9,
      reviews: 64,
      image: 'images/products/new/sh1.png',
      desc: 'Non-marking high-traction gum rubber sole with heel shock-absorber cushion. Designed for rapid footwork and stability.'
    },
    {
      id: 5,
      name: 'SmashZone Performance Jersey',
      category: 'clothing',
      price: 12500.00,
      oldPrice: 15000.00,
      badge: 'NEW',
      badgeClass: 'badge-new',
      rating: 4.8,
      reviews: 29,
      image: 'images/products/new/c1.png',
      desc: 'Ultra-lightweight moisture-wicking athletic tee with anti-bacterial tech. Maximum breathability during intense matches.'
    },
    {
      id: 6,
      name: 'Premium Badminton Backpack',
      category: 'bags',
      price: 22900.00,
      oldPrice: 26500.00,
      badge: '-16%',
      badgeClass: 'badge-sale',
      rating: 4.9,
      reviews: 51,
      image: 'images/products/new/b2.jpeg',
      desc: 'Dedicated padded 3-racket compartment with shoe bag tunnel and accessory organizer pockets.'
    },
    {
      id: 7,
      name: 'Pro Grip Set (Pack of 3)',
      category: 'accessories',
      price: 4200.00,
      oldPrice: 5000.00,
      badge: 'TOP RATED',
      badgeClass: 'badge-new',
      rating: 5.0,
      reviews: 88,
      image: 'images/products/new/a3.jpeg',
      desc: 'High-tack absorbent polyurethane overgrips for non-slip hold in sweaty match conditions.'
    },
    {
      id: 8,
      name: 'Tournament Shuttlecock Box',
      category: 'shuttlecocks',
      price: 11200.00,
      oldPrice: 13000.00,
      badge: 'LIMITED',
      badgeClass: 'badge-hot',
      rating: 4.9,
      reviews: 42,
      image: 'images/products/new/s5.jpeg',
      desc: 'BWF-standard approved speed 77 tournament feather shuttles crafted for high-altitude accuracy.'
    }
  ];

  // ------------------------------------------------------------------------
  // 2. SHOPPING CART FUNCTIONALITY (PERSISTENT BACKEND SESSION SYNC)
  // ------------------------------------------------------------------------
  const cartBadgeDesktop = document.getElementById('cartBadgeDesktop');
  const cartBadgeMobile = document.getElementById('cartBadgeMobile');
  const cartDrawerItems = document.getElementById('cartDrawerItems');
  const cartSubtotalElem = document.getElementById('cartSubtotal');
  const cartCountTitle = document.getElementById('cartCountTitle');

  function updateCartUI() {
    const totalCount = cart.reduce((sum, item) => sum + item.qty, 0);
    const subtotal = cart.reduce((sum, item) => sum + (item.price * item.qty), 0);

    // Update badges
    if (cartBadgeDesktop) {
      cartBadgeDesktop.textContent = totalCount;
      cartBadgeDesktop.classList.add('pulse');
      setTimeout(() => cartBadgeDesktop.classList.remove('pulse'), 300);
    }
    if (cartBadgeMobile) {
      cartBadgeMobile.textContent = totalCount;
    }

    if (cartCountTitle) {
      cartCountTitle.textContent = totalCount;
    }

    if (cartSubtotalElem) {
      cartSubtotalElem.textContent = `Rs. ${subtotal.toLocaleString('en-US', {minimumFractionDigits: 2, maximumFractionDigits: 2})}`;
    }

    const cartTotalElem = document.getElementById('cartTotal');
    if (cartTotalElem) {
      cartTotalElem.textContent = `Rs. ${subtotal.toLocaleString('en-US', {minimumFractionDigits: 2, maximumFractionDigits: 2})}`;
    }

    // Free Shipping Progress Calculation (Rs. 15,000 threshold)
    const freeShippingThreshold = 15000.00;
    const freeShippingText = document.getElementById('freeShippingText');
    const freeShippingPercent = document.getElementById('freeShippingPercent');
    const freeShippingProgressBar = document.getElementById('freeShippingProgressBar');

    if (freeShippingText && freeShippingPercent && freeShippingProgressBar) {
      if (subtotal >= freeShippingThreshold) {
        freeShippingText.innerHTML = `<i class="bi bi-check-circle-fill text-success me-1"></i> <strong>Congratulations! You unlocked FREE Express Shipping!</strong>`;
        freeShippingPercent.textContent = `100%`;
        freeShippingProgressBar.style.width = `100%`;
        freeShippingProgressBar.style.background = `#12B76A`;
      } else {
        const remaining = freeShippingThreshold - subtotal;
        const percent = Math.min(100, Math.round((subtotal / freeShippingThreshold) * 100));
        freeShippingText.innerHTML = `<i class="bi bi-truck text-warning me-1"></i> Add <strong>Rs. ${remaining.toLocaleString('en-US', {minimumFractionDigits: 2, maximumFractionDigits: 2})}</strong> for FREE Express Shipping`;
        freeShippingPercent.textContent = `${percent}%`;
        freeShippingProgressBar.style.width = `${percent}%`;
        freeShippingProgressBar.style.background = `linear-gradient(90deg, #FF6B00 0%, #FFA800 100%)`;
      }
    }

    // Render Drawer List
    if (cartDrawerItems) {
      if (cart.length === 0) {
        cartDrawerItems.innerHTML = `
          <div class="text-center py-5 text-muted">
            <i class="bi bi-bag-x display-3 mb-3 text-secondary"></i>
            <p class="mb-1 fw-bold text-dark">Your SmashZone cart is empty.</p>
            <small>Explore our categories to add badminton equipment.</small>
          </div>
        `;
      } else {
        cartDrawerItems.innerHTML = cart.map(item => `
          <div class="cart-item-card">
            <img src="${item.image}" alt="${item.name}" class="cart-item-img">
            <div class="flex-grow-1 me-1">
              <h6 class="mb-1 text-truncate fw-bold" style="max-width: 170px; font-size: 0.88rem;">${item.name}</h6>
              <div class="text-primary fw-bold" style="font-size: 0.85rem;">Rs. ${item.price.toLocaleString('en-US', {minimumFractionDigits: 2, maximumFractionDigits: 2})}</div>
              <div class="d-flex align-items-center gap-2 mt-2">
                <button class="qty-control-btn btn-qty-minus" data-id="${item.id}">-</button>
                <span class="fw-bold px-1" style="font-size: 0.85rem;">${item.qty}</span>
                <button class="qty-control-btn btn-qty-plus" data-id="${item.id}">+</button>
              </div>
            </div>
            <button class="btn btn-link text-danger p-0 border-0 btn-remove-item ms-auto" data-id="${item.id}">
              <i class="bi bi-trash fs-5"></i>
            </button>
          </div>
        `).join('');

        // Attach Drawer Item Listeners
        cartDrawerItems.querySelectorAll('.btn-qty-plus').forEach(btn => {
          btn.addEventListener('click', (e) => {
            const id = parseInt(e.currentTarget.getAttribute('data-id'));
            changeQty(id, 1);
          });
        });

        cartDrawerItems.querySelectorAll('.btn-qty-minus').forEach(btn => {
          btn.addEventListener('click', (e) => {
            const id = parseInt(e.currentTarget.getAttribute('data-id'));
            changeQty(id, -1);
          });
        });

        cartDrawerItems.querySelectorAll('.btn-remove-item').forEach(btn => {
          btn.addEventListener('click', (e) => {
            const id = parseInt(e.currentTarget.getAttribute('data-id'));
            removeFromCart(id);
          });
        });
      }
    }
  }

  // Load backend session cart on page load / refresh
  function loadCartFromBackend() {
    fetch('api/cart.php?action=get')
      .then(res => res.json())
      .then(data => {
        if (data.status === 'success' && Array.isArray(data.cart)) {
          cart = data.cart;
          updateCartUI();
        }
      })
      .catch(err => console.error('Cart sync error:', err));
  }

  function addToCart(productId, quantity = 1, productFallback = null) {
    if (typeof requireLoginPrompt === 'function' && !requireLoginPrompt('Please log in first to purchase or add products to your cart!')) {
      return Promise.reject('login_required');
    }

    const itemObj = productsData.find(p => p.id === productId) || productFallback;

    const formData = new FormData();
    formData.append('action', 'add');
    formData.append('product_id', productId);
    formData.append('quantity', quantity);
    if (itemObj) {
      formData.append('name', itemObj.name);
      formData.append('price', itemObj.price);
      formData.append('image', itemObj.image);
    }

    return fetch('api/cart.php', { method: 'POST', body: formData })
      .then(res => res.json())
      .then(data => {
        if (data.status === 'success') {
          cart = data.cart;
          updateCartUI();
          const itemName = itemObj ? itemObj.name : 'Equipment item';
          showToast(`Added <strong>${itemName}</strong> to cart!`, 'cart');
          return data;
        } else if (data.status === 'login_required') {
          requireLoginPrompt(data.message);
          throw new Error('login_required');
        }
      })
      .catch(err => {
        console.error('Error adding to cart:', err);
        throw err;
      });
  }

  function changeQty(productId, delta) {
    const item = cart.find(i => i.id === productId);
    if (!item) return;
    const newQty = item.qty + delta;

    const formData = new FormData();
    formData.append('action', 'update');
    formData.append('product_id', productId);
    formData.append('quantity', newQty);

    fetch('api/cart.php', { method: 'POST', body: formData })
      .then(res => res.json())
      .then(data => {
        if (data.status === 'success') {
          cart = data.cart;
          updateCartUI();
        }
      });
  }

  function removeFromCart(productId) {
    const formData = new FormData();
    formData.append('action', 'remove');
    formData.append('product_id', productId);

    fetch('api/cart.php', { method: 'POST', body: formData })
      .then(res => res.json())
      .then(data => {
        if (data.status === 'success') {
          cart = data.cart;
          updateCartUI();
          showToast('Item removed from cart', 'info');
        }
      });
  }

  // Load Cart from Session on DOM Ready
  loadCartFromBackend();

  // Expose Global Cart Helpers
  window.smashZoneAddToCart = addToCart;
  window.smashZoneChangeQty = changeQty;
  window.smashZoneRemoveFromCart = removeFromCart;
  window.smashZoneUpdateCartUI = updateCartUI;
  window.smashZoneLoadCartFromBackend = loadCartFromBackend;

  // ------------------------------------------------------------------------
  // 3. TOAST NOTIFICATION SYSTEM
  // ------------------------------------------------------------------------
  function showToast(message, type = 'info') {
    let container = document.getElementById('toastContainer');
    if (!container) {
      container = document.createElement('div');
      container.id = 'toastContainer';
      container.className = 'toast-container-custom';
      document.body.appendChild(container);
    }

    const iconMap = {
      cart: 'bi-bag-check-fill text-warning',
      wishlist: 'bi-heart-fill text-danger',
      info: 'bi-info-circle-fill text-info',
      success: 'bi-check-circle-fill text-success'
    };

    const toast = document.createElement('div');
    toast.className = 'custom-toast';
    toast.innerHTML = `
      <i class="bi ${iconMap[type] || 'bi-check-circle-fill'} fs-4"></i>
      <div>${message}</div>
    `;

    container.appendChild(toast);

    setTimeout(() => {
      toast.style.opacity = '0';
      toast.style.transform = 'translateX(-100%)';
      toast.style.transition = 'all 0.3s ease';
      setTimeout(() => toast.remove(), 300);
    }, 3200);
  }

  // ------------------------------------------------------------------------
  // 4. LIVE PRODUCT SEARCH & FILTERING
  // ------------------------------------------------------------------------
  const searchInputDesktop = document.getElementById('searchInputDesktop');
  const searchDropdown = document.getElementById('searchDropdown');

  if (searchInputDesktop && searchDropdown) {
    searchInputDesktop.addEventListener('input', (e) => {
      const query = e.target.value.toLowerCase().trim();
      if (query.length < 2) {
        searchDropdown.classList.remove('show');
        return;
      }

      const matches = productsData.filter(p => 
        p.name.toLowerCase().includes(query) || 
        p.category.toLowerCase().includes(query)
      );

      if (matches.length === 0) {
        searchDropdown.innerHTML = `
          <div class="p-3 text-muted text-center" style="font-size: 0.9rem;">
            No products found matching "${query}"
          </div>
        `;
      } else {
        searchDropdown.innerHTML = matches.map(p => `
          <div class="search-result-item" data-id="${p.id}" style="cursor: pointer;">
            <img src="${p.image}" class="search-result-img" alt="${p.name}">
            <div class="flex-grow-1">
              <div class="fw-bold" style="font-size: 0.875rem;">${p.name}</div>
              <div class="text-primary fw-semibold" style="font-size: 0.8rem;">$${p.price.toFixed(2)}</div>
            </div>
            <span class="badge bg-light text-dark text-capitalize" style="font-size: 0.7rem;">${p.category}</span>
          </div>
        `).join('');

        searchDropdown.querySelectorAll('.search-result-item').forEach(item => {
          item.addEventListener('click', () => {
            const id = parseInt(item.getAttribute('data-id'));
            openQuickView(id);
            searchDropdown.classList.remove('show');
          });
        });
      }

      searchDropdown.classList.add('show');
    });

    document.addEventListener('click', (e) => {
      if (!searchInputDesktop.contains(e.target) && !searchDropdown.contains(e.target)) {
        searchDropdown.classList.remove('show');
      }
    });
  }

  // Category Nav Pills Filtering
  const filterPills = document.querySelectorAll('.filter-pill-btn');
  const productCards = document.querySelectorAll('.product-grid-item');

  filterPills.forEach(pill => {
    pill.addEventListener('click', () => {
      filterPills.forEach(p => p.classList.remove('active'));
      pill.classList.add('active');

      const filterCategory = pill.getAttribute('data-filter');

      productCards.forEach(card => {
        const cardCat = card.getAttribute('data-category');
        if (filterCategory === 'all' || cardCat === filterCategory) {
          card.style.display = 'block';
          card.style.animation = 'fadeIn 0.4s ease';
        } else {
          card.style.display = 'none';
        }
      });
    });
  });

  // ------------------------------------------------------------------------
  // 5. EVENT LISTENERS FOR PRODUCTS & ACTIONS
  // ------------------------------------------------------------------------
  // Add to Cart Buttons
  document.querySelectorAll('.btn-add-cart').forEach(btn => {
    btn.addEventListener('click', (e) => {
      const id = parseInt(e.currentTarget.getAttribute('data-id'));
      addToCart(id);
    });
  });

  // Wishlist Heart Buttons
  document.querySelectorAll('.wishlist-toggle-btn').forEach(btn => {
    btn.addEventListener('click', (e) => {
      const btnElem = e.currentTarget;
      const id = parseInt(btnElem.getAttribute('data-id'));
      const product = productsData.find(p => p.id === id);

      if (wishlist.has(id)) {
        wishlist.delete(id);
        btnElem.classList.remove('active');
        btnElem.innerHTML = '<i class="bi bi-heart"></i>';
        showToast(`Removed from wishlist`, 'info');
      } else {
        wishlist.add(id);
        btnElem.classList.add('active');
        btnElem.innerHTML = '<i class="bi bi-heart-fill"></i>';
        showToast(`Saved <strong>${product ? product.name : 'product'}</strong> to wishlist!`, 'wishlist');
      }
    });
  });

  // Quick View Buttons (Delegated listener to handle all clicks reliably)
  document.addEventListener('click', (e) => {
    const btn = e.target.closest('.btn-quick-view');
    if (btn) {
      e.preventDefault();
      e.stopPropagation();
      const id = parseInt(btn.getAttribute('data-id')) || 0;
      openQuickView(id, btn);
    }
  });

  function openQuickView(productId, btnElem = null) {
    const product = productsData.find(p => p.id === productId);

    const modalElem = document.getElementById('quickViewModal');
    if (!modalElem) return;

    // Extract image and info directly from the clicked product card or button attributes
    let cardImgSrc = '';
    let cardName = '';
    let cardCat = '';
    let cardPrice = '';
    let cardOldPrice = '';

    if (btnElem) {
      // 1. Direct data attributes on button
      if (btnElem.dataset) {
        cardImgSrc = btnElem.dataset.image || btnElem.getAttribute('data-image') || '';
        cardName = btnElem.dataset.name || btnElem.getAttribute('data-name') || '';
        cardCat = btnElem.dataset.category || btnElem.getAttribute('data-category') || '';
        cardPrice = btnElem.dataset.price || btnElem.getAttribute('data-price') || '';
        cardOldPrice = btnElem.dataset.oldPrice || btnElem.getAttribute('data-old-price') || '';
      }

      // 2. Fallback to DOM elements within card
      const card = btnElem.closest('.product-card') || btnElem.closest('.product-grid-item');
      if (card) {
        if (!cardImgSrc) {
          const imgElem = card.querySelector('.product-img-container img') || card.querySelector('img');
          if (imgElem) {
            cardImgSrc = imgElem.getAttribute('src') || imgElem.src;
          }
        }
        if (!cardName) {
          const nameElem = card.querySelector('.product-name');
          if (nameElem) cardName = nameElem.textContent.trim();
        }
        if (!cardCat) {
          const catElem = card.querySelector('.product-category');
          if (catElem) cardCat = catElem.textContent.trim();
        }
        if (!cardPrice) {
          const curPriceElem = card.querySelector('.current-price');
          if (curPriceElem) cardPrice = curPriceElem.textContent.trim();
        }
        if (!cardOldPrice) {
          const oldPriceElem = card.querySelector('.old-price');
          if (oldPriceElem) cardOldPrice = oldPriceElem.textContent.trim();
        }
      }
    }

    const finalImage = cardImgSrc || (product ? product.image : '') || 'images/products/new/r1.png';
    const finalName = cardName || (product ? product.name : 'Badminton Equipment');
    const finalCategory = cardCat || (product ? product.category : 'Badminton Gear');
    const finalPrice = cardPrice || (product ? `Rs. ${Number(product.price).toLocaleString('en-US', {minimumFractionDigits: 2, maximumFractionDigits: 2})}` : 'Rs. 0.00');
    const finalOldPrice = cardOldPrice || (product && product.oldPrice ? `Rs. ${Number(product.oldPrice).toLocaleString('en-US', {minimumFractionDigits: 2, maximumFractionDigits: 2})}` : '');
    const finalDesc = (product && product.desc) ? product.desc : 'High-grade badminton equipment crafted for tournament performance, power, and durability.';

    // Update modal elements
    const modalTitle = modalElem.querySelector('#quickViewTitle') || document.getElementById('quickViewTitle');
    const modalImages = document.querySelectorAll('#quickViewImage');
    const modalCategory = modalElem.querySelector('#quickViewCategory') || document.getElementById('quickViewCategory');
    const modalPrice = modalElem.querySelector('#quickViewPrice') || document.getElementById('quickViewPrice');
    const modalOldPrice = modalElem.querySelector('#quickViewOldPrice') || document.getElementById('quickViewOldPrice');
    const modalDesc = modalElem.querySelector('#quickViewDesc') || document.getElementById('quickViewDesc');
    const modalAddToCartBtn = modalElem.querySelector('#quickViewAddCartBtn') || document.getElementById('quickViewAddCartBtn');

    if (modalTitle) modalTitle.textContent = finalName;
    modalImages.forEach(img => {
      img.src = finalImage;
      img.setAttribute('src', finalImage);
      img.alt = finalName;
    });
    if (modalCategory) modalCategory.textContent = finalCategory;
    if (modalPrice) modalPrice.textContent = finalPrice;
    if (modalOldPrice) modalOldPrice.textContent = finalOldPrice;
    if (modalDesc) modalDesc.textContent = finalDesc;

    if (modalAddToCartBtn) {
      modalAddToCartBtn.onclick = () => {
        addToCart(productId);
        const bsModal = bootstrap.Modal.getInstance(modalElem) || bootstrap.Modal.getOrCreateInstance(modalElem);
        if (bsModal) bsModal.hide();
      };
    }

    const bsModal = bootstrap.Modal.getInstance(modalElem) || new bootstrap.Modal(modalElem);
    if (bsModal) {
      bsModal.show();
    }
  }

  // ------------------------------------------------------------------------
  // 6. SPECIAL OFFER COUNTDOWN TIMER
  // ------------------------------------------------------------------------
  const timerHours = document.getElementById('timerHours');
  const timerMinutes = document.getElementById('timerMinutes');
  const timerSeconds = document.getElementById('timerSeconds');

  if (timerHours && timerMinutes && timerSeconds) {
    let totalSeconds = (14 * 3600) + (45 * 60) + 30; // 14 hours, 45 mins, 30 secs initial

    setInterval(() => {
      if (totalSeconds <= 0) return;
      totalSeconds--;

      const hrs = Math.floor(totalSeconds / 3600);
      const mins = Math.floor((totalSeconds % 3600) / 60);
      const secs = totalSeconds % 60;

      timerHours.textContent = String(hrs).padStart(2, '0');
      timerMinutes.textContent = String(mins).padStart(2, '0');
      timerSeconds.textContent = String(secs).padStart(2, '0');
    }, 1000);
  }

  // ------------------------------------------------------------------------
  // 7. NEWSLETTER FORM VALIDATION
  // ------------------------------------------------------------------------
  const newsletterForm = document.getElementById('newsletterForm');
  if (newsletterForm) {
    newsletterForm.addEventListener('submit', (e) => {
      e.preventDefault();
      const emailInput = document.getElementById('newsletterEmail');
      if (emailInput && emailInput.value.trim() !== '') {
        showToast('Thank you for subscribing to SmashZone updates!', 'success');
        emailInput.value = '';
      }
    });
  }

  // ------------------------------------------------------------------------
  // 8. BACK TO TOP BUTTON & SCROLL HANDLER
  // ------------------------------------------------------------------------
  const backToTopBtn = document.getElementById('backToTopBtn');
  if (backToTopBtn) {
    window.addEventListener('scroll', () => {
      if (window.scrollY > 350) {
        backToTopBtn.classList.add('show');
      } else {
        backToTopBtn.classList.remove('show');
      }
    });

    backToTopBtn.addEventListener('click', (e) => {
      e.preventDefault();
      window.scrollTo({
        top: 0,
        behavior: 'smooth'
      });
    });
  }

  // Coupon Code Application Listener
  const btnApplyCoupon = document.getElementById('btnApplyCoupon');
  if (btnApplyCoupon) {
    btnApplyCoupon.addEventListener('click', () => {
      const couponInput = document.getElementById('couponInput');
      if (couponInput && couponInput.value.trim().toUpperCase() === 'SMASH10') {
        showToast('Promo code <strong>SMASH10</strong> applied! 10% discount applied.', 'success');
      } else if (couponInput && couponInput.value.trim() !== '') {
        showToast('Invalid promo code. Try <strong>SMASH10</strong>!', 'info');
      }
    });
  }

  // Background Video Sound Toggle & Scroll Auto-Pause / Auto-Play
  const videoSoundToggleBtn = document.getElementById('videoSoundToggleBtn');
  const heroVideoBg = document.getElementById('heroVideoBg');
  if (videoSoundToggleBtn && heroVideoBg) {
    videoSoundToggleBtn.addEventListener('click', () => {
      if (heroVideoBg.muted) {
        heroVideoBg.muted = false;
        videoSoundToggleBtn.innerHTML = '<i class="bi bi-volume-up-fill fs-5"></i> <span>Sound On</span>';
        videoSoundToggleBtn.classList.add('bg-orange');
      } else {
        heroVideoBg.muted = true;
        videoSoundToggleBtn.innerHTML = '<i class="bi bi-volume-mute-fill fs-5"></i> <span>Sound Off</span>';
        videoSoundToggleBtn.classList.remove('bg-orange');
      }
    });
  }

  // Scroll Auto-Pause on scroll down & Auto-Play on scroll up
  if (heroVideoBg) {
    const heroSection = document.getElementById('hero');
    if (heroSection && 'IntersectionObserver' in window) {
      const videoObserver = new IntersectionObserver((entries) => {
        entries.forEach((entry) => {
          if (entry.isIntersecting) {
            heroVideoBg.play().catch(() => {});
          } else {
            heroVideoBg.pause();
          }
        });
      }, { threshold: 0.15 });

      videoObserver.observe(heroSection);
    }
  }
});


