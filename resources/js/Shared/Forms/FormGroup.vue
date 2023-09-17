<script setup>
defineProps({
  fullWidth: {
    type: Boolean,
    default: true,
  },
})
</script>

<template>
  <div :class="[fullWidth ? 'w-full' : 'max-w-md', 'items-center space-y-2 p-4']">
    <slot />
  </div>
</template>
