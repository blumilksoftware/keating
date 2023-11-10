<script setup>
import PublicLayout from '@/Layouts/PublicLayout.vue'
import BackgroundGrid from '@/Components/BackgroundGrid.vue'
import SectionHeader from '@/Components/SectionHeader.vue'
import { Link } from '@inertiajs/inertia-vue3'
import TextInput from '@/Shared/Forms/TextInput.vue'
import SubmitButton from '../../Shared/Components/Buttons/SubmitButton.vue'

defineProps({
  title: String,
  semesters: Array,
  semester: Object,
  courses: Array,
  course: Object,
  groups: Array,
  group: Object,
})
</script>

<template>
  <PublicLayout>
    <div class="relative isolate bg-gradient-to-r from-gray-50 to-gray-100 py-24 sm:py-32">
      <BackgroundGrid mask-direction="left" />
      <div class="mx-auto max-w-7xl px-6 lg:px-8">
        <SectionHeader class="max-w-full">
          <template #header>
            Formularz dostępu do ocen
          </template>
          <template #subheader>
            Wybierz odpowiedni semestr, kurs oraz grupę, a następnie wpisz swój numer indeksu, aby uzyskać arkusz ocen i
            obecności
          </template>
        </SectionHeader>
        <div class="mt-5">
          <table>
            <tbody>
              <tr>
                <td class="border-b-2 border-r-2 border-gray-200 p-5">
                  Wybierz semestr:
                </td>
                <td class="border-b-2 border-gray-200 p-5">
                  <div class="grid grid-cols-6">
                    <Link v-for="item in semesters" :key="item.id"
                          :class="[item.id === semester?.id ? 'border-blue-900 text-blue-900' : '']"
                          :href="`/oceny/${item.id}`"
                          class="mr-5 mt-4 border-2 px-5 py-3"
                    >
                      {{ item.name }}
                    </Link>
                  </div>
                </td>
              </tr>
              <tr v-if="semester">
                <td class="border-b-2 border-r-2 border-gray-200 p-5">
                  Wybierz kurs:
                </td>
                <td class="border-b-2 border-gray-200 p-5">
                  <div class="grid grid-cols-6">
                    <Link v-for="item in courses" :key="item.id"
                          :class="[item.id === course?.id ? 'border-blue-900 text-blue-900' : '']"
                          :href="`/oceny/${semester.id}/${item.id}`"
                          class="mr-5 mt-4 border-2 px-5 py-3"
                    >
                      {{ item.course.name }}
                    </Link>
                  </div>
                </td>
              </tr>
              <tr v-if="course">
                <td class="border-b-2 border-r-2 border-gray-200 p-5">
                  Wybierz grupę:
                </td>
                <td class="border-b-2 border-gray-200 p-5">
                  <div class="grid grid-cols-6">
                    <Link v-for="item in groups" :key="item.id"
                          :class="[item.id === group?.id ? 'border-blue-900 text-blue-900' : '']"
                          :href="`/oceny/${semester.id}/${course.id}/${item.id}`"
                          class="mr-5 mt-4 border-2 px-5 py-3"
                    >
                      {{ item.name }}
                    </Link>
                  </div>
                </td>
              </tr>
              <tr v-if="group">
                <td class="border-b-2 border-r-2 border-gray-200 p-5">
                  Wybierz numer indeksu:
                </td>
                <td class="flex border-b-2 border-gray-200 p-5">
                  <TextInput class="mr-3 w-1/4 opacity-75" autocomplete="off" />
                  <SubmitButton>
                    Szukaj
                  </SubmitButton>
                </td>
              </tr>
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </PublicLayout>
</template>
