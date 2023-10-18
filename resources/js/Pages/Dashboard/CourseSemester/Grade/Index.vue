<script setup>
import DashboardLayout from '@/Layouts/DashboardLayout.vue'
import TableHeader from '@/Shared/Components/Table/TableHeader.vue'
import TableWrapper from '@/Shared/Components/Table/TableWrapper.vue'
import TableRow from '@/Shared/Components/Table/TableRow.vue'
import TableCell from '@/Shared/Components/Table/TableCell.vue'
import FormGroup from '@/Shared/Forms/FormGroup.vue'
import FormLabel from '@/Shared/Forms/FormLabel.vue'
import FormError from '@/Shared/Forms/FormError.vue'
import SubmitButton from '@/Shared/Components/Buttons/SubmitButton.vue'
import { Inertia } from '@inertiajs/inertia'
import { useForm } from '@inertiajs/inertia-vue3'
import TextInput from '@/Shared/Forms/TextInput.vue'
import ManagementHeader from '@/Shared/Components/ManagementHeader.vue'
import ManagementHeaderItem from '@/Shared/Components/ManagementHeaderItem.vue'

const props = defineProps({
  course: Object,
  group: Object,
  students: Array,
  gradeColumns: Array,
})

const form = useForm({
  name: '',
})

function createGradeColumn() {
  form.post(`/dashboard/semester-courses/${props.course.data.id}/groups/${props.group.id}/grades`)
  form.reset()
}

function createOrUpdateGrade(gradeColumnId, studentId, status) {
  Inertia.post(`/dashboard/semester-courses/${props.course.data.id}/groups/${props.group.id}/grades/${gradeColumnId}`, {
    status: status,
    student_id: studentId,
  })
}
</script>

<template>
  <DashboardLayout>
    <div class="flex flex-col gap-8">
      <ManagementHeader>
        <template #header>
          Zarządzanie ocenami w grupie <span class="text-gray-500">{{ group.name }}</span><br>
          dla kursu <span class="text-gray-500">{{ course.data.course }}</span>
        </template>
        <template #statistics>
          <ManagementHeaderItem>
            Liczba studentów w grupie: {{ total }}
          </ManagementHeaderItem>
          <ManagementHeaderItem v-if="students.total">
            Liczba studentów w tabeli: {{ students.total }}
          </ManagementHeaderItem>
        </template>
        <template #actions>
          <div class="flex">
            <form class="grid grid-cols-2" @submit.prevent="createGradeColumn">
              <FormGroup>
                <FormLabel for="name">
                  Nazwa
                </FormLabel>
                <TextInput id="name" v-model="form.name" :error="form.errors.name" autocomplete="off" />
                <FormError :error="form.errors.name" />
              </FormGroup>
              <SubmitButton>
                Utwórz
              </SubmitButton>
            </form>
          </div>
        </template>
      </ManagementHeader>
      <div class="flex flex-col gap-8">
        <TableWrapper>
          <template #header>
            <TableHeader class="w-1/6">
              Numer indeksu
            </TableHeader>
            <TableHeader v-for="column in gradeColumns" :key="column.id">
              {{ column.name }}
            </TableHeader>
          </template>
          <template #body>
            <TableRow v-for="student in students.data" :key="student.id">
              <TableCell>
                {{ student.index_number }}
              </TableCell>
              <TableCell v-for="column in gradeColumns" :key="column.id" @dblclick="createOrUpdateGrade(column.id, student.id, false)" @click="createOrUpdateGrade(column.id, student.id, true)">
                <TextInput id="name" :class="[column.grades.find(obj => obj.student_id === student.id)?.status ? 'bg-green-300' : 'bg-red-300']" />
              </TableCell>
            </TableRow>
          </template>
        </TableWrapper>
      </div>
    </div>
  </DashboardLayout>
</template>
