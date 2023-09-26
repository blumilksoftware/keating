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
  label: '',
  link: '',
})

function createContactInfo() {
  form.post('/dashboard/contact-infos')
}
</script>

<template>
  <DashboardLayout>
    <h3 class="text-base font-semibold leading-6 text-gray-900">
      Dodawanie form kontaktu
    </h3>
    <form @submit.prevent="createContactInfo">
      <Section class="mt-3">
        <div class="flex justify-between">
          <FormGroup>
            <FormLabel for="label">
              Etykieta
            </FormLabel>
            <TextInput id="label" v-model="form.label" :error="form.errors.label" />
            <FormError :error="form.errors.label" class="mt-2" />
          </FormGroup>
          <FormGroup>
            <FormLabel for="link">
              Link do kontaktu
            </FormLabel>
            <TextInput id="link" v-model="form.link" :error="form.errors.link" />
            <FormError :error="form.errors.link" class="mt-2" />
          </FormGroup>
        </div>
        <div class="flex justify-end space-x-3 py-3">
          <SecondaryButton href="/dashboard/contact-infos">
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
