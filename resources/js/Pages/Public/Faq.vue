<script setup>
import PublicLayout from '@/Layouts/PublicLayout.vue'
import BackgroundGrid from '@/Components/BackgroundGrid.vue'
import SectionHeader from '@/Components/SectionHeader.vue'
import { NoSymbolIcon } from '@heroicons/vue/24/outline'
import { Head } from '@inertiajs/inertia-vue3'
import DOMPurify from 'dompurify'

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
              Często zadawane pytania i odpowiedzi na nie
            </template>
          </SectionHeader>

          <div class="mx-auto mt-10 grid max-w-2xl grid-cols-1 gap-x-8 gap-y-4 border-t border-gray-200 pt-10 sm:mt-16 sm:pt-16 lg:mx-0 lg:max-w-none">
            <div v-for="(faq, index) in faqs" :key="index" class="cursor-pointer">
              <div class="flex items-center justify-between bg-[#FAFAFC] p-4 text-lg font-semibold text-gray-600">
                <div class="w-[90%]">
                  {{ faq.question }}
                </div>
              </div>
              <div class="text-md flex items-center justify-between bg-white px-4 py-5 font-normal text-gray-600">
                <!-- eslint-disable vue/no-v-html -->
                <p class="prose text-gray-600" v-html="DOMPurify.sanitize(faq.answer)" />
                <!-- eslint-enable vue/no-v-html -->
              </div>
            </div>

            <div v-if="faqs.length === 0" class="text-center">
              <NoSymbolIcon class="mx-auto size-12 text-gray-400" />
              <h3 class="mt-2 text-sm font-semibold text-gray-900">
                Brak pytań i odpowiedzi
              </h3>
            </div>
          </div>
        </div>
      </div>
    </div>
  </PublicLayout>
</template>
