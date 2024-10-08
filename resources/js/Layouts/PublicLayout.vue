<script setup>
import { ref } from 'vue'
import { Link } from '@inertiajs/inertia-vue3'
import { Dialog, DialogPanel } from '@headlessui/vue'
import { Bars3Icon, EllipsisHorizontalIcon, XMarkIcon, ArrowTopRightOnSquareIcon } from '@heroicons/vue/24/outline'

const navigation = [
  { name: 'Strona główna', href: '/' },
  { name: 'Aktualności', href: '/aktualnosci' },
  { name: 'Kursy i materiały', href: '/kursy' },
  { name: 'Oceny', href: '/oceny' },
  { name: 'FAQ', href: '/faq' },
  { name: 'Kontakt', href: '/kontakt' },
]

const mobileMenuOpen = ref(false)
</script>

<template>
  <div class="flex h-screen flex-col">
    <header class="absolute inset-x-0 top-0 z-50">
      <nav class="flex items-center justify-between p-6 lg:px-8" aria-label="Global">
        <div class="flex lg:hidden">
          <button type="button" class="-m-2.5 inline-flex items-center justify-center rounded-md p-2.5 text-gray-700" @click="mobileMenuOpen = true">
            <span class="sr-only">Otwórz menu</span>
            <Bars3Icon class="size-6" aria-hidden="true" />
          </button>
        </div>
        <div class="hidden lg:flex lg:gap-x-12">
          <Link v-for="item in navigation" :key="item.name" :href="item.href" class="text-sm font-semibold leading-6 text-gray-900">
            {{ item.name }}
          </Link>
          <a v-if="$page.props.settings.scheduleLink" :href="$page.props.settings.scheduleLink" target="_blank" class="flex items-center gap-2 text-sm font-semibold leading-6 text-gray-900">
            Plan zajęć
            <ArrowTopRightOnSquareIcon class="size-5" />
          </a>
        </div>
        <div class="hidden lg:flex lg:flex-1 lg:justify-end">
          <Link v-if="$page.props.auth.user" href="/dashboard" class="text-sm font-semibold leading-6 text-gray-900">
            Dashboard
            <span aria-hidden="true">&rarr;</span>
          </Link>
          <Link v-else href="/login" class="text-sm font-semibold leading-6 text-gray-900">
            Logowanie
            <span aria-hidden="true">&rarr;</span>
          </Link>
        </div>
      </nav>
      <Dialog as="div" class="lg:hidden" :open="mobileMenuOpen" @close="mobileMenuOpen = false">
        <div class="fixed inset-0 z-50" />
        <DialogPanel class="fixed inset-y-0 right-0 z-50 w-full overflow-y-auto bg-white p-6 sm:max-w-sm sm:ring-1 sm:ring-gray-900/10">
          <div class="flex items-center justify-between">
            <button type="button" class="-m-2.5 rounded-md p-2.5 text-gray-700" @click="mobileMenuOpen = false">
              <span class="sr-only">Close menu</span>
              <XMarkIcon class="size-6" aria-hidden="true" />
            </button>
          </div>
          <div class="mt-6 flow-root">
            <div class="-my-6 divide-y divide-gray-500/10">
              <div class="space-y-2 py-6">
                <Link v-for="item in navigation" :key="item.name" :href="item.href" class="-mx-3 block rounded-lg px-3 py-2 text-base font-semibold leading-7 text-gray-900 hover:bg-gray-50">
                  {{ item.name }}
                </Link>
                <a v-if="$page.props.settings.scheduleLink" :href="$page.props.settings.scheduleLink" target="_blank" class="-mx-3 flex items-center gap-2 rounded-lg px-3 py-2 text-base font-semibold leading-7 text-gray-900 hover:bg-gray-50">
                  Plan zajęć
                  <ArrowTopRightOnSquareIcon class="size-5" />
                </a>
              </div>
              <div class="py-6">
                <Link v-if="$page.props.auth.user" href="/dashboard" class="-mx-3 block rounded-lg px-3 py-2.5 text-base font-semibold leading-7 text-gray-900 hover:bg-gray-50">
                  Dashboard
                </Link>
                <Link v-else href="/login" class="-mx-3 block rounded-lg px-3 py-2.5 text-base font-semibold leading-7 text-gray-900 hover:bg-gray-50">
                  Logowanie
                </Link>
              </div>
            </div>
          </div>
        </DialogPanel>
      </Dialog>
    </header>

    <div class="flex-1 bg-white">
      <slot />
    </div>

    <footer class="bg-white">
      <div class="mx-auto max-w-7xl px-6 py-12 md:flex md:items-center md:justify-center lg:px-8">
        <div class="mt-8 md:order-1 md:mt-0">
          <p class="text-center text-xs leading-5 text-gray-500">
            2024
            <EllipsisHorizontalIcon class="mx-2 inline-block w-6" />
            <a class="font-semibold" href="https://github.com/blumilksoftware/keating" target="_blank">keating
              management system</a> developed at <a class="font-semibold" href="https://blumilk.pl/" target="_blank">Blumilk</a>
          </p>
        </div>
      </div>
    </footer>
  </div>
</template>
