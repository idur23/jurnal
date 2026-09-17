<?php
$host = 'localhost';
$user = 'root';
$pass = '';

try {
    $pdo = new PDO("mysql:host=$host;charset=utf8mb4", $user, $pass, [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
    ]);

    $dbsStmt = $pdo->query("SHOW DATABASES");
    $dbs = $dbsStmt->fetchAll(PDO::FETCH_COLUMN);

    foreach ($dbs as $db) {
        if (in_array($db, ['information_schema', 'mysql', 'performance_schema', 'sys'])) continue;
        
        echo "Database: $db\n";
        $pdo->exec("USE `$db`");
        $tablesStmt = $pdo->query("SHOW TABLES");
        $tables = $tablesStmt->fetchAll(PDO::FETCH_COLUMN);

        foreach ($tables as $table) {
            echo "  - $table\n";
        }
    }
} catch (Exception $e) {
    echo "Error: " . $e->getMessage() . "\n";
}
