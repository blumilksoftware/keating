<script setup>
import DashboardLayout from '@/Layouts/DashboardLayout.vue'
import Section from '@/Shared/Components/Section.vue'
import SubmitButton from '@/Shared/Components/Buttons/SubmitButton.vue'
import FormGroup from '@/Shared/Forms/FormGroup.vue'
import FormLabel from '@/Shared/Forms/FormLabel.vue'
import { useForm } from '@inertiajs/inertia-vue3'
import FormError from '@/Shared/Forms/FormError.vue'
import ManagementHeader from '@/Shared/Components/ManagementHeader.vue'
import ManagementHeaderItem from '@/Shared/Components/ManagementHeaderItem.vue'

const form = useForm({
  content: '',
})

function importStudents() {
  form.post('/dashboard/students/import')
}
</script>

<template>
  <DashboardLayout>
    <div class="flex flex-col gap-8">
      <ManagementHeader>
        <template #header>
          Zarządzanie studentami (masowo)
        </template>
        <template #statistics>
          <ManagementHeaderItem>
            Formularz dodawania nowych studentów
          </ManagementHeaderItem>
        </template>
      </ManagementHeader>

      <form class="grid grid-cols-2" @submit.prevent="importStudents">
        <Section>
          <div class="flex flex-col justify-between gap-4">
            <FormGroup>
              <FormLabel for="content">
                Źródło strony z WU
                <span class="text-gray-500">(uczelnia -> protokoły -> edytuj)</span>
              </FormLabel>
              <textarea v-model="form.content" class="block h-[320px] w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 sm:text-sm sm:leading-6" />
              <FormError :error="form.errors.content" />
            </FormGroup>
            <div class="mt-4 flex justify-end">
              <SubmitButton>
                Importuj
              </SubmitButton>
            </div>
          </div>
        </Section>
      </form>
    </div>
  </DashboardLayout>
</template>
