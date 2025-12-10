<?php

declare(strict_types=1);

use SoloTerm\Solo\Commands\Command;
use SoloTerm\Solo\Commands\EnhancedTailCommand;
use SoloTerm\Solo\Commands\MakeCommand;
use SoloTerm\Solo\Hotkeys\DefaultHotkeys;
use SoloTerm\Solo\Hotkeys\VimHotkeys;
use SoloTerm\Solo\Manager;
use SoloTerm\Solo\Themes\DarkTheme;
use SoloTerm\Solo\Themes\LightTheme;

// Solo may not (should not!) exist in prod, so we have to
// check here first to see if it's installed.
if (! class_exists(Manager::class)) {
    return [
        //
    ];
}

return [
    /*
     |--------------------------------------------------------------------------
     | Themes
     |--------------------------------------------------------------------------
     */
    'theme' => env('SOLO_THEME', 'dark'),
    'themes' => [
        'light' => LightTheme::class,
        'dark' => DarkTheme::class,
    ],
    /*
     |--------------------------------------------------------------------------
     | Keybindings
     |--------------------------------------------------------------------------
     */
    'keybinding' => env('SOLO_KEYBINDING', 'default'),
    'keybindings' => [
        'default' => DefaultHotkeys::class,
        'vim' => VimHotkeys::class,
    ],
    /*
     |--------------------------------------------------------------------------
     | Commands
     |--------------------------------------------------------------------------
     |
     | Development commands start automatically when Solo starts.
     | Lazy commands can be started on demand using the 's' key.
     |
     */
    'commands' => [
        // Development commands (auto-start)
        'Server' => 'php artisan serve',
        'Queue' => 'php artisan queue:listen --tries=1',
        'Logs' => EnhancedTailCommand::file(storage_path('logs/laravel.log')),
        'Vite' => 'bun run dev',
        'Make' => new MakeCommand(),
        // Lazy commands do not automatically start when Solo starts.
        'Dumps' => Command::from('php artisan solo:dumps')->lazy(),
        'Reverb' => Command::from('php artisan reverb:start --debug')->lazy(),
        'Pint' => Command::from('./vendor/bin/pint --ansi')->lazy(),
        'Pail' => Command::from('php artisan pail --timeout=0')->lazy(),
        'Tests' => Command::from('php artisan test --colors=always')
            ->withEnv(['APP_ENV' => 'testing'])
            /** @psalm-suppress MixedMethodCall */
            ->lazy(),
        // Workflow quality checks (lazy - start on demand)
        // Workflow commands (lazy - start on demand)
        'Workflow' => Command::from('composer workflow')
            ->withEnv(['COMPOSER_PROCESS_TIMEOUT' => '0'])
            /** @psalm-suppress MixedMethodCall */
            ->lazy(),
        'Workflow:Clean' => Command::from('composer local:ghaction:clean')
            ->withEnv(['COMPOSER_PROCESS_TIMEOUT' => '0'])
            /** @psalm-suppress MixedMethodCall */
            ->lazy(),
        'Workflow:Lint' => Command::from('composer workflow:lint')
            ->withEnv(['COMPOSER_PROCESS_TIMEOUT' => '0'])
            /** @psalm-suppress MixedMethodCall */
            ->lazy(),
        'Workflow:PHPMD' => Command::from('composer workflow:phpmd')
            ->withEnv(['COMPOSER_PROCESS_TIMEOUT' => '0'])
            /** @psalm-suppress MixedMethodCall */
            ->lazy(),
        'Workflow:Pre-commit' => Command::from('composer workflow:pre-commit')
            ->withEnv(['COMPOSER_PROCESS_TIMEOUT' => '0'])
            /** @psalm-suppress MixedMethodCall */
            ->lazy(),
        'Workflow:Tests' => Command::from('composer workflow:tests')
            ->withEnv(['COMPOSER_PROCESS_TIMEOUT' => '0'])
            /** @psalm-suppress MixedMethodCall */
            ->lazy(),
        'Workflow:Browser' => Command::from('composer workflow:browser')
            ->withEnv(['COMPOSER_PROCESS_TIMEOUT' => '0'])
            /** @psalm-suppress MixedMethodCall */
            ->lazy(),
        'Workflow:Heavy' => Command::from('composer workflow:heavy')
            ->withEnv(['COMPOSER_PROCESS_TIMEOUT' => '0'])
            /** @psalm-suppress MixedMethodCall */
            ->lazy(),
    ],
    /**
     * By default, we prefer to use GNU Screen as an intermediary between Solo
     * and the underlying process. This helps us with many issues, including
     * PTY and some ANSI rendering things. Not all environments have Screen,
     * so you can turn it off for a slightly degraded experience.
     */
    'use_screen' => (bool) env('SOLO_USE_SCREEN', true),
    /*
     |--------------------------------------------------------------------------
     | Miscellaneous
     |--------------------------------------------------------------------------
     */

    /*
     * If you run the solo:dumps command, Solo will start a server to receive
     * the dumps. This is the address. You probably don't need to change
     * this unless the default is already taken for some reason.
     */
    'dump_server_host' => env('SOLO_DUMP_SERVER_HOST', 'tcp://127.0.0.1:9984'),
];
