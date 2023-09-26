<script setup>
import DashboardLayout from '@/Layouts/DashboardLayout.vue'
import Section from '@/Shared/Components/Section.vue'
import SubmitButton from '@/Shared/Components/Buttons/SubmitButton.vue'
import FormGroup from '@/Shared/Forms/FormGroup.vue'
import FormLabel from '@/Shared/Forms/FormLabel.vue'
import TextInput from '@/Shared/Forms/TextInput.vue'
import { useForm } from '@inertiajs/inertia-vue3'
import FormError from '@/Shared/Forms/FormError.vue'
import ManagementHeaderItem from '@/Shared/Components/ManagementHeaderItem.vue'
import ManagementHeader from '@/Shared/Components/ManagementHeader.vue'

const props = defineProps({
  student: Object,
})

const form = useForm({
  name: props.student.name,
  surname: props.student.surname,
  index_number: props.student.index_number,
})

function updateStudent() {
  form.patch(`/dashboard/students/${props.student.id}`)
}
</script>

<template>
  <DashboardLayout>
    <div class="flex flex-col gap-8">
      <ManagementHeader>
        <template #header>
          Zarządzanie studentami
        </template>
        <template #statistics>
          <ManagementHeaderItem>
            Formularz edycji studenta {{ props.student.name }} {{ props.student.surname }} (#{{ student.index_number }})
          </ManagementHeaderItem>
        </template>
      </ManagementHeader>

      <form class="grid grid-cols-2" @submit.prevent="updateStudent">
        <Section>
          <div class="flex flex-col justify-between gap-4">
            <FormGroup>
              <FormLabel for="id">
                Id
              </FormLabel>
              <TextInput class="opacity-75" :placeholder="student.id" autocomplete="off" disabled />
            </FormGroup>
            <FormGroup>
              <FormLabel for="name">
                Imię
              </FormLabel>
              <TextInput id="name" v-model="form.name" :error="form.errors.name" />
              <FormError :error="form.errors.name" />
            </FormGroup>
            <FormGroup>
              <FormLabel for="surname">
                Nazwisko
              </FormLabel>
              <TextInput id="surname" v-model="form.surname" :error="form.errors.surname" />
              <FormError :error="form.errors.surname" />
            </FormGroup>
            <FormGroup>
              <FormLabel for="index_number">
                Numer indeksu
              </FormLabel>
              <TextInput id="index_number" v-model="form.index_number" type="number" min="1" :error="form.errors.index_number" />
              <FormError :error="form.errors.index_number" />
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
