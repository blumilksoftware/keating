<script setup>
import { computed, ref } from 'vue'
import { CameraIcon, XCircleIcon } from '@heroicons/vue/24/outline'

const props = defineProps({
  previousImage: String,
  id: String,
  viewer: {
    type: Boolean,
    default: true,
  },
})

const emit = defineEmits(['update'])

const imageInput = ref(null)
const dragging = ref(false)
const imageFile = ref(null)
const deleted = ref(false)

const imageSrc = computed(() => {
  if (imageFile.value) {
    return URL.createObjectURL(imageFile.value)
  }

  if (deleted.value) {
    return null
  }

  return props.previousImage
})

function onImageChange() {
  const file = imageInput.value.files[0]

  if (!file) {
    return
  }

  if (!file.type.match('image/')) {
    return
  }

  imageFile.value = file
  deleted.value = false

  emit('update', file)
}

function drop(event) {

  if (!event.dataTransfer?.files) {
    return
  }

  imageInput.value.files = event.dataTransfer.files
  onImageChange()
  dragging.value = false
}

function deleteImage() {
  imageInput.value.value = null
  imageFile.value = null
  emit('update', null)
  deleted.value = true
}

</script>

<template>
  <div
    :class="[dragging ? 'bg-wb-grey-90' : 'bg-white', 'relative min-h-[10rem] w-full flex items-center justify-center transition transition-colors p-6 border border-wb-grey-70 rounded-md']"
    @dragover.prevent="dragging = true"
    @dragleave="dragging = false"
    @drop.prevent="drop"
  >
    <label
      v-if="!imageSrc"
      :for="id"
      class="block cursor-pointer text-center space-y-1 my-4 group text-sm rounded-md font-medium text-wb-blue-50 hover:text-wb-blue-40"
    >
      <template v-if="!imageFile">
        <CameraIcon :class="[dragging ? 'text-wb-blue-60' : 'text-wb-grey-60 group-hover:text-wb-blue-60', 'mx-auto h-12 w-12']" />
        <span>Wyślij zdjęcie</span>
        <span class="block text-xs text-wb-grey-50">
          PNG, JPG, GIF do 10MB
        </span>
      </template>
    </label>
    <div v-else>
      <viewer
        v-if="viewer"
        :images="[imageSrc]"
      >
        <img
          :src="imageSrc"
          class="max-h-64 cursor-pointer rounded-xl"
        >
      </viewer>
      <button
        type="button"
        title="Usuń"
        class="absolute top-1 right-1 p-1 rounded-md hover:bg-wb-grey-90"
        @click="deleteImage"
      >
        <XCircleIcon class="h-6 w-6 text-wb-grey-40" />
      </button>
    </div>
    <input
      :id="id"
      ref="imageInput"
      type="file"
      class="hidden"
      accept="image/*"
      @change="onImageChange"
    >
  </div>
</template>
