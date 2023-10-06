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
import FormGroup from '@/Shared/Forms/FormGroup.vue'
import FormLabel from '@/Shared/Forms/FormLabel.vue'
import Select from '@/Shared/Forms/Select.vue'
import { ref, watch } from 'vue'
import { Inertia } from '@inertiajs/inertia'
import { debounce } from 'lodash'
import TextInput from '@/Shared/Forms/TextInput.vue'
import { useForm } from '@inertiajs/inertia-vue3'
import { Cog6ToothIcon, XCircleIcon } from '@heroicons/vue/24/outline'
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
const form = useForm({
  search: props.search ?? '',
})
const studentForm = useForm({
  students: '',
})
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
          Zarządzanie studentami w grupie kursowej
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
          <TextInput v-if="total || form.search.length > 0" id="filter" v-model="form.search" placeholder="Szukaj" type="search" class="max-w-lg" />
          <FormGroup class="w-1/3">
            <FormLabel for="students">
              Studenci
            </FormLabel>
            <Select id="students" v-model="studentForm.students" :error="studentForm.errors.students" :options="availableStudents" label="index_number" item-value="id" />
            <FormError :error="studentForm.errors.students" />
          </FormGroup>
          <Button :href="`/dashboard/students/create`">
            Dodaj
          </Button>
        </template>
      </ManagementHeader>
      <div v-if="students.data.length" class="flex flex-col gap-8">
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
                {{ student.first_name }}
              </TableCell>
              <TableCell>
                {{ student.surname }}
              </TableCell>
              <TableCell class="flex justify-end gap-2">
                <Button :href="`students/${student.id}/edit`">
                  <Cog6ToothIcon class="w-5" />
                </Button>
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
