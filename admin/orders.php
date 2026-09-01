<?php
/**
 * SmashZone - Orders Management (admin/orders.php)
 * View customer orders, detailed item modal, and status updates
 */

$pageTitle = "Orders Management";
$currentPage = "orders";

require_once __DIR__ . '/includes/auth_check.php';
require_once __DIR__ . '/includes/functions.php';
require_once __DIR__ . '/../includes/db.php';

$successMessage = '';
$errorMessage = '';

// Handle Status Update POST
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'update_status') {
    verify_csrf_token();

    $orderId = (int)($_POST['order_id'] ?? 0);
    $newStatus = trim($_POST['status'] ?? '');

    $allowedStatuses = ['pending', 'processing', 'shipped', 'delivered', 'cancelled'];
    if ($orderId > 0 && in_array($newStatus, $allowedStatuses)) {
        $stmt = $pdo->prepare("UPDATE orders SET status = ? WHERE id = ?");
        if ($stmt->execute([$newStatus, $orderId])) {
            $successMessage = "Order #SMZ-" . sprintf('%05d', $orderId) . " status updated to " . ucfirst($newStatus) . ".";
        }
    }
}

require_once __DIR__ . '/includes/header.php';

// Filtering
$statusFilter = $_GET['status'] ?? '';
$searchQuery = trim($_GET['search'] ?? '');

$sql = "SELECT o.*, u.first_name, u.last_name, u.email, u.phone 
        FROM orders o 
        JOIN users u ON o.user_id = u.id 
        WHERE 1=1";
$params = [];

if (!empty($statusFilter)) {
    $sql .= " AND o.status = ?";
    $params[] = $statusFilter;
}

if (!empty($searchQuery)) {
    $sql .= " AND (o.id LIKE ? OR u.first_name LIKE ? OR u.last_name LIKE ? OR u.email LIKE ?)";
    $params[] = "%$searchQuery%";
    $params[] = "%$searchQuery%";
    $params[] = "%$searchQuery%";
    $params[] = "%$searchQuery%";
}

$sql .= " ORDER BY o.created_at DESC";

$stmt = $pdo->prepare($sql);
$stmt->execute($params);
$orders = $stmt->fetchAll();
?>

<!-- Header -->
<div class="page-header">
  <div class="page-title-group">
    <h1><i class="bi bi-receipt text-primary me-2"></i>Orders Management</h1>
    <p class="page-subtitle">Track, review, and process customer equipment orders.</p>
  </div>
</div>

<?php if (!empty($successMessage)): ?>
  <div class="alert alert-success rounded-4 shadow-sm mb-4">
    <i class="bi bi-check-circle-fill me-2"></i> <?= htmlspecialchars($successMessage) ?>
  </div>
<?php endif; ?>

<!-- Filter Toolbar -->
<div class="admin-card mb-4">
  <div class="admin-card-body p-3">
    <form method="GET" action="orders.php" class="row g-3 align-items-center">
      <div class="col-md-5">
        <div class="input-group">
          <span class="input-group-text bg-light"><i class="bi bi-search"></i></span>
          <input type="text" name="search" class="form-control" placeholder="Search Order ID, Customer Name, Email..." value="<?= htmlspecialchars($searchQuery) ?>">
        </div>
      </div>
      <div class="col-md-4">
        <select name="status" class="form-select" onchange="this.form.submit()">
          <option value="">All Order Statuses</option>
          <option value="pending" <?= $statusFilter === 'pending' ? 'selected' : '' ?>>Pending</option>
          <option value="processing" <?= $statusFilter === 'processing' ? 'selected' : '' ?>>Processing</option>
          <option value="shipped" <?= $statusFilter === 'shipped' ? 'selected' : '' ?>>Shipped</option>
          <option value="delivered" <?= $statusFilter === 'delivered' ? 'selected' : '' ?>>Delivered</option>
          <option value="cancelled" <?= $statusFilter === 'cancelled' ? 'selected' : '' ?>>Cancelled</option>
        </select>
      </div>
      <div class="col-md-3 d-flex gap-2">
        <button type="submit" class="btn btn-primary-green w-100">Filter Orders</button>
        <?php if (!empty($searchQuery) || !empty($statusFilter)): ?>
          <a href="orders.php" class="btn btn-secondary-light"><i class="bi bi-x-lg"></i></a>
        <?php endif; ?>
      </div>
    </form>
  </div>
</div>

<!-- Orders Table -->
<div class="admin-card">
  <div class="admin-card-header">
    <h3 class="admin-card-title">
      <i class="bi bi-bag-check text-primary"></i> Customer Orders (<?= count($orders) ?> Total)
    </h3>
  </div>

  <div class="table-responsive">
    <table class="admin-table">
      <thead>
        <tr>
          <th>Order Ref</th>
          <th>Customer Name</th>
          <th>Email</th>
          <th>Total Amount</th>
          <th>Status</th>
          <th>Date</th>
          <th class="text-end">Actions</th>
        </tr>
      </thead>
      <tbody>
        <?php if (empty($orders)): ?>
          <tr>
            <td colspan="7" class="text-center py-5 text-muted">
              <i class="bi bi-inbox fs-2 d-block mb-2 text-secondary"></i>
              No orders found matching criteria.
            </td>
          </tr>
        <?php else: ?>
          <?php foreach ($orders as $ord): ?>
            <?php
              // Fetch items for modal
              $itemsStmt = $pdo->prepare("SELECT oi.*, p.name as product_name, p.image 
                                          FROM order_items oi 
                                          JOIN products p ON oi.product_id = p.id 
                                          WHERE oi.order_id = ?");
              $itemsStmt->execute([$ord['id']]);
              $items = $itemsStmt->fetchAll();
            ?>
            <tr>
              <td>
                <span class="fw-bold font-monospace text-primary">#SMZ-<?= sprintf('%05d', $ord['id']) ?></span>
              </td>
              <td>
                <div class="fw-bold"><?= htmlspecialchars($ord['first_name'] . ' ' . $ord['last_name']) ?></div>
                <small class="text-muted"><?= htmlspecialchars($ord['phone'] ?: 'No phone') ?></small>
              </td>
              <td>
                <small class="text-muted"><?= htmlspecialchars($ord['email']) ?></small>
              </td>
              <td>
                <span class="fw-bold text-success">Rs. <?= number_format($ord['total_amount'], 2) ?></span>
              </td>
              <td>
                <span class="badge-status badge-status-<?= strtolower($ord['status']) ?>">
                  <?= ucfirst($ord['status']) ?>
                </span>
              </td>
              <td>
                <small class="text-muted"><?= date('M d, Y H:i', strtotime($ord['created_at'])) ?></small>
              </td>
              <td class="text-end">
                <button type="button" class="btn btn-sm btn-outline-success font-semibold rounded-pill px-3" data-bs-toggle="modal" data-bs-target="#orderModal<?= $ord['id'] ?>">
                  <i class="bi bi-eye-fill me-1"></i> View Details
                </button>

                <!-- Order Details & Update Status Modal -->
                <div class="modal fade" id="orderModal<?= $ord['id'] ?>" tabindex="-1" aria-hidden="true">
                  <div class="modal-dialog modal-dialog-centered modal-lg">
                    <div class="modal-content border-0 shadow-lg rounded-4 text-start">
                      
                      <div class="modal-header border-bottom p-4 bg-light">
                        <div>
                          <h5 class="modal-title fw-bold text-dark">Order #SMZ-<?= sprintf('%05d', $ord['id']) ?></h5>
                          <small class="text-muted">Placed on <?= date('F j, Y \a\t g:i A', strtotime($ord['created_at'])) ?></small>
                        </div>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                      </div>

                      <div class="modal-body p-4">
                        
                        <!-- Customer Info Row -->
                        <div class="row g-3 mb-4">
                          <div class="col-md-6">
                            <div class="p-3 bg-light rounded-3 border">
                              <h6 class="fw-bold text-primary mb-2"><i class="bi bi-person-fill me-1"></i> Customer Information</h6>
                              <div class="fw-bold"><?= htmlspecialchars($ord['first_name'] . ' ' . $ord['last_name']) ?></div>
                              <div class="small text-muted"><?= htmlspecialchars($ord['email']) ?></div>
                              <div class="small text-muted"><?= htmlspecialchars($ord['phone'] ?: 'N/A') ?></div>
                            </div>
                          </div>
                          <div class="col-md-6">
                            <div class="p-3 bg-light rounded-3 border">
                              <h6 class="fw-bold text-primary mb-2"><i class="bi bi-geo-alt-fill me-1"></i> Delivery Shipping Address</h6>
                              <div class="small text-dark"><?= nl2br(htmlspecialchars($ord['shipping_address'] ?: 'Standard Store Pickup / Local Delivery')) ?></div>
                            </div>
                          </div>
                        </div>

                        <!-- Order Items Table -->
                        <h6 class="fw-bold text-dark mb-3"><i class="bi bi-box-seam me-1 text-success"></i> Ordered Equipment Items</h6>
                        <div class="table-responsive mb-4">
                          <table class="table table-bordered align-middle">
                            <thead class="table-light">
                              <tr>
                                <th>Item Description</th>
                                <th>Unit Price</th>
                                <th>Qty</th>
                                <th class="text-end">Subtotal</th>
                              </tr>
                            </thead>
                            <tbody>
                              <?php if (empty($items)): ?>
                                <tr>
                                  <td colspan="4" class="text-center text-muted">Standard Order Item Record (Total Rs. <?= number_format($ord['total_amount'], 2) ?>)</td>
                                </tr>
                              <?php else: ?>
                                <?php foreach ($items as $it): ?>
                                  <tr>
                                    <td>
                                      <div class="product-cell">
                                        <img src="../<?= htmlspecialchars($it['image']) ?>" alt="Product" class="product-thumb" onerror="this.src='../images/logo/logo.png'">
                                        <span class="fw-bold text-dark"><?= htmlspecialchars($it['product_name']) ?></span>
                                      </div>
                                    </td>
                                    <td>Rs. <?= number_format($it['price'], 2) ?></td>
                                    <td><strong>x<?= $it['quantity'] ?></strong></td>
                                    <td class="text-end fw-bold text-success">Rs. <?= number_format($it['price'] * $it['quantity'], 2) ?></td>
                                  </tr>
                                <?php endforeach; ?>
                              <?php endif; ?>
                            </tbody>
                            <tfoot>
                              <tr>
                                <th colspan="3" class="text-end font-semibold fs-6">Order Total:</th>
                                <th class="text-end fw-bold text-success fs-5">Rs. <?= number_format($ord['total_amount'], 2) ?></th>
                              </tr>
                            </tfoot>
                          </table>
                        </div>

                        <!-- Status Update Form -->
                        <form method="POST" action="orders.php" class="p-3 bg-light rounded-3 border">
                          <input type="hidden" name="csrf_token" value="<?= $_SESSION['csrf_token'] ?>">
                          <input type="hidden" name="action" value="update_status">
                          <input type="hidden" name="order_id" value="<?= $ord['id'] ?>">

                          <div class="row align-items-center g-3">
                            <div class="col-md-7">
                              <label class="form-label font-semibold mb-1">Update Order Status:</label>
                              <select name="status" class="form-select font-semibold">
                                <option value="pending" <?= $ord['status'] === 'pending' ? 'selected' : '' ?>>Pending (Awaiting Confirmation)</option>
                                <option value="processing" <?= $ord['status'] === 'processing' ? 'selected' : '' ?>>Processing (Preparing Shipment)</option>
                                <option value="shipped" <?= $ord['status'] === 'shipped' ? 'selected' : '' ?>>Shipped (In Transit)</option>
                                <option value="delivered" <?= $ord['status'] === 'delivered' ? 'selected' : '' ?>>Delivered (Completed)</option>
                                <option value="cancelled" <?= $ord['status'] === 'cancelled' ? 'selected' : '' ?>>Cancelled</option>
                              </select>
                            </div>
                            <div class="col-md-5 mt-md-4">
                              <button type="submit" class="btn btn-primary-green w-100 font-semibold py-2">
                                <i class="bi bi-save me-1"></i> Update Status
                              </button>
                            </div>
                          </div>
                        </form>

                      </div>

                    </div>
                  </div>
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
