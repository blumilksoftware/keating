<script setup>
defineProps({
  contact: Object,
})

const isMailable = (contact) => {
  return contact.identifier.includes('@')
}
</script>

<template>
  <div class="text-left">
    <label class="text-sm">
      {{ contact.label }}
    </label>
    <a v-if="isMailable(contact)"
       :href="'mailto:' + contact.identifier"
       class="flex w-full items-center justify-center text-center text-xl font-bold tracking-tight text-gray-900 sm:text-2xl"
    >
      {{ contact.identifier }}
    </a>
    <a v-else
       :href="contact.identifier"
       class="flex w-full items-center justify-center text-center text-xl font-bold tracking-tight text-gray-900 sm:text-2xl"
       target="_blank"
    >
      {{ contact.identifier }}
    </a>
  </div>
</template>
