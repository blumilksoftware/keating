<script setup>
import DashboardLayout from '@/Layouts/DashboardLayout.vue'
import Section from '@/Shared/Components/Section.vue'
import SubmitButton from '@/Shared/Components/Buttons/SubmitButton.vue'
import FormGroup from '@/Shared/Forms/FormGroup.vue'
import FormLabel from '@/Shared/Forms/FormLabel.vue'
import TextInput from '@/Shared/Forms/TextInput.vue'
import Button from '@/Shared/Components/Buttons/Button.vue'
import { useForm } from '@inertiajs/inertia-vue3'
import FormError from '@/Shared/Forms/FormError.vue'
import ManagementHeader from '@/Shared/Components/ManagementHeader.vue'
import ManagementHeaderItem from '@/Shared/Components/ManagementHeaderItem.vue'
import RemoveModal from '@/Shared/Modals/RemoveModal.vue'
import { Cog6ToothIcon, UsersIcon, XCircleIcon } from '@heroicons/vue/24/outline'
import { ref } from 'vue'

const props = defineProps({
  course: Object,
  groups: Array,
})
const showModal = ref(false)
const groupToDeleteId = ref(0)
const groupToEdit = ref(0)
const showEditForm = ref(false)
const form = useForm({
  name: '',
})
const editForm = useForm({
  name: '',
})

function editGroup(group) {
  groupToEdit.value = group
  editForm.name = group.name
  showEditForm.value = true
}

function createGroup() {
  form.post(`/dashboard/course-semester/${props.course.data.id}/groups`, {
    onSuccess: () => {
      form.reset()
    },
  })
}

function updateGroup() {
  editForm.patch(`/dashboard/course-semester/${props.course.data.id}/groups/${groupToEdit.value.id}`, {
    onSuccess: () => {
      showEditForm.value = false
    },
  })
}
</script>

<template>
  <DashboardLayout>
    <div class="flex flex-col gap-8">
      <ManagementHeader>
        <template #header>
          Pdogląd i zarządzanie kursem w semestrze
        </template>
        <template #statistics>
          <ManagementHeaderItem>
            Formularz podglądu kursu w semestrze
          </ManagementHeaderItem>
        </template>
      </ManagementHeader>
      <div class="grid grid-cols-2 gap-4">
        <Section>
          <div class="flex flex-col justify-between gap-4">
            <FormGroup>
              <FormLabel for="id">
                Id
              </FormLabel>
              <TextInput :placeholder="course.data.id" autocomplete="off" disabled />
            </FormGroup>
            <FormGroup>
              <FormLabel for="course">
                Kurs
              </FormLabel>
              <TextInput :placeholder="course.data.course" autocomplete="off" disabled />
            </FormGroup>
            <FormGroup>
              <FormLabel for="semester">
                Semestr
              </FormLabel>
              <TextInput :placeholder="course.data.semester" autocomplete="off" disabled />
            </FormGroup>
            <FormGroup>
              <FormLabel for="type">
                Tryb studiów
              </FormLabel>
              <TextInput :placeholder="course.data.form" autocomplete="off" disabled />
            </FormGroup>
          </div>
        </Section>
      </div>
      <ManagementHeader v-if="!showEditForm">
        <template #header>
          Dodawanie grupy w kursie
        </template>
        <template #statistics>
          <ManagementHeaderItem>
            Formularz dodawania grupy w kursie
          </ManagementHeaderItem>
        </template>
      </ManagementHeader>
      <ManagementHeader v-else>
        <template #header>
          Edycja grupy w kursie
        </template>
        <template #statistics>
          <ManagementHeaderItem>
            Formularz edycji grupy w kursie
          </ManagementHeaderItem>
        </template>
      </ManagementHeader>
      <div class="grid grid-cols-2 gap-4">
        <Section class="h-max">
          <form v-if="!showEditForm" @submit.prevent="createGroup">
            <div class="flex flex-col justify-between gap-4">
              <FormGroup>
                <FormLabel for="id">
                  Id
                </FormLabel>
                <TextInput class="opacity-75" placeholder="autogenerowany ulid" autocomplete="off" disabled />
              </FormGroup>
              <FormGroup>
                <FormLabel for="name">
                  Nazwa
                </FormLabel>
                <TextInput id="name" v-model="form.name" :error="form.errors.name" autocomplete="off" />
                <FormError :error="form.errors.name" />
              </FormGroup>
              <div class="mt-4 flex justify-end">
                <SubmitButton>
                  Utwórz
                </SubmitButton>
              </div>
            </div>
          </form>
          <form v-else class="gap-4" @submit.prevent="updateGroup">
            <div class="flex flex-col justify-between gap-4">
              <FormGroup>
                <FormLabel for="id">
                  Id
                </FormLabel>
                <TextInput class="opacity-75" :placeholder="groupToEdit.id" autocomplete="off" disabled />
              </FormGroup>
              <FormGroup>
                <FormLabel for="name">
                  Nazwa
                </FormLabel>
                <TextInput id="name" v-model="editForm.name" :error="editForm.errors.name" autocomplete="off" />
                <FormError :error="editForm.errors.name" />
              </FormGroup>
              <div class="mt-4 flex justify-end">
                <SubmitButton>
                  Zapisz
                </SubmitButton>
              </div>
            </div>
          </form>
        </Section>
        <div class="grid grid-cols-2 gap-4">
          <div v-for="group in groups" :key="group.id"
               class="flex h-max cursor-pointer items-center justify-between overflow-x-auto bg-white p-4 text-center sm:rounded-lg"
          >
            {{ group.name }}
            <div class="flex gap-2">
              <Button :href="`/dashboard/course-semester/${course.data.id}/groups/${group.id}/students`">
                <UsersIcon class="w-5" />
              </Button>
              <Button>
                <Cog6ToothIcon class="w-5" @click="editGroup(group)" />
              </Button>
              <Button class="text-red-600" @click="[showModal = true, showEditForm = false, groupToDeleteId = group.id]">
                <XCircleIcon class="w-5" />
              </Button>
            </div>
          </div>
        </div>
      </div>
    </div>
  </DashboardLayout>

  <RemoveModal :show="showModal" :href="`/dashboard/course-semester/${course.data.id}/groups/${groupToDeleteId}`"
               @close="showModal = false"
  />
</template>