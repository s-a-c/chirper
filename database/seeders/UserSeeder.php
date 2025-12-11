<?php

declare(strict_types=1);

// Compliant with [.ai/AI-GUIDELINES.md](../../.ai/AI-GUIDELINES.md) v374a22e55a53ea38928957463e1f0ef28f820080a27e0466f35d46c20626fa72

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

final class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @psalm-suppress PossiblyUnusedMethod
     */
    public function run(): void
    {
        // Create Super Admin
        User::factory()->create([
            'name' => 'Super Admin',
            'email' => 'superadmin@example.com',
            'password' => Hash::make('password'),
        ]);

        // Create Admin User
        User::factory()->create([
            'name' => 'Admin User',
            'email' => 'admin@example.com',
            'password' => Hash::make('password'),
        ]);

        // Create Test User
        User::factory()->create([
            'name' => 'Test User',
            'email' => 'test@example.com',
            'password' => Hash::make('password'),
        ]);

        // Create Regular User
        User::factory()->create([
            'name' => 'Regular User',
            'email' => 'user@example.com',
            'password' => Hash::make('password'),
        ]);

        // Create 100 random users using faker
        User::factory()->count(100)->create();
    }
}
