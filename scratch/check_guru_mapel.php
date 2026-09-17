<?php
$pdo = new PDO('mysql:host=localhost;dbname=jg_enterprise;charset=utf8mb4', 'root', '');

echo "=== GURU MAPEL ===\n";
$gm = $pdo->query('SELECT gm.*, g.nama_lengkap, g.nip, mp.kode_mapel, mp.nama_mapel FROM guru_mapel gm JOIN guru g ON g.id=gm.guru_id JOIN mata_pelajaran mp ON mp.id=gm.mapel_id')->fetchAll(PDO::FETCH_ASSOC);
echo json_encode($gm, JSON_PRETTY_PRINT);
