<script setup>
import DashboardLayout from '@/Layouts/DashboardLayout.vue'
import TableHeader from '@/Shared/Components/Table/TableHeader.vue'
import TableWrapper from '@/Shared/Components/Table/TableWrapper.vue'
import TableRow from '@/Shared/Components/Table/TableRow.vue'
import TableCell from '@/Shared/Components/Table/TableCell.vue'
import Pagination from '@/Shared/Components/Pagination.vue'
import Button from '@/Shared/Components/Buttons/Button.vue'
import EmptyState from '@/Shared/Components/EmptyState.vue'
import RemoveModal from '@/Shared/Modals/RemoveModal.vue'
import { ref, watch } from 'vue'
import { Inertia } from '@inertiajs/inertia'
import { debounce } from 'lodash'
import TextInput from '@/Shared/Forms/TextInput.vue'
import { useForm } from '@inertiajs/inertia-vue3'
import { Cog6ToothIcon, XCircleIcon } from '@heroicons/vue/24/outline'
import ManagementHeader from '@/Shared/Components/ManagementHeader.vue'
import ManagementHeaderItem from '@/Shared/Components/ManagementHeaderItem.vue'

const props = defineProps({
  news: Object,
  search: String,
  total: Number,
  lastUpdate: String,
})
const showModal = ref(false)
const newsToDeleteId = ref(0)
const form = useForm({
  search: props.search ?? '',
})

watch(form, debounce(() => {
  Inertia.get('/dashboard/news', {
    search: form.search,
  }, {
    preserveState: true,
    replace: true,
  })
}, 300), { deep: true })
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
            Liczba aktualności w bazie: {{ total }}
          </ManagementHeaderItem>
          <ManagementHeaderItem v-if="news.total">
            Liczba aktualności w tabeli: {{ news.total }}
          </ManagementHeaderItem>
          <ManagementHeaderItem v-if="lastUpdate">
            Ostatnie zmiany: {{ lastUpdate }}
          </ManagementHeaderItem>
        </template>
        <template #actions>
          <TextInput v-if="total || form.search.length > 0" id="filter" v-model="form.search" placeholder="Szukaj" type="search" class="max-w-lg" />
          <Button :href="`/dashboard/news/create`">
            Dodaj
          </Button>
        </template>
      </ManagementHeader>
      <div v-if="news.data.length" class="flex flex-col gap-8">
        <TableWrapper>
          <template #header>
            <TableHeader class="w-1/6">
              ID
            </TableHeader>
            <TableHeader class="w-1/6">
              Tytuł
            </TableHeader>
            <TableHeader class="w-1/5">
              Slug
            </TableHeader>
            <TableHeader class="w-1/5">
              Data publikacji
            </TableHeader>
            <TableHeader />
          </template>
          <template #body>
            <TableRow v-for="news in news.data" :key="news.id">
              <TableCell class="pr-12 opacity-75">
                {{ news.id }}
              </TableCell>
              <TableCell>
                {{ news.title }}
              </TableCell>
              <TableCell>
                {{ news.slug }}
              </TableCell>
              <TableCell>
                {{ news.published_at }}
              </TableCell>
              <TableCell class="flex justify-end gap-2">
                <Button :href="`news/${news.id}/edit`">
                  <Cog6ToothIcon class="w-5" />
                </Button>
                <Button class="text-red-600" @click="[showModal = true, newsToDeleteId = news.id]">
                  <XCircleIcon class="w-5" />
                </Button>
              </TableCell>
            </TableRow>
          </template>
        </TableWrapper>
        <Pagination :pagination="news" />
      </div>
      <EmptyState v-else />
    </div>
  </DashboardLayout>

  <RemoveModal :show="showModal" :href="`/dashboard/news/${newsToDeleteId}`" @close="showModal = false" />
</template>
