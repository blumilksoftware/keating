<template>
  <div class="lg:flex lg:items-center lg:justify-between">
    <div class="min-w-0 flex-1">
      <h2 class="text-2xl font-bold leading-7 text-gray-900 sm:truncate sm:text-3xl sm:tracking-tight">
        <slot name="header"></slot>
      </h2>
      <div class="mt-1 flex flex-col sm:mt-0 sm:flex-row sm:flex-wrap sm:space-x-6">
        <slot name="statistics"></slot>
      </div>
    </div>
    <div class="w-1/2 flex lg:ml-4 gap-4 justify-end">
      <slot name="actions"></slot>
    </div>
  </div>
</template>
