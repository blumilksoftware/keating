<script>
import Quill from 'quill'
import 'quill/dist/quill.snow.css'

export default {
  name: 'QuillEditor',
  props: {
    modelValue: {
      type: String,
      default: '',
    },
    editorStyle: {
      type: Object,
      default: () => ({ height: '320px' }),
    },
  },
  emits: ['update:modelValue'],
  watch: {
    modelValue(newValue) {
      if (newValue !== this.quill.root.innerHTML) {
        this.quill.root.innerHTML = newValue
      }
    },
  },
  mounted() {
    this.quill = new Quill(this.$refs.editorContainer, {
      theme: 'snow',
      modules: {
        toolbar: this.$refs.editorToolbar,
      },
    })

    this.quill.on('text-change', () => {
      const content = this.quill.root.innerHTML
      this.$emit('update:modelValue', content)
    })

    this.quill.root.innerHTML = this.modelValue
  },
}
</script>

<template>
  <div>
    <div ref="editorToolbar" class="ql-toolbar">
      <span class="ql-formats">
        <button aria-label="Heading H1" class="ql-header" value="1" />
        <button aria-label="Heading H2" class="ql-header" value="2" />
        <button aria-label="Bold" class="ql-bold" />
        <button aria-label="Italic" class="ql-italic" />
        <button aria-label="Underline" class="ql-underline" />
        <button aria-label="Strike" class="ql-strike" />
        <button aria-label="Code" class="ql-code-block" />
        <button aria-label="Ordered list" class="ql-list" value="ordered" />
        <button aria-label="Unordered list" class="ql-list" value="bullet" />
        <button aria-label="Link" class="ql-link" />
      </span>
    </div>
    <div ref="editorContainer" class="ql-editor" :style="editorStyle" />
  </div>
</template>

<style scoped>
.ql-editor {
  border: 1px solid #ccc;
  border-radius: 4px;
  padding: 10px;
}
</style>
