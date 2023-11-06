<script setup>
import DashboardLayout from '@/Layouts/DashboardLayout.vue'
import Section from '@/Shared/Components/Section.vue'
import SubmitButton from '@/Shared/Components/Buttons/SubmitButton.vue'
import FormGroup from '@/Shared/Forms/FormGroup.vue'
import FormLabel from '@/Shared/Forms/FormLabel.vue'
import TextInput from '@/Shared/Forms/TextInput.vue'
import { useForm } from '@inertiajs/inertia-vue3'
import FormError from '@/Shared/Forms/FormError.vue'
import ManagementHeader from '@/Shared/Components/ManagementHeader.vue'
import ManagementHeaderItem from '@/Shared/Components/ManagementHeaderItem.vue'

const props = defineProps({
  settings: Object,
})

const form = useForm({
  teacher_name: props.settings.teacher_name,
  teacher_email: props.settings.teacher_email,
  teacher_titles: props.settings.teacher_titles,
  university_name: props.settings.university_name,
  department_name: props.settings.department_name,
})

function updateSettings() {
  form.patch(`/dashboard/settings`)
}
</script>

<template>
  <DashboardLayout>
    <div class="flex flex-col gap-8">
      <ManagementHeader>
        <template #header>
          Zarządzanie ustawieniami
        </template>
        <template #statistics>
          <ManagementHeaderItem>
            Formularz edycji ustawień
          </ManagementHeaderItem>
        </template>
      </ManagementHeader>
      <form class="grid grid-cols-2" @submit.prevent="updateSettings">
        <Section>
          <div class="flex flex-col justify-between gap-4">
            <FormGroup>
              <FormLabel for="id">
                Id
              </FormLabel>
              <TextInput class="opacity-75" :placeholder="settings.id" autocomplete="off" disabled />
            </FormGroup>
            <FormGroup>
              <FormLabel for="teacher_name">
                Imię i nazwisko nauczyciela
              </FormLabel>
              <TextInput id="teacher_name" v-model="form.teacher_name" :error="form.errors.teacher_name" autocomplete="off" />
              <FormError :error="form.errors.teacher_name" />
            </FormGroup>
            <FormGroup>
              <FormLabel for="teacher_email">
                E-mail nauczyciela
              </FormLabel>
              <TextInput id="teacher_email" v-model="form.teacher_email" :error="form.errors.teacher_email" autocomplete="off" />
              <FormError :error="form.errors.teacher_email" />
            </FormGroup>
            <FormGroup>
              <FormLabel for="teacher_titles">
                Tytuły nauczyciela
              </FormLabel>
              <TextInput id="teacher_titles" v-model="form.teacher_titles" :error="form.errors.teacher_titles" autocomplete="off" />
              <FormError :error="form.errors.teacher_titles" />
            </FormGroup>
            <FormGroup>
              <FormLabel for="university_name">
                Nazwa uczelni
              </FormLabel>
              <TextInput id="university_name" v-model="form.university_name" :error="form.errors.university_name" autocomplete="off" />
              <FormError :error="form.errors.university_name" />
            </FormGroup>
            <FormGroup>
              <FormLabel for="department_name">
                Nazwa wydziału
              </FormLabel>
              <TextInput id="department_name" v-model="form.department_name" :error="form.errors.department_name" autocomplete="off" />
              <FormError :error="form.errors.department_name" />
            </FormGroup>
            <div class="mt-4 flex justify-end">
              <SubmitButton>
                Zapisz
              </SubmitButton>
            </div>
          </div>
        </Section>
      </form>
    </div>
  </DashboardLayout>
</template>
