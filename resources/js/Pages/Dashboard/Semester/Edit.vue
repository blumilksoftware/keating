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

const props = defineProps({
  semester: Object,
})

const form = useForm({
  name: props.semester.name,
})

function updateSemester() {
  form.patch(`/dashboard/semesters/${props.semester.id}`)
}
</script>

<template>
  <DashboardLayout>
    <div class="flex flex-col gap-8">
      <ManagementHeader>
        <template #header>
          Zarządzanie semestrami
        </template>
        <template #statistics>
          <ManagementHeaderItem>
            Formularz edycji semestru {{ semester.name }}
          </ManagementHeaderItem>
        </template>
      </ManagementHeader>

      <form class="grid grid-cols-2" @submit.prevent="updateSemester">
        <Section>
          <div class="flex flex-col justify-between gap-4">
            <FormGroup>
              <FormLabel for="id">
                Id
              </FormLabel>
              <TextInput class="opacity-75" :placeholder="semester.id" autocomplete="off" disabled />
            </FormGroup>
            <FormGroup>
              <FormLabel for="name">
                Nazwa
              </FormLabel>
              <TextInput id="name" v-model="form.name" :error="form.errors.name" autocomplete="off" />
              <FormError :error="form.errors.name" />
            </FormGroup>
            <div class="mt-4 flex justify-end">
              <SubmitButton>
                Zapisz
              </SubmitButton>
            </div>
          </div>
        </Section>
      </form>
    </div>
  </DashboardLayout>
</template>
