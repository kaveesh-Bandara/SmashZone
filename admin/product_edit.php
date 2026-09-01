<?php
/**
 * SmashZone - Edit Product (admin/product_edit.php)
 * Pre-filled Form, Image Replacement, and Live Database Update
 */

$pageTitle = "Edit Product";
$currentPage = "products";

require_once __DIR__ . '/includes/auth_check.php';
require_once __DIR__ . '/includes/functions.php';
require_once __DIR__ . '/../includes/db.php';

$productId = (int)($_GET['id'] ?? 0);
if ($productId <= 0) {
    header("Location: products.php");
    exit;
}

// Fetch existing product record
$stmt = $pdo->prepare("SELECT * FROM products WHERE id = ?");
$stmt->execute([$productId]);
$product = $stmt->fetch();

if (!$product) {
    header("Location: products.php");
    exit;
}

$errorMessage = '';
$successMessage = '';

// Fetch categories for dropdown
$categories = $pdo->query("SELECT * FROM categories ORDER BY name ASC")->fetchAll();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    verify_csrf_token();

    $name = trim($_POST['name'] ?? '');
    $brand = trim($_POST['brand'] ?? '');
    $categoryId = (int)($_POST['category_id'] ?? 0);
    $description = trim($_POST['description'] ?? '');
    $price = (float)($_POST['price'] ?? 0);
    $oldPrice = (float)($_POST['old_price'] ?? 0);
    $stock = (int)($_POST['stock'] ?? 0);
    $badge = trim($_POST['badge'] ?? '');
    $badgeClass = trim($_POST['badge_class'] ?? 'badge-new');
    $spec1 = trim($_POST['spec_1'] ?? '');
    $spec2 = trim($_POST['spec_2'] ?? '');
    $spec3 = trim($_POST['spec_3'] ?? '');
    $status = $_POST['status'] === 'inactive' ? 'inactive' : 'active';

    if (empty($name) || empty($brand) || $categoryId <= 0 || $price <= 0) {
        $errorMessage = "Please complete all required fields (Product Name, Brand, Category, and Price).";
    } else {
        try {
            // Keep existing image by default
            $imagePath = $product['image'];

            // Replace image if new file uploaded
            if (isset($_FILES['product_image']) && $_FILES['product_image']['error'] !== UPLOAD_ERR_NO_FILE) {
                $imagePath = handle_product_image_upload($_FILES['product_image'], $product['image']);
            }

            if ($oldPrice <= 0) {
                $oldPrice = $price;
            }

            // Update database query
            $updateStmt = $pdo->prepare("UPDATE products SET 
                category_id = ?, brand = ?, name = ?, price = ?, old_price = ?, stock = ?, status = ?, 
                badge = ?, badge_class = ?, image = ?, spec_1 = ?, spec_2 = ?, spec_3 = ?, description = ? 
                WHERE id = ?");

            $updated = $updateStmt->execute([
                $categoryId, $brand, $name, $price, $oldPrice, $stock, $status, 
                $badge, $badgeClass, $imagePath, $spec1, $spec2, $spec3, $description, $productId
            ]);

            if ($updated) {
                $successMessage = "Product updated successfully! Changes are live on the customer website.";
                // Refresh product variable
                $stmt->execute([$productId]);
                $product = $stmt->fetch();
            } else {
                $errorMessage = "Failed to update product record.";
            }

        } catch (Exception $e) {
            $errorMessage = $e->getMessage();
        }
    }
}

require_once __DIR__ . '/includes/header.php';
?>

<!-- Header -->
<div class="page-header">
  <div class="page-title-group">
    <h1><i class="bi bi-pencil-square text-primary me-2"></i>Edit Product #<?= $product['id'] ?></h1>
    <p class="page-subtitle">Update details, pricing, inventory stock, or image for <strong><?= htmlspecialchars($product['name']) ?></strong>.</p>
  </div>
  <div>
    <a href="products.php" class="btn btn-secondary-light">
      <i class="bi bi-arrow-left"></i> Back to Products
    </a>
  </div>
</div>

<?php if (!empty($errorMessage)): ?>
  <div class="alert alert-danger rounded-4 shadow-sm mb-4">
    <i class="bi bi-exclamation-triangle-fill me-2"></i> <?= htmlspecialchars($errorMessage) ?>
  </div>
<?php endif; ?>

<?php if (!empty($successMessage)): ?>
  <div class="alert alert-success rounded-4 shadow-sm mb-4">
    <i class="bi bi-check-circle-fill me-2"></i> <?= htmlspecialchars($successMessage) ?>
  </div>
<?php endif; ?>

<form method="POST" action="product_edit.php?id=<?= $product['id'] ?>" enctype="multipart/form-data">
  <input type="hidden" name="csrf_token" value="<?= $_SESSION['csrf_token'] ?>">

  <div class="row g-4">
    
    <!-- Left Main Column -->
    <div class="col-lg-8">
      
      <!-- Basic Details -->
      <div class="admin-card">
        <div class="admin-card-header">
          <h3 class="admin-card-title"><i class="bi bi-info-circle text-primary"></i> Edit Product Information</h3>
        </div>
        <div class="admin-card-body">
          
          <div class="mb-3">
            <label class="form-label">Product Name <span class="text-danger">*</span></label>
            <input type="text" name="name" class="form-control" required value="<?= htmlspecialchars($product['name']) ?>">
          </div>

          <div class="row g-3 mb-3">
            <div class="col-md-6">
              <label class="form-label">Brand <span class="text-danger">*</span></label>
              <input type="text" name="brand" class="form-control" required value="<?= htmlspecialchars($product['brand']) ?>">
            </div>
            <div class="col-md-6">
              <label class="form-label">Category <span class="text-danger">*</span></label>
              <select name="category_id" class="form-select" required>
                <?php foreach ($categories as $cat): ?>
                  <option value="<?= $cat['id'] ?>" <?= $product['category_id'] == $cat['id'] ? 'selected' : '' ?>>
                    <?= htmlspecialchars($cat['name']) ?>
                  </option>
                <?php endforeach; ?>
              </select>
            </div>
          </div>

          <div class="mb-3">
            <label class="form-label">Product Description</label>
            <textarea name="description" class="form-control" rows="4"><?= htmlspecialchars($product['description']) ?></textarea>
          </div>

        </div>
      </div>

      <!-- Pricing & Stock -->
      <div class="admin-card">
        <div class="admin-card-header">
          <h3 class="admin-card-title"><i class="bi bi-cash-stack text-success"></i> Pricing & Inventory</h3>
        </div>
        <div class="admin-card-body">
          
          <div class="row g-3 mb-3">
            <div class="col-md-4">
              <label class="form-label">Regular Price (LKR) <span class="text-danger">*</span></label>
              <div class="input-group">
                <span class="input-group-text">Rs.</span>
                <input type="number" step="0.01" name="price" class="form-control" required value="<?= htmlspecialchars($product['price']) ?>">
              </div>
            </div>
            <div class="col-md-4">
              <label class="form-label">Old Price (LKR)</label>
              <div class="input-group">
                <span class="input-group-text">Rs.</span>
                <input type="number" step="0.01" name="old_price" class="form-control" value="<?= htmlspecialchars($product['old_price']) ?>">
              </div>
            </div>
            <div class="col-md-4">
              <label class="form-label">Stock Quantity <span class="text-danger">*</span></label>
              <input type="number" name="stock" class="form-control" required min="0" value="<?= htmlspecialchars($product['stock'] ?? 15) ?>">
            </div>
          </div>

          <div class="row g-3">
            <div class="col-md-4">
              <label class="form-label">Spec #1</label>
              <input type="text" name="spec_1" class="form-control" value="<?= htmlspecialchars($product['spec_1']) ?>">
            </div>
            <div class="col-md-4">
              <label class="form-label">Spec #2</label>
              <input type="text" name="spec_2" class="form-control" value="<?= htmlspecialchars($product['spec_2']) ?>">
            </div>
            <div class="col-md-4">
              <label class="form-label">Spec #3</label>
              <input type="text" name="spec_3" class="form-control" value="<?= htmlspecialchars($product['spec_3']) ?>">
            </div>
          </div>

        </div>
      </div>

    </div>

    <!-- Right Sidebar Column -->
    <div class="col-lg-4">
      
      <!-- Current & New Image Card -->
      <div class="admin-card">
        <div class="admin-card-header">
          <h3 class="admin-card-title"><i class="bi bi-image text-warning"></i> Product Image</h3>
        </div>
        <div class="admin-card-body image-upload-wrapper">
          
          <div class="text-center mb-3">
            <label class="small fw-bold text-muted d-block mb-2">Current Image:</label>
            <img src="../<?= htmlspecialchars($product['image']) ?>" alt="Current Product Image" class="img-thumbnail rounded-3 shadow-sm" style="max-height: 140px;" onerror="this.src='../images/logo/logo.png'">
          </div>

          <div class="image-upload-box mb-3" onclick="document.getElementById('editProductImageInput').click();">
            <i class="bi bi-cloud-arrow-up"></i>
            <h6 class="fw-bold mb-1">Upload New Image</h6>
            <p class="small text-muted mb-0">Leave blank to keep existing image</p>
            <input type="file" id="editProductImageInput" name="product_image" class="d-none image-upload-input" accept="image/jpeg,image/png,image/webp">
          </div>

          <div id="imagePreviewBox" class="image-preview-container text-center">
            <img src="../images/logo/logo.png" alt="Preview Image" class="img-fluid rounded">
          </div>

        </div>
      </div>

      <!-- Status & Actions Card -->
      <div class="admin-card">
        <div class="admin-card-header">
          <h3 class="admin-card-title"><i class="bi bi-sliders text-info"></i> Status & Save</h3>
        </div>
        <div class="admin-card-body">
          
          <div class="mb-3">
            <label class="form-label">Store Status</label>
            <select name="status" class="form-select">
              <option value="active" <?= ($product['status'] ?? 'active') === 'active' ? 'selected' : '' ?>>Active (Visible on Store)</option>
              <option value="inactive" <?= ($product['status'] ?? '') === 'inactive' ? 'selected' : '' ?>>Inactive (Hidden from Store)</option>
            </select>
          </div>

          <div class="mb-3">
            <label class="form-label">Badge Tag Text</label>
            <input type="text" name="badge" class="form-control" value="<?= htmlspecialchars($product['badge']) ?>">
          </div>

          <div class="mb-4">
            <label class="form-label">Badge Styling</label>
            <select name="badge_class" class="form-select">
              <option value="badge-new" <?= $product['badge_class'] === 'badge-new' ? 'selected' : '' ?>>New Arrival (Green / Blue)</option>
              <option value="badge-hot" <?= $product['badge_class'] === 'badge-hot' ? 'selected' : '' ?>>Hot Deal (Orange / Red)</option>
              <option value="badge-sale" <?= $product['badge_class'] === 'badge-sale' ? 'selected' : '' ?>>Sale Discount (Yellow)</option>
            </select>
          </div>

          <button type="submit" class="btn btn-primary-green w-100 py-3 font-semibold fs-6 shadow-sm mb-2">
            <i class="bi bi-save-fill me-2"></i> UPDATE PRODUCT
          </button>
          
          <a href="products.php" class="btn btn-secondary-light w-100 py-2 text-center">Cancel</a>

        </div>
      </div>

    </div>

  </div>
</form>

<?php require_once __DIR__ . '/includes/footer.php'; ?>
