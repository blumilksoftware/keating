<script setup>
import { Method } from '@inertiajs/inertia'
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
    default: Method.GET,
  },
})
</script>

<template>
  <Button class="bg-gray-700 text-white hover:bg-gray-600 focus:ring-gray-700" :disabled="disabled" :href="href" :method="method">
    <slot />
  </Button>
</template>
