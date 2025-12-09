<?php

declare(strict_types=1);

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Override;

final class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    // @mago-ignore analysis:invalid-override-attribute
    #[Override]
    public function register(): void {}
}
