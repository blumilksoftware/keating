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
import ManagementHeader from '@/Shared/Components/ManagementHeader.vue'
import ManagementHeaderItem from '@/Shared/Components/ManagementHeaderItem.vue'
import { PencilSquareIcon, XCircleIcon, EyeIcon } from '@heroicons/vue/24/outline'
import StyledLink from '@/Shared/Components/StyledLink.vue'

defineProps({
  courses: Object,
  activeSemester: Object,
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
          Zarządzanie kursami w semestrze
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
            <StyledLink :href="`/dashboard/semester-courses/create`">
              Dodaj
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
            <TableHeader class="w-1/6">
              Kurs
            </TableHeader>
            <TableHeader class="w-1/6">
              Semestr
            </TableHeader>
            <TableHeader class="w-1/6">
              Liczba grup
            </TableHeader>
            <TableHeader />
          </template>
          <template #body>
            <TableRow v-for="course in courses" :key="course.id">
              <TableCell class="pr-12 opacity-75">
                {{ course.id }}
              </TableCell>
              <TableCell>
                {{ course.course }}
              </TableCell>
              <TableCell>
                <div class="inline-flex items-center">
                  <span v-if="course.semesterId === activeSemester?.id">
                    <svg class="mr-1.5 size-1.5 fill-green-500" viewBox="0 0 8 8" aria-hidden="true">
                      <circle cx="4" cy="4" r="4" />
                    </svg>
                  </span>
                  {{ course.semester }}
                </div>
              </TableCell>
              <TableCell>
                {{ course.groupsCount }}
              </TableCell>
              <TableCell class="flex justify-end gap-2">
                <StyledLink :href="`/dashboard/semester-courses/${course.id}`">
                  <EyeIcon class="w-5" />
                </StyledLink>
                <StyledLink :href="`/dashboard/semester-courses/${course.id}/edit`">
                  <PencilSquareIcon class="w-5" />
                </StyledLink>
                <Button class="text-red-600" @click="[showModal = true, courseToDeleteId = course.id]">
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

  <RemoveModal :show="showModal" :href="`/dashboard/semester-courses/${courseToDeleteId}`" @close="showModal = false" />
</template>
