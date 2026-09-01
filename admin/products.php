<?php
/**
 * SmashZone - Admin Product Management (admin/products.php)
 * Full CRUD, Search, Filters (Category, Brand, Status), Stock Badges, AJAX Deactivation
 */

$pageTitle = "Products Management";
$currentPage = "products";

require_once __DIR__ . '/includes/auth_check.php';
require_once __DIR__ . '/includes/functions.php';
require_once __DIR__ . '/../includes/db.php';

$toastMessage = '';

// Handle POST Deactivate / Activate Action
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action'])) {
    verify_csrf_token();
    
    $productId = (int)($_POST['product_id'] ?? 0);
    $newStatus = $_POST['action'] === 'deactivate' ? 'inactive' : 'active';
    
    if ($productId > 0) {
        $stmt = $pdo->prepare("UPDATE products SET status = ? WHERE id = ?");
        if ($stmt->execute([$newStatus, $productId])) {
            $toastMessage = $newStatus === 'inactive' ? 'Product deactivated successfully.' : 'Product activated successfully.';
        }
    }
}

require_once __DIR__ . '/includes/header.php';

if (!empty($toastMessage)) {
    echo "<script>document.addEventListener('DOMContentLoaded', () => showAdminToast('$toastMessage', 'success'));</script>";
}
if (isset($_GET['added']) && $_GET['added'] === '1') {
    echo "<script>document.addEventListener('DOMContentLoaded', () => showAdminToast('Product added successfully!', 'success'));</script>";
}

// Fetch Categories for Filter Dropdown
$categories = $pdo->query("SELECT * FROM categories ORDER BY name ASC")->fetchAll();

// Fetch Brands for Filter Dropdown
$brands = $pdo->query("SELECT DISTINCT brand FROM products ORDER BY brand ASC")->fetchAll(PDO::FETCH_COLUMN);

// Build Filtering SQL Query
$catFilter = $_GET['category_id'] ?? '';
$brandFilter = $_GET['brand'] ?? '';
$statusFilter = $_GET['status'] ?? '';
$searchQuery = trim($_GET['search'] ?? '');

$sql = "SELECT p.*, c.name as category_name 
        FROM products p 
        JOIN categories c ON p.category_id = c.id 
        WHERE 1=1";
$params = [];

if (!empty($catFilter)) {
    $sql .= " AND p.category_id = ?";
    $params[] = $catFilter;
}

if (!empty($brandFilter)) {
    $sql .= " AND p.brand = ?";
    $params[] = $brandFilter;
}

if (!empty($statusFilter)) {
    $sql .= " AND p.status = ?";
    $params[] = $statusFilter;
}

if (!empty($searchQuery)) {
    $sql .= " AND (p.name LIKE ? OR p.brand LIKE ? OR p.description LIKE ?)";
    $params[] = "%$searchQuery%";
    $params[] = "%$searchQuery%";
    $params[] = "%$searchQuery%";
}

$sql .= " ORDER BY p.id DESC";

$stmt = $pdo->prepare($sql);
$stmt->execute($params);
$products = $stmt->fetchAll();
?>

<!-- Header -->
<div class="page-header">
  <div class="page-title-group">
    <h1><i class="bi bi-box-seam text-primary me-2"></i>Product Management</h1>
    <p class="page-subtitle">Manage all SmashZone badminton equipment catalog items.</p>
  </div>
  <div>
    <a href="product_add.php" class="btn btn-primary-green">
      <i class="bi bi-plus-lg"></i> + Add New Product
    </a>
  </div>
</div>

<!-- Search & Filters Toolbar -->
<div class="admin-card mb-4">
  <div class="admin-card-body p-3">
    <form method="GET" action="products.php" class="row g-3 align-items-center">
      
      <!-- Search Input -->
      <div class="col-md-4 col-lg-3">
        <div class="input-group">
          <span class="input-group-text bg-light"><i class="bi bi-search"></i></span>
          <input type="text" name="search" class="form-control" placeholder="Search product name, brand..." value="<?= htmlspecialchars($searchQuery) ?>">
        </div>
      </div>

      <!-- Category Filter -->
      <div class="col-md-3 col-lg-3">
        <select name="category_id" class="form-select" onchange="this.form.submit()">
          <option value="">All Categories</option>
          <?php foreach ($categories as $cat): ?>
            <option value="<?= $cat['id'] ?>" <?= $catFilter == $cat['id'] ? 'selected' : '' ?>>
              <?= htmlspecialchars($cat['name']) ?>
            </option>
          <?php endforeach; ?>
        </select>
      </div>

      <!-- Brand Filter -->
      <div class="col-md-3 col-lg-2">
        <select name="brand" class="form-select" onchange="this.form.submit()">
          <option value="">All Brands</option>
          <?php foreach ($brands as $b): ?>
            <option value="<?= htmlspecialchars($b) ?>" <?= $brandFilter === $b ? 'selected' : '' ?>>
              <?= htmlspecialchars($b) ?>
            </option>
          <?php endforeach; ?>
        </select>
      </div>

      <!-- Status Filter -->
      <div class="col-md-2 col-lg-2">
        <select name="status" class="form-select" onchange="this.form.submit()">
          <option value="">All Statuses</option>
          <option value="active" <?= $statusFilter === 'active' ? 'selected' : '' ?>>Active</option>
          <option value="inactive" <?= $statusFilter === 'inactive' ? 'selected' : '' ?>>Inactive</option>
        </select>
      </div>

      <!-- Clear Button -->
      <div class="col-md-2 col-lg-2 d-flex gap-2">
        <button type="submit" class="btn btn-primary-green w-100">Filter</button>
        <?php if (!empty($searchQuery) || !empty($catFilter) || !empty($brandFilter) || !empty($statusFilter)): ?>
          <a href="products.php" class="btn btn-secondary-light" title="Reset Filters"><i class="bi bi-x-lg"></i></a>
        <?php endif; ?>
      </div>

    </form>
  </div>
</div>

<!-- Products Data Table -->
<div class="admin-card">
  <div class="admin-card-header">
    <h3 class="admin-card-title">
      <i class="bi bi-table text-primary"></i> Equipment Inventory (<?= count($products) ?> items)
    </h3>
  </div>

  <div class="table-responsive">
    <table class="admin-table">
      <thead>
        <tr>
          <th style="width: 60px;">ID</th>
          <th>Product Image & Name</th>
          <th>Category</th>
          <th>Price (LKR)</th>
          <th>Stock</th>
          <th>Status</th>
          <th class="text-end">Actions</th>
        </tr>
      </thead>
      <tbody>
        <?php if (empty($products)): ?>
          <tr>
            <td colspan="7" class="text-center py-5 text-muted">
              <i class="bi bi-search fs-2 d-block mb-2 text-secondary"></i>
              No products found matching your search query.
            </td>
          </tr>
        <?php else: ?>
          <?php foreach ($products as $p): ?>
            <?php 
              $stockVal = (int)($p['stock'] ?? 15);
              $statusVal = $p['status'] ?? 'active';
              
              if ($stockVal === 0) {
                  $stockBadgeClass = 'badge-status-outofstock';
                  $stockLabel = 'Out of Stock (0)';
              } elseif ($stockVal <= 5) {
                  $stockBadgeClass = 'badge-status-lowstock';
                  $stockLabel = "Critical ($stockVal)";
              } elseif ($stockVal <= 10) {
                  $stockBadgeClass = 'badge-status-lowstock';
                  $stockLabel = "Low Stock ($stockVal)";
              } else {
                  $stockBadgeClass = 'badge-status-active';
                  $stockLabel = "In Stock ($stockVal)";
              }
            ?>
            <tr>
              <td class="fw-bold text-muted">#<?= $p['id'] ?></td>
              <td>
                <div class="product-cell">
                  <img src="../<?= htmlspecialchars($p['image']) ?>" alt="<?= htmlspecialchars($p['name']) ?>" class="product-thumb" onerror="this.src='../images/logo/logo.png'">
                  <div>
                    <a href="product_edit.php?id=<?= $p['id'] ?>" class="product-info-name">
                      <?= htmlspecialchars($p['name']) ?>
                    </a>
                    <span class="product-info-brand">Brand: <strong><?= htmlspecialchars($p['brand']) ?></strong></span>
                  </div>
                </div>
              </td>
              <td>
                <span class="badge bg-light text-dark border px-2 py-1 rounded-pill">
                  <?= htmlspecialchars($p['category_name']) ?>
                </span>
              </td>
              <td>
                <div class="fw-bold text-success">Rs. <?= number_format($p['price'], 2) ?></div>
                <?php if ($p['old_price'] > $p['price']): ?>
                  <small class="text-muted text-decoration-line-through">Rs. <?= number_format($p['old_price'], 2) ?></small>
                <?php endif; ?>
              </td>
              <td>
                <span class="badge-status <?= $stockBadgeClass ?>">
                  <?= $stockLabel ?>
                </span>
              </td>
              <td>
                <span class="badge-status badge-status-<?= $statusVal ?>">
                  <i class="bi bi-circle-fill" style="font-size: 0.5rem;"></i>
                  <?= ucfirst($statusVal) ?>
                </span>
              </td>
              <td class="text-end">
                <div class="d-inline-flex gap-1">
                  <!-- Edit Button -->
                  <a href="product_edit.php?id=<?= $p['id'] ?>" class="btn-action-icon" title="Edit Product">
                    <i class="bi bi-pencil-fill text-primary"></i>
                  </a>

                  <!-- Toggle Active / Deactivate Form -->
                  <form method="POST" action="products.php" class="d-inline" onsubmit="return confirm('Are you sure you want to <?= $statusVal === 'active' ? 'deactivate' : 'activate' ?> this product? It will <?= $statusVal === 'active' ? 'no longer' : 'now' ?> appear on the customer website.');">
                    <input type="hidden" name="csrf_token" value="<?= $_SESSION['csrf_token'] ?>">
                    <input type="hidden" name="product_id" value="<?= $p['id'] ?>">
                    <input type="hidden" name="action" value="<?= $statusVal === 'active' ? 'deactivate' : 'activate' ?>">
                    <button type="submit" class="btn-action-icon <?= $statusVal === 'active' ? 'btn-action-danger' : '' ?>" title="<?= $statusVal === 'active' ? 'Deactivate Product' : 'Activate Product' ?>">
                      <i class="bi bi-power <?= $statusVal === 'active' ? 'text-danger' : 'text-success' ?>"></i>
                    </button>
                  </form>
                </div>
              </td>
            </tr>
          <?php endforeach; ?>
        <?php endif; ?>
      </tbody>
    </table>
  </div>
</div>

<?php require_once __DIR__ . '/includes/footer.php'; ?>
