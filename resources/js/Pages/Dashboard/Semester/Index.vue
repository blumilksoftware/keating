<script setup>
import DashboardLayout from '@/Layouts/DashboardLayout.vue'
import TableHeader from '@/Shared/Components/Table/TableHeader.vue'
import TableWrapper from '@/Shared/Components/Table/TableWrapper.vue'
import TableRow from '@/Shared/Components/Table/TableRow.vue'
import TableCell from '@/Shared/Components/Table/TableCell.vue'
import Button from '@/Shared/Components/Buttons/Button.vue'
import EmptyState from '@/Shared/Components/EmptyState.vue'
import RemoveModal from '@/Shared/Modals/RemoveModal.vue'
import { ref } from 'vue'

const props = defineProps({
  semesters: Object,
})
const showModal = ref(false)
const semesterToDeleteId = ref(0)
</script>

<template>
  <DashboardLayout>
    <div class="flex justify-between">
      <h3 class="text-base font-semibold leading-6 text-gray-900">
        Lista semestrów
      </h3>
      <Button :href="`/dashboard/semesters/create`">
        Dodaj
      </Button>
    </div>
    <div v-if="semesters.data.length">
      <TableWrapper class="mt-2">
        <template #header>
          <TableHeader>
            Nazwa
          </TableHeader>
          <TableHeader>
            Status
          </TableHeader>
          <TableHeader class="sm:w-2/10 w-1/3" />
        </template>
        <template #body>
          <TableRow v-for="semester in semesters.data" :key="semester.id">
            <TableCell>
              {{ semester.name }}
            </TableCell>
            <TableCell>
              {{ semester.status_label }}
            </TableCell>
            <TableCell class="text-right">
              <InertiaLink :href="`/dashboard/semesters/${semester.id}/edit`">
                Edycja
              </InertiaLink>
              <button class="ml-3 text-red-600" @click="[showModal = true, semesterToDeleteId = semester.id]">
                Usuń
              </button>
            </TableCell>
          </TableRow>
        </template>
      </TableWrapper>
    </div>
    <EmptyState v-else class="mt-3" />
  </DashboardLayout>
  <RemoveModal :show="showModal" :href="`/dashboard/semesters/${semesterToDeleteId}`" @close="showModal = false" />
</template>
