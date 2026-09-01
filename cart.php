<?php
/**
 * SmashZone - Professional Customer Shopping Cart Page (cart.php)
 * Full-page interactive cart management, order summary, and checkout gateway.
 */

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

require_once __DIR__ . '/includes/db.php';

// Session Guard: Must be logged in to view shopping cart
if (!isset($_SESSION['user'])) {
    header("Location: index.php?login_required=1");
    exit;
}

$pageTitle = "My Shopping Cart — SmashZone Sri Lanka";
$pageMetaDesc = "Review items in your SmashZone shopping cart, update equipment quantities, and proceed to express checkout.";

// Handle POST Backend Actions (Update Quantity, Remove Item, Clear Cart)
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['cart_action'])) {
    $action = $_POST['cart_action'];
    $productId = (int)($_POST['product_id'] ?? 0);

    if (!isset($_SESSION['cart']) || !is_array($_SESSION['cart'])) {
        $_SESSION['cart'] = [];
    }

    if ($action === 'update_qty' && $productId > 0) {
        $newQty = max(1, (int)($_POST['qty'] ?? 1));
        if (isset($_SESSION['cart'][$productId])) {
            $_SESSION['cart'][$productId]['qty'] = $newQty;
        }
    } elseif ($action === 'remove_item' && $productId > 0) {
        if (isset($_SESSION['cart'][$productId])) {
            unset($_SESSION['cart'][$productId]);
        }
    } elseif ($action === 'clear_cart') {
        $_SESSION['cart'] = [];
    }

    header("Location: cart.php");
    exit;
}

$cart = $_SESSION['cart'] ?? [];

// Calculate Subtotal & Shipping
$subtotal = 0;
foreach ($cart as $item) {
    $subtotal += ($item['price'] * $item['qty']);
}

$freeShippingThreshold = 15000;
$shippingFee = ($subtotal >= $freeShippingThreshold || $subtotal == 0) ? 0 : 450;
$grandTotal = $subtotal + $shippingFee;

require_once __DIR__ . '/includes/header.php';
?>

<style>
  .cart-hero-banner {
    background: linear-gradient(135deg, #051329 0%, #082F5A 50%, #0B4F9C 100%);
    padding: 2.25rem 0;
    color: #ffffff;
    margin-bottom: 2rem;
  }
  .cart-breadcrumb {
    font-size: 0.85rem;
    color: rgba(255,255,255,0.7);
  }
  .cart-breadcrumb a { color: #FF9800; text-decoration: none; }
  .cart-table-card {
    background: #ffffff;
    border-radius: 18px;
    border: 1px solid #E2E8F0;
    box-shadow: 0 4px 15px rgba(0,0,0,0.03);
    overflow: hidden;
    margin-bottom: 1.5rem;
  }
  .cart-table th {
    background-color: #F8FAFC;
    color: #082F5A;
    font-weight: 700;
    font-size: 0.82rem;
    text-transform: uppercase;
    letter-spacing: 0.5px;
    padding: 1rem 1.25rem;
    border-bottom: 1px solid #E2E8F0;
  }
  .cart-table td {
    padding: 1.1rem 1.25rem;
    vertical-align: middle;
    border-bottom: 1px solid #E2E8F0;
  }
  .cart-product-thumb {
    width: 64px;
    height: 64px;
    object-fit: cover;
    border-radius: 12px;
    border: 1px solid #E2E8F0;
    background: #F8FAFC;
  }
  .cart-summary-card {
    background: #ffffff;
    border-radius: 18px;
    border: 1px solid #E2E8F0;
    box-shadow: 0 8px 25px rgba(8, 47, 90, 0.08);
    padding: 1.75rem;
    position: sticky;
    top: 140px;
  }
  .qty-input-group {
    max-width: 120px;
  }
  .qty-input-group .btn {
    padding: 0.25rem 0.65rem;
    font-weight: bold;
    border-color: #CBD5E1;
  }
  .qty-input-group input {
    text-align: center;
    font-weight: bold;
    border-color: #CBD5E1;
  }
</style>

<!-- Cart Page Hero Banner -->
<section class="cart-hero-banner">
  <div class="container">
    <div class="cart-breadcrumb mb-2">
      <a href="index.php"><i class="bi bi-house-door-fill"></i> Home</a>
      <i class="bi bi-chevron-right mx-1 small opacity-50"></i>
      <span class="text-white font-semibold">Shopping Cart</span>
    </div>
    <h2 class="fw-bold mb-1 font-heading text-white">Your Shopping <span class="text-warning">Cart</span></h2>
    <p class="text-light opacity-85 small mb-0">Review your selected badminton racquets, apparel, and court equipment.</p>
  </div>
</section>

<main class="pb-5">
  <div class="container">

    <?php if (empty($cart)): ?>
      
      <!-- EMPTY CART DISPLAY -->
      <div class="row justify-content-center py-5">
        <div class="col-md-7 col-lg-5 text-center">
          <div class="card border-0 shadow-sm rounded-4 p-5">
            <i class="bi bi-bag-x display-1 text-muted opacity-40 mb-3"></i>
            <h4 class="fw-bold text-navy">Your Shopping Cart is Empty</h4>
            <p class="text-muted small mb-4">Explore our authentic badminton racquets, shuttlecocks, court shoes, and accessories to start adding gear.</p>
            <a href="index.php" class="btn btn-hero-orange py-3 px-4 fw-bold rounded-3">
              EXPLORE BADMINTON STORE <i class="bi bi-arrow-right ms-2"></i>
            </a>
          </div>
        </div>
      </div>

    <?php else: ?>

      <!-- ACTIVE CART TABLE & SUMMARY -->
      <div class="row g-4">
        
        <!-- LEFT COLUMN: CART ITEMS TABLE -->
        <div class="col-lg-8">
          <div class="cart-table-card">
            
            <div class="p-3 p-md-4 border-bottom d-flex align-items-center justify-content-between flex-wrap gap-2">
              <h5 class="fw-bold text-navy mb-0 font-heading">
                <i class="bi bi-bag-fill text-primary me-2"></i> Cart Items (<?= count($cart) ?>)
              </h5>
              <form method="POST" action="cart.php" onsubmit="return confirm('Are you sure you want to clear your entire cart?');">
                <input type="hidden" name="cart_action" value="clear_cart">
                <button type="submit" class="btn btn-outline-danger btn-sm rounded-pill font-semibold">
                  <i class="bi bi-trash me-1"></i> Clear Entire Cart
                </button>
              </form>
            </div>

            <div class="table-responsive">
              <table class="table cart-table mb-0 align-middle">
                <thead>
                  <tr>
                    <th>Product Equipment</th>
                    <th>Unit Price</th>
                    <th class="text-center">Quantity</th>
                    <th class="text-end">Subtotal</th>
                    <th class="text-center">Action</th>
                  </tr>
                </thead>
                <tbody>
                  <?php foreach ($cart as $item): ?>
                    <tr>
                      <td>
                        <div class="d-flex align-items-center gap-3">
                          <img src="<?= htmlspecialchars($item['image']) ?>" alt="Product" class="cart-product-thumb">
                          <div>
                            <h6 class="mb-1 text-dark fw-bold" style="font-size: 0.95rem;"><?= htmlspecialchars($item['name']) ?></h6>
                            <span class="badge bg-primary-subtle text-primary font-semibold">Authentic Equipment</span>
                          </div>
                        </div>
                      </td>
                      <td class="fw-bold text-navy" style="font-size: 0.95rem;">
                        Rs. <?= number_format($item['price'], 2) ?>
                      </td>
                      <td class="text-center">
                        <form method="POST" action="cart.php" class="d-inline-flex align-items-center qty-input-group mx-auto">
                          <input type="hidden" name="cart_action" value="update_qty">
                          <input type="hidden" name="product_id" value="<?= $item['id'] ?>">
                          <button type="submit" class="btn btn-light btn-sm" onclick="this.form.qty.value = Math.max(1, parseInt(this.form.qty.value) - 1);">-</button>
                          <input type="number" name="qty" class="form-control form-control-sm" value="<?= $item['qty'] ?>" min="1" onchange="this.form.submit();">
                          <button type="submit" class="btn btn-light btn-sm" onclick="this.form.qty.value = parseInt(this.form.qty.value) + 1;">+</button>
                        </form>
                      </td>
                      <td class="text-end fw-bold text-primary fs-6">
                        Rs. <?= number_format($item['price'] * $item['qty'], 2) ?>
                      </td>
                      <td class="text-center">
                        <form method="POST" action="cart.php">
                          <input type="hidden" name="cart_action" value="remove_item">
                          <input type="hidden" name="product_id" value="<?= $item['id'] ?>">
                          <button type="submit" class="btn btn-link text-danger p-0 border-0" title="Remove item">
                            <i class="bi bi-trash fs-5"></i>
                          </button>
                        </form>
                      </td>
                    </tr>
                  <?php endforeach; ?>
                </tbody>
              </table>
            </div>

            <div class="p-3 border-top bg-light d-flex justify-content-between align-items-center flex-wrap gap-2">
              <a href="index.php" class="btn btn-secondary-light font-semibold btn-sm rounded-pill">
                <i class="bi bi-arrow-left me-1"></i> Continue Shopping
              </a>
              <span class="text-muted small">All prices are in Sri Lankan Rupees (LKR)</span>
            </div>

          </div>
        </div>

        <!-- RIGHT COLUMN: ORDER SUMMARY -->
        <div class="col-lg-4">
          <div class="cart-summary-card">
            
            <h5 class="fw-bold text-navy pb-3 mb-3 border-bottom font-heading">
              Order Summary
            </h5>

            <!-- Free Shipping Progress Calculation -->
            <div class="mb-4">
              <?php if ($subtotal >= $freeShippingThreshold): ?>
                <div class="alert alert-success border-success rounded-3 p-2 small mb-2 d-flex align-items-center gap-2">
                  <i class="bi bi-check-circle-fill fs-5 text-success"></i>
                  <div><strong>Congratulations!</strong> You unlocked FREE Express Shipping!</div>
                </div>
                <div class="progress" style="height: 8px;">
                  <div class="progress-bar bg-success" style="width: 100%;"></div>
                </div>
              <?php else: ?>
                <?php 
                  $remaining = $freeShippingThreshold - $subtotal;
                  $percent = min(100, round(($subtotal / $freeShippingThreshold) * 100));
                ?>
                <div class="d-flex justify-content-between small mb-1">
                  <span class="text-muted"><i class="bi bi-truck text-warning me-1"></i> Add <strong>Rs. <?= number_format($remaining, 2) ?></strong> for FREE Shipping</span>
                  <span class="fw-bold text-dark"><?= $percent ?>%</span>
                </div>
                <div class="progress" style="height: 8px;">
                  <div class="progress-bar bg-warning" style="width: <?= $percent ?>%;"></div>
                </div>
              <?php endif; ?>
            </div>

            <!-- Price Breakdown -->
            <div class="py-2 border-bottom">
              <div class="d-flex justify-content-between text-muted small mb-2">
                <span>Subtotal</span>
                <span class="fw-bold text-dark">Rs. <?= number_format($subtotal, 2) ?></span>
              </div>
              <div class="d-flex justify-content-between text-muted small mb-2">
                <span>Islandwide Express Delivery</span>
                <?php if ($shippingFee == 0): ?>
                  <span class="fw-bold text-success"><i class="bi bi-tag-fill me-1"></i> FREE</span>
                <?php else: ?>
                  <span class="fw-bold text-dark">Rs. <?= number_format($shippingFee, 2) ?></span>
                <?php endif; ?>
              </div>
              <div class="d-flex justify-content-between text-muted small">
                <span>Estimated Tax / VAT</span>
                <span class="text-success font-semibold">Included</span>
              </div>
            </div>

            <!-- Total -->
            <div class="d-flex align-items-center justify-content-between py-3 my-2">
              <span class="fw-bold text-navy fs-6">Total Amount</span>
              <span class="fs-4 fw-bold text-primary font-heading">Rs. <?= number_format($grandTotal, 2) ?></span>
            </div>

            <!-- CTA Button -->
            <a href="checkout.php" class="btn btn-hero-orange w-100 py-3 font-semibold fs-5 shadow rounded-3 mb-3">
              PROCEED TO CHECKOUT <i class="bi bi-arrow-right ms-2"></i>
            </a>

            <!-- Trust Badges -->
            <div class="bg-light p-3 rounded-3 border small text-muted">
              <div class="d-flex align-items-center gap-2 mb-2">
                <i class="bi bi-shield-check text-primary fs-5"></i>
                <span>100% Authentic Badminton Brands</span>
              </div>
              <div class="d-flex align-items-center gap-2 mb-2">
                <i class="bi bi-truck text-success fs-5"></i>
                <span>Islandwide Fast Courier Delivery</span>
              </div>
              <div class="d-flex align-items-center gap-2">
                <i class="bi bi-arrow-counterclockwise text-warning fs-5"></i>
                <span>7-Day Easy Returns & Warranty</span>
              </div>
            </div>

          </div>
        </div>

      </div>

    <?php endif; ?>

  </div>
</main>

<?php require_once __DIR__ . '/includes/footer.php'; ?>
