<script setup>
import DashboardLayout from '@/Layouts/DashboardLayout.vue'
import Section from '@/Shared/Components/Section.vue'
import SubmitButton from '@/Shared/Components/Buttons/SubmitButton.vue'
import FormGroup from '@/Shared/Forms/FormGroup.vue'
import FormLabel from '@/Shared/Forms/FormLabel.vue'
import Select from '@/Shared/Forms/Select.vue'
import TextInput from '@/Shared/Forms/TextInput.vue'
import { useForm } from '@inertiajs/inertia-vue3'
import FormError from '@/Shared/Forms/FormError.vue'
import ManagementHeader from '@/Shared/Components/ManagementHeader.vue'
import ManagementHeaderItem from '@/Shared/Components/ManagementHeaderItem.vue'

defineProps({
  courses: Array,
  semesters: Array,
})

const form = useForm({
  course: '',
  semester: '',
})

function createCourse() {
  form.post('/dashboard/semester-courses')
}
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
            Formularz dodawania nowego kursu w semestrze
          </ManagementHeaderItem>
        </template>
      </ManagementHeader>
      <form class="grid grid-cols-2" @submit.prevent="createCourse">
        <Section>
          <div class="flex flex-col justify-between gap-4">
            <FormGroup>
              <FormLabel for="id">
                Id
              </FormLabel>
              <TextInput class="opacity-75" placeholder="autogenerowany ulid" autocomplete="off" disabled />
            </FormGroup>
            <FormGroup>
              <FormLabel for="course">
                Kurs
              </FormLabel>
              <Select id="course" v-model="form.course" :error="form.errors.course" :options="courses" label="name" item-value="id" />
              <FormError :error="form.errors.course" />
            </FormGroup>
            <FormGroup>
              <FormLabel for="semester">
                Semestr
              </FormLabel>
              <Select id="semester" v-model="form.semester" :error="form.errors.semester" :options="semesters" label="name" item-value="id" />
              <FormError :error="form.errors.semester" />
            </FormGroup>
            <div class="mt-4 flex justify-end">
              <SubmitButton>
                Utwórz
              </SubmitButton>
            </div>
          </div>
        </Section>
      </form>
    </div>
  </DashboardLayout>
</template>
