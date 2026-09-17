<?php
$mysqli = new mysqli('localhost', 'root', '', 'jg_enterprise');
if ($mysqli->connect_error) {
    die("Connection failed: " . $mysqli->connect_error);
}

$sql = file_get_contents(__DIR__ . '/../database/migration_cr008.sql');
if ($mysqli->multi_query($sql)) {
    do {
        if ($result = $mysqli->store_result()) {
            $result->free();
        }
    } while ($mysqli->more_results() && $mysqli->next_result());
}

if ($mysqli->error) {
    echo "Migration error: " . $mysqli->error . "\n";
} else {
    echo "Migration CR008 executed successfully!\n";
}
