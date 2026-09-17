<?php
$dir = new RecursiveDirectoryIterator(__DIR__ . '/../application');
$iterator = new RecursiveIteratorIterator($dir);
$recent = [];
foreach ($iterator as $file) {
    if ($file->isFile() && $file->getExtension() === 'php') {
        $mtime = $file->getMTime();
        if (time() - $mtime < 24 * 3600) {
            $recent[] = [
                'path' => $file->getPathname(),
                'mtime' => $mtime,
                'date' => date('Y-m-d H:i:s', $mtime)
            ];
        }
    }
}
usort($recent, function($a, $b) {
    return $b['mtime'] <=> $a['mtime'];
});
foreach ($recent as $r) {
    echo $r['path'] . ' - ' . $r['date'] . "\n";
}
