<script setup>
defineProps({
  background: String,
})
</script>

<template>
  <div class="m-0.5 flex-none bg-white p-1">
    <div class="size-4 border border-black p-1" :class="background" />
  </div>
</template>
