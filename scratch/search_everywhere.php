<?php
$dir = new RecursiveDirectoryIterator('c:/laragon/www/jg');
$iterator = new RecursiveIteratorIterator($dir);

foreach ($iterator as $file) {
    if ($file->isDir()) continue;
    $filePath = $file->getPathname();
    if (strpos($filePath, 'vendor') !== false || strpos($filePath, 'scratch') !== false || strpos($filePath, '.git') !== false) {
        continue;
    }
    
    $content = @file_get_contents($filePath);
    if ($content === false) continue;
    
    if (stripos($content, 'TOK') !== false) {
        echo "Found in file: $filePath\n";
        $lines = explode("\n", $content);
        foreach ($lines as $i => $line) {
            if (stripos($line, 'TOK') !== false) {
                echo "  Line " . ($i + 1) . ": " . trim($line) . "\n";
            }
        }
    }
}
echo "Full search completed.\n";
