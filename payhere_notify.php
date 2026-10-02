<?php
/**
 * SmashZone - PayHere Instant Payment Notification (IPN) Webhook
 * Server-to-server asynchronous callback handler from PayHere Gateway
 */

require_once __DIR__ . '/includes/db.php';
require_once __DIR__ . '/includes/payhere_config.php';

// Ensure request is POST
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    exit('Method Not Allowed');
}

$merchantId      = trim($_POST['merchant_id'] ?? '');
$orderId         = intval($_POST['order_id'] ?? 0);
$payherePaymentId= trim($_POST['payment_id'] ?? '');
$payhereAmount   = trim($_POST['payhere_amount'] ?? '');
$payhereCurrency = trim($_POST['payhere_currency'] ?? '');
$statusCode      = trim($_POST['status_code'] ?? '');
$md5sig          = trim($_POST['md5sig'] ?? '');

if (empty($merchantId) || $orderId <= 0 || empty($md5sig)) {
    http_response_code(400);
    exit('Bad Request: Missing IPN Parameters');
}

// Verify PayHere Security Signature
$isValidSig = verifyPayHereIPN($merchantId, $orderId, $payhereAmount, $payhereCurrency, $statusCode, $md5sig);

if (!$isValidSig) {
    // Log signature verification failure
    error_log("PayHere IPN Signature Verification Failed for Order #$orderId");
    http_response_code(400);
    exit('Invalid Hash Signature');
}

try {
    // PayHere Status Codes:
    // 2  = Success / Paid
    // 0  = Pending
    // -1 = Canceled
    // -2 = Failed
    // -3 = Chargedback
    if ($statusCode == 2) {
        $stmt = $pdo->prepare("UPDATE orders SET payment_status = 'paid', status = 'processing', payhere_payment_id = ? WHERE id = ?");
        $stmt->execute([$payherePaymentId, $orderId]);
    } elseif ($statusCode == -1 || $statusCode == -2 || $statusCode == -3) {
        $stmt = $pdo->prepare("UPDATE orders SET payment_status = 'failed' WHERE id = ?");
        $stmt->execute([$orderId]);
    }

    http_response_code(200);
    echo "OK";
} catch (Exception $e) {
    error_log("PayHere IPN DB Exception: " . $e->getMessage());
    http_response_code(500);
    echo "Server Error";
}
