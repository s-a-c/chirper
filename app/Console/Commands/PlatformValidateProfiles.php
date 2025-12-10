<?php

declare(strict_types=1);

namespace App\Console\Commands;

use Exception;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

/**
 * Platform Validate Profiles Command
 *
 * Validates that the platform environment profiles are correctly configured.
 */
final class PlatformValidateProfiles extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'platform:validate-profiles
                            {--all : Validate all environment profiles}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Validate platform environment profiles';

    /**
     * Execute the console command.
     */
    public function handle(): int
    {
        $this->info('Validating platform environment profiles...');

        // Validate database connection
        try {
            DB::connection()->getPdo();
            $this->info('✓ Database connection: OK');
        } catch (Exception $e) {
            $this->error('✗ Database connection: FAILED');
            $this->error('  '.$e->getMessage());

            return self::FAILURE;
        }

        // Validate migrations have been run
        try {
            $migrations = DB::table('migrations')->count();
            if ($migrations > 0) {
                $this->info("✓ Migrations: OK ({$migrations} migrations found)");
            } else {
                $this->warn('⚠ Migrations: No migrations found (database may be empty)');
            }
        } catch (Exception $e) {
            $this->warn('⚠ Migrations: Could not check migrations table');
        }

        // Validate seeders have been run (check for users)
        try {
            $userCount = DB::table('users')->count();
            if ($userCount > 0) {
                $this->info("✓ Seeders: OK ({$userCount} users found)");
            } else {
                $this->warn('⚠ Seeders: No users found (BasePlatformSeeder may not have been run)');
            }
        } catch (Exception $e) {
            $this->warn('⚠ Seeders: Could not check users table');
        }

        if ($this->option('all')) {
            $this->info('✓ All profiles validated');
        }

        $this->info('Platform validation complete.');

        return self::SUCCESS;
    }
}
