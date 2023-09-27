<script setup>
import { computed } from 'vue'
import Editor from 'primevue/editor'

const modules = {
  keyboard: {
    bindings: {
      tab: false,
    },
  },
}

const props = defineProps({
  modelValue: {
    type: [String, Number],
    default: null,
  },
  error: {
    type: String,
    default: null,
  },
})
const emit = defineEmits(['update:modelValue'])
const value = computed({
  get: () => props.modelValue,
  set: (value) => {
    emit('update:modelValue', value)
  },
})
</script>

<template>
  <Editor v-model="value" :modules="modules" editor-style="height: 320px" class="focus-within:border-brand-black hover:border-brand-black border border-transparent">
    <template #toolbar>
      <!-- eslint-disable tailwindcss/no-custom-classname -->
      <span class="ql-formats">
        <button class="ql-header" aria-label="Heading H1" value="1" />
        <button class="ql-header" aria-label="Heading H2" value="2" />
        <button class="ql-bold" aria-label="Bold" />
        <button class="ql-italic" aria-label="Italic" />
        <button class="ql-underline" aria-label="Underline" />
        <button class="ql-strike" aria-label="Strike" />
        <button class="ql-code-block" aria-label="Code" />
        <button class="ql-list" value="ordered" aria-label="Ordered list" />
        <button class="ql-list" value="bullet" aria-label="Unordered list" />
        <button class="ql-link" aria-label="Link" />
      </span>
      <!-- eslint-enable -->
    </template>
  </Editor>
</template>
