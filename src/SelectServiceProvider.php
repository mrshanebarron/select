<?php

namespace MrShaneBarron\Select;

use Illuminate\Support\ServiceProvider;

class SelectServiceProvider extends ServiceProvider
{
    public function boot(): void
    {
        if (class_exists(\Livewire\Livewire::class)) {
            \Livewire\Livewire::component('ld-select', Livewire\Select::class);
        }
        $this->loadViewsFrom(__DIR__ . '/../resources/views', 'ld-select');
    }
}
