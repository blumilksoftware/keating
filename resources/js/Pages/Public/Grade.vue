<script setup>
import PublicLayout from '@/Layouts/PublicLayout.vue'
import BackgroundGrid from '@/Components/BackgroundGrid.vue'
import SectionHeader from '@/Components/SectionHeader.vue'
import { Head, Link } from '@inertiajs/inertia-vue3'
import SubmitButton from '@/Shared/Components/Buttons/SubmitButton.vue'
import TableWrapper from '@/Shared/Components/Table/TableWrapper.vue'
import TableHeader from '@/Shared/Components/Table/TableHeader.vue'
import TableRow from '@/Shared/Components/Table/TableRow.vue'
import TableCell from '@/Shared/Components/Table/TableCell.vue'
import { Inertia } from '@inertiajs/inertia'
import { ExclamationCircleIcon, MagnifyingGlassIcon } from '@heroicons/vue/24/solid'
import { ref } from 'vue'

const props = defineProps({
  title: String,
  semesters: Array,
  semester: Object,
  courses: Array,
  course: Object,
  groups: Array,
  group: Object,
  index: String,
  gradeColumns: Array,
  students: Array,
  indexExists: Boolean,
})

const searchIndex = ref(props.index)

function getIndex() {
  Inertia.get(`/oceny/${props.semester.id}/${props.course.id}/${props.group.id}/${searchIndex.value}`, {}, {
    preserveScroll: true,
  })
}
</script>

<template>
  <Head title="Oceny" />

  <PublicLayout>
    <div class="relative isolate bg-white">
      <BackgroundGrid />
      <div class="py-24 sm:py-32">
        <div class="mx-auto max-w-7xl px-6 lg:px-8">
          <SectionHeader>
            <template #header>
              Oceny
            </template>
            <template #subheader>
              Wybierz odpowiedni semestr, kurs oraz grupę, a następnie wpisz swój numer indeksu, aby uzyskać arkusz ocen i obecności.
            </template>
          </SectionHeader>

          <div class="mx-auto mt-10 border-t border-gray-200 pt-10 text-sm sm:mt-16 sm:pt-16 lg:mx-0 lg:max-w-none lg:grid-cols-3">
            <table>
              <tbody>
                <tr>
                  <td class="block pl-5 sm:table-cell sm:p-5">
                    Wybierz semestr:
                  </td>
                  <td class="block px-5 sm:table-cell">
                    <div class="flex flex-wrap gap-2">
                      <Link v-for="item in semesters" :key="item.id" :class="[item.id === semester?.id ? 'border-blue-900 text-blue-900' : '']" :href="`/oceny/${item.id}`" class="border px-4 py-2.5">
                        {{ item.name }}
                      </Link>
                    </div>
                  </td>
                </tr>
                <tr v-if="semester">
                  <td class="block pl-5 sm:table-cell sm:p-5">
                    Wybierz kurs:
                  </td>
                  <td class="block px-5 sm:table-cell">
                    <div class="flex flex-wrap gap-2">
                      <Link v-for="item in courses" :key="item.id" :class="[item.id === course?.id ? 'border-blue-900 text-blue-900' : '']" :href="`/oceny/${semester.id}/${item.id}`" class="border px-4 py-2.5">
                        {{ item.course.name }}
                      </Link>
                    </div>
                  </td>
                </tr>
                <tr v-if="course">
                  <td class="block pl-5 sm:table-cell sm:p-5">
                    Wybierz grupę:
                  </td>
                  <td class="block px-5 sm:table-cell">
                    <div class="flex flex-wrap gap-2">
                      <Link v-for="item in groups" :key="item.id" :class="[item.id === group?.id ? 'border-blue-900 text-blue-900' : '']" :href="`/oceny/${semester.id}/${course.id}/${item.id}`" class="border px-4 py-2.5">
                        {{ item.name }}
                      </Link>
                    </div>
                  </td>
                </tr>
                <tr v-if="group">
                  <td class="block pl-5 sm:table-cell sm:p-5">
                    Wybierz numer indeksu:
                  </td>
                  <td class="block px-5 sm:table-cell">
                    <div class="flex">
                      <input v-model="searchIndex" autocomplete="off" class="border-1 mr-3 block w-32 px-4 py-2.5 opacity-75 focus:!border-blue-900 focus:!text-blue-900 focus:!ring-0 sm:w-48" @keyup.enter="getIndex()" />
                      <SubmitButton class="min-h-max" @click="getIndex()">
                        <MagnifyingGlassIcon class="size-6" />
                      </SubmitButton>
                    </div>
                  </td>
                </tr>
              </tbody>
            </table>

            <div v-if="index && indexExists" class="mt-5">
              <h3 class="text-2xl font-bold tracking-tight text-gray-900 sm:text-3xl">
                Arkusz ocen i obecności
              </h3>
              <p class="mt-1 text-lg leading-8 text-gray-600">
                Numery indeksów innych studentów są zaciemnione z prawnych względów
              </p>
              <TableWrapper class="mt-10">
                <template #header>
                  <TableHeader>
                    student
                  </TableHeader>
                  <TableHeader v-for="column in gradeColumns" :key="column.id" class="min-w-[50px] border-2 border-solid text-center">
                    {{ column.name }}
                  </TableHeader>
                </template>
                <template #body>
                  <TableRow v-for="student in students" :key="student">
                    <TableCell class="size-[50px] min-w-[50px] border-2 text-center">
                      {{ student.student }}
                    </TableCell>
                    <TableCell v-for="grade in student.grades" :key="grade" :class="{'bg-lime-200': grade.present === true, 'bg-rose-300': grade.present === false}" class="border-2 text-center text-gray-900">
                      {{ grade.value }}
                    </TableCell>
                  </TableRow>
                </template>
              </TableWrapper>
              <div class="mt-4">
                <h5 class="text-xl font-bold tracking-tight text-gray-900">
                  Legenda:
                </h5>
                <div class="flex flex-col gap-5 text-sm sm:flex-row">
                  <div class="mt-3 flex items-center gap-2">
                    <span class="size-8 bg-lime-300" />
                    <p>student obecny lub ocena pozytywna</p>
                  </div>
                  <div class="mt-3 flex items-center gap-2">
                    <span class="size-8 bg-red-300" />
                    <p>student nieobecny lub ocena niedostateczna</p>
                  </div>
                </div>
              </div>
            </div>
            <div v-else-if="index" class="mt-5 rounded-md bg-red-50 p-4">
              <div class="flex items-center">
                <div class="shrink-0">
                  <ExclamationCircleIcon class="size-14 text-red-400" />
                </div>
                <div class="ml-3">
                  <h3 class="text-sm font-medium text-red-800">
                    Niestety nic nie znaleziono.
                  </h3>
                  <p class="mt-2 text-sm text-red-700">
                    Dla podanej kombinacji identyfikatorów semestru, kursu i numeru indeksu nie odnaleziono żadnych
                    danych. Sprawdź poprawność podanych informacji. Jeżeli semestr dopiero się rozpoczął, może po prostu
                    jeszcze niczego tu nie ma.
                  </p>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </PublicLayout>
</template>
