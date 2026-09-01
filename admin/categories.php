<?php
/**
 * SmashZone - Category Management (admin/categories.php)
 * Add, Edit, Delete/Deactivate Categories with Dynamic MySQL Sync
 */

$pageTitle = "Categories Management";
$currentPage = "categories";

require_once __DIR__ . '/includes/auth_check.php';
require_once __DIR__ . '/includes/functions.php';
require_once __DIR__ . '/../includes/db.php';

$errorMessage = '';
$successMessage = '';

// Handle Form Submissions (Add / Edit / Delete)
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    verify_csrf_token();
    $action = $_POST['form_action'] ?? '';

    if ($action === 'add') {
        $name = trim($_POST['name'] ?? '');
        $slug = strtolower(trim(preg_replace('/[^A-Za-z0-9-]+/', '-', $name)));
        $description = trim($_POST['description'] ?? '');
        $status = $_POST['status'] === 'inactive' ? 'inactive' : 'active';

        if (empty($name)) {
            $errorMessage = "Category name is required.";
        } else {
            // Check if slug exists
            $chk = $pdo->prepare("SELECT id FROM categories WHERE slug = ?");
            $chk->execute([$slug]);
            if ($chk->fetch()) {
                $slug .= '-' . time();
            }

            $stmt = $pdo->prepare("INSERT INTO categories (name, slug, description, image, status) VALUES (?, ?, ?, 'images/categories/category-rackets.png', ?)");
            if ($stmt->execute([$name, $slug, $description, $status])) {
                $successMessage = "New category '$name' added successfully!";
            }
        }
    } elseif ($action === 'edit') {
        $catId = (int)($_POST['category_id'] ?? 0);
        $name = trim($_POST['name'] ?? '');
        $description = trim($_POST['description'] ?? '');
        $status = $_POST['status'] === 'inactive' ? 'inactive' : 'active';

        if ($catId > 0 && !empty($name)) {
            $stmt = $pdo->prepare("UPDATE categories SET name = ?, description = ?, status = ? WHERE id = ?");
            if ($stmt->execute([$name, $description, $status, $catId])) {
                $successMessage = "Category updated successfully!";
            }
        }
    } elseif ($action === 'toggle_status') {
        $catId = (int)($_POST['category_id'] ?? 0);
        $newStatus = $_POST['new_status'] === 'inactive' ? 'inactive' : 'active';
        if ($catId > 0) {
            $stmt = $pdo->prepare("UPDATE categories SET status = ? WHERE id = ?");
            $stmt->execute([$newStatus, $catId]);
            $successMessage = "Category status updated.";
        }
    }
}

// Fetch all categories with product count
$categories = $pdo->query("SELECT c.*, COUNT(p.id) as product_count 
                           FROM categories c 
                           LEFT JOIN products p ON c.id = p.category_id 
                           GROUP BY c.id 
                           ORDER BY c.id ASC")->fetchAll();

require_once __DIR__ . '/includes/header.php';
?>

<!-- Header -->
<div class="page-header">
  <div class="page-title-group">
    <h1><i class="bi bi-tags text-primary me-2"></i>Categories Management</h1>
    <p class="page-subtitle">Organize SmashZone badminton catalog structure and navigation categories.</p>
  </div>
  <div>
    <button class="btn btn-primary-green" data-bs-toggle="modal" data-bs-target="#addCategoryModal">
      <i class="bi bi-plus-lg"></i> + Add New Category
    </button>
  </div>
</div>

<?php if (!empty($successMessage)): ?>
  <div class="alert alert-success rounded-4 shadow-sm mb-4">
    <i class="bi bi-check-circle-fill me-2"></i> <?= htmlspecialchars($successMessage) ?>
  </div>
<?php endif; ?>

<?php if (!empty($errorMessage)): ?>
  <div class="alert alert-danger rounded-4 shadow-sm mb-4">
    <i class="bi bi-exclamation-triangle-fill me-2"></i> <?= htmlspecialchars($errorMessage) ?>
  </div>
<?php endif; ?>

<!-- Categories Grid / Table -->
<div class="admin-card">
  <div class="admin-card-header">
    <h3 class="admin-card-title">
      <i class="bi bi-grid-3x3-gap text-primary"></i> Store Categories (<?= count($categories) ?> Total)
    </h3>
  </div>

  <div class="table-responsive">
    <table class="admin-table">
      <thead>
        <tr>
          <th>ID</th>
          <th>Category Name</th>
          <th>Slug</th>
          <th>Description</th>
          <th>Products Count</th>
          <th>Status</th>
          <th class="text-end">Actions</th>
        </tr>
      </thead>
      <tbody>
        <?php foreach ($categories as $cat): ?>
          <tr>
            <td class="fw-bold text-muted">#<?= $cat['id'] ?></td>
            <td>
              <div class="fw-bold text-dark fs-6"><?= htmlspecialchars($cat['name']) ?></div>
            </td>
            <td>
              <span class="font-monospace small text-primary bg-primary-subtle px-2 py-1 rounded">
                <?= htmlspecialchars($cat['slug']) ?>
              </span>
            </td>
            <td>
              <small class="text-muted" style="max-width: 280px; display: block; overflow: hidden; text-overflow: ellipsis; white-space: nowrap;">
                <?= htmlspecialchars($cat['description'] ?: 'No description') ?>
              </small>
            </td>
            <td>
              <span class="badge bg-success-subtle text-success font-semibold px-3 py-1 rounded-pill">
                <?= $cat['product_count'] ?> Products
              </span>
            </td>
            <td>
              <span class="badge-status badge-status-<?= $cat['status'] ?? 'active' ?>">
                <?= ucfirst($cat['status'] ?? 'active') ?>
              </span>
            </td>
            <td class="text-end">
              <div class="d-inline-flex gap-1">
                <!-- Edit Modal Button -->
                <button type="button" class="btn-action-icon" data-bs-toggle="modal" data-bs-target="#editCategoryModal<?= $cat['id'] ?>" title="Edit Category">
                  <i class="bi bi-pencil-fill text-primary"></i>
                </button>

                <!-- Toggle Status -->
                <form method="POST" action="categories.php" class="d-inline">
                  <input type="hidden" name="csrf_token" value="<?= $_SESSION['csrf_token'] ?>">
                  <input type="hidden" name="form_action" value="toggle_status">
                  <input type="hidden" name="category_id" value="<?= $cat['id'] ?>">
                  <input type="hidden" name="new_status" value="<?= ($cat['status'] ?? 'active') === 'active' ? 'inactive' : 'active' ?>">
                  <button type="submit" class="btn-action-icon" title="Toggle Status">
                    <i class="bi bi-power <?= ($cat['status'] ?? 'active') === 'active' ? 'text-danger' : 'text-success' ?>"></i>
                  </button>
                </form>
              </div>

              <!-- Edit Category Modal -->
              <div class="modal fade" id="editCategoryModal<?= $cat['id'] ?>" tabindex="-1" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered">
                  <div class="modal-content border-0 shadow-lg rounded-4 text-start">
                    <form method="POST" action="categories.php">
                      <input type="hidden" name="csrf_token" value="<?= $_SESSION['csrf_token'] ?>">
                      <input type="hidden" name="form_action" value="edit">
                      <input type="hidden" name="category_id" value="<?= $cat['id'] ?>">

                      <div class="modal-header border-bottom p-4">
                        <h5 class="modal-title fw-bold"><i class="bi bi-pencil-square me-2 text-success"></i>Edit Category</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                      </div>

                      <div class="modal-body p-4">
                        <div class="mb-3">
                          <label class="form-label">Category Name</label>
                          <input type="text" name="name" class="form-control" value="<?= htmlspecialchars($cat['name']) ?>" required>
                        </div>
                        <div class="mb-3">
                          <label class="form-label">Description</label>
                          <textarea name="description" class="form-control" rows="3"><?= htmlspecialchars($cat['description']) ?></textarea>
                        </div>
                        <div class="mb-3">
                          <label class="form-label">Status</label>
                          <select name="status" class="form-select">
                            <option value="active" <?= ($cat['status'] ?? 'active') === 'active' ? 'selected' : '' ?>>Active</option>
                            <option value="inactive" <?= ($cat['status'] ?? '') === 'inactive' ? 'selected' : '' ?>>Inactive</option>
                          </select>
                        </div>
                      </div>

                      <div class="modal-footer border-top p-3">
                        <button type="button" class="btn btn-secondary-light" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-primary-green">Save Changes</button>
                      </div>
                    </form>
                  </div>
                </div>
              </div>

            </td>
          </tr>
        <?php endforeach; ?>
      </tbody>
    </table>
  </div>
</div>

<!-- Add Category Modal -->
<div class="modal fade" id="addCategoryModal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content border-0 shadow-lg rounded-4">
      <form method="POST" action="categories.php">
        <input type="hidden" name="csrf_token" value="<?= $_SESSION['csrf_token'] ?>">
        <input type="hidden" name="form_action" value="add">

        <div class="modal-header border-bottom p-4">
          <h5 class="modal-title fw-bold"><i class="bi bi-folder-plus me-2 text-success"></i>Add New Category</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
        </div>

        <div class="modal-body p-4">
          <div class="mb-3">
            <label class="form-label">Category Name <span class="text-danger">*</span></label>
            <input type="text" name="name" class="form-control" placeholder="e.g. Badminton Strings" required>
          </div>
          <div class="mb-3">
            <label class="form-label">Description</label>
            <textarea name="description" class="form-control" rows="3" placeholder="Brief category description..."></textarea>
          </div>
          <div class="mb-3">
            <label class="form-label">Status</label>
            <select name="status" class="form-select">
              <option value="active" selected>Active</option>
              <option value="inactive">Inactive</option>
            </select>
          </div>
        </div>

        <div class="modal-footer border-top p-3">
          <button type="button" class="btn btn-secondary-light" data-bs-dismiss="modal">Cancel</button>
          <button type="submit" class="btn btn-primary-green">Create Category</button>
        </div>
      </form>
    </div>
  </div>
</div>

<?php require_once __DIR__ . '/includes/footer.php'; ?>
