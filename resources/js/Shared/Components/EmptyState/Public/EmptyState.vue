<script lang="ts" setup>
import { NoSymbolIcon } from '@heroicons/vue/24/outline'

defineProps({
  description: String,
})
</script>

<template>
  <div class="text-center">
    <NoSymbolIcon class="mx-auto size-12 text-gray-400" />
    <h3 class="mt-2 text-sm font-semibold text-gray-900">
      {{ description }}
    </h3>
  </div>
</template>
