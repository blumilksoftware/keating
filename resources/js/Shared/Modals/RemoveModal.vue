<script setup>
import { Inertia } from '@inertiajs/inertia'
import BaseModal from '@/Shared/Modals/BaseModal.vue'
import SecondaryButton from '@/Shared/Components/Buttons/SecondaryButton.vue'
import Button from '@/Shared/Components/Buttons/Button.vue'

defineProps({
  show: {
    type: Boolean,
    default: false,
  },
  href: {
    type: String,
    default: null,
  },
})

const emit = defineEmits(['close', 'deleteResource'])

function cancel() {
  emit('close')
}

function removeResource(url) {
  Inertia.delete(url, {
    preserveScroll: true,
    onSuccess() {
      cancel()
    },
  })
}
</script>

<template>
  <BaseModal :show="show" max-size="max-w-xl" :header="false" @close="cancel">
    <template #body>
      <div class="sm:flex sm:items-start">
        <div class="m-auto text-center sm:text-left">
          <h3 class="text-brand-black text-lg font-medium leading-6">
            Czy na pewno chcesz usunąć?
          </h3>
        </div>
      </div>
    </template>
    <template #footer>
      <div class="flex justify-center space-x-7">
        <SecondaryButton @click="cancel">
          Anuluj
        </SecondaryButton>
        <Button @click.once="removeResource(href)">
          Usuń
        </Button>
      </div>
    </template>
  </BaseModal>
</template>
