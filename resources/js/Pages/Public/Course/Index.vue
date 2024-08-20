<script setup>
import PublicLayout from '@/Layouts/PublicLayout.vue'
import BackgroundGrid from '../../../Components/BackgroundGrid.vue'
import SectionHeader from '../../../Components/SectionHeader.vue'
import { ArrowRightCircleIcon } from '@heroicons/vue/24/outline'
import TableWrapper from '../../../Shared/Components/Table/Public/TableWrapper.vue'
import TableHeader from '../../../Shared/Components/Table/Public/TableHeader.vue'
import TableRow from '../../../Shared/Components/Table/Public/TableRow.vue'
import TableCell from '../../../Shared/Components/Table/Public/TableCell.vue'

defineProps({
  courses: Object,
})

</script>

<template>
  <PublicLayout>
    <div class="relative isolate bg-white">
      <BackgroundGrid />
      <div class="py-24 sm:py-32">
        <div class="mx-auto max-w-7xl px-6 lg:px-8">
          <SectionHeader>
            <template #header>
              Lista kursów
            </template>
            <template #subheader>
              Szczegółowe informacje dotyczące kursów
            </template>
          </SectionHeader>

          <div class="mx-auto mt-10 border-t border-gray-200 pt-10 sm:mt-16 sm:pt-16 lg:mx-0 lg:max-w-none lg:grid-cols-3">
            <div v-if="courses.length" class="flex flex-col gap-8">
              <TableWrapper>
                <template #header>
                  <TableHeader class="w-1/5">
                    Kod
                  </TableHeader>
                  <TableHeader class="w-1/5">
                    Pełna nazwa kursu
                  </TableHeader>
                  <TableHeader class="w-1/5">
                    Specjalność
                  </TableHeader>
                  <TableHeader class="w-1/5">
                    Semestr
                  </TableHeader>
                  <TableHeader class="w-1/5">
                    Forma
                  </TableHeader>
                  <TableHeader />
                </template>
                <template #body>
                  <TableRow v-for="course in courses" :key="course.id" :class="[course.active ? '' : 'bg-gray-100']">
                    <TableCell>
                      {{ course.abbreviation }}
                    </TableCell>
                    <TableCell>
                      {{ course.name }}
                    </TableCell>
                    <TableCell>
                      {{ course.fieldAbbreviation }}
                    </TableCell>
                    <TableCell>
                      {{ course.semester }}
                    </TableCell>
                    <TableCell>
                      {{ course.type }}
                    </TableCell>
                    <TableCell>
                      <InertiaLink :href="`kursy/${course.id}`">
                        <ArrowRightCircleIcon class="m-auto size-6 text-gray-500" />
                      </InertiaLink>
                    </TableCell>
                  </TableRow>
                </template>
              </TableWrapper>
            </div>
          </div>
        </div>
      </div>
    </div>
  </PublicLayout>
</template>
