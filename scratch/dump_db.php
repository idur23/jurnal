<?php
$command = 'C:\laragon\bin\mysql\mysql-8.0.30-winx64\bin\mysqldump.exe -u root jg_enterprise > database.sql';
// Try standard mysqldump or php export
exec('mysqldump -u root jg_enterprise > database.sql', $output, $return_var);

if ($return_var !== 0) {
    // Backup approach via PHP PDO script
    $pdo = new PDO('mysql:host=localhost;dbname=jg_enterprise;charset=utf8mb4', 'root', '');
    $tables = ['tahun_pelajaran', 'kelas', 'ruangan', 'guru', 'mata_pelajaran', 'guru_mapel', 'jam_pelajaran', 'jadwal_pelajaran'];
    
    $sqlDump = "-- Database dump for jg_enterprise\n";
    $sqlDump .= "-- Created at " . date('Y-m-d H:i:s') . "\n\n";
    $sqlDump .= "SET FOREIGN_KEY_CHECKS=0;\n\n";

    // We can dump all tables or main tables
    $allTables = $pdo->query('SHOW TABLES')->fetchAll(PDO::FETCH_COLUMN);
    foreach ($allTables as $t) {
        $createStmt = $pdo->query("SHOW CREATE TABLE `$t`")->fetch(PDO::FETCH_ASSOC);
        $sqlDump .= "DROP TABLE IF EXISTS `$t`;\n";
        $sqlDump .= $createStmt['Create Table'] . ";\n\n";

        $rows = $pdo->query("SELECT * FROM `$t`")->fetchAll(PDO::FETCH_ASSOC);
        if (count($rows) > 0) {
            foreach ($rows as $row) {
                $cols = array_map(function($c) { return "`$c`"; }, array_keys($row));
                $vals = array_map(function($v) use ($pdo) {
                    if ($v === NULL) return 'NULL';
                    return $pdo->quote($v);
                }, array_values($row));
                $sqlDump .= "INSERT INTO `$t` (" . implode(', ', $cols) . ") VALUES (" . implode(', ', $vals) . ");\n";
            }
            $sqlDump .= "\n";
        }
    }
    $sqlDump .= "SET FOREIGN_KEY_CHECKS=1;\n";
    file_put_contents('database.sql', $sqlDump);
    echo "Exported database.sql via PHP PDO successfully.\n";
} else {
    echo "Exported database.sql via mysqldump successfully.\n";
}
