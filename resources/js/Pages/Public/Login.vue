<script setup>
import PublicLayout from '@/Layouts/PublicLayout.vue'
import BackgroundGrid from '@/Components/BackgroundGrid.vue'
import { useForm } from '@inertiajs/inertia-vue3'

defineProps({
  university: String,
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
      <BackgroundGrid />
      <img src="/cwup.png" alt="" class="absolute right-0 z-0 hidden w-[50%] opacity-10 lg:mt-16 lg:block xl:mt-10 2xl:mt-0">
      <div class="mx-auto max-w-7xl px-6 py-24 sm:py-32 lg:flex lg:items-center lg:gap-x-10 lg:px-8 lg:py-40">
        <div class="mx-auto max-w-7xl text-center lg:mx-0 lg:flex-auto">
          <img :src="universityLogo" :alt="university" class="mx-auto w-[360px]">
          <div class="sm:mx-auto sm:w-full sm:max-w-[480px]">
            <div class="px-6 py-7 sm:px-12">
              <form
                class="space-y-6 z-10"
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
                           class="block w-full top rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-black sm:text-sm sm:leading-6"
                    >
                  </div>
                </div>
                <div>
                  <label for="password" class="block text-sm font-medium leading-6 text-gray-900">Hasło</label>
                  <div class="mt-2">
                    <input id="password" v-model="loginForm.password" name="password" type="password"
                           class="block w-full z-50 rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-black sm:text-sm sm:leading-6"
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
