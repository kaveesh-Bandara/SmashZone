<?php
/**
 * SmashZone Admin Utilities & Helpers (admin/includes/functions.php)
 */

if (!function_exists('verify_csrf_token')) {
    function verify_csrf_token() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $token = $_POST['csrf_token'] ?? $_SERVER['HTTP_X_CSRF_TOKEN'] ?? '';
            if (empty($token) || !hash_equals($_SESSION['csrf_token'] ?? '', $token)) {
                if (!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) === 'xmlhttprequest') {
                    header('Content-Type: application/json');
                    http_response_code(400);
                    echo json_encode(['status' => 'error', 'message' => 'Invalid or expired CSRF token. Please refresh the page.']);
                    exit;
                }
                die("CSRF Security Validation Failed.");
            }
        }
    }
}

if (!function_exists('handle_product_image_upload')) {
    function handle_product_image_upload($fileArray, $defaultPath = '') {
        if (!isset($fileArray) || $fileArray['error'] === UPLOAD_ERR_NO_FILE) {
            return $defaultPath;
        }

        if ($fileArray['error'] !== UPLOAD_ERR_OK) {
            throw new Exception("File upload failed with error code " . $fileArray['error']);
        }

        $fileName = $fileArray['name'];
        $fileTmp = $fileArray['tmp_name'];
        $fileSize = $fileArray['size'];
        $fileType = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));

        $allowedTypes = ['jpg', 'jpeg', 'png', 'webp'];
        if (!in_array($fileType, $allowedTypes)) {
            throw new Exception("Invalid image format. Allowed formats: JPG, JPEG, PNG, WEBP.");
        }

        if ($fileSize > 5 * 1024 * 1024) { // 5MB limit
            throw new Exception("Uploaded image exceeds the 5MB file size limit.");
        }

        $targetDir = __DIR__ . '/../../uploads/products/';
        if (!is_dir($targetDir)) {
            mkdir($targetDir, 0755, true);
        }

        $newFileName = 'prod_' . time() . '_' . uniqid() . '.' . $fileType;
        $targetFile = $targetDir . $newFileName;

        if (!move_uploaded_file($fileTmp, $targetFile)) {
            throw new Exception("Failed to move uploaded file to target directory.");
        }

        return 'uploads/products/' . $newFileName;
    }
}

if (!function_exists('sanitize')) {
    function sanitize($data) {
        return htmlspecialchars(trim($data ?? ''), ENT_QUOTES, 'UTF-8');
    }
}
