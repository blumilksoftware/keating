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

const form = useForm({
  first_name: '',
  surname: '',
  index_number: '',
})

function createStudent() {
  form.post('/dashboard/students')
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
            Formularz dodawania nowego studenta
          </ManagementHeaderItem>
        </template>
      </ManagementHeader>

      <form class="grid grid-cols-2" @submit.prevent="createStudent">
        <Section>
          <div class="flex flex-col justify-between gap-4">
            <FormGroup>
              <FormLabel for="id">
                Id
              </FormLabel>
              <TextInput class="opacity-75" placeholder="autogenerowany ulid" autocomplete="off" disabled />
            </FormGroup>
            <FormGroup>
              <FormLabel for="first_name">
                Imię
              </FormLabel>
              <TextInput id="first_name" v-model="form.first_name" :error="form.errors.first_name" autocomplete="off" />
              <FormError :error="form.errors.first_name" />
            </FormGroup>
            <FormGroup>
              <FormLabel for="surname">
                Nazwisko
              </FormLabel>
              <TextInput id="surname" v-model="form.surname" :error="form.errors.surname" autocomplete="off" />
              <FormError :error="form.errors.surname" />
            </FormGroup>
            <FormGroup>
              <FormLabel for="index_number">
                Numer indeksu
              </FormLabel>
              <TextInput id="index_number" v-model="form.index_number" type="number" min="1" :error="form.errors.index_number" autocomplete="off" />
              <FormError :error="form.errors.index_number" />
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
