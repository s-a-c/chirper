#!/usr/bin/env php
<?php

declare(strict_types=1);

/**
 * Generates a JSON manifest of available routes for browser test filtering.
 * This allows tests to be skipped at definition time rather than runtime.
 */

require_once __DIR__.'/../vendor/autoload.php';

$app = require_once __DIR__.'/../bootstrap/app.php';
$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();

$routes = collect(Illuminate\Support\Facades\Route::getRoutes()->getRoutesByName())->keys()->values()->toArray();

$manifest = [
    'generated_at' => date('c'),
    'route_count' => count($routes),
    'routes' => $routes,
];

$outputPath = __DIR__.'/../tests/Browser/.route-manifest.json';
file_put_contents($outputPath, json_encode($manifest, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES));

echo 'Generated route manifest with '.count($routes)." routes at {$outputPath}\n";
