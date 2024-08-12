<script setup>
import { Dialog, DialogPanel, DialogTitle, TransitionChild, TransitionRoot } from '@headlessui/vue'
import { XMarkIcon } from '@heroicons/vue/24/solid'

const emit = defineEmits(['close'])

defineProps({
  show: {
    type: Boolean,
    default: false,
  },
  maxSize: {
    type: String,
    default: 'max-w-3xl',
  },
  header: {
    type: Boolean,
    default: true,
  },
})
</script>

<template>
  <TransitionRoot as="template" :show="show">
    <Dialog as="div" class="relative z-50 m-5" @close="emit('close')">
      <TransitionChild as="template" enter="ease-out duration-300" enter-from="opacity-0" enter-to="opacity-100" leave="ease-in duration-200"
                       leave-from="opacity-100" leave-to="opacity-0"
      >
        <div class="fixed inset-0 bg-gray-500/75 transition-opacity" />
      </TransitionChild>

      <div class="fixed inset-0 z-50 overflow-y-auto">
        <div class="flex min-h-full items-center justify-center p-4 text-center sm:p-0">
          <TransitionChild as="template" enter="ease-out duration-300" enter-from="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95" enter-to="opacity-100 translate-y-0 sm:scale-100"
                           leave="ease-in duration-200" leave-from="opacity-100 translate-y-0 sm:scale-100" leave-to="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
          >
            <DialogPanel data-cy="dialog-panel"
                         :class="`relative bg-white text-left shadow-brand transform transition-all ${maxSize} p-0.5 w-full sm:rounded-lg`"
            >
              <div class="mx-4 mt-6 flex">
                <div class="grow">
                  <DialogTitle v-if="header" as="h3" class="text-brand-black pl-3 text-xl font-semibold leading-8">
                    <slot name="header" />
                  </DialogTitle>
                </div>
                <div class="size-10">
                  <button type="button" class="border-brand-black rounded-full border-2 p-0.5 opacity-70 hover:opacity-90 focus:opacity-100 focus:outline-none"
                          @click="emit('close')"
                  >
                    <span class="sr-only">Anuluj</span>
                    <XMarkIcon class="size-6" />
                  </button>
                </div>
              </div>

              <div class="mt-4 bg-white px-8">
                <slot name="body" />
              </div>
              <div class="mt-2 space-x-7 p-4 sm:flex sm:flex-row sm:justify-center sm:px-6 sm:py-10">
                <slot name="footer" />
              </div>
            </DialogPanel>
          </TransitionChild>
        </div>
      </div>
    </Dialog>
  </TransitionRoot>
</template>
