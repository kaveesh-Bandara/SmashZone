<?php
/**
 * SmashZone - Homepage (index.php)
 * Powered by PHP & MySQL Database smashZone
 */

require_once __DIR__ . '/includes/db.php';

$pageTitle = "SmashZone — Premier Badminton Equipment Hub Sri Lanka";
$pageMetaDesc = "Shop authentic badminton rackets, shuttlecocks, court shoes, apparel, bags, and accessories in Sri Lanka. Yonex, Li-Ning, Victor, Hundred.";

// Fetch categories from DB
$categoriesStmt = $pdo->query("SELECT * FROM categories ORDER BY id ASC");
$categories = $categoriesStmt->fetchAll();

// Fetch active products from DB (newest first)
$productsStmt = $pdo->query("SELECT p.*, c.name as category_name FROM products p JOIN categories c ON p.category_id = c.id WHERE (p.status = 'active' OR p.status IS NULL) ORDER BY p.id DESC");
$allProducts = $productsStmt->fetchAll();

require_once __DIR__ . '/includes/header.php';
?>

  <!-- ==========================================================================
       HERO SECTION (BACKGROUND VIDEO BANNER)
       ========================================================================== -->
  <section class="hero-video-banner-section" id="hero">

    <!-- Background Video Element -->
    <video id="heroVideoBg" class="hero-video-bg" autoplay muted loop playsinline
      poster="images/banners/promo-banner.png">
      <source src="images/banners/banner video.mp4" type="video/mp4">
    </video>

    <!-- Dark Luxury Glass Overlay Layer -->
    <div class="hero-video-overlay"></div>

    <!-- Sound Audio Toggle Floating Control -->
    <button id="videoSoundToggleBtn" class="video-sound-toggle-btn" type="button" aria-label="Toggle Sound">
      <i class="bi bi-volume-mute-fill fs-5"></i> <span>Sound Off</span>
    </button>

    <div class="container hero-video-container">
      <div class="row">
        <div class="col-lg-8 col-xl-7">
          <div class="hero-video-glass-card">

            <div class="hero-badge-tag">
              <i class="bi bi-lightning-fill text-warning"></i> PRO BADMINTON ACTION STUDIO
            </div>

            <h1 class="hero-title-ultra">
              Smash Harder. <span class="hero-gradient-text">Play Better.</span>
            </h1>

            <p class="hero-subtitle-ultra">
              Experience tournament-grade badminton racquets, high-speed feather shuttlecocks, and professional
              equipment tested for peak court performance and explosive power.
            </p>

            <div class="hero-cta-group">
              <a href="#new-arrivals" class="btn btn-hero-orange">
                SHOP COLLECTION <i class="bi bi-arrow-right-short fs-4"></i>
              </a>
              <a href="#categories" class="btn btn-hero-outline">
                <i class="bi bi-grid-3x3-gap-fill text-warning me-1"></i> EXPLORE CATEGORIES
              </a>
            </div>

            <!-- Hero Proof Row -->
            <div class="hero-proof-row">
              <div class="hero-proof-item">
                <div class="hero-proof-icon">
                  <i class="bi bi-star-fill text-warning"></i>
                </div>
                <div>
                  <strong class="d-block text-white fw-bold">4.9 / 5.0 Rating</strong>
                  <span class="text-light opacity-75 small">12,000+ Active Players</span>
                </div>
              </div>

              <div class="hero-proof-item">
                <div class="hero-proof-icon">
                  <i class="bi bi-patch-check-fill text-warning"></i>
                </div>
                <div>
                  <strong class="d-block text-white fw-bold">100% Authentic</strong>
                  <span class="text-light opacity-75 small">Official Warranty</span>
                </div>
              </div>
            </div>

          </div>
        </div>
      </div>
    </div>
  </section>


  <!-- ==========================================================================
       TRUST / BENEFITS BAR
       ========================================================================== -->
  <section class="benefits-bar" id="benefits">
    <div class="container">
      <div class="row g-4">

        <div class="col-6 col-md-3">
          <div class="benefit-card">
            <div class="benefit-icon-wrapper">
              <i class="bi bi-truck"></i>
            </div>
            <div>
              <div class="benefit-title">Fast Delivery</div>
              <p class="benefit-desc">Fast & reliable dispatch</p>
            </div>
          </div>
        </div>

        <div class="col-6 col-md-3">
          <div class="benefit-card">
            <div class="benefit-icon-wrapper">
              <i class="bi bi-award"></i>
            </div>
            <div>
              <div class="benefit-title">Premium Quality</div>
              <p class="benefit-desc">Authentic badminton gear</p>
            </div>
          </div>
        </div>

        <div class="col-6 col-md-3">
          <div class="benefit-card">
            <div class="benefit-icon-wrapper">
              <i class="bi bi-shield-check"></i>
            </div>
            <div>
              <div class="benefit-title">Secure Shopping</div>
              <p class="benefit-desc">100% safe online checkout</p>
            </div>
          </div>
        </div>

        <div class="col-6 col-md-3">
          <div class="benefit-card">
            <div class="benefit-icon-wrapper">
              <i class="bi bi-headset"></i>
            </div>
            <div>
              <div class="benefit-title">Player Support</div>
              <p class="benefit-desc">Expert choice guidance</p>
            </div>
          </div>
        </div>

      </div>
    </div>
  </section>

  <!-- ==========================================================================
       SHOP BY CATEGORIES SECTION
       ========================================================================== -->
  <section class="categories-section" id="categories">
    <div class="container">

      <div class="text-center">
        <div class="section-tag">OUR COLLECTION</div>
        <h2 class="section-title">Shop by Categories</h2>
        <p class="section-subtitle">Everything you need to play your best game.</p>
      </div>

      <div class="row g-4">

        <!-- Category 1: Rackets -->
        <div class="col-md-6 col-lg-4">
          <div class="category-card">
            <div class="category-img-wrapper">
              <img src="images/categories/category-rackets.png" alt="Badminton Rackets">
            </div>
            <div class="category-body">
              <h3 class="category-title">Badminton Rackets</h3>
              <p class="category-desc">Precision-engineered head-heavy, even-balance, and light rackets for power and
                control.</p>
              <a href="rackets.php" class="category-action-link">Explore Rackets <i class="bi bi-arrow-right"></i></a>
            </div>
          </div>
        </div>

        <!-- Category 2: Shuttlecocks -->
        <div class="col-md-6 col-lg-4">
          <div class="category-card">
            <div class="category-img-wrapper">
              <img src="images/categories/category-shuttlecocks.png" alt="Shuttlecocks">
            </div>
            <div class="category-body">
              <h3 class="category-title">Shuttlecocks</h3>
              <p class="category-desc">Tournament goose feather shuttles and high-durability synthetic shuttlecocks.</p>
              <a href="shuttlecocks.php" class="category-action-link">Explore Shuttlecocks <i
                  class="bi bi-arrow-right"></i></a>
            </div>
          </div>
        </div>

        <!-- Category 3: Shoes -->
        <div class="col-md-6 col-lg-4">
          <div class="category-card">
            <div class="category-img-wrapper">
              <img src="images/categories/category-shoes.png" alt="Badminton Shoes">
            </div>
            <div class="category-body">
              <h3 class="category-title">Badminton Shoes</h3>
              <p class="category-desc">High-grip non-marking rubber court shoes with extra cushion and lateral
                stability.</p>
              <a href="shoes.php" class="category-action-link">Explore Shoes <i class="bi bi-arrow-right"></i></a>
            </div>
          </div>
        </div>

        <!-- Category 4: Clothings -->
        <div class="col-md-6 col-lg-4">
          <div class="category-card">
            <div class="category-img-wrapper">
              <img src="images/categories/category-clothings.png" alt="Clothings">
            </div>
            <div class="category-body">
              <h3 class="category-title">Clothings</h3>
              <p class="category-desc">Breathable dry-fit jerseys, shorts, and activewear crafted for maximum agility.
              </p>
              <a href="clothing.php" class="category-action-link">Explore Apparel <i class="bi bi-arrow-right"></i></a>
            </div>
          </div>
        </div>

        <!-- Category 5: Bags -->
        <div class="col-md-6 col-lg-4">
          <div class="category-card">
            <div class="category-img-wrapper">
              <img src="images/categories/category-bags.png" alt="Badminton Bags">
            </div>
            <div class="category-body">
              <h3 class="category-title">Badminton Bags</h3>
              <p class="category-desc">Thermal-lined multi-racket bags, backpacks, and tournament duffels.</p>
              <a href="bags.php" class="category-action-link">Explore Bags <i class="bi bi-arrow-right"></i></a>
            </div>
          </div>
        </div>

        <!-- Category 6: Accessories -->
        <div class="col-md-6 col-lg-4">
          <div class="category-card">
            <div class="category-img-wrapper">
              <img src="images/categories/category-accessories.png" alt="Accessories">
            </div>
            <div class="category-body">
              <h3 class="category-title">Accessories</h3>
              <p class="category-desc">Overgrips, high-tension string reels, stencils, wristbands, and court maintenance
                gear.</p>
              <a href="accessories.php" class="category-action-link">Explore Accessories <i
                  class="bi bi-arrow-right"></i></a>
            </div>
          </div>
        </div>

      </div>
    </div>
  </section>

  <!-- ==========================================================================
       NEW ARRIVALS SECTION (PRODUCT SHOWCASE)
       ========================================================================== -->
  <section class="products-section" id="new-arrivals">
    <div class="container">

      <div class="text-center">
        <div class="section-tag tag-orange">FEATURED PRODUCTS</div>
        <h2 class="section-title">New Arrivals</h2>
        <p class="section-subtitle">Discover the latest badminton gear at SmashZone.</p>
      </div>

      <!-- Filter Nav Pills -->
      <div class="filter-pills-nav">
        <button class="filter-pill-btn active" data-filter="all">All Products</button>
        <button class="filter-pill-btn" data-filter="rackets">Rackets</button>
        <button class="filter-pill-btn" data-filter="shuttlecocks">Shuttlecocks</button>
        <button class="filter-pill-btn" data-filter="shoes">Shoes</button>
        <button class="filter-pill-btn" data-filter="clothing">Clothing</button>
        <button class="filter-pill-btn" data-filter="bags">Bags</button>
        <button class="filter-pill-btn" data-filter="accessories">Accessories</button>
      </div>

      <!-- Product Cards Grid -->
      <div class="row g-4">

        <!-- Product 1 -->
        <div class="col-sm-6 col-lg-3 product-grid-item" data-category="rackets">
          <div class="product-card">
            <span class="product-badge">NEW</span>
            <button class="wishlist-toggle-btn" data-id="1" aria-label="Add to Wishlist">
              <i class="bi bi-heart"></i>
            </button>
            <div class="product-img-container">
              <img src="images/products/new/r1.png" alt="SmashZone Pro X900 Racket">
              <div class="quick-view-overlay">
                <button class="btn-quick-view" data-id="1" data-image="images/products/new/r1.png" data-name="SmashZone Pro X900 Racket" data-category="Badminton Rackets" data-price="Rs. 54,900" data-old-price="Rs. 62,000"><i class="bi bi-eye"></i> Quick View</button>
              </div>
            </div>
            <div class="product-category">Badminton Rackets</div>
            <h4 class="product-name">SmashZone Pro X900 Racket</h4>
            <div class="product-rating">
              <i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i
                class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i>
              <span class="rating-count">(48)</span>
            </div>
            <div class="product-price-row">
              <span class="current-price">Rs. 54,900</span>
              <span class="old-price">Rs. 62,000</span>
            </div>
            <button class="btn-add-cart" data-id="1">
              <i class="bi bi-cart-plus"></i> Add to Cart
            </button>
          </div>
        </div>

        <!-- Product 2 -->
        <div class="col-sm-6 col-lg-3 product-grid-item" data-category="shuttlecocks">
          <div class="product-card">
            <span class="product-badge badge-sale">BESTSELLER</span>
            <button class="wishlist-toggle-btn" data-id="2" aria-label="Add to Wishlist">
              <i class="bi bi-heart"></i>
            </button>
            <div class="product-img-container">
              <img src="images/products/new/s4.jpeg" alt="Professional Feather Shuttlecock">
              <div class="quick-view-overlay">
                <button class="btn-quick-view" data-id="2" data-image="images/products/new/s4.jpeg" data-name="Professional Feather Shuttlecock" data-category="Shuttlecocks" data-price="Rs. 9,800" data-old-price="Rs. 11,500"><i class="bi bi-eye"></i> Quick View</button>
              </div>
            </div>
            <div class="product-category">Shuttlecocks</div>
            <h4 class="product-name">Professional Feather Shuttlecock</h4>
            <div class="product-rating">
              <i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i
                class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i>
              <span class="rating-count">(112)</span>
            </div>
            <div class="product-price-row">
              <span class="current-price">Rs. 9,800</span>
              <span class="old-price">Rs. 11,500</span>
            </div>
            <button class="btn-add-cart" data-id="2">
              <i class="bi bi-cart-plus"></i> Add to Cart
            </button>
          </div>
        </div>

        <!-- Product 3 -->
        <div class="col-sm-6 col-lg-3 product-grid-item" data-category="rackets">
          <div class="product-card">
            <span class="product-badge badge-sale">-15%</span>
            <button class="wishlist-toggle-btn" data-id="3" aria-label="Add to Wishlist">
              <i class="bi bi-heart"></i>
            </button>
            <div class="product-img-container">
              <img src="images/products/new/r8.jpeg" alt="Carbon Performance Racket">
              <div class="quick-view-overlay">
                <button class="btn-quick-view" data-id="3" data-image="images/products/new/r8.jpeg" data-name="Carbon Performance Racket" data-category="Badminton Rackets" data-price="Rs. 42,500" data-old-price="Rs. 49,000"><i class="bi bi-eye"></i> Quick View</button>
              </div>
            </div>
            <div class="product-category">Badminton Rackets</div>
            <h4 class="product-name">Carbon Performance Racket</h4>
            <div class="product-rating">
              <i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i
                class="bi bi-star-fill"></i><i class="bi bi-star-half"></i>
              <span class="rating-count">(36)</span>
            </div>
            <div class="product-price-row">
              <span class="current-price">Rs. 42,500</span>
              <span class="old-price">Rs. 49,000</span>
            </div>
            <button class="btn-add-cart" data-id="3">
              <i class="bi bi-cart-plus"></i> Add to Cart
            </button>
          </div>
        </div>

        <!-- Product 4 -->
        <div class="col-sm-6 col-lg-3 product-grid-item" data-category="shoes">
          <div class="product-card">
            <span class="product-badge badge-hot">HOT</span>
            <button class="wishlist-toggle-btn" data-id="4" aria-label="Add to Wishlist">
              <i class="bi bi-heart"></i>
            </button>
            <div class="product-img-container">
              <img src="images/products/new/sh1.png" alt="Elite Badminton Shoes">
              <div class="quick-view-overlay">
                <button class="btn-quick-view" data-id="4" data-image="images/products/new/sh1.png" data-name="Elite Badminton Shoes" data-category="Badminton Shoes" data-price="Rs. 34,500" data-old-price="Rs. 39,000"><i class="bi bi-eye"></i> Quick View</button>
              </div>
            </div>
            <div class="product-category">Badminton Shoes</div>
            <h4 class="product-name">Elite Badminton Shoes</h4>
            <div class="product-rating">
              <i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i
                class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i>
              <span class="rating-count">(64)</span>
            </div>
            <div class="product-price-row">
              <span class="current-price">Rs. 34,500</span>
              <span class="old-price">Rs. 39,000</span>
            </div>
            <button class="btn-add-cart" data-id="4">
              <i class="bi bi-cart-plus"></i> Add to Cart
            </button>
          </div>
        </div>

        <!-- Product 5 -->
        <div class="col-sm-6 col-lg-3 product-grid-item" data-category="clothing">
          <div class="product-card">
            <span class="product-badge">NEW</span>
            <button class="wishlist-toggle-btn" data-id="5" aria-label="Add to Wishlist">
              <i class="bi bi-heart"></i>
            </button>
            <div class="product-img-container">
              <img src="images/products/new/c1.png" alt="SmashZone Performance Jersey">
              <div class="quick-view-overlay">
                <button class="btn-quick-view" data-id="5" data-image="images/products/new/c1.png" data-name="SmashZone Performance Jersey" data-category="Clothings" data-price="Rs. 12,500" data-old-price="Rs. 15,000"><i class="bi bi-eye"></i> Quick View</button>
              </div>
            </div>
            <div class="product-category">Clothings</div>
            <h4 class="product-name">SmashZone Performance Jersey</h4>
            <div class="product-rating">
              <i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i
                class="bi bi-star-fill"></i><i class="bi bi-star-half"></i>
              <span class="rating-count">(29)</span>
            </div>
            <div class="product-price-row">
              <span class="current-price">Rs. 12,500</span>
              <span class="old-price">Rs. 15,000</span>
            </div>
            <button class="btn-add-cart" data-id="5">
              <i class="bi bi-cart-plus"></i> Add to Cart
            </button>
          </div>
        </div>

        <!-- Product 6 -->
        <div class="col-sm-6 col-lg-3 product-grid-item" data-category="bags">
          <div class="product-card">
            <span class="product-badge badge-sale">-16%</span>
            <button class="wishlist-toggle-btn" data-id="6" aria-label="Add to Wishlist">
              <i class="bi bi-heart"></i>
            </button>
            <div class="product-img-container">
              <img src="images/products/new/b2.jpeg" alt="Premium Badminton Backpack">
              <div class="quick-view-overlay">
                <button class="btn-quick-view" data-id="6" data-image="images/products/new/b2.jpeg" data-name="Premium Badminton Backpack" data-category="Badminton Bags" data-price="Rs. 22,900" data-old-price="Rs. 26,500"><i class="bi bi-eye"></i> Quick View</button>
              </div>
            </div>
            <div class="product-category">Badminton Bags</div>
            <h4 class="product-name">Premium Badminton Backpack</h4>
            <div class="product-rating">
              <i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i
                class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i>
              <span class="rating-count">(51)</span>
            </div>
            <div class="product-price-row">
              <span class="current-price">Rs. 22,900</span>
              <span class="old-price">Rs. 26,500</span>
            </div>
            <button class="btn-add-cart" data-id="6">
              <i class="bi bi-cart-plus"></i> Add to Cart
            </button>
          </div>
        </div>

        <!-- Product 7 -->
        <div class="col-sm-6 col-lg-3 product-grid-item" data-category="accessories">
          <div class="product-card">
            <span class="product-badge">TOP RATED</span>
            <button class="wishlist-toggle-btn" data-id="7" aria-label="Add to Wishlist">
              <i class="bi bi-heart"></i>
            </button>
            <div class="product-img-container">
              <img src="images/products/new/a3.jpeg" alt="Pro Grip Set">
              <div class="quick-view-overlay">
                <button class="btn-quick-view" data-id="7" data-image="images/products/new/a3.jpeg" data-name="Pro Grip Set (Pack of 3)" data-category="Accessories" data-price="Rs. 4,200" data-old-price="Rs. 5,000"><i class="bi bi-eye"></i> Quick View</button>
              </div>
            </div>
            <div class="product-category">Accessories</div>
            <h4 class="product-name">Pro Grip Set (Pack of 3)</h4>
            <div class="product-rating">
              <i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i
                class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i>
              <span class="rating-count">(88)</span>
            </div>
            <div class="product-price-row">
              <span class="current-price">Rs. 4,200</span>
              <span class="old-price">Rs. 5,000</span>
            </div>
            <button class="btn-add-cart" data-id="7">
              <i class="bi bi-cart-plus"></i> Add to Cart
            </button>
          </div>
        </div>

        <!-- Product 8 -->
        <div class="col-sm-6 col-lg-3 product-grid-item" data-category="shuttlecocks">
          <div class="product-card">
            <span class="product-badge badge-hot">LIMITED</span>
            <button class="wishlist-toggle-btn" data-id="8" aria-label="Add to Wishlist">
              <i class="bi bi-heart"></i>
            </button>
            <div class="product-img-container">
              <img src="images/products/new/s5.jpeg" alt="Tournament Shuttlecock">
              <div class="quick-view-overlay">
                <button class="btn-quick-view" data-id="8" data-image="images/products/new/s5.jpeg" data-name="Tournament Shuttlecock Box" data-category="Shuttlecocks" data-price="Rs. 11,200" data-old-price="Rs. 13,000"><i class="bi bi-eye"></i> Quick View</button>
              </div>
            </div>
            <div class="product-category">Shuttlecocks</div>
            <h4 class="product-name">Tournament Shuttlecock Box</h4>
            <div class="product-rating">
              <i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i
                class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i>
              <span class="rating-count">(42)</span>
            </div>
            <div class="product-price-row">
              <span class="current-price">Rs. 11,200</span>
              <span class="old-price">Rs. 13,000</span>
            </div>
            <button class="btn-add-cart" data-id="8">
              <i class="bi bi-cart-plus"></i> Add to Cart
            </button>
          </div>
        </div>

      </div>
    </div>
  </section>

  <!-- ==========================================================================
       FEATURED PRODUCT PROMOTION BANNER (#082F5A)
       ========================================================================== -->
  <section class="promo-banner-section" id="promo">
    <div class="container">
      <div class="promo-banner-card">
        <div class="row align-items-center gy-4">

          <div class="col-lg-7">
            <div class="section-tag tag-orange">FEATURED SPOTLIGHT</div>
            <h2 class="promo-heading">Gear Up. Smash Harder.</h2>
            <p class="promo-desc">
              Premium equipment designed to help you perform with confidence. Engineered with carbon fiber strength and
              aerodynamic precision.
            </p>
            <a href="#new-arrivals" class="btn btn-brand-orange">
              SHOP COLLECTION <i class="bi bi-bag-check-fill ms-1"></i>
            </a>
          </div>

          <div class="col-lg-5 text-center">
            <div class="promo-img-wrapper">
              <img src="images/banners/promo-banner.png" alt="Gear Up Smash Harder Promotional Banner">
            </div>
          </div>

        </div>
      </div>
    </div>
  </section>

  <!-- ==========================================================================
       CUSTOMER REVIEWS / TESTIMONIALS
       ========================================================================== -->
  <section class="reviews-section" id="reviews">
    <div class="container">

      <div class="text-center">
        <div class="section-tag">TESTIMONIALS</div>
        <h2 class="section-title">What Players Say</h2>
        <p class="section-subtitle">Trusted by badminton players and club enthusiasts nationwide.</p>
      </div>

      <div class="row g-4">

        <!-- Review 1 -->
        <div class="col-md-4">
          <div class="testimonial-card">
            <div class="testimonial-stars">
              <i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i
                class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i>
            </div>
            <p class="testimonial-text">
              "The SmashZone Pro X900 completely transformed my smash power. Ordering was seamless and shipping was
              lightning fast!"
            </p>
            <div class="testimonial-user">
              <div class="user-avatar-placeholder">MV</div>
              <div class="user-info">
                <h6>Marcus Vance</h6>
                <div class="verified-badge"><i class="bi bi-patch-check-fill"></i> Verified Buyer</div>
              </div>
            </div>
          </div>
        </div>

        <!-- Review 2 -->
        <div class="col-md-4">
          <div class="testimonial-card">
            <div class="testimonial-stars">
              <i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i
                class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i>
            </div>
            <p class="testimonial-text">
              "Highest quality feather shuttlecocks I've played with. Excellent durability and flight stability even in
              long rallies."
            </p>
            <div class="testimonial-user">
              <div class="user-avatar-placeholder" style="background-color: var(--primary-orange);">SC</div>
              <div class="user-info">
                <h6>Sarah Chen</h6>
                <div class="verified-badge"><i class="bi bi-patch-check-fill"></i> Verified Buyer</div>
              </div>
            </div>
          </div>
        </div>

        <!-- Review 3 -->
        <div class="col-md-4">
          <div class="testimonial-card">
            <div class="testimonial-stars">
              <i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i
                class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i>
            </div>
            <p class="testimonial-text">
              "SmashZone customer service helped me pick the right string tension and racket weight. Incredible guidance
              and support!"
            </p>
            <div class="testimonial-user">
              <div class="user-avatar-placeholder" style="background-color: var(--shadow-navy);">DM</div>
              <div class="user-info">
                <h6>David Miller</h6>
                <div class="verified-badge"><i class="bi bi-patch-check-fill"></i> Verified Buyer</div>
              </div>
            </div>
          </div>
        </div>

      </div>
    </div>
  </section>
  

  <!-- ==========================================================================
       MODALS & DRAWERS
       ========================================================================== -->

  <!-- 1. SHOPPING CART OFFCANVAS DRAWER -->
  <div class="offcanvas offcanvas-end pro-cart-offcanvas" tabindex="-1" id="cartOffcanvas"
    aria-labelledby="cartOffcanvasLabel">
    <div class="offcanvas-header border-bottom">
      <h5 class="offcanvas-title fw-bold" id="cartOffcanvasLabel">
        <i class="bi bi-bag-fill text-orange me-2"></i> Shopping Cart (<span id="cartCountTitle">0</span>)
      </h5>
      <button type="button" class="btn-close btn-close-white" data-bs-dismiss="offcanvas" aria-label="Close"></button>
    </div>

    <!-- Free Shipping Progress Meter -->
    <div class="free-shipping-box">
      <div class="d-flex justify-content-between align-items-center small fw-semibold">
        <span id="freeShippingText"><i class="bi bi-truck text-warning me-1"></i> Add $75.00 for FREE Express
          Shipping</span>
        <span id="freeShippingPercent" class="text-warning">0%</span>
      </div>
      <div class="free-shipping-progress">
        <div id="freeShippingProgressBar" class="free-shipping-progress-bar" style="width: 0%;"></div>
      </div>
    </div>

    <div class="offcanvas-body p-3" id="cartDrawerItems">
      <!-- Cart items populated dynamically via JS -->
    </div>

    <div class="offcanvas-footer p-3 border-top bg-white">
      <!-- Promo Code Bar -->
      <div class="cart-coupon-box mb-3">
        <div class="input-group">
          <input type="text" id="couponInput" class="form-control form-control-sm border-0 bg-transparent"
            placeholder="Promo code (e.g. SMASH10)">
          <button class="btn btn-sm btn-brand-primary rounded-2 px-3" id="btnApplyCoupon" type="button">Apply</button>
        </div>
      </div>

      <div class="d-flex align-items-center justify-content-between mb-2 small text-muted">
        <span>Subtotal</span>
        <span id="cartSubtotal" class="fw-bold text-dark">$0.00</span>
      </div>
      <div class="d-flex align-items-center justify-content-between mb-3">
        <span class="fw-bold text-navy">Estimated Total</span>
        <span id="cartTotal" class="fs-4 fw-bold text-primary">$0.00</span>
      </div>

      <div class="d-grid gap-2">
        <button class="btn btn-brand-orange py-3 fw-bold fs-6">
          PROCEED TO CHECKOUT <i class="bi bi-arrow-right ms-1"></i>
        </button>
        <button class="btn btn-link text-muted text-decoration-none small py-1" data-bs-dismiss="offcanvas">
          Continue Shopping
        </button>
      </div>
    </div>
  </div>

<?php require_once __DIR__ . '/includes/footer.php'; ?>
