<?php
/**
 * SmashZone Admin Sidebar Component (admin/includes/sidebar.php)
 */
$currentPage = $currentPage ?? 'dashboard';
?>
<aside id="sidebar">
  <div class="sidebar-header">
    <a href="dashboard.php" class="sidebar-brand">
      <img src="../images/logo/logo.png" alt="SmashZone Logo">
      <span class="sidebar-brand-text">Smash<span>Zone</span></span>
    </a>
    <button class="btn-sidebar-toggle d-lg-none" id="mobileSidebarClose" aria-label="Close Sidebar">
      <i class="bi bi-x-lg text-white"></i>
    </button>
  </div>

  <ul class="sidebar-menu">
    <li class="sidebar-heading">MAIN MENU</li>
    
    <li class="sidebar-item">
      <a href="dashboard.php" class="sidebar-link <?= $currentPage === 'dashboard' ? 'active' : '' ?>">
        <i class="bi bi-grid-1x2-fill"></i>
        <span>Dashboard</span>
      </a>
    </li>

    <li class="sidebar-heading">CATALOG MANAGEMENT</li>

    <li class="sidebar-item">
      <a href="products.php" class="sidebar-link <?= $currentPage === 'products' ? 'active' : '' ?>">
        <i class="bi bi-box-seam-fill"></i>
        <span>Products</span>
      </a>
    </li>

    <li class="sidebar-item">
      <a href="categories.php" class="sidebar-link <?= $currentPage === 'categories' ? 'active' : '' ?>">
        <i class="bi bi-tags-fill"></i>
        <span>Categories</span>
      </a>
    </li>

    <li class="sidebar-item">
      <a href="inventory.php" class="sidebar-link <?= $currentPage === 'inventory' ? 'active' : '' ?>">
        <i class="bi bi-card-checklist"></i>
        <span>Inventory & Stock</span>
      </a>
    </li>

    <li class="sidebar-heading">SALES & CUSTOMERS</li>

    <li class="sidebar-item">
      <a href="orders.php" class="sidebar-link <?= $currentPage === 'orders' ? 'active' : '' ?>">
        <i class="bi bi-bag-check-fill"></i>
        <span>Orders</span>
      </a>
    </li>

    <li class="sidebar-item">
      <a href="customers.php" class="sidebar-link <?= $currentPage === 'customers' ? 'active' : '' ?>">
        <i class="bi bi-people-fill"></i>
        <span>Customers</span>
      </a>
    </li>

    <li class="sidebar-item">
      <a href="reviews.php" class="sidebar-link <?= $currentPage === 'reviews' ? 'active' : '' ?>">
        <i class="bi bi-chat-left-text-fill"></i>
        <span>Messages & Reviews</span>
      </a>
    </li>

    <li class="sidebar-heading">SYSTEM</li>

    <li class="sidebar-item">
      <a href="settings.php" class="sidebar-link <?= $currentPage === 'settings' ? 'active' : '' ?>">
        <i class="bi bi-gear-fill"></i>
        <span>Settings</span>
      </a>
    </li>

    <li class="sidebar-item">
      <a href="../index.php" target="_blank" class="sidebar-link">
        <i class="bi bi-globe"></i>
        <span>View Customer Store</span>
      </a>
    </li>

    <li class="sidebar-item mt-3">
      <a href="logout.php" class="sidebar-link text-danger">
        <i class="bi bi-box-arrow-right text-danger"></i>
        <span class="text-danger">Logout</span>
      </a>
    </li>
  </ul>

  <div class="sidebar-footer">
    <div class="d-flex align-items-center justify-content-between">
      <span>SmashZone v2.5</span>
      <span class="badge bg-success rounded-pill px-2">Online</span>
    </div>
  </div>
</aside>
