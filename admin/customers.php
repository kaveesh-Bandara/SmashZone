<?php
/**
 * SmashZone - Customer Account Management (admin/customers.php)
 * Lists customer accounts, order counts, status toggling. Passwords kept strictly secure.
 */

$pageTitle = "Customer Accounts";
$currentPage = "customers";

require_once __DIR__ . '/includes/auth_check.php';
require_once __DIR__ . '/includes/functions.php';
require_once __DIR__ . '/../includes/db.php';

$successMessage = '';

// Handle Status Toggle POST
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'toggle_customer_status') {
    verify_csrf_token();

    $userId = (int)($_POST['user_id'] ?? 0);
    $newStatus = $_POST['new_status'] === 'suspended' ? 'suspended' : 'active';

    if ($userId > 0) {
        $stmt = $pdo->prepare("UPDATE users SET status = ? WHERE id = ? AND role = 'customer'");
        if ($stmt->execute([$newStatus, $userId])) {
            $successMessage = "Customer account status updated to " . ucfirst($newStatus) . ".";
        }
    }
}

require_once __DIR__ . '/includes/header.php';

// Search
$searchQuery = trim($_GET['search'] ?? '');

$sql = "SELECT u.*, COUNT(o.id) as total_orders 
        FROM users u 
        LEFT JOIN orders o ON u.id = o.user_id 
        WHERE u.role = 'customer'";
$params = [];

if (!empty($searchQuery)) {
    $sql .= " AND (u.first_name LIKE ? OR u.last_name LIKE ? OR u.email LIKE ? OR u.phone LIKE ?)";
    $params[] = "%$searchQuery%";
    $params[] = "%$searchQuery%";
    $params[] = "%$searchQuery%";
    $params[] = "%$searchQuery%";
}

$sql .= " GROUP BY u.id ORDER BY u.created_at DESC";

$stmt = $pdo->prepare($sql);
$stmt->execute($params);
$customers = $stmt->fetchAll();
?>

<!-- Header -->
<div class="page-header">
  <div class="page-title-group">
    <h1><i class="bi bi-people text-primary me-2"></i>Customer Management</h1>
    <p class="page-subtitle">View and manage registered SmashZone player accounts.</p>
  </div>
</div>

<?php if (!empty($successMessage)): ?>
  <div class="alert alert-success rounded-4 shadow-sm mb-4">
    <i class="bi bi-check-circle-fill me-2"></i> <?= htmlspecialchars($successMessage) ?>
  </div>
<?php endif; ?>

<!-- Search Toolbar -->
<div class="admin-card mb-4">
  <div class="admin-card-body p-3">
    <form method="GET" action="customers.php" class="row g-3 align-items-center">
      <div class="col-md-9">
        <div class="input-group">
          <span class="input-group-text bg-light"><i class="bi bi-search"></i></span>
          <input type="text" name="search" class="form-control" placeholder="Search customer name, email address, phone number..." value="<?= htmlspecialchars($searchQuery) ?>">
        </div>
      </div>
      <div class="col-md-3 d-flex gap-2">
        <button type="submit" class="btn btn-primary-green w-100">Search</button>
        <?php if (!empty($searchQuery)): ?>
          <a href="customers.php" class="btn btn-secondary-light"><i class="bi bi-x-lg"></i></a>
        <?php endif; ?>
      </div>
    </form>
  </div>
</div>

<!-- Customer Table -->
<div class="admin-card">
  <div class="admin-card-header">
    <h3 class="admin-card-title">
      <i class="bi bi-person-lines-fill text-primary"></i> Player Accounts (<?= count($customers) ?> Registered)
    </h3>
  </div>

  <div class="table-responsive">
    <table class="admin-table">
      <thead>
        <tr>
          <th>Customer Name</th>
          <th>Email Address</th>
          <th>Phone Number</th>
          <th>Total Orders</th>
          <th>Status</th>
          <th>Registered Date</th>
          <th class="text-end">Actions</th>
        </tr>
      </thead>
      <tbody>
        <?php if (empty($customers)): ?>
          <tr>
            <td colspan="7" class="text-center py-5 text-muted">
              <i class="bi bi-people fs-2 d-block mb-2 text-secondary"></i>
              No customer accounts found matching your query.
            </td>
          </tr>
        <?php else: ?>
          <?php foreach ($customers as $c): ?>
            <?php 
              $avatar = (!empty($c['profile_picture']) && strpos($c['profile_picture'], 'photo-1534528741775-53994a69daeb') === false) ? htmlspecialchars($c['profile_picture']) : 'images/avatars/default-avatar.svg';
              if (strpos($avatar, 'http') !== 0) {
                  $avatar = '../' . $avatar;
              }
            ?>
            <tr>
              <td>
                <div class="product-cell">
                  <img src="<?= $avatar ?>" alt="Customer Avatar" class="product-thumb rounded-circle" onerror="this.src='../images/avatars/default-avatar.svg'">
                  <div>
                    <span class="product-info-name"><?= htmlspecialchars($c['first_name'] . ' ' . $c['last_name']) ?></span>
                    <small class="text-muted" style="font-size: 0.75rem;">Role: Customer</small>
                  </div>
                </div>
              </td>
              <td>
                <span class="text-dark font-semibold"><?= htmlspecialchars($c['email']) ?></span>
              </td>
              <td>
                <small class="text-muted"><?= htmlspecialchars($c['phone'] ?: 'N/A') ?></small>
              </td>
              <td>
                <span class="badge bg-success-subtle text-success font-semibold px-3 py-1 rounded-pill">
                  <?= $c['total_orders'] ?> Orders
                </span>
              </td>
              <td>
                <span class="badge-status badge-status-<?= $c['status'] === 'active' ? 'active' : 'inactive' ?>">
                  <?= ucfirst($c['status']) ?>
                </span>
              </td>
              <td>
                <small class="text-muted"><?= date('M d, Y', strtotime($c['created_at'])) ?></small>
              </td>
              <td class="text-end">
                <form method="POST" action="customers.php" class="d-inline" onsubmit="return confirm('Are you sure you want to <?= $c['status'] === 'active' ? 'suspend' : 'reactivate' ?> this customer account?');">
                  <input type="hidden" name="csrf_token" value="<?= $_SESSION['csrf_token'] ?>">
                  <input type="hidden" name="action" value="toggle_customer_status">
                  <input type="hidden" name="user_id" value="<?= $c['id'] ?>">
                  <input type="hidden" name="new_status" value="<?= $c['status'] === 'active' ? 'suspended' : 'active' ?>">
                  
                  <button type="submit" class="btn btn-sm <?= $c['status'] === 'active' ? 'btn-outline-danger' : 'btn-outline-success' ?> font-semibold rounded-pill px-3">
                    <?= $c['status'] === 'active' ? '<i class="bi bi-slash-circle me-1"></i> Suspend' : '<i class="bi bi-check-circle me-1"></i> Activate' ?>
                  </button>
                </form>
              </td>
            </tr>
          <?php endforeach; ?>
        <?php endif; ?>
      </tbody>
    </table>
  </div>
</div>

<?php require_once __DIR__ . '/includes/footer.php'; ?>
