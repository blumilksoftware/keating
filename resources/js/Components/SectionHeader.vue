<template>
  <div class="mx-auto max-w-2xl lg:mx-0">
    <h2 class="text-3xl font-bold tracking-tight text-gray-900 sm:text-4xl">
      <slot name="header" />
    </h2>
    <p class="mt-1 text-lg leading-8 text-gray-600">
      <slot name="subheader" />
    </p>
  </div>
</template>
