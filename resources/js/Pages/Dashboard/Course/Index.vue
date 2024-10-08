<script setup>
import DashboardLayout from '@/Layouts/DashboardLayout.vue'
import TableHeader from '@/Shared/Components/Table/TableHeader.vue'
import TableWrapper from '@/Shared/Components/Table/TableWrapper.vue'
import TableRow from '@/Shared/Components/Table/TableRow.vue'
import TableCell from '@/Shared/Components/Table/TableCell.vue'
import Button from '@/Shared/Components/Buttons/Button.vue'
import EmptyState from '@/Shared/Components/EmptyState/EmptyState.vue'
import RemoveModal from '@/Shared/Modals/RemoveModal.vue'
import { ref } from 'vue'
import ManagementHeader from '@/Shared/Components/ManagementHeader.vue'
import ManagementHeaderItem from '@/Shared/Components/ManagementHeaderItem.vue'
import StyledLink from '@/Shared/Components/StyledLink.vue'

defineProps({
  courses: Object,
  total: Number,
  lastUpdate: String,
})
const showModal = ref(false)
const courseToDeleteId = ref(0)
</script>

<template>
  <DashboardLayout>
    <div class="flex flex-col gap-8">
      <ManagementHeader>
        <template #header>
          Zarządzanie kursami
        </template>
        <template #statistics>
          <ManagementHeaderItem>
            Liczba kursów w bazie: {{ total }}
          </ManagementHeaderItem>
          <ManagementHeaderItem v-if="lastUpdate">
            Ostatnie zmiany: {{ lastUpdate }}
          </ManagementHeaderItem>
        </template>
        <template #actions>
          <span class="hidden sm:block">
            <StyledLink :href="`/dashboard/courses/create`">
              dodaj
            </StyledLink>
          </span>
        </template>
      </ManagementHeader>
      <div v-if="courses.length" class="flex flex-col gap-8">
        <TableWrapper>
          <template #header>
            <TableHeader class="w-1/6">
              ID
            </TableHeader>
            <TableHeader class="w-1/5">
              Nazwa
            </TableHeader>
            <TableHeader class="w-1/6">
              Skrótowiec
            </TableHeader>
            <TableHeader class="w-1/6">
              Semestr
            </TableHeader>
            <TableHeader class="w-1/6">
              Forma
            </TableHeader>
            <TableHeader />
          </template>
          <template #body>
            <TableRow v-for="course in courses" :key="course.id">
              <TableCell class="pr-12 opacity-75">
                {{ course.id }}
              </TableCell>
              <TableCell>
                {{ course.name }}
              </TableCell>
              <TableCell>
                {{ course.abbreviation }}
              </TableCell>
              <TableCell>
                {{ course.semester }}
              </TableCell>
              <TableCell>
                {{ course.type }}
              </TableCell>
              <TableCell class="flex justify-end gap-2">
                <StyledLink :href="`/dashboard/courses/${course.id}/edit`">
                  edytuj
                </StyledLink>
                <Button class="text-red-600" @click="[showModal = true, courseToDeleteId = course.id]">
                  usuń
                </Button>
              </TableCell>
            </TableRow>
          </template>
        </TableWrapper>
      </div>
      <EmptyState v-else />
    </div>
  </DashboardLayout>

  <RemoveModal :show="showModal" :href="`/dashboard/courses/${courseToDeleteId}`" @close="showModal = false" />
</template>
