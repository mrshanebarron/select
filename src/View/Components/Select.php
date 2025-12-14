<?php

namespace MrShaneBarron\Select\View\Components;

use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class Select extends Component
{
    public string $selectId;

    public function __construct(
        public string $name = 'select',
        public mixed $value = null,
        public array $options = [],
        public ?string $placeholder = null,
        public bool $multiple = false,
        public bool $searchable = true,
        public bool $clearable = true,
        public bool $disabled = false,
        public string $valueField = 'value',
        public string $labelField = 'label',
        public int $maxItems = -1,
        ?string $id = null
    ) {
        $this->placeholder = $placeholder ?? config('ld-select.placeholder', 'Select an option');
        $this->selectId = $id ?? 'select-' . uniqid();
    }

    public function render(): View
    {
        return view('ld-select::components.select');
    }
}
