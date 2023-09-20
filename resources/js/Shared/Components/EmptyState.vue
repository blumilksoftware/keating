<script setup>
defineProps({
  customTitle: String,
})
</script>

<template>
  <div class="w-full bg-white py-16 text-center sm:rounded-lg">
    <slot />
    <div class="mt-2 text-gray-600">
      <p>
        {{ (customTitle ?? 'Brak danych') }}
      </p>
    </div>
  </div>
</template>
