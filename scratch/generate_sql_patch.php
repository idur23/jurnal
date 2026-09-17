<?php
$pdo = new PDO('mysql:host=localhost;dbname=jg_enterprise;charset=utf8mb4', 'root', '');

$sql = "-- UPDATE JADWAL PELAJARAN & MASTER DATA KWU\n";
$sql .= "SET FOREIGN_KEY_CHECKS=0;\n\n";

// KWU Mapel insert if not exists
$sql .= "-- Insert Mapel KWU if not exists\n";
$sql .= "INSERT IGNORE INTO `mata_pelajaran` (`id`, `kode_mapel`, `nama_mapel`, `kelompok`, `kkm`, `guru_id`, `kelas_id`, `semester`, `tahun_pelajaran_id`, `status`) VALUES (32, 'KWU', 'KEWIRAUSAHAAN', 'Wajib', 70.00, 29, 1, 'Ganjil', 3, 'Aktif');\n";
$sql .= "INSERT IGNORE INTO `guru_mapel` (`guru_id`, `mapel_id`) VALUES (29, 32);\n\n";

$sql .= "-- Delete old schedule for tahun_pelajaran_id = 3\n";
$sql .= "DELETE FROM `jadwal_pelajaran` WHERE `tahun_pelajaran_id` = 3;\n\n";

$sql .= "-- Insert 120 Jadwal Pelajaran Records\n";
$rows = $pdo->query("SELECT * FROM `jadwal_pelajaran` WHERE `tahun_pelajaran_id` = 3")->fetchAll(PDO::FETCH_ASSOC);
foreach ($rows as $r) {
    $cols = array_map(function($c) { return "`$c`"; }, array_keys($r));
    $vals = array_map(function($v) use ($pdo) {
        if ($v === NULL) return 'NULL';
        return $pdo->quote($v);
    }, array_values($r));
    $sql .= "INSERT INTO `jadwal_pelajaran` (" . implode(', ', $cols) . ") VALUES (" . implode(', ', $vals) . ");\n";
}

$sql .= "\nSET FOREIGN_KEY_CHECKS=1;\n";

file_put_contents('update_jadwal_pelajaran.sql', $sql);
echo "Generated update_jadwal_pelajaran.sql with " . count($rows) . " records.\n";
