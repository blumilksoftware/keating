<script setup>
import { computed, ref } from 'vue'

const props = defineProps({ status: Number })

const title = computed(() => {
  return {
    401: 'Błąd 401',
    403: 'Błąd 403',
    404: 'Błąd 404',
    419: 'Błąd 419',
    429: 'Błąd 429',
    500: 'Błąd 500',
    503: 'Błąd 503',
  }[props.status]
})

const isLightTheme = ref(false)

window.matchMedia('(prefers-color-scheme: light)').addEventListener('change', e => {
  isLightTheme.value = e.matches ?? false
})
</script>

<template>
  <div class="flex min-h-screen flex-col items-center justify-center bg-gray-100">
    <div v-if="isLightTheme" class="flex flex-col items-center">
      <img src="/baby-yoda.png"
           alt="Baby yoda"
           class="mb-8 ml-16 w-72 sm:ml-28 sm:w-96"
      >
      <h1 class="mb-2 text-3xl font-bold uppercase text-gray-600">
        {{ title }}
      </h1>
      <p class="mb-8 text-center text-xl text-gray-700">
        Niech Moc będzie z Tobą.
      </p>
      <InertiaLink
        href="/"
        class="text-md rounded-md bg-white px-4 py-3 font-semibold text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 hover:bg-gray-50"
      >
        Wróć do strony głównej
      </InertiaLink>
    </div>
    <div v-else class="flex flex-col items-center">
      <img src="/darth-vader.png"
           alt="Darth Vader"
           class="mb-16 w-96 px-4 sm:w-1/2 sm:px-0"
      >
      <h1 class="mb-4 text-3xl font-bold uppercase text-gray-600">
        {{ title }}
      </h1>
      <p class="mb-8 px-4 text-center text-xl text-gray-700 sm:px-0">
        Nigdy nie lekceważ potęgi Ciemnej Strony Mocy.
      </p>
      <InertiaLink
        class="text-md rounded-md bg-gray-800 px-4 py-3 font-semibold text-gray-100 shadow-sm hover:bg-black"
        href="/"
      >
        Wróć do strony głównej
      </InertiaLink>
    </div>
  </div>
</template>
