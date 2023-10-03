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
import TextAreaEditor from '@/Shared/Forms/TextAreaEditor.vue'

defineProps({
  semesters: Array,
  classTypes: Array,
  studyForms: Array,
})

const form = useForm({
  name: '',
  abbreviation: '',
  description: '',
  semester: '',
  type: '',
  form: '',
})

function createCourse() {
  form.post('/dashboard/courses')
}
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
            Formularz dodawania nowego kursu
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
              <FormLabel for="name">
                Nazwa
              </FormLabel>
              <TextInput id="name" v-model="form.name" :error="form.errors.name" autocomplete="off" />
              <FormError :error="form.errors.name" />
            </FormGroup>
            <FormGroup>
              <FormLabel for="abbreviation">
                Skrótowiec
              </FormLabel>
              <TextInput id="abbreviation" v-model="form.abbreviation" :error="form.errors.abbreviation" autocomplete="off" />
              <FormError :error="form.errors.abbreviation" />
            </FormGroup>
            <FormGroup>
              <FormLabel for="semester">
                Semestr
              </FormLabel>
              <Select id="semester" v-model="form.semester" :error="form.errors.semester" :options="semesters" item-value="name" />
              <FormError :error="form.errors.semester" />
            </FormGroup>
            <FormGroup>
              <FormLabel for="type">
                Typ zajęć
              </FormLabel>
              <Select id="type" v-model="form.type" :error="form.errors.type" :options="classTypes" label="label" item-value="value" />
              <FormError :error="form.errors.type" />
            </FormGroup>
            <FormGroup>
              <FormLabel for="type">
                Tryb zajęć
              </FormLabel>
              <Select id="type" v-model="form.form" :error="form.errors.form" :options="studyForms" label="label" item-value="value" />
              <FormError :error="form.errors.type" />
            </FormGroup>
            <FormGroup>
              <FormLabel for="description">
                Opis
              </FormLabel>
              <TextAreaEditor id="description" v-model="form.description" :error="form.errors.description" autocomplete="off" />
              <FormError :error="form.errors.description" />
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
