<?php

declare(strict_types=1);

use App\Console\Commands\PlatformValidateProfiles;
use Illuminate\Support\Facades\DB;

use function Pest\Laravel\artisan;

test('platform validate profiles command runs successfully', function (): void {
    artisan(PlatformValidateProfiles::class)
        ->expectsOutput('Validating platform environment profiles...')
        ->expectsOutputToContain('Database connection: OK')
        ->assertSuccessful();
});

test('platform validate profiles command shows migration count when migrations exist', function (): void {
    // Run migrations first to ensure migrations table exists
    $this->artisan('migrate')->assertSuccessful();

    artisan(PlatformValidateProfiles::class)
        ->expectsOutputToContain('Migrations:')
        ->assertSuccessful();
});

test('platform validate profiles command shows user count when users exist', function (): void {
    artisan(PlatformValidateProfiles::class)
        ->expectsOutputToContain('Seeders:')
        ->assertSuccessful();
});

test('platform validate profiles command shows user count message when users exist', function (): void {
    // Ensure database is migrated
    $this->artisan('migrate')->assertSuccessful();
    
    // Create a user to ensure the "users found" path is hit (line 72)
    \App\Models\User::factory()->create();

    artisan(PlatformValidateProfiles::class)
        ->expectsOutputToContain('Seeders:')
        ->assertSuccessful();
});

test('platform validate profiles command handles --all option', function (): void {
    artisan(PlatformValidateProfiles::class, ['--all' => true])
        ->expectsOutput('✓ All profiles validated')
        ->expectsOutput('Platform validation complete.')
        ->assertSuccessful();
});

