<?php

declare(strict_types=1);

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use OverflowException;
use Override;

/**
 * @extends Factory<User>
 */
final class UserFactory extends Factory
{
    /**
     * The current password being used by the factory.
     */
    private static string $password;

    /**
     * Define the model's default state.
     *
     * @return (Carbon|string)[]
     *
     * @psalm-return array{name: string, email: string, email_verified_at: Carbon, password: string, remember_token: string}
     *
     * @throws OverflowException
     */
    // @mago-ignore analysis:invalid-override-attribute
    #[Override]
    public function definition(): array
    {
        if (! isset(self::$password)) {
            self::$password = Hash::make('password');
        }

        return [
            'name' => fake()->name(),
            'email' => fake()->unique()->safeEmail(),
            'email_verified_at' => now(),
            'password' => self::$password,
            'remember_token' => Str::random(10),
        ];
    }
}
