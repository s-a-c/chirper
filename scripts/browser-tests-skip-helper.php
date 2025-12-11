<?php

declare(strict_types=1);

// Route manifest is loaded once at boot time for efficient route checking
$_routeManifest = null;

/**
 * Get the route manifest (cached after first load).
 */
function getRouteManifest(): array
{
    global $_routeManifest;

    if ($_routeManifest === null) {
        $manifestPath = __DIR__.'/Browser/.route-manifest.json';
        if (file_exists($manifestPath)) {
            $_routeManifest = json_decode(file_get_contents($manifestPath), true);
        } else {
            // Fallback: check routes dynamically if manifest doesn't exist
            $_routeManifest = ['routes' => []];
        }
    }

    return $_routeManifest;
}

/**
 * Check if a route exists (uses manifest for speed, falls back to Route facade).
 */
function routeExists(string $routeName): bool
{
    $manifest = getRouteManifest();

    // If manifest has routes, use it
    if (! empty($manifest['routes'])) {
        return in_array($routeName, $manifest['routes'], true);
    }

    // Fallback to Route facade
    return Illuminate\Support\Facades\Route::has($routeName);
}

/**
 * Helper function to skip tests if a route doesn't exist.
 * Call this at the START of a test function to skip before any route() calls.
 */
function skipIfRouteMissing(string $routeName): void
{
    if (! routeExists($routeName)) {
        PHPUnit\Framework\Assert::markTestSkipped("Route [{$routeName}] not available in this project");
    }
}

/**
 * Helper function to skip tests if a factory method doesn't exist.
 */
function skipIfMethodMissing(string $class, string $method): void
{
    if (! method_exists($class, $method)) {
        PHPUnit\Framework\Assert::markTestSkipped("Method [{$class}::{$method}()] not available in this project");
    }
}

/**
 * Helper function to skip tests if expected content doesn't exist on a URL.
 * Useful for skipping starter kit-specific content tests.
 */
function skipIfContentMissing(string $url, string $expectedContent): void
{
    // This is a simple check - the test framework will handle the actual assertion
    // We can't easily pre-check content without making a request, so we mark this
    // as a known limitation. Tests expecting starter kit content should be skipped manually.
    // For now, this function is a no-op but documents the intent.
}

/**
 * Get a closure for Pest's ->skip() method to check route availability.
 * Usage: test('...', fn() => ...)->skip(fn() => skipWhenRouteMissing('login'));
 */
function skipWhenRouteMissing(string $routeName): bool
{
    return ! routeExists($routeName);
}

/**
 * Get a closure for Pest's ->skip() method to check method availability.
 */
function skipWhenMethodMissing(string $class, string $method): bool
{
    return ! method_exists($class, $method);
}

/**
 * Check if this is a Laravel starter kit project by looking for starter kit markers.
 * Returns false for custom projects that don't have starter kit features.
 */
function isStarterKitProject(): bool
{
    // Check for common starter kit indicators
    return routeExists('login') && routeExists('register') && routeExists('dashboard') && routeExists('home');
}

/**
 * Skip tests that require the full Laravel starter kit.
 * Call at the start of tests that rely on starter kit-specific features/content.
 */
function skipIfNotStarterKit(): void
{
    if (! isStarterKitProject()) {
        PHPUnit\Framework\Assert::markTestSkipped('Test requires Laravel starter kit features');
    }
}
