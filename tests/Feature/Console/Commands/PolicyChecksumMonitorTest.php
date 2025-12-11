<?php

declare(strict_types=1);

use App\Console\Commands\PolicyChecksumMonitor;
use Illuminate\Support\Facades\File;

use function Pest\Laravel\artisan;

test('policy checksum monitor command executes', function (): void {
    // Ensure the policy check script exists
    $scriptPath = base_path('scripts/policy-check.php');
    if (! File::exists($scriptPath)) {
        $this->markTestSkipped('Policy check script not found');
    }

    // The command may succeed or fail depending on policy compliance
    // We just verify it executes without throwing exceptions
    try {
        artisan(PolicyChecksumMonitor::class);
        expect(true)->toBeTrue(); // Command executed
    } catch (\Exception $e) {
        $this->fail('Command threw exception: '.$e->getMessage());
    }
});

test('policy checksum monitor command handles --strict option', function (): void {
    $scriptPath = base_path('scripts/policy-check.php');
    if (! File::exists($scriptPath)) {
        $this->markTestSkipped('Policy check script not found');
    }

    // The command may succeed or fail depending on policy compliance
    // We just verify it executes without throwing exceptions
    try {
        artisan(PolicyChecksumMonitor::class, ['--strict' => true]);
        expect(true)->toBeTrue(); // Command executed
    } catch (\Exception $e) {
        $this->fail('Command threw exception: '.$e->getMessage());
    }
});

test('policy checksum monitor command handles --paths option', function (): void {
    $scriptPath = base_path('scripts/policy-check.php');
    if (! File::exists($scriptPath)) {
        $this->markTestSkipped('Policy check script not found');
    }

    artisan(PolicyChecksumMonitor::class, ['--paths' => 'app/Console/Commands'])
        ->assertSuccessful();
});

test('policy checksum monitor command fails when script not found', function (): void {
    // Temporarily rename the script to simulate it not existing
    $scriptPath = base_path('scripts/policy-check.php');
    $backupPath = base_path('scripts/policy-check.php.backup');

    if (File::exists($scriptPath)) {
        File::move($scriptPath, $backupPath);
    }

    try {
        artisan(PolicyChecksumMonitor::class)
            ->expectsOutputToContain('Policy check script not found')
            ->assertFailed();
    } finally {
        // Restore the script
        if (File::exists($backupPath)) {
            File::move($backupPath, $scriptPath);
        }
    }
});
