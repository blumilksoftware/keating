<script setup>
import { ref } from 'vue'
import { Dialog, DialogPanel, TransitionChild, TransitionRoot } from '@headlessui/vue'
import {
  Bars3Icon,
  ClockIcon,
  BriefcaseIcon,
  HomeIcon,
  PowerIcon,
  QuestionMarkCircleIcon,
  NewspaperIcon,
  XMarkIcon,
  AtSymbolIcon,
  UsersIcon,
  BookmarkSquareIcon,
  MagnifyingGlassIcon,
  ClipboardIcon,
  CodeBracketSquareIcon,
  Cog6ToothIcon,
  LockOpenIcon,
} from '@heroicons/vue/24/outline'
import { watch } from 'vue'
import { useToast } from 'vue-toastification'

const toast = useToast()
const props = defineProps({
  flash: {
    type: Object,
    default () {
      return Object
    },
  },
})

const navigation = [
  {
    title: 'Ogólne',
    elements: [
      { name: 'Dashboard', href: '/dashboard', icon: HomeIcon, current: true },
      { name: 'Ustawienia', href: '#', icon: Cog6ToothIcon, current: false },
      { name: 'Aktualizacja hasła', href: '/dashboard/password', icon: LockOpenIcon, current: false },
      { name: 'Aktualności', href: '#', icon: NewspaperIcon, current: false },
      { name: 'FAQ', href: '#', icon: QuestionMarkCircleIcon, current: false },
      { name: 'Formy kontaktu', href: '/dashboard/contact-infos', icon: AtSymbolIcon, current: false },
    ],
  },
  {
    title: 'Uczelnia',
    elements: [
      { name: 'Studenci', href: '/dashboard/students', icon: UsersIcon, current: false },
      { name: 'Kursy w semestrze', href: '#', icon: BookmarkSquareIcon, current: false },
    ],
  },
  {
    title: 'Słowniki',
    elements: [
      { name: 'Kursy', href: '#', icon: BriefcaseIcon, current: false },
      { name: 'Kierunki i specjalności', href: '#', icon: MagnifyingGlassIcon, current: false },
      { name: 'Semestry', href: '#', icon: ClipboardIcon, current: false },
      { name: 'Formy zajęć', href: '#', icon: CodeBracketSquareIcon, current: false },
      { name: 'Tryby studiów', href: '#', icon: ClockIcon, current: false },
    ],
  },
]

const sidebarOpen = ref(false)

watch(() => props.flash, (flash) => {
  if (!flash) {
    return
  }

  if (flash.success) {
    toast.success(flash.success)
  }

  if (flash.info) {
    toast.info(flash.info)
  }

  if (flash.error) {
    toast.error(flash.error)
  }
}, { immediate: true })
</script>

<template>
  <div>
    <TransitionRoot as="template" :show="sidebarOpen">
      <Dialog as="div" class="relative z-50 lg:hidden" @close="sidebarOpen = false">
        <TransitionChild as="template" enter="transition-opacity ease-linear duration-300" enter-from="opacity-0" enter-to="opacity-100" leave="transition-opacity ease-linear duration-300" leave-from="opacity-100" leave-to="opacity-0">
          <div class="fixed inset-0 bg-gray-900/80" />
        </TransitionChild>

        <div class="fixed inset-0 flex">
          <TransitionChild as="template" enter="transition ease-in-out duration-300 transform" enter-from="-translate-x-full" enter-to="translate-x-0" leave="transition ease-in-out duration-300 transform" leave-from="translate-x-0" leave-to="-translate-x-full">
            <DialogPanel class="relative mr-16 flex w-full max-w-xs flex-1">
              <TransitionChild as="template" enter="ease-in-out duration-300" enter-from="opacity-0" enter-to="opacity-100" leave="ease-in-out duration-300" leave-from="opacity-100" leave-to="opacity-0">
                <div class="absolute left-full top-0 flex w-16 justify-center pt-5">
                  <button type="button" class="-m-2.5 p-2.5" @click="sidebarOpen = false">
                    <span class="sr-only">Close sidebar</span>
                    <XMarkIcon class="h-6 w-6 text-white" aria-hidden="true" />
                  </button>
                </div>
              </TransitionChild>
              <!-- Sidebar component, swap this element with another sidebar if you like -->
              <div class="flex grow flex-col gap-y-5 overflow-y-auto bg-white px-6 pb-2">
                <nav class="mt-6 flex flex-1 flex-col">
                  <ul role="list" class="flex flex-1 flex-col gap-y-7">
                    <li v-for="(section, i) in navigation" :key="i">
                      <div class="text-xs font-semibold leading-6 text-gray-400">
                        {{ section.title }}
                      </div>
                      <ul role="list" class="-mx-2 space-y-1">
                        <li v-for="item in section.elements" :key="item.name">
                          <InertiaLink :href="item.href" :class="[item.current ? 'bg-gray-50 text-sky-600' : 'text-gray-700 hover:bg-gray-50 hover:text-sky-600', 'group flex gap-x-3 rounded-md p-2 text-sm font-semibold leading-6']">
                            <component :is="item.icon" :class="[item.current ? 'text-sky-600' : 'text-gray-400 group-hover:text-sky-600', 'h-6 w-6 shrink-0']" aria-hidden="true" />
                            {{ item.name }}
                          </InertiaLink>
                        </li>
                      </ul>
                    </li>
                  </ul>
                </nav>
              </div>
            </DialogPanel>
          </TransitionChild>
        </div>
      </Dialog>
    </TransitionRoot>

    <!-- Static sidebar for desktop -->
    <div class="hidden lg:fixed lg:inset-y-0 lg:z-50 lg:flex lg:w-72 lg:flex-col">
      <div class="flex grow flex-col gap-y-5 overflow-y-auto border-r border-gray-200 bg-white px-6">
        <nav class="mt-5 flex flex-1 flex-col">
          <ul role="list" class="flex flex-1 flex-col gap-y-7">
            <li v-for="(section, i) in navigation" :key="i">
              <div class="mb-2 text-xs font-semibold leading-6 text-gray-400">
                {{ section.title }}
              </div>
              <ul role="list" class="-mx-2 space-y-1">
                <li v-for="item in section.elements" :key="item.name">
                  <InertiaLink :href="item.href" :class="[item.current ? 'bg-gray-50 text-sky-600' : 'text-gray-700 hover:bg-gray-50 hover:text-sky-600', 'group flex gap-x-3 rounded-md p-2 text-sm font-semibold leading-6']">
                    <component :is="item.icon" :class="[item.current ? 'text-sky-600' : 'text-gray-400 group-hover:text-sky-600', 'h-6 w-6 shrink-0']" aria-hidden="true" />
                    {{ item.name }}
                  </InertiaLink>
                </li>
              </ul>
            </li>
            <li class="-mx-6 mb-3 mt-auto">
              <InertiaLink href="/" class="flex items-center gap-x-4 px-6 py-3 text-sm font-semibold leading-6 text-gray-900 hover:bg-gray-50">
                <HomeIcon class="h-6 w-6 text-gray-700" title="Strona główna" />
                <span aria-hidden="true">Strona główna</span>
              </InertiaLink>
              <InertiaLink href="/dashboard/logout" method="post" as="button" class="flex items-center gap-x-4 px-6 py-3 text-sm font-semibold leading-6 text-gray-900 hover:bg-gray-50">
                <PowerIcon class="h-6 w-6 text-gray-700" title="Wyloguj się" />
                <span aria-hidden="true">Wyloguj się</span>
              </InertiaLink>
            </li>
          </ul>
        </nav>
      </div>
    </div>

    <div class="sticky top-0 z-40 flex items-center gap-x-6 bg-white p-4 shadow-sm sm:px-6 lg:hidden">
      <button type="button" class="-m-2.5 p-2.5 text-gray-700 lg:hidden" @click="sidebarOpen = true">
        <span class="sr-only">Open sidebar</span>
        <Bars3Icon class="h-6 w-6" aria-hidden="true" />
      </button>
      <div class="flex-1 text-sm font-semibold leading-6 text-gray-900">
        Dashboard
      </div>
      <InertiaLink href="/">
        <span class="sr-only">Strona główna</span>
        <HomeIcon class="h-6 w-6 text-gray-700" title="Strona główna" />
      </InertiaLink>
      <InertiaLink href="/dashboard/logout" method="post" as="button">
        <span class="sr-only">Wyloguj się</span>
        <PowerIcon class="h-6 w-6 text-gray-700" title="Wyloguj się" />
      </InertiaLink>
    </div>

    <main class="py-10 lg:pl-72">
      <div class="px-4 sm:px-6 lg:px-8">
        <slot />
      </div>
    </main>
  </div>
</template>
