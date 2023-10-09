<?php

namespace Brunocfalcao\LaravelNovaHelpers;

use Brunocfalcao\LaravelNovaHelpers\Commands\ChangeUserPasswordCommand;
use Brunocfalcao\LaravelNovaHelpers\Commands\MakeUserCommand;
use Brunocfalcao\LaravelNovaHelpers\Commands\PintCommand;
use Brunocfalcao\LaravelNovaHelpers\Commands\PolicyListCommand;
use Brunocfalcao\LaravelNovaHelpers\Commands\ViewNamespacesCommand;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\ServiceProvider;

class LaravelNovaHelpersServiceProvider extends ServiceProvider
{
    public function boot(): void
    {
        //
    }

    public function register(): void
    {
        //
    }
}
