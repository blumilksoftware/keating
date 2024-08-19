<script setup>

defineProps({
  pagination: Object,
})
</script>

<template>
  <nav class="relative flex justify-center">
    <template v-for="link in pagination.links" :key="link.label">
      <InertiaLink
        preserve-scroll
        :href="link.url ?? ''"
        class="flex items-center justify-center rounded-lg px-3 py-2 text-sm text-gray-600"
        :class="{ 'bg-gray-200': link.active, '!text-gray-300': !link.url }"
      >
        {{ link.label }}
      </InertiaLink>
    </template>
  </nav>
</template>
