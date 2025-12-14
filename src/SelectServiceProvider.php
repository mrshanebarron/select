<?php

namespace MrShaneBarron\Select;

use Illuminate\Support\ServiceProvider;
use MrShaneBarron\Select\View\Components\Select;
use Livewire\Livewire;

class SelectServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->mergeConfigFrom(__DIR__.'/../config/ld-select.php', 'ld-select');
    }

    public function boot(): void
    {
        $this->loadViewsFrom(__DIR__.'/../resources/views', 'ld-select');

        $this->publishes([
            __DIR__.'/../config/ld-select.php' => config_path('ld-select.php'),
        ], 'ld-select-config');

        $this->publishes([
            __DIR__.'/../resources/views' => resource_path('views/vendor/ld-select'),
        ], 'ld-select-views');

        // Register Blade component
        $this->loadViewComponentsAs('ld', [
            Select::class,
        ]);

        // Register Livewire component if Livewire is installed
        if (class_exists(Livewire::class)) {
            Livewire::component('ld-select', \MrShaneBarron\Select\Livewire\Select::class);
        }
    }
}
