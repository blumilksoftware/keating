<script setup>
defineProps({
  customTitle: String,
})
</script>

<template>
  <div class="w-full bg-white p-8 text-center sm:rounded-lg">
    <div class="text-sm text-gray-600">
      <p>
        {{ (customTitle ?? 'Brak danych.') }}
      </p>
    </div>
    <slot />
  </div>
</template>
