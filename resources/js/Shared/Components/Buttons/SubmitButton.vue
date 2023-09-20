<script setup>
import Button from '@/Shared/Components/Buttons/Button.vue'

defineProps({
  disabled: {
    type: Boolean,
    default: false,
  },
  href: {
    type: String,
    default: null,
  },
  method: {
    type: String,
    default: null,
  },
})
</script>

<template>
  <Button type="submit" :disabled="disabled" :href="href" :method="method">
    <slot />
  </Button>
</template>
