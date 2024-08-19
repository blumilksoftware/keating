<script setup>
import TableRow from '@/Shared/Components/Table/TableRow.vue'
import { useSlots } from 'vue'

const slots = useSlots()
</script>

<template>
  <div class="flow-root">
    <div class="-mx-4 -my-2 overflow-x-auto sm:-mx-6 lg:-mx-8">
      <div class="inline-block min-w-full py-2 align-middle sm:px-6 lg:px-8">
        <div class="ring-opacity/5 overflow-hidden">
          <table class="min-w-full divide-y">
            <thead v-if="slots.header">
              <TableRow>
                <slot name="header" />
              </TableRow>
            </thead>
            <tbody v-if="slots.body" class="divide-y bg-white">
              <slot name="body" />
            </tbody>
            <slot />
          </table>
        </div>
      </div>
    </div>
  </div>
</template>
