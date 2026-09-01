<?php
/**
 * SmashZone Admin Header & Top Navbar Component (admin/includes/header.php)
 */
require_once __DIR__ . '/auth_check.php';
require_once __DIR__ . '/functions.php';
require_once __DIR__ . '/../../includes/db.php';

$adminName = htmlspecialchars($adminUser['name'] ?? ($adminUser['first_name'] . ' ' . $adminUser['last_name']));
$adminEmail = htmlspecialchars($adminUser['email'] ?? 'admin@smashzone.lk');
$adminPic = !empty($adminUser['profile_picture']) ? htmlspecialchars($adminUser['profile_picture']) : 'https://images.unsplash.com/photo-1507003211169-0a1dd7228f2d?auto=format&fit=crop&w=300&q=80';
if (strpos($adminPic, 'http') !== 0) {
    $adminPic = '../' . $adminPic;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title><?= isset($pageTitle) ? htmlspecialchars($pageTitle) . ' | ' : '' ?>SmashZone Admin Portal</title>
  
  <!-- CSRF Token Meta -->
  <meta name="csrf-token" content="<?= $_SESSION['csrf_token'] ?>">

  <!-- Google Fonts: Outfit & Plus Jakarta Sans -->
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@400;500;600;700;800&family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">

  <!-- Bootstrap 5 CSS -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  
  <!-- Bootstrap Icons -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">

  <!-- SmashZone Admin Stylesheet -->
  <link rel="stylesheet" href="assets/css/admin.css">
</head>
<body>

<div id="admin-wrapper">
  
  <!-- Sidebar -->
  <?php require_once __DIR__ . '/sidebar.php'; ?>

  <!-- Main Content Layout -->
  <div id="main-content">

    <!-- Top Navigation Bar -->
    <header id="top-navbar">
      
      <div class="navbar-left">
        <button class="btn-sidebar-toggle" id="sidebarToggleBtn" title="Toggle Sidebar">
          <i class="bi bi-list fs-4"></i>
        </button>

        <form action="products.php" method="GET" class="navbar-search m-0">
          <i class="bi bi-search"></i>
          <input type="text" name="search" id="globalAdminSearch" placeholder="Search products, orders..." autocomplete="off" value="<?= isset($_GET['search']) ? htmlspecialchars($_GET['search']) : '' ?>">
        </form>
      </div>

      <div class="navbar-right">
        <!-- Notification Dropdown -->
        <div class="dropdown">
          <button class="nav-icon-btn" data-bs-toggle="dropdown" aria-expanded="false" title="Notifications">
            <i class="bi bi-bell-fill"></i>
            <span class="badge-dot"></span>
          </button>
          <div class="dropdown-menu dropdown-menu-end shadow-lg border-0 rounded-4 p-3" style="width: 320px;">
            <div class="d-flex align-items-center justify-content-between pb-2 mb-2 border-bottom">
              <h6 class="fw-bold mb-0">Notifications</h6>
              <span class="badge bg-success-subtle text-success font-semibold">Real-time</span>
            </div>
            <div class="notification-list" style="max-height: 240px; overflow-y: auto;">
              <a href="orders.php" class="dropdown-item p-2 rounded-3 d-flex align-items-start gap-3 text-wrap mb-1">
                <div class="bg-primary-subtle text-primary p-2 rounded-circle">
                  <i class="bi bi-bag-check fs-6"></i>
                </div>
                <div>
                  <p class="mb-0 small font-semibold">New customer order received!</p>
                  <small class="text-muted" style="font-size: 0.75rem;">Just now</small>
                </div>
              </a>
              <a href="inventory.php" class="dropdown-item p-2 rounded-3 d-flex align-items-start gap-3 text-wrap">
                <div class="bg-warning-subtle text-warning p-2 rounded-circle">
                  <i class="bi bi-exclamation-triangle fs-6"></i>
                </div>
                <div>
                  <p class="mb-0 small font-semibold">Yonex Astrox stock low (3 left)</p>
                  <small class="text-muted" style="font-size: 0.75rem;">15 mins ago</small>
                </div>
              </a>
            </div>
          </div>
        </div>

        <!-- Admin Profile Dropdown -->
        <div class="dropdown admin-profile-dropdown">
          <button class="dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
            <img src="<?= $adminPic ?>" alt="Admin Avatar" class="admin-avatar">
            <div class="admin-info">
              <span class="admin-name"><?= $adminName ?></span>
              <span class="admin-role-badge">ADMIN</span>
            </div>
            <i class="bi bi-chevron-down text-muted small ms-1"></i>
          </button>
          <ul class="dropdown-menu dropdown-menu-end shadow-lg border-0 rounded-4 py-2" style="min-width: 220px;">
            <li class="px-3 py-2 border-bottom">
              <div class="fw-bold text-dark"><?= $adminName ?></div>
              <small class="text-muted"><?= $adminEmail ?></small>
            </li>
            <li>
              <a class="dropdown-item py-2 fw-semibold" href="settings.php">
                <i class="bi bi-person-circle me-2 text-primary"></i> My Profile
              </a>
            </li>
            <li>
              <a class="dropdown-item py-2 fw-semibold" href="settings.php">
                <i class="bi bi-gear me-2 text-secondary"></i> Account Settings
              </a>
            </li>
            <li>
              <a class="dropdown-item py-2 fw-semibold" href="../index.php" target="_blank">
                <i class="bi bi-box-arrow-up-right me-2 text-success"></i> Customer Store
              </a>
            </li>
            <li><hr class="dropdown-divider"></li>
            <li>
              <a class="dropdown-item py-2 fw-semibold text-danger" href="logout.php">
                <i class="bi bi-box-arrow-right me-2 text-danger"></i> Logout
              </a>
            </li>
          </ul>
        </div>
      </div>

    </header>

    <!-- Page Body Container Starts Here -->
    <div class="admin-page-container">
