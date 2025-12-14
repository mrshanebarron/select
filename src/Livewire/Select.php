<?php

namespace MrShaneBarron\Select\Livewire;

use Livewire\Component;

class Select extends Component
{
    public $value = null;
    public array $options = [];
    public ?string $placeholder = 'Select an option';
    public bool $searchable = false;
    public bool $multiple = false;
    public bool $disabled = false;
    public ?string $name = null;
    public string $search = '';

    public function mount($value = null, array $options = [], ?string $placeholder = 'Select an option', bool $searchable = false, bool $multiple = false, bool $disabled = false, ?string $name = null): void
    {
        $this->value = $value;
        $this->options = $options;
        $this->placeholder = $placeholder;
        $this->searchable = $searchable;
        $this->multiple = $multiple;
        $this->disabled = $disabled;
        $this->name = $name;
    }

    public function selectOption($optionValue): void
    {
        if ($this->multiple) {
            $values = is_array($this->value) ? $this->value : [];
            if (in_array($optionValue, $values)) {
                $this->value = array_values(array_diff($values, [$optionValue]));
            } else {
                $this->value = array_merge($values, [$optionValue]);
            }
        } else {
            $this->value = $optionValue;
        }
        $this->dispatch('select-changed', value: $this->value);
    }

    public function getFilteredOptions(): array
    {
        if (!$this->searchable || empty($this->search)) return $this->options;
        return array_filter($this->options, fn($label) => stripos($label, $this->search) !== false);
    }

    public function render()
    {
        return view('ld-select::livewire.select');
    }
}
