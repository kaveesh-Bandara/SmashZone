<?php
/**
 * SmashZone - Main Customer & Admin Account Dashboard (account.php)
 * Authenticates users and renders role-specific dashboards (Customer vs Admin)
 */

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

require_once __DIR__ . '/includes/db.php';

// Authentication Guard: Redirect to home page if not logged in
if (!isset($_SESSION['user'])) {
    header('Location: index.php?login_required=1');
    exit;
}

// Fetch fresh user data directly from database for maximum accuracy
$userId = $_SESSION['user']['id'];
$stmt = $pdo->prepare("SELECT * FROM users WHERE id = ?");
$stmt->execute([$userId]);
$currentUser = $stmt->fetch();

if (!$currentUser || $currentUser['status'] !== 'active') {
    unset($_SESSION['user']);
    unset($_SESSION['role']);
    session_destroy();
    header('Location: index.php?error=inactive_account');
    exit;
}

// Default Avatar Fallback (Clean Neutral SVG Icon)
$userAvatar = (!empty($currentUser['profile_picture']) && strpos($currentUser['profile_picture'], 'photo-1534528741775-53994a69daeb') === false) 
    ? htmlspecialchars($currentUser['profile_picture']) 
    : 'images/avatars/default-avatar.svg';

// Update session user copy
$_SESSION['user'] = array_merge($_SESSION['user'], [
    'first_name' => $currentUser['first_name'],
    'last_name' => $currentUser['last_name'],
    'name' => $currentUser['first_name'] . ' ' . $currentUser['last_name'],
    'email' => $currentUser['email'],
    'phone' => $currentUser['phone'],
    'profile_picture' => $userAvatar,
    'role' => $currentUser['role']
]);

$updateSuccess = false;
$updateSuccessMsg = '';
$updateError = '';

// 1. Personal Details Profile Update Handling
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['update_profile'])) {
    $firstName = trim($_POST['first_name'] ?? '');
    $lastName = trim($_POST['last_name'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $phone = trim($_POST['phone'] ?? '');

    if (empty($firstName) || empty($lastName) || empty($email)) {
        $updateError = 'First Name, Last Name, and Email are required.';
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $updateError = 'Please enter a valid email address.';
    } else {
        // Handle Avatar Upload
        $avatarPath = $currentUser['profile_picture'];
        if (isset($_FILES['profile_picture']) && $_FILES['profile_picture']['error'] === UPLOAD_ERR_OK) {
            $ext = strtolower(pathinfo($_FILES['profile_picture']['name'], PATHINFO_EXTENSION));
            if (in_array($ext, ['jpg', 'jpeg', 'png', 'webp']) && $_FILES['profile_picture']['size'] <= 5 * 1024 * 1024) {
                $newFileName = 'avatar_' . time() . '_' . bin2hex(random_bytes(6)) . '.' . $ext;
                $uploadDir = __DIR__ . '/uploads/avatars/';
                if (!is_dir($uploadDir)) mkdir($uploadDir, 0755, true);
                if (move_uploaded_file($_FILES['profile_picture']['tmp_name'], $uploadDir . $newFileName)) {
                    $avatarPath = 'uploads/avatars/' . $newFileName;
                }
            }
        }

        $updateStmt = $pdo->prepare("UPDATE users SET first_name = ?, last_name = ?, email = ?, phone = ?, profile_picture = ? WHERE id = ?");
        $updateStmt->execute([$firstName, $lastName, $email, $phone, $avatarPath, $userId]);

        $updateSuccess = true;
        header("Location: account.php?updated=profile");
        exit;
    }
}

// 2. Three-Field Password Security Update Handling
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['update_password'])) {
    $oldPassword = trim($_POST['old_password'] ?? '');
    $newPassword = trim($_POST['new_password'] ?? '');
    $confirmNewPassword = trim($_POST['confirm_new_password'] ?? '');

    if (empty($oldPassword) || empty($newPassword) || empty($confirmNewPassword)) {
        $updateError = 'Please fill in all three password fields: Current Password, New Password, and Re-enter New Password.';
    } elseif (!password_verify($oldPassword, $currentUser['password'])) {
        $updateError = 'Current password is incorrect. Please verify your old password.';
    } elseif ($newPassword !== $confirmNewPassword) {
        $updateError = 'New passwords do not match. Please ensure both new password fields match exactly.';
    } else {
        // Enforce 5 Password Security Rules
        $hasMinLength = strlen($newPassword) >= 8;
        $has2Upper     = preg_match_all('/[A-Z]/', $newPassword) >= 2;
        $has2Lower     = preg_match_all('/[a-z]/', $newPassword) >= 2;
        $has1Num       = preg_match_all('/[0-9]/', $newPassword) >= 1;
        $has1Spec      = preg_match('/[!@#$%^&*()_+\-=\[\]{};\':"\\\\|,.<>\/?]/', $newPassword) === 1;

        if (!$hasMinLength || !$has2Upper || !$has2Lower || !$has1Num || !$has1Spec) {
            $updateError = 'New password does not meet security rules: min 8 characters, 2+ uppercase, 2+ lowercase, 1+ number, 1+ special character.';
        } else {
            $hashedPass = password_hash($newPassword, PASSWORD_DEFAULT);
            $updateStmt = $pdo->prepare("UPDATE users SET password = ? WHERE id = ?");
            $updateStmt->execute([$hashedPass, $userId]);

            $updateSuccess = true;
            header("Location: account.php?updated=password");
            exit;
        }
    }
}

// Fetch Real Customer Orders from Database
$customerOrders = [];
if ($currentUser['role'] === 'customer') {
    $ordersStmt = $pdo->prepare("SELECT * FROM orders WHERE user_id = ? ORDER BY created_at DESC");
    $ordersStmt->execute([$userId]);
    $customerOrders = $ordersStmt->fetchAll();
}

$pageTitle = ($currentUser['role'] === 'admin') ? "Admin Control Panel — SmashZone" : "My Player Account — SmashZone";
$pageMetaDesc = "Manage your SmashZone account, view real order history and live tracking, and update security settings.";

require_once __DIR__ . '/includes/header.php';
?>

<?php if ($currentUser['role'] === 'admin'): ?>
  <!-- ==========================================================================
       ADMIN EXECUTIVE DASHBOARD INTERFACE
       ========================================================================== -->
  <section class="page-hero-banner" style="background: linear-gradient(135deg, #051329 0%, #082F5A 50%, #0B4F9C 100%);">
    <div class="container py-3">
      <div class="d-flex align-items-center justify-content-between flex-wrap gap-3 text-white">
        <div class="d-flex align-items-center gap-3">
          <img src="<?php echo $userAvatar; ?>" alt="Admin Avatar" class="rounded-circle border border-3 border-warning" style="width: 72px; height: 72px; object-fit: cover;">
          <div>
            <div class="badge bg-warning text-dark px-2 py-1 rounded-pill mb-1 font-semibold" style="font-size: 0.75rem;">
              <i class="bi bi-shield-lock-fill me-1"></i> SYSTEM ADMINISTRATOR
            </div>
            <h2 class="fw-bold mb-0"><?php echo htmlspecialchars($currentUser['first_name'] . ' ' . $currentUser['last_name']); ?></h2>
            <p class="text-light opacity-75 small mb-0"><?php echo htmlspecialchars($currentUser['email']); ?></p>
          </div>
        </div>
        <div>
          <a href="admin/dashboard.php" class="btn btn-warning btn-sm fw-bold px-3 me-2">
            <i class="bi bi-speedometer2 me-1"></i> Go to Admin Panel
          </a>
          <a href="auth.php?action=logout" class="btn btn-outline-light btn-sm fw-bold px-3">
            <i class="bi bi-box-arrow-right me-1"></i> Admin Sign Out
          </a>
        </div>
      </div>
    </div>
  </section>

  <section class="py-5" style="background-color: var(--light-bg);">
    <div class="container py-2">
      <div class="alert alert-info rounded-4 shadow-sm mb-4">
        <i class="bi bi-info-circle-fill me-2 fs-5"></i> You are logged in as a <strong>System Administrator</strong>. Access the full <a href="admin/dashboard.php" class="fw-bold text-decoration-underline">SmashZone Admin Control Panel</a> for complete inventory, order, and customer management.
      </div>
    </div>
  </section>

<?php else: ?>
  <!-- ==========================================================================
       CUSTOMER ACCOUNT DASHBOARD INTERFACE
       ========================================================================== -->
  <section class="page-hero-banner account-page-hero" style="background: linear-gradient(135deg, #051329 0%, #082F5A 50%, #0B4F9C 100%);">
    <div class="container py-3">
      <div class="d-flex align-items-center justify-content-between flex-wrap gap-3 text-white">
        <div class="d-flex align-items-center gap-3">
          <img src="<?php echo $userAvatar; ?>" alt="Customer Avatar" class="rounded-circle border border-3 border-white shadow-sm" style="width: 76px; height: 76px; object-fit: cover;">
          <div>
            <h1 class="page-hero-title mb-1 text-white">Welcome back, <?php echo htmlspecialchars($currentUser['first_name']); ?>!</h1>
            <p class="page-hero-subtitle text-white-50 mb-0">Manage your profile, view live order history & tracking, and security settings.</p>
          </div>
        </div>
        <div>
          <span class="badge bg-warning text-dark px-3 py-2 fs-6 rounded-pill fw-bold border border-2 border-white shadow-sm">
            <i class="bi bi-person-check-fill me-1"></i> SmashZone Member
          </span>
        </div>
      </div>
    </div>
  </section>

  <section class="py-5 bg-light">
    <div class="container py-2">

      <?php if (isset($_GET['updated']) && $_GET['updated'] === 'profile'): ?>
        <div class="alert alert-success alert-dismissible fade show rounded-3 mb-4" role="alert">
          <i class="bi bi-check-circle-fill me-2"></i> Your personal profile details have been updated successfully!
          <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
      <?php endif; ?>

      <?php if (isset($_GET['updated']) && $_GET['updated'] === 'password'): ?>
        <div class="alert alert-success alert-dismissible fade show rounded-3 mb-4" role="alert">
          <i class="bi bi-shield-check me-2 fs-5"></i> Your account password has been updated successfully!
          <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
      <?php endif; ?>

      <?php if (!empty($updateError)): ?>
        <div class="alert alert-danger alert-dismissible fade show rounded-3 mb-4" role="alert">
          <i class="bi bi-exclamation-triangle-fill me-2"></i> <?php echo htmlspecialchars($updateError); ?>
          <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
      <?php endif; ?>

      <div class="row g-4">
        
        <!-- SIDEBAR NAVIGATION PANEL -->
        <div class="col-lg-4">
          <div class="bg-white rounded-4 p-4 border border-1 shadow-sm text-center">
            
            <div class="position-relative d-inline-block mb-3">
              <img id="avatarPreview" src="<?php echo $userAvatar; ?>" alt="Avatar" class="rounded-circle border border-3 border-primary" style="width: 100px; height: 100px; object-fit: cover;">
            </div>

            <h5 class="fw-bold mb-1"><?php echo htmlspecialchars($currentUser['first_name'] . ' ' . $currentUser['last_name']); ?></h5>
            <p class="text-muted small mb-3"><?php echo htmlspecialchars($currentUser['email']); ?></p>

            <hr class="my-3 opacity-10">

            <div class="nav flex-column text-start gap-2" id="accountTabs" role="tablist">
              <button class="btn btn-outline-primary active text-start py-3 px-3 fw-bold border-0 text-navy" id="tab-profile-btn" data-bs-toggle="pill" data-bs-target="#tab-profile" type="button">
                <i class="bi bi-person-vcard me-2"></i> Personal Details
              </button>
              <button class="btn btn-outline-primary text-start py-3 px-3 fw-bold border-0 text-navy d-flex align-items-center justify-content-between" id="tab-orders-btn" data-bs-toggle="pill" data-bs-target="#tab-orders" type="button">
                <span><i class="bi bi-bag-check me-2"></i> Orders & Tracking</span>
                <span class="badge bg-primary rounded-pill px-2"><?php echo count($customerOrders); ?> Orders</span>
              </button>
              <button class="btn btn-outline-primary text-start py-3 px-3 fw-bold border-0 text-navy" id="tab-security-btn" data-bs-toggle="pill" data-bs-target="#tab-security" type="button">
                <i class="bi bi-shield-lock me-2"></i> Security & Password
              </button>
              <a href="auth.php?action=logout" class="btn btn-outline-danger text-start py-3 px-3 fw-bold border-0 mt-3">
                <i class="bi bi-box-arrow-right me-2"></i> Sign Out
              </a>
            </div>

          </div>
        </div>

        <!-- RIGHT CONTENT TABS -->
        <div class="col-lg-8">
          <div class="tab-content" id="accountTabContent">
            
            <!-- 1. PERSONAL DETAILS TAB -->
            <div class="tab-pane fade show active" id="tab-profile" role="tabpanel">
              <div class="bg-white rounded-4 p-4 p-md-5 border border-1 shadow-sm">
                <div class="d-flex justify-content-between align-items-center mb-4">
                  <div>
                    <h4 class="fw-bold mb-1">Personal Details</h4>
                    <p class="text-muted small mb-0">Update your customer profile information.</p>
                  </div>
                  <span class="badge bg-light text-success border border-success"><i class="bi bi-check-circle-fill me-1"></i> Verified Account</span>
                </div>

                <form method="POST" enctype="multipart/form-data">
                  <input type="hidden" name="update_profile" value="1">
                  
                  <div class="row g-3">
                    <div class="col-md-6">
                      <label class="form-label font-semibold small text-muted">First Name</label>
                      <input type="text" name="first_name" class="form-control form-control-lg fs-6" value="<?php echo htmlspecialchars($currentUser['first_name']); ?>" required>
                    </div>
                    <div class="col-md-6">
                      <label class="form-label font-semibold small text-muted">Last Name</label>
                      <input type="text" name="last_name" class="form-control form-control-lg fs-6" value="<?php echo htmlspecialchars($currentUser['last_name']); ?>" required>
                    </div>
                    <div class="col-md-6">
                      <label class="form-label font-semibold small text-muted">Email Address</label>
                      <input type="email" name="email" class="form-control form-control-lg fs-6" value="<?php echo htmlspecialchars($currentUser['email']); ?>" required>
                    </div>
                    <div class="col-md-6">
                      <label class="form-label font-semibold small text-muted">Phone Number</label>
                      <input type="tel" name="phone" class="form-control form-control-lg fs-6" value="<?php echo htmlspecialchars($currentUser['phone'] ?: ''); ?>" placeholder="0771234567 or +94771234567">
                    </div>

                    <div class="col-12 mt-4 p-3 bg-light rounded-3 border">
                      <label class="form-label font-semibold small text-muted d-block mb-1">
                        <i class="bi bi-camera-fill me-1 text-primary"></i> Upload Profile Picture
                      </label>
                      <input type="file" name="profile_picture" class="form-control" accept="image/jpeg,image/png,image/webp">
                      <small class="text-muted d-block mt-1">Supported formats: JPG, PNG, WEBP (Max 5MB)</small>
                    </div>

                    <div class="col-12 mt-4">
                      <button type="submit" class="btn btn-hero-orange py-3 px-5 fw-bold fs-6 rounded-3 shadow-sm">
                        SAVE PROFILE CHANGES <i class="bi bi-check-lg ms-1"></i>
                      </button>
                    </div>
                  </div>
                </form>

              </div>
            </div>

            <!-- 2. ORDERS & TRACKING TAB (LIVE DATABASE DATA) -->
            <div class="tab-pane fade" id="tab-orders" role="tabpanel">
              <div class="bg-white rounded-4 p-4 p-md-5 border border-1 shadow-sm">
                <div class="d-flex justify-content-between align-items-center mb-4">
                  <div>
                    <h4 class="fw-bold mb-1">Order History & Live Tracking</h4>
                    <p class="text-muted small mb-0">Track real-time status and islandwide delivery for all your SmashZone equipment orders.</p>
                  </div>
                </div>

                <?php if (empty($customerOrders)): ?>
                  <div class="text-center py-5 text-muted border rounded-4 p-5 bg-light">
                    <i class="bi bi-bag-x display-4 mb-3 text-secondary"></i>
                    <h5 class="fw-bold text-dark mb-1">No Orders Placed Yet</h5>
                    <p class="mb-3">You haven't placed any badminton equipment orders yet.</p>
                    <a href="index.php#categories" class="btn btn-hero-orange px-4 py-2 fw-bold rounded-3">
                      Explore Badminton Equipment <i class="bi bi-arrow-right ms-1"></i>
                    </a>
                  </div>
                <?php else: ?>
                  <?php foreach ($customerOrders as $ord): ?>
                    <?php
                      // Fetch Order Items from Database
                      $itemsStmt = $pdo->prepare("
                          SELECT oi.*, p.name as product_name, p.image as product_image, p.brand 
                          FROM order_items oi 
                          JOIN products p ON oi.product_id = p.id 
                          WHERE oi.order_id = ?
                      ");
                      $itemsStmt->execute([$ord['id']]);
                      $orderItems = $itemsStmt->fetchAll();

                      $statusLower = strtolower($ord['status']);
                      $badgeClass = 'bg-secondary';
                      $statusLabel = ucfirst($ord['status']);

                      if ($statusLower === 'pending') {
                          $badgeClass = 'bg-warning text-dark';
                          $statusLabel = 'Pending Payment / Confirmation';
                      } elseif ($statusLower === 'processing') {
                          $badgeClass = 'bg-info text-white';
                          $statusLabel = 'Processing & Stringing';
                      } elseif ($statusLower === 'shipped') {
                          $badgeClass = 'bg-primary text-white';
                          $statusLabel = 'Out for Delivery / In Transit';
                      } elseif ($statusLower === 'delivered') {
                          $badgeClass = 'bg-success text-white';
                          $statusLabel = 'Delivered Successfully';
                      } elseif ($statusLower === 'cancelled') {
                          $badgeClass = 'bg-danger text-white';
                          $statusLabel = 'Cancelled';
                      }
                    ?>
                    
                    <div class="border rounded-4 p-4 mb-4 bg-light shadow-sm">
                      
                      <!-- Order Header -->
                      <div class="d-flex justify-content-between align-items-center flex-wrap gap-2 mb-3 pb-3 border-bottom">
                        <div>
                          <span class="fw-bold fs-6 text-navy">Order #SMZ-<?php echo sprintf('%05d', $ord['id']); ?></span>
                          <span class="text-muted small ms-2">• Placed on <?php echo date('M d, Y', strtotime($ord['created_at'])); ?></span>
                        </div>
                        <div>
                          <span class="badge <?php echo $badgeClass; ?> px-3 py-2 fw-bold" style="font-size: 0.82rem;">
                            <i class="bi bi-box-seam me-1"></i> <?php echo $statusLabel; ?>
                          </span>
                        </div>
                      </div>

                      <!-- Order Items List -->
                      <div class="row align-items-center gy-3 mb-3">
                        <div class="col-lg-8">
                          <div class="d-flex flex-column gap-3">
                            <?php foreach ($orderItems as $item): ?>
                              <div class="d-flex align-items-center gap-3">
                                <img src="<?php echo htmlspecialchars($item['product_image']); ?>" alt="Product" class="rounded bg-white p-2 border" style="width: 60px; height: 60px; object-fit: contain;" onerror="this.src='images/logo/logo.png'">
                                <div>
                                  <h6 class="fw-bold mb-0 text-navy" style="font-size: 0.93rem;"><?php echo htmlspecialchars($item['product_name']); ?></h6>
                                  <small class="text-muted">Brand: <?php echo htmlspecialchars($item['brand']); ?> • Qty: <?php echo (int)$item['quantity']; ?></small>
                                  <div class="fw-bold text-primary" style="font-size: 0.88rem;">Rs. <?php echo number_format($item['price'] * $item['quantity'], 2); ?></div>
                                </div>
                              </div>
                            <?php endforeach; ?>
                          </div>
                        </div>

                        <div class="col-lg-4 text-lg-end border-lg-start pt-2 pt-lg-0">
                          <div class="text-muted small">Total Order Value:</div>
                          <div class="fs-4 fw-bold text-navy mb-2">Rs. <?php echo number_format($ord['total_amount'], 2); ?></div>
                          <button class="btn btn-outline-primary btn-sm px-3 fw-bold w-100" data-bs-toggle="collapse" data-bs-target="#trackingDetails-<?php echo $ord['id']; ?>">
                            <i class="bi bi-geo-alt me-1"></i> View Live Tracking Status
                          </button>
                        </div>
                      </div>

                      <!-- Tracking Progress Bar Collapsible -->
                      <div class="collapse mt-3 pt-3 border-top" id="trackingDetails-<?php echo $ord['id']; ?>">
                        <div class="p-3 bg-white rounded-3 border">
                          <h6 class="fw-bold text-navy mb-3"><i class="bi bi-truck text-orange me-1"></i> Islandwide Delivery Progress</h6>
                          
                          <div class="row text-center position-relative g-2">
                            <div class="col-3">
                              <div class="p-2 rounded-3 <?php echo in_array($statusLower, ['pending', 'processing', 'shipped', 'delivered']) ? 'bg-success text-white fw-bold' : 'bg-light text-muted'; ?>" style="font-size: 0.75rem;">
                                1. Order Placed
                              </div>
                            </div>
                            <div class="col-3">
                              <div class="p-2 rounded-3 <?php echo in_array($statusLower, ['processing', 'shipped', 'delivered']) ? 'bg-success text-white fw-bold' : 'bg-light text-muted'; ?>" style="font-size: 0.75rem;">
                                2. Processing
                              </div>
                            </div>
                            <div class="col-3">
                              <div class="p-2 rounded-3 <?php echo in_array($statusLower, ['shipped', 'delivered']) ? 'bg-success text-white fw-bold' : 'bg-light text-muted'; ?>" style="font-size: 0.75rem;">
                                3. In Transit
                              </div>
                            </div>
                            <div class="col-3">
                              <div class="p-2 rounded-3 <?php echo ($statusLower === 'delivered') ? 'bg-success text-white fw-bold' : 'bg-light text-muted'; ?>" style="font-size: 0.75rem;">
                                4. Delivered
                              </div>
                            </div>
                          </div>

                          <div class="mt-3 pt-2 text-muted small border-top">
                            <strong>Shipping Destination:</strong><br>
                            <?php echo nl2br(htmlspecialchars($ord['shipping_address'])); ?>
                          </div>
                        </div>
                      </div>

                    </div>
                  <?php endforeach; ?>
                <?php endif; ?>

              </div>
            </div>

            <!-- 3. SECURITY & PASSWORD TAB (3 TEXT FIELDS REQUIRED) -->
            <div class="tab-pane fade" id="tab-security" role="tabpanel">
              <div class="bg-white rounded-4 p-4 p-md-5 border border-1 shadow-sm">
                <div class="mb-4">
                  <h4 class="fw-bold mb-1">Account Security & Password Update</h4>
                  <p class="text-muted small mb-0">To update your password, please enter your current password followed by your new password.</p>
                </div>
                
                <form method="POST" novalidate>
                  <input type="hidden" name="update_password" value="1">
                  
                  <div class="row g-3 max-w-md" style="max-width: 480px;">
                    
                    <!-- 1. Current / Old Password -->
                    <div class="col-12">
                      <label class="form-label font-semibold small text-navy" for="accOldPassword">Current Password</label>
                      <div class="position-relative">
                        <i class="bi bi-key-fill position-absolute top-50 start-0 translate-middle-y ms-3 text-muted"></i>
                        <input type="password" id="accOldPassword" name="old_password" class="form-control form-control-lg fs-6 ps-5 pe-4" placeholder="Enter current password" required>
                        <button type="button" class="btn btn-link text-secondary position-absolute top-50 end-0 translate-middle-y text-decoration-none pe-2" onclick="togglePassVisibility('accOldPassword', this)" aria-label="Toggle Password Visibility">
                          <i class="bi bi-eye fs-6"></i>
                        </button>
                      </div>
                    </div>

                    <!-- 2. New Password -->
                    <div class="col-12">
                      <label class="form-label font-semibold small text-navy" for="accNewPassword">New Password</label>
                      <div class="position-relative">
                        <i class="bi bi-lock-fill position-absolute top-50 start-0 translate-middle-y ms-3 text-muted"></i>
                        <input type="password" id="accNewPassword" name="new_password" class="form-control form-control-lg fs-6 ps-5 pe-4" placeholder="Enter new password (min 8 chars)" required>
                        <button type="button" class="btn btn-link text-secondary position-absolute top-50 end-0 translate-middle-y text-decoration-none pe-2" onclick="togglePassVisibility('accNewPassword', this)" aria-label="Toggle Password Visibility">
                          <i class="bi bi-eye fs-6"></i>
                        </button>
                      </div>
                      <small class="text-muted d-block mt-1" style="font-size: 0.75rem;">Rule: 8+ chars, 2+ uppercase, 2+ lowercase, 1+ number, 1+ special char (!@#$%)</small>
                    </div>

                    <!-- 3. Re-enter New Password -->
                    <div class="col-12">
                      <label class="form-label font-semibold small text-navy" for="accConfirmNewPassword">Re-enter New Password</label>
                      <div class="position-relative">
                        <i class="bi bi-shield-lock-fill position-absolute top-50 start-0 translate-middle-y ms-3 text-muted"></i>
                        <input type="password" id="accConfirmNewPassword" name="confirm_new_password" class="form-control form-control-lg fs-6 ps-5 pe-4" placeholder="Re-enter new password" required>
                        <button type="button" class="btn btn-link text-secondary position-absolute top-50 end-0 translate-middle-y text-decoration-none pe-2" onclick="togglePassVisibility('accConfirmNewPassword', this)" aria-label="Toggle Password Visibility">
                          <i class="bi bi-eye fs-6"></i>
                        </button>
                      </div>
                    </div>

                    <div class="col-12 mt-4">
                      <button type="submit" class="btn btn-hero-orange py-3 px-5 fw-bold fs-6 rounded-3 shadow-sm">
                        UPDATE ACCOUNT PASSWORD <i class="bi bi-shield-check ms-1 fs-5"></i>
                      </button>
                    </div>

                  </div>
                </form>

              </div>
            </div>

          </div>
        </div>

      </div>
    </div>
  </section>

<?php endif; ?>

<?php require_once __DIR__ . '/includes/footer.php'; ?>
