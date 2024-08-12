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
  name: '',
  abbreviation: '',
})

function createField() {
  form.post('/dashboard/fields')
}
</script>

<template>
  <DashboardLayout>
    <div class="flex flex-col gap-8">
      <ManagementHeader>
        <template #header>
          Zarządzanie kierunkami i specjalnościami
        </template>
        <template #statistics>
          <ManagementHeaderItem>
            Formularz dodawania nowego kierunku lub specjalności
          </ManagementHeaderItem>
        </template>
      </ManagementHeader>

      <form class="grid grid-cols-2" @submit.prevent="createField">
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
