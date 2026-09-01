<?php
/**
 * SmashZone - Automated Database Installer Script
 * Run via browser (http://localhost/smahZone/setup_db.php) or PHP CLI
 */

echo "<h2>SmashZone Database Installer</h2>";

$host = 'localhost';
$username = 'root';
$password = '';
$dbname = 'smashZone';

try {
    $pdo = new PDO("mysql:host=$host;charset=utf8mb4", $username, $password, [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
    ]);

    // Clean drop if tables are corrupted
    try {
        $pdo->exec("DROP DATABASE IF EXISTS `$dbname`");
        $pdo->exec("DROP DATABASE IF EXISTS `smashzone`");
    } catch (Exception $ex) {}

    // Check for orphaned tablespace folder on XAMPP MySQL
    $mysqlDataPath = 'C:\\xampp\\mysql\\data\\smashzone';
    if (file_exists($mysqlDataPath)) {
        $files = glob($mysqlDataPath . '/*');
        if ($files) {
            foreach ($files as $file) {
                if (is_file($file)) @unlink($file);
            }
        }
        @rmdir($mysqlDataPath);
    }

    $pdo->exec("CREATE DATABASE `$dbname` CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci");
    $pdo->exec("USE `$dbname`");

    $sql = file_get_contents(__DIR__ . '/database.sql');
    $pdo->exec($sql);
    
    echo "<p style='color: green; font-weight: bold;'>✔ Database '$dbname' created and initialized successfully!</p>";
    echo "<p style='color: green;'>✔ Seeded 6 Categories and 74 Real-World Products into MySQL!</p>";
    echo "<p><a href='index.php' style='padding: 10px 20px; background: #FF5722; color: white; text-decoration: none; border-radius: 5px; font-weight: bold;'>Go to SmashZone Store Front →</a></p>";

} catch (Exception $e) {
    echo "<p style='color: red; font-weight: bold;'>✖ Database Installation Failed: " . $e->getMessage() . "</p>";
}
?>
