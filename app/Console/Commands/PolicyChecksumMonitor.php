<?php

declare(strict_types=1);

// Compliant with [.ai/AI-GUIDELINES.md](../../.ai/AI-GUIDELINES.md) v374a22e55a53ea38928957463e1f0ef28f820080a27e0466f35d46c20626fa72

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Symfony\Component\Process\Process;

final class PolicyChecksumMonitor extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'policy:checksum-monitor
                            {--strict : Enable strict mode (drift enforcement and warnings as errors)}
                            {--paths= : Comma-separated list of file paths/globs to check}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Monitor AI-GUIDELINES.md compliance and checksum validation';

    /**
     * Execute the console command.
     */
    public function handle(): int
    {
        $scriptPath = base_path('.ai/scripts/policy-check.php');

        if (! file_exists($scriptPath)) {
            $this->error("Policy check script not found at: {$scriptPath}");

            return self::FAILURE;
        }

        $args = [];
        if ($this->option('strict')) {
            $args[] = '--strict';
        }

        $paths = $this->option('paths');
        if ($paths !== null && $paths !== '') {
            $args[] = '--paths='.$paths;
        }

        $process = new Process(
            command: array_merge(['php', $scriptPath], $args),
            cwd: base_path(),
        );

        $process->setTimeout(300);
        $process->run(function (string $type, string $buffer): void {
            if ($type === Process::ERR) {
                $this->error($buffer);
            } else {
                $this->line($buffer);
            }
        });

        $exitCode = $process->getExitCode();

        return $exitCode ?? self::FAILURE;
    }
}
