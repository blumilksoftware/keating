<script setup>
import DashboardLayout from '@/Layouts/DashboardLayout.vue'
import TableHeader from '@/Shared/Components/Table/TableHeader.vue'
import TableWrapper from '@/Shared/Components/Table/TableWrapper.vue'
import TableRow from '@/Shared/Components/Table/TableRow.vue'
import TableCell from '@/Shared/Components/Table/TableCell.vue'
import Pagination from '@/Shared/Components/Pagination.vue'
import Section from '@/Shared/Components/Section.vue'
import Button from '@/Shared/Components/Buttons/Button.vue'
import { Inertia, Method } from '@inertiajs/inertia'
import EmptyState from '../../../Shared/Components/EmptyState.vue'

defineProps({
  students: Object,
})

function deleteStudent(id) {
  if (confirm('Czy na pewno chcesz usunąć studenta?')) {
    Inertia.visit(`/students/${id}`, {
      method: Method.DELETE,
    })
  }
}
</script>

<template>
  <DashboardLayout>
    <div class="flex justify-between">
      <h3 class="text-base font-semibold leading-6 text-gray-900">
        Lista studentów
      </h3>
      <Button :href="`/students/create`">
        Dodaj
      </Button>
    </div>
    <div v-if="students.data.length">
      <TableWrapper class="mt-2">
        <template #header>
          <TableHeader>
            Imię
          </TableHeader>
          <TableHeader>
            Nazwisko
          </TableHeader>
          <TableHeader>
            Numer indeksu
          </TableHeader>
          <TableHeader class="w-1/12" />
        </template>
        <template #body>
          <TableRow v-for="student in students.data" :key="student.id">
            <TableCell>
              {{ student.name }}
            </TableCell>
            <TableCell>
              {{ student.surname }}
            </TableCell>
            <TableCell>
              {{ student.index_number }}
            </TableCell>
            <TableCell>
              <InertiaLink :href="`students/${student.id}/edit`">
                Edycja
              </InertiaLink>
              <InertiaLink class="ml-3 text-red-600" @click="deleteStudent(student.id)">
                Usuń
              </InertiaLink>
            </TableCell>
          </TableRow>
        </template>
      </TableWrapper>
      <Section class="mt-3">
        <Pagination :pagination="students" />
      </Section>
    </div>
    <EmptyState v-else class="mt-3" />
  </DashboardLayout>
</template>
