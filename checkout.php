<?php
/**
 * SmashZone - Professional Checkout Page (checkout.php)
 * Complete Frontend UI & Backend Order Processing System
 */

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

require_once __DIR__ . '/includes/db.php';

// Session Guard: Must be logged in to access checkout
if (!isset($_SESSION['user'])) {
    header("Location: index.php?login_required=1");
    exit;
}

$pageTitle = "Express Checkout — Complete Your Badminton Order | SmashZone Sri Lanka";
$pageMetaDesc = "Secure checkout for authentic badminton rackets, shuttlecocks, shoes, and equipment. Islandwide delivery in Sri Lanka.";

$user = $_SESSION['user'];
$cart = $_SESSION['cart'] ?? [];

$errorMessage = '';
$orderConfirmed = false;
$confirmedOrderRef = 0;
$confirmedOrderDetails = null;

// Calculate Totals
$subtotal = 0;
foreach ($cart as $item) {
    $subtotal += ($item['price'] * $item['qty']);
}

// Shipping Logic: Free shipping for orders >= Rs. 15,000, otherwise Rs. 450 islandwide delivery
$shippingFee = ($subtotal >= 15000 || $subtotal == 0) ? 0 : 450;
$grandTotal = $subtotal + $shippingFee;

// Handle Form POST Submission (Place Order)
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'place_order') {
    if (empty($cart)) {
        $errorMessage = "Your cart is empty. Please add equipment to your cart before checking out.";
    } else {
        $firstName = trim($_POST['first_name'] ?? '');
        $lastName = trim($_POST['last_name'] ?? '');
        $phone = trim($_POST['phone'] ?? '');
        $email = trim($_POST['email'] ?? '');
        $street = trim($_POST['street_address'] ?? '');
        $city = trim($_POST['city'] ?? '');
        $district = trim($_POST['district'] ?? '');
        $paymentMethod = trim($_POST['payment_method'] ?? 'cod');
        $notes = trim($_POST['delivery_notes'] ?? '');

        if (empty($firstName) || empty($lastName) || empty($phone) || empty($street) || empty($city) || empty($district)) {
            $errorMessage = "Please fill in all required shipping address fields.";
        } else {
            try {
                $pdo->beginTransaction();

                // Format Full Address string
                $fullAddress = "Name: $firstName $lastName\n" .
                               "Phone: $phone\n" .
                               "Address: $street, $city, $district Province\n" .
                               "Payment Method: " . strtoupper($paymentMethod) . "\n" .
                               ($notes ? "Notes: $notes" : "");

                // Insert into orders table
                $orderStmt = $pdo->prepare("INSERT INTO orders (user_id, total_amount, status, shipping_address, created_at) VALUES (?, ?, 'pending', ?, NOW())");
                $orderStmt->execute([$user['id'], $grandTotal, $fullAddress]);
                $orderId = $pdo->lastInsertId();

                // Insert order items & reduce stock
                $itemStmt = $pdo->prepare("INSERT INTO order_items (order_id, product_id, price, quantity) VALUES (?, ?, ?, ?)");
                $stockStmt = $pdo->prepare("UPDATE products SET stock = GREATEST(0, stock - ?) WHERE id = ?");

                foreach ($cart as $item) {
                    $itemStmt->execute([$orderId, $item['id'], $item['price'], $item['qty']]);
                    $stockStmt->execute([$item['qty'], $item['id']]);
                }

                $pdo->commit();

                // Save confirmed order data and clear session cart
                $confirmedOrderRef = $orderId;
                $confirmedOrderDetails = [
                    'order_id' => $orderId,
                    'items' => $cart,
                    'subtotal' => $subtotal,
                    'shipping' => $shippingFee,
                    'total' => $grandTotal,
                    'name' => "$firstName $lastName",
                    'phone' => $phone,
                    'address' => "$street, $city, $district",
                    'payment_method' => $paymentMethod
                ];
                
                $_SESSION['cart'] = [];
                $orderConfirmed = true;

            } catch (Exception $e) {
                if ($pdo->inTransaction()) {
                    $pdo->rollBack();
                }
                $errorMessage = "Order processing failed: " . $e->getMessage();
            }
        }
    }
}

require_once __DIR__ . '/includes/header.php';
?>

<!-- Custom Checkout Styles (Scoped to Checkout Page) -->
<style>
  .checkout-hero-banner {
    background: linear-gradient(135deg, #051329 0%, #082F5A 50%, #0B4F9C 100%);
    padding: 2.5rem 0;
    color: #ffffff;
    margin-bottom: 2rem;
  }
  .checkout-breadcrumb {
    font-size: 0.85rem;
    color: rgba(255,255,255,0.7);
  }
  .checkout-breadcrumb a { color: #FF9800; text-decoration: none; }
  .checkout-section-card {
    background: #ffffff;
    border-radius: 18px;
    border: 1px solid #E2E8F0;
    box-shadow: 0 4px 15px rgba(0,0,0,0.03);
    padding: 1.75rem;
    margin-bottom: 1.5rem;
  }
  .checkout-section-title {
    font-family: var(--font-heading);
    font-size: 1.15rem;
    font-weight: 700;
    color: #082F5A;
    margin-bottom: 1.25rem;
    display: flex;
    align-items: center;
    gap: 0.6rem;
  }
  .payment-option-card {
    border: 2px solid #E2E8F0;
    border-radius: 12px;
    padding: 1rem 1.25rem;
    cursor: pointer;
    transition: all 0.2s ease;
    margin-bottom: 0.75rem;
    background: #F8FAFC;
  }
  .payment-option-card:hover {
    border-color: #0B4F9C;
    background: #F0F7FF;
  }
  .payment-option-card.active {
    border-color: #0B4F9C;
    background: #EBF5FF;
  }
  .order-summary-card {
    background: #ffffff;
    border-radius: 18px;
    border: 1px solid #E2E8F0;
    box-shadow: 0 8px 25px rgba(8, 47, 90, 0.08);
    position: sticky;
    top: 140px;
    padding: 1.75rem;
  }
  .order-item-thumb {
    width: 52px;
    height: 52px;
    object-fit: cover;
    border-radius: 10px;
    border: 1px solid #E2E8F0;
    background: #F8FAFC;
  }
  .trust-badge-item {
    display: flex;
    align-items: center;
    gap: 0.75rem;
    font-size: 0.82rem;
    color: #475569;
    padding: 0.6rem 0;
    border-bottom: 1px dashed #E2E8F0;
  }
  .trust-badge-item:last-child { border-bottom: none; }
  .trust-badge-icon {
    width: 32px;
    height: 32px;
    border-radius: 50%;
    background: #EBF5FF;
    color: #0B4F9C;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1rem;
    flex-shrink: 0;
  }
</style>

<!-- Checkout Page Hero Banner -->
<section class="checkout-hero-banner">
  <div class="container">
    <div class="checkout-breadcrumb mb-2">
      <a href="index.php"><i class="bi bi-house-door-fill"></i> Home</a>
      <i class="bi bi-chevron-right mx-1 small opacity-50"></i>
      <span>Shopping Cart</span>
      <i class="bi bi-chevron-right mx-1 small opacity-50"></i>
      <span class="text-white font-semibold">Express Checkout</span>
    </div>
    <h2 class="fw-bold mb-1 font-heading text-white">SmashZone <span class="text-warning">Express Checkout</span></h2>
    <p class="text-light opacity-85 small mb-0">Complete your order with 100% authentic badminton equipment & islandwide delivery.</p>
  </div>
</section>

<main class="pb-5">
  <div class="container">

    <?php if ($orderConfirmed): ?>
      
      <!-- ORDER CONFIRMATION SCREEN -->
      <div class="row justify-content-center py-4">
        <div class="col-lg-8">
          <div class="card border-0 shadow-lg rounded-4 overflow-hidden text-center p-4 p-md-5">
            <div class="mb-3">
              <div class="d-inline-flex align-items-center justify-content-center bg-success text-white rounded-circle shadow" style="width: 80px; height: 80px;">
                <i class="bi bi-check-lg display-4"></i>
              </div>
            </div>
            <span class="badge bg-success-subtle text-success font-semibold px-3 py-1 rounded-pill mx-auto mb-2 fs-6">
              <i class="bi bi-shield-check me-1"></i> Order Placed Successfully
            </span>
            <h2 class="fw-bold text-navy font-heading">Thank You For Your Order!</h2>
            <p class="text-muted fs-6 mb-4">Order Reference Number: <strong class="text-primary font-monospace">#SMZ-<?= sprintf('%05d', $confirmedOrderRef) ?></strong></p>

            <div class="p-4 bg-light rounded-4 text-start mb-4 border">
              <div class="row g-3">
                <div class="col-md-6">
                  <h6 class="fw-bold text-navy mb-1"><i class="bi bi-person-fill text-primary me-1"></i> Customer Information</h6>
                  <div class="small text-dark fw-bold"><?= htmlspecialchars($confirmedOrderDetails['name']) ?></div>
                  <div class="small text-muted"><?= htmlspecialchars($confirmedOrderDetails['phone']) ?></div>
                  <div class="small text-muted"><?= htmlspecialchars($user['email']) ?></div>
                </div>
                <div class="col-md-6">
                  <h6 class="fw-bold text-navy mb-1"><i class="bi bi-geo-alt-fill text-danger me-1"></i> Shipping Address</h6>
                  <div class="small text-dark"><?= htmlspecialchars($confirmedOrderDetails['address']) ?></div>
                  <div class="small text-success mt-1 fw-bold"><i class="bi bi-truck me-1"></i> Estimated Delivery: 2-3 Business Days</div>
                </div>
              </div>
            </div>

            <!-- Items Ordered Breakdown -->
            <div class="table-responsive text-start mb-4">
              <table class="table table-bordered align-middle">
                <thead class="table-light">
                  <tr>
                    <th>Item</th>
                    <th class="text-center">Qty</th>
                    <th class="text-end">Price</th>
                  </tr>
                </thead>
                <tbody>
                  <?php foreach ($confirmedOrderDetails['items'] as $it): ?>
                    <tr>
                      <td>
                        <div class="d-flex align-items-center gap-2">
                          <img src="<?= htmlspecialchars($it['image']) ?>" alt="Product" style="width:40px; height:40px; object-fit:cover; border-radius:8px;">
                          <span class="fw-bold small"><?= htmlspecialchars($it['name']) ?></span>
                        </div>
                      </td>
                      <td class="text-center font-bold">x<?= $it['qty'] ?></td>
                      <td class="text-end fw-bold text-success">Rs. <?= number_format($it['price'] * $it['qty'], 2) ?></td>
                    </tr>
                  <?php endforeach; ?>
                </tbody>
                <tfoot>
                  <tr>
                    <td colspan="2" class="text-end font-semibold">Delivery Fee:</td>
                    <td class="text-end fw-bold"><?= $confirmedOrderDetails['shipping'] > 0 ? 'Rs. ' . number_format($confirmedOrderDetails['shipping'], 2) : 'FREE' ?></td>
                  </tr>
                  <tr>
                    <td colspan="2" class="text-end fw-bold fs-6">Total Amount Paid / Due:</td>
                    <td class="text-end fw-bold text-primary fs-5">Rs. <?= number_format($confirmedOrderDetails['total'], 2) ?></td>
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
        </div>
      </div>

    <?php elseif (empty($cart)): ?>

      <!-- EMPTY CART STATE -->
      <div class="row justify-content-center py-5">
        <div class="col-md-7 col-lg-5 text-center">
          <div class="card border-0 shadow-sm rounded-4 p-5">
            <i class="bi bi-bag-x display-1 text-muted opacity-40 mb-3"></i>
            <h4 class="fw-bold text-navy">Your Shopping Cart is Empty</h4>
            <p class="text-muted small mb-4">You have no items in your cart. Explore our badminton racquets, shuttlecocks, and court gear to start shopping.</p>
            <a href="index.php" class="btn btn-hero-orange py-3 px-4 fw-bold rounded-3">
              EXPLORE BADMINTON STORE <i class="bi bi-arrow-right ms-2"></i>
            </a>
          </div>
        </div>
      </div>

    <?php else: ?>

      <!-- STANDARD CHECKOUT FORM UI -->
      <?php if (!empty($errorMessage)): ?>
        <div class="alert alert-danger rounded-4 shadow-sm mb-4">
          <i class="bi bi-exclamation-triangle-fill me-2"></i> <?= htmlspecialchars($errorMessage) ?>
        </div>
      <?php endif; ?>

      <form method="POST" action="checkout.php" id="checkoutForm">
        <input type="hidden" name="action" value="place_order">

        <div class="row g-4">
          
          <!-- LEFT COLUMN: CUSTOMER DETAILS & SHIPPING -->
          <div class="col-lg-7 col-xl-8">
            
            <!-- Customer Contact Details Card -->
            <div class="checkout-section-card">
              <h4 class="checkout-section-title">
                <i class="bi bi-person-bounding-box text-primary"></i> 1. Customer Contact Details
              </h4>
              <div class="row g-3">
                <div class="col-md-6">
                  <label class="form-label">First Name <span class="text-danger">*</span></label>
                  <input type="text" name="first_name" class="form-control" required value="<?= htmlspecialchars($_POST['first_name'] ?? $user['first_name']) ?>">
                </div>
                <div class="col-md-6">
                  <label class="form-label">Last Name <span class="text-danger">*</span></label>
                  <input type="text" name="last_name" class="form-control" required value="<?= htmlspecialchars($_POST['last_name'] ?? $user['last_name']) ?>">
                </div>
                <div class="col-md-6">
                  <label class="form-label">Email Address (Account)</label>
                  <input type="email" name="email" class="form-control bg-light" readonly value="<?= htmlspecialchars($user['email']) ?>">
                </div>
                <div class="col-md-6">
                  <label class="form-label">Mobile Phone Number <span class="text-danger">*</span></label>
                  <input type="tel" name="phone" class="form-control" placeholder="+94 77 123 4567" required value="<?= htmlspecialchars($_POST['phone'] ?? ($user['phone'] ?? '')) ?>">
                </div>
              </div>
            </div>

            <!-- Shipping Delivery Address Card -->
            <div class="checkout-section-card">
              <h4 class="checkout-section-title">
                <i class="bi bi-truck text-success"></i> 2. Delivery Shipping Address
              </h4>
              <div class="row g-3">
                <div class="col-12">
                  <label class="form-label">Street Address & House No <span class="text-danger">*</span></label>
                  <input type="text" name="street_address" class="form-control" placeholder="No. 45, Temple Road" required value="<?= htmlspecialchars($_POST['street_address'] ?? '') ?>">
                </div>
                <div class="col-md-6">
                  <label class="form-label">City / Town <span class="text-danger">*</span></label>
                  <input type="text" name="city" class="form-control" placeholder="Colombo 03" required value="<?= htmlspecialchars($_POST['city'] ?? '') ?>">
                </div>
                <div class="col-md-6">
                  <label class="form-label">District / Province <span class="text-danger">*</span></label>
                  <select name="district" class="form-select" required>
                    <option value="">Select District...</option>
                    <?php 
                      $districts = ['Colombo', 'Gampaha', 'Kalutara', 'Kandy', 'Galle', 'Matara', 'Jaffna', 'Kurunegala', 'Ratnapura', 'Badulla', 'Anuradhapura', 'Trincomalee', 'Batticaloa', 'Nuwara Eliya', 'Puttalam', 'Kegalle', 'Hambantota', 'Matale', 'Vavuniya', 'Mannar', 'Mullaitivu', 'Kilinochchi', 'Moneragala', 'Polonnaruwa', 'Ampara'];
                      foreach ($districts as $d):
                    ?>
                      <option value="<?= $d ?>" <?= ($_POST['district'] ?? 'Colombo') === $d ? 'selected' : '' ?>><?= $d ?></option>
                    <?php endforeach; ?>
                  </select>
                </div>
                <div class="col-12">
                  <label class="form-label">Special Delivery Notes / Landmarks (Optional)</label>
                  <textarea name="delivery_notes" class="form-control" rows="2" placeholder="e.g. Leave package with security desk / Call before delivery..."><?= htmlspecialchars($_POST['delivery_notes'] ?? '') ?></textarea>
                </div>
              </div>
            </div>

            <!-- Payment Method Selection Card -->
            <div class="checkout-section-card">
              <h4 class="checkout-section-title">
                <i class="bi bi-credit-card-2-front text-warning"></i> 3. Select Payment Method
              </h4>
              
              <!-- Option 1: Cash on Delivery -->
              <label class="payment-option-card d-flex align-items-center justify-content-between active" onclick="selectPaymentOption(this);">
                <div class="d-flex align-items-center gap-3">
                  <input type="radio" name="payment_method" value="cod" checked class="form-check-input">
                  <div>
                    <div class="fw-bold text-dark"><i class="bi bi-cash-stack text-success me-1"></i> Cash on Delivery (COD)</div>
                    <small class="text-muted">Pay cash when courier delivers package to your address.</small>
                  </div>
                </div>
                <span class="badge bg-success-subtle text-success font-semibold px-2 py-1">Popular</span>
              </label>

              <!-- Option 2: Online Card Payment -->
              <label class="payment-option-card d-flex align-items-center justify-content-between" onclick="selectPaymentOption(this);">
                <div class="d-flex align-items-center gap-3">
                  <input type="radio" name="payment_method" value="card" class="form-check-input">
                  <div>
                    <div class="fw-bold text-dark"><i class="bi bi-credit-card text-primary me-1"></i> Credit / Debit Card (Visa / MasterCard / Amex)</div>
                    <small class="text-muted">256-bit SSL Instant Secure Online Gateway.</small>
                  </div>
                </div>
                <div class="d-flex gap-1">
                  <i class="bi bi-credit-card-fill fs-5 text-primary"></i>
                </div>
              </label>

              <!-- Option 3: Bank Transfer -->
              <label class="payment-option-card d-flex align-items-center justify-content-between" onclick="selectPaymentOption(this);">
                <div class="d-flex align-items-center gap-3">
                  <input type="radio" name="payment_method" value="bank_transfer" class="form-check-input">
                  <div>
                    <div class="fw-bold text-dark"><i class="bi bi-bank text-info me-1"></i> Direct Bank Transfer</div>
                    <small class="text-muted">Deposit directly to SmashZone Commercial Bank / Sampath Bank account.</small>
                  </div>
                </div>
              </label>

            </div>

            <!-- Submit Action -->
            <button type="submit" class="btn btn-hero-orange w-100 py-3 font-semibold fs-5 shadow rounded-3">
              <i class="bi bi-shield-lock-fill me-2"></i> PLACE ORDER NOW (Rs. <?= number_format($grandTotal, 2) ?>)
            </button>
            <div class="text-center mt-2">
              <small class="text-muted" style="font-size: 0.78rem;"><i class="bi bi-lock-fill text-success me-1"></i> 256-Bit SSL Encrypted Checkout & Purchase Guarantee</small>
            </div>

          </div>

          <!-- RIGHT COLUMN: ORDER SUMMARY CARD -->
          <div class="col-lg-5 col-xl-4">
            <div class="order-summary-card">
              <div class="d-flex align-items-center justify-content-between pb-3 mb-3 border-bottom">
                <h5 class="fw-bold text-navy mb-0 font-heading">Order Summary</h5>
                <span class="badge bg-primary rounded-pill px-3 py-1 font-semibold"><?= count($cart) ?> Items</span>
              </div>

              <!-- Cart Product Items List -->
              <div class="order-items-scroll mb-3" style="max-height: 240px; overflow-y: auto;">
                <?php foreach ($cart as $item): ?>
                  <div class="d-flex align-items-center justify-content-between py-2 border-bottom">
                    <div class="d-flex align-items-center gap-2">
                      <img src="<?= htmlspecialchars($item['image']) ?>" alt="Product" class="order-item-thumb">
                      <div>
                        <div class="fw-bold text-dark small text-truncate" style="max-width: 140px;"><?= htmlspecialchars($item['name']) ?></div>
                        <small class="text-muted">Qty: <strong>x<?= $item['qty'] ?></strong></small>
                      </div>
                    </div>
                    <div class="fw-bold text-navy small">Rs. <?= number_format($item['price'] * $item['qty'], 2) ?></div>
                  </div>
                <?php endforeach; ?>
              </div>

              <!-- Price Calculations -->
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

              <!-- Grand Total -->
              <div class="d-flex align-items-center justify-content-between py-3 my-2">
                <span class="fw-bold text-navy fs-6">Grand Total</span>
                <span class="fs-4 fw-bold text-primary font-heading">Rs. <?= number_format($grandTotal, 2) ?></span>
              </div>

              <!-- Trust Badges -->
              <div class="mt-3 bg-light p-3 rounded-3 border">
                <div class="trust-badge-item">
                  <div class="trust-badge-icon"><i class="bi bi-shield-check"></i></div>
                  <div><strong>100% Authentic Equipment</strong><br><small class="text-muted">Direct from Yonex, Li-Ning, Victor</small></div>
                </div>
                <div class="trust-badge-item">
                  <div class="trust-badge-icon"><i class="bi bi-truck"></i></div>
                  <div><strong>Fast Islandwide Courier</strong><br><small class="text-muted">Delivered in 2-3 business days</small></div>
                </div>
                <div class="trust-badge-item">
                  <div class="trust-badge-icon"><i class="bi bi-arrow-counterclockwise"></i></div>
                  <div><strong>7-Day Returns & Warranty</strong><br><small class="text-muted">Easy hassle-free exchange policy</small></div>
                </div>
              </div>

            </div>
          </div>

        </div>
      </form>

    <?php endif; ?>

  </div>
</main>

<script>
  function selectPaymentOption(cardElem) {
    document.querySelectorAll('.payment-option-card').forEach(c => c.classList.remove('active'));
    cardElem.classList.add('active');
    const radio = cardElem.querySelector('input[type="radio"]');
    if (radio) radio.checked = true;
  }
</script>

<?php require_once __DIR__ . '/includes/footer.php'; ?>
