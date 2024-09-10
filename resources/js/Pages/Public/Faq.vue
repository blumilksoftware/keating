<script setup>
import PublicLayout from '@/Layouts/PublicLayout.vue'
import BackgroundGrid from '@/Components/BackgroundGrid.vue'
import SectionHeader from '@/Components/SectionHeader.vue'
import { QuestionMarkCircleIcon } from '@heroicons/vue/24/outline'
import { Head } from '@inertiajs/inertia-vue3'
import DOMPurify from 'dompurify'
import EmptyState from '@/Shared/Components/EmptyState/Public/EmptyState.vue'

defineProps({
  faqs: Object,
})
</script>

<template>
  <Head title="FAQ" />

  <PublicLayout>
    <div class="relative isolate bg-white">
      <BackgroundGrid />
      <div class="py-24 sm:py-32">
        <div class="mx-auto max-w-7xl px-6 lg:px-8">
          <SectionHeader>
            <template #header>
              FAQ
            </template>
            <template #subheader>
              Często zadawane pytania i odpowiedzi na nie.
            </template>
          </SectionHeader>

          <div class="mx-auto mt-10 grid max-w-2xl grid-cols-1 gap-x-8 border-t border-gray-200 pt-10 sm:mt-16 sm:pt-16 lg:mx-0 lg:max-w-none">
            <div v-for="(faq, index) in faqs" :key="index" class="mb-5 border-b-2 pb-5">
              <div class="flex items-center justify-between text-lg font-semibold text-gray-600">
                <div class="flex w-[90%] items-center gap-2">
                  <QuestionMarkCircleIcon class="size-7" />
                  <span>{{ faq.question }}</span>
                </div>
              </div>
              <div class="text-md flex items-center justify-between bg-white px-4 pt-3 font-normal text-gray-600">
                <!-- eslint-disable vue/no-v-html -->
                <p class="prose max-w-full text-gray-600" v-html="DOMPurify.sanitize(faq.answer)" />
                <!-- eslint-enable vue/no-v-html -->
              </div>
            </div>

            <EmptyState v-if="faqs.length === 0" description="Brak pytań i odpowiedzi" />
          </div>
        </div>
      </div>
    </div>
  </PublicLayout>
</template>
