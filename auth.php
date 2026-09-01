<?php
/**
 * SmashZone - Authentication Handler & Modal Component (auth.php)
 * Handles AJAX Login, Registration, Logout, Session Security, and Bootstrap Modals
 */

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

require_once __DIR__ . '/includes/db.php';

// ============================================================================
// BACKEND API HANDLERS (LOGOUT, LOGIN, REGISTER)
// ============================================================================

$action = $_GET['action'] ?? $_POST['action'] ?? '';

// 1. LOGOUT ACTION
if ($action === 'logout') {
    unset($_SESSION['user']);
    unset($_SESSION['role']);
    session_destroy();
    header('Location: index.php');
    exit;
}

// 2. LOGIN ACTION (AJAX POST)
if ($action === 'login') {
    header('Content-Type: application/json');

    if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
        echo json_encode(['status' => 'error', 'message' => 'Invalid request method.']);
        exit;
    }
    
    $email = trim($_POST['email'] ?? '');
    $password = trim($_POST['password'] ?? '');

    if (empty($email) || empty($password)) {
        echo json_encode(['status' => 'error', 'message' => 'Please enter both email address and password.']);
        exit;
    }

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        echo json_encode(['status' => 'error', 'message' => 'Invalid email address or password.']);
        exit;
    }

    try {
        // Prepared Statement for Secure SQL Injection Protection
        $stmt = $pdo->prepare("SELECT * FROM users WHERE email = ?");
        $stmt->execute([$email]);
        $user = $stmt->fetch();

        if ($user && password_verify($password, $user['password'])) {
            if ($user['status'] !== 'active') {
                echo json_encode([
                    'status' => 'error', 
                    'message' => 'Your account is currently suspended or inactive. Please contact support.'
                ]);
                exit;
            }

            // Security Improvement: Regenerate session ID upon authentication
            session_regenerate_id(true);

            $_SESSION['user'] = [
                'id' => (int)$user['id'],
                'first_name' => $user['first_name'],
                'last_name' => $user['last_name'],
                'name' => $user['first_name'] . ' ' . $user['last_name'],
                'email' => $user['email'],
                'phone' => $user['phone'],
                'profile_picture' => $user['profile_picture'] ?: 'images/avatars/default-avatar.svg',
                'role' => $user['role'],
                'status' => $user['status']
            ];
            $_SESSION['role'] = $user['role'];

            // Automated Role Detection from Database Record
            $redirectUrl = ($user['role'] === 'admin') ? 'admin/dashboard.php' : 'account.php';

            echo json_encode([
                'status' => 'success',
                'message' => 'Welcome back, ' . htmlspecialchars($user['first_name']) . '!',
                'redirect' => $redirectUrl,
                'user' => $_SESSION['user']
            ]);
        } else {
            // Generic security error message to prevent account enumeration
            echo json_encode(['status' => 'error', 'message' => 'Invalid email address or password.']);
        }
    } catch (Exception $e) {
        error_log('SmashZone Login Error: ' . $e->getMessage());
        echo json_encode(['status' => 'error', 'message' => 'Something went wrong. Please try again later.']);
    }
    exit;
}

// 3. REGISTRATION ACTION (AJAX POST)
if ($action === 'register') {
    header('Content-Type: application/json');

    if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
        echo json_encode(['status' => 'error', 'message' => 'Invalid request method.']);
        exit;
    }

    $firstName = trim($_POST['first_name'] ?? '');
    $lastName = trim($_POST['last_name'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $phone = trim($_POST['phone'] ?? '');
    $password = trim($_POST['password'] ?? '');
    $confirmPassword = trim($_POST['confirm_password'] ?? '');

    // Server-Side Field Validations
    if (empty($firstName) || empty($lastName) || empty($email) || empty($phone) || empty($password) || empty($confirmPassword)) {
        echo json_encode(['status' => 'error', 'message' => 'Please fill in all required registration fields.']);
        exit;
    }

    // Name Validation (Letters, spaces, hyphens, apostrophes only)
    if (!preg_match('/^[a-zA-Z\s\'-]{2,50}$/', $firstName) || !preg_match('/^[a-zA-Z\s\'-]{2,50}$/', $lastName)) {
        echo json_encode(['status' => 'error', 'message' => 'Please enter a valid First Name and Last Name (letters only).']);
        exit;
    }

    // Email Format Validation
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        echo json_encode(['status' => 'error', 'message' => 'Please enter a valid email address.']);
        exit;
    }

    // Sri Lankan Phone Number Format Validation (Allows 07XXXXXXXX or +947XXXXXXXX)
    $cleanPhone = preg_replace('/[\s\-\(\)]+/', '', $phone);
    if (!preg_match('/^(?:\+94|0)?7[0-9]{8}$/', $cleanPhone)) {
        echo json_encode(['status' => 'error', 'message' => 'Please enter a valid Sri Lankan phone number (e.g., 0771234567 or +94771234567).']);
        exit;
    }
    // Normalize phone number for consistent DB storage
    if (strpos($cleanPhone, '0') === 0) {
        $normalizedPhone = '+94' . substr($cleanPhone, 1);
    } elseif (strpos($cleanPhone, '+94') === 0) {
        $normalizedPhone = $cleanPhone;
    } else {
        $normalizedPhone = '+94' . $cleanPhone;
    }

    // Password Criteria Verification (5 Strict Criteria)
    $hasMinLength = strlen($password) >= 8;
    $has2Upper = preg_match_all('/[A-Z]/', $password) >= 2;
    $has2Lower = preg_match_all('/[a-z]/', $password) >= 2;
    $has1Num   = preg_match_all('/[0-9]/', $password) >= 1;
    $has1Spec  = preg_match('/[!@#$%^&*()_+\-=\[\]{};\':"\\\\|,.<>\/?]/', $password) === 1;

    if (!$hasMinLength || !$has2Upper || !$has2Lower || !$has1Num || !$has1Spec) {
        echo json_encode([
            'status' => 'error', 
            'message' => 'Password must satisfy all security rules: 8+ chars, 2+ uppercase, 2+ lowercase, 1+ number, 1+ special char.'
        ]);
        exit;
    }

    // Confirm Password Match Check
    if ($password !== $confirmPassword) {
        echo json_encode(['status' => 'error', 'message' => 'Passwords do not match. Please verify both entries.']);
        exit;
    }

    // Customer Role Enforcement: Public sign-ups are ALWAYS created as 'customer'
    $role = 'customer';

    try {
        // Check if email already exists in DB
        $stmt = $pdo->prepare("SELECT id FROM users WHERE email = ?");
        $stmt->execute([$email]);
        if ($stmt->fetch()) {
            echo json_encode([
                'status' => 'error', 
                'message' => 'This email address is already registered. Please log in instead.'
            ]);
            exit;
        }

        // Profile Picture Upload Handling & Secure Validation
        $profilePicturePath = 'images/avatars/default-avatar.svg';

        if (isset($_FILES['profile_picture']) && $_FILES['profile_picture']['error'] === UPLOAD_ERR_OK) {
            $fileTmpPath = $_FILES['profile_picture']['tmp_name'];
            $fileName = $_FILES['profile_picture']['name'];
            $fileSize = $_FILES['profile_picture']['size'];
            
            $fileExtension = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));
            $allowedExtensions = ['jpg', 'jpeg', 'png', 'webp'];
            
            // Server-side extension check
            if (!in_array($fileExtension, $allowedExtensions)) {
                echo json_encode(['status' => 'error', 'message' => 'Invalid image format. Allowed formats: JPG, PNG, WEBP.']);
                exit;
            }

            // Server-side size check (5MB Limit)
            if ($fileSize > 5 * 1024 * 1024) {
                echo json_encode(['status' => 'error', 'message' => 'Profile image exceeds 5MB size limit.']);
                exit;
            }

            // Server-side MIME check using finfo
            $finfo = finfo_open(FILEINFO_MIME_TYPE);
            $mimeType = finfo_file($finfo, $fileTmpPath);
            finfo_close($finfo);

            $allowedMimeTypes = ['image/jpeg', 'image/png', 'image/webp'];
            if (!in_array($mimeType, $allowedMimeTypes)) {
                echo json_encode(['status' => 'error', 'message' => 'Uploaded file is not a valid image.']);
                exit;
            }

            $uploadDir = __DIR__ . '/uploads/avatars/';
            if (!is_dir($uploadDir)) {
                mkdir($uploadDir, 0755, true);
            }

            $newFileName = 'avatar_' . time() . '_' . bin2hex(random_bytes(8)) . '.' . $fileExtension;
            $destPath = $uploadDir . $newFileName;

            if (move_uploaded_file($fileTmpPath, $destPath)) {
                $profilePicturePath = 'uploads/avatars/' . $newFileName;
            }
        }

        // Secure Password Hashing
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

        // Save Customer to Database
        $stmt = $pdo->prepare("INSERT INTO users (first_name, last_name, email, password, phone, profile_picture, role, status) VALUES (?, ?, ?, ?, ?, ?, ?, 'active')");
        if ($stmt->execute([$firstName, $lastName, $email, $hashedPassword, $normalizedPhone, $profilePicturePath, $role])) {
            $userId = (int)$pdo->lastInsertId();

            // Auto Log In Customer
            session_regenerate_id(true);
            $_SESSION['user'] = [
                'id' => $userId,
                'first_name' => $firstName,
                'last_name' => $lastName,
                'name' => $firstName . ' ' . $lastName,
                'email' => $email,
                'phone' => $normalizedPhone,
                'profile_picture' => $profilePicturePath,
                'role' => $role,
                'status' => 'active'
            ];
            $_SESSION['role'] = $role;

            echo json_encode([
                'status' => 'success',
                'message' => 'Registration successful! Welcome to SmashZone.',
                'redirect' => 'account.php',
                'user' => $_SESSION['user']
            ]);
        } else {
            echo json_encode(['status' => 'error', 'message' => 'Account creation failed. Please try again.']);
        }
    } catch (Exception $e) {
        error_log('SmashZone Registration Error: ' . $e->getMessage());
        echo json_encode(['status' => 'error', 'message' => 'Something went wrong during registration. Please try again later.']);
    }
    exit;
}

// ============================================================================
// FRONTEND MODAL RENDER FUNCTION (SMASHZONE REDESIGN)
// ============================================================================

/**
 * Render Login & Registration Bootstrap Modals
 */
if (!function_exists('renderAuthModals')) {
function renderAuthModals() {
    ?>
    <!-- 1. LOGIN MODAL -->
    <div class="modal fade pro-auth-modal" id="loginModal" tabindex="-1" aria-labelledby="loginModalLabel" aria-hidden="true">
      <div class="modal-dialog modal-dialog-centered" style="max-width: 450px;">
        <div class="modal-content border-0 shadow-lg" style="border-radius: 24px; overflow: hidden; background: #ffffff;">
          
          <!-- Banner Header -->
          <div class="auth-modal-banner text-center position-relative p-4" style="background: linear-gradient(135deg, #051329 0%, #082F5A 50%, #0B4F9C 100%);">
            <button type="button" class="btn-close btn-close-white position-absolute top-0 end-0 m-3" data-bs-dismiss="modal" aria-label="Close"></button>
            
            <div class="mb-2">
              <span class="badge bg-warning text-dark px-3 py-1 rounded-pill font-semibold small shadow-sm">
                <i class="bi bi-shield-check me-1"></i> SmashZone Portal
              </span>
            </div>
            
            <img src="images/logo/logo.png" alt="SmashZone Logo" style="height: 48px; background: white; padding: 5px 16px; border-radius: 12px;" class="mb-2 shadow-sm">
            <h4 class="fw-bold text-white mb-1" id="loginModalLabel" style="font-family: var(--font-heading);">Welcome Back</h4>
            <p class="text-light small opacity-85 mb-0">Sign in to continue your SmashZone experience.</p>
          </div>

          <div class="modal-body p-4">

            <div id="loginAlert" class="alert d-none small rounded-3 mb-3"></div>

            <form id="formCustomerLogin" autocomplete="on" novalidate>
              <input type="hidden" name="action" value="login">
              
              <!-- Email Input -->
              <div class="mb-3">
                <label class="form-label font-semibold small text-navy mb-1" for="loginEmailInput">Email Address</label>
                <div class="position-relative">
                  <i class="bi bi-envelope-at-fill position-absolute top-50 start-0 translate-middle-y ms-3 text-primary"></i>
                  <input type="email" id="loginEmailInput" name="email" class="form-control ps-5 py-2.5 rounded-3 bg-light border-1" placeholder="Enter your email" required style="font-size: 0.95rem;">
                </div>
                <span id="loginEmailFeedback" class="input-validation-msg d-none"></span>
              </div>

              <!-- Password Input -->
              <div class="mb-3">
                <div class="d-flex justify-content-between align-items-center mb-1">
                  <label class="form-label font-semibold small text-navy mb-0" for="loginPasswordInput">Password</label>
                  <a href="#" onclick="alert('Password reset link has been dispatched to your registered email address.'); return false;" class="text-orange small text-decoration-none fw-bold">Forgot?</a>
                </div>
                <div class="position-relative">
                  <i class="bi bi-key-fill position-absolute top-50 start-0 translate-middle-y ms-3 text-primary"></i>
                  <input type="password" id="loginPasswordInput" name="password" class="form-control ps-5 pe-5 py-2.5 rounded-3 bg-light border-1" placeholder="Enter your password" required style="font-size: 0.95rem;">
                  <button type="button" class="btn btn-link text-secondary position-absolute top-50 end-0 translate-middle-y text-decoration-none pe-3" onclick="togglePassVisibility('loginPasswordInput', this)" aria-label="Toggle Password Visibility">
                    <i class="bi bi-eye fs-5"></i>
                  </button>
                </div>
                <span id="loginPasswordFeedback" class="input-validation-msg d-none"></span>
              </div>

              <!-- Remember Me & Security Indicator -->
              <div class="d-flex align-items-center justify-content-between mb-4">
                <div class="form-check">
                  <input class="form-check-input" type="checkbox" id="rememberMe" checked>
                  <label class="form-check-label small text-muted fw-semibold" for="rememberMe">Remember Me</label>
                </div>
                <small class="text-muted fw-bold" style="font-size: 0.78rem;">
                  <i class="bi bi-shield-lock-fill text-success me-1"></i> Secure Login
                </small>
              </div>

              <!-- Submit CTA -->
              <button type="submit" id="btnLoginSubmit" class="btn btn-hero-orange w-100 py-3 fw-bold justify-content-center fs-6 shadow rounded-3">
                LOGIN TO SMASHZONE <i class="bi bi-arrow-right ms-2 fs-5"></i>
              </button>
            </form>

            <hr class="my-3 opacity-10">

            <div class="text-center small text-muted">
              Don't have an account? 
              <a href="#" class="text-orange fw-bold text-decoration-none ms-1" data-bs-toggle="modal" data-bs-target="#registerModal" data-bs-dismiss="modal">Create Account →</a>
            </div>

          </div>

        </div>
      </div>
    </div>

    <!-- 2. SIGN UP / REGISTER MODAL -->
    <div class="modal fade pro-auth-modal" id="registerModal" tabindex="-1" aria-labelledby="registerModalLabel" aria-hidden="true">
      <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable" style="max-width: 520px;">
        <div class="modal-content border-0 shadow-lg" style="border-radius: 24px; overflow: hidden; background: #ffffff;">
          
          <!-- Banner Header -->
          <div class="auth-modal-banner text-center position-relative p-4" style="background: linear-gradient(135deg, #051329 0%, #082F5A 50%, #0B4F9C 100%);">
            <button type="button" class="btn-close btn-close-white position-absolute top-0 end-0 m-3" data-bs-dismiss="modal" aria-label="Close"></button>
            
            <div class="mb-2">
              <span class="badge bg-warning text-dark px-3 py-1 rounded-pill font-semibold small shadow-sm">
                <i class="bi bi-trophy-fill me-1"></i> Join SmashZone Club
              </span>
            </div>

            <img src="images/logo/logo.png" alt="SmashZone Logo" style="height: 46px; background: white; padding: 5px 16px; border-radius: 12px;" class="mb-2 shadow-sm">
            <h4 class="fw-bold text-white mb-1" id="registerModalLabel" style="font-family: var(--font-heading);">Create Your Account</h4>
            <p class="text-light small opacity-85 mb-0">Join SmashZone to elevate your badminton experience</p>
          </div>

          <div class="modal-body p-4">

            <div id="registerAlert" class="alert d-none small rounded-3 mb-3"></div>

            <form id="formCustomerRegister" enctype="multipart/form-data" novalidate>
              <input type="hidden" name="action" value="register">

              <!-- First Name & Last Name (Responsive 2-Col) -->
              <div class="row g-2 mb-3">
                <div class="col-sm-6">
                  <label class="form-label font-semibold small text-navy mb-1" for="regFirstName">First Name</label>
                  <div class="position-relative">
                    <i class="bi bi-person-fill position-absolute top-50 start-0 translate-middle-y ms-3 text-primary"></i>
                    <input type="text" id="regFirstName" name="first_name" class="form-control ps-5 bg-light border-1" placeholder="e.g. Marcus" required>
                  </div>
                  <span id="regFirstNameFeedback" class="input-validation-msg d-none"></span>
                </div>
                <div class="col-sm-6">
                  <label class="form-label font-semibold small text-navy mb-1" for="regLastName">Last Name</label>
                  <div class="position-relative">
                    <i class="bi bi-person-fill position-absolute top-50 start-0 translate-middle-y ms-3 text-primary"></i>
                    <input type="text" id="regLastName" name="last_name" class="form-control ps-5 bg-light border-1" placeholder="e.g. Vance" required>
                  </div>
                  <span id="regLastNameFeedback" class="input-validation-msg d-none"></span>
                </div>
              </div>

              <!-- Email Address -->
              <div class="mb-3">
                <label class="form-label font-semibold small text-navy mb-1" for="regEmail">Email Address</label>
                <div class="position-relative">
                  <i class="bi bi-envelope-at-fill position-absolute top-50 start-0 translate-middle-y ms-3 text-primary"></i>
                  <input type="email" id="regEmail" name="email" class="form-control ps-5 bg-light border-1" placeholder="player@smashzone.lk" required>
                </div>
                <span id="regEmailFeedback" class="input-validation-msg d-none"></span>
              </div>

              <!-- Phone Number -->
              <div class="mb-3">
                <label class="form-label font-semibold small text-navy mb-1" for="regPhone">Phone Number</label>
                <div class="position-relative">
                  <i class="bi bi-telephone-fill position-absolute top-50 start-0 translate-middle-y ms-3 text-primary"></i>
                  <input type="tel" id="regPhone" name="phone" class="form-control ps-5 bg-light border-1" placeholder="0771234567 or +94771234567" required>
                </div>
                <span id="regPhoneFeedback" class="input-validation-msg d-none"></span>
              </div>

              <!-- Passwords (2-Col) -->
              <div class="row g-2 mb-2">
                <div class="col-sm-6">
                  <label class="form-label font-semibold small text-navy mb-1" for="regPasswordInput">Password</label>
                  <div class="position-relative">
                    <i class="bi bi-lock-fill position-absolute top-50 start-0 translate-middle-y ms-3 text-primary"></i>
                    <input type="password" id="regPasswordInput" name="password" class="form-control ps-5 pe-4 bg-light border-1" placeholder="Strong Password" required>
                    <button type="button" class="btn btn-link text-secondary position-absolute top-50 end-0 translate-middle-y text-decoration-none pe-2" onclick="togglePassVisibility('regPasswordInput', this)" aria-label="Toggle Password Visibility">
                      <i class="bi bi-eye fs-6"></i>
                    </button>
                  </div>
                </div>
                <div class="col-sm-6">
                  <label class="form-label font-semibold small text-navy mb-1" for="regConfirmPasswordInput">Confirm Password</label>
                  <div class="position-relative">
                    <i class="bi bi-shield-lock-fill position-absolute top-50 start-0 translate-middle-y ms-3 text-primary"></i>
                    <input type="password" id="regConfirmPasswordInput" name="confirm_password" class="form-control ps-5 pe-4 bg-light border-1" placeholder="Repeat Password" required>
                    <button type="button" class="btn btn-link text-secondary position-absolute top-50 end-0 translate-middle-y text-decoration-none pe-2" onclick="togglePassVisibility('regConfirmPasswordInput', this)" aria-label="Toggle Password Visibility">
                      <i class="bi bi-eye fs-6"></i>
                    </button>
                  </div>
                </div>
              </div>

              <!-- Confirm Password Match Indicator -->
              <div class="mb-2">
                <span id="regConfirmFeedback" class="input-validation-msg d-none"></span>
              </div>

              <!-- Password Strength Meter & Live Checklist -->
              <div class="p-3 mb-3 bg-light rounded-3 border">
                <div class="d-flex justify-content-between align-items-center">
                  <span class="small fw-bold text-dark" style="font-size: 0.76rem;">Password Strength:</span>
                  <span id="passStrengthText" class="pass-strength-label text-muted">Not Entered</span>
                </div>
                <div class="pass-strength-meter">
                  <div id="passStrengthBar" class="pass-strength-bar"></div>
                </div>

                <ul class="pass-rules-list">
                  <li id="ruleLength" class="pass-rule-item unmet"><i class="bi bi-circle"></i> At least 8 characters</li>
                  <li id="ruleUpper" class="pass-rule-item unmet"><i class="bi bi-circle"></i> At least 2 uppercase (A-Z)</li>
                  <li id="ruleLower" class="pass-rule-item unmet"><i class="bi bi-circle"></i> At least 2 lowercase (a-z)</li>
                  <li id="ruleNum" class="pass-rule-item unmet"><i class="bi bi-circle"></i> At least 1 number (0-9)</li>
                  <li id="ruleSpec" class="pass-rule-item unmet"><i class="bi bi-circle"></i> At least 1 special char (!@#$%)</li>
                </ul>
              </div>

              <!-- Optional Profile Picture Upload -->
              <div class="mb-4 p-3 bg-light rounded-3 border">
                <label class="form-label font-semibold small text-navy mb-1 d-block" for="regProfilePic">
                  <i class="bi bi-camera-fill me-1 text-orange"></i> Profile Picture (Optional)
                </label>
                <input type="file" id="regProfilePic" name="profile_picture" class="form-control form-control-sm" accept="image/jpeg,image/png,image/webp">
                <small class="text-muted d-block mt-1" style="font-size: 0.72rem;">Supported formats: JPG, PNG, WEBP (Max size 5MB)</small>
                <span id="regProfilePicFeedback" class="input-validation-msg d-none"></span>
              </div>

              <!-- Submit CTA -->
              <button type="submit" id="btnRegisterSubmit" class="btn btn-hero-orange w-100 py-3 fw-bold justify-content-center fs-6 shadow rounded-3" disabled>
                CREATE SMASHZONE ACCOUNT <i class="bi bi-person-check-fill ms-2 fs-5"></i>
              </button>
            </form>

            <hr class="my-3 opacity-10">

            <div class="text-center small text-muted">
              Already have an account? 
              <a href="#" class="text-orange fw-bold text-decoration-none ms-1" data-bs-toggle="modal" data-bs-target="#loginModal" data-bs-dismiss="modal">Log In →</a>
            </div>

          </div>

        </div>
      </div>
    </div>
    <?php
}
}
?>

