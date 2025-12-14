<?php

namespace MrShaneBarron\Select;

use Illuminate\Support\ServiceProvider;

class SelectServiceProvider extends ServiceProvider
{
    public function boot(): void
    {
        if (class_exists(\Livewire\Livewire::class)) {
            \Livewire\Livewire::component('sb-select', Livewire\Select::class);
        }
        $this->loadViewsFrom(__DIR__ . '/../resources/views', 'sb-select');
    }
}
