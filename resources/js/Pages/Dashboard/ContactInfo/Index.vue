<script setup>
import DashboardLayout from '@/Layouts/DashboardLayout.vue'
import TableHeader from '@/Shared/Components/Table/TableHeader.vue'
import TableWrapper from '@/Shared/Components/Table/TableWrapper.vue'
import TableRow from '@/Shared/Components/Table/TableRow.vue'
import TableCell from '@/Shared/Components/Table/TableCell.vue'
import Pagination from '@/Shared/Components/Pagination.vue'
import Button from '@/Shared/Components/Buttons/Button.vue'
import EmptyState from '@/Shared/Components/EmptyState/EmptyState.vue'
import RemoveModal from '@/Shared/Modals/RemoveModal.vue'
import { ref } from 'vue'
import ManagementHeader from '@/Shared/Components/ManagementHeader.vue'
import ManagementHeaderItem from '@/Shared/Components/ManagementHeaderItem.vue'
import StyledLink from '@/Shared/Components/StyledLink.vue'
defineProps({
  contactInfos: Object,
  total: Number,
  lastUpdate: String,
})
const showModal = ref(false)
const contactInfoToDeleteId = ref(0)

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
            Liczba form kontaktu w bazie: {{ total }}
          </ManagementHeaderItem>
          <ManagementHeaderItem v-if="contactInfos.total">
            Liczba form kontaktu w tabeli: {{ contactInfos.total }}
          </ManagementHeaderItem>
          <ManagementHeaderItem v-if="lastUpdate">
            Ostatnie zmiany: {{ lastUpdate }}
          </ManagementHeaderItem>
        </template>
        <template #actions>
          <StyledLink :href="`/dashboard/contact-infos/create`">
            Dodaj
          </StyledLink>
        </template>
      </ManagementHeader>
      <div v-if="contactInfos.length" class="flex flex-col gap-8">
        <TableWrapper>
          <template #header>
            <TableHeader class="w-1/5">
              ID
            </TableHeader>
            <TableHeader class="w-1/5">
              Etykieta
            </TableHeader>
            <TableHeader class="w-1/5">
              Email / Link
            </TableHeader>
            <TableHeader />
          </template>
          <template #body>
            <TableRow v-for="contact in contactInfos" :key="contact.id">
              <TableCell class="pr-12 opacity-75">
                {{ contact.id }}
              </TableCell>
              <TableCell>
                {{ contact.label }}
              </TableCell>
              <TableCell>
                {{ contact.identifier }}
              </TableCell>
              <TableCell class="flex justify-end gap-2">
                <StyledLink :href="`contact-infos/${contact.id}/edit`">
                  edytuj
                </StyledLink>
                <Button class="text-red-600" @click="[showModal = true, contactInfoToDeleteId = contact.id]">
                  usuń
                </Button>
              </TableCell>
            </TableRow>
          </template>
        </TableWrapper>
        <Pagination :pagination="contactInfos" />
      </div>
      <EmptyState v-else />
    </div>
  </DashboardLayout>

  <RemoveModal :show="showModal" :href="`/dashboard/contact-infos/${contactInfoToDeleteId}`" @close="showModal = false" />
</template>
