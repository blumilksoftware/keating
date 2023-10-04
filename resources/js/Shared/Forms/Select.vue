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
  options: {
    type: Array,
    default: null,
  },
  label: {
    type: String,
    default: 'name',
  },
  itemValue: {
    type: String,
    default: 'id',
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
  <select v-bind="$attrs" v-model="value"
          class="block w-full rounded-lg border-0 p-2.5 text-sm text-gray-900 shadow-sm ring-gray-300 placeholder:text-gray-400 focus:border-blue-500 focus:ring-blue-500"
          :class="[props.error
                     ? 'text-red-900 ring-red-300 placeholder:text-red-300'
                     : 'text-gray-900 shadow-sm ring-gray-300 placeholder:text-gray-400',
                   'block w-full rounded-md border-0 py-1.5 ring-1 ring-inset sm:text-sm sm:leading-6'
          ]"
  >
    <option v-for="option in options"
            :key="option[`${props.itemValue}`]"
            :value="option[`${props.itemValue}`]"
            :selected="option[`${props.itemValue}`] === value"
    >
      {{ option[`${props.label}`] }}
    </option>
  </select>
</template>
