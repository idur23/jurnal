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
        
        $pdo->exec("USE `$db`");
        $tablesStmt = $pdo->query("SHOW TABLES");
        $tables = $tablesStmt->fetchAll(PDO::FETCH_COLUMN);

        foreach ($tables as $table) {
            // Check if table has text columns
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
                echo "Found in DB: $db, table: $table (Count: " . count($results) . ")\n";
                foreach ($results as $row) {
                    print_r($row);
                }
            }
        }
    }
} catch (Exception $e) {
    echo "Error: " . $e->getMessage() . "\n";
}
echo "All DB search completed.\n";
