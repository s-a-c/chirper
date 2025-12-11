#!/usr/bin/env php
<?php

declare(strict_types=1);

/**
 * Injects skip checks into browser test files to prevent failures
 * when routes or methods aren't available in the project.
 *
 * This script finds all route references in test files and adds
 * skip checks at the appropriate locations.
 */
$testDir = $argv[1] ?? 'tests/Browser';

if (! is_dir($testDir)) {
    echo "Error: Directory {$testDir} does not exist\n";
    exit(1);
}

$files = new RecursiveIteratorIterator(
    new RecursiveDirectoryIterator($testDir),
    RecursiveIteratorIterator::LEAVES_ONLY,
);

foreach ($files as $file) {
    if ($file->getExtension() !== 'php') {
        continue;
    }

    $filename = $file->getFilename();
    $pathname = $file->getPathname();

    // Skip Pest.php, TestCase.php, and any file not in Browser subdirectory
    if (
        $filename === 'Pest.php'
        || $filename === 'TestCase.php'
        || mb_strpos($pathname, '/tests/Pest.php') !== false
        || mb_strpos($pathname, '/tests/TestCase.php') !== false
        || mb_strpos($pathname, '/Browser/') === false
    ) {
        continue;
    }

    $content = file_get_contents($file->getPathname());
    $originalContent = $content;

    // Find all test() blocks and inject skip checks for routes/methods used
    $content = preg_replace_callback(
        "/test\(['\"]([^'\"]+)['\"],\s*function\s*\([^)]*\)\s*\{/s",
        function ($matches) use ($content) {
            $testStart = $matches[0];
            $testName = $matches[1];

            // Find the full test body to analyze what routes/methods it uses
            $pos = mb_strpos($content, $testStart);
            if ($pos === false) {
                return $testStart;
            }

            // Extract the test body (rough approximation - find matching brace)
            $testBody = extractTestBody($content, $pos + mb_strlen($testStart));

            // Collect all routes used in this test
            $routes = [];
            $methods = [];

            // Match route('name') patterns
            if (preg_match_all("/route\(['\"]([^'\"]+)['\"]/", $testBody, $routeMatches)) {
                $routes = array_merge($routes, $routeMatches[1]);
            }

            // Match URL::temporarySignedRoute('name', ...) patterns
            if (preg_match_all("/URL::temporarySignedRoute\(['\"]([^'\"]+)['\"]/", $testBody, $signedMatches)) {
                $routes = array_merge($routes, $signedMatches[1]);
            }

            // Match URL::signedRoute('name', ...) patterns
            if (preg_match_all("/URL::signedRoute\(['\"]([^'\"]+)['\"]/", $testBody, $signedMatches)) {
                $routes = array_merge($routes, $signedMatches[1]);
            }

            // Check for factory methods
            if (preg_match("/User::factory\(\)->withoutTwoFactor\(\)/", $testBody)) {
                $methods[] = ['Database\\Factories\\UserFactory', 'withoutTwoFactor'];
            }
            if (preg_match("/User::factory\(\)->unverified\(\)/", $testBody)) {
                $methods[] = ['Database\\Factories\\UserFactory', 'unverified'];
            }

            // Check if test asserts specific starter kit content (like "Let's get started")
            // Note: content may be escaped in various ways in the source
            $starterKitPatterns = [
                '/Let.*s get started/i',
                '/Create an account/i',
                '/Log in to your account/i',
                '/Enter your email and password below/i',
                '/Enter your details below to create/i',
            ];
            $hasStarterKitContent = false;
            foreach ($starterKitPatterns as $pattern) {
                if (preg_match($pattern, $testBody)) {
                    $hasStarterKitContent = true;
                    break;
                }
            }

            // Build skip checks
            $skipChecks = [];

            // If test has starter kit specific content, add starter kit check
            if ($hasStarterKitContent) {
                $skipChecks[] = 'skipIfNotStarterKit();';
            }

            foreach (array_unique($routes) as $route) {
                $skipChecks[] = "skipIfRouteMissing('{$route}');";
            }
            foreach ($methods as [$class, $method]) {
                $skipChecks[] = "skipIfMethodMissing('{$class}', '{$method}');";
            }

            if (empty($skipChecks)) {
                return $testStart;
            }

            // Inject skip checks at the start of the test function
            return $testStart."\n    ".implode("\n    ", $skipChecks)."\n";
        },
        $content,
    );

    // Only write if content changed
    if ($content !== $originalContent) {
        file_put_contents($file->getPathname(), $content);
        echo "Updated: {$file->getPathname()}\n";
    }
}

echo "Done injecting skip checks\n";

/**
 * Extract the body of a test function (rough approximation).
 */
function extractTestBody(string $content, int $startPos): string
{
    $braceCount = 1;
    $pos = $startPos;
    $length = mb_strlen($content);

    while ($pos < $length && $braceCount > 0) {
        $char = mb_substr($content, $pos, 1);
        if ($char === '{') {
            $braceCount++;
        } elseif ($char === '}') {
            $braceCount--;
        }
        $pos++;
    }

    return mb_substr($content, $startPos, $pos - $startPos);
}
