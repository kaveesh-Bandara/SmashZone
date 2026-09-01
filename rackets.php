<?php
/**
 * SmashZone - Badminton Rackets Category (rackets.php)
 * Powered by PHP & MySQL database smashZone
 */

require_once __DIR__ . '/includes/db.php';

$pageTitle = "Badminton Rackets — Yonex, Li-Ning, Hundred, Wish, Maxbolt | SmashZone Sri Lanka";
$pageMetaDesc = "Shop authentic badminton rackets in Sri Lanka. Filters for brand, player level, balance, and price in Sri Lankan Rupees (Rs.).";

require_once __DIR__ . '/includes/header.php';
?>

  <!-- HERO BANNER -->
  <section class="category-page-hero">
    <div class="container">
      <div class="category-breadcrumb">
        <a href="index.php"><i class="bi bi-house-door-fill"></i> Home</a>
        <i class="bi bi-chevron-right small"></i>
        <span>Categories</span>
        <i class="bi bi-chevron-right small"></i>
        <span class="active-item">Badminton Rackets</span>
      </div>

      <h1 class="category-hero-title">Badminton <span class="text-orange">Rackets</span></h1>
      <p class="category-hero-desc">
        Explore 17 authentic badminton rackets from world-renowned brands <strong>Yonex, Li-Ning, Hundred, Wish, and Maxbolt</strong>. Filter by player level, balance specs, and price in Sri Lankan Rupees (Rs.).
      </p>
    </div>
  </section>

  <!-- MAIN CONTENT: SIDEBAR FILTERS & PRODUCT GRID -->
  <main class="py-5" style="background-color: var(--light-bg);">
    <div class="container">
      
      <!-- Mobile Filter Trigger -->
      <div class="d-lg-none mb-3">
        <button class="btn-mobile-filter-trigger w-100 justify-content-center py-2 fs-6" data-bs-toggle="offcanvas" data-bs-target="#filterOffcanvas">
          <i class="bi bi-funnel-fill text-warning"></i> Filter Rackets (Brand, Level, Price)
        </button>
      </div>

      <div class="row g-4">
        
        <!-- LEFT SIDEBAR FILTERS (DESKTOP) -->
        <div class="col-lg-3 d-none d-lg-block">
          <div class="filter-sidebar-card">
            
            <div class="filter-sidebar-header">
              <h3 class="filter-sidebar-title">
                <i class="bi bi-sliders text-orange"></i> Filters
              </h3>
              <button id="clearFiltersBtn" class="btn-clear-filters">
                <i class="bi bi-arrow-counterclockwise"></i> Clear All
              </button>
            </div>

            <!-- Search Within Rackets -->
            <div class="filter-group-block">
              <div class="filter-group-heading">Search Rackets</div>
              <div class="position-relative">
                <input type="text" id="racketSearchInput" class="form-control form-control-sm rounded-pill ps-4" placeholder="Astrox, Axforce, 100ZZ...">
                <i class="bi bi-search position-absolute top-50 start-0 translate-middle-y ms-2 text-muted small"></i>
              </div>
            </div>

            <!-- FILTER 1: BRANDS -->
            <div class="filter-group-block">
              <div class="filter-group-heading">
                <span>Brand</span>
                <span class="badge bg-light text-primary border">5 Brands</span>
              </div>
              <div class="filter-options-list">
                <label class="custom-filter-check">
                  <span class="filter-check-label">
                    <input type="checkbox" class="brandCheck" value="Yonex">
                    <span class="fw-bold text-dark">Yonex</span>
                  </span>
                  <span class="filter-count-badge">5</span>
                </label>
                <label class="custom-filter-check">
                  <span class="filter-check-label">
                    <input type="checkbox" class="brandCheck" value="Li-Ning">
                    <span class="fw-bold text-dark">Li-Ning</span>
                  </span>
                  <span class="filter-count-badge">4</span>
                </label>
                <label class="custom-filter-check">
                  <span class="filter-check-label">
                    <input type="checkbox" class="brandCheck" value="Hundred">
                    <span class="fw-bold text-dark">Hundred</span>
                  </span>
                  <span class="filter-count-badge">3</span>
                </label>
                <label class="custom-filter-check">
                  <span class="filter-check-label">
                    <input type="checkbox" class="brandCheck" value="Wish">
                    <span class="fw-bold text-dark">Wish</span>
                  </span>
                  <span class="filter-count-badge">3</span>
                </label>
                <label class="custom-filter-check">
                  <span class="filter-check-label">
                    <input type="checkbox" class="brandCheck" value="Maxbolt">
                    <span class="fw-bold text-dark">Maxbolt</span>
                  </span>
                  <span class="filter-count-badge">2</span>
                </label>
              </div>
            </div>

            <!-- FILTER 2: PLAYER LEVEL -->
            <div class="filter-group-block">
              <div class="filter-group-heading">Player Level</div>
              <div class="filter-options-list">
                <label class="custom-filter-check">
                  <span class="filter-check-label">
                    <input type="checkbox" class="levelCheck" value="Beginner">
                    <span>Beginner</span>
                  </span>
                </label>
                <label class="custom-filter-check">
                  <span class="filter-check-label">
                    <input type="checkbox" class="levelCheck" value="Intermediate">
                    <span>Intermediate</span>
                  </span>
                </label>
                <label class="custom-filter-check">
                  <span class="filter-check-label">
                    <input type="checkbox" class="levelCheck" value="Advanced">
                    <span>Advanced / Professional</span>
                  </span>
                </label>
              </div>
            </div>

            <!-- FILTER 3: PRICE RANGE SLIDER -->
            <div class="filter-group-block">
              <div class="filter-group-heading">Max Price Limit</div>
              <div class="price-range-wrapper">
                <input type="range" id="priceSlider" class="price-slider-input" min="8000" max="100000" step="2500" value="100000">
                <div class="price-inputs-display">
                  <span>Up to:</span>
                  <span id="priceDisplay" class="text-orange">Rs. 100,000</span>
                </div>
              </div>
            </div>

          </div>
        </div>

        <!-- RIGHT PRODUCTS COLUMN -->
        <div class="col-lg-9">
          
          <div class="products-toolbar-card">
            <p class="products-count-text">
              Showing <strong id="racketCount">17</strong> Badminton Rackets Products
            </p>

            <div class="d-flex align-items-center gap-2">
              <label for="sortSelect" class="small text-muted fw-bold mb-0 text-nowrap d-none d-sm-inline">Sort By:</label>
              <select id="sortSelect" class="form-select form-select-sm border-secondary-subtle rounded-pill px-3 shadow-none">
                <option value="featured">Featured / Recommended</option>
                <option value="price-low">Price: Low to High</option>
                <option value="price-high">Price: High to Low</option>
                <option value="rating">Highest Rating</option>
              </select>
            </div>
          </div>

          <div id="activeFiltersBar" class="active-filters-bar"></div>

          <!-- RACKET PRODUCT GRID -->
          <div class="row g-4" id="racketGrid">
            <!-- Rendered dynamically via js/rackets.js -->
          </div>

        </div>

      </div>
    </div>
  </main>

  <!-- MOBILE FILTER OFFCANVAS DRAWER -->
  <div class="offcanvas offcanvas-start" tabindex="-1" id="filterOffcanvas" aria-labelledby="filterOffcanvasLabel">
    <div class="offcanvas-header bg-navy text-white">
      <h5 class="offcanvas-title fw-bold" id="filterOffcanvasLabel">
        <i class="bi bi-sliders text-warning me-2"></i> Filter Rackets
      </h5>
      <button type="button" class="btn-close btn-close-white" data-bs-dismiss="offcanvas" aria-label="Close"></button>
    </div>
    <div class="offcanvas-body p-4">
      <div class="d-flex justify-content-between align-items-center mb-3">
        <span class="fw-bold text-dark">Refine Selection</span>
        <button id="mobileClearFiltersBtn" class="btn btn-link text-orange text-decoration-none small p-0 fw-bold">Clear All</button>
      </div>

      <div class="mb-4">
        <h6 class="fw-bold text-uppercase small text-muted">Brand</h6>
        <label class="custom-filter-check"><span class="filter-check-label"><input type="checkbox" class="brandCheck" value="Yonex"> Yonex</span></label>
        <label class="custom-filter-check"><span class="filter-check-label"><input type="checkbox" class="brandCheck" value="Li-Ning"> Li-Ning</span></label>
        <label class="custom-filter-check"><span class="filter-check-label"><input type="checkbox" class="brandCheck" value="Hundred"> Hundred</span></label>
        <label class="custom-filter-check"><span class="filter-check-label"><input type="checkbox" class="brandCheck" value="Wish"> Wish</span></label>
        <label class="custom-filter-check"><span class="filter-check-label"><input type="checkbox" class="brandCheck" value="Maxbolt"> Maxbolt</span></label>
      </div>

      <button class="btn btn-hero-orange w-100 py-3 font-semibold" data-bs-dismiss="offcanvas">
        APPLY FILTERS
      </button>
    </div>
  </div>

  <script src="js/rackets.js"></script>
<?php require_once __DIR__ . '/includes/footer.php'; ?>
