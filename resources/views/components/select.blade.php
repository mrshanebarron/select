<div
    x-data="{
        choices: null,
        value: @js($value),
        init() {
            this.choices = new Choices(this.$refs.select, {
                allowHTML: true,
                searchEnabled: {{ $searchable ? 'true' : 'false' }},
                removeItemButton: {{ $clearable ? 'true' : 'false' }},
                placeholder: true,
                placeholderValue: '{{ $placeholder }}',
                searchPlaceholderValue: '{{ config('ld-select.searchPlaceholder', 'Search...') }}',
                noResultsText: '{{ config('ld-select.noResultsText', 'No results found') }}',
                noChoicesText: '{{ config('ld-select.noChoicesText', 'No choices available') }}',
                maxItemCount: {{ $maxItems }},
                shouldSort: false,
            })

            this.$refs.select.addEventListener('change', () => {
                this.value = {{ $multiple }} ? this.choices.getValue(true) : this.$refs.select.value
            })
        },
        destroy() {
            if (this.choices) {
                this.choices.destroy()
            }
        }
    }"
    x-init="init()"
    x-on:destroy="destroy()"
    class="ld-select"
>
    <select
        x-ref="select"
        name="{{ $name }}{{ $multiple ? '[]' : '' }}"
        id="{{ $selectId }}"
        @if($multiple) multiple @endif
        @if($disabled) disabled @endif
        class="w-full"
    >
        @if(!$multiple && $placeholder)
            <option value="">{{ $placeholder }}</option>
        @endif
        @foreach($options as $option)
            @php
                $optionValue = is_array($option) ? ($option[$valueField] ?? $option['value'] ?? '') : $option;
                $optionLabel = is_array($option) ? ($option[$labelField] ?? $option['label'] ?? $option['value'] ?? '') : $option;
                $isSelected = $multiple
                    ? (is_array($value) && in_array($optionValue, $value))
                    : $value == $optionValue;
            @endphp
            <option
                value="{{ $optionValue }}"
                @if($isSelected) selected @endif
            >{{ $optionLabel }}</option>
        @endforeach
    </select>
</div>

@once
    @push('styles')
        <link rel="stylesheet" href="{{ config('ld-select.choices_css_url') }}">
    @endpush
    @push('scripts')
        <script src="{{ config('ld-select.choices_js_url') }}"></script>
    @endpush
@endonce
