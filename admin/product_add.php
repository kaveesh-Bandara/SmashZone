<?php
/**
 * SmashZone - Add Product Form (admin/product_add.php)
 * Secure Image File Upload & Prepared PDO SQL Insertion
 */

$pageTitle = "Add New Product";
$currentPage = "products";

require_once __DIR__ . '/includes/auth_check.php';
require_once __DIR__ . '/includes/functions.php';
require_once __DIR__ . '/../includes/db.php';

$errorMessage = '';
$successMessage = '';

// Fetch categories for select input
$categories = $pdo->query("SELECT * FROM categories ORDER BY name ASC")->fetchAll();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    verify_csrf_token();

    $name = trim($_POST['name'] ?? '');
    $brand = trim($_POST['brand'] ?? '');
    $categoryId = (int)($_POST['category_id'] ?? 0);
    $description = trim($_POST['description'] ?? '');
    $price = (float)($_POST['price'] ?? 0);
    $oldPrice = (float)($_POST['old_price'] ?? 0);
    $stock = (int)($_POST['stock'] ?? 15);
    $badge = trim($_POST['badge'] ?? 'NEW');
    $badgeClass = trim($_POST['badge_class'] ?? 'badge-new');
    $spec1 = trim($_POST['spec_1'] ?? '');
    $spec2 = trim($_POST['spec_2'] ?? '');
    $spec3 = trim($_POST['spec_3'] ?? '');
    $status = $_POST['status'] === 'inactive' ? 'inactive' : 'active';

    // Validation
    if (empty($name) || empty($brand) || $categoryId <= 0 || $price <= 0) {
        $errorMessage = "Please complete all required fields (Product Name, Brand, Category, and Price).";
    } else {
        try {
            // Handle Image Upload
            $imagePath = 'images/logo/logo.png'; // default fallback
            if (isset($_FILES['product_image']) && $_FILES['product_image']['error'] !== UPLOAD_ERR_NO_FILE) {
                $imagePath = handle_product_image_upload($_FILES['product_image']);
            }

            if ($oldPrice <= 0) {
                $oldPrice = $price;
            }

            // Insert into products table
            $stmt = $pdo->prepare("INSERT INTO products 
                (category_id, brand, name, price, old_price, stock, status, badge, badge_class, rating, reviews, image, spec_1, spec_2, spec_3, description) 
                VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, 5.0, 10, ?, ?, ?, ?, ?)");

            $inserted = $stmt->execute([
                $categoryId, $brand, $name, $price, $oldPrice, $stock, $status, 
                $badge, $badgeClass, $imagePath, $spec1, $spec2, $spec3, $description
            ]);

            if ($inserted) {
                header("Location: products.php?added=1");
                exit;
            } else {
                $errorMessage = "Failed to insert product record into MySQL database.";
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
    <h1><i class="bi bi-plus-square text-primary me-2"></i>Add New Product</h1>
    <p class="page-subtitle">Create a new badminton equipment item for SmashZone store catalog.</p>
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

<form method="POST" action="product_add.php" enctype="multipart/form-data" class="needs-validation">
  <input type="hidden" name="csrf_token" value="<?= $_SESSION['csrf_token'] ?>">

  <div class="row g-4">
    
    <!-- Left Main Column: Form Inputs -->
    <div class="col-lg-8">
      
      <!-- Basic Details Card -->
      <div class="admin-card">
        <div class="admin-card-header">
          <h3 class="admin-card-title"><i class="bi bi-info-circle text-primary"></i> Basic Product Information</h3>
        </div>
        <div class="admin-card-body">
          
          <div class="mb-3">
            <label class="form-label">Product Name <span class="text-danger">*</span></label>
            <input type="text" name="name" class="form-control" placeholder="e.g. Yonex Astrox 100ZZ Kurenai" required value="<?= htmlspecialchars($_POST['name'] ?? '') ?>">
          </div>

          <div class="row g-3 mb-3">
            <div class="col-md-6">
              <label class="form-label">Brand <span class="text-danger">*</span></label>
              <input type="text" name="brand" class="form-control" placeholder="e.g. Yonex, Li-Ning, Victor, Wish" required value="<?= htmlspecialchars($_POST['brand'] ?? '') ?>">
            </div>
            <div class="col-md-6">
              <label class="form-label">Category <span class="text-danger">*</span></label>
              <select name="category_id" class="form-select" required>
                <option value="">Select Category...</option>
                <?php foreach ($categories as $cat): ?>
                  <option value="<?= $cat['id'] ?>" <?= ($_POST['category_id'] ?? '') == $cat['id'] ? 'selected' : '' ?>>
                    <?= htmlspecialchars($cat['name']) ?>
                  </option>
                <?php endforeach; ?>
              </select>
            </div>
          </div>

          <div class="mb-3">
            <label class="form-label">Product Description</label>
            <textarea name="description" class="form-control" rows="4" placeholder="Detailed product specifications, materials, performance features..."><?= htmlspecialchars($_POST['description'] ?? '') ?></textarea>
          </div>

        </div>
      </div>

      <!-- Pricing & Inventory Card -->
      <div class="admin-card">
        <div class="admin-card-header">
          <h3 class="admin-card-title"><i class="bi bi-cash-stack text-success"></i> Pricing & Inventory Stock</h3>
        </div>
        <div class="admin-card-body">
          
          <div class="row g-3 mb-3">
            <div class="col-md-4">
              <label class="form-label">Regular Price (LKR) <span class="text-danger">*</span></label>
              <div class="input-group">
                <span class="input-group-text">Rs.</span>
                <input type="number" step="0.01" name="price" class="form-control" placeholder="45000.00" required value="<?= htmlspecialchars($_POST['price'] ?? '') ?>">
              </div>
            </div>
            <div class="col-md-4">
              <label class="form-label">Original / Old Price (LKR)</label>
              <div class="input-group">
                <span class="input-group-text">Rs.</span>
                <input type="number" step="0.01" name="old_price" class="form-control" placeholder="52000.00" value="<?= htmlspecialchars($_POST['old_price'] ?? '') ?>">
              </div>
            </div>
            <div class="col-md-4">
              <label class="form-label">Stock Quantity <span class="text-danger">*</span></label>
              <input type="number" name="stock" class="form-control" value="<?= htmlspecialchars($_POST['stock'] ?? 15) ?>" required min="0">
            </div>
          </div>

          <div class="row g-3">
            <div class="col-md-4">
              <label class="form-label">Spec #1 (e.g. Weight/Balance)</label>
              <input type="text" name="spec_1" class="form-control" placeholder="Head Heavy / 4U (83g)" value="<?= htmlspecialchars($_POST['spec_1'] ?? '') ?>">
            </div>
            <div class="col-md-4">
              <label class="form-label">Spec #2 (e.g. Level/Flex)</label>
              <input type="text" name="spec_2" class="form-control" placeholder="Advanced / Extra Stiff" value="<?= htmlspecialchars($_POST['spec_2'] ?? '') ?>">
            </div>
            <div class="col-md-4">
              <label class="form-label">Spec #3 (e.g. Size/Color)</label>
              <input type="text" name="spec_3" class="form-control" placeholder="Red Edition / Speed 77" value="<?= htmlspecialchars($_POST['spec_3'] ?? '') ?>">
            </div>
          </div>

        </div>
      </div>

    </div>

    <!-- Right Sidebar Column: Image Upload & Status Settings -->
    <div class="col-lg-4">
      
      <!-- Image Upload Card -->
      <div class="admin-card">
        <div class="admin-card-header">
          <h3 class="admin-card-title"><i class="bi bi-image text-warning"></i> Product Image</h3>
        </div>
        <div class="admin-card-body image-upload-wrapper">
          
          <div class="image-upload-box mb-3" onclick="document.getElementById('productImageInput').click();">
            <i class="bi bi-cloud-arrow-up"></i>
            <h6 class="fw-bold mb-1">Click to Upload Image</h6>
            <p class="small text-muted mb-0">Supported formats: JPG, PNG, WEBP (Max 5MB)</p>
            <input type="file" id="productImageInput" name="product_image" class="d-none image-upload-input" accept="image/jpeg,image/png,image/webp">
          </div>

          <div id="imagePreviewBox" class="image-preview-container text-center">
            <img src="../images/logo/logo.png" alt="Preview Image" class="img-fluid rounded">
          </div>

        </div>
      </div>

      <!-- Visibility & Status Card -->
      <div class="admin-card">
        <div class="admin-card-header">
          <h3 class="admin-card-title"><i class="bi bi-sliders text-info"></i> Visibility & Badges</h3>
        </div>
        <div class="admin-card-body">
          
          <div class="mb-3">
            <label class="form-label">Store Status</label>
            <select name="status" class="form-select">
              <option value="active" selected>Active (Visible on Customer Site)</option>
              <option value="inactive">Inactive (Hidden from Customer Site)</option>
            </select>
          </div>

          <div class="mb-3">
            <label class="form-label">Badge Tag Text</label>
            <input type="text" name="badge" class="form-control" placeholder="NEW, PRO CHOICE, BESTSELLER" value="NEW">
          </div>

          <div class="mb-4">
            <label class="form-label">Badge Styling</label>
            <select name="badge_class" class="form-select">
              <option value="badge-new">New Arrival (Green / Blue)</option>
              <option value="badge-hot">Hot Deal (Orange / Red)</option>
              <option value="badge-sale">Sale Discount (Yellow)</option>
            </select>
          </div>

          <button type="submit" class="btn btn-primary-green w-100 py-3 font-semibold fs-6 shadow-sm">
            <i class="bi bi-check-circle-fill me-2"></i> SAVE & PUBLISH PRODUCT
          </button>

        </div>
      </div>

    </div>

  </div>
</form>

<?php require_once __DIR__ . '/includes/footer.php'; ?>
