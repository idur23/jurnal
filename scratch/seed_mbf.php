<?php
$mysqli = new mysqli('localhost', 'root', '', 'jg_enterprise');
if ($mysqli->connect_error) {
    die("Connection failed: " . $mysqli->connect_error);
}

// 1. Check or insert Tentor role
$res = $mysqli->query("SELECT id FROM roles WHERE role_code = 'tentor'");
if ($res->num_rows == 0) {
    $mysqli->query("INSERT INTO roles (role_code, role_name, description) VALUES ('tentor', 'Tentor MBF', 'Akses khusus kegiatan MBF')");
    $role_id = $mysqli->insert_id;
} else {
    $row = $res->fetch_assoc();
    $role_id = $row['id'];
}

// 2. Check or insert User 'tentor1'
$res_user = $mysqli->query("SELECT id FROM users WHERE username = 'tentor1'");
if ($res_user->num_rows == 0) {
    $pass_hash = password_hash('Admin@12345', PASSWORD_BCRYPT);
    $mysqli->query("INSERT INTO users (username, email, password, full_name, role_id, is_active) VALUES ('tentor1', 'tentor1@mbf.sch.id', '$pass_hash', 'Ahmad, S.Pd.I', $role_id, 1)");
    $user_id = $mysqli->insert_id;
} else {
    $row = $res_user->fetch_assoc();
    $user_id = $row['id'];
}

// 3. Check or insert Tentor record 'Ahmad, S.Pd.I'
$res_tentor = $mysqli->query("SELECT id FROM tentor WHERE user_id = $user_id");
if ($res_tentor->num_rows == 0) {
    $mysqli->query("INSERT INTO tentor (user_id, nip, nama_lengkap, no_hp, email, is_active) VALUES ($user_id, '199001012020011001', 'Ahmad, S.Pd.I', '081234567899', 'tentor1@mbf.sch.id', 1)");
    $tentor_id = $mysqli->insert_id;
} else {
    $row = $res_tentor->fetch_assoc();
    $tentor_id = $row['id'];
}

// 4. Get active tahun_pelajaran
$res_tp = $mysqli->query("SELECT id FROM tahun_pelajaran WHERE is_active = 1 LIMIT 1");
$tp_id = ($res_tp->num_rows > 0) ? $res_tp->fetch_assoc()['id'] : 1;

// 5. Insert Sample Mapel MBF: Tahfidz & Bahasa Arab
$res_m1 = $mysqli->query("SELECT id FROM mapel_mbf WHERE kode_mapel = 'MBF-THF'");
if ($res_m1->num_rows == 0) {
    $mysqli->query("INSERT INTO mapel_mbf (kode_mapel, nama_mapel, tentor_id, tahun_pelajaran_id, semester, status) VALUES ('MBF-THF', 'Tahfidz Al-Qur\'an', $tentor_id, $tp_id, 'Ganjil', 1)");
    $mapel_id1 = $mysqli->insert_id;

    // Enroll students (id 1, 2, 3) to Tahfidz
    $mysqli->query("INSERT IGNORE INTO peserta_mapel_mbf (mapel_mbf_id, siswa_id) VALUES ($mapel_id1, 1), ($mapel_id1, 2), ($mapel_id1, 3)");
}

$res_m2 = $mysqli->query("SELECT id FROM mapel_mbf WHERE kode_mapel = 'MBF-ARB'");
if ($res_m2->num_rows == 0) {
    $mysqli->query("INSERT INTO mapel_mbf (kode_mapel, nama_mapel, tentor_id, tahun_pelajaran_id, semester, status) VALUES ('MBF-ARB', 'Bahasa Arab Interaktif', $tentor_id, $tp_id, 'Ganjil', 1)");
    $mapel_id2 = $mysqli->insert_id;

    // Enroll students (id 1, 3, 4) to Bahasa Arab
    $mysqli->query("INSERT IGNORE INTO peserta_mapel_mbf (mapel_mbf_id, siswa_id) VALUES ($mapel_id2, 1), ($mapel_id2, 3), ($mapel_id2, 4)");
}

echo "MBF Sample data seeded successfully!\n";
