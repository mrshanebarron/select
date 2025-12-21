<div
    style="position: relative;"
    x-data="{ open: false }"
    @click.away="open = false"
    @keydown.escape="open = false"
>
    <button
        type="button"
        @click="open = !open"
        @if($this->disabled) disabled @endif
        style="position: relative; width: 100%; cursor: default; border-radius: 8px; background: white; padding: 10px 40px 10px 12px; text-align: left; border: 1px solid #d1d5db; {{ $this->disabled ? 'opacity: 0.5; cursor: not-allowed;' : '' }}"
    >
        <span style="display: block; overflow: hidden; text-overflow: ellipsis; white-space: nowrap;">
            @if($this->multiple && is_array($this->value) && count($this->value) > 0)
                {{ count($this->value) }} selected
            @elseif(!$this->multiple && $this->value !== null && isset($this->options[$this->value]))
                {{ $this->options[$this->value] }}
            @else
                <span style="color: #9ca3af;">{{ $this->placeholder }}</span>
            @endif
        </span>
        <span style="pointer-events: none; position: absolute; top: 0; bottom: 0; right: 0; display: flex; align-items: center; padding-right: 8px;">
            <svg style="height: 20px; width: 20px; color: #9ca3af;" viewBox="0 0 20 20" fill="currentColor"><path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" /></svg>
        </span>
    </button>

    <div x-show="open" x-transition style="position: absolute; z-index: 50; margin-top: 4px; max-height: 240px; width: 100%; overflow: auto; border-radius: 6px; background: white; padding: 4px 0; box-shadow: 0 10px 15px -3px rgba(0,0,0,0.1); border: 1px solid rgba(0,0,0,0.05);">
        @if($this->searchable)
            <div style="padding: 8px 12px;">
                <input type="text" wire:model.live="search" placeholder="Search..." style="width: 100%; border-radius: 4px; border: 1px solid #d1d5db; padding: 6px 10px; font-size: 14px;">
            </div>
        @endif

        @foreach($this->getFilteredOptions() as $optionValue => $label)
            @php
                $isSelected = ($this->multiple && is_array($this->value) && in_array($optionValue, $this->value)) || (!$this->multiple && $this->value === $optionValue);
            @endphp
            <div
                wire:click="selectOption('{{ $optionValue }}')"
                style="position: relative; cursor: pointer; user-select: none; padding: 8px 16px 8px 40px; {{ $isSelected ? 'background: #eff6ff; color: #1e3a8a;' : 'color: #111827;' }}"
                onmouseover="this.style.background='#eff6ff'"
                onmouseout="this.style.background='{{ $isSelected ? '#eff6ff' : 'transparent' }}'"
            >
                <span style="display: block; overflow: hidden; text-overflow: ellipsis; white-space: nowrap;">{{ $label }}</span>
                @if($isSelected)
                    <span style="position: absolute; top: 0; bottom: 0; left: 0; display: flex; align-items: center; padding-left: 12px; color: #2563eb;">
                        <svg style="height: 20px; width: 20px;" viewBox="0 0 20 20" fill="currentColor"><path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd" /></svg>
                    </span>
                @endif
            </div>
        @endforeach
    </div>

    @if($this->name)
        @if($this->multiple && is_array($this->value))
            @foreach($this->value as $v)
                <input type="hidden" name="{{ $this->name }}[]" value="{{ $v }}">
            @endforeach
        @else
            <input type="hidden" name="{{ $this->name }}" value="{{ $this->value }}">
        @endif
    @endif
</div>
