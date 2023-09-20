<script setup>
import PublicLayout from '../../Layouts/PublicLayout.vue'
import { useForm } from '@inertiajs/inertia-vue3'

defineProps({
  universityLogo: String,
})

const loginForm = useForm({
  email: '',
  password: '',
})

function attemptLogin() {
  loginForm.post('/login')
}
</script>

<template>
  <PublicLayout>
    <div class="relative isolate bg-white pt-14">
      <svg
        class="absolute inset-0 -z-10 h-full w-full stroke-gray-200 [mask-image:radial-gradient(100%_100%_at_top_right,white,transparent)]"
        aria-hidden="true"
      >
        <defs>
          <pattern id="83fd4e5a-9d52-42fc-97b6-718e5d7ee527" width="200" height="200" x="50%" y="-1"
                   patternUnits="userSpaceOnUse"
          >
            <path d="M100 200V.5M.5 .5H200" fill="none" />
          </pattern>
        </defs>
        <svg x="50%" y="-1" class="overflow-visible fill-gray-50">
          <path
            d="M-100.5 0h201v201h-201Z M699.5 0h201v201h-201Z M499.5 400h201v201h-201Z M-300.5 600h201v201h-201Z"
            stroke-width="0"
          />
        </svg>
        <rect width="100%" height="100%" stroke-width="0" fill="url(#83fd4e5a-9d52-42fc-97b6-718e5d7ee527)" />
      </svg>
      <div class="mx-auto max-w-7xl px-6 py-24 sm:py-32 lg:flex lg:items-center lg:gap-x-10 lg:px-8 lg:py-40">
        <div class="mx-auto max-w-7xl text-center lg:mx-0 lg:flex-auto">
          <img :src="universityLogo" :alt="university" class="mx-auto w-[360px]">
          <div class="sm:mx-auto sm:w-full sm:max-w-[480px]">
            <div class="px-6 py-9 sm:px-12">
              <form
                class="space-y-6"
                @submit.prevent="attemptLogin"
              >
                <div
                  v-if="loginForm.errors.email"
                  class="bg-wb-red-10 border-wb-red-20 text-wb-grey-80 rounded-md border px-4 py-3 text-center text-sm"
                >
                  {{ loginForm.errors.email }}
                </div>
                <div>
                  <label for="email"
                         class="block text-sm font-medium leading-6 text-gray-900"
                  >Email</label>
                  <div class="mt-2">
                    <input id="email" v-model="loginForm.email" name="email" type="email" autocomplete="email" required
                           class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-black sm:text-sm sm:leading-6"
                    >
                  </div>
                </div>
                <div>
                  <label for="password" class="block text-sm font-medium leading-6 text-gray-900">Hasło</label>
                  <div class="mt-2">
                    <input id="password" v-model="loginForm.password" name="password" type="password"
                           class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-black sm:text-sm sm:leading-6"
                    >
                  </div>
                </div>
                <div>
                  <button type="submit"
                          class="flex w-full justify-center rounded-md bg-black px-3 py-1.5 text-sm font-semibold leading-6 text-white shadow-sm focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2"
                  >
                    Zaloguj się
                  </button>
                </div>
              </form>
            </div>
          </div>
        </div>
      </div>
    </div>
  </PublicLayout>
</template>
