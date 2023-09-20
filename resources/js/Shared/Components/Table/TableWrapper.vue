<script setup>
import TableRow from '@/Shared/Components/Table/TableRow.vue'
import { useSlots } from 'vue'

const slots = useSlots()
</script>

<template>
  <div class="mt-8 flow-root">
    <div class="-mx-4 -my-2 overflow-x-auto sm:-mx-6 lg:-mx-8">
      <div class="inline-block min-w-full py-2 align-middle sm:px-6 lg:px-8">
        <div class="overflow-hidden shadow ring-1 ring-black ring-opacity-5 sm:rounded-lg">
          <table class="min-w-full divide-y divide-gray-300">
            <thead v-if="slots.header" class="bg-gray-50">
              <TableRow>
                <slot name="header" />
              </TableRow>
            </thead>
            <tbody v-if="slots.body" class="divide-y divide-gray-200 bg-white">
              <slot name="body" />
            </tbody>
            <slot />
          </table>
        </div>
      </div>
    </div>
  </div>
</template>
