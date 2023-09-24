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

const props = defineProps({
  contactInfo: Object,
})

const form = useForm({
  email: props.contactInfo.email,
  github_handle: props.contactInfo.github_handle,
  alternative_channel: props.contactInfo.alternative_channel,
})

function updateContact() {
  form.patch(`/dashboard/contact-info`)
}
</script>

<template>
  <DashboardLayout>
    <h3 class="text-base font-semibold leading-6 text-gray-900">
      Edycja form kontaktu
    </h3>
    <form @submit.prevent="updateContact">
      <Section class="mt-3">
        <div class="flex justify-between">
          <FormGroup>
            <FormLabel for="email">
              E-mail uczelniany
            </FormLabel>
            <TextInput id="email" v-model="form.email" :error="form.errors.email" type="email" />
            <FormError :error="form.errors.email" class="mt-2" />
          </FormGroup>
          <FormGroup>
            <FormLabel for="github_handle">
              Github link
            </FormLabel>
            <TextInput id="github_handle" v-model="form.github_handle" :error="form.errors.github_handle" />
            <FormError :error="form.errors.github_handle" class="mt-2" />
          </FormGroup>
          <FormGroup>
            <FormLabel for="alternative_channel">
              Alternatywny kontakt
            </FormLabel>
            <TextInput id="alternative_channel" v-model="form.alternative_channel" :error="form.errors.alternative_channel" />
            <FormError :error="form.errors.alternative_channel" class="mt-2" />
          </FormGroup>
        </div>
        <div class="flex justify-end space-x-3 py-3">
          <SecondaryButton href="/dashboard">
            Cofnij
          </SecondaryButton>
          <SubmitButton>
            Zapisz
          </SubmitButton>
        </div>
      </Section>
    </form>
  </DashboardLayout>
</template>
