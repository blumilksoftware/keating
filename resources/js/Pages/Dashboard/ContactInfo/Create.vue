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

defineProps({
  icons: Array,
})

const form = useForm({
  label: '',
  identifier: '',
  icon: '',
})

function createContactInfo() {
  form.post('/dashboard/contact-infos')
}
</script>

<template>
  <DashboardLayout>
    <div class="flex flex-col gap-8">
      <ManagementHeader>
        <template #header>
          Zarządzanie formami kontaktu
        </template>
        <template #statistics>
          <ManagementHeaderItem>
            Formularz dodawania nowej formy kontaktu
          </ManagementHeaderItem>
        </template>
      </ManagementHeader>

      <form class="grid grid-cols-2" @submit.prevent="createContactInfo">
        <Section>
          <div class="flex flex-col justify-between gap-4">
            <FormGroup>
              <FormLabel for="id">
                Id
              </FormLabel>
              <TextInput class="opacity-75" placeholder="autogenerowany ulid" autocomplete="off" disabled />
            </FormGroup>
            <FormGroup>
              <FormLabel for="label">
                Etykieta
              </FormLabel>
              <TextInput id="label" v-model="form.label" :error="form.errors.label" autocomplete="off" />
              <FormError :error="form.errors.label" />
            </FormGroup>
            <FormGroup>
              <FormLabel for="identifier">
                Email / link do kontaktu
              </FormLabel>
              <TextInput id="identifier" v-model="form.identifier" :error="form.errors.identifier" autocomplete="off" />
              <FormError :error="form.errors.identifier" />
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

