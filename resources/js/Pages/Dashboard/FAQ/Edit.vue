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
import TextAreaEditor from '../../../Shared/Forms/TextAreaEditor.vue'

const props = defineProps({
  faq: Object,
})

const form = useForm({
  question: props.faq.question,
  answer: props.faq.answer,
})

function editFAQ() {
  form.patch(`/dashboard/faqs/${props.faq.id}`)
}
</script>

<template>
  <DashboardLayout>
    <div class="flex flex-col gap-8">
      <ManagementHeader>
        <template #header>
          Zarządzanie FAQ
        </template>
        <template #statistics>
          <ManagementHeaderItem>
            Formularz edycji FAQ {{ faq.question }}
          </ManagementHeaderItem>
        </template>
      </ManagementHeader>

      <form class="grid grid-cols-2" @submit.prevent="editFAQ">
        <Section>
          <div class="flex flex-col justify-between gap-4">
            <FormGroup>
              <FormLabel for="id">
                Id
              </FormLabel>
              <TextInput class="opacity-75" :placeholder="faq.id" autocomplete="off" disabled />
            </FormGroup>
            <FormGroup>
              <FormLabel for="question">
                Pytanie
              </FormLabel>
              <TextInput id="question" v-model="form.question" :error="form.errors.question" autocomplete="off" />
              <FormError :error="form.errors.question" />
            </FormGroup>
            <FormGroup>
              <FormLabel for="answer">
                Odpowiedź
              </FormLabel>
              <TextAreaEditor id="answer" v-model="form.answer" />
              <FormError :error="form.errors.answer" />
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
