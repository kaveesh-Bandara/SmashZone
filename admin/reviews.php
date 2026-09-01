<?php
/**
 * SmashZone - Messages & Reviews Management (admin/reviews.php)
 */

$pageTitle = "Messages & Reviews";
$currentPage = "reviews";

require_once __DIR__ . '/includes/header.php';

// Fetch contact messages
$messages = $pdo->query("SELECT * FROM contact_messages ORDER BY created_at DESC")->fetchAll();
?>

<!-- Header -->
<div class="page-header">
  <div class="page-title-group">
    <h1><i class="bi bi-chat-left-text text-primary me-2"></i>Customer Messages & Contact Submissions</h1>
    <p class="page-subtitle">Review feedback and contact queries sent from the customer website.</p>
  </div>
</div>

<div class="admin-card">
  <div class="admin-card-header">
    <h3 class="admin-card-title">
      <i class="bi bi-envelope-paper text-primary"></i> Customer Messages (<?= count($messages) ?> Total)
    </h3>
  </div>

  <div class="table-responsive">
    <table class="admin-table">
      <thead>
        <tr>
          <th>Sender Name</th>
          <th>Email Address</th>
          <th>Subject</th>
          <th>Message Content</th>
          <th>Submitted Date</th>
        </tr>
      </thead>
      <tbody>
        <?php if (empty($messages)): ?>
          <tr>
            <td colspan="5" class="text-center py-5 text-muted">
              <i class="bi bi-chat-square-text fs-2 d-block mb-2 text-secondary"></i>
              No contact messages recorded yet.
            </td>
          </tr>
        <?php else: ?>
          <?php foreach ($messages as $msg): ?>
            <tr>
              <td class="fw-bold text-dark"><?= htmlspecialchars($msg['name']) ?></td>
              <td><small class="text-muted"><?= htmlspecialchars($msg['email']) ?></small></td>
              <td><span class="badge bg-light text-dark border"><?= htmlspecialchars($msg['subject']) ?></span></td>
              <td><small class="text-dark"><?= nl2br(htmlspecialchars($msg['message'])) ?></small></td>
              <td><small class="text-muted"><?= date('M d, Y H:i', strtotime($msg['created_at'])) ?></small></td>
            </tr>
          <?php endforeach; ?>
        <?php endif; ?>
      </tbody>
    </table>
  </div>
</div>

<?php require_once __DIR__ . '/includes/footer.php'; ?>
