<script setup>
import DashboardLayout from '@/Layouts/DashboardLayout.vue'
import TableHeader from '@/Shared/Components/Table/TableHeader.vue'
import TableWrapper from '@/Shared/Components/Table/TableWrapper.vue'
import TableRow from '@/Shared/Components/Table/TableRow.vue'
import TableCell from '@/Shared/Components/Table/TableCell.vue'
import Pagination from '@/Shared/Components/Pagination.vue'
import Button from '@/Shared/Components/Buttons/Button.vue'
import EmptyState from '@/Shared/Components/EmptyState/EmptyState.vue'
import RemoveModal from '@/Shared/Modals/RemoveModal.vue'
import { ref, watch } from 'vue'
import { Inertia } from '@inertiajs/inertia'
import { debounce } from 'lodash'
import TextInput from '@/Shared/Forms/TextInput.vue'
import { useForm } from '@inertiajs/inertia-vue3'
import ManagementHeader from '@/Shared/Components/ManagementHeader.vue'
import ManagementHeaderItem from '@/Shared/Components/ManagementHeaderItem.vue'
import StyledLink from '@/Shared/Components/StyledLink.vue'

const props = defineProps({
  students: Object,
  search: String,
  total: Number,
  lastUpdate: String,
})
const showModal = ref(false)
const studentToDeleteId = ref(0)
const form = useForm({
  search: props.search ?? '',
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
    <div class="flex flex-col gap-8">
      <ManagementHeader>
        <template #header>
          Zarządzanie studentami
        </template>
        <template #statistics>
          <ManagementHeaderItem>
            Liczba studentów w bazie: {{ total }}
          </ManagementHeaderItem>
          <ManagementHeaderItem v-if="students.total">
            Liczba studentów w tabeli: {{ students.total }}
          </ManagementHeaderItem>
          <ManagementHeaderItem v-if="lastUpdate">
            Ostatnie zmiany: {{ lastUpdate }}
          </ManagementHeaderItem>
        </template>
        <template #actions>
          <TextInput v-if="total || form.search.length > 0" id="filter" v-model="form.search" placeholder="Szukaj" type="search" class="max-w-lg" />
          <StyledLink :href="`/dashboard/students/import`">
            Dodaj masowo
          </StyledLink>
          <StyledLink :href="`/dashboard/students/create`">
            Dodaj
          </StyledLink>
        </template>
      </ManagementHeader>
      <div v-if="students.data.length" class="flex flex-col gap-8">
        <TableWrapper>
          <template #header>
            <TableHeader class="w-1 text-nowrap">
              ID
            </TableHeader>
            <TableHeader class="w-1 text-nowrap">
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
              <TableCell class="text-nowrap pr-12 opacity-75">
                {{ student.id }}
              </TableCell>
              <TableCell>
                {{ student.index_number }}
              </TableCell>
              <TableCell>
                {{ student.first_name }}
              </TableCell>
              <TableCell>
                {{ student.surname }}
              </TableCell>
              <TableCell class="flex justify-end gap-2">
                <StyledLink :href="`students/${student.id}/edit`">
                  edytuj
                </StyledLink>
                <Button class="text-red-600" @click="[showModal = true, studentToDeleteId = student.id]">
                  usuń
                </Button>
              </TableCell>
            </TableRow>
          </template>
        </TableWrapper>
        <Pagination :pagination="students" />
      </div>
      <EmptyState v-else />
    </div>
  </DashboardLayout>

  <RemoveModal :show="showModal" :href="`/dashboard/students/${studentToDeleteId}`" @close="showModal = false" />
</template>
