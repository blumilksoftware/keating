<script setup>
import PublicLayout from '../../Layouts/PublicLayout.vue'

defineProps({
  title: String,
  name: String,
  department: String,
  university: String,
  universityLogo: String,
  sections: Array,
})
</script>

<template>
  <PublicLayout>
    <div class="relative isolate bg-white pt-14">
      <svg class="absolute inset-0 -z-10 h-full w-full stroke-gray-200 [mask-image:radial-gradient(100%_100%_at_top_right,white,transparent)]" aria-hidden="true">
        <defs>
          <pattern id="83fd4e5a-9d52-42fc-97b6-718e5d7ee527" width="200" height="200" x="50%" y="-1" patternUnits="userSpaceOnUse">
            <path d="M100 200V.5M.5 .5H200" fill="none" />
          </pattern>
        </defs>
        <svg x="50%" y="-1" class="overflow-visible fill-gray-50">
          <path d="M-100.5 0h201v201h-201Z M699.5 0h201v201h-201Z M499.5 400h201v201h-201Z M-300.5 600h201v201h-201Z" stroke-width="0" />
        </svg>
        <rect width="100%" height="100%" stroke-width="0" fill="url(#83fd4e5a-9d52-42fc-97b6-718e5d7ee527)" />
      </svg>
      <div class="mx-auto max-w-7xl px-6 py-24 sm:py-32 lg:flex lg:items-center lg:gap-x-10 lg:px-8 lg:py-40">
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

    <div class="relative isolate bg-gradient-to-r from-gray-50 to-gray-100 py-24 sm:py-32">
      <svg class="absolute inset-0 -z-10 h-full w-full stroke-gray-200 [mask-image:radial-gradient(100%_100%_at_top_left,white,transparent)]" aria-hidden="true">
        <defs>
          <pattern id="83fd4e5a-9d52-42fc-97b6-718e5d7ee527" width="200" height="200" x="50%" y="-1" patternUnits="userSpaceOnUse">
            <path d="M100 200V.5M.5 .5H200" fill="none" />
          </pattern>
        </defs>
        <svg x="50%" y="-1" class="overflow-visible fill-gray-50">
          <path d="M-100.5 0h201v201h-201Z M699.5 0h201v201h-201Z M499.5 400h201v201h-201Z M-300.5 600h201v201h-201Z" stroke-width="0" />
        </svg>
        <rect width="100%" height="100%" stroke-width="0" fill="url(#83fd4e5a-9d52-42fc-97b6-718e5d7ee527)" />
      </svg>
      <div class="mx-auto max-w-7xl px-6 lg:px-8">
        <div class="mx-auto max-w-2xl lg:mx-0">
          <h2 class="text-3xl font-bold tracking-tight text-gray-900 sm:text-4xl">
            O mnie
          </h2>
          <p class="mt-1 text-lg leading-8 text-gray-600">
            Kilka słów o mnie.
          </p>
        </div>
        <div class="mx-auto grid max-w-2xl grid-cols-1 gap-x-8 gap-y-16 pt-10 lg:mx-0 lg:max-w-none lg:grid-cols-3">
          <article v-for="section in sections" :key="section.title" class="flex max-w-xl flex-col items-start justify-between">
            <div class="group relative">
              <h3 class="mt-3 text-lg font-semibold leading-6 text-gray-900 group-hover:text-gray-600">
                {{ section.header }}
              </h3>
              <p v-for="(paragraph, i) in section.paragraphs" :key="i" class="mt-5 text-sm leading-6 text-gray-600">
                {{ paragraph }}
              </p>
            </div>
          </article>
        </div>
      </div>
    </div>
  </PublicLayout>
</template>
