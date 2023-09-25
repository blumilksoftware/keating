<script setup>
import DashboardLayout from '@/Layouts/DashboardLayout.vue'
import TableHeader from '@/Shared/Components/Table/TableHeader.vue'
import TableWrapper from '@/Shared/Components/Table/TableWrapper.vue'
import TableRow from '@/Shared/Components/Table/TableRow.vue'
import TableCell from '@/Shared/Components/Table/TableCell.vue'
import Pagination from '@/Shared/Components/Pagination.vue'
import Button from '@/Shared/Components/Buttons/Button.vue'
import EmptyState from '@/Shared/Components/EmptyState.vue'
import RemoveModal from '@/Shared/Modals/RemoveModal.vue'
import {ref, watch} from 'vue'
import {Inertia} from '@inertiajs/inertia'
import {debounce} from 'lodash'
import TextInput from '@/Shared/Forms/TextInput.vue'
import {useForm} from '@inertiajs/inertia-vue3'

const props = defineProps({
  students: Object,
  search: String,
  total: Number,
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
}, 300), {deep: true})
</script>

<template>
  <DashboardLayout>
    <div v-if="students.data.length" class="flex flex-col gap-8">
      <div class="lg:flex lg:items-center lg:justify-between">
        <div class="min-w-0 flex-1">
          <h2 class="text-2xl font-bold leading-7 text-gray-900 sm:truncate sm:text-3xl sm:tracking-tight">
            Zarządzanie studentami
          </h2>
          <div class="mt-1 flex flex-col sm:mt-0 sm:flex-row sm:flex-wrap sm:space-x-6">
            <div class="mt-2 flex items-center text-sm text-gray-500">
              liczba studentów w bazie: {{ total }}
            </div>
            <div class="mt-2 flex items-center text-sm text-gray-500">
              liczba studentów: {{ students.total }}
            </div>
            <div class="mt-2 flex items-center text-sm text-gray-500">
              ostatnia zmiana: wczoraj
            </div>
          </div>
        </div>
        <div class="flex lg:ml-4 gap-4">
          <TextInput id="filter" v-model="form.search" placeholder="Szukaj" type="search" class="max-w-xs"/>
          <span class="hidden sm:block">
            <Button :href="`/dashboard/students/create`">
             Dodaj
            </Button>
          </span>
        </div>
      </div>

      <TableWrapper>
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
          <TableHeader class="sm:w-2/10 w-1/3"/>
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
              <Button :href="`students/${student.id}/edit`">
                Edycja
              </Button>
              <Button class="text-red-600" @click="[showModal = true, studentToDeleteId = student.id]">
                Usuń
              </Button>
            </TableCell>
          </TableRow>
        </template>
      </TableWrapper>

      <Pagination :pagination="students"/>
    </div>

    <EmptyState v-else class="mt-3"/>
  </DashboardLayout>
  <RemoveModal :show="showModal" :href="`/dashboard/students/${studentToDeleteId}`" @close="showModal = false"/>
</template>
