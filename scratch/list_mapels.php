<?php
$pdo = new PDO('mysql:host=localhost;dbname=jg_enterprise;charset=utf8mb4', 'root', '');
$mapels = $pdo->query('SELECT * FROM mata_pelajaran')->fetchAll(PDO::FETCH_ASSOC);
echo json_encode($mapels, JSON_PRETTY_PRINT);
