<script setup>
import PublicLayout from '@/Layouts/PublicLayout.vue'
import BackgroundGrid from '@/Components/BackgroundGrid.vue'
import SectionHeader from '@/Components/SectionHeader.vue'
import { Head } from '@inertiajs/inertia-vue3'
import ContactItem from '@/Shared/Components/ContactItem.vue'
import { NoSymbolIcon } from '@heroicons/vue/24/outline'

defineProps({
  email: String,
  contactInfos: Array,
})
</script>

<template>
  <Head title="Kontakt" />

  <PublicLayout>
    <div class="relative isolate bg-white">
      <BackgroundGrid />
      <div class="py-24 sm:py-32">
        <div class="mx-auto max-w-7xl px-6 lg:px-8">
          <SectionHeader>
            <template #header>
              Kontakt
            </template>
            <template #subheader>
              Informacje kontaktowe.
            </template>
          </SectionHeader>
          <div class="mx-auto mt-10 border-t border-gray-200 pt-10 sm:mt-16 sm:pt-16 lg:mx-0 lg:max-w-none lg:grid-cols-3">
            <div class="mx-auto max-w-7xl text-center lg:mx-0 lg:flex-auto ">
              <div v-if="email" class="mx-auto max-w-2xl py-6 text-left lg:mx-0 xl:py-3">
                <label class="text-sm">
                  E-mail
                </label>
                <a :href="'mailto:' + email"
                   class="flex w-full items-center text-center text-xl font-bold tracking-tight text-gray-900 sm:text-2xl"
                >
                  {{ email.split('@')[0] }}
                  <span class="font-normal">@{{ email.split('@')[1] }}</span>
                </a>
              </div>
              <div v-for="(contactInfo, index) in contactInfos" :key="index" class="mx-auto flex max-w-2xl py-6 lg:mx-0 xl:py-3">
                <ContactItem :contact="contactInfo" />
              </div>

              <div v-if="!email && contactInfos.length === 0" class="text-center">
                <NoSymbolIcon class="mx-auto size-12 text-gray-400" />
                <h3 class="mt-2 text-sm font-semibold text-gray-900">
                  Brak danych kontaktowych
                </h3>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </PublicLayout>
</template>
