<script setup>
import DashboardLayout from '@/Layouts/DashboardLayout.vue'
import Section from '@/Shared/Components/Section.vue'
import SubmitButton from '@/Shared/Components/Buttons/SubmitButton.vue'
import FormGroup from '@/Shared/Forms/FormGroup.vue'
import FormLabel from '@/Shared/Forms/FormLabel.vue'
import TextInput from '@/Shared/Forms/TextInput.vue'
import SecondaryButton from '@/Shared/Components/Buttons/SecondaryButton.vue'
import { useForm } from '@inertiajs/inertia-vue3'
import FormError from '@/Shared/Forms/FormError.vue'

const form = useForm({
  name: '',
  surname: '',
  index_number: '',
})

function createStudent() {
  form.post('/dashboard/students')
}
</script>

<template>
  <DashboardLayout>
    <h3 class="text-base font-semibold leading-6 text-gray-900">
      Dodawanie studenta
    </h3>
    <form @submit.prevent="createStudent">
      <Section class="mt-3">
        <div class="flex justify-between">
          <FormGroup>
            <FormLabel for="name">
              Imię
            </FormLabel>
            <TextInput id="name" v-model="form.name" :error="form.errors.name" />
            <FormError :error="form.errors.name" class="mt-2" />
          </FormGroup>
          <FormGroup>
            <FormLabel for="surname">
              Nazwisko
            </FormLabel>
            <TextInput id="surname" v-model="form.surname" :error="form.errors.surname" />
            <FormError :error="form.errors.surname" class="mt-2" />
          </FormGroup>
          <FormGroup>
            <FormLabel for="index_number">
              Numer indeksu
            </FormLabel>
            <TextInput id="index_number" v-model="form.index_number" type="number" min="1" :error="form.errors.index_number" />
            <FormError :error="form.errors.index_number" class="mt-2" />
          </FormGroup>
        </div>
        <div class="flex justify-end space-x-3 py-3">
          <SecondaryButton href="/dashboard/students">
            Cofnij
          </SecondaryButton>
          <SubmitButton>
            Utwórz
          </SubmitButton>
        </div>
      </Section>
    </form>
  </DashboardLayout>
</template>
