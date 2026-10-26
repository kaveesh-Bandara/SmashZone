<?php
require_once __DIR__ . '/../includes/db.php';

echo "--- orders ---\n";
$q = $pdo->query('DESCRIBE orders');
while ($r = $q->fetch(PDO::FETCH_ASSOC)) {
    echo "{$r['Field']} ({$r['Type']})\n";
}

echo "--- order_items ---\n";
$q2 = $pdo->query('DESCRIBE order_items');
while ($r = $q2->fetch(PDO::FETCH_ASSOC)) {
    echo "{$r['Field']} ({$r['Type']})\n";
}
