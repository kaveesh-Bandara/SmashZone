<?php
/**
 * SmashZone - Homepage (index.php)
 * Powered by PHP & MySQL Database smashZone
 */

require_once __DIR__ . '/includes/db.php';

$pageTitle = "SmashZone — Premier Badminton Equipment Hub Sri Lanka";
$pageMetaDesc = "Shop authentic badminton rackets, shuttlecocks, court shoes, apparel, bags, and accessories in Sri Lanka. Yonex, Li-Ning, Victor, Hundred.";

require_once __DIR__ . '/includes/header.php';

// Fetch categories from DB
$categoriesStmt = $pdo->query("SELECT * FROM categories ORDER BY id ASC");
$categories = $categoriesStmt->fetchAll();

// Fetch new arrival products from DB
$productsStmt = $pdo->query("SELECT p.*, c.name as category_name FROM products p JOIN categories c ON p.category_id = c.id ORDER BY p.id ASC");
$allProducts = $productsStmt->fetchAll();
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>About Us — SmashZone Badminton Excellence</title>
  <meta name="description" content="Learn about SmashZone, our passion for badminton, tournament-grade racquet tuning, authentic products, and commitment to players worldwide.">

  <!-- Google Fonts -->
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@400;500;600;700;800;900&family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">

  <!-- Bootstrap 5 CSS CDN -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  
  <!-- Bootstrap Icons CDN -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">

  <!-- SmashZone Custom Stylesheet -->
  <link rel="stylesheet" href="css/style.css">
</head>
<body>

  

  <!-- ==========================================================================
       PAGE HERO BANNER
       ========================================================================== -->
  <section class="page-hero-banner about-page-hero">
    <div class="container">
      <h1 class="page-hero-title">Driven by Passion. Engineered for Victory.</h1>
      <p class="page-hero-subtitle">
        We are SmashZone — dedicated to delivering authentic, high-performance badminton racquets, equipment, stringing expertise, and court apparel to players of all levels worldwide.
      </p>
    </div>
  </section>

  <!-- ==========================================================================
       OUR STORY & CRAFTSMANSHIP
       ========================================================================== -->
  <section class="py-5 bg-white">
    <div class="container py-4">
      <div class="row align-items-center gy-5">
        <div class="col-lg-6">
          <div class="section-tag tag-orange"><i class="bi bi-trophy-fill me-1"></i> THE SMASHZONE STORY</div>
          <h2 class="section-title mb-4">Born on the Badminton Court</h2>
          <p class="lead text-muted mb-4" style="font-size: 1.1rem; line-height: 1.7;">
            Founded by former tournament players and master racquet stringers, SmashZone was established with one clear mission: to make world-class badminton gear accessible to every player with uncompromised authenticity.
          </p>
          <p class="text-muted mb-4" style="line-height: 1.7;">
            Whether you are mastering your first jump smash or competing in national circuits, every racquet strung in our studio undergoes computerized electronic tension calibration down to 0.1 lbs. We partner directly with official manufacturers to ensure 100% genuine products, backed by full manufacturer warranties.
          </p>
          
          <div class="row g-3 mt-2">
            <div class="col-sm-6">
              <div class="d-flex align-items-center gap-3 p-3 rounded-3 bg-light border border-1 border-light">
                <i class="bi bi-shield-check fs-2 text-primary"></i>
                <div>
                  <h6 class="fw-bold mb-0">100% Authentic</h6>
                  <small class="text-muted">Official Brand Warranties</small>
                </div>
              </div>
            </div>
            <div class="col-sm-6">
              <div class="d-flex align-items-center gap-3 p-3 rounded-3 bg-light border border-1 border-light">
                <i class="bi bi-tools fs-2 text-orange"></i>
                <div>
                  <h6 class="fw-bold mb-0">Master Stringing</h6>
                  <small class="text-muted">Electronic Tension Control</small>
                </div>
              </div>
            </div>
          </div>
        </div>

        <div class="col-lg-6">
          <div class="position-relative">
            <img src="images/banners/promo-banner.png" alt="SmashZone Racquet Studio" class="img-fluid rounded-4 shadow-lg border border-3 border-white">
            <div class="position-absolute bottom-0 start-0 m-4 p-4 bg-navy text-white rounded-3 shadow-lg max-w-sm d-none d-sm-block" style="max-width: 280px;">
              <div class="display-6 fw-bold text-orange mb-1">10+ Years</div>
              <p class="small text-light mb-0">Serving Badminton Clubs & Champions Worldwide</p>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>

  <!-- ==========================================================================
       CORE VALUES & PILLARS
       ========================================================================== -->
  <section class="py-5" style="background-color: #F8FAFC;">
    <div class="container py-4">
      <div class="text-center mb-5">
        <div class="section-tag">WHY PLAYERS CHOOSE US</div>
        <h2 class="section-title">Our Core Commitments</h2>
        <p class="section-subtitle"> Built by badminton players, for badminton players.</p>
      </div>

      <div class="row g-4">
        <div class="col-md-6 col-lg-3">
          <div class="p-4 bg-white rounded-4 shadow-sm border border-1 h-100 text-center">
            <div class="mx-auto mb-3 rounded-circle bg-light d-flex align-items-center justify-content-center" style="width: 64px; height: 64px;">
              <i class="bi bi-award-fill fs-2 text-primary"></i>
            </div>
            <h5 class="fw-bold mb-2">Tournament Grade</h5>
            <p class="text-muted small mb-0">BWF speed approved shuttlecocks and carbon high-modulus frames for unmatched court feedback.</p>
          </div>
        </div>

        <div class="col-md-6 col-lg-3">
          <div class="p-4 bg-white rounded-4 shadow-sm border border-1 h-100 text-center">
            <div class="mx-auto mb-3 rounded-circle bg-light d-flex align-items-center justify-content-center" style="width: 64px; height: 64px;">
              <i class="bi bi-lightning-charge-fill fs-2 text-orange"></i>
            </div>
            <h5 class="fw-bold mb-2">Precision Stringing</h5>
            <p class="text-muted small mb-0">Custom string recommendations tailored to your playing style, tension preference, and smash power.</p>
          </div>
        </div>

        <div class="col-md-6 col-lg-3">
          <div class="p-4 bg-white rounded-4 shadow-sm border border-1 h-100 text-center">
            <div class="mx-auto mb-3 rounded-circle bg-light d-flex align-items-center justify-content-center" style="width: 64px; height: 64px;">
              <i class="bi bi-box-seam-fill fs-2 text-primary"></i>
            </div>
            <h5 class="fw-bold mb-2">Express Global Dispatch</h5>
            <p class="text-muted small mb-0">Secure thermal bubble packaging for delicate racquets with real-time live package tracking.</p>
          </div>
        </div>

        <div class="col-md-6 col-lg-3">
          <div class="p-4 bg-white rounded-4 shadow-sm border border-1 h-100 text-center">
            <div class="mx-auto mb-3 rounded-circle bg-light d-flex align-items-center justify-content-center" style="width: 64px; height: 64px;">
              <i class="bi bi-headset fs-2 text-orange"></i>
            </div>
            <h5 class="fw-bold mb-2">Player Consultation</h5>
            <p class="text-muted small mb-0">Direct 1-on-1 equipment advice from certified badminton coaches to help select your ideal gear.</p>
          </div>
        </div>
      </div>
    </div>
  </section>

  <!-- ==========================================================================
       STATS COUNTER SECTION
       ========================================================================== -->
  <section class="py-5 text-white" style="background: linear-gradient(135deg, #082F5A 0%, #0B4F9C 100%);">
    <div class="container py-3">
      <div class="row g-4 text-center">
        <div class="col-6 col-md-3">
          <div class="display-4 fw-extrabold text-orange mb-1">50,000+</div>
          <p class="text-light opacity-75 mb-0 fw-semibold">Racquets Custom Strung</p>
        </div>
        <div class="col-6 col-md-3">
          <div class="display-4 fw-extrabold text-white mb-1">100+</div>
          <p class="text-light opacity-75 mb-0 fw-semibold">Partner Badminton Clubs</p>
        </div>
        <div class="col-6 col-md-3">
          <div class="display-4 fw-extrabold text-orange mb-1">4.9 / 5.0</div>
          <p class="text-light opacity-75 mb-0 fw-semibold">Verified Player Rating</p>
        </div>
        <div class="col-6 col-md-3">
          <div class="display-4 fw-extrabold text-white mb-1">24/7</div>
          <p class="text-light opacity-75 mb-0 fw-semibold">Player Gear Support</p>
        </div>
      </div>
    </div>
  </section>

  <?php require_once __DIR__ . '/includes/footer.php'; ?>
