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
                    ? 'border-red-500 text-red-500 focus:border-red-300'
                    : 'text-black-700 hover:border-black-700 border-gray-500 focus:border-black',
                  '!mb-[1px] block w-full border-0 border-b p-2 text-sm font-medium hover:!mb-[1px] hover:border-b-2 focus:!mb-[1px] focus:border-b-2 focus:ring-0 focus:ring-offset-0'
         ]"
  >
</template>
