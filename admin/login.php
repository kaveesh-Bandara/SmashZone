<?php
/**
 * SmashZone - Admin Login Portal (admin/login.php)
 * Dedicated authentication page for SmashZone Administrators
 */

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

require_once __DIR__ . '/../includes/db.php';

// If already logged in as Admin, redirect straight to Admin Dashboard
if (isset($_SESSION['user']) && ($_SESSION['role'] ?? '') === 'admin') {
    header('Location: dashboard.php');
    exit;
}

$errorMsg = '';

// Handle Direct POST Form Submission (Fallback for non-JS / standard POST)
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = trim($_POST['email'] ?? '');
    $password = trim($_POST['password'] ?? '');

    if (empty($email) || empty($password)) {
        $errorMsg = 'Please enter both email address and password.';
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errorMsg = 'Invalid email address or password.';
    } else {
        try {
            $stmt = $pdo->prepare("SELECT * FROM users WHERE email = ?");
            $stmt->execute([$email]);
            $user = $stmt->fetch();

            if ($user && password_verify($password, $user['password'])) {
                if ($user['role'] !== 'admin') {
                    $errorMsg = 'Access Denied: Account does not have Administrator privileges.';
                } elseif ($user['status'] !== 'active') {
                    $errorMsg = 'This administrator account is suspended or inactive.';
                } else {
                    session_regenerate_id(true);
                    $_SESSION['user'] = [
                        'id' => (int)$user['id'],
                        'first_name' => $user['first_name'],
                        'last_name' => $user['last_name'],
                        'name' => $user['first_name'] . ' ' . $user['last_name'],
                        'email' => $user['email'],
                        'phone' => $user['phone'],
                        'profile_picture' => $user['profile_picture'] ?: 'https://images.unsplash.com/photo-1507003211169-0a1dd7228f2d?auto=format&fit=crop&w=300&q=80',
                        'role' => $user['role'],
                        'status' => $user['status']
                    ];
                    $_SESSION['role'] = $user['role'];

                    header('Location: dashboard.php');
                    exit;
                }
            } else {
                $errorMsg = 'Invalid email address or password.';
            }
        } catch (Exception $e) {
            error_log('SmashZone Admin Login Error: ' . $e->getMessage());
            $errorMsg = 'Something went wrong. Please try again later.';
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Admin Portal Login | SmashZone Control Panel</title>
  
  <!-- Google Fonts: Outfit & Plus Jakarta Sans -->
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@400;500;600;700;800&family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">

  <!-- Bootstrap 5 CSS & Icons -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">

  <style>
    :root {
      --primary-navy: #051329;
      --secondary-navy: #0B2545;
      --brand-orange: #FF5722;
      --brand-orange-hover: #E64A19;
      --font-body: 'Plus Jakarta Sans', sans-serif;
      --font-heading: 'Outfit', sans-serif;
    }
    body {
      font-family: var(--font-body);
      background: linear-gradient(135deg, #030C1A 0%, #071E3D 50%, #0B2545 100%);
      min-height: 100vh;
      display: flex;
      align-items: center;
      justify-content: center;
      padding: 20px;
      color: #334155;
    }
    .admin-login-card {
      width: 100%;
      max-width: 440px;
      background: #ffffff;
      border-radius: 24px;
      box-shadow: 0 20px 40px rgba(0, 0, 0, 0.4);
      overflow: hidden;
      border: 1px solid rgba(255, 255, 255, 0.1);
    }
    .admin-card-header {
      background: linear-gradient(135deg, #051329 0%, #0D2C54 100%);
      padding: 32px 24px 24px 24px;
      text-align: center;
      position: relative;
    }
    .admin-logo-badge {
      background: #ffffff;
      padding: 8px 20px;
      border-radius: 14px;
      display: inline-block;
      box-shadow: 0 4px 12px rgba(0,0,0,0.15);
      margin-bottom: 16px;
    }
    .admin-logo-img {
      height: 42px;
      object-fit: contain;
    }
    .btn-admin-submit {
      background: var(--brand-orange);
      color: #ffffff;
      font-weight: 700;
      border: none;
      padding: 14px;
      border-radius: 12px;
      transition: all 0.25s ease;
    }
    .btn-admin-submit:hover {
      background: var(--brand-orange-hover);
      color: #ffffff;
      transform: translateY(-1px);
      box-shadow: 0 6px 16px rgba(255, 87, 34, 0.35);
    }
  </style>
</head>
<body>

<div class="admin-login-card">
  
  <!-- Card Header -->
  <div class="admin-card-header">
    <div class="admin-logo-badge">
      <img src="../images/logo/logo.png" alt="SmashZone Logo" class="admin-logo-img">
    </div>
    <h3 class="fw-bold text-white mb-1" style="font-family: var(--font-heading);">Admin Portal Login</h3>
    <p class="text-white-50 small mb-0">Authorized SmashZone Management Access Only</p>
  </div>

  <!-- Card Body -->
  <div class="p-4 p-md-4">

    <?php if (!empty($errorMsg)): ?>
      <div class="alert alert-danger rounded-3 small mb-3 d-flex align-items-center gap-2">
        <i class="bi bi-exclamation-triangle-fill fs-5"></i>
        <div><?= htmlspecialchars($errorMsg) ?></div>
      </div>
    <?php endif; ?>

    <div id="adminLoginAlert" class="alert d-none rounded-3 small mb-3"></div>

    <form id="adminLoginForm" method="POST" action="login.php" novalidate>
      <input type="hidden" name="action" value="login">
      
      <!-- Email Input -->
      <div class="mb-3">
        <label class="form-label font-semibold small text-secondary mb-1" for="adminEmailInput">Admin Email Address</label>
        <div class="position-relative">
          <i class="bi bi-envelope-at-fill position-absolute top-50 start-0 translate-middle-y ms-3 text-muted"></i>
          <input type="email" id="adminEmailInput" name="email" class="form-control ps-5 py-2.5 rounded-3 border" placeholder="Enter admin email address" required style="font-size: 0.95rem;">
        </div>
      </div>

      <!-- Password Input -->
      <div class="mb-4">
        <label class="form-label font-semibold small text-secondary mb-1" for="adminPasswordInput">Password</label>
        <div class="position-relative">
          <i class="bi bi-key-fill position-absolute top-50 start-0 translate-middle-y ms-3 text-muted"></i>
          <input type="password" id="adminPasswordInput" name="password" class="form-control ps-5 pe-5 py-2.5 rounded-3 border" placeholder="Enter password" required style="font-size: 0.95rem;">
          <button type="button" class="btn btn-link text-secondary position-absolute top-50 end-0 translate-middle-y pe-3 text-decoration-none" onclick="togglePass()" aria-label="Toggle Password Visibility">
            <i class="bi bi-eye fs-5" id="passEyeIcon"></i>
          </button>
        </div>
      </div>

      <button type="submit" id="btnAdminSubmit" class="btn btn-admin-submit w-100 fs-6 shadow-sm">
        LOG IN TO ADMIN DASHBOARD <i class="bi bi-arrow-right ms-2 fs-5"></i>
      </button>
    </form>

    <div class="text-center mt-4 pt-3 border-top">
      <a href="../index.php" class="text-secondary small text-decoration-none fw-semibold">
        <i class="bi bi-arrow-left me-1"></i> Return to Store Front
      </a>
    </div>

  </div>
</div>

<script>
  function togglePass() {
    const input = document.getElementById('adminPasswordInput');
    const icon = document.getElementById('passEyeIcon');
    if (input.type === 'password') {
      input.type = 'text';
      icon.className = 'bi bi-eye-slash text-warning';
    } else {
      input.type = 'password';
      icon.className = 'bi bi-eye';
    }
  }

  // AJAX Admin Login Handler
  document.getElementById('adminLoginForm').addEventListener('submit', function(e) {
    e.preventDefault();
    const alertBox = document.getElementById('adminLoginAlert');
    const submitBtn = document.getElementById('btnAdminSubmit');
    const emailVal = document.getElementById('adminEmailInput').value.trim();
    const passVal = document.getElementById('adminPasswordInput').value.trim();

    if (!emailVal || !passVal) {
      alertBox.className = 'alert alert-danger rounded-3 small mb-3';
      alertBox.textContent = 'Please fill in both admin email address and password.';
      alertBox.classList.remove('d-none');
      return;
    }

    submitBtn.disabled = true;
    submitBtn.innerHTML = '<span class="spinner-border spinner-border-sm me-2" role="status" aria-hidden="true"></span> Authenticating...';
    alertBox.className = 'alert d-none';

    const formData = new FormData(this);

    fetch('../auth.php', { method: 'POST', body: formData })
      .then(res => res.json())
      .then(data => {
        alertBox.classList.remove('d-none');
        if (data.status === 'success') {
          alertBox.className = 'alert alert-success rounded-3 small mb-3';
          alertBox.textContent = data.message + ' Redirecting to Control Panel...';
          setTimeout(() => {
            let targetRedirect = data.redirect || 'dashboard.php';
            if (targetRedirect.startsWith('admin/')) {
              targetRedirect = targetRedirect.replace(/^admin\//, '');
            }
            window.location.href = targetRedirect;
          }, 600);
        } else {
          submitBtn.disabled = false;
          submitBtn.innerHTML = 'LOG IN TO ADMIN DASHBOARD <i class="bi bi-arrow-right ms-2 fs-5"></i>';
          alertBox.className = 'alert alert-danger rounded-3 small mb-3';
          alertBox.textContent = data.message;
        }
      })
      .catch(err => {
        // Fallback: Submit form standard POST if fetch fails
        this.submit();
      });
  });
</script>

</body>
</html>

