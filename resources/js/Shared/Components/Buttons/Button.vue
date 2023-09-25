<script setup>
import { Inertia, Method } from '@inertiajs/inertia'

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

function redirect(href, method) {
  if (href)
    Inertia.visit(href, {
      method: method,
    })
}
</script>

<template>
  <button type="button" class="rounded-md bg-white px-3 py-2 text-sm font-semibold text-gray-900 hover:bg-gray-50"
          @click="redirect(href, method)"
  >
    <slot />
  </button>
</template>
