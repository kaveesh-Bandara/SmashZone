<?php
/**
 * SmashZone - Inventory & Stock Management (admin/inventory.php)
 * Stock status breakdown, threshold alerts, and quick inline stock updater
 */

$pageTitle = "Inventory & Stock";
$currentPage = "inventory";

require_once __DIR__ . '/includes/auth_check.php';
require_once __DIR__ . '/includes/functions.php';
require_once __DIR__ . '/../includes/db.php';

$successMessage = '';

// Handle Stock Update POST
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'update_stock') {
    verify_csrf_token();

    $productId = (int)($_POST['product_id'] ?? 0);
    $newStock = (int)($_POST['stock'] ?? 0);

    if ($productId > 0 && $newStock >= 0) {
        $stmt = $pdo->prepare("UPDATE products SET stock = ? WHERE id = ?");
        if ($stmt->execute([$newStock, $productId])) {
            $successMessage = "Stock quantity updated successfully!";
        }
    }
}

require_once __DIR__ . '/includes/header.php';

// Fetch Inventory Records
$inventory = $pdo->query("SELECT p.*, c.name as category_name 
                          FROM products p 
                          JOIN categories c ON p.category_id = c.id 
                          ORDER BY p.stock ASC, p.name ASC")->fetchAll();
?>

<!-- Header -->
<div class="page-header">
  <div class="page-title-group">
    <h1><i class="bi bi-card-checklist text-primary me-2"></i>Inventory & Stock Control</h1>
    <p class="page-subtitle">Monitor stock levels, critical thresholds, and adjust inventory quantities.</p>
  </div>
</div>

<?php if (!empty($successMessage)): ?>
  <div class="alert alert-success rounded-4 shadow-sm mb-4">
    <i class="bi bi-check-circle-fill me-2"></i> <?= htmlspecialchars($successMessage) ?>
  </div>
<?php endif; ?>

<!-- Inventory Table -->
<div class="admin-card">
  <div class="admin-card-header">
    <h3 class="admin-card-title">
      <i class="bi bi-box-seam text-primary"></i> Stock Matrix (<?= count($inventory) ?> Items)
    </h3>
  </div>

  <div class="table-responsive">
    <table class="admin-table">
      <thead>
        <tr>
          <th>Product Name & Brand</th>
          <th>Category</th>
          <th>Price (LKR)</th>
          <th>Current Stock</th>
          <th>Stock Status</th>
          <th class="text-end">Quick Adjust Stock</th>
        </tr>
      </thead>
      <tbody>
        <?php foreach ($inventory as $item): ?>
          <?php 
            $stock = (int)($item['stock'] ?? 15);
            if ($stock === 0) {
                $statusBadge = 'badge-status-outofstock';
                $statusText = 'Out of Stock';
            } elseif ($stock <= 5) {
                $statusBadge = 'badge-status-lowstock';
                $statusText = 'Critical (<5)';
            } elseif ($stock <= 10) {
                $statusBadge = 'badge-status-lowstock';
                $statusText = 'Low Stock (<10)';
            } else {
                $statusBadge = 'badge-status-active';
                $statusText = 'In Stock';
            }
          ?>
          <tr>
            <td>
              <div class="product-cell">
                <img src="../<?= htmlspecialchars($item['image']) ?>" alt="Product" class="product-thumb" onerror="this.src='../images/logo/logo.png'">
                <div>
                  <span class="product-info-name"><?= htmlspecialchars($item['name']) ?></span>
                  <span class="product-info-brand">Brand: <?= htmlspecialchars($item['brand']) ?></span>
                </div>
              </div>
            </td>
            <td>
              <span class="badge bg-light text-dark border px-2 py-1 rounded-pill">
                <?= htmlspecialchars($item['category_name']) ?>
              </span>
            </td>
            <td class="fw-bold text-success">
              Rs. <?= number_format($item['price'], 2) ?>
            </td>
            <td>
              <span class="fw-bold fs-6 <?= $stock <= 5 ? 'text-danger' : ($stock <= 10 ? 'text-warning-emphasis' : 'text-dark') ?>">
                <?= $stock ?> Units
              </span>
            </td>
            <td>
              <span class="badge-status <?= $statusBadge ?>">
                <?= $statusText ?>
              </span>
            </td>
            <td class="text-end">
              <form method="POST" action="inventory.php" class="d-inline-flex align-items-center gap-2 justify-content-end">
                <input type="hidden" name="csrf_token" value="<?= $_SESSION['csrf_token'] ?>">
                <input type="hidden" name="action" value="update_stock">
                <input type="hidden" name="product_id" value="<?= $item['id'] ?>">

                <input type="number" name="stock" value="<?= $stock ?>" min="0" class="form-control form-control-sm text-center font-bold" style="width: 80px;" required>
                
                <button type="submit" class="btn btn-sm btn-primary-green px-3">
                  Update
                </button>
              </form>
            </td>
          </tr>
        <?php endforeach; ?>
      </tbody>
    </table>
  </div>
</div>

<?php require_once __DIR__ . '/includes/footer.php'; ?>
