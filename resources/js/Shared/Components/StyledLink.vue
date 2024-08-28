<script setup>
import { Method } from '@inertiajs/inertia'

defineProps({
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
  <InertiaLink
    :href="href"
    :method="method"
    class="rounded-md bg-white px-3 py-2 text-sm font-semibold text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 hover:bg-gray-50"
  >
    <slot />
  </InertiaLink>
</template>
