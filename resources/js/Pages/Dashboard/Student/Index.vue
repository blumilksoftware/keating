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
import { ref, watch } from 'vue'
import { Inertia } from '@inertiajs/inertia'
import { debounce } from 'lodash'
import TextInput from '@/Shared/Forms/TextInput.vue'
import { useForm } from '@inertiajs/inertia-vue3'
import { Cog6ToothIcon, XCircleIcon } from '@heroicons/vue/24/outline'
import ManagementHeader from '../../../Shared/Components/ManagementHeader.vue'

const props = defineProps({
  students: Object,
  search: String,
  total: Number,
  lastUpdate: String,
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
    <div v-if="students.data.length" class="flex flex-col gap-8">
      <ManagementHeader>
        <template #header>
          Zarządzanie studentami
        </template>
        <template #statistics>
          <div class="mt-2 flex items-center text-sm text-gray-500">
            liczba studentów w bazie: {{ total }}
          </div>
          <div class="mt-2 flex items-center text-sm text-gray-500">
            liczba studentów: {{ students.total }}
          </div>
          <div class="mt-2 flex items-center text-sm text-gray-500">
            ostatnia zmiana: {{ lastUpdate }}
          </div>
        </template>
        <template #actions>
          <TextInput id="filter" v-model="form.search" placeholder="Szukaj" type="search" class="max-w-lg" />
          <span class="hidden sm:block">
            <Button :href="`/dashboard/students/create`">
              Dodaj
            </Button>
          </span>
        </template>
      </ManagementHeader>

      <TableWrapper>
        <template #header>
          <TableHeader class="w-1/6">
            ID
          </TableHeader>
          <TableHeader class="w-1/6">
            Numer indeksu
          </TableHeader>
          <TableHeader class="w-1/5">
            Imię
          </TableHeader>
          <TableHeader class="w-1/5">
            Nazwisko
          </TableHeader>
          <TableHeader />
        </template>
        <template #body>
          <TableRow v-for="student in students.data" :key="student.id">
            <TableCell class="pr-12 opacity-75">
              {{ student.id }}
            </TableCell>
            <TableCell>
              {{ student.index_number }}
            </TableCell>
            <TableCell>
              {{ student.name }}
            </TableCell>
            <TableCell>
              {{ student.surname }}
            </TableCell>
            <TableCell class="text-right">
              <Button :href="`students/${student.id}/edit`">
                <Cog6ToothIcon class="w-6" />
              </Button>
              <Button class="text-red-600" @click="[showModal = true, studentToDeleteId = student.id]">
                <XCircleIcon class="w-6" />
              </Button>
            </TableCell>
          </TableRow>
        </template>
      </TableWrapper>

      <Pagination :pagination="students" />
    </div>

    <EmptyState v-else class="mt-3" />
  </DashboardLayout>
  <RemoveModal :show="showModal" :href="`/dashboard/students/${studentToDeleteId}`" @close="showModal = false" />
</template>
