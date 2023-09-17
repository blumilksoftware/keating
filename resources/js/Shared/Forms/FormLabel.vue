<script setup>
defineProps({
  modelValue: {
    type: [String, Number, null],
    default: null,
  },
  isCustom: {
    type: Boolean,
    default: false,
  },
})
</script>

<template>
  <span v-if="isCustom" class="block text-sm leading-5 text-gray-700">
    <slot />
  </span>
  <label v-else class="block text-sm leading-5 text-gray-700">
    <slot />
  </label>
</template>
