<script setup>
import DashboardLayout from '@/Layouts/DashboardLayout.vue'
import Section from '@/Shared/Components/Section.vue'
import SubmitButton from '@/Shared/Components/Buttons/SubmitButton.vue'
import FormGroup from '@/Shared/Forms/FormGroup.vue'
import FormLabel from '@/Shared/Forms/FormLabel.vue'
import FormError from '@/Shared/Forms/FormError.vue'
import { useForm } from '@inertiajs/inertia-vue3'
import ManagementHeader from '@/Shared/Components/ManagementHeader.vue'
import ManagementHeaderItem from '@/Shared/Components/ManagementHeaderItem.vue'
import EmptyState from '@/Shared/Components/EmptyState/EmptyState.vue'
import TableCell from '@/Shared/Components/Table/TableCell.vue'
import TableRow from '@/Shared/Components/Table/TableRow.vue'
import TableHeader from '@/Shared/Components/Table/TableHeader.vue'
import TableWrapper from '@/Shared/Components/Table/TableWrapper.vue'
import Button from '@/Shared/Components/Buttons/Button.vue'
import { ref } from 'vue'
import TextInput from '@/Shared/Forms/TextInput.vue'
import Select from '@/Shared/Forms/Select.vue'
import TextAreaEditor from '@/Shared/Forms/TextAreaEditor.vue'
import RemoveModal from '@/Shared/Modals/RemoveModal.vue'
import DOMPurify from 'dompurify'

const props = defineProps({
  about: Array,
  counters: Array,
  sectionSettings: Object,
  sectionTypes: Array,
})
const showModal = ref(false)
const showEditForm = ref(false)
const showCreateForm = ref(false)
const sectionToDeleteId = ref(0)
const sectionToEdit = ref({})
const createForm = useForm({
  title: '',
  value: '',
  type: '',
})
const editForm = useForm({
  title: '',
  value: '',
  type: '',
})
const sectionSettingsForm = useForm({
  banner_enabled: props.sectionSettings.banner_enabled,
  about_enabled: props.sectionSettings.about_enabled,
  counters_enabled: props.sectionSettings.counters_enabled,
  contact_enabled: props.sectionSettings.contact_enabled,
})

function editSection(section) {
  sectionToEdit.value = section
  editForm.title = section.title
  editForm.value = section.value
  editForm.type = section.type
  showCreateForm.value = false
  showEditForm.value = true
}

function createSection() {
  createForm.post('/dashboard/sections/', {
    preserveScroll: true,
    onSuccess: () => {
      createForm.reset()
    },
  })
}

function updateSection() {
  editForm.patch(`/dashboard/sections/${sectionToEdit.value.id}/`, {
    preserveScroll: true,
    onSuccess: () => {
      showEditForm.value = false
      editForm.reset()
    },
  })
}

function updateSectionSettings() {
  sectionSettingsForm.patch('/dashboard/section-settings', {
    preserveScroll: true,
  })
}
</script>

<template>
  <DashboardLayout>
    <div class="flex flex-col gap-8">
      <ManagementHeader>
        <template #header>
          Zarządzanie sekcjami strony głównej
        </template>
        <template #statistics>
          <ManagementHeaderItem>
            Formularz edycji sekcji strony głównej
          </ManagementHeaderItem>
        </template>
        <template #actions>
          <Button @click="[showCreateForm = true, showEditForm = false]">
            Dodaj
          </Button>
        </template>
      </ManagementHeader>
      <form v-if="!showEditForm && showCreateForm" class="grid grid-cols-2" @submit.prevent="createSection">
        <Section>
          <div class="flex flex-col justify-between gap-4">
            <FormGroup>
              <FormLabel for="type">
                Typ sekcji
              </FormLabel>
              <Select id="type" v-model="createForm.type" :error="createForm.errors.type" :options="sectionTypes"
                      item-value="value" label="label"
              />
              <FormError :error="createForm.errors.type" />
            </FormGroup>
            <FormGroup>
              <FormLabel for="title">
                Tytuł
              </FormLabel>
              <TextInput id="title" v-model="createForm.title" :error="createForm.errors.title" autocomplete="off" />
              <FormError :error="createForm.errors.title" />
            </FormGroup>
            <FormGroup>
              <FormLabel for="value">
                Opis
              </FormLabel>
              <TextAreaEditor id="value" v-model="createForm.value" :error="createForm.errors.value"
                              autocomplete="off"
              />
              <FormError :error="createForm.errors.value" />
            </FormGroup>
            <div class="mt-4 flex justify-end">
              <Button class="mr-3" @click="[showCreateForm = false]">
                Zamknij
              </Button>
              <SubmitButton>
                Utwórz
              </SubmitButton>
            </div>
          </div>
        </Section>
      </form>
      <form v-if="showEditForm && !showCreateForm" class="grid grid-cols-2" @submit.prevent="updateSection">
        <Section>
          <div class="flex flex-col justify-between gap-4">
            <FormGroup>
              <FormLabel for="type">
                Typ sekcji
              </FormLabel>
              <Select id="type" v-model="editForm.type" :error="editForm.errors.type" :options="sectionTypes"
                      item-value="value" label="label"
              />
              <FormError :error="editForm.errors.type" />
            </FormGroup>
            <FormGroup>
              <FormLabel for="title">
                Tytuł
              </FormLabel>
              <TextInput id="title" v-model="editForm.title" :error="editForm.errors.title" autocomplete="off" />
              <FormError :error="editForm.errors.title" />
            </FormGroup>
            <FormGroup>
              <FormLabel for="value">
                Opis
              </FormLabel>
              <TextAreaEditor id="value" v-model="editForm.value" :error="editForm.errors.value"
                              autocomplete="off"
              />
              <FormError :error="editForm.errors.value" />
            </FormGroup>
            <div class="mt-4 flex justify-end">
              <Button class="mr-3" @click="[showEditForm = false]">
                Zamknij
              </Button>
              <SubmitButton>
                Zapisz
              </SubmitButton>
            </div>
          </div>
        </Section>
      </form>
      <div class="grid gap-4">
        <div class="flex flex-col gap-4">
          <h3 class="font-bold">
            O mnie
          </h3>
          <div>
            <div v-if="about.length" class="flex flex-col gap-8">
              <TableWrapper>
                <template #header>
                  <TableHeader class="w-1/5">
                    Tytuł
                  </TableHeader>
                  <TableHeader class="w-4/5">
                    Opis
                  </TableHeader>
                  <TableHeader />
                </template>
                <template #body>
                  <TableRow v-for="item in about" :key="item.id">
                    <TableCell>
                      {{ item.title }}
                    </TableCell>
                    <TableCell>
                      <!-- eslint-disable vue/no-v-html -->
                      <div class="prose" v-html="DOMPurify.sanitize(item.value)" />
                      <!-- eslint-enable -->
                    </TableCell>
                    <TableCell class="flex justify-end gap-2">
                      <Button @click="editSection(item)">
                        edytuj
                      </Button>
                      <Button class="text-red-600" @click="[showModal = true, sectionToDeleteId = item.id]">
                        usuń
                      </Button>
                    </TableCell>
                  </TableRow>
                </template>
              </TableWrapper>
            </div>
            <EmptyState v-else />
          </div>
        </div>
        <div class="flex flex-col gap-4">
          <h3 class="font-bold">
            Liczniki
          </h3>
          <div>
            <div v-if="counters.length" class="flex flex-col gap-8">
              <TableWrapper>
                <template #header>
                  <TableHeader class="w-1/5">
                    Tytuł
                  </TableHeader>
                  <TableHeader class="w-4/5">
                    Opis
                  </TableHeader>
                  <TableHeader />
                </template>
                <template #body>
                  <TableRow v-for="counter in counters" :key="counter.id">
                    <TableCell>
                      {{ counter.title }}
                    </TableCell>
                    <TableCell>
                      <!-- eslint-disable vue/no-v-html -->
                      <div class="prose" v-html="DOMPurify.sanitize(counter.value)" />
                      <!-- eslint-enable -->
                    </TableCell>
                    <TableCell class="flex justify-end gap-2">
                      <Button @click="editSection(counter)">
                        edytuj
                      </Button>
                      <Button class="text-red-600" @click="[showModal = true, sectionToDeleteId = counter.id]">
                        usuń
                      </Button>
                    </TableCell>
                  </TableRow>
                </template>
              </TableWrapper>
            </div>
            <EmptyState v-else />
          </div>
        </div>
      </div>
      <Section class="w-1/2">
        <h3 class="mb-5 font-bold">
          Widoczność sekcji strony głównej
        </h3>
        <form @submit.prevent="updateSectionSettings">
          <FormGroup class="mb-2 flex items-center">
            <input id="banner_enabled" v-model="sectionSettingsForm.banner_enabled" class="mr-3" type="checkbox">
            <FormLabel class="!m-0" for="banner_enabled">
              Baner
            </FormLabel>
          </FormGroup>
          <FormGroup class="mb-2 flex items-center">
            <input id="about_enabled" v-model="sectionSettingsForm.about_enabled" class="mr-3" type="checkbox">
            <FormLabel class="!m-0" for="about_enabled">
              O mnie
            </FormLabel>
          </FormGroup>
          <FormGroup class="mb-2 flex items-center">
            <input id="counters_enabled" v-model="sectionSettingsForm.counters_enabled" class="mr-3" type="checkbox">
            <FormLabel class="!m-0" for="counters_enabled">
              Liczniki
            </FormLabel>
          </FormGroup>
          <FormGroup class="flex items-center">
            <input id="contact_enabled" v-model="sectionSettingsForm.contact_enabled" class="mr-3" type="checkbox">
            <FormLabel class="!m-0" for="contact_enabled">
              Kontakt
            </FormLabel>
          </FormGroup>
          <div class="flex justify-end">
            <SubmitButton>
              Zapisz
            </SubmitButton>
          </div>
        </form>
      </Section>
    </div>
  </DashboardLayout>
  <RemoveModal
    :href="`/dashboard/sections/${sectionToDeleteId}`"
    :show="showModal"
    @close="showModal = false"
  />
</template>
