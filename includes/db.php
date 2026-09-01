<?php
/**
 * SmashZone - Database Connection (PDO)
 * Target Database: smashZone on XAMPP MySQL
 */

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

$host = 'localhost';
$dbname = 'smashZone';
$username = 'root';
$password = '';

try {
    // First connect without dbname to ensure database exists
    $pdo = new PDO("mysql:host=$host;charset=utf8mb4", $username, $password, [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        PDO::ATTR_EMULATE_PREPARES => false,
    ]);

    // Create database if it does not exist yet
    $pdo->exec("CREATE DATABASE IF NOT EXISTS `$dbname` CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;");
    $pdo->exec("USE `$dbname`;");

    // Auto-heal: Check if essential tables exist and are accessible in MySQL engine
    $needsInit = false;
    try {
        $pdo->query("SELECT 1 FROM `categories` LIMIT 1");
        $pdo->query("SELECT 1 FROM `products` LIMIT 1");
    } catch (PDOException $e) {
        // Table missing or InnoDB Error 1932 ("Table 'smashzone.categories' doesn't exist in engine")
        $needsInit = true;
    }

    if ($needsInit) {
        $sqlPath = dirname(__DIR__) . '/database.sql';
        if (file_exists($sqlPath)) {
            try {
                // Drop and recreate database to resolve InnoDB 1932 tablespace mismatch on XAMPP
                $pdo->exec("DROP DATABASE IF EXISTS `$dbname`;");
                $pdo->exec("CREATE DATABASE `$dbname` CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;");
                $pdo->exec("USE `$dbname`;");
            } catch (Exception $ex) {}

            $sql = file_get_contents($sqlPath);
            $pdo->exec($sql);
        }
    }

    // Auto-migration: Ensure stock, status, and updated_at columns exist on products table
    try {
        $cols = $pdo->query("SHOW COLUMNS FROM `products` LIKE 'stock'")->fetch();
        if (!$cols) {
            $pdo->exec("ALTER TABLE `products` ADD COLUMN `stock` INT NOT NULL DEFAULT 15 AFTER `price`;");
        }
        $colsStatus = $pdo->query("SHOW COLUMNS FROM `products` LIKE 'status'")->fetch();
        if (!$colsStatus) {
            $pdo->exec("ALTER TABLE `products` ADD COLUMN `status` ENUM('active', 'inactive') NOT NULL DEFAULT 'active' AFTER `stock`;");
        }
        $colsUpdated = $pdo->query("SHOW COLUMNS FROM `products` LIKE 'updated_at'")->fetch();
        if (!$colsUpdated) {
            $pdo->exec("ALTER TABLE `products` ADD COLUMN `updated_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP AFTER `created_at`;");
        }
        $catStatus = $pdo->query("SHOW COLUMNS FROM `categories` LIKE 'status'")->fetch();
        if (!$catStatus) {
            $pdo->exec("ALTER TABLE `categories` ADD COLUMN `status` ENUM('active', 'inactive') NOT NULL DEFAULT 'active' AFTER `description`;");
        }
    } catch (PDOException $e) {
        // Log migration warning quietly
    }

} catch (PDOException $e) {
    die("Database Connection Failure: " . $e->getMessage());
}
?>
