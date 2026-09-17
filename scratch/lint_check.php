<?php
function getDirContents($dir, &$results = array()) {
    $files = scandir($dir);
    foreach ($files as $key => $value) {
        $path = realpath($dir . DIRECTORY_SEPARATOR . $value);
        if (!is_dir($path)) {
            if (pathinfo($path, PATHINFO_EXTENSION) === 'php') {
                $results[] = $path;
            }
        } else if ($value != "." && $value != "..") {
            getDirContents($path, $results);
        }
    }
    return $results;
}

$dirs = [
    __DIR__ . '/../application/controllers',
    __DIR__ . '/../application/models',
    __DIR__ . '/../application/libraries',
    __DIR__ . '/../application/helpers',
    __DIR__ . '/../application/services',
    __DIR__ . '/../application/core'
];

$all_files = [];
foreach ($dirs as $dir) {
    if (is_dir($dir)) {
        getDirContents($dir, $all_files);
    }
}

echo "Total PHP files found: " . count($all_files) . "\n";
$errors = 0;
foreach ($all_files as $file) {
    $output = [];
    $retval = 0;
    exec("c:\\laragon\\bin\\php\\php-8.3.30-Win32-vs16-x64\\php.exe -l " . escapeshellarg($file), $output, $retval);
    if ($retval !== 0) {
        echo "Syntax Error in file: $file\n";
        echo implode("\n", $output) . "\n\n";
        $errors++;
    }
}

if ($errors === 0) {
    echo "All files passed PHP lint check (syntax is valid).\n";
} else {
    echo "Total files with syntax errors: $errors\n";
}
