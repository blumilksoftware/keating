<template>
  <div class="lg:flex lg:items-center lg:justify-between">
    <div class="min-w-0 flex-1">
      <h2 class="text-2xl font-bold leading-7 text-gray-900 sm:truncate sm:text-3xl sm:tracking-tight">
        <slot name="header" />
      </h2>
      <div class="mt-1 flex flex-col sm:mt-0 sm:flex-row sm:flex-wrap sm:space-x-6">
        <slot name="statistics" />
      </div>
    </div>
    <div class="flex w-1/2 justify-end gap-4 lg:ml-4">
      <slot name="actions" />
    </div>
  </div>
</template>
