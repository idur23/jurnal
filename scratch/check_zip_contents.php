<?php
$zip = new ZipArchive();
if ($zip->open('update_master_jadwal.zip') === TRUE) {
    echo "=== UPDATE_MASTER_JADWAL.ZIP CONTENTS ===\n";
    for ($i = 0; $i < $zip->numFiles; $i++) {
        echo "- " . $zip->getNameIndex($i) . "\n";
    }
    $zip->close();
}
