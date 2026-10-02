<?php
/**
 * SmashZone - PayHere Payment Gateway Configuration
 * PayHere Merchant Credentials & Hash Generator Helpers
 */

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// --------------------------------------------------------------------------
// PayHere Merchant Credentials & Settings
// --------------------------------------------------------------------------
define('PAYHERE_MERCHANT_ID', '1238365'); // User PayHere Merchant ID
define('PAYHERE_MERCHANT_SECRET', 'ODMzNjIyMzk5MTgxODMyMzc3NzIwNTU3OTc4ODkxNTMzNzg5NTQ4'); // User PayHere Merchant Secret
define('PAYHERE_MODE', 'sandbox'); // 'sandbox' for testing, 'live' for production
define('PAYHERE_CURRENCY', 'LKR');

// PayHere Gateway URLs
if (PAYHERE_MODE === 'live') {
    define('PAYHERE_GATEWAY_URL', 'https://www.payhere.lk/pay/checkout');
} else {
    define('PAYHERE_GATEWAY_URL', 'https://sandbox.payhere.lk/pay/checkout');
}

/**
 * Get Site Base URL dynamically for callbacks
 */
if (!function_exists('getSmashZoneBaseUrl')) {
    function getSmashZoneBaseUrl() {
        $protocol = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on') || (isset($_SERVER['HTTP_X_FORWARDED_PROTO']) && $_SERVER['HTTP_X_FORWARDED_PROTO'] === 'https') ? "https" : "http";
        $host = $_SERVER['HTTP_HOST'] ?? 'localhost';
        $scriptDir = rtrim(dirname($_SERVER['SCRIPT_NAME']), '/\\');
        return "$protocol://$host$scriptDir/";
    }
}

/**
 * Compute MD5 Hash of PayHere Merchant Secret according to PayHere Standard Checkout SDK Specification.
 * Formula: strtoupper(md5(PAYHERE_MERCHANT_SECRET))
 */
if (!function_exists('getPayHereSecretHash')) {
    function getPayHereSecretHash($secret = PAYHERE_MERCHANT_SECRET) {
        return strtoupper(md5($secret));
    }
}

/**
 * Generate PayHere Checkout Security Hash
 * Formula: md5(merchant_id + order_id + amount + currency + md5(merchant_secret))
 */
if (!function_exists('generatePayHereHash')) {
    function generatePayHereHash($orderId, $amount, $currency = PAYHERE_CURRENCY) {
        $formattedAmount = number_format((float)$amount, 2, '.', '');
        $secretHash = getPayHereSecretHash(PAYHERE_MERCHANT_SECRET);
        $rawString = PAYHERE_MERCHANT_ID . $orderId . $formattedAmount . $currency . $secretHash;
        return strtoupper(md5($rawString));
    }
}

/**
 * Verify PayHere Instant Payment Notification (IPN) Signature
 */
if (!function_exists('verifyPayHereIPN')) {
    function verifyPayHereIPN($merchantId, $orderId, $payhereAmount, $payhereCurrency, $statusCode, $receivedMd5Sig) {
        $secretHash = getPayHereSecretHash(PAYHERE_MERCHANT_SECRET);
        $rawString = $merchantId . $orderId . $payhereAmount . $payhereCurrency . $statusCode . $secretHash;
        $localMd5Sig = strtoupper(md5($rawString));
        return ($localMd5Sig === strtoupper($receivedMd5Sig));
    }
}
