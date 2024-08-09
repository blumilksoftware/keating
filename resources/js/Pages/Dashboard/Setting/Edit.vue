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
import ColorInput from '../../../Shared/Forms/ColorInput.vue'
import { ref } from 'vue'
import { Method } from '@inertiajs/inertia'

const props = defineProps({
  settings: Object,
})

const form = useForm({
  teacher_name: props.settings.teacher_name,
  teacher_email: props.settings.teacher_email,
  teacher_titles: props.settings.teacher_titles,
  university_name: props.settings.university_name,
  department_name: props.settings.department_name,
  primary_color: props.settings.primary_color,
  secondary_color: props.settings.secondary_color,
  logo: null,
})

const imageUrl = ref('')

function updateSettings() {
  form.post('/dashboard/settings')
}

function onFileSelected(event) {
  const file = event.target?.files[0]

  if (file.size > 1024 * 1024) {
    form.errors.logo = 'Plik nie może być większy niż 1MB'

    return
  }

  form.logo = file
  imageUrl.value = URL.createObjectURL(event.target?.files[0])
  form.errors.logo = ''
}
</script>

<template>
  <DashboardLayout>
    <div class="flex flex-col gap-8">
      <ManagementHeader>
        <template #header>
          Zarządzanie ustawieniami
        </template>
        <template #statistics>
          <ManagementHeaderItem>
            Formularz edycji ustawień
          </ManagementHeaderItem>
        </template>
      </ManagementHeader>
      <form class="grid grid-cols-2" enctype="multipart/form-data" @submit.prevent="updateSettings">
        <Section>
          <div class="flex flex-col justify-between gap-4">
            <FormGroup>
              <FormLabel for="teacher_name">
                Imię i nazwisko nauczyciela
              </FormLabel>
              <TextInput id="teacher_name" v-model="form.teacher_name" :error="form.errors.teacher_name" autocomplete="off" />
              <FormError :error="form.errors.teacher_name" />
            </FormGroup>
            <FormGroup>
              <FormLabel for="teacher_email">
                E-mail nauczyciela
              </FormLabel>
              <TextInput id="teacher_email" v-model="form.teacher_email" :error="form.errors.teacher_email" autocomplete="off" />
              <FormError :error="form.errors.teacher_email" />
            </FormGroup>
            <FormGroup>
              <FormLabel for="teacher_titles">
                Tytuły nauczyciela
              </FormLabel>
              <TextInput id="teacher_titles" v-model="form.teacher_titles" :error="form.errors.teacher_titles" autocomplete="off" />
              <FormError :error="form.errors.teacher_titles" />
            </FormGroup>
            <FormGroup>
              <FormLabel for="university_name">
                Nazwa uczelni
              </FormLabel>
              <TextInput id="university_name" v-model="form.university_name" :error="form.errors.university_name" autocomplete="off" />
              <FormError :error="form.errors.university_name" />
            </FormGroup>
            <FormGroup>
              <FormLabel for="department_name">
                Nazwa wydziału
              </FormLabel>
              <TextInput id="department_name" v-model="form.department_name" :error="form.errors.department_name" autocomplete="off" />
              <FormError :error="form.errors.department_name" />
            </FormGroup>
            <FormGroup>
              <FormLabel for="primary_color">
                Kolor główny
              </FormLabel>
              <ColorInput id="primary_color" v-model="form.primary_color" :error="form.errors.primary_color" autocomplete="off" />
              <FormError :error="form.errors.primary_color" />
            </FormGroup>
            <FormGroup>
              <FormLabel for="secondary_color">
                Kolor dodatkowy
              </FormLabel>
              <ColorInput id="secondary_color" v-model="form.secondary_color" :error="form.errors.secondary_color" autocomplete="off" />
              <FormError :error="form.errors.secondary_color" />
            </FormGroup>
            <FormGroup>
              <FormLabel for="title">
                Logo
              </FormLabel>
              <input
                class="border-brand-light-gray text-brand-black hover:border-brand-black focus:border-brand-black !mb-px block w-full border-0 border-b p-2 text-sm font-medium hover:!mb-px hover:border-b-2 focus:!mb-px focus:border-b-2 focus:ring-0 focus:ring-offset-0"
                type="file" max="1" @input="onFileSelected"
              >
              <FormError :error="form.errors.logo" class="mt-2" />
            </FormGroup>
            <FormGroup v-if="settings.logo || imageUrl">
              <div v-if="settings.logo && !imageUrl">
                <FormLabel class="mb-3 flex justify-between">
                  Aktualne logo
                  <InertiaLink
                    href="/dashboard/settings/remove-logo"
                    :method="Method.DELETE"
                    class="text-sm text-red-500 hover:text-red-700"
                    @click="form.logo = ''"
                  >
                    Usuń
                  </InertiaLink>
                </FormLabel>
                <img :alt="'alt text'"
                     :src="`/storage/${settings.logo}`"
                     class="m-auto shadow-lg"
                >
              </div>
              <div v-else>
                <FormLabel class="mb-3">
                  Przesłane logo
                </FormLabel>
                <img :src="imageUrl" alt="Image preview" class="m-auto shadow-lg">
              </div>
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
