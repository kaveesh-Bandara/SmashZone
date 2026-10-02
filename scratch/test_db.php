<?php
require_once __DIR__ . '/../includes/db.php';
echo "Connected successfully!\n";
$stmt = $pdo->query("SELECT COUNT(*) FROM users");
echo "Users count: " . $stmt->fetchColumn() . "\n";
$stmt2 = $pdo->query("SELECT COUNT(*) FROM products");
echo "Products count: " . $stmt2->fetchColumn() . "\n";
