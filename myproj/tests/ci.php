<?php
// Simple CI helper for Jenkins: lints all php files under this project and writes results to tests/ci-output.txt
$root = dirname(__DIR__);
$it = new RecursiveIteratorIterator(new RecursiveDirectoryIterator($root));
$output = [];
$errors = 0;
foreach ($it as $file) {
    if ($file->isFile()) {
        $path = $file->getPathname();
        if (in_array(pathinfo($path, PATHINFO_EXTENSION), ['php'])) {
            // skip vendor or .git folders if any
            if (strpos($path, DIRECTORY_SEPARATOR . 'vendor' . DIRECTORY_SEPARATOR) !== false) continue;
            // run php -l
            $cmd = "php -l " . escapeshellarg($path) . " 2>&1";
            $result = null;
            $ret = null;
            exec($cmd, $result, $ret);
            $line = implode("\n", $result);
            $output[] = "$path: $line";
            if ($ret !== 0) $errors++;
        }
    }
}
$summary = "PHP lint errors: $errors\n";
file_put_contents(__DIR__ . '/ci-output.txt', $summary . implode("\n", $output));
if ($errors > 0) {
    echo $summary;
    exit(1);
}
echo $summary;
exit(0);
?>