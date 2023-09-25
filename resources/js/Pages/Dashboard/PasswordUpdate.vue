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
  current_password: '',
  password: '',
  password_confirmation: '',
})

function updatePassword() {
  form.patch('/dashboard/password', {
    preserveScroll: true,
    onSuccess: () => {
      form.reset()
    },
  })
}
</script>

<template>
  <DashboardLayout>
    <h3 class="text-base font-semibold leading-6 text-gray-900">
      Edycja hasła
    </h3>
    <form @submit.prevent="updatePassword">
      <Section class="mt-3">
        <div class="flex justify-between">
          <FormGroup>
            <FormLabel for="current_password">
              Aktualne hasło
            </FormLabel>
            <TextInput id="current_password" v-model="form.current_password" :error="form.errors.current_password" type="password" />
            <FormError :error="form.errors.current_password" class="mt-2" />
          </FormGroup>
          <FormGroup>
            <FormLabel for="password">
              Nowe hasło
            </FormLabel>
            <TextInput id="password" v-model="form.password" :error="form.errors.password" type="password" />
            <FormError :error="form.errors.password" class="mt-2" />
          </FormGroup>
          <FormGroup>
            <FormLabel for="password_confirmation">
              Potwierdź nowe hasło
            </FormLabel>
            <TextInput id="password_confirmation" v-model="form.password_confirmation" :error="form.errors.password_confirmation" type="password" />
            <FormError :error="form.errors.password_confirmation" class="mt-2" />
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
