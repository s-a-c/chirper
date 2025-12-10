<?php

declare(strict_types=1);

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Symfony\Component\Process\Process;

class PolicyChecksumMonitor extends Command
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

        if ($this->option('paths')) {
            $args[] = '--paths=' . $this->option('paths');
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

        return $process->getExitCode();
    }
}
