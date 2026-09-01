<?php
/**
 * SmashZone Admin Logout Handler (admin/logout.php)
 */

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

unset($_SESSION['user']);
unset($_SESSION['role']);
unset($_SESSION['admin_initiated']);
unset($_SESSION['csrf_token']);

session_destroy();

header('Location: ../index.php');
exit;
