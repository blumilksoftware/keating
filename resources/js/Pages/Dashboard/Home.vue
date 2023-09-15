<script setup>
import DashboardLayout from '../../Layouts/DashboardLayout.vue'

defineProps({
  counters: Array,
})
</script>

<template>
  <DashboardLayout>
    <h3 class="text-base font-semibold leading-6 text-gray-900">
      Ogólne statystyki
    </h3>
    <div class="flex flex-col">
      <dl v-for="(section, i) in counters" :key="i" class="mt-5 grid grid-cols-1 gap-5 sm:grid-cols-3">
        <div v-for="item in section" :key="item.name" class="overflow-hidden rounded-lg bg-white px-4 py-5 shadow sm:p-6">
          <dt class="truncate text-sm font-medium text-gray-500">
            {{ item.name }}
          </dt>
          <dd class="mt-1 text-3xl font-semibold tracking-tight text-gray-900">
            {{ item.value }}
          </dd>
        </div>
      </dl>
    </div>
  </DashboardLayout>
</template>
