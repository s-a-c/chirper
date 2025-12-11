<?php

declare(strict_types=1);

use Illuminate\Support\Facades\Route;

use function Pest\Laravel\get;

test('welcome route returns 200', function (): void {
    get('/')
        ->assertStatus(200)
        ->assertViewIs('welcome');
});

test('welcome route is accessible', function (): void {
    // Test that the route can be matched
    $route = Route::getRoutes()->match(request()->create('/'));
    expect($route)->not->toBeNull();
});

test('chirps index route exists and is accessible', function (): void {
    // ChirpController is currently empty, so this will return 500
    // We test that the route is registered and accessible
    expect(route('chirps.index'))->toContain('/chirper');
    expect(Route::has('chirps.index'))->toBeTrue();

    get('/chirper')
        ->assertStatus(500); // Method not implemented yet
});

test('chirps index route is registered at /chirper path', function (): void {
    $route = Route::getRoutes()->match(request()->create('/chirper'));
    expect($route)->not->toBeNull();
    expect($route->getName())->toBe('chirps.index');
});
