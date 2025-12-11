#!/usr/bin/env php
<?php

declare(strict_types=1);

/**
 * Appends helper functions to Pest.php, properly handling PHP syntax
 */
$pestFile = 'tests/Pest.php';

if (! file_exists($pestFile)) {
    echo "Error: {$pestFile} does not exist\n";
    exit(1);
}

// Check if helpers are already appended to avoid duplicate declarations
$existingContent = file_get_contents($pestFile);
if (mb_strpos($existingContent, 'function skipIfRouteMissing') !== false) {
    echo "Helpers already appended to {$pestFile}, skipping\n";
    exit(0);
}

// Read helper files and extract content (skip opening PHP tag)
$skipHelper = file_get_contents('scripts/browser-tests-skip-helper.php');
$cspHelper = file_get_contents('scripts/browser-tests-helper.php');

// Remove opening PHP tag and declare statement from skip helper
$skipLines = explode("\n", $skipHelper);
$skipStartIndex = 0;
foreach ($skipLines as $i => $line) {
    $trimmed = mb_trim($line);
    if ($trimmed === '<?php' || str_starts_with($trimmed, 'declare(strict_types') || $trimmed === '') {
        $skipStartIndex = $i + 1;
    } else {
        break;
    }
}
$skipHelper = implode("\n", array_slice($skipLines, $skipStartIndex));

// Remove opening PHP tag and declare statement from CSP helper
$cspLines = explode("\n", $cspHelper);
$cspStartIndex = 0;
foreach ($cspLines as $i => $line) {
    $trimmed = mb_trim($line);
    if ($trimmed === '<?php' || str_starts_with($trimmed, 'declare(strict_types') || $trimmed === '') {
        $cspStartIndex = $i + 1;
    } else {
        break;
    }
}
$cspHelper = implode("\n", array_slice($cspLines, $cspStartIndex));

// Append helpers to Pest.php
file_put_contents($pestFile, "\n\n".$skipHelper."\n\n".$cspHelper, FILE_APPEND);

echo "Helpers appended to {$pestFile}\n";
