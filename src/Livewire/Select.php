<?php

namespace MrShaneBarron\Select\Livewire;

use Livewire\Component;
use Livewire\Attributes\Modelable;

class Select extends Component
{
    #[Modelable]
    public mixed $value = null;

    public array $options = [];
    public string $placeholder = '';
    public bool $multiple = false;
    public bool $searchable = true;
    public bool $clearable = true;
    public bool $disabled = false;
    public string $valueField = 'value';
    public string $labelField = 'label';
    public int $maxItems = -1;

    public function mount(
        mixed $value = null,
        array $options = [],
        ?string $placeholder = null,
        bool $multiple = false,
        bool $searchable = true,
        bool $clearable = true,
        bool $disabled = false,
        string $valueField = 'value',
        string $labelField = 'label',
        int $maxItems = -1
    ): void {
        $this->value = $value;
        $this->options = $options;
        $this->placeholder = $placeholder ?? config('ld-select.placeholder', 'Select an option');
        $this->multiple = $multiple;
        $this->searchable = $searchable;
        $this->clearable = $clearable;
        $this->disabled = $disabled;
        $this->valueField = $valueField;
        $this->labelField = $labelField;
        $this->maxItems = $maxItems;
    }

    public function updatedValue(): void
    {
        $this->dispatch('select-changed', value: $this->value);
    }

    public function render()
    {
        return view('ld-select::livewire.select');
    }
}
