# Select

A custom select dropdown component for Laravel applications. Supports search, multi-select, and custom styling. Works with Livewire and Vue 3.

## Installation

```bash
composer require mrshanebarron/select
```

## Livewire Usage

### Basic Usage

```blade
<livewire:sb-select
    wire:model="country"
    :options="['us' => 'United States', 'ca' => 'Canada', 'mx' => 'Mexico']"
/>
```

### With Placeholder

```blade
<livewire:sb-select
    wire:model="status"
    :options="$statuses"
    placeholder="Select a status"
/>
```

### Searchable

```blade
<livewire:sb-select
    wire:model="country"
    :options="$countries"
    :searchable="true"
    placeholder="Search countries..."
/>
```

### Multi-select

```blade
<livewire:sb-select
    wire:model="tags"
    :options="$availableTags"
    :multiple="true"
    placeholder="Select tags"
/>
```

### Livewire Props

| Prop | Type | Default | Description |
|------|------|---------|-------------|
| `wire:model` | mixed | `null` | Selected value(s) |
| `options` | array | required | Key-value options |
| `placeholder` | string | `'Select an option'` | Placeholder text |
| `searchable` | boolean | `false` | Enable search |
| `multiple` | boolean | `false` | Allow multiple selections |
| `disabled` | boolean | `false` | Disable select |

## Vue 3 Usage

### Setup

```javascript
import { SbSelect } from './vendor/sb-select';
app.component('SbSelect', SbSelect);
```

### Basic Usage

```vue
<template>
  <SbSelect v-model="selected" :options="options" />
</template>

<script setup>
import { ref } from 'vue';

const selected = ref(null);
const options = {
  draft: 'Draft',
  published: 'Published',
  archived: 'Archived'
};
</script>
```

### With Placeholder

```vue
<template>
  <SbSelect
    v-model="selected"
    :options="options"
    placeholder="Choose a status..."
  />
</template>
```

### Searchable

```vue
<template>
  <SbSelect
    v-model="country"
    :options="countries"
    searchable
    placeholder="Search countries..."
  />
</template>

<script setup>
import { ref } from 'vue';

const country = ref(null);
const countries = {
  us: 'United States',
  ca: 'Canada',
  uk: 'United Kingdom',
  de: 'Germany',
  fr: 'France',
  // ... more countries
};
</script>
```

### Multi-select

```vue
<template>
  <SbSelect
    v-model="selectedTags"
    :options="tags"
    multiple
    placeholder="Select tags"
  />
  <p>Selected: {{ selectedTags }}</p>
</template>

<script setup>
import { ref } from 'vue';

const selectedTags = ref([]);
const tags = {
  frontend: 'Frontend',
  backend: 'Backend',
  design: 'Design',
  devops: 'DevOps'
};
</script>
```

### Form Example

```vue
<template>
  <form @submit.prevent="submit" class="space-y-4">
    <div>
      <label class="block text-sm font-medium mb-1">Category</label>
      <SbSelect
        v-model="form.category"
        :options="categories"
        placeholder="Select category"
      />
    </div>

    <div>
      <label class="block text-sm font-medium mb-1">Tags</label>
      <SbSelect
        v-model="form.tags"
        :options="tags"
        multiple
        searchable
        placeholder="Select tags"
      />
    </div>

    <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded">
      Save
    </button>
  </form>
</template>
```

### Vue Props

| Prop | Type | Default | Description |
|------|------|---------|-------------|
| `modelValue` | Any | `null` | Selected value(s) |
| `options` | Object | required | `{ value: 'Label' }` pairs |
| `placeholder` | String | `'Select an option'` | Placeholder text |
| `searchable` | Boolean | `false` | Enable filtering |
| `multiple` | Boolean | `false` | Multi-select mode |
| `disabled` | Boolean | `false` | Disable interaction |

### Events

| Event | Payload | Description |
|-------|---------|-------------|
| `update:modelValue` | `any` | Emitted when selection changes |

## Features

- **Custom Styling**: Matches form design
- **Searchable**: Filter options by typing
- **Multi-select**: Select multiple values
- **Checkmarks**: Visual selection indicators
- **Keyboard Navigation**: Escape to close
- **Click Outside**: Closes on outside click

## Options Format

```javascript
// Object format (value => label)
const options = {
  draft: 'Draft',
  published: 'Published',
  archived: 'Archived'
};
```

## Multi-select Values

When `multiple` is true, the model value is an array:

```vue
// Single select
const selected = ref('draft'); // string

// Multi-select
const selected = ref(['frontend', 'backend']); // array
```

## Styling

Uses Tailwind CSS:
- White background with border
- Blue ring on focus
- Checkmark for selected items
- Hover highlight
- Disabled opacity

## Requirements

- PHP 8.1+
- Laravel 10, 11, or 12
- Tailwind CSS 3.x

## License

MIT License
