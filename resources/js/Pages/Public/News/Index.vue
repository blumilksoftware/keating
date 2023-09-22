<script setup>
import PublicLayout from '@/Layouts/PublicLayout.vue'
import BackgroundGrid from '../../../Components/BackgroundGrid.vue'
import SectionHeader from '../../../Components/SectionHeader.vue'

defineProps({
  paginator: Object,
})
</script>

<template>
  <PublicLayout>
    <div class="relative isolate bg-white">
      <BackgroundGrid />
      <div class="py-24 sm:py-32">
        <div class="mx-auto max-w-7xl px-6 lg:px-8">
          <SectionHeader>
            <template #header>
              Aktualności
            </template>
            <template #subheader>
              Ostatnie wiadomości opublikowane w systemie.
            </template>
          </SectionHeader>

          <div class="mx-auto mt-10 grid max-w-2xl grid-cols-1 gap-x-8 gap-y-16 border-t border-gray-200 pt-10 sm:mt-16 sm:pt-16 lg:mx-0 lg:max-w-none lg:grid-cols-3">
            <article v-for="post in paginator.data" :key="post.id" class="flex max-w-xl flex-col items-start justify-between">
              <div class="flex items-center gap-x-4 text-xs">
                <time :datetime="post.published_at" class="text-gray-500">{{ post.published_at }}</time>
              </div>
              <div class="group relative">
                <h3 class="mt-3 text-lg font-semibold leading-6 text-gray-900 group-hover:text-gray-600">
                  <a :href="'aktualnosci/' + post.slug">
                    <span class="absolute inset-0" />
                    {{ post.title }}
                  </a>
                </h3>
                <p class="mt-5 line-clamp-3 text-sm leading-6 text-gray-600">
                  {{ post.content }}
                </p>
              </div>
            </article>
          </div>
        </div>
      </div>
    </div>
  </PublicLayout>
</template>
