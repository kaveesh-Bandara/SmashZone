<?php
/**
 * SmashZone - PayHere Payment Gateway Callback (payhere_callback.php)
 * Handles customer return & cancel redirects from PayHere Gateway
 */

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

require_once __DIR__ . '/includes/db.php';
require_once __DIR__ . '/includes/payhere_config.php';

$pageTitle = "Payment Status — SmashZone Sri Lanka";
$pageMetaDesc = "PayHere Payment Gateway transaction results for your SmashZone order.";

$status = trim($_GET['status'] ?? '');
$orderId = intval($_GET['order_id'] ?? 0);

$order = null;
$orderItems = [];

if ($orderId > 0) {
    $stmt = $pdo->prepare("SELECT * FROM orders WHERE id = ?");
    $stmt->execute([$orderId]);
    $order = $stmt->fetch();

    if ($order) {
        $itemsStmt = $pdo->prepare("SELECT oi.*, p.name, p.image FROM order_items oi JOIN products p ON oi.product_id = p.id WHERE oi.order_id = ?");
        $itemsStmt->execute([$orderId]);
        $orderItems = $itemsStmt->fetchAll();

        // If payment return was successful, mark payment_status as paid and clear session cart
        if ($status === 'success') {
            $updateStmt = $pdo->prepare("UPDATE orders SET payment_status = 'paid', status = 'processing' WHERE id = ?");
            $updateStmt->execute([$orderId]);
            $_SESSION['cart'] = [];
            $order['payment_status'] = 'paid';
            $order['status'] = 'processing';
        }
    }
}

require_once __DIR__ . '/includes/header.php';
?>

<section class="checkout-hero-banner py-4" style="background: linear-gradient(135deg, #051329 0%, #082F5A 50%, #0B4F9C 100%); color: white;">
  <div class="container">
    <h2 class="fw-bold mb-1 font-heading text-white">Payment <span class="text-warning">Status</span></h2>
    <p class="text-light opacity-85 small mb-0">PayHere Instant Payment Gateway Processing Result</p>
  </div>
</section>

<main class="py-5">
  <div class="container">
    <div class="row justify-content-center">
      <div class="col-lg-8">
        
        <?php if ($status === 'success' && $order): ?>

          <!-- SUCCESS PAYMENT CONFIRMATION SCREEN -->
          <div class="card border-0 shadow-lg rounded-4 overflow-hidden text-center p-4 p-md-5">
            <div class="mb-3">
              <div class="d-inline-flex align-items-center justify-content-center bg-success text-white rounded-circle shadow" style="width: 84px; height: 84px;">
                <i class="bi bi-shield-check display-3"></i>
              </div>
            </div>

            <span class="badge bg-success-subtle text-success font-semibold px-3 py-1.5 rounded-pill mx-auto mb-3 fs-6">
              <i class="bi bi-patch-check-fill me-1"></i> PayHere Online Card Payment Successful
            </span>

            <h2 class="fw-bold text-navy font-heading">Thank You For Your Payment!</h2>
            <p class="text-muted fs-6 mb-4">
              Order Reference Number: <strong class="text-primary font-monospace">#SMZ-<?= sprintf('%05d', $order['id']) ?></strong>
              <?php if (!empty($order['payhere_payment_id'])): ?>
                <br><small class="text-muted">PayHere Transaction Ref: <code><?= htmlspecialchars($order['payhere_payment_id']) ?></code></small>
              <?php endif; ?>
            </p>

            <div class="p-4 bg-light rounded-4 text-start mb-4 border">
              <div class="row g-3">
                <div class="col-md-6">
                  <h6 class="fw-bold text-navy mb-1"><i class="bi bi-credit-card-fill text-primary me-1"></i> Payment Summary</h6>
                  <div class="small text-muted">Method: <strong class="text-dark">PayHere Online Gateway (Visa/MasterCard/Amex)</strong></div>
                  <div class="small text-muted">Payment Status: <span class="badge bg-success text-white">PAID</span></div>
                  <div class="small text-dark fw-bold mt-1 fs-6">Total Amount Paid: Rs. <?= number_format($order['total_amount'], 2) ?></div>
                </div>
                <div class="col-md-6">
                  <h6 class="fw-bold text-navy mb-1"><i class="bi bi-truck text-success me-1"></i> Order & Delivery Status</h6>
                  <div class="small text-muted">Order Status: <span class="badge bg-primary text-white"><?= strtoupper($order['status']) ?></span></div>
                  <div class="small text-success mt-1 fw-bold"><i class="bi bi-box-seam me-1"></i> Preparing for Islandwide Delivery (2-3 Business Days)</div>
                </div>
              </div>
            </div>

            <!-- Ordered Items Breakdown -->
            <h5 class="fw-bold text-navy font-heading text-start mb-3"><i class="bi bi-bag-check-fill text-warning me-2"></i> Items Included in Order</h5>
            <div class="table-responsive text-start mb-4">
              <table class="table table-bordered align-middle">
                <thead class="table-light">
                  <tr>
                    <th>Item Description</th>
                    <th class="text-center">Qty</th>
                    <th class="text-end">Price</th>
                  </tr>
                </thead>
                <tbody>
                  <?php foreach ($orderItems as $it): ?>
                    <tr>
                      <td>
                        <div class="d-flex align-items-center gap-2">
                          <img src="<?= htmlspecialchars($it['image']) ?>" alt="Product" style="width:42px; height:42px; object-fit:cover; border-radius:8px;">
                          <span class="fw-bold small"><?= htmlspecialchars($it['name']) ?></span>
                        </div>
                      </td>
                      <td class="text-center font-bold">x<?= $it['quantity'] ?></td>
                      <td class="text-end fw-bold text-success">Rs. <?= number_format($it['price'] * $it['quantity'], 2) ?></td>
                    </tr>
                  <?php endforeach; ?>
                </tbody>
                <tfoot>
                  <tr>
                    <td colspan="2" class="text-end font-semibold fs-6">Total Paid:</td>
                    <td class="text-end fw-bold text-primary fs-5">Rs. <?= number_format($order['total_amount'], 2) ?></td>
                  </tr>
                </tfoot>
              </table>
            </div>

            <div class="d-flex justify-content-center gap-3 flex-wrap">
              <a href="account.php" class="btn btn-primary-green px-4 py-2.5 font-semibold rounded-pill">
                <i class="bi bi-clock-history me-1"></i> View Order History in My Account
              </a>
              <a href="index.php" class="btn btn-secondary-light px-4 py-2.5 font-semibold rounded-pill">
                <i class="bi bi-cart me-1"></i> Continue Shopping
              </a>
            </div>

          </div>

        <?php else: ?>

          <!-- CANCELLED OR FAILED PAYMENT SCREEN -->
          <div class="card border-0 shadow-lg rounded-4 overflow-hidden text-center p-4 p-md-5">
            <div class="mb-3">
              <div class="d-inline-flex align-items-center justify-content-center bg-danger-subtle text-danger rounded-circle shadow-sm" style="width: 84px; height: 84px;">
                <i class="bi bi-exclamation-octagon display-3"></i>
              </div>
            </div>

            <span class="badge bg-danger-subtle text-danger font-semibold px-3 py-1.5 rounded-pill mx-auto mb-3 fs-6">
              <i class="bi bi-x-circle-fill me-1"></i> PayHere Payment Cancelled or Incomplete
            </span>

            <h3 class="fw-bold text-navy font-heading">Online Payment Was Not Completed</h3>
            <p class="text-muted fs-6 mb-4">
              Your order transaction was not processed by PayHere. No charges were made to your account.
              <?php if ($orderId > 0): ?>
                <br>Order Reference Number: <strong class="text-dark font-monospace">#SMZ-<?= sprintf('%05d', $orderId) ?></strong>
              <?php endif; ?>
            </p>

            <div class="p-3 bg-light rounded-3 text-start mb-4 border border-warning">
              <div class="d-flex align-items-center gap-2 text-dark font-semibold">
                <i class="bi bi-info-circle-fill text-warning fs-5"></i>
                <span>What happens next?</span>
              </div>
              <p class="small text-muted mb-0 mt-1">
                Your order items are still saved in your cart. You can return to the checkout page to re-attempt your card payment via PayHere or select Cash on Delivery / Direct Bank Transfer.
              </p>
            </div>

            <div class="d-flex justify-content-center gap-3 flex-wrap">
              <a href="checkout.php" class="btn btn-hero-orange px-4 py-2.5 font-semibold rounded-pill">
                <i class="bi bi-arrow-counterclockwise me-1"></i> Return to Checkout & Retry Payment
              </a>
              <a href="cart.php" class="btn btn-secondary-light px-4 py-2.5 font-semibold rounded-pill">
                <i class="bi bi-bag-fill me-1"></i> View Shopping Cart
              </a>
            </div>

          </div>

        <?php endif; ?>

      </div>
    </div>
  </div>
</main>

<?php require_once __DIR__ . '/includes/footer.php'; ?>
