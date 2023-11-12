<script setup>
import PublicLayout from '@/Layouts/PublicLayout.vue'
import BackgroundGrid from '@/Components/BackgroundGrid.vue'
import SectionHeader from '@/Components/SectionHeader.vue'
import { Link } from '@inertiajs/inertia-vue3'
import TextInput from '@/Shared/Forms/TextInput.vue'
import SubmitButton from '@/Shared/Components/Buttons/SubmitButton.vue'
import TableWrapper from '@/Shared/Components/Table/TableWrapper.vue'
import TableHeader from '@/Shared/Components/Table/TableHeader.vue'
import TableRow from '@/Shared/Components/Table/TableRow.vue'
import TableCell from '@/Shared/Components/Table/TableCell.vue'
import { Inertia } from '@inertiajs/inertia'
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

const index = ref(props.index)

function getIndex() {
  Inertia.get(`/oceny/${props.semester.id}/${props.course.id}/${props.group.id}/${index.value}`, {}, {
    preserveScroll: true,
  })
}
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
                  <TextInput v-model="index" autocomplete="off" class="mr-3 w-1/4 opacity-75" />
                  <SubmitButton @click="getIndex">
                    Szukaj
                  </SubmitButton>
                </td>
              </tr>
            </tbody>
          </table>
          <TableWrapper v-if="indexExists" class="mt-10">
            <template #header>
              <TableHeader>
                student
              </TableHeader>
              <TableHeader v-for="column in gradeColumns" :key="column.id"
                           class="min-w-[50px] border-2 border-solid text-center"
              >
                {{ column.name }}
              </TableHeader>
            </template>
            <template #body>
              <TableRow v-for="student in students" :key="student">
                <TableCell class="h-[50px] w-[50px] min-w-[50px] cursor-pointer border-2 text-center font-bold">
                  {{ student.student }}
                </TableCell>
                <TableCell v-for="grade in student.grades" :key="grade"
                           :class="[grade.present ? 'bg-lime-200' :'bg-rose-300']"
                           class="border-2 text-center font-bold text-gray-900"
                >
                  {{ grade.value }}
                </TableCell>
              </TableRow>
            </template>
          </TableWrapper>
        </div>
      </div>
    </div>
  </PublicLayout>
</template>
