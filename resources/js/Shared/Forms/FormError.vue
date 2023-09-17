<script setup>
defineProps({
  error: {
    type: String,
    default: '',
  },
})
</script>

<template>
  <p v-if="error" class="text-xs leading-5 text-red-500">
    {{ '* ' + error }}
  </p>
</template>
