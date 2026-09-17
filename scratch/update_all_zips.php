<?php
$files = [
    'application/controllers/Master.php',
    'application/views/master/jadwal.php',
    'application/controllers/Penilaian.php',
    'application/views/penilaian/index.php',
    'application/services/NilaiService.php',
    'update_jadwal_pelajaran.sql',
    'database.sql'
];

$zipFilename1 = 'update_full_project_changes.zip';
$zip1 = new ZipArchive();
if ($zip1->open($zipFilename1, ZipArchive::CREATE | ZipArchive::OVERWRITE) === TRUE) {
    foreach ($files as $f) {
        $zip1->addFile($f, $f);
    }
    $zip1->close();
    echo "Updated $zipFilename1 successfully.\n";
}

$zipFilename2 = 'update_master_jadwal.zip';
$zip2 = new ZipArchive();
if ($zip2->open($zipFilename2, ZipArchive::CREATE | ZipArchive::OVERWRITE) === TRUE) {
    foreach ($files as $f) {
        $zip2->addFile($f, $f);
    }
    $zip2->close();
    echo "Updated $zipFilename2 successfully.\n";
}
