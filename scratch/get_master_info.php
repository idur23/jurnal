<?php
$pdo = new PDO('mysql:host=localhost;dbname=jg_enterprise;charset=utf8mb4', 'root', '');

echo "=== TAHUN PELAJARAN ===\n";
foreach ($pdo->query('SELECT * FROM tahun_pelajaran')->fetchAll(PDO::FETCH_ASSOC) as $r) {
    echo "ID: {$r['id']}, Tahun: {$r['tahun']}, Semester: {$r['semester']}, Active: {$r['is_active']}\n";
}

echo "\n=== KELAS ===\n";
foreach ($pdo->query('SELECT * FROM kelas')->fetchAll(PDO::FETCH_ASSOC) as $r) {
    echo "ID: {$r['id']}, Kode: {$r['kode_kelas']}, Nama: {$r['nama_kelas']}, Tingkat: {$r['tingkat']}\n";
}

echo "\n=== MATA PELAJARAN ===\n";
foreach ($pdo->query('SELECT * FROM mata_pelajaran')->fetchAll(PDO::FETCH_ASSOC) as $r) {
    echo "ID: {$r['id']}, Kode: {$r['kode_mapel']}, Nama: {$r['nama_mapel']}\n";
}

echo "\n=== GURU ===\n";
foreach ($pdo->query('SELECT * FROM guru')->fetchAll(PDO::FETCH_ASSOC) as $r) {
    echo "ID: {$r['id']}, NIP: {$r['nip']}, Nama: {$r['nama_lengkap']}\n";
}

echo "\n=== RUANGAN ===\n";
foreach ($pdo->query('SELECT * FROM ruangan')->fetchAll(PDO::FETCH_ASSOC) as $r) {
    echo "ID: {$r['id']}, Kode: {$r['kode_ruangan']}, Nama: {$r['nama_ruangan']}\n";
}
