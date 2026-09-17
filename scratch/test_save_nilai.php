<?php
$pdo = new PDO('mysql:host=localhost;dbname=jg_enterprise;charset=utf8mb4', 'root', '');

// Simulate finding teacher for kelas_id = 2 and mapel_id = 31
$stmt = $pdo->prepare("SELECT guru_id FROM jadwal_pelajaran WHERE kelas_id = 2 AND mapel_id = 31 LIMIT 1");
$stmt->execute();
$jd = $stmt->fetch(PDO::FETCH_ASSOC);

echo "Guru ID from jadwal_pelajaran for kelas 2, mapel 31: " . json_encode($jd) . "\n";

// Check if this guru_id exists in guru table
if ($jd) {
    $stmtG = $pdo->prepare("SELECT id, nama_lengkap FROM guru WHERE id = ?");
    $stmtG->execute([$jd['guru_id']]);
    $g = $stmtG->fetch(PDO::FETCH_ASSOC);
    echo "Teacher details: " . json_encode($g) . "\n";
}
