<?php
/**
 * SmashZone - Admin Dashboard (admin/dashboard.php)
 * Live MySQL Statistics, Recent Orders, Low Stock Alerts, & Quick Actions
 */

$pageTitle = "Dashboard";
$currentPage = "dashboard";

require_once __DIR__ . '/includes/header.php';

// Fetch Live Database Statistics
$totalProducts = (int)$pdo->query("SELECT COUNT(*) FROM products")->fetchColumn();
$totalOrders = (int)$pdo->query("SELECT COUNT(*) FROM orders")->fetchColumn();
$totalCustomers = (int)$pdo->query("SELECT COUNT(*) FROM users WHERE role = 'customer'")->fetchColumn();
$totalRevenue = (float)$pdo->query("SELECT COALESCE(SUM(total_amount), 0) FROM orders WHERE status != 'cancelled'")->fetchColumn();

// Fetch Recent Orders
$recentOrdersStmt = $pdo->query("SELECT o.*, u.first_name, u.last_name, u.email 
                                 FROM orders o 
                                 JOIN users u ON o.user_id = u.id 
                                 ORDER BY o.created_at DESC LIMIT 5");
$recentOrders = $recentOrdersStmt->fetchAll();

// Fetch Low Stock Products
$lowStockStmt = $pdo->query("SELECT * FROM products WHERE stock <= 10 ORDER BY stock ASC LIMIT 5");
$lowStockProducts = $lowStockStmt->fetchAll();

// Fetch Recent Products
$recentProductsStmt = $pdo->query("SELECT p.*, c.name as category_name 
                                   FROM products p 
                                   JOIN categories c ON p.category_id = c.id 
                                   ORDER BY p.id DESC LIMIT 5");
$recentProducts = $recentProductsStmt->fetchAll();
?>

<!-- Dashboard Page Header -->
<div class="page-header">
  <div class="page-title-group">
    <h1><i class="bi bi-speedometer2 text-primary me-2"></i>Admin Dashboard</h1>
    <p class="page-subtitle">Welcome back, <strong><?= $adminName ?></strong>! Overview of SmashZone store performance.</p>
  </div>

  <div class="d-flex align-items-center gap-2">
    <a href="product_add.php" class="btn btn-primary-green">
      <i class="bi bi-plus-lg"></i> Add Product
    </a>
    <a href="categories.php?action=new" class="btn btn-secondary-light">
      <i class="bi bi-folder-plus"></i> Add Category
    </a>
  </div>
</div>

<!-- KPI Summary Cards Row -->
<div class="row g-4 mb-4">
  
  <!-- Total Products Card -->
  <div class="col-xl-3 col-md-6">
    <div class="stat-card">
      <div class="stat-header">
        <span class="stat-title">Total Products</span>
        <div class="stat-icon"><i class="bi bi-box-seam"></i></div>
      </div>
      <div class="stat-value"><?= number_format($totalProducts) ?></div>
      <div class="stat-footer">
        <span class="positive"><i class="bi bi-check-circle-fill"></i> Live Sync</span> catalog inventory
      </div>
    </div>
  </div>

  <!-- Total Orders Card -->
  <div class="col-xl-3 col-md-6">
    <div class="stat-card stat-card-orange">
      <div class="stat-header">
        <span class="stat-title">Total Orders</span>
        <div class="stat-icon"><i class="bi bi-bag-check"></i></div>
      </div>
      <div class="stat-value"><?= number_format($totalOrders) ?></div>
      <div class="stat-footer">
        <span class="positive"><i class="bi bi-arrow-up-short"></i> Active</span> store orders
      </div>
    </div>
  </div>

  <!-- Total Customers Card -->
  <div class="col-xl-3 col-md-6">
    <div class="stat-card stat-card-blue">
      <div class="stat-header">
        <span class="stat-title">Customers</span>
        <div class="stat-icon"><i class="bi bi-people"></i></div>
      </div>
      <div class="stat-value"><?= number_format($totalCustomers) ?></div>
      <div class="stat-footer">
        <span class="positive"><i class="bi bi-person-check-fill"></i> Registered</span> player accounts
      </div>
    </div>
  </div>

  <!-- Revenue Card -->
  <div class="col-xl-3 col-md-6">
    <div class="stat-card stat-card-amber">
      <div class="stat-header">
        <span class="stat-title">Total Revenue</span>
        <div class="stat-icon"><i class="bi bi-currency-dollar"></i></div>
      </div>
      <div class="stat-value">Rs. <?= number_format($totalRevenue, 2) ?></div>
      <div class="stat-footer">
        <span class="positive"><i class="bi bi-graph-up-arrow"></i> Lifetime</span> sales volume
      </div>
    </div>
  </div>

</div>

<!-- Quick Action Shortcuts Bar -->
<div class="admin-card mb-4">
  <div class="admin-card-body p-3">
    <div class="d-flex align-items-center justify-content-between flex-wrap gap-3">
      <div class="fw-bold text-dark d-flex align-items-center gap-2">
        <i class="bi bi-lightning-charge-fill text-warning fs-5"></i> Quick Actions:
      </div>
      <div class="d-flex align-items-center gap-2 flex-wrap">
        <a href="product_add.php" class="btn btn-sm btn-outline-success fw-bold rounded-pill px-3">
          <i class="bi bi-plus-circle me-1"></i> + Add Product
        </a>
        <a href="categories.php" class="btn btn-sm btn-outline-primary fw-bold rounded-pill px-3">
          <i class="bi bi-folder-plus me-1"></i> + Add Category
        </a>
        <a href="orders.php" class="btn btn-sm btn-outline-dark fw-bold rounded-pill px-3">
          <i class="bi bi-receipt me-1"></i> View Orders
        </a>
        <a href="inventory.php" class="btn btn-sm btn-outline-warning text-dark fw-bold rounded-pill px-3">
          <i class="bi bi-box-fill me-1"></i> Manage Inventory
        </a>
      </div>
    </div>
  </div>
</div>

<!-- Two-Column Grid: Recent Orders & Alerts -->
<div class="row g-4">
  
  <!-- Left Column: Recent Orders -->
  <div class="col-lg-7 col-xl-8">
    <div class="admin-card">
      <div class="admin-card-header">
        <h3 class="admin-card-title">
          <i class="bi bi-clock-history text-primary"></i> Recent Customer Orders
        </h3>
        <a href="orders.php" class="btn btn-sm btn-secondary-light">View All Orders →</a>
      </div>
      
      <div class="table-responsive">
        <table class="admin-table">
          <thead>
            <tr>
              <th>Order ID</th>
              <th>Customer</th>
              <th>Total Amount</th>
              <th>Status</th>
              <th>Date</th>
              <th>Action</th>
            </tr>
          </thead>
          <tbody>
            <?php if (empty($recentOrders)): ?>
              <tr>
                <td colspan="6" class="text-center py-4 text-muted">
                  <i class="bi bi-inbox fs-3 d-block mb-1"></i> No orders recorded yet.
                </td>
              </tr>
            <?php else: ?>
              <?php foreach ($recentOrders as $ord): ?>
                <tr>
                  <td>
                    <span class="fw-bold font-monospace text-dark">#SMZ-<?= sprintf('%05d', $ord['id']) ?></span>
                  </td>
                  <td>
                    <div class="fw-bold"><?= htmlspecialchars($ord['first_name'] . ' ' . $ord['last_name']) ?></div>
                    <small class="text-muted" style="font-size: 0.75rem;"><?= htmlspecialchars($ord['email']) ?></small>
                  </td>
                  <td class="fw-bold text-success">
                    Rs. <?= number_format($ord['total_amount'], 2) ?>
                  </td>
                  <td>
                    <span class="badge-status badge-status-<?= strtolower($ord['status']) ?>">
                      <?= ucfirst($ord['status']) ?>
                    </span>
                  </td>
                  <td>
                    <small class="text-muted"><?= date('M d, Y', strtotime($ord['created_at'])) ?></small>
                  </td>
                  <td>
                    <a href="orders.php?id=<?= $ord['id'] ?>" class="btn-action-icon" title="View Order">
                      <i class="bi bi-eye"></i>
                    </a>
                  </td>
                </tr>
              <?php endforeach; ?>
            <?php endif; ?>
          </tbody>
        </table>
      </div>
    </div>
  </div>

  <!-- Right Column: Low Stock Alerts & Recent Products -->
  <div class="col-lg-5 col-xl-4">
    
    <!-- Low Stock Alert Card -->
    <div class="admin-card border-warning">
      <div class="admin-card-header bg-warning-subtle">
        <h3 class="admin-card-title text-warning-emphasis">
          <i class="bi bi-exclamation-triangle-fill text-warning"></i> Low Stock Alert
        </h3>
        <a href="inventory.php" class="small fw-bold text-warning-emphasis">Manage →</a>
      </div>
      <div class="admin-card-body p-0">
        <ul class="list-group list-group-flush">
          <?php if (empty($lowStockProducts)): ?>
            <li class="list-group-item text-center text-muted py-3">
              <i class="bi bi-check-circle text-success me-1"></i> All stock levels healthy!
            </li>
          <?php else: ?>
            <?php foreach ($lowStockProducts as $ls): ?>
              <li class="list-group-item d-flex align-items-center justify-content-between p-3">
                <div class="product-cell">
                  <img src="../<?= htmlspecialchars($ls['image']) ?>" alt="Product" class="product-thumb" onerror="this.src='../images/logo/logo.png'">
                  <div>
                    <span class="product-info-name text-truncate" style="max-width: 150px;"><?= htmlspecialchars($ls['name']) ?></span>
                    <span class="product-info-brand"><?= htmlspecialchars($ls['brand']) ?></span>
                  </div>
                </div>
                <span class="badge bg-danger-subtle text-danger font-semibold px-2 py-1 rounded-pill">
                  <?= $ls['stock'] ?> Left
                </span>
              </li>
            <?php endforeach; ?>
          <?php endif; ?>
        </ul>
      </div>
    </div>

    <!-- Recently Added Products -->
    <div class="admin-card">
      <div class="admin-card-header">
        <h3 class="admin-card-title">
          <i class="bi bi-box-seam text-success"></i> Recent Products
        </h3>
        <a href="products.php" class="small fw-bold text-success">All Products →</a>
      </div>
      <div class="admin-card-body p-0">
        <ul class="list-group list-group-flush">
          <?php foreach ($recentProducts as $rp): ?>
            <li class="list-group-item d-flex align-items-center justify-content-between p-3">
              <div class="product-cell">
                <img src="../<?= htmlspecialchars($rp['image']) ?>" alt="Product" class="product-thumb" onerror="this.src='../images/logo/logo.png'">
                <div>
                  <span class="product-info-name text-truncate" style="max-width: 150px;"><?= htmlspecialchars($rp['name']) ?></span>
                  <span class="product-info-brand"><?= htmlspecialchars($rp['category_name']) ?></span>
                </div>
              </div>
              <div class="text-end">
                <div class="fw-bold text-dark small">Rs. <?= number_format($rp['price']) ?></div>
                <span class="badge-status badge-status-<?= $rp['status'] ?? 'active' ?>" style="font-size: 0.68rem;">
                  <?= ucfirst($rp['status'] ?? 'active') ?>
                </span>
              </div>
            </li>
          <?php endforeach; ?>
        </ul>
      </div>
    </div>

  </div>

</div>

<?php require_once __DIR__ . '/includes/footer.php'; ?>
