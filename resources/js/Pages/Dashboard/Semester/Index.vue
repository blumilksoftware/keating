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
import { Method } from '@inertiajs/inertia'
import ManagementHeader from '@/Shared/Components/ManagementHeader.vue'
import { Cog6ToothIcon, XCircleIcon, CheckIcon } from '@heroicons/vue/24/outline'

defineProps({
  semesters: Object,
})
const showModal = ref(false)
const semesterToDeleteId = ref(0)
</script>

<template>
  <DashboardLayout>
    <div v-if="semesters.data.length" class="flex flex-col gap-8">
      <ManagementHeader>
        <template #header>
          Zarządzanie semestrami
        </template>
        <template #actions>
          <span class="hidden sm:block">
            <Button :href="`/dashboard/semesters/create`">
              Dodaj
            </Button>
          </span>
        </template>
      </ManagementHeader>
      <TableWrapper class="mt-2">
        <template #header>
          <TableHeader class="w-1/5">
            Nazwa
          </TableHeader>
          <TableHeader class="w-1/5">
            Status
          </TableHeader>
          <TableHeader />
        </template>
        <template #body>
          <TableRow v-for="semester in semesters.data" :key="semester.id" :class="semester.status === 'active' ? 'bg-green-50' : ''">
            <TableCell>
              {{ semester.name }}
            </TableCell>
            <TableCell>
              {{ semester.statusLabel }}
            </TableCell>
            <TableCell class="text-right">
              <Button v-if="semester.status !== 'active'" :method="Method.POST" :href="`/dashboard/semesters/${semester.id}/activate`">
                <CheckIcon class="w-6" />
              </Button>
              <Button :href="`/dashboard/semesters/${semester.id}/edit`">
                <Cog6ToothIcon class="w-6" />
              </Button>
              <Button class="text-red-600" @click="[showModal = true, semesterToDeleteId = semester.id]">
                <XCircleIcon class="w-6" />
              </Button>
            </TableCell>
          </TableRow>
        </template>
      </TableWrapper>
    </div>
    <EmptyState v-else class="mt-3" />
  </DashboardLayout>
  <RemoveModal :show="showModal" :href="`/dashboard/semesters/${semesterToDeleteId}`" @close="showModal = false" />
</template>
