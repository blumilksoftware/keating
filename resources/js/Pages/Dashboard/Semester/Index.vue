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
import ManagementHeaderItem from '@/Shared/Components/ManagementHeaderItem.vue'
import { Cog6ToothIcon, XCircleIcon, CheckIcon } from '@heroicons/vue/24/outline'

defineProps({
  semesters: Object,
  total: Number,
  lastUpdate: String,
})
const showModal = ref(false)
const semesterToDeleteId = ref(0)
</script>

<template>
  <DashboardLayout>
    <div class="flex flex-col gap-8">
      <ManagementHeader>
        <template #header>
          Zarządzanie semestrami
        </template>
        <template #statistics>
          <ManagementHeaderItem>
            Liczba semestrów w bazie: {{ total }}
          </ManagementHeaderItem>
          <ManagementHeaderItem v-if="lastUpdate">
            Ostatnie zmiany: {{ lastUpdate }}
          </ManagementHeaderItem>
        </template>
        <template #actions>
          <span class="hidden sm:block">
            <Button :href="`/dashboard/semesters/create`">
              Dodaj
            </Button>
          </span>
        </template>
      </ManagementHeader>
      <div v-if="semesters.length" class="flex flex-col gap-8">
        <TableWrapper>
          <template #header>
            <TableHeader class="w-1/6">
              ID
            </TableHeader>
            <TableHeader class="w-1/5">
              Nazwa
            </TableHeader>
            <TableHeader class="w-1/5">
              Status
            </TableHeader>
            <TableHeader />
          </template>
          <template #body>
            <TableRow v-for="semester in semesters" :key="semester.id"
                      :class="semester.active === true ? 'bg-green-50' : ''"
            >
              <TableCell class="pr-12 opacity-75">
                {{ semester.id }}
              </TableCell>
              <TableCell>
                {{ semester.name }}
              </TableCell>
              <TableCell>
                {{ semester.active ? "aktywny" : "nieaktywny" }}
              </TableCell>
              <TableCell class="flex justify-end gap-2">
                <Button v-if="semester.status !== true" :method="Method.POST"
                        :href="`/dashboard/semesters/${semester.id}/activate`"
                >
                  <CheckIcon class="w-5" />
                </Button>
                <Button :href="`/dashboard/semesters/${semester.id}/edit`">
                  <Cog6ToothIcon class="w-5" />
                </Button>
                <Button class="text-red-600" @click="[showModal = true, semesterToDeleteId = semester.id]">
                  <XCircleIcon class="w-5" />
                </Button>
              </TableCell>
            </TableRow>
          </template>
        </TableWrapper>
      </div>
      <EmptyState v-else />
    </div>
  </DashboardLayout>

  <RemoveModal :show="showModal" :href="`/dashboard/semesters/${semesterToDeleteId}`" @close="showModal = false" />
</template>
