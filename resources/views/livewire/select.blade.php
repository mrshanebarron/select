<div
    class="relative"
    x-data="{ open: false }"
    @click.away="open = false"
    @keydown.escape="open = false"
>
    <button
        type="button"
        @click="open = !open"
        @if($disabled) disabled @endif
        class="relative w-full cursor-default rounded-lg bg-white py-2.5 pl-3 pr-10 text-left border border-gray-300 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 {{ $disabled ? 'opacity-50 cursor-not-allowed' : '' }}"
    >
        <span class="block truncate">
            @if($multiple && is_array($value) && count($value) > 0)
                {{ count($value) }} selected
            @elseif(!$multiple && $value !== null && isset($options[$value]))
                {{ $options[$value] }}
            @else
                <span class="text-gray-400">{{ $placeholder }}</span>
            @endif
        </span>
        <span class="pointer-events-none absolute inset-y-0 right-0 flex items-center pr-2">
            <svg class="h-5 w-5 text-gray-400" viewBox="0 0 20 20" fill="currentColor"><path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" /></svg>
        </span>
    </button>

    <div x-show="open" x-transition class="absolute z-50 mt-1 max-h-60 w-full overflow-auto rounded-md bg-white py-1 shadow-lg ring-1 ring-black ring-opacity-5">
        @if($searchable)
            <div class="px-3 py-2">
                <input type="text" wire:model.live="search" placeholder="Search..." class="w-full rounded border-gray-300 text-sm focus:ring-blue-500 focus:border-blue-500">
            </div>
        @endif

        @foreach($this->getFilteredOptions() as $optionValue => $label)
            <div
                wire:click="selectOption('{{ $optionValue }}')"
                class="relative cursor-pointer select-none py-2 pl-10 pr-4 hover:bg-blue-50 {{ ($multiple && is_array($value) && in_array($optionValue, $value)) || (!$multiple && $value === $optionValue) ? 'bg-blue-50 text-blue-900' : 'text-gray-900' }}"
            >
                <span class="block truncate">{{ $label }}</span>
                @if(($multiple && is_array($value) && in_array($optionValue, $value)) || (!$multiple && $value === $optionValue))
                    <span class="absolute inset-y-0 left-0 flex items-center pl-3 text-blue-600">
                        <svg class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor"><path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd" /></svg>
                    </span>
                @endif
            </div>
        @endforeach
    </div>

    @if($name)
        @if($multiple && is_array($value))
            @foreach($value as $v)
                <input type="hidden" name="{{ $name }}[]" value="{{ $v }}">
            @endforeach
        @else
            <input type="hidden" name="{{ $name }}" value="{{ $value }}">
        @endif
    @endif
</div>
