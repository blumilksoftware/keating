<script setup>
import DashboardLayout from '@/Layouts/DashboardLayout.vue'
import TableHeader from '@/Shared/Components/Table/TableHeader.vue'
import TableWrapper from '@/Shared/Components/Table/TableWrapper.vue'
import TableRow from '@/Shared/Components/Table/TableRow.vue'
import TableCell from '@/Shared/Components/Table/TableCell.vue'
import Pagination from '@/Shared/Components/Pagination.vue'
import Section from '@/Shared/Components/Section.vue'
import Button from '@/Shared/Components/Buttons/Button.vue'
import EmptyState from '@/Shared/Components/EmptyState.vue'
import RemoveModal from '@/Shared/Modals/RemoveModal.vue'
import { ref, watch } from 'vue'
import { Inertia } from '@inertiajs/inertia'
import { debounce } from 'lodash'
import TextInput from '@/Shared/Forms/TextInput.vue'
import { useForm } from '@inertiajs/inertia-vue3'

const props = defineProps({
  students: Object,
  search: String,
})
const showModal = ref(false)
const studentToDeleteId = ref(0)
const form = useForm({
  search: props.search,
})

watch(form, debounce(() => {
  Inertia.get('/dashboard/students', {
    search: form.search,
  }, {
    preserveState: true,
    replace: true,
  })
}, 300), { deep: true })
</script>

<template>
  <DashboardLayout>
    <div class="flex justify-between">
      <h3 class="text-base font-semibold leading-6 text-gray-900">
        Lista studentów
      </h3>
      <Button :href="`/dashboard/students/create`">
        Dodaj
      </Button>
    </div>
    <TextInput id="filter" v-model="form.search" placeholder="Szukaj" type="search" class="max-w-xs" />
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
          <TableHeader class="sm:w-2/10 w-1/3" />
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
            <TableCell class="text-right">
              <InertiaLink :href="`students/${student.id}/edit`">
                Edycja
              </InertiaLink>
              <button class="ml-3 text-red-600" @click="[showModal = true, studentToDeleteId = student.id]">
                Usuń
              </button>
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
  <RemoveModal :show="showModal" :href="`/dashboard/students/${studentToDeleteId}`" @close="showModal = false" />
</template>
