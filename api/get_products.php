<?php
/**
 * SmashZone - Public & Internal Products API Endpoint (api/get_products.php)
 * Returns active products from MySQL database smashZone in JSON format.
 */

header('Content-Type: application/json; charset=utf-8');
require_once __DIR__ . '/../includes/db.php';

try {
    $categorySlug = isset($_GET['category']) ? trim($_GET['category']) : '';
    $brand = isset($_GET['brand']) ? trim($_GET['brand']) : '';
    $search = isset($_GET['search']) ? trim($_GET['search']) : '';
    $includeInactive = isset($_GET['all']) && $_GET['all'] === '1'; // Admin check

    $sql = "SELECT p.*, c.name AS category_name, c.slug AS category_slug 
            FROM products p 
            JOIN categories c ON p.category_id = c.id 
            WHERE 1=1";

    $params = [];

    if (!$includeInactive) {
        $sql .= " AND p.status = 'active'";
    }

    if (!empty($categorySlug)) {
        $sql .= " AND c.slug = ?";
        $params[] = $categorySlug;
    }

    if (!empty($brand)) {
        $sql .= " AND p.brand = ?";
        $params[] = $brand;
    }

    if (!empty($search)) {
        $sql .= " AND (p.name LIKE ? OR p.brand LIKE ? OR p.description LIKE ?)";
        $searchTerm = '%' . $search . '%';
        $params[] = $searchTerm;
        $params[] = $searchTerm;
        $params[] = $searchTerm;
    }

    $sql .= " ORDER BY p.id ASC";

    $stmt = $pdo->prepare($sql);
    $stmt->execute($params);
    $rawProducts = $stmt->fetchAll();

    $formattedProducts = array_map(function($p) {
        return [
            'id' => (int)$p['id'],
            'category_id' => (int)$p['category_id'],
            'category_name' => $p['category_name'],
            'category_slug' => $p['category_slug'],
            'brand' => $p['brand'],
            'name' => $p['name'],
            'price' => (float)$p['price'],
            'oldPrice' => (float)$p['old_price'],
            'badge' => $p['badge'],
            'badgeClass' => $p['badge_class'],
            'rating' => (float)$p['rating'],
            'reviews' => (int)$p['reviews'],
            'image' => $p['image'],
            'stock' => isset($p['stock']) ? (int)$p['stock'] : 15,
            'status' => $p['status'] ?? 'active',
            'spec_1' => $p['spec_1'],
            'spec_2' => $p['spec_2'],
            'spec_3' => $p['spec_3'],
            'desc' => $p['description'],
            'description' => $p['description'],
            'created_at' => $p['created_at']
        ];
    }, $rawProducts);

    echo json_encode([
        'status' => 'success',
        'count' => count($formattedProducts),
        'products' => $formattedProducts
    ]);

} catch (Exception $e) {
    http_response_code(500);
    echo json_encode([
        'status' => 'error',
        'message' => 'Failed to fetch products: ' . $e->getMessage()
    ]);
}
