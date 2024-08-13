<script setup>
import DashboardLayout from '@/Layouts/DashboardLayout.vue'
import TableHeader from '@/Shared/Components/Table/TableHeader.vue'
import TableWrapper from '@/Shared/Components/Table/TableWrapper.vue'
import TableRow from '@/Shared/Components/Table/TableRow.vue'
import TableCell from '@/Shared/Components/Table/TableCell.vue'
import Button from '@/Shared/Components/Buttons/Button.vue'
import EmptyState from '@/Shared/Components/EmptyState.vue'
import RemoveModal from '@/Shared/Modals/RemoveModal.vue'
import { ref } from 'vue'
import ManagementHeader from '@/Shared/Components/ManagementHeader.vue'
import ManagementHeaderItem from '@/Shared/Components/ManagementHeaderItem.vue'
import { PencilSquareIcon, XCircleIcon } from '@heroicons/vue/24/outline'

defineProps({
  faqs: Object,
  total: Number,
  lastUpdate: String,
})
const showModal = ref(false)
const faqToDeleteId = ref(0)
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
            Liczba pytań i odpowiedzi w bazie: {{ total }}
          </ManagementHeaderItem>
          <ManagementHeaderItem v-if="lastUpdate">
            Ostatnie zmiany: {{ lastUpdate }}
          </ManagementHeaderItem>
        </template>
        <template #actions>
          <span class="hidden sm:block">
            <Button :href="`/dashboard/faqs/create`">
              Dodaj
            </Button>
          </span>
        </template>
      </ManagementHeader>
      <div v-if="faqs.length" class="flex flex-col gap-8">
        <TableWrapper>
          <template #header>
            <TableHeader class="w-1/6">
              ID
            </TableHeader>
            <TableHeader class="w-1/5">
              Pytanie
            </TableHeader>
            <TableHeader />
          </template>
          <template #body>
            <TableRow v-for="faq in faqs" :key="faq.id">
              <TableCell class="pr-12 opacity-75">
                {{ faq.id }}
              </TableCell>
              <TableCell>
                {{ faq.question }}
              </TableCell>
              <TableCell class="flex justify-end gap-2">
                <Button :href="`/dashboard/faqs/${faq.id}/edit`">
                  <PencilSquareIcon class="w-5" />
                </Button>
                <Button class="text-red-600" @click="[showModal = true, faqToDeleteId = faq.id]">
                  <XCircleIcon class="w-5" />
                </Button>
              </TableCell>
            </TableRow>
          </template>
        </TableWrapper>
      </div>
      <EmptyState v-else />
    </div>
  </DashboardLayout>

  <RemoveModal :show="showModal" :href="`/dashboard/faqs/${faqToDeleteId}`" @close="showModal = false" />
</template>
