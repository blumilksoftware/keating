<script setup>
defineProps({
  pagination: Object,
})
</script>

<template>
  <div class="mx-auto flex items-center justify-center lg:justify-between">
    <nav class="flex flex-wrap justify-center space-x-1">
      <template v-for="(link, index) in pagination.links" :key="index">
        <Component :is="link.url ? 'InertiaLink' : 'span'" :href="link.url" :preserve-scroll="true"
                   class="rounded-brand-button rounded border border-gray-200 px-4 py-2 text-sm"
                   :class="{ 'h-9.5 hover:bg-gray-200 focus:outline-none focus:ring-2 focus:ring-offset-1': link.url, 'bg-white': link.active }"
        >
          {{ link.label }}
        </Component>
      </template>
    </nav>
  </div>
</template>
