<?php
ob_start();
/**
 * SmashZone - Admin Security Authorization Middleware (admin/includes/auth_check.php)
 * Enforces server-side PHP session verification for all protected Admin Panel pages.
 */

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// 1. Verify user session and role
$isLoggedIn = isset($_SESSION['user']) && !empty($_SESSION['user']['id']);
$userRole = $_SESSION['role'] ?? $_SESSION['user']['role'] ?? '';

if (!$isLoggedIn || $userRole !== 'admin') {
    // If request is an AJAX call, return JSON error HTTP 403
    if (!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) === 'xmlhttprequest') {
        header('Content-Type: application/json');
        http_response_code(403);
        echo json_encode(['status' => 'error', 'message' => 'Access Denied: Admin authorization required.']);
        exit;
    }

    // Standard page load: redirect to dedicated admin login portal
    header("Location: login.php?error=admin_required");
    exit;
}

// Security: Prevent session fixation
if (!isset($_SESSION['admin_initiated'])) {
    session_regenerate_id(true);
    $_SESSION['admin_initiated'] = time();
}

// CSRF Token Initialization
if (empty($_SESSION['csrf_token'])) {
    $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
}

$adminUser = $_SESSION['user'];
