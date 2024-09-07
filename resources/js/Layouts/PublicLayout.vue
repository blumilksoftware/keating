<script setup>
import { ref } from 'vue'
import { Link, usePage } from '@inertiajs/inertia-vue3'
import { Dialog, DialogPanel } from '@headlessui/vue'
import { Bars3Icon, EllipsisHorizontalIcon, XMarkIcon } from '@heroicons/vue/24/outline'

const sections = usePage().props.value.sections
const navigation = [
  { name: 'Strona główna', href: '/', enabled: true },
  { name: 'Aktualności', href: '/aktualnosci', enabled: true },
  { name: 'Kursy i materiały', href: '/kursy', enabled: true },
  { name: 'Oceny', href: '/oceny', enabled: true },
  { name: 'FAQ', href: '/faq', enabled: true },
  { name: 'Kontakt', href: '/kontakt', enabled: sections.contact_enabled },
]

const mobileMenuOpen = ref(false)
</script>

<template>
  <div class="flex h-screen flex-col">
    <header class="absolute inset-x-0 top-0 z-50">
      <nav aria-label="Global" class="flex items-center justify-between p-6 lg:px-8">
        <div class="flex lg:hidden">
          <button class="-m-2.5 inline-flex items-center justify-center rounded-md p-2.5 text-gray-700" type="button"
                  @click="mobileMenuOpen = true"
          >
            <span class="sr-only">Otwórz menu</span>
            <Bars3Icon aria-hidden="true" class="size-6" />
          </button>
        </div>
        <div class="hidden lg:flex lg:gap-x-12">
          <span v-for="item in navigation" :key="item.name">
            <Link v-if="item.enabled" :href="item.href" class="text-sm font-semibold leading-6 text-gray-900">
              {{ item.name }}
            </Link>
          </span>
        </div>
        <div class="hidden lg:flex lg:flex-1 lg:justify-end">
          <Link v-if="$page.props.auth.user" class="text-sm font-semibold leading-6 text-gray-900" href="/dashboard">
            Dashboard
            <span aria-hidden="true">&rarr;</span>
          </Link>
          <Link v-else class="text-sm font-semibold leading-6 text-gray-900" href="/login">
            Logowanie
            <span aria-hidden="true">&rarr;</span>
          </Link>
        </div>
      </nav>
      <Dialog :open="mobileMenuOpen" as="div" class="lg:hidden" @close="mobileMenuOpen = false">
        <div class="fixed inset-0 z-50" />
        <DialogPanel
          class="fixed inset-y-0 right-0 z-50 w-full overflow-y-auto bg-white p-6 sm:max-w-sm sm:ring-1 sm:ring-gray-900/10"
        >
          <div class="flex items-center justify-between">
            <button class="-m-2.5 rounded-md p-2.5 text-gray-700" type="button" @click="mobileMenuOpen = false">
              <span class="sr-only">Close menu</span>
              <XMarkIcon aria-hidden="true" class="size-6" />
            </button>
          </div>
          <div class="mt-6 flow-root">
            <div class="-my-6 divide-y divide-gray-500/10">
              <div class="space-y-2 py-6">
                <span v-for="item in navigation" :key="item.name">
                  <Link v-if="item.enabled" :key="item.name" :href="item.href"
                        class="-mx-3 block rounded-lg px-3 py-2 text-base font-semibold leading-7 text-gray-900 hover:bg-gray-50"
                  >
                    {{ item.name }}
                  </Link>
                </span>
              </div>
              <div class="py-6">
                <Link v-if="$page.props.auth.user" class="-mx-3 block rounded-lg px-3 py-2.5 text-base font-semibold leading-7 text-gray-900 hover:bg-gray-50"
                      href="/dashboard"
                >
                  Dashboard
                </Link>
                <Link v-else class="-mx-3 block rounded-lg px-3 py-2.5 text-base font-semibold leading-7 text-gray-900 hover:bg-gray-50"
                      href="/login"
                >
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
            2023
            <EllipsisHorizontalIcon class="mx-2 inline-block w-6" />
            <a class="font-semibold" href="https://github.com/blumilksoftware/keating" target="_blank">keating
              management system</a> developed at <a class="font-semibold" href="https://blumilk.pl/" target="_blank">Blumilk</a>
          </p>
        </div>
      </div>
    </footer>
  </div>
</template>
