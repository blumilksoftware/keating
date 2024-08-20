<script setup>
import PublicLayout from '@/Layouts/PublicLayout.vue'
import BackgroundGrid from '../../../Components/BackgroundGrid.vue'
import SectionHeader from '../../../Components/SectionHeader.vue'
import DOMPurify from 'dompurify'

defineProps({
  course: Object,
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
              {{ course.name }}
            </template>
            <template #subheader>
              Strona informacyjna kursu {{ course.abbreviation }}
            </template>
          </SectionHeader>

          <div
            class="mx-auto mt-10 md:border-t border-gray-200 pt-10 sm:mt-16 sm:pt-16 lg:mx-0 lg:max-w-none lg:grid-cols-3"
          >
            <h3 class="text-xl">
              Podstawowe informacje
            </h3>
            <div
              class="mx-auto mt-10 grid max-w-2xl grid-cols-1 gap-x-8 gap-y-16 uppercase lg:max-w-none lg:grid-cols-3"
            >
              <div class="flex-row text-center">
                <div class="text-xl leading-8">
                  KIERUNEK
                </div>
                <div class="my-2 text-5xl leading-10">
                  {{ course.fieldAbbreviation }}
                </div>
                <div class="text-xl leading-8">
                  {{ course.field }}
                </div>
              </div>
              <div class="flex-row text-center">
                <div class="text-xl leading-8">
                  SEMESTR
                </div>
                <div class="my-2 text-5xl leading-10">
                  {{ course.semester }}
                </div>
                <div class="text-xl leading-8">
                  {{ course.semesterName }}
                </div>
              </div>
              <div class="flex-row text-center">
                <div class="text-xl leading-8">
                  FORMA ZAJĘĆ
                </div>
                <div class="my-2 text-5xl leading-10">
                  {{ course.type[0] }}
                </div>
                <div class="text-xl leading-8">
                  {{ course.type }}
                </div>
              </div>
            </div>
          </div>

          <div
            class="mx-auto mt-10 border-t border-gray-200 pt-10 sm:mt-16 sm:pt-16 lg:mx-0 lg:max-w-none lg:grid-cols-3"
          >
            <h3 class="text-xl">
              Opis kursu
            </h3>
            <div
              class="mx-auto mt-10 flex max-w-2xl lg:max-w-none"
            >
              <!-- eslint-disable vue/no-v-html -->
              <p class="prose text-gray-600" v-html="DOMPurify.sanitize(course.description)" />
              <!-- eslint-enable vue/no-v-html -->
            </div>
          </div>
        </div>
      </div>
    </div>
  </PublicLayout>
</template>
