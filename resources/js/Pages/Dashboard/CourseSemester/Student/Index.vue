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
import { XCircleIcon, PlusIcon } from '@heroicons/vue/24/outline'
import ManagementHeader from '@/Shared/Components/ManagementHeader.vue'
import ManagementHeaderItem from '@/Shared/Components/ManagementHeaderItem.vue'

const props = defineProps({
  course: Object,
  group: Object,
  students: Array,
  availableStudents: Array,
  search: String,
  total: Number,
  lastUpdate: String,
})
const showModal = ref(false)
const studentToDeleteId = ref(0)
const studentsFormOpen = ref(false)
const form = useForm({
  search: props.search,
})

function addStudent(id) {
  Inertia.post(`/dashboard/course-semester/${props.course.data.id}/groups/${props.group.id}/students`, {
    student: id,
  }, {
    preserveState: true,
  })
}

watch(form, debounce(() => {
  Inertia.get(`/dashboard/course-semester/${props.course.data.id}/groups/${props.group.id}/students`, {
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
          Zarządzanie studentami w grupie <span class="text-gray-500">{{ group.name }}</span><br>
          dla kursu <span class="text-gray-500">{{ course.data.course }}</span>
        </template>
        <template #statistics>
          <ManagementHeaderItem>
            Liczba studentów w grupie: {{ total }}
          </ManagementHeaderItem>
          <ManagementHeaderItem v-if="students.total">
            Liczba studentów w tabeli: {{ students.total }}
          </ManagementHeaderItem>
          <ManagementHeaderItem v-if="lastUpdate">
            Ostatnie zmiany: {{ lastUpdate }}
          </ManagementHeaderItem>
        </template>
        <template #actions>
          <Button @click="[studentsFormOpen = !studentsFormOpen]">
            Dodaj
          </Button>
        </template>
      </ManagementHeader>
      <div v-if="studentsFormOpen" class="border-2 border-dotted p-4 sm:rounded-lg">
        <TextInput id="search" v-model="form.search" placeholder="Szukaj studentów do dodania" type="search"
                   class="mb-5 max-w-lg"
        />
        <div v-if="availableStudents.length" class="grid max-h-64 grid-cols-3 gap-4 overflow-y-auto">
          <div v-for="student in availableStudents" :key="student.id"
               class="flex h-max cursor-pointer items-center justify-between overflow-x-auto bg-white p-4 text-left sm:rounded-lg"
          >
            <div>
              {{ student.first_name }} {{ student.surname }} <br>
              {{ student.index_number }}
            </div>
            <div>
              <Button @click="addStudent(student.id)">
                <PlusIcon class="w-5" />
              </Button>
            </div>
          </div>
        </div>
        <EmptyState v-else />
      </div>
      <div v-if="students.length" class="flex flex-col gap-8">
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
            <TableRow v-for="student in students" :key="student.id">
              <TableCell class="pr-12 opacity-75">
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
                <Button class="text-red-600" @click="[showModal = true, studentToDeleteId = student.id]">
                  <XCircleIcon class="w-5" />
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
