<script setup>
import PublicLayout from '@/Layouts/PublicLayout.vue'
import {
  EnvelopeIcon,
} from '@heroicons/vue/24/outline'
import BackgroundGrid from '@/Components/BackgroundGrid.vue'
import SectionHeader from '@/Components/SectionHeader.vue'
import DOMPurify from 'dompurify'

defineProps({
  title: String,
  name: String,
  email: String,
  department: String,
  university: String,
  universityLogo: String,
  sectionSettings: Object,
  about: Array,
  counters: Array,
})
</script>

<template>
  <PublicLayout>
    <div v-if="sectionSettings.banner_enabled" class="relative isolate bg-white pt-14">
      <BackgroundGrid />
      <img src="/cwup.png" alt="" class="absolute right-0 hidden w-[50%] opacity-10 lg:mt-16 lg:block xl:mt-10 2xl:mt-0">
      <div class="mx-auto max-w-7xl px-6 py-24 sm:py-32 lg:flex lg:items-center lg:gap-x-10 lg:px-8 lg:py-32">
        <div class="mx-auto max-w-7xl text-center lg:mx-0 lg:flex-auto">
          <h1 class="mx-auto mt-10 max-w-4xl text-4xl font-bold tracking-tight text-gray-900 sm:text-6xl">
            <span class="font-normal">{{ title }}</span>
            {{ name }}
          </h1>
          <p class="mt-12 text-lg text-gray-600">
            {{ department }}
          </p>
          <p class="text-lg text-gray-600">
            {{ university }}
          </p>
          <img :src="universityLogo" :alt="university" class="mx-auto w-[360px]">
        </div>
      </div>
    </div>
    <div v-if="sectionSettings.about_enabled && about.length" class="relative isolate bg-gradient-to-r from-gray-50 to-gray-100 py-24 sm:py-32">
      <BackgroundGrid mask-direction="left" />
      <div class="mx-auto max-w-7xl px-6 lg:px-8">
        <SectionHeader>
          <template #header>
            O mnie
          </template>
          <template #subheader>
            Kilka słów o mnie.
          </template>
        </SectionHeader>
        <div
          class="mx-auto grid max-w-2xl grid-cols-1 gap-x-8 gap-y-16 pt-10 lg:mx-0 lg:max-w-none lg:grid-cols-3"
        >
          <article v-for="section in about" :key="section.id"
                   class="flex max-w-xl flex-col items-start justify-between"
          >
            <div class="group relative">
              <h3 class="mt-3 text-lg font-semibold leading-6 text-gray-900">
                {{ section.title }}
              </h3>
              <!-- eslint-disable vue/no-v-html -->
              <div class="mt-5 text-sm leading-6 text-gray-600 prose" v-html="DOMPurify.sanitize(section.value)" />
              <!-- eslint-enable -->
            </div>
          </article>
        </div>
      </div>
    </div>

    <div v-if="sectionSettings.counters_enabled && counters.length" class="relative isolate overflow-hidden bg-gray-900 py-24 sm:py-32">
      <img
        src="https://images.unsplash.com/photo-1542831371-29b0f74f9713?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxzZWFyY2h8M3x8cHJvZ3JhbW1pbmd8ZW58MHx8MHx8fDA%3D&auto=format&fit=crop&w=2850&q=80&blend=111827&blend-mode=multiply&sat=-100&exp=15"
        alt="" class="absolute inset-0 -z-10 h-full w-full object-cover"
      >
      <div class="relative mx-auto max-w-7xl px-6 lg:px-8">
        <dl
          class="mx-auto grid max-w-2xl grid-cols-1 gap-x-8 gap-y-10 text-white sm:grid-cols-2 sm:gap-y-16 lg:mx-0 lg:max-w-none lg:grid-cols-4"
        >
          <div v-for="counter in counters" :key="counter.id" class="flex flex-col gap-y-3 border-l border-white pl-6">
            <dt class="text-sm text-white prose" v-html="counter.value" />
            <dd class="order-first text-5xl font-semibold tracking-tight">
              {{ counter.title }}
            </dd>
          </div>
        </dl>
      </div>
    </div>

    <div v-if="sectionSettings.contact_enabled" class="relative isolate bg-white py-24 sm:py-32">
      <BackgroundGrid />
      <div class="mx-auto max-w-7xl px-6 xl:grid xl:grid-cols-2 xl:px-8">
        <SectionHeader>
          <template #header>
            Kontakt
          </template>
          <template #subheader>
            Więcej szczegółów w zakładce Kontakt.
          </template>
        </SectionHeader>
        <div class="mx-auto flex max-w-2xl py-12 xl:mx-0 xl:py-0">
          <a :href="'mailto:' + email" class="flex w-full items-center justify-center text-center text-xl font-bold tracking-tight text-gray-900 sm:text-2xl">
            <EnvelopeIcon class="mr-2 w-12" />
            {{ email.split('@')[0] }}<span class="font-normal">@{{ email.split('@')[1] }}</span>
          </a>
        </div>
      </div>
    </div>
  </PublicLayout>
</template>
