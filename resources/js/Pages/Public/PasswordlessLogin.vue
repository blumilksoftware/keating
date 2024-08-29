<script setup>
import PublicLayout from '@/Layouts/PublicLayout.vue'
import BackgroundGrid from '@/Components/BackgroundGrid.vue'
import { Head, useForm } from '@inertiajs/inertia-vue3'
import { ref } from 'vue'
import axios from 'axios'
import { onBeforeUnmount } from 'vue'
import { Inertia } from '@inertiajs/inertia'

defineProps({
  university: String,
  universityLogo: String,
})

const loginForm = useForm({
  email: '',
})
const interval = ref(0)

function attemptLogin() {
  loginForm.post('/passwordless', {
    preserveState: true,
    onSuccess: () => {
      interval.value = setInterval(checkLogin, 5000)
    },
  })
}

async function checkLogin() {
  return axios.post(`/passwordless/check/${loginForm.email}`)
    .then(response => {
      if (response.status === 200) {
        Inertia.visit('/dashboard')
      }
    })
}

onBeforeUnmount(() => {
  if (interval.value) {
    clearInterval(interval.value)
  }
})
</script>

<template>
  <Head title="Logowanie bez hasła" />

  <PublicLayout>
    <div class="relative isolate bg-white pt-14">
      <BackgroundGrid />
      <img alt="" class="pointer-events-none absolute right-0 z-0 hidden w-1/2 opacity-10 lg:mt-16 lg:block xl:mt-10 2xl:mt-0"
           src="/cwup.png"
      >
      <div class="mx-auto max-w-7xl px-6 py-24 sm:py-32 lg:flex lg:items-center lg:gap-x-10 lg:px-8 lg:py-40">
        <div class="mx-auto max-w-7xl text-center lg:mx-0 lg:flex-auto">
          <img :alt="university" :src="universityLogo" class="mx-auto w-[360px]">
          <div class="sm:mx-auto sm:w-full sm:max-w-[480px]">
            <div class="px-6 py-7 sm:px-12">
              <form class="z-10 space-y-6" @submit.prevent="attemptLogin">
                <div v-if="$page.props.flash.success"
                     class="text-wb-grey-80 rounded-md border border-blue-200 bg-blue-100 px-4 py-3 text-center text-sm"
                >
                  {{ $page.props.flash.success }}
                </div>
                <div v-if="loginForm.errors.email"
                     class="bg-wb-red-10 border-wb-red-20 text-wb-grey-80 rounded-md border px-4 py-3 text-center text-sm"
                >
                  {{ loginForm.errors.email }}
                </div>
                <div>
                  <label class="block text-sm font-medium leading-6 text-gray-900" for="email">Email</label>
                  <div class="mt-2">
                    <input id="email" v-model="loginForm.email" autocomplete="email" class="top block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-black sm:text-sm sm:leading-6" name="email" required
                           type="email"
                    >
                  </div>
                </div>
                <div>
                  <button class="flex w-full justify-center rounded-md bg-black px-3 py-1.5 text-sm font-semibold leading-6 text-white shadow-sm focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2"
                          type="submit"
                  >
                    Zaloguj się adresem e-mail
                  </button>
                </div>
              </form>
              <div>
                <InertiaLink class="mt-3 flex w-full justify-center rounded-md bg-black px-3 py-1.5 text-sm font-semibold leading-6 text-white shadow-sm focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2"
                             href="/login"
                >
                  Powrót do zwykłego logowania
                </InertiaLink>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </PublicLayout>
</template>
