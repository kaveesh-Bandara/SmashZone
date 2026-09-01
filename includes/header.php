<?php
/**
 * SmashZone - Reusable Top Header & Navigation Component
 */

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

$currentPage = basename($_SERVER['PHP_SELF']);

// Cart quantity calculation
$cartQty = 0;
if (isset($_SESSION['cart']) && is_array($_SESSION['cart'])) {
    $cartQty = array_sum(array_column($_SESSION['cart'], 'qty'));
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title><?php echo isset($pageTitle) ? htmlspecialchars($pageTitle) : 'SmashZone — Premier Badminton Equipment Sri Lanka'; ?></title>
  <meta name="description" content="<?php echo isset($pageMetaDesc) ? htmlspecialchars($pageMetaDesc) : 'Shop authentic badminton rackets and apparel in Sri Lanka.'; ?>">

  <!-- Google Fonts: Outfit & Plus Jakarta Sans -->
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@400;500;600;700;800;900&family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">

  <!-- Bootstrap 5 & Bootstrap Icons CSS -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">
  
  <!-- SmashZone Theme CSS -->
  <link rel="stylesheet" href="css/style.css">
</head>
<body>

  <!-- ==========================================================================
       HEADER: TOP NAVIGATION BAR & SECOND CATEGORY NAV
       ========================================================================== -->
  <header class="sticky-header-wrapper">
    
    <!-- DESKTOP TOP NAV BAR (#082F5A, Height ~80px) -->
    <nav class="top-nav-bar d-none d-lg-block">
      <div class="container">
        <div class="row align-items-center">
          
          <!-- LEFT AREA: LOGO -->
          <div class="col-auto">
            <a href="index.php" class="d-flex align-items-center gap-2 text-decoration-none">
              <img src="images/logo/logo.png" alt="SmashZone Logo" class="brand-logo">
            </a>
          </div>

          <!-- CENTER AREA: SEARCH BAR -->
          <div class="col px-4">
            <form class="header-search-form mx-auto" action="index.php" method="GET">
              <i class="bi bi-search header-search-icon"></i>
              <input type="search" name="search" id="searchInputDesktop" class="form-control header-search-input" placeholder="Search badminton rackets, apparel..." aria-label="Search products" value="<?php echo isset($_GET['search']) ? htmlspecialchars($_GET['search']) : ''; ?>">
              <div id="searchDropdown" class="search-results-dropdown"></div>
            </form>
          </div>

          <!-- RIGHT AREA: ACTIONS -->
          <div class="col-auto">
            <div class="top-nav-actions">
              <a href="index.php#new-arrivals" class="nav-action-link">
                <i class="bi bi-stars"></i>
                <span>New Arrivals</span>
              </a>

              <?php if (isset($_SESSION['user'])): ?>
                <div class="dropdown">
                  <a href="account.php" class="nav-action-link dropdown-toggle text-orange d-flex align-items-center gap-2" data-bs-toggle="dropdown" aria-expanded="false">
                    <img src="<?php echo htmlspecialchars($_SESSION['user']['profile_picture']); ?>" class="rounded-circle border border-2 border-warning" style="width:28px; height:28px; object-fit:cover;">
                    <span>Hi, <?php echo htmlspecialchars(explode(' ', $_SESSION['user']['first_name'])[0]); ?></span>
                    <span class="badge <?php echo $_SESSION['user']['role'] === 'admin' ? 'bg-danger' : 'bg-warning text-dark'; ?> ms-1" style="font-size: 0.65rem;">
                      <?php echo strtoupper($_SESSION['user']['role']); ?>
                    </span>
                  </a>
                  <ul class="dropdown-menu dropdown-menu-end shadow-sm">
                    <li><a class="dropdown-item fw-bold" href="account.php"><i class="bi bi-person-circle me-2 text-primary"></i> My Account</a></li>
                    <?php if ($_SESSION['user']['role'] === 'admin'): ?>
                      <li><a class="dropdown-item fw-bold text-success" href="admin/dashboard.php"><i class="bi bi-speedometer2 me-2"></i> Admin Panel</a></li>
                    <?php endif; ?>
                    <li><hr class="dropdown-divider"></li>
                    <li><a class="dropdown-item text-danger fw-bold" href="auth.php?action=logout"><i class="bi bi-box-arrow-right me-2"></i> Log Out</a></li>
                  </ul>
                </div>
              <?php else: ?>
                <a href="account.php" data-bs-toggle="modal" data-bs-target="#loginModal" class="nav-action-link">
                  <i class="bi bi-person-circle"></i>
                  <span>My Account</span>
                </a>
              <?php endif; ?>

              <!-- SHOPPING CART NAVBAR TOP BAR RIGHT SIDE -->
              <a href="cart.php" class="nav-action-link cart-action-btn text-decoration-none" aria-label="Open Shopping Cart">
                <i class="bi bi-bag"></i>
                <span>Shopping Cart</span>
                <span id="cartBadgeDesktop" class="cart-counter-badge"><?php echo $cartQty; ?></span>
              </a>

            </div>
          </div>

        </div>
      </div>
    </nav>

    <!-- DESKTOP SECOND NAVIGATION BAR (#0B4F9C, Height ~50px) -->
    <nav class="second-nav-bar d-none d-lg-block">
      <div class="container">
        <ul class="second-nav-list">
          <li><a href="index.php" class="second-nav-link <?php echo ($currentPage === 'index.php') ? 'active' : ''; ?>">Home</a></li>
          <li><a href="index.php#categories" class="second-nav-link">Shop by Categories</a></li>
          <li><a href="clothing.php" class="second-nav-link <?php echo ($currentPage === 'clothing.php') ? 'active' : ''; ?>">Clothings</a></li>
          <li><a href="about.php" class="second-nav-link <?php echo ($currentPage === 'about.php') ? 'active' : ''; ?>">About Us</a></li>
          <li><a href="contact.php" class="second-nav-link <?php echo ($currentPage === 'contact.php') ? 'active' : ''; ?>">Contact Us</a></li>

          <?php if (isset($_SESSION['user'])): ?>
            <li><a href="account.php" class="second-nav-link <?php echo ($currentPage === 'account.php') ? 'active' : ''; ?>">My Account</a></li>
          <?php else: ?>
            <li><a href="account.php" data-bs-toggle="modal" data-bs-target="#loginModal" class="second-nav-link">Sign In</a></li>
          <?php endif; ?>
        </ul>
      </div>
    </nav>

    <!-- MOBILE HEADER (<992px) -->
    <div class="mobile-header-bar d-lg-none">
      <div class="container d-flex align-items-center justify-content-between">
        <a href="index.php" aria-label="SmashZone Home">
          <img src="images/logo/logo.png" alt="SmashZone Logo" style="height: 52px; width: auto;">
        </a>

        <div class="d-flex align-items-center gap-3">
          <a href="cart.php" class="position-relative cart-action-btn text-decoration-none">
            <i class="bi bi-bag fs-3 text-primary"></i>
            <span id="cartBadgeMobile" class="cart-counter-badge"><?php echo $cartQty; ?></span>
          </a>

          <button class="mobile-nav-toggle" data-bs-toggle="offcanvas" data-bs-target="#mobileNavOffcanvas" aria-label="Toggle Menu">
            <i class="bi bi-list"></i>
          </button>
        </div>
      </div>
    </div>

    <!-- MOBILE NAV OFFCANVAS DRAWER -->
    <div class="offcanvas offcanvas-start mobile-menu-offcanvas" tabindex="-1" id="mobileNavOffcanvas" aria-labelledby="mobileNavOffcanvasLabel">
      <div class="offcanvas-header text-white" style="background: rgba(0, 0, 0, 0.2); border-bottom: 1px solid rgba(255, 255, 255, 0.12); padding: 1rem 1.25rem;">
        <div class="d-flex align-items-center gap-2">
          <img src="images/logo/logo.png" alt="SmashZone Logo" style="height: 38px; background: white; padding: 4px 10px; border-radius: 8px;">
          <span class="fw-bold fs-5 text-white" style="font-family: var(--font-heading);">SmashZone</span>
        </div>
        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="offcanvas" aria-label="Close"></button>
      </div>

      <div class="offcanvas-body p-0">
        <!-- USER PROFILE HEADER BANNER -->
        <div class="p-3 border-bottom border-white-10" style="background: rgba(255, 255, 255, 0.05);">
          <?php if (isset($_SESSION['user'])): ?>
            <div class="d-flex align-items-center gap-3">
              <img src="<?php echo htmlspecialchars($_SESSION['user']['profile_picture']); ?>" class="rounded-circle border border-2 border-warning" style="width: 44px; height: 44px; object-fit: cover;">
              <div>
                <div class="fw-bold text-white fs-6"><?php echo htmlspecialchars($_SESSION['user']['name']); ?></div>
                <div class="small text-white-50"><?php echo htmlspecialchars($_SESSION['user']['email']); ?></div>
                <span class="badge <?php echo $_SESSION['user']['role'] === 'admin' ? 'bg-danger' : 'bg-warning text-dark'; ?> mt-1 font-semibold" style="font-size: 0.65rem;">
                  <?php echo strtoupper($_SESSION['user']['role']); ?> PLAYER
                </span>
              </div>
            </div>
          <?php else: ?>
            <div class="text-center py-1">
              <p class="text-white-50 small mb-2">Welcome to SmashZone Player Hub!</p>
              <button class="btn btn-warning btn-sm w-100 fw-bold py-2 rounded-3 text-dark shadow-sm" data-bs-toggle="modal" data-bs-target="#loginModal" data-bs-dismiss="offcanvas">
                <i class="bi bi-person-circle me-1"></i> LOG IN / REGISTER NOW
              </button>
            </div>
          <?php endif; ?>
        </div>

        <!-- EMBEDDED MOBILE SEARCH FORM -->
        <div class="p-3 border-bottom border-white-10">
          <form action="index.php" method="GET" class="position-relative">
            <i class="bi bi-search position-absolute top-50 start-0 translate-middle-y ms-3 text-white-50"></i>
            <input type="search" name="search" class="form-control form-control-sm ps-5 py-2 rounded-pill bg-white-10 text-white border-white-20" placeholder="Search rackets, shoes, equipment..." style="font-size: 0.88rem;" value="<?php echo isset($_GET['search']) ? htmlspecialchars($_GET['search']) : ''; ?>">
          </form>
        </div>

        <!-- MOBILE NAVIGATION MENU LIST -->
        <div class="mobile-menu-scroll p-3">
          <div class="text-uppercase small fw-bold text-white-50 mb-2 px-2" style="font-size: 0.72rem; letter-spacing: 0.08em;">Navigation</div>
          <ul class="mobile-menu-list">
            <li class="mobile-menu-item"><a href="index.php" data-bs-dismiss="offcanvas"><i class="bi bi-house-door-fill me-2 text-warning"></i> Home <i class="bi bi-chevron-right ms-auto"></i></a></li>
            <li class="mobile-menu-item"><a href="clothing.php" data-bs-dismiss="offcanvas"><i class="bi bi-person-square me-2 text-info"></i> Clothings <i class="bi bi-chevron-right ms-auto"></i></a></li>
            <li class="mobile-menu-item"><a href="cart.php" data-bs-dismiss="offcanvas"><i class="bi bi-bag-check-fill me-2 text-success"></i> Shopping Cart <span class="badge bg-warning text-dark ms-auto"><?php echo $cartQty; ?></span></a></li>
            <li class="mobile-menu-item"><a href="about.php" data-bs-dismiss="offcanvas"><i class="bi bi-info-circle-fill me-2 text-primary"></i> About Us <i class="bi bi-chevron-right ms-auto"></i></a></li>
            <li class="mobile-menu-item"><a href="contact.php" data-bs-dismiss="offcanvas"><i class="bi bi-envelope-fill me-2 text-warning"></i> Contact Us <i class="bi bi-chevron-right ms-auto"></i></a></li>
          </ul>

          <div class="text-uppercase small fw-bold text-white-50 mt-4 mb-2 px-2" style="font-size: 0.72rem; letter-spacing: 0.08em;">Categories</div>
          <ul class="mobile-menu-list">
            <li class="mobile-menu-item"><a href="rackets.php" data-bs-dismiss="offcanvas"><i class="bi bi-shield-fill me-2 text-danger"></i> Badminton Rackets <i class="bi bi-chevron-right ms-auto"></i></a></li>
            <li class="mobile-menu-item"><a href="shuttlecocks.php" data-bs-dismiss="offcanvas"><i class="bi bi-circle-fill me-2 text-warning"></i> Shuttlecocks <i class="bi bi-chevron-right ms-auto"></i></a></li>
            <li class="mobile-menu-item"><a href="shoes.php" data-bs-dismiss="offcanvas"><i class="bi bi-lightning-fill me-2 text-info"></i> Badminton Shoes <i class="bi bi-chevron-right ms-auto"></i></a></li>
            <li class="mobile-menu-item"><a href="clothing.php" data-bs-dismiss="offcanvas"><i class="bi bi-tag-fill me-2 text-success"></i> Clothings <i class="bi bi-chevron-right ms-auto"></i></a></li>
            <li class="mobile-menu-item"><a href="bags.php" data-bs-dismiss="offcanvas"><i class="bi bi-briefcase-fill me-2 text-secondary"></i> Badminton Bags <i class="bi bi-chevron-right ms-auto"></i></a></li>
            <li class="mobile-menu-item"><a href="accessories.php" data-bs-dismiss="offcanvas"><i class="bi bi-tools me-2 text-primary"></i> Accessories <i class="bi bi-chevron-right ms-auto"></i></a></li>
          </ul>

          <div class="text-uppercase small fw-bold text-white-50 mt-4 mb-2 px-2" style="font-size: 0.72rem; letter-spacing: 0.08em;">Account Options</div>
          <ul class="mobile-menu-list">
            <?php if (isset($_SESSION['user'])): ?>
              <li class="mobile-menu-item"><a href="account.php" data-bs-dismiss="offcanvas"><i class="bi bi-person-fill-gear me-2 text-warning"></i> My Account <i class="bi bi-chevron-right ms-auto"></i></a></li>
              <?php if ($_SESSION['user']['role'] === 'admin'): ?>
                <li class="mobile-menu-item"><a href="admin/dashboard.php" class="text-success"><i class="bi bi-speedometer2 me-2"></i> Admin Panel <i class="bi bi-chevron-right ms-auto"></i></a></li>
              <?php endif; ?>
              <li class="mobile-menu-item"><a href="auth.php?action=logout" class="text-danger"><i class="bi bi-box-arrow-right me-2"></i> Log Out <i class="bi bi-chevron-right ms-auto"></i></a></li>
            <?php else: ?>
              <li class="mobile-menu-item"><a href="#" data-bs-toggle="modal" data-bs-target="#loginModal" data-bs-dismiss="offcanvas"><i class="bi bi-person-check-fill me-2 text-warning"></i> Sign In / Register <i class="bi bi-chevron-right ms-auto"></i></a></li>
            <?php endif; ?>
          </ul>
        </div>
      </div>
    </div>

  </header>
