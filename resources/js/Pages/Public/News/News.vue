<script setup>
import PublicLayout from '@/Layouts/PublicLayout.vue'
import BackgroundGrid from '../../../Components/BackgroundGrid.vue'
import SectionHeader from '../../../Components/SectionHeader.vue'

defineProps({
  news: Object,
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
              {{ news.title }}
            </template>
            <template #subheader>
              wiadomość z dnia {{ news.published_at }}
            </template>
          </SectionHeader>

          <div class="mt-10" v-html="news.content"></div>
        </div>
      </div>
    </div>
  </PublicLayout>
</template>
