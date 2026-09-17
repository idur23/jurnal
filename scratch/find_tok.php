<?php
$dir = new RecursiveDirectoryIterator('c:/laragon/www/jg');
$iterator = new RecursiveIteratorIterator($dir);
$regex = new RegexIterator($iterator, '/\.(php|html|js|sql|txt)$/i', RecursiveRegexIterator::GET_MATCH);

foreach ($regex as $file => $value) {
    if (strpos($file, 'vendor') !== false || strpos($file, 'scratch') !== false) {
        continue;
    }
    $content = file_get_contents($file);
    if (stripos($content, '2 TOK') !== false) {
        echo "Found in file: $file\n";
        // print lines containing "2 TOK"
        $lines = explode("\n", $content);
        foreach ($lines as $i => $line) {
            if (stripos($line, '2 TOK') !== false) {
                echo "  Line " . ($i + 1) . ": " . trim($line) . "\n";
            }
        }
    }
}
echo "Search completed.\n";
