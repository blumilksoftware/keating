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
         :class="[props.error
                    ? 'text-red-900 placeholder:text-red-300 sm:text-sm sm:leading-6'
                    : 'text-gray-900 placeholder:text-gray-400 sm:text-sm sm:leading-6',
                  'block w-full rounded shadow-sm border-0 py-1.5 text-gray-900 shadow-sm placeholder:text-gray-400 sm:text-sm sm:leading-6'
         ]"
  >
</template>
