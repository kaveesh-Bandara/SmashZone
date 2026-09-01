<?php
/**
 * SmashZone - Admin Profile & Security Settings (admin/settings.php)
 */

$pageTitle = "Admin Settings";
$currentPage = "settings";

require_once __DIR__ . '/includes/auth_check.php';
require_once __DIR__ . '/includes/functions.php';
require_once __DIR__ . '/../includes/db.php';

$successMessage = '';
$errorMessage = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    verify_csrf_token();
    $action = $_POST['action'] ?? '';

    if ($action === 'update_profile') {
        $firstName = trim($_POST['first_name'] ?? '');
        $lastName = trim($_POST['last_name'] ?? '');
        $phone = trim($_POST['phone'] ?? '');

        if (!empty($firstName) && !empty($lastName)) {
            $stmt = $pdo->prepare("UPDATE users SET first_name = ?, last_name = ?, phone = ? WHERE id = ?");
            if ($stmt->execute([$firstName, $lastName, $phone, $adminUser['id']])) {
                $_SESSION['user']['first_name'] = $firstName;
                $_SESSION['user']['last_name'] = $lastName;
                $_SESSION['user']['name'] = $firstName . ' ' . $lastName;
                $_SESSION['user']['phone'] = $phone;
                $adminUser = $_SESSION['user'];
                $successMessage = "Profile details updated successfully!";
            }
        }
    } elseif ($action === 'change_password') {
        $currentPass = $_POST['current_password'] ?? '';
        $newPass = $_POST['new_password'] ?? '';
        $confirmPass = $_POST['confirm_password'] ?? '';

        if (empty($currentPass) || empty($newPass) || empty($confirmPass)) {
            $errorMessage = "Please fill in all password fields.";
        } elseif ($newPass !== $confirmPass) {
            $errorMessage = "New passwords do not match.";
        } elseif (strlen($newPass) < 8) {
            $errorMessage = "New password must be at least 8 characters long.";
        } else {
            // Verify current password
            $stmt = $pdo->prepare("SELECT password FROM users WHERE id = ?");
            $stmt->execute([$adminUser['id']]);
            $u = $stmt->fetch();

            if ($u && password_verify($currentPass, $u['password'])) {
                $hashedNew = password_hash($newPass, PASSWORD_DEFAULT);
                $up = $pdo->prepare("UPDATE users SET password = ? WHERE id = ?");
                if ($up->execute([$hashedNew, $adminUser['id']])) {
                    $successMessage = "Password changed successfully!";
                }
            } else {
                $errorMessage = "Incorrect current password.";
            }
        }
    }
}

require_once __DIR__ . '/includes/header.php';
?>

<!-- Header -->
<div class="page-header">
  <div class="page-title-group">
    <h1><i class="bi bi-gear text-primary me-2"></i>Account & Security Settings</h1>
    <p class="page-subtitle">Manage your administrator profile details and account security password.</p>
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

<div class="row g-4">
  
  <!-- Profile Information -->
  <div class="col-lg-6">
    <div class="admin-card">
      <div class="admin-card-header">
        <h3 class="admin-card-title"><i class="bi bi-person-circle text-primary"></i> Administrator Details</h3>
      </div>
      <div class="admin-card-body">
        <form method="POST" action="settings.php">
          <input type="hidden" name="csrf_token" value="<?= $_SESSION['csrf_token'] ?>">
          <input type="hidden" name="action" value="update_profile">

          <div class="row g-3 mb-3">
            <div class="col-6">
              <label class="form-label">First Name</label>
              <input type="text" name="first_name" class="form-control" value="<?= htmlspecialchars($adminUser['first_name'] ?? 'SmashZone') ?>" required>
            </div>
            <div class="col-6">
              <label class="form-label">Last Name</label>
              <input type="text" name="last_name" class="form-control" value="<?= htmlspecialchars($adminUser['last_name'] ?? 'Administrator') ?>" required>
            </div>
          </div>

          <div class="mb-3">
            <label class="form-label">Email Address (Read-only)</label>
            <input type="email" class="form-control bg-light" value="<?= htmlspecialchars($adminUser['email'] ?? 'admin@smashzone.lk') ?>" readonly>
          </div>

          <div class="mb-4">
            <label class="form-label">Phone Number</label>
            <input type="tel" name="phone" class="form-control" value="<?= htmlspecialchars($adminUser['phone'] ?? '+94 11 234 5678') ?>">
          </div>

          <button type="submit" class="btn btn-primary-green w-100 py-2.5">
            <i class="bi bi-save me-1"></i> Save Profile Details
          </button>
        </form>
      </div>
    </div>
  </div>

  <!-- Security Password -->
  <div class="col-lg-6">
    <div class="admin-card">
      <div class="admin-card-header">
        <h3 class="admin-card-title"><i class="bi bi-shield-lock text-warning"></i> Change Admin Password</h3>
      </div>
      <div class="admin-card-body">
        <form method="POST" action="settings.php">
          <input type="hidden" name="csrf_token" value="<?= $_SESSION['csrf_token'] ?>">
          <input type="hidden" name="action" value="change_password">

          <div class="mb-3">
            <label class="form-label">Current Password</label>
            <input type="password" name="current_password" class="form-control" required placeholder="••••••••">
          </div>

          <div class="mb-3">
            <label class="form-label">New Password</label>
            <input type="password" name="new_password" class="form-control" required placeholder="Min 8 characters">
          </div>

          <div class="mb-4">
            <label class="form-label">Confirm New Password</label>
            <input type="password" name="confirm_password" class="form-control" required placeholder="Repeat new password">
          </div>

          <button type="submit" class="btn btn-secondary-light border-warning text-dark font-semibold w-100 py-2.5">
            <i class="bi bi-key me-1"></i> Update Security Password
          </button>
        </form>
      </div>
    </div>
  </div>

</div>

<?php require_once __DIR__ . '/includes/footer.php'; ?>
