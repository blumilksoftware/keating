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
import ManagementHeader from '@/Shared/Components/ManagementHeader.vue'
import ManagementHeaderItem from '@/Shared/Components/ManagementHeaderItem.vue'

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

    <div class="flex flex-col gap-8">
      <ManagementHeader>
        <template #header>
          Zarządzanie profilem
        </template>
        <template #statistics>
          <ManagementHeaderItem>
            Formularz zmiany hasła
          </ManagementHeaderItem>
        </template>
      </ManagementHeader>

      <form class="grid grid-cols-2" @submit.prevent="updatePassword">
        <Section>
          <div class="flex flex-col justify-between gap-4">
            <FormGroup>
              <FormLabel for="current_password">
                Aktualne hasło
              </FormLabel>
              <TextInput id="current_password" v-model="form.current_password" :error="form.errors.current_password" type="password" />
              <FormError :error="form.errors.current_password" />
            </FormGroup>
            <FormGroup>
              <FormLabel for="password">
                Nowe hasło
              </FormLabel>
              <TextInput id="password" v-model="form.password" :error="form.errors.password" type="password" />
              <FormError :error="form.errors.password" />
            </FormGroup>
            <FormGroup>
              <FormLabel for="password_confirmation">
                Potwierdź nowe hasło
              </FormLabel>
              <TextInput id="password_confirmation" v-model="form.password_confirmation" :error="form.errors.password_confirmation" type="password" />
              <FormError :error="form.errors.password_confirmation" />
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
