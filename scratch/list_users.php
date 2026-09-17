<?php
$db = new mysqli('localhost', 'root', '', 'jg_enterprise');
if ($db->connect_error) {
    die("Connection failed: " . $db->connect_error);
}
$res = $db->query('SELECT username, email, role_id FROM users');
while($row = $res->fetch_assoc()) {
    echo $row['username'] . ' (' . $row['email'] . ') - Role: ' . $row['role_id'] . "\n";
}
