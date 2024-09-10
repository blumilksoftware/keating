<script setup>
import PublicLayout from '@/Layouts/PublicLayout.vue'
import BackgroundGrid from '@/Components/BackgroundGrid.vue'
import SectionHeader from '@/Components/SectionHeader.vue'
import { Head } from '@inertiajs/inertia-vue3'
import DOMPurify from 'dompurify'

defineProps({
  news: Object,
})
</script>

<template>
  <Head :title="news.title + ' - Aktualności'" />

  <PublicLayout>
    <div class="relative isolate bg-white">
      <BackgroundGrid />
      <div class="py-24 sm:py-32">
        <div class="mx-auto max-w-7xl px-6 lg:px-8">
          <SectionHeader>
            <template #header>
              {{ news.title }}
            </template>
            <template #subheader>
              wiadomość z dnia {{ news.published_at }}
            </template>
          </SectionHeader>
          <!-- eslint-disable vue/no-v-html -->
          <div class="mt-10" v-html="DOMPurify.sanitize(news.content)" />
          <!-- eslint-enable vue/no-v-html -->
        </div>
      </div>
    </div>
  </PublicLayout>
</template>
