<?php
$host = 'localhost';
$user = 'root';
$pass = '';
$db   = 'jg_enterprise';

try {
    $pdo = new PDO("mysql:host=$host;dbname=$db;charset=utf8mb4", $user, $pass, [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
    ]);

    $tablesStmt = $pdo->query("SHOW TABLES");
    $tables = $tablesStmt->fetchAll(PDO::FETCH_COLUMN);

    foreach ($tables as $table) {
        // Get columns
        $colsStmt = $pdo->query("DESCRIBE `$table`");
        $cols = $colsStmt->fetchAll();

        $textCols = [];
        foreach ($cols as $col) {
            $type = strtolower($col['Type']);
            if (strpos($type, 'char') !== false || strpos($type, 'text') !== false) {
                $textCols[] = $col['Field'];
            }
        }

        if (empty($textCols)) continue;

        $conditions = [];
        foreach ($textCols as $col) {
            $conditions[] = "`$col` LIKE :query";
        }

        $sql = "SELECT * FROM `$table` WHERE " . implode(' OR ', $conditions);
        $stmt = $pdo->prepare($sql);
        $stmt->execute(['query' => '%TOK%']);
        $results = $stmt->fetchAll();

        if (!empty($results)) {
            echo "Found in table: $table (Count: " . count($results) . ")\n";
            foreach ($results as $row) {
                print_r($row);
            }
        }
    }
} catch (Exception $e) {
    echo "Error: " . $e->getMessage() . "\n";
}
echo "Database search completed.\n";
