<?php
$secret1 = 'ODMzNjIyMzk5MTgxODMyMzc3NzIwNTU3OTc4ODkxNTMzNzg5NTQ4';
$secret2 = base64_decode($secret1);

$merchant_id = '1238365';
$order_id = '11';
$amount = '84900.00';
$currency = 'LKR';

$hash1 = strtoupper(md5($merchant_id . $order_id . $amount . $currency . strtoupper(md5($secret1))));
$hash2 = strtoupper(md5($merchant_id . $order_id . $amount . $currency . strtoupper(md5($secret2))));

echo "Merchant ID: " . $merchant_id . "\n";
echo "Hash 1 (raw secret): " . $hash1 . "\n";
echo "Hash 2 (base64 decoded secret): " . $hash2 . "\n";
