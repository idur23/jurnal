<?php
$pw1 = '$2y$10$p5B4W4pJTSUKRtd2q4R74Ords6eRzbjvRLt.mRkqy5yIX8BHF.8K2';
$pw2 = '$2y$10$4.z4zC.bYQ.u5l9GZ1oTje/zZ3W7dGgN34Uu1xYpWbQ8vR1v8E0qO';

$passwords = [
    'admin', 'admin123', '123456', 'password', 'jurnalguru', 'jurnalguru123',
    'guru1', 'guru', 'wali', 'wali1', 'superadmin', 'kamad', 'kamad123',
    'jurnalguru2026.', 'jg_enterprise', 'budi', 'siti', 'fauzi', 'bSantoso',
    'masr2113_jurnalguru', 'masr2113_jurnal', 'jurnalguru2026'
];

foreach ($passwords as $p) {
    if (password_verify($p, $pw1)) {
        echo "pw1 MATCH: " . $p . "\n";
    }
    if (password_verify($p, $pw2)) {
        echo "pw2 MATCH: " . $p . "\n";
    }
}
?>
