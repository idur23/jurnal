<?php
$pdo = new PDO('mysql:host=localhost;dbname=jg_enterprise;charset=utf8mb4', 'root', '');

echo "=== TOTAL REKAP JADWAL PER KELAS ===\n";
$sql = "SELECT k.nama_kelas, SUM(j.jam_selesai_ke - j.jam_mulai_ke + 1) as total_jp, COUNT(*) as total_sesi
        FROM jadwal_pelajaran j
        JOIN kelas k ON k.id = j.kelas_id
        GROUP BY k.id, k.nama_kelas
        ORDER BY k.id";
foreach ($pdo->query($sql)->fetchAll(PDO::FETCH_ASSOC) as $r) {
    echo "Kelas {$r['nama_kelas']}: {$r['total_jp']} JP ({$r['total_sesi']} sesi)\n";
}

echo "\n=== TOTAL REKAP JADWAL PER GURU ===\n";
$sqlGuru = "SELECT g.nip, g.nama_lengkap, mp.kode_mapel, SUM(j.jam_selesai_ke - j.jam_mulai_ke + 1) as total_jp
            FROM jadwal_pelajaran j
            JOIN guru g ON g.id = j.guru_id
            JOIN mata_pelajaran mp ON mp.id = j.mapel_id
            GROUP BY g.id, mp.id
            ORDER BY g.nip, mp.kode_mapel";
foreach ($pdo->query($sqlGuru)->fetchAll(PDO::FETCH_ASSOC) as $r) {
    echo "NIP {$r['nip']} | {$r['nama_lengkap']} | Mapel: {$r['kode_mapel']} => {$r['total_jp']} JP\n";
}

echo "\n=== TOTAL JP ALL GURU ===\n";
$sqlAll = "SELECT SUM(jam_selesai_ke - jam_mulai_ke + 1) as total_all FROM jadwal_pelajaran";
$tot = $pdo->query($sqlAll)->fetch(PDO::FETCH_ASSOC);
echo "Total JP Keseluruhan: {$tot['total_all']} JP\n";
