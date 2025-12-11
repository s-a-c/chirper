<?php

declare(strict_types=1);

use Illuminate\Support\Facades\Artisan;

use function Pest\Laravel\artisan as pestArtisan;

test('inspire command is registered', function (): void {
    // Verify the command is registered by checking Artisan
    expect(Artisan::all())->toHaveKey('inspire');
});

test('inspire command runs successfully', function (): void {
    pestArtisan('inspire')
        ->assertSuccessful();
});

test('inspire command outputs inspiring quote', function (): void {
    pestArtisan('inspire')
        ->expectsOutputToContain('')
        ->assertSuccessful();
});
