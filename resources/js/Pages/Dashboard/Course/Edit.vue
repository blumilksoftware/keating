<script setup>
import DashboardLayout from '@/Layouts/DashboardLayout.vue'
import Section from '@/Shared/Components/Section.vue'
import Select from '@/Shared/Forms/Select.vue'
import SubmitButton from '@/Shared/Components/Buttons/SubmitButton.vue'
import FormGroup from '@/Shared/Forms/FormGroup.vue'
import FormLabel from '@/Shared/Forms/FormLabel.vue'
import TextInput from '@/Shared/Forms/TextInput.vue'
import { useForm } from '@inertiajs/inertia-vue3'
import FormError from '@/Shared/Forms/FormError.vue'
import ManagementHeader from '@/Shared/Components/ManagementHeader.vue'
import ManagementHeaderItem from '@/Shared/Components/ManagementHeaderItem.vue'
import TextAreaEditor from '../../../Shared/Forms/TextAreaEditor.vue'


const props = defineProps({
  course: Object,
  classTypes: Array,
  fields: Array,
  semesterNames: Array,
})


const form = useForm({
  name: props.course.name,
  abbreviation: props.course.abbreviation,
  description: props.course.description,
  semester: props.course.semester,
  type: props.course.type,
  field_id: props.course.field_id,
  semester_name: props.course.semester_name,
})

function updateCourse() {
  form.patch(`/dashboard/courses/${props.course.id}`)
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
            Formularz edycji istniejącego kursu
          </ManagementHeaderItem>
        </template>
      </ManagementHeader>

      <form class="grid grid-cols-2" @submit.prevent="updateCourse">
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
              <TextInput id="semester" v-model="form.semester" type="number" min="1" max="10" :error="form.errors.semester" autocomplete="off" />
              <FormError :error="form.errors.semester" />
            </FormGroup>
            <FormGroup>
              <FormLabel for="semesterName">
                Nazwa semestru
              </FormLabel>
              <Select id="semesterName" v-model="form.semester_name" :error="form.errors.semester_name" :options="semesterNames" label="label" item-value="value" />
              <FormError :error="form.errors.semester_name" />
            </FormGroup>
            <FormGroup>
              <FormLabel for="type">
                Typ zajęć
              </FormLabel>
              <Select id="type" v-model="form.type" :error="form.errors.type" :options="classTypes" label="label" item-value="value" />
              <FormError :error="form.errors.type" />
            </FormGroup>
            <FormGroup>
              <FormLabel for="field">
                Kierunek/specjalność
              </FormLabel>
              <Select id="field" v-model="form.field_id" :error="form.errors.field_id" :options="fields" label="name" item-value="id" />
              <FormError :error="form.errors.field_id" />
            </FormGroup>
            <FormGroup>
              <FormLabel for="description">
                Opis
              </FormLabel>
              <TextAreaEditor id="description" v-model="form.description" />
              <FormError :error="form.errors.description" />
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
