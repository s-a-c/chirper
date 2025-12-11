<?php

declare(strict_types=1);

// Compliant with [.ai/AI-GUIDELINES.md](../../.ai/AI-GUIDELINES.md) v374a22e55a53ea38928957463e1f0ef28f820080a27e0466f35d46c20626fa72

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

uses(TestCase::class, RefreshDatabase::class);

covers(User::class);

test('user has fillable attributes', function (): void {
    /** @var User $user */
    $user = User::factory()->make();

    expect($user->getFillable())->toBe([
        'name',
        'email',
        'password',
    ]);
});

test('user can be created with fillable attributes', function (): void {
    /** @var User $user */
    $user = User::factory()->create([
        'name' => 'John Doe',
        'email' => 'john@example.com',
        'password' => 'password123',
    ]);

    /** @psalm-suppress UndefinedMagicPropertyFetch */
    expect($user->name)
        ->toBe('John Doe')
        /** @psalm-suppress UndefinedMagicPropertyFetch */
        ->and($user->email)
        ->toBe('john@example.com')
        /** @psalm-suppress UndefinedMagicPropertyFetch */
        ->and($user->password)
        ->not->toBe('password123')->and(Hash::check('password123', $user->password))->toBeTrue(); // Should be hashed
});

test('user has hidden attributes', function (): void {
    $user = User::factory()->create();

    /** @var array<string, mixed> $userArray */
    $userArray = $user->toArray();

    /** @psalm-suppress MixedPropertyFetch */
    expect($userArray)->not->toHaveKey('password')->and($userArray)->not->toHaveKey('remember_token');
});

test('user password is automatically hashed when set', function (): void {
    $user = User::factory()->create([
        'password' => 'plaintext-password',
    ]);

    expect($user->password)
        ->not
        ->toBe('plaintext-password')
        ->and(Hash::check('plaintext-password', $user->password))
        ->toBeTrue();
});

test('user email verified at is cast to datetime', function (): void {
    $user = User::factory()->create([
        'email_verified_at' => now(),
    ]);

    expect($user->email_verified_at)->toBeInstanceOf(Carbon::class);
});

test('user email verified at can be null', function (): void {
    $user = User::factory()->create([
        'email_verified_at' => null,
    ]);

    expect($user->email_verified_at)->toBeNull();
});

test('user password is cast to hashed', function (): void {
    $user = new User();
    $user->password = 'test-password';

    expect($user->password)->not->toBe('test-password')->and(Hash::check('test-password', $user->password))->toBeTrue();
});

test('user can be found by email', function (): void {
    $user = User::factory()->create([
        'email' => 'unique@example.com',
    ]);

    $found = User::query()->where('email', 'unique@example.com')->first();

    expect($found)->not->toBeNull()->and($found)->toBeInstanceOf(User::class);
    assert($found instanceof User, description: 'Found user should be an instance of User');
    expect($found->id)->toBe($user->id);
});

test('user can be found by name', function (): void {
    $user = User::factory()->create([
        'name' => 'Unique Name',
    ]);

    $found = User::query()->where('name', 'Unique Name')->first();

    expect($found)->not->toBeNull()->and($found)->toBeInstanceOf(User::class);
    assert($found instanceof User, description: 'Found user should be an instance of User');
    expect($found->id)->toBe($user->id);
});

test('user uses has factory trait', function (): void {
    expect(User::factory())->toBeInstanceOf(Factory::class);
});

test('user uses notifiable trait', function (): void {
    $user = User::factory()->create();

    /** @phpstan-ignore-next-line function.alreadyNarrowedType */
    expect(method_exists($user, 'notify'))->toBeTrue();
    /** @phpstan-ignore-next-line function.alreadyNarrowedType */
    expect(method_exists($user, 'notifyNow'))->toBeTrue();
    /** @phpstan-ignore-next-line function.alreadyNarrowedType */
    expect(method_exists($user, 'notifications'))->toBeTrue();
});

test('user extends authenticatable', function (): void {
    $user = User::factory()->create();

    expect($user)->toBeInstanceOf(Illuminate\Foundation\Auth\User::class);
});

test('user can update name', function (): void {
    /** @var User $user */
    $user = User::factory()->create([
        'name' => 'Original Name',
    ]);

    $user->update(['name' => 'Updated Name']);

    $fresh = $user->fresh();
    expect($fresh)->not->toBeNull()->and($fresh)->toBeInstanceOf(User::class);
    assert($fresh instanceof User, description: 'Fresh user should be an instance of User');
    /** @psalm-suppress UndefinedMagicPropertyFetch */
    expect($fresh->name)->toBe('Updated Name');
});

test('user can update email', function (): void {
    /** @var User $user */
    $user = User::factory()->create([
        'email' => 'original@example.com',
    ]);

    $user->update(['email' => 'updated@example.com']);

    $fresh = $user->fresh();
    expect($fresh)->not->toBeNull()->and($fresh)->toBeInstanceOf(User::class);
    assert($fresh instanceof User, description: 'Fresh user should be an instance of User');
    /** @psalm-suppress UndefinedMagicPropertyFetch */
    expect($fresh->email)->toBe('updated@example.com');
});

test('user can update password', function (): void {
    /** @var User $user */
    $user = User::factory()->create([
        'password' => 'old-password',
    ]);

    /** @psalm-suppress UndefinedMagicPropertyFetch */
    $oldPasswordHash = $user->password;

    $user->update(['password' => 'new-password']);

    $fresh = $user->fresh();
    expect($fresh)->not->toBeNull()->and($fresh)->toBeInstanceOf(User::class);
    assert($fresh instanceof User, description: 'Fresh user should be an instance of User');
    /** @psalm-suppress UndefinedMagicPropertyFetch */
    expect($fresh->password)
        ->not
        ->toBe($oldPasswordHash)
        /** @psalm-suppress UndefinedMagicPropertyFetch */
        ->and(Hash::check('new-password', $fresh->password))
        ->toBeTrue();
});

test('user remember token is generated', function (): void {
    /** @var User $user */
    $user = User::factory()->create();

    /** @psalm-suppress UndefinedMagicPropertyFetch */
    expect($user->remember_token)
        ->not
        ->toBeNull()
        /** @psalm-suppress UndefinedMagicPropertyFetch */
        ->and($user->remember_token)
        ->toBeString()
        /** @psalm-suppress UndefinedMagicPropertyFetch */
        ->and(mb_strlen($user->remember_token))
        ->toBeGreaterThan(0);
});

test('user can be deleted', function (): void {
    /** @var User $user */
    $user = User::factory()->create();

    /** @psalm-suppress UndefinedMagicPropertyFetch */
    $userId = $user->id;
    $user->delete();

    expect(User::query()->find($userId))->toBeNull();
});

test('user casts are applied correctly', function (): void {
    /** @var User $user */
    $user = User::factory()->create([
        'email_verified_at' => now(),
        'password' => 'test-password',
    ]);

    // Test that casts are applied by checking the types
    /** @psalm-suppress UndefinedMagicPropertyFetch */
    expect($user->email_verified_at)
        ->toBeInstanceOf(Carbon::class)
        /** @psalm-suppress UndefinedMagicPropertyFetch */
        ->and(Hash::check('test-password', $user->password))
        ->toBeTrue();
});

test('user can be created without email verified at', function (): void {
    /** @var User $user */
    $user = User::factory()->create([
        'email_verified_at' => null,
    ]);

    /** @psalm-suppress UndefinedMagicPropertyFetch */
    expect($user->email_verified_at)->toBeNull();
});

test('user can be created with email verified at', function (): void {
    /** @var User $user */
    $user = User::factory()->create();

    /** @psalm-suppress UndefinedMagicPropertyFetch */
    expect($user->email_verified_at)
        /** @psalm-suppress UndefinedMagicPropertyFetch */
        ->not
        ->toBeNull()
        /** @psalm-suppress UndefinedMagicPropertyFetch */
        ->and($user->email_verified_at)
        /** @psalm-suppress MixedMethodCall */
        ->toBeInstanceOf(Carbon::class);
});

test('user has correct table name', function (): void {
    $user = new User();

    expect($user->getTable())->toBe('users');
});

test('user has correct primary key', function (): void {
    $user = new User();

    expect($user->getKeyName())->toBe('id');
});

test('user timestamps are enabled by default', function (): void {
    /** @var User $user */
    $user = User::factory()->create();

    /** @psalm-suppress UndefinedMagicPropertyFetch */
    /** @psalm-suppress MixedPropertyFetch */
    expect($user->created_at)
        /** @psalm-suppress UndefinedMagicPropertyFetch */
        ->not->toBeNull()
        /** @psalm-suppress UndefinedMagicPropertyFetch */
        ->and($user->updated_at)
        ->not->toBeNull();
});

test('user can be serialized to array', function (): void {
    $user = User::factory()->create([
        'name' => 'Test User',
        'email' => 'test@example.com',
    ]);

    /** @var array<string, mixed> $array */
    $array = $user->toArray();

    /** @psalm-suppress MixedPropertyFetch */
    expect($array)
        ->toBeArray()
        ->and($array)
        ->toHaveKey('id')
        ->and($array)
        ->toHaveKey('name')
        ->and($array)
        ->toHaveKey('email')
        ->and($array)
        ->not->toHaveKey('password')->and($array)
        ->not->toHaveKey('remember_token');
});

test('user can be serialized to json', function (): void {
    $user = User::factory()->create([
        'name' => 'Test User',
        'email' => 'test@example.com',
    ]);

    $json = $user->toJson();
    /** @var array<string, mixed> $decoded */
    $decoded = json_decode(
        json: $json,
        associative: true,
    );

    /** @psalm-suppress MixedPropertyFetch */
    expect($decoded)
        ->toBeArray()
        ->and($decoded)
        ->toHaveKey('id')
        ->and($decoded)
        ->toHaveKey('name')
        ->and($decoded)
        ->toHaveKey('email')
        ->and($decoded)
        /** @psalm-suppress MixedMethodCall */
        ->not->toHaveKey('password')->and($decoded)
        /** @psalm-suppress MixedMethodCall */
        ->not->toHaveKey('remember_token');
});

test('user can be refreshed from database', function (): void {
    /** @var User $user */
    $user = User::factory()->create([
        'name' => 'Original Name',
    ]);

    /** @psalm-suppress UndefinedMagicPropertyFetch */
    User::query()->where('id', $user->id)->update(['name' => 'Updated Name']);

    $user->refresh();

    /** @psalm-suppress UndefinedMagicPropertyFetch */
    expect($user->name)->toBe('Updated Name');
});

test('user can be accessed as array', function (): void {
    $user = User::factory()->create([
        'name' => 'Array User',
        'email' => 'array@example.com',
    ]);

    /** @phpstan-ignore-next-line typePerfect.noArrayAccessOnObject */
    expect($user['name'])->toBe('Array User');
    /** @phpstan-ignore-next-line typePerfect.noArrayAccessOnObject */
    expect($user['email'])->toBe('array@example.com');
});

test('user can be set as array', function (): void {
    $user = User::factory()->create();

    /** @phpstan-ignore-next-line typePerfect.noArrayAccessOnObject */
    $user['name'] = 'Array Set Name';

    /** @psalm-suppress UndefinedMagicPropertyFetch */
    /** @psalm-suppress InternalMethod */
    expect($user->name)->toBe('Array Set Name');
});

test('user can check if attribute exists', function (): void {
    $user = User::factory()->create();

    expect(isset($user->name))->toBeTrue()->and(isset($user->email))->toBeTrue();
    /** @phpstan-ignore-next-line property.notFound */
    expect(isset($user->nonexistent))->toBeFalse();
});

test('user can be converted to string', function (): void {
    $user = User::factory()->create([
        'name' => 'String User',
        'email' => 'string@example.com',
    ]);

    $string = (string) $user;

    expect($string)->toBeString()->and($string)->toContain('String User');
});
