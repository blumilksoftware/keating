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
  news: Object,
})

const form = useForm({
  title: props.news.title,
  slug: props.news.slug,
  content: props.news.content,
})

function updateNews() {
  form.patch(`/dashboard/news/${props.news.id}`)
}
</script>

<template>
  <DashboardLayout>
    <div class="flex flex-col gap-8">
      <ManagementHeader>
        <template #header>
          Zarządzanie aktualnościami
        </template>
        <template #statistics>
          <ManagementHeaderItem>
            Formularz edycji aktualności {{ props.news.title }}
          </ManagementHeaderItem>
        </template>
      </ManagementHeader>

      <form class="grid grid-cols-2" @submit.prevent="updateNews">
        <Section>
          <div class="flex flex-col justify-between gap-4">
            <FormGroup>
              <FormLabel for="id">
                Id
              </FormLabel>
              <TextInput class="opacity-75" :placeholder="news.id" autocomplete="off" disabled />
            </FormGroup>
            <FormGroup>
              <FormLabel for="title">
                Tytuł
              </FormLabel>
              <TextInput id="title" v-model="form.title" :error="form.errors.title" autocomplete="off" />
              <FormError :error="form.errors.title" />
            </FormGroup>
            <FormGroup>
              <FormLabel for="slug">
                Slug
              </FormLabel>
              <TextInput id="slug" v-model="form.slug" :error="form.errors.slug" autocomplete="off" />
              <FormError :error="form.errors.slug" />
            </FormGroup>
            <FormGroup>
              <FormLabel for="content">
                Treść
              </FormLabel>
              <TextAreaEditor id="content" v-model="form.content" />
              <FormError :error="form.errors.content" />
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
