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
                  'block w-full rounded-md border-0 py-1.5 ring-1 ring-inset sm:text-sm sm:leading-6'
         ]"
  >
</template>
