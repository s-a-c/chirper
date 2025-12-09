<?php

declare(strict_types=1);

use function Pest\Laravel\get;

test('example', function (): void {
    get('/')->assertStatus(200);
});
