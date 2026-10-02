<?php
/**
 * SmashZone - Database Connection (PDO)
 * Target Database: smashZone on XAMPP MySQL
 */

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

require_once __DIR__ . '/payhere_config.php';

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
        $pdo->query("SELECT 1 FROM `users` LIMIT 1");
    } catch (PDOException $e) {
        // Table missing or InnoDB Error 1932 ("Table doesn't exist in engine") or 1813 ("Tablespace exists")
        $needsInit = true;
    }

    if ($needsInit) {
        $sqlPath = dirname(__DIR__) . '/database.sql';
        if (file_exists($sqlPath)) {
            $cleanupTablespace = function($dbName) {
                $paths = [
                    'C:\\xampp\\mysql\\data\\' . strtolower($dbName),
                    'C:\\xampp\\mysql\\data\\' . $dbName,
                ];
                foreach ($paths as $path) {
                    if (file_exists($path)) {
                        $files = glob($path . '/*');
                        if ($files) {
                            foreach ($files as $file) {
                                if (is_file($file)) @unlink($file);
                            }
                        }
                        @rmdir($path);
                    }
                }
            };

            try {
                $pdo->exec("DROP DATABASE IF EXISTS `$dbname`;");
                $pdo->exec("DROP DATABASE IF EXISTS `" . strtolower($dbname) . "`;");
            } catch (Exception $ex) {}

            $cleanupTablespace($dbname);

            $pdo->exec("CREATE DATABASE IF NOT EXISTS `$dbname` CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;");
            $pdo->exec("USE `$dbname`;");

            $sql = file_get_contents($sqlPath);
            try {
                $pdo->exec($sql);
            } catch (PDOException $e) {
                if (strpos($e->getMessage(), '1813') !== false || strpos($e->getMessage(), 'Tablespace') !== false) {
                    $cleanupTablespace($dbname);
                    $pdo->exec("CREATE DATABASE IF NOT EXISTS `$dbname` CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;");
                    $pdo->exec("USE `$dbname`;");
                    $pdo->exec($sql);
                } else {
                    throw $e;
                }
            }
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

        // Migration for Orders Table Payment Fields
        $colsPM = $pdo->query("SHOW COLUMNS FROM `orders` LIKE 'payment_method'")->fetch();
        if (!$colsPM) {
            $pdo->exec("ALTER TABLE `orders` ADD COLUMN `payment_method` VARCHAR(50) DEFAULT 'cod' AFTER `status`;");
        }
        $colsPS = $pdo->query("SHOW COLUMNS FROM `orders` LIKE 'payment_status'")->fetch();
        if (!$colsPS) {
            $pdo->exec("ALTER TABLE `orders` ADD COLUMN `payment_status` VARCHAR(50) DEFAULT 'pending' AFTER `payment_method`;");
        }
        $colsPID = $pdo->query("SHOW COLUMNS FROM `orders` LIKE 'payhere_payment_id'")->fetch();
        if (!$colsPID) {
            $pdo->exec("ALTER TABLE `orders` ADD COLUMN `payhere_payment_id` VARCHAR(100) DEFAULT NULL AFTER `payment_status`;");
        }
    } catch (PDOException $e) {
        // Log migration warning quietly
    }

} catch (PDOException $e) {
    die("Database Connection Failure: " . $e->getMessage());
}
?>
