<?php
$pdo = new PDO('mysql:host=localhost;dbname=jg_enterprise;charset=utf8mb4', 'root', '', [
    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
]);

// 1. Ensure KWU exists in mata_pelajaran
$stmt = $pdo->prepare("SELECT id FROM mata_pelajaran WHERE kode_mapel = 'KWU'");
$stmt->execute();
$kwu = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$kwu) {
    $stmtIns = $pdo->prepare("INSERT INTO mata_pelajaran (kode_mapel, nama_mapel, kelompok, kkm, guru_id, kelas_id, semester, tahun_pelajaran_id, status) VALUES ('KWU', 'KEWIRAUSAHAAN', 'Wajib', 70.00, 29, 1, 'Ganjil', 3, 'Aktif')");
    $stmtIns->execute();
    $kwu_id = $pdo->lastInsertId();
    echo "Inserted KWU mapel with ID: $kwu_id\n";
} else {
    $kwu_id = $kwu['id'];
    echo "KWU mapel existing ID: $kwu_id\n";
}

// 2. Ensure KWU in guru_mapel for Lazatin 'Aniqoh (id: 29)
$stmt = $pdo->prepare("SELECT id FROM guru_mapel WHERE guru_id = 29 AND mapel_id = ?");
$stmt->execute([$kwu_id]);
if (!$stmt->fetch()) {
    $pdo->prepare("INSERT INTO guru_mapel (guru_id, mapel_id) VALUES (29, ?)")->execute([$kwu_id]);
    echo "Inserted KWU into guru_mapel for Lazatin 'Aniqoh\n";
}

// Year ID
$tp_id = 3; // 2026/2027 Ganjil

// Classes mapping (kode_kelas => [kelas_id, ruangan_id])
$kelas_map = [
    'X-A'   => ['kelas_id' => 1, 'ruangan_id' => 3],
    'X-B'   => ['kelas_id' => 2, 'ruangan_id' => 6],
    'XI-A'  => ['kelas_id' => 5, 'ruangan_id' => 4],
    'XI-B'  => ['kelas_id' => 6, 'ruangan_id' => 7],
    'XII-A' => ['kelas_id' => 7, 'ruangan_id' => 5],
    'XII-B' => ['kelas_id' => 8, 'ruangan_id' => 8],
];

// Mapel mapping (kode_mapel => mapel_id)
$mapel_stmt = $pdo->query("SELECT id, kode_mapel FROM mata_pelajaran");
$mapel_map = [];
foreach ($mapel_stmt->fetchAll(PDO::FETCH_ASSOC) as $m) {
    $mapel_map[$m['kode_mapel']] = $m['id'];
}
// Alias MAT TL to MAT TP (id: 20)
$mapel_map['MAT TL'] = $mapel_map['MAT TP'];
$mapel_map['KOD.AI'] = $mapel_map['KOD AI'];

// Guru mapping by NIP/Code according to PDF document:
// A1  => 27 (Fakhrur Rozi)
// A2  => 34 (Dr. Nur Indah Agustina)
// A3  => 24 (Amin Adimas Putra)
// A4  => 31 (Muhammad Ahsan Thoriq)
// A5  => 30 (M. Alifudin Ikhsan)
// A6  => 35 (Pratiwi Nur Zamzani)
// A7  => 32 (Nilnalminach Ziyadatul 'Ishmah)
// A8  => 23 (Abi Lazkar Amar Ma'rufi)
// A9  => 29 (Lazatin 'Aniqoh)
// A10 => 25 (Arsy Bintang Ramadhani)
// A11 => 36 (Rudy Cahya Kumala)
// A13 => 38 (Thalita Syahda Raniah)
// A14 => 26 (Elmiatun Nafi'ah)
// A15 => 33 (Nur Arifah Dzul Qo'dah)
// A16 => 37 (Siti Aminatuz Zuhroh)
// A17 => 22 (Abdul Majdid Wafa)

$mapel_guru = [
    'ARB 1'    => 27,
    'KIM'      => 34,
    'EKO'      => 24,
    'SR 1'     => 24,
    'ARB 2'    => 31,
    'SR 2'     => 31,
    'PP 1'     => 30,
    'BIN 1'    => 35,
    'SR 3'     => 35,
    'PP 2'     => 35,
    'BIO'      => 32,
    'AP 1'     => 23,
    'PAI TP 1' => 23,
    'MAT WJB'  => 29,
    'MAT TP'   => 29,
    'MAT TL'   => 29,
    'KWU'      => 29,
    'FIS'      => 25,
    'INFOR'    => 36,
    'KOD AI'   => 36,
    'KOD.AI'   => 36,
    'BIN 2'    => 38,
    'BING'     => 26,
    'AP 2'     => 33,
    'PAI TP 2' => 33,
    'IPS TP'   => 37,
    'SI'       => 37,
    'PP 3'     => 37,
    'PJOK'     => 22,
];

$schedules = [
    // === X-A ===
    ['kelas' => 'X-A', 'hari' => 'Senin', 'jam_mulai' => 1, 'jam_selesai' => 2, 'mapel' => 'KIM'],
    ['kelas' => 'X-A', 'hari' => 'Senin', 'jam_mulai' => 3, 'jam_selesai' => 5, 'mapel' => 'IPS TP'],
    ['kelas' => 'X-A', 'hari' => 'Senin', 'jam_mulai' => 6, 'jam_selesai' => 7, 'mapel' => 'INFOR'],
    ['kelas' => 'X-A', 'hari' => 'Senin', 'jam_mulai' => 8, 'jam_selesai' => 9, 'mapel' => 'BIO'],

    ['kelas' => 'X-A', 'hari' => 'Selasa', 'jam_mulai' => 1, 'jam_selesai' => 2, 'mapel' => 'PAI TP 2'],
    ['kelas' => 'X-A', 'hari' => 'Selasa', 'jam_mulai' => 3, 'jam_selesai' => 4, 'mapel' => 'PP 3'],
    ['kelas' => 'X-A', 'hari' => 'Selasa', 'jam_mulai' => 5, 'jam_selesai' => 7, 'mapel' => 'BIN 1'],
    ['kelas' => 'X-A', 'hari' => 'Selasa', 'jam_mulai' => 8, 'jam_selesai' => 9, 'mapel' => 'ARB 2'],

    ['kelas' => 'X-A', 'hari' => 'Rabu', 'jam_mulai' => 1, 'jam_selesai' => 2, 'mapel' => 'FIS'],
    ['kelas' => 'X-A', 'hari' => 'Rabu', 'jam_mulai' => 3, 'jam_selesai' => 4, 'mapel' => 'ARB 2'],
    ['kelas' => 'X-A', 'hari' => 'Rabu', 'jam_mulai' => 5, 'jam_selesai' => 7, 'mapel' => 'PAI TP 2'],
    ['kelas' => 'X-A', 'hari' => 'Rabu', 'jam_mulai' => 8, 'jam_selesai' => 9, 'mapel' => 'KWU'],

    ['kelas' => 'X-A', 'hari' => 'Kamis', 'jam_mulai' => 1, 'jam_selesai' => 2, 'mapel' => 'EKO'],
    ['kelas' => 'X-A', 'hari' => 'Kamis', 'jam_mulai' => 3, 'jam_selesai' => 4, 'mapel' => 'IPS TP'],
    ['kelas' => 'X-A', 'hari' => 'Kamis', 'jam_mulai' => 5, 'jam_selesai' => 7, 'mapel' => 'MAT WJB'],
    ['kelas' => 'X-A', 'hari' => 'Kamis', 'jam_mulai' => 8, 'jam_selesai' => 9, 'mapel' => 'SR 1'],

    ['kelas' => 'X-A', 'hari' => 'Jumat', 'jam_mulai' => 1, 'jam_selesai' => 3, 'mapel' => 'PJOK'],
    ['kelas' => 'X-A', 'hari' => 'Jumat', 'jam_mulai' => 4, 'jam_selesai' => 6, 'mapel' => 'BING'],
    ['kelas' => 'X-A', 'hari' => 'Jumat', 'jam_mulai' => 7, 'jam_selesai' => 8, 'mapel' => 'AP 1'],

    // === X-B ===
    ['kelas' => 'X-B', 'hari' => 'Senin', 'jam_mulai' => 1, 'jam_selesai' => 2, 'mapel' => 'PAI TP 2'],
    ['kelas' => 'X-B', 'hari' => 'Senin', 'jam_mulai' => 3, 'jam_selesai' => 4, 'mapel' => 'BIO'],
    ['kelas' => 'X-B', 'hari' => 'Senin', 'jam_mulai' => 5, 'jam_selesai' => 6, 'mapel' => 'KIM'],
    ['kelas' => 'X-B', 'hari' => 'Senin', 'jam_mulai' => 7, 'jam_selesai' => 9, 'mapel' => 'IPS TP'],

    ['kelas' => 'X-B', 'hari' => 'Selasa', 'jam_mulai' => 1, 'jam_selesai' => 2, 'mapel' => 'FIS'],
    ['kelas' => 'X-B', 'hari' => 'Selasa', 'jam_mulai' => 3, 'jam_selesai' => 4, 'mapel' => 'EKO'],
    ['kelas' => 'X-B', 'hari' => 'Selasa', 'jam_mulai' => 5, 'jam_selesai' => 6, 'mapel' => 'ARB 2'],
    ['kelas' => 'X-B', 'hari' => 'Selasa', 'jam_mulai' => 7, 'jam_selesai' => 9, 'mapel' => 'MAT WJB'],

    ['kelas' => 'X-B', 'hari' => 'Rabu', 'jam_mulai' => 1, 'jam_selesai' => 2, 'mapel' => 'INFOR'],
    ['kelas' => 'X-B', 'hari' => 'Rabu', 'jam_mulai' => 3, 'jam_selesai' => 4, 'mapel' => 'AP 1'],
    ['kelas' => 'X-B', 'hari' => 'Rabu', 'jam_mulai' => 5, 'jam_selesai' => 7, 'mapel' => 'BIN 1'],
    ['kelas' => 'X-B', 'hari' => 'Rabu', 'jam_mulai' => 8, 'jam_selesai' => 9, 'mapel' => 'ARB 2'],

    ['kelas' => 'X-B', 'hari' => 'Kamis', 'jam_mulai' => 1, 'jam_selesai' => 2, 'mapel' => 'PP 3'],
    ['kelas' => 'X-B', 'hari' => 'Kamis', 'jam_mulai' => 3, 'jam_selesai' => 5, 'mapel' => 'PAI TP 2'],
    ['kelas' => 'X-B', 'hari' => 'Kamis', 'jam_mulai' => 6, 'jam_selesai' => 7, 'mapel' => 'SR 1'],
    ['kelas' => 'X-B', 'hari' => 'Kamis', 'jam_mulai' => 8, 'jam_selesai' => 9, 'mapel' => 'IPS TP'],

    ['kelas' => 'X-B', 'hari' => 'Jumat', 'jam_mulai' => 1, 'jam_selesai' => 3, 'mapel' => 'BING'],
    ['kelas' => 'X-B', 'hari' => 'Jumat', 'jam_mulai' => 4, 'jam_selesai' => 6, 'mapel' => 'PJOK'],
    ['kelas' => 'X-B', 'hari' => 'Jumat', 'jam_mulai' => 7, 'jam_selesai' => 8, 'mapel' => 'KWU'],

    // === XI-A ===
    ['kelas' => 'XI-A', 'hari' => 'Senin', 'jam_mulai' => 1, 'jam_selesai' => 2, 'mapel' => 'MAT WJB'],
    ['kelas' => 'XI-A', 'hari' => 'Senin', 'jam_mulai' => 3, 'jam_selesai' => 4, 'mapel' => 'AP 2'],
    ['kelas' => 'XI-A', 'hari' => 'Senin', 'jam_mulai' => 5, 'jam_selesai' => 7, 'mapel' => 'BIN 1'],
    ['kelas' => 'XI-A', 'hari' => 'Senin', 'jam_mulai' => 8, 'jam_selesai' => 9, 'mapel' => 'FIS'],

    ['kelas' => 'XI-A', 'hari' => 'Selasa', 'jam_mulai' => 1, 'jam_selesai' => 3, 'mapel' => 'PJOK'],
    ['kelas' => 'XI-A', 'hari' => 'Selasa', 'jam_mulai' => 4, 'jam_selesai' => 5, 'mapel' => 'BIO'],
    ['kelas' => 'XI-A', 'hari' => 'Selasa', 'jam_mulai' => 6, 'jam_selesai' => 7, 'mapel' => 'EKO'],
    ['kelas' => 'XI-A', 'hari' => 'Selasa', 'jam_mulai' => 8, 'jam_selesai' => 9, 'mapel' => 'KIM'],

    ['kelas' => 'XI-A', 'hari' => 'Rabu', 'jam_mulai' => 1, 'jam_selesai' => 2, 'mapel' => 'KIM'],
    ['kelas' => 'XI-A', 'hari' => 'Rabu', 'jam_mulai' => 3, 'jam_selesai' => 4, 'mapel' => 'SI'],
    ['kelas' => 'XI-A', 'hari' => 'Rabu', 'jam_mulai' => 5, 'jam_selesai' => 7, 'mapel' => 'PAI TP 1'],
    ['kelas' => 'XI-A', 'hari' => 'Rabu', 'jam_mulai' => 8, 'jam_selesai' => 9, 'mapel' => 'SR 3'],

    ['kelas' => 'XI-A', 'hari' => 'Kamis', 'jam_mulai' => 1, 'jam_selesai' => 2, 'mapel' => 'ARB 2'],
    ['kelas' => 'XI-A', 'hari' => 'Kamis', 'jam_mulai' => 3, 'jam_selesai' => 4, 'mapel' => 'PP 2'],
    ['kelas' => 'XI-A', 'hari' => 'Kamis', 'jam_mulai' => 5, 'jam_selesai' => 7, 'mapel' => 'BING'],
    ['kelas' => 'XI-A', 'hari' => 'Kamis', 'jam_mulai' => 8, 'jam_selesai' => 9, 'mapel' => 'FIS'],

    ['kelas' => 'XI-A', 'hari' => 'Jumat', 'jam_mulai' => 1, 'jam_selesai' => 2, 'mapel' => 'PAI TP 1'],
    ['kelas' => 'XI-A', 'hari' => 'Jumat', 'jam_mulai' => 3, 'jam_selesai' => 4, 'mapel' => 'MAT TL'],
    ['kelas' => 'XI-A', 'hari' => 'Jumat', 'jam_mulai' => 5, 'jam_selesai' => 6, 'mapel' => 'BIO'],
    ['kelas' => 'XI-A', 'hari' => 'Jumat', 'jam_mulai' => 7, 'jam_selesai' => 8, 'mapel' => 'KOD.AI'],

    // === XI-B ===
    ['kelas' => 'XI-B', 'hari' => 'Senin', 'jam_mulai' => 1, 'jam_selesai' => 2, 'mapel' => 'FIS'],
    ['kelas' => 'XI-B', 'hari' => 'Senin', 'jam_mulai' => 3, 'jam_selesai' => 4, 'mapel' => 'KIM'],
    ['kelas' => 'XI-B', 'hari' => 'Senin', 'jam_mulai' => 5, 'jam_selesai' => 7, 'mapel' => 'BING'],
    ['kelas' => 'XI-B', 'hari' => 'Senin', 'jam_mulai' => 8, 'jam_selesai' => 9, 'mapel' => 'EKO'],

    ['kelas' => 'XI-B', 'hari' => 'Selasa', 'jam_mulai' => 1, 'jam_selesai' => 4, 'mapel' => 'PAI TP 1'],
    ['kelas' => 'XI-B', 'hari' => 'Selasa', 'jam_mulai' => 5, 'jam_selesai' => 6, 'mapel' => 'PJOK'],
    ['kelas' => 'XI-B', 'hari' => 'Selasa', 'jam_mulai' => 7, 'jam_selesai' => 7, 'mapel' => 'SI'],
    ['kelas' => 'XI-B', 'hari' => 'Selasa', 'jam_mulai' => 8, 'jam_selesai' => 9, 'mapel' => 'PP 2'],

    ['kelas' => 'XI-B', 'hari' => 'Rabu', 'jam_mulai' => 1, 'jam_selesai' => 2, 'mapel' => 'MAT WJB'],
    ['kelas' => 'XI-B', 'hari' => 'Rabu', 'jam_mulai' => 3, 'jam_selesai' => 4, 'mapel' => 'SR 3'],
    ['kelas' => 'XI-B', 'hari' => 'Rabu', 'jam_mulai' => 5, 'jam_selesai' => 5, 'mapel' => 'SI'],
    ['kelas' => 'XI-B', 'hari' => 'Rabu', 'jam_mulai' => 6, 'jam_selesai' => 7, 'mapel' => 'KIM'],
    ['kelas' => 'XI-B', 'hari' => 'Rabu', 'jam_mulai' => 8, 'jam_selesai' => 9, 'mapel' => 'FIS'],

    ['kelas' => 'XI-B', 'hari' => 'Kamis', 'jam_mulai' => 1, 'jam_selesai' => 2, 'mapel' => 'BIO'],
    ['kelas' => 'XI-B', 'hari' => 'Kamis', 'jam_mulai' => 3, 'jam_selesai' => 4, 'mapel' => 'ARB 2'],
    ['kelas' => 'XI-B', 'hari' => 'Kamis', 'jam_mulai' => 5, 'jam_selesai' => 7, 'mapel' => 'BIN 1'],
    ['kelas' => 'XI-B', 'hari' => 'Kamis', 'jam_mulai' => 8, 'jam_selesai' => 9, 'mapel' => 'PAI TP 1'],

    ['kelas' => 'XI-B', 'hari' => 'Jumat', 'jam_mulai' => 1, 'jam_selesai' => 2, 'mapel' => 'MAT TL'],
    ['kelas' => 'XI-B', 'hari' => 'Jumat', 'jam_mulai' => 3, 'jam_selesai' => 4, 'mapel' => 'BIO'],
    ['kelas' => 'XI-B', 'hari' => 'Jumat', 'jam_mulai' => 5, 'jam_selesai' => 6, 'mapel' => 'KOD.AI'],
    ['kelas' => 'XI-B', 'hari' => 'Jumat', 'jam_mulai' => 7, 'jam_selesai' => 8, 'mapel' => 'AP 2'],

    // === XII-A ===
    ['kelas' => 'XII-A', 'hari' => 'Senin', 'jam_mulai' => 1, 'jam_selesai' => 2, 'mapel' => 'PP 1'],
    ['kelas' => 'XII-A', 'hari' => 'Senin', 'jam_mulai' => 3, 'jam_selesai' => 4, 'mapel' => 'MAT WJB'],
    ['kelas' => 'XII-A', 'hari' => 'Senin', 'jam_mulai' => 5, 'jam_selesai' => 7, 'mapel' => 'BIN 2'],
    ['kelas' => 'XII-A', 'hari' => 'Senin', 'jam_mulai' => 8, 'jam_selesai' => 9, 'mapel' => 'PAI TP 2'],

    ['kelas' => 'XII-A', 'hari' => 'Selasa', 'jam_mulai' => 1, 'jam_selesai' => 2, 'mapel' => 'ARB 1'],
    ['kelas' => 'XII-A', 'hari' => 'Selasa', 'jam_mulai' => 3, 'jam_selesai' => 5, 'mapel' => 'BING'],
    ['kelas' => 'XII-A', 'hari' => 'Selasa', 'jam_mulai' => 6, 'jam_selesai' => 7, 'mapel' => 'FIS'],
    ['kelas' => 'XII-A', 'hari' => 'Selasa', 'jam_mulai' => 8, 'jam_selesai' => 9, 'mapel' => 'BIO'],

    ['kelas' => 'XII-A', 'hari' => 'Rabu', 'jam_mulai' => 1, 'jam_selesai' => 3, 'mapel' => 'PJOK'],
    ['kelas' => 'XII-A', 'hari' => 'Rabu', 'jam_mulai' => 4, 'jam_selesai' => 5, 'mapel' => 'KIM'],
    ['kelas' => 'XII-A', 'hari' => 'Rabu', 'jam_mulai' => 6, 'jam_selesai' => 7, 'mapel' => 'BIO'],
    ['kelas' => 'XII-A', 'hari' => 'Rabu', 'jam_mulai' => 8, 'jam_selesai' => 9, 'mapel' => 'SI'],

    ['kelas' => 'XII-A', 'hari' => 'Kamis', 'jam_mulai' => 1, 'jam_selesai' => 2, 'mapel' => 'KIM'],
    ['kelas' => 'XII-A', 'hari' => 'Kamis', 'jam_mulai' => 3, 'jam_selesai' => 4, 'mapel' => 'AP 1'],
    ['kelas' => 'XII-A', 'hari' => 'Kamis', 'jam_mulai' => 5, 'jam_selesai' => 6, 'mapel' => 'KOD.AI'],
    ['kelas' => 'XII-A', 'hari' => 'Kamis', 'jam_mulai' => 7, 'jam_selesai' => 9, 'mapel' => 'PAI TP 2'],

    ['kelas' => 'XII-A', 'hari' => 'Jumat', 'jam_mulai' => 1, 'jam_selesai' => 2, 'mapel' => 'EKO'],
    ['kelas' => 'XII-A', 'hari' => 'Jumat', 'jam_mulai' => 3, 'jam_selesai' => 4, 'mapel' => 'SR 2'],
    ['kelas' => 'XII-A', 'hari' => 'Jumat', 'jam_mulai' => 5, 'jam_selesai' => 6, 'mapel' => 'MAT TL'],
    ['kelas' => 'XII-A', 'hari' => 'Jumat', 'jam_mulai' => 7, 'jam_selesai' => 8, 'mapel' => 'FIS'],

    // === XII-B ===
    ['kelas' => 'XII-B', 'hari' => 'Senin', 'jam_mulai' => 1, 'jam_selesai' => 3, 'mapel' => 'BIN 2'],
    ['kelas' => 'XII-B', 'hari' => 'Senin', 'jam_mulai' => 4, 'jam_selesai' => 5, 'mapel' => 'FIS'],
    ['kelas' => 'XII-B', 'hari' => 'Senin', 'jam_mulai' => 6, 'jam_selesai' => 7, 'mapel' => 'PAI TP 2'],
    ['kelas' => 'XII-B', 'hari' => 'Senin', 'jam_mulai' => 8, 'jam_selesai' => 9, 'mapel' => 'MAT WJB'],

    ['kelas' => 'XII-B', 'hari' => 'Selasa', 'jam_mulai' => 1, 'jam_selesai' => 2, 'mapel' => 'PP 1'],
    ['kelas' => 'XII-B', 'hari' => 'Selasa', 'jam_mulai' => 3, 'jam_selesai' => 4, 'mapel' => 'ARB 2'],
    ['kelas' => 'XII-B', 'hari' => 'Selasa', 'jam_mulai' => 5, 'jam_selesai' => 6, 'mapel' => 'KIM'],
    ['kelas' => 'XII-B', 'hari' => 'Selasa', 'jam_mulai' => 7, 'jam_selesai' => 9, 'mapel' => 'BING'],

    ['kelas' => 'XII-B', 'hari' => 'Rabu', 'jam_mulai' => 1, 'jam_selesai' => 3, 'mapel' => 'PAI TP 2'],
    ['kelas' => 'XII-B', 'hari' => 'Rabu', 'jam_mulai' => 4, 'jam_selesai' => 6, 'mapel' => 'PJOK'],
    ['kelas' => 'XII-B', 'hari' => 'Rabu', 'jam_mulai' => 7, 'jam_selesai' => 7, 'mapel' => 'SI'],
    ['kelas' => 'XII-B', 'hari' => 'Rabu', 'jam_mulai' => 8, 'jam_selesai' => 9, 'mapel' => 'BIO'],

    ['kelas' => 'XII-B', 'hari' => 'Kamis', 'jam_mulai' => 1, 'jam_selesai' => 2, 'mapel' => 'MAT TL'],
    ['kelas' => 'XII-B', 'hari' => 'Kamis', 'jam_mulai' => 3, 'jam_selesai' => 4, 'mapel' => 'KIM'],
    ['kelas' => 'XII-B', 'hari' => 'Kamis', 'jam_mulai' => 5, 'jam_selesai' => 6, 'mapel' => 'AP 1'],
    ['kelas' => 'XII-B', 'hari' => 'Kamis', 'jam_mulai' => 7, 'jam_selesai' => 7, 'mapel' => 'SI'],
    ['kelas' => 'XII-B', 'hari' => 'Kamis', 'jam_mulai' => 8, 'jam_selesai' => 9, 'mapel' => 'KOD.AI'],

    ['kelas' => 'XII-B', 'hari' => 'Jumat', 'jam_mulai' => 1, 'jam_selesai' => 2, 'mapel' => 'FIS'],
    ['kelas' => 'XII-B', 'hari' => 'Jumat', 'jam_mulai' => 3, 'jam_selesai' => 4, 'mapel' => 'EKO'],
    ['kelas' => 'XII-B', 'hari' => 'Jumat', 'jam_mulai' => 5, 'jam_selesai' => 6, 'mapel' => 'SR 2'],
    ['kelas' => 'XII-B', 'hari' => 'Jumat', 'jam_mulai' => 7, 'jam_selesai' => 8, 'mapel' => 'BIO'],
];

// Start transaction
$pdo->beginTransaction();

// Clear existing schedules for active TP
$pdo->prepare("DELETE FROM jadwal_pelajaran WHERE tahun_pelajaran_id = ?")->execute([$tp_id]);

$stmtInsert = $pdo->prepare("INSERT INTO jadwal_pelajaran (tahun_pelajaran_id, kelas_id, mapel_id, guru_id, ruangan_id, hari, jam_mulai_ke, jam_selesai_ke) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");

$inserted = 0;
foreach ($schedules as $s) {
    $kode_kelas = $s['kelas'];
    $kelas_id   = $kelas_map[$kode_kelas]['kelas_id'];
    $ruangan_id = $kelas_map[$kode_kelas]['ruangan_id'];
    
    $kode_mapel = $s['mapel'];
    if (!isset($mapel_map[$kode_mapel])) {
        throw new Exception("Mapel not found: $kode_mapel");
    }
    $mapel_id = $mapel_map[$kode_mapel];

    if (!isset($mapel_guru[$kode_mapel])) {
        throw new Exception("Guru not mapped for: $kode_mapel");
    }
    $guru_id = $mapel_guru[$kode_mapel];

    $stmtInsert->execute([
        $tp_id,
        $kelas_id,
        $mapel_id,
        $guru_id,
        $ruangan_id,
        $s['hari'],
        $s['jam_mulai'],
        $s['jam_selesai']
    ]);
    $inserted++;
}

$pdo->commit();
echo "Successfully inserted $inserted schedule records into master data -> jadwal_pelajaran!\n";
