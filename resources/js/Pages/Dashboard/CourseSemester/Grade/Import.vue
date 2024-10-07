<script setup>
import DashboardLayout from '@/Layouts/DashboardLayout.vue'
import ManagementHeader from '@/Shared/Components/ManagementHeader.vue'
import Section from '@/Shared/Components/Section.vue'
import SubmitButton from '@/Shared/Components/Buttons/SubmitButton.vue'
import FormGroup from '@/Shared/Forms/FormGroup.vue'
import FormLabel from '@/Shared/Forms/FormLabel.vue'
import { useForm } from '@inertiajs/inertia-vue3'
import FormError from '@/Shared/Forms/FormError.vue'
import TableWrapper from '@/Shared/Components/Table/Public/TableWrapper.vue'
import TableRow from '@/Shared/Components/Table/Public/TableRow.vue'
import TableCell from '@/Shared/Components/Table/Public/TableCell.vue'
import GradeCell from '@/Shared/Components/GradeCell.vue'
import TableHeader from "@/Shared/Components/Table/TableHeader.vue";

const props = defineProps({
  course: Object,
  group: Object,
  column: Object,
  csrfToken: String,
})

const preparationForm = useForm({
  content: '',
})

const gradesForm = useForm({
  grades: '',
})

function prepareStudentsList() {
  fetch(`/dashboard/semester-courses/${props.course.id}/groups/${props.group.id}/grades/${props.column.id}/prepare`)
    .then(response => response.json())
    .then(data => {
      gradesForm.grades = data['students']
    })
}
</script>

<template>
  <DashboardLayout>
    <div class="flex flex-col gap-8">
      <ManagementHeader>
        <template #header>
          Import aktywności studentów
          <span class="text-gray-500">{{ group.name }}</span>
          <br> dla kursu
          <span class="text-gray-500">{{ course.course }}</span>
          dla oceny
          <span class="text-gray-500">{{ column.name }}</span>
        </template>
      </ManagementHeader>
      <div class="grid grid-cols-2 gap-8">
        <Section>
          <form class="flex flex-col justify-between gap-4" @submit.prevent="prepareStudentsList()">
            <FormGroup>
              <FormLabel for="content">
                Lista studentów do zaimportowania
                <span class="text-gray-500">(z pliku CSV przysłanego z Google Workspace)</span>
              </FormLabel>
              <textarea v-model="preparationForm.content" class="block h-[320px] w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 sm:text-sm sm:leading-6" />
              <FormError :error="preparationForm.errors.content" />
            </FormGroup>
            <div class="mt-4 flex justify-end">
              <SubmitButton>
                przygotuj
              </SubmitButton>
            </div>
          </form>
        </Section>
        <Section>
          <FormLabel for="content">
            Lista ocen
          </FormLabel>
          <TableWrapper class="mt-2">
            <template #header>
              <TableHeader>
                Numer indeksu
              </TableHeader>
              <TableHeader>
                Obecna ocena
              </TableHeader>
              <TableHeader>
                Proponowana
              </TableHeader>
            </template>
            <template #body>
              <TableRow v-for="data in gradesForm.grades" :key="data.student.id">
                <TableCell class="h-[70px] w-1 cursor-pointer flex-row border-2">
                  <div class="text-nowrap font-bold">
                    {{ data.student.name }}
                  </div>
                  <div>
                    ({{ data.student.indexNumber }})
                  </div>
                </TableCell>
                <GradeCell :grade="data" :grade-column="data.column" :student="data.student" class="cursor-pointer border-2"/>
                <GradeCell :grade="data" :grade-column="data.column" :student="data.student" class="cursor-pointer border-2"/>
              </TableRow>
            </template>
          </TableWrapper>
        </Section>
      </div>
    </div>
  </DashboardLayout>
</template>
