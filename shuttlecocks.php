<?php
/**
 * SmashZone - Shuttlecocks Category (shuttlecocks.php)
 * Powered by PHP & MySQL database smashZone
 */

require_once __DIR__ . '/includes/db.php';

$pageTitle = "Badminton Shuttlecocks — Feather & Nylon Tubes | SmashZone Sri Lanka";
$pageMetaDesc = "Shop tournament BWF approved feather and nylon shuttlecocks in Sri Lanka. Yonex, Li-Ning, Victor, RSL, Carlton. Fast delivery & 100% authentic.";

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
        <span class="active-item">Shuttlecocks</span>
      </div>

      <h1 class="category-hero-title">Badminton <span class="text-orange">Shuttlecocks</span></h1>
      <p class="category-hero-desc">
        BWF approved goose feather shuttlecocks and durable synthetic shuttle tubes from <strong>Yonex, Li-Ning, Victor, RSL, and Carlton</strong>. Formatted in Sri Lankan Rupees (Rs.).
      </p>
    </div>
  </section>

  <!-- MAIN CONTENT: SIDEBAR FILTERS & PRODUCT GRID -->
  <main class="py-5" style="background-color: var(--light-bg);">
    <div class="container">
      
      <!-- Mobile Filter Trigger -->
      <div class="d-lg-none mb-3">
        <button class="btn-mobile-filter-trigger w-100 justify-content-center py-2 fs-6" data-bs-toggle="offcanvas" data-bs-target="#filterOffcanvas">
          <i class="bi bi-funnel-fill text-warning"></i> Filter Shuttlecocks (Brand, Material, Price)
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

            <!-- Search Within Shuttles -->
            <div class="filter-group-block">
              <div class="filter-group-heading">Search Shuttlecocks</div>
              <div class="position-relative">
                <input type="text" id="shuttleSearchInput" class="form-control form-control-sm rounded-pill ps-4" placeholder="AS-50, Mavis 350, G900...">
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
                  <span class="filter-count-badge">3</span>
                </label>
                <label class="custom-filter-check">
                  <span class="filter-check-label">
                    <input type="checkbox" class="brandCheck" value="Li-Ning">
                    <span class="fw-bold text-dark">Li-Ning</span>
                  </span>
                  <span class="filter-count-badge">2</span>
                </label>
                <label class="custom-filter-check">
                  <span class="filter-check-label">
                    <input type="checkbox" class="brandCheck" value="Victor">
                    <span class="fw-bold text-dark">Victor</span>
                  </span>
                  <span class="filter-count-badge">2</span>
                </label>
                <label class="custom-filter-check">
                  <span class="filter-check-label">
                    <input type="checkbox" class="brandCheck" value="RSL">
                    <span class="fw-bold text-dark">RSL</span>
                  </span>
                  <span class="filter-count-badge">1</span>
                </label>
                <label class="custom-filter-check">
                  <span class="filter-check-label">
                    <input type="checkbox" class="brandCheck" value="Carlton">
                    <span class="fw-bold text-dark">Carlton</span>
                  </span>
                  <span class="filter-count-badge">1</span>
                </label>
              </div>
            </div>

            <!-- FILTER 2: MATERIAL TYPE -->
            <div class="filter-group-block">
              <div class="filter-group-heading">Material / Type</div>
              <div class="filter-options-list">
                <label class="custom-filter-check">
                  <span class="filter-check-label">
                    <input type="checkbox" class="typeCheck" value="Feather">
                    <span>Goose/Duck Feather</span>
                  </span>
                </label>
                <label class="custom-filter-check">
                  <span class="filter-check-label">
                    <input type="checkbox" class="typeCheck" value="Nylon">
                    <span>Nylon / Synthetic</span>
                  </span>
                </label>
              </div>
            </div>

            <!-- FILTER 3: PRICE RANGE SLIDER -->
            <div class="filter-group-block">
              <div class="filter-group-heading">Max Price Limit</div>
              <div class="price-range-wrapper">
                <input type="range" id="priceSlider" class="price-slider-input" min="5000" max="25000" step="1000" value="25000">
                <div class="price-inputs-display">
                  <span>Up to:</span>
                  <span id="priceDisplay" class="text-orange">Rs. 25,000</span>
                </div>
              </div>
            </div>

          </div>
        </div>

        <!-- RIGHT PRODUCTS COLUMN -->
        <div class="col-lg-9">
          
          <div class="products-toolbar-card">
            <p class="products-count-text">
              Showing <strong id="shuttleCount">9</strong> Shuttlecock Products
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

          <!-- SHUTTLECOCKS PRODUCT GRID -->
          <div class="row g-4" id="shuttleGrid"></div>

        </div>

      </div>
    </div>
  </main>

  <script src="js/shuttlecocks.js"></script>
<?php require_once __DIR__ . '/includes/footer.php'; ?>
