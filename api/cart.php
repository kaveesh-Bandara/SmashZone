<?php
/**
 * SmashZone - Cart Action Endpoint (api/cart.php)
 * Handles AJAX add, update, remove, get, and clear for customer session cart.
 */

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Enforce User Login Requirement for cart modification
if (!isset($_SESSION['user'])) {
    echo json_encode([
        'status' => 'login_required',
        'message' => 'Please log in first to purchase or add products to your cart!'
    ]);
    exit;
}

require_once __DIR__ . '/../includes/db.php';

$action = $_POST['action'] ?? $_GET['action'] ?? 'get';
$productId = intval($_POST['product_id'] ?? $_POST['id'] ?? 0);
$quantity = intval($_POST['quantity'] ?? 1);

if (!isset($_SESSION['cart']) || !is_array($_SESSION['cart'])) {
    $_SESSION['cart'] = [];
}

// 1. ADD TO CART
if ($action === 'add' && $productId > 0) {
    $stmt = $pdo->prepare("SELECT * FROM products WHERE id = ?");
    $stmt->execute([$productId]);
    $product = $stmt->fetch();

    $name = $product ? $product['name'] : trim($_POST['name'] ?? 'Badminton Equipment');
    $price = $product ? floatval($product['price']) : floatval($_POST['price'] ?? 0);
    $image = $product ? $product['image'] : trim($_POST['image'] ?? 'images/products/product-racket-x900.png');

    if (isset($_SESSION['cart'][$productId])) {
        $_SESSION['cart'][$productId]['qty'] += max(1, $quantity);
    } else {
        $_SESSION['cart'][$productId] = [
            'id' => (int)$productId,
            'name' => $name,
            'price' => $price,
            'image' => $image,
            'qty' => max(1, $quantity)
        ];
    }

    $cartValues = array_values($_SESSION['cart']);
    $totalQty = array_sum(array_column($cartValues, 'qty'));
    $totalAmount = array_reduce($cartValues, function($sum, $item) {
        return $sum + ($item['price'] * $item['qty']);
    }, 0);

    echo json_encode([
        'status' => 'success',
        'message' => 'Product added to cart!',
        'totalQty' => $totalQty,
        'totalAmount' => $totalAmount,
        'cart' => $cartValues
    ]);
    exit;
}

// 2. UPDATE ITEM QUANTITY
if ($action === 'update' && $productId > 0) {
    if (isset($_SESSION['cart'][$productId])) {
        if ($quantity <= 0) {
            unset($_SESSION['cart'][$productId]);
        } else {
            $_SESSION['cart'][$productId]['qty'] = $quantity;
        }
    }
    $cartValues = array_values($_SESSION['cart']);
    $totalQty = array_sum(array_column($cartValues, 'qty'));
    $totalAmount = array_reduce($cartValues, function($sum, $item) {
        return $sum + ($item['price'] * $item['qty']);
    }, 0);

    echo json_encode([
        'status' => 'success',
        'totalQty' => $totalQty,
        'totalAmount' => $totalAmount,
        'cart' => $cartValues
    ]);
    exit;
}

// 3. REMOVE ITEM
if ($action === 'remove' && $productId > 0) {
    if (isset($_SESSION['cart'][$productId])) {
        unset($_SESSION['cart'][$productId]);
    }
    $cartValues = array_values($_SESSION['cart']);
    $totalQty = array_sum(array_column($cartValues, 'qty'));
    $totalAmount = array_reduce($cartValues, function($sum, $item) {
        return $sum + ($item['price'] * $item['qty']);
    }, 0);

    echo json_encode([
        'status' => 'success',
        'totalQty' => $totalQty,
        'totalAmount' => $totalAmount,
        'cart' => $cartValues
    ]);
    exit;
}

// 4. CLEAR CART
if ($action === 'clear') {
    $_SESSION['cart'] = [];
    echo json_encode(['status' => 'success', 'cart' => [], 'totalQty' => 0, 'totalAmount' => 0]);
    exit;
}

// 5. GET CART
if ($action === 'get') {
    $cartValues = array_values($_SESSION['cart']);
    $totalQty = array_sum(array_column($cartValues, 'qty'));
    $totalAmount = array_reduce($cartValues, function($sum, $item) {
        return $sum + ($item['price'] * $item['qty']);
    }, 0);

    echo json_encode([
        'status' => 'success',
        'cart' => $cartValues,
        'totalQty' => $totalQty,
        'totalAmount' => $totalAmount
    ]);
    exit;
}

echo json_encode(['status' => 'error', 'message' => 'Invalid cart action.']);
exit;
