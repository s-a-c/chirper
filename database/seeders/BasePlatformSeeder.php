<?php

declare(strict_types=1);

namespace Database\Seeders;

use Illuminate\Database\Seeder;

/**
 * Base Platform Seeder
 *
 * Seeds the platform with base data required for the application to function.
 * This seeder is called during CI/CD and local development setup.
 *
 * @psalm-suppress UnusedClass
 * This seeder is called via `php artisan db:seed --class=BasePlatformSeeder` in CI.
 */
final class BasePlatformSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $this->call([
            DatabaseSeeder::class,
        ]);
    }
}
