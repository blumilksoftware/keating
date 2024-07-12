<script setup>
import DashboardLayout from '@/Layouts/DashboardLayout.vue'
import TableHeader from '@/Shared/Components/Table/TableHeader.vue'
import TableWrapper from '@/Shared/Components/Table/TableWrapper.vue'
import TableRow from '@/Shared/Components/Table/TableRow.vue'
import TableCell from '@/Shared/Components/Table/TableCell.vue'
import FormGroup from '@/Shared/Forms/FormGroup.vue'
import FormLabel from '@/Shared/Forms/FormLabel.vue'
import FormError from '@/Shared/Forms/FormError.vue'
import SubmitButton from '@/Shared/Components/Buttons/SubmitButton.vue'
import { Inertia } from '@inertiajs/inertia'
import { useForm } from '@inertiajs/inertia-vue3'
import TextInput from '@/Shared/Forms/TextInput.vue'
import ManagementHeader from '@/Shared/Components/ManagementHeader.vue'
import ManagementHeaderItem from '@/Shared/Components/ManagementHeaderItem.vue'
import { ref, watch } from 'vue'
import RemoveModal from '@/Shared/Modals/RemoveModal.vue'
import Section from '@/Shared/Components/Section.vue'
import Button from '@/Shared/Components/Buttons/Button.vue'
import { ArrowLeftIcon, ArrowRightIcon, PencilSquareIcon, TrashIcon } from '@heroicons/vue/24/outline'
import GradeCell from '@/Shared/Components/GradeCell.vue'
import { debounce } from 'lodash'
import Pagination from '@/Shared/Components/Pagination.vue'

const props = defineProps({
  course: Object,
  group: Object,
  students: Object,
  gradeColumns: Array,
  search: String,
  total: Number,
})
const showModal = ref(false)
const showEditForm = ref(false)
const showCreateForm = ref(false)
const columnToDeleteId = ref(0)
const columnToEdit = ref({})
const showColumnMenu = ref(false)
const form = useForm({
  name: '',
  active: true,
})
const editForm = useForm({
  name: '',
  active: false,
})

function createGradeColumn() {
  form.post(`/dashboard/semester-courses/${props.course.data.id}/groups/${props.group.id}/grades`, {
    preserveScroll: true,
  })
  form.reset()
}

function updateGradeColumn() {
  editForm.patch(`/dashboard/semester-courses/${props.course.data.id}/groups/${props.group.id}/grades/${columnToEdit.value.id}`, {
    preserveScroll: true,
  })
  showEditForm.value = false
  editForm.reset()
}

function updateGrade(gradeColumnId, studentId, value, status) {
  Inertia.patch(`/dashboard/semester-courses/${props.course.data.id}/groups/${props.group.id}/grades/${gradeColumnId}/update`, {
    status: status,
    value: value,
    student_id: studentId,
  }, {
    preserveScroll: true,
  })
}

function createGrade(gradeColumnId, studentId, status) {
  Inertia.post(`/dashboard/semester-courses/${props.course.data.id}/groups/${props.group.id}/grades/${gradeColumnId}/store`, {
    status: status,
    student_id: studentId,
  }, {
    preserveScroll: true,
  })
}

function editColumn(column) {
  columnToEdit.value = column
  editForm.name = column.name
  editForm.active = column.active
  showCreateForm.value = false
  showEditForm.value = true
}

function reorder(id, down) {
  Inertia.post(`/dashboard/semester-courses/${props.course.data.id}/groups/${props.group.id}/grades/${id}/reorder/${down}`, {}, {
    preserveScroll: true,
  })
}

const searchForm = useForm({
  search: props.search ?? '',
})

watch(searchForm, debounce(() => {
  Inertia.get(`/dashboard/semester-courses/${props.course.data.id}/groups/${props.group.id}/grades`, {
    search: searchForm.search,
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
          Zarządzanie ocenami w grupie <span class="text-gray-500">{{ group.name }}</span><br>
          dla kursu <span class="text-gray-500">{{ course.data.course }}</span>
        </template>
        <template #statistics>
          <ManagementHeaderItem>
            Liczba studentów w grupie: {{ total }}
          </ManagementHeaderItem>
          <ManagementHeaderItem v-if="students.total">
            Liczba studentów w tabeli: {{ students.total }}
          </ManagementHeaderItem>
        </template>
        <template #actions>
          <TextInput id="filter" v-model="searchForm.search" class="max-w-lg" placeholder="Szukaj" type="search" />
          <Button @click="[showCreateForm = true, showEditForm = false]">
            Dodaj kolumnę
          </Button>
        </template>
      </ManagementHeader>
      <div class="flex flex-col gap-8">
        <form v-if="!showEditForm && showCreateForm" class="grid grid-cols-2" @submit.prevent="createGradeColumn">
          <Section>
            <div class="flex flex-col justify-between gap-4">
              <FormGroup>
                <FormLabel for="name">
                  Nazwa kolumny
                </FormLabel>
                <TextInput id="name" v-model="form.name" :error="form.errors.name" autocomplete="off" />
                <FormError :error="form.errors.name" />
              </FormGroup>
              <FormGroup class="flex items-center">
                <input id="active" v-model="form.active" class="mr-3" type="checkbox">
                <FormLabel class="!m-0" for="active">
                  Aktywna
                </FormLabel>
              </FormGroup>
              <div class="mt-4 flex justify-end">
                <Button class="mr-3" @click="[showCreateForm = false]">
                  Zamknij
                </Button>
                <SubmitButton>
                  Utwórz
                </SubmitButton>
              </div>
            </div>
          </Section>
        </form>
        <form v-if="showEditForm && !showCreateForm" class="grid grid-cols-2" @submit.prevent="updateGradeColumn">
          <Section>
            <div class="flex flex-col justify-between gap-4">
              <FormGroup>
                <FormLabel for="name">
                  Nazwa
                </FormLabel>
                <TextInput id="name" v-model="editForm.name" :error="editForm.errors.name" autocomplete="off" />
                <FormError :error="editForm.errors.name" />
              </FormGroup>
              <FormGroup class="flex items-center">
                <input id="active" v-model="editForm.active" class="mr-3" type="checkbox">
                <FormLabel class="!m-0" for="active">
                  Aktywna
                </FormLabel>
              </FormGroup>
              <div class="mt-4 flex justify-end">
                <Button class="mr-3" @click="[showEditForm = false]">
                  Zamknij
                </Button>
                <SubmitButton>
                  Zapisz
                </SubmitButton>
              </div>
            </div>
          </Section>
        </form>
        <TableWrapper>
          <template #header>
            <TableHeader>
              Numer indeksu
            </TableHeader>
            <TableHeader v-for="(column, index) in gradeColumns" :key="column.id"
                         v-auto-animate="{ duration: 100 }"
                         :class="[column.active ? '' : 'bg-gray-300 text-white']"
                         class="w-[70px] cursor-pointer border-2 border-solid text-center"
            >
              <div v-if="showColumnMenu" class="mb-5 flex grow justify-between">
                <ArrowLeftIcon v-if="index === 0" class="w-6 text-gray-400" />
                <div v-else title="Move Up" @click="reorder(column.id, 1)"
                     @keydown.prevent.stop.space="reorder(column.id, 1)"
                >
                  <ArrowLeftIcon class="w-6 hover:text-gray-500" />
                </div>
                <ArrowRightIcon v-if="index === gradeColumns.length - 1" class="w-6 text-gray-400" />
                <div v-else title="Move Down" @click="reorder(column.id, 0)"
                     @keydown.prevent.stop.space="reorder(column.id, 0)"
                >
                  <ArrowRightIcon class="w-6 hover:text-gray-500" />
                </div>
              </div>
              <span @click="showColumnMenu = !showColumnMenu">
                {{ column.name }}
              </span>
              <div v-if="showColumnMenu" class="mt-5 flex grow justify-between">
                <PencilSquareIcon class="w-6" @click="editColumn(column)" />
                <TrashIcon class="w-6" @click="[columnToDeleteId = column.id, showModal = true]" />
              </div>
            </TableHeader>
          </template>
          <template #body>
            <TableRow v-for="student in students.data" :key="student.id">
              <TableCell class="h-[70px] w-[120px] min-w-[120px] cursor-pointer flex-row border-2">
                <div class="font-bold">
                  {{ student.first_name }} {{ student.surname }}
                </div>
                <div>({{ student.index_number }})</div>
              </TableCell>
              <GradeCell v-for="column in gradeColumns" :key="column.id"
                         :grade="column.grades.find(obj => obj.student_id === student.id)" :grade-column="column"
                         :student="student" class="cursor-pointer border-2"
                         @create-grade="createGrade" @update-grade="updateGrade"
              />
            </TableRow>
          </template>
        </TableWrapper>
        <Pagination :pagination="students" />
      </div>
    </div>
  </DashboardLayout>
  <RemoveModal
    :href="`/dashboard/semester-courses/${props.course.data.id}/groups/${props.group.id}/grades/${columnToDeleteId}`"
    :show="showModal"
    @close="showModal = false"
  />
</template>
