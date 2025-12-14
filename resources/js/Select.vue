<template>
  <div class="relative" ref="container">
    <button type="button" @click="open = !open" :disabled="disabled" :class="['relative w-full cursor-default rounded-lg bg-white py-2.5 pl-3 pr-10 text-left border border-gray-300 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500', disabled ? 'opacity-50 cursor-not-allowed' : '']">
      <span class="block truncate">
        <template v-if="multiple && Array.isArray(modelValue) && modelValue.length">{{ modelValue.length }} selected</template>
        <template v-else-if="!multiple && modelValue !== null && options[modelValue]">{{ options[modelValue] }}</template>
        <span v-else class="text-gray-400">{{ placeholder }}</span>
      </span>
      <span class="pointer-events-none absolute inset-y-0 right-0 flex items-center pr-2">
        <svg class="h-5 w-5 text-gray-400" viewBox="0 0 20 20" fill="currentColor"><path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" /></svg>
      </span>
    </button>

    <Transition name="dropdown">
      <div v-if="open" class="absolute z-50 mt-1 max-h-60 w-full overflow-auto rounded-md bg-white py-1 shadow-lg ring-1 ring-black ring-opacity-5">
        <div v-if="searchable" class="px-3 py-2">
          <input v-model="search" type="text" placeholder="Search..." class="w-full rounded border-gray-300 text-sm focus:ring-blue-500 focus:border-blue-500">
        </div>
        <div v-for="(label, value) in filteredOptions" :key="value" @click="selectOption(value)" :class="['relative cursor-pointer select-none py-2 pl-10 pr-4 hover:bg-blue-50', isSelected(value) ? 'bg-blue-50 text-blue-900' : 'text-gray-900']">
          <span class="block truncate">{{ label }}</span>
          <span v-if="isSelected(value)" class="absolute inset-y-0 left-0 flex items-center pl-3 text-blue-600">
            <svg class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor"><path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd" /></svg>
          </span>
        </div>
      </div>
    </Transition>
  </div>
</template>

<script>
import { ref, computed, onMounted, onUnmounted } from 'vue';

export default {
  name: 'LdSelect',
  props: {
    modelValue: { default: null },
    options: { type: Object, required: true },
    placeholder: { type: String, default: 'Select an option' },
    searchable: { type: Boolean, default: false },
    multiple: { type: Boolean, default: false },
    disabled: { type: Boolean, default: false }
  },
  emits: ['update:modelValue'],
  setup(props, { emit }) {
    const open = ref(false);
    const search = ref('');
    const container = ref(null);

    const filteredOptions = computed(() => {
      if (!props.searchable || !search.value) return props.options;
      return Object.fromEntries(Object.entries(props.options).filter(([_, label]) => label.toLowerCase().includes(search.value.toLowerCase())));
    });

    const isSelected = (value) => props.multiple ? Array.isArray(props.modelValue) && props.modelValue.includes(value) : props.modelValue === value;

    const selectOption = (value) => {
      if (props.multiple) {
        const values = Array.isArray(props.modelValue) ? [...props.modelValue] : [];
        const idx = values.indexOf(value);
        if (idx > -1) values.splice(idx, 1); else values.push(value);
        emit('update:modelValue', values);
      } else {
        emit('update:modelValue', value);
        open.value = false;
      }
    };

    const handleClickOutside = (e) => { if (container.value && !container.value.contains(e.target)) open.value = false; };
    onMounted(() => document.addEventListener('click', handleClickOutside));
    onUnmounted(() => document.removeEventListener('click', handleClickOutside));

    return { open, search, container, filteredOptions, isSelected, selectOption };
  }
};
</script>
