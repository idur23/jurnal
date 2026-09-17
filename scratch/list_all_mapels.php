<?php
$pdo = new PDO('mysql:host=localhost;dbname=jg_enterprise;charset=utf8mb4', 'root', '');
$mapels = $pdo->query('SELECT id, kode_mapel, nama_mapel FROM mata_pelajaran ORDER BY id ASC')->fetchAll(PDO::FETCH_ASSOC);
foreach ($mapels as $m) {
    echo "ID: {$m['id']}, Kode: '{$m['kode_mapel']}', Nama: '{$m['nama_mapel']}'\n";
}
