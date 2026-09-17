<?php
$zipFilename = 'update_master_jadwal.zip';

$zip = new ZipArchive();
if ($zip->open($zipFilename, ZipArchive::CREATE | ZipArchive::OVERWRITE) === TRUE) {
    $zip->addFile('application/controllers/Master.php', 'application/controllers/Master.php');
    $zip->addFile('application/views/master/jadwal.php', 'application/views/master/jadwal.php');
    $zip->addFile('update_jadwal_pelajaran.sql', 'update_jadwal_pelajaran.sql');
    $zip->addFile('database.sql', 'database.sql');
    $zip->close();
    echo "Created $zipFilename successfully. Size: " . filesize($zipFilename) . " bytes.\n";
} else {
    echo "Failed to create zip file.\n";
}
