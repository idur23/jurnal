<?php
$mysqli = new mysqli('localhost', 'root', '', 'jg_enterprise');
if ($mysqli->connect_error) {
    die("Connection failed: " . $mysqli->connect_error);
}

// Check if guru_id column already exists
$res = $mysqli->query("SHOW COLUMNS FROM tentor LIKE 'guru_id'");
if ($res->num_rows == 0) {
    $mysqli->query("ALTER TABLE tentor ADD COLUMN guru_id INT UNSIGNED NULL AFTER user_id");
    $mysqli->query("ALTER TABLE tentor ADD CONSTRAINT fk_tentor_guru FOREIGN KEY (guru_id) REFERENCES guru (id) ON DELETE SET NULL ON UPDATE CASCADE");
    echo "Column guru_id added to tentor table successfully!\n";
} else {
    echo "Column guru_id already exists in tentor table.\n";
}
