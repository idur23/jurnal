<?php
$pdo = new PDO('mysql:host=localhost;dbname=jg_enterprise;charset=utf8mb4', 'root', '');

echo "=== TAHUN PELAJARAN ===\n";
print_r($pdo->query('SELECT * FROM tahun_pelajaran')->fetchAll(PDO::FETCH_ASSOC));

echo "=== KELAS ===\n";
print_r($pdo->query('SELECT * FROM kelas')->fetchAll(PDO::FETCH_ASSOC));

echo "=== MATA PELAJARAN ===\n";
print_r($pdo->query('SELECT * FROM mata_pelajaran')->fetchAll(PDO::FETCH_ASSOC));

echo "=== GURU ===\n";
print_r($pdo->query('SELECT * FROM guru')->fetchAll(PDO::FETCH_ASSOC));

echo "=== RUANGAN ===\n";
print_r($pdo->query('SELECT * FROM ruangan')->fetchAll(PDO::FETCH_ASSOC));

echo "=== STRUCTURE OF JADWAL_PELAJARAN ===\n";
print_r($pdo->query('DESCRIBE jadwal_pelajaran')->fetchAll(PDO::FETCH_ASSOC));
