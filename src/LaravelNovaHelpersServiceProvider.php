<?php

namespace Brunocfalcao\LaravelNovaHelpers;

use Illuminate\Support\Collection;
use Illuminate\Support\ServiceProvider;

class LaravelNovaHelpersServiceProvider extends ServiceProvider
{
    public function boot(): void
    {
        $this->registerMacros();
    }

    public function register(): void
    {
        //
    }

    protected function registerMacros(): void
    {
        // Include all files from the Macros folder.
        Collection::make(glob(__DIR__.'/Macros/*.php'))
            ->mapWithKeys(function ($path) {
                return [$path => pathinfo($path, PATHINFO_FILENAME)];
            })
            ->each(function ($macro, $path) {
                require_once $path;
            });
    }
}
