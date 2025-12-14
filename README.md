# Laravel Design Select

Enhanced select component using Choices.js for Laravel. Supports Livewire, Blade, and Vue 3.

## Installation

```bash
composer require mrshanebarron/select
```

For Vue components:
```bash
npm install @laraveldesign/select
```

Include Choices.js CSS and JS:

```html
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/choices.js/public/assets/styles/choices.min.css">
<script src="https://cdn.jsdelivr.net/npm/choices.js/public/assets/scripts/choices.min.js"></script>
```

## Usage

### Livewire Component

```blade
<livewire:ld-select
    wire:model="country"
    :options="[
        ['value' => 'us', 'label' => 'United States'],
        ['value' => 'uk', 'label' => 'United Kingdom'],
        ['value' => 'ca', 'label' => 'Canada'],
    ]"
    placeholder="Select a country"
/>

{{-- Multiple selection --}}
<livewire:ld-select
    wire:model="tags"
    :options="$availableTags"
    :multiple="true"
    :searchable="true"
    placeholder="Select tags..."
/>

{{-- With max items --}}
<livewire:ld-select
    wire:model="categories"
    :options="$categories"
    :multiple="true"
    :max-items="3"
/>
```

### Blade Component

```blade
<x-ld-select name="status" :options="$statuses" />

{{-- With initial value --}}
<x-ld-select
    name="priority"
    :options="$priorities"
    :value="$task->priority"
/>

{{-- Multiple selection --}}
<x-ld-select
    name="assignees[]"
    :options="$users"
    :multiple="true"
    :value="$task->assignees"
    placeholder="Assign team members..."
/>

{{-- Not searchable --}}
<x-ld-select
    name="rating"
    :options="[1,2,3,4,5]"
    :searchable="false"
/>
```

### Vue 3 Component

```vue
<script setup>
import { ref } from 'vue'
import { LdSelect } from '@laraveldesign/select'

const selected = ref(null)
const options = [
  { value: 'react', label: 'React' },
  { value: 'vue', label: 'Vue' },
  { value: 'angular', label: 'Angular' },
  { value: 'svelte', label: 'Svelte' },
]
</script>

<template>
  <LdSelect
    v-model="selected"
    :options="options"
    placeholder="Choose a framework"
    :searchable="true"
    :clearable="true"
  />
</template>
```

## Props

| Prop | Type | Default | Description |
|------|------|---------|-------------|
| `value` | mixed | `null` | Selected value(s) |
| `options` | array | `[]` | Available options |
| `placeholder` | string | `'Select an option'` | Placeholder text |
| `multiple` | boolean | `false` | Allow multiple selection |
| `searchable` | boolean | `true` | Enable search/filter |
| `clearable` | boolean | `true` | Show clear button |
| `disabled` | boolean | `false` | Disable the select |
| `valueField` | string | `'value'` | Key for option value |
| `labelField` | string | `'label'` | Key for option label |
| `maxItems` | number | `-1` | Max selections (-1 = unlimited) |

## Option Formats

Options can be provided in multiple formats:

```php
// Simple array
['Option 1', 'Option 2', 'Option 3']

// Key-value pairs
[
    'draft' => 'Draft',
    'published' => 'Published',
    'archived' => 'Archived',
]

// Object array
[
    ['value' => 1, 'label' => 'Admin'],
    ['value' => 2, 'label' => 'Editor'],
    ['value' => 3, 'label' => 'Viewer'],
]

// With groups
[
    ['value' => 1, 'label' => 'Apple', 'group' => 'Fruits'],
    ['value' => 2, 'label' => 'Banana', 'group' => 'Fruits'],
    ['value' => 3, 'label' => 'Carrot', 'group' => 'Vegetables'],
]
```

## Events

### Livewire Events

```javascript
Livewire.on('select-changed', ({ value }) => {
    console.log('Selected:', value);
});
```

### Vue Events

```vue
<LdSelect
  v-model="value"
  @change="handleChange"
  @search="handleSearch"
/>
```

## Configuration

Publish the config file:

```bash
php artisan vendor:publish --tag=ld-select-config
```

### Configuration Options

```php
// config/ld-select.php
return [
    'placeholder' => 'Select an option',
    'searchable' => true,
    'clearable' => true,
    'search_placeholder' => 'Search...',
    'no_results_text' => 'No results found',
];
```

## Customization

### Publishing Views

```bash
php artisan vendor:publish --tag=ld-select-views
```

### Choices.js Styling

Override Choices.js styles:

```css
.choices__inner {
    background-color: white;
    border-color: #d1d5db;
}

.choices__input {
    background-color: white;
}
```

## License

MIT
