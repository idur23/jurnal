<?php
$pdo = new PDO('mysql:host=localhost;dbname=jg_enterprise;charset=utf8mb4', 'root', '');
$stmt = $pdo->query('SELECT j.*, tp.tahun, tp.semester, k.kode_kelas, mp.kode_mapel, g.nip as nip_guru, r.kode_ruangan FROM jadwal_pelajaran j JOIN tahun_pelajaran tp ON tp.id = j.tahun_pelajaran_id JOIN kelas k ON k.id = j.kelas_id JOIN mata_pelajaran mp ON mp.id = j.mapel_id JOIN guru g ON g.id = j.guru_id LEFT JOIN ruangan r ON r.id = j.ruangan_id');
$rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
echo "Successfully fetched " . count($rows) . " joined rows.\n";
