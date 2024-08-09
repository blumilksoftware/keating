<script setup>
import { computed } from 'vue'

const props = defineProps({
  modelValue: {
    type: [String, Number, null],
    default: null,
  },
  error: {
    type: String,
    default: null,
  },
})
const emit = defineEmits(['update:modelValue'])
const value = computed({
  get: () => props.modelValue,
  set: (value) => {
    emit('update:modelValue', value)
  },
})
</script>

<template>
  <input v-bind="$attrs" v-model="value"
         type="color"
         :class="[props.error
                    ? 'text-red-900 ring-red-300 placeholder:text-red-300'
                    : 'text-gray-900 shadow-sm ring-gray-300 placeholder:text-gray-400',
                  'block h-10 w-14 cursor-pointer rounded-lg border border-gray-200 bg-white p-1 disabled:pointer-events-none disabled:opacity-50 dark:border-neutral-700 dark:bg-neutral-900'
         ]"
  >
</template>
