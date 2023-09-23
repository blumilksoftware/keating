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
})

function createSemester() {
  form.post('/dashboard/semesters')
}
</script>

<template>
  <DashboardLayout>
    <h3 class="text-base font-semibold leading-6 text-gray-900">
      Dodawanie semestru
    </h3>
    <form @submit.prevent="createSemester">
      <Section class="mt-3">
        <div class="flex justify-between">
          <FormGroup>
            <FormLabel for="name">
              Nazwa
            </FormLabel>
            <TextInput id="name" v-model="form.name" :error="form.errors.name" />
            <FormError :error="form.errors.name" class="mt-2" />
          </FormGroup>
        </div>
        <div class="flex justify-end space-x-3 py-3">
          <SecondaryButton href="/dashboard/semesters">
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
