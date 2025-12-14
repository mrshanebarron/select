<script setup lang="ts">
import { ref, onMounted, onUnmounted, watch, computed } from 'vue'
import Choices from 'choices.js'
import 'choices.js/public/assets/styles/choices.min.css'

interface Option {
  value: string | number
  label: string
  disabled?: boolean
  selected?: boolean
}

interface Props {
  modelValue?: string | number | (string | number)[] | null
  options?: Option[] | string[]
  placeholder?: string
  multiple?: boolean
  searchable?: boolean
  clearable?: boolean
  disabled?: boolean
  maxItems?: number
}

const props = withDefaults(defineProps<Props>(), {
  modelValue: null,
  options: () => [],
  placeholder: 'Select an option',
  multiple: false,
  searchable: true,
  clearable: true,
  disabled: false,
  maxItems: -1,
})

const emit = defineEmits<{
  'update:modelValue': [value: string | number | (string | number)[] | null]
  'change': [value: string | number | (string | number)[] | null]
  'search': [query: string]
}>()

const selectRef = ref<HTMLSelectElement | null>(null)
let choicesInstance: Choices | null = null

const normalizedOptions = computed(() => {
  return props.options.map(option => {
    if (typeof option === 'string') {
      return { value: option, label: option }
    }
    return option
  })
})

function initChoices() {
  if (!selectRef.value) return

  choicesInstance = new Choices(selectRef.value, {
    allowHTML: true,
    searchEnabled: props.searchable,
    removeItemButton: props.clearable && props.multiple,
    placeholder: true,
    placeholderValue: props.placeholder,
    searchPlaceholderValue: 'Search...',
    noResultsText: 'No results found',
    noChoicesText: 'No choices available',
    maxItemCount: props.maxItems,
    shouldSort: false,
  })

  selectRef.value.addEventListener('change', handleChange)
  selectRef.value.addEventListener('search', handleSearch)
}

function handleChange() {
  if (!choicesInstance) return

  const value = props.multiple
    ? choicesInstance.getValue(true)
    : selectRef.value?.value || null

  emit('update:modelValue', value)
  emit('change', value)
}

function handleSearch(event: Event) {
  const customEvent = event as CustomEvent
  emit('search', customEvent.detail.value)
}

function destroyChoices() {
  if (choicesInstance) {
    choicesInstance.destroy()
    choicesInstance = null
  }
}

function setChoicesValue(value: any) {
  if (!choicesInstance) return

  if (props.multiple && Array.isArray(value)) {
    choicesInstance.removeActiveItems()
    value.forEach(v => choicesInstance?.setChoiceByValue(String(v)))
  } else if (value !== null && value !== undefined) {
    choicesInstance.setChoiceByValue(String(value))
  } else {
    choicesInstance.removeActiveItems()
  }
}

onMounted(() => {
  initChoices()
  if (props.modelValue !== null) {
    setChoicesValue(props.modelValue)
  }
})

onUnmounted(() => {
  destroyChoices()
})

watch(() => props.modelValue, (newValue) => {
  setChoicesValue(newValue)
})

watch(() => props.options, () => {
  if (choicesInstance) {
    choicesInstance.clearStore()
    choicesInstance.setChoices(
      normalizedOptions.value.map(opt => ({
        value: String(opt.value),
        label: opt.label,
        disabled: opt.disabled || false,
        selected: props.multiple
          ? Array.isArray(props.modelValue) && props.modelValue.includes(opt.value)
          : props.modelValue === opt.value,
      })),
      'value',
      'label',
      true
    )
  }
}, { deep: true })

watch(() => props.disabled, (disabled) => {
  if (choicesInstance) {
    if (disabled) {
      choicesInstance.disable()
    } else {
      choicesInstance.enable()
    }
  }
})

defineExpose({
  choices: () => choicesInstance,
  refresh: () => {
    destroyChoices()
    initChoices()
  },
})
</script>

<template>
  <div class="ld-select">
    <select
      ref="selectRef"
      :multiple="multiple"
      :disabled="disabled"
      class="w-full"
    >
      <option v-if="!multiple && placeholder" value="">{{ placeholder }}</option>
      <option
        v-for="option in normalizedOptions"
        :key="option.value"
        :value="option.value"
        :disabled="option.disabled"
        :selected="multiple
          ? Array.isArray(modelValue) && modelValue.includes(option.value)
          : modelValue === option.value"
      >
        {{ option.label }}
      </option>
    </select>
  </div>
</template>
