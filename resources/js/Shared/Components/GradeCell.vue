<script setup>
import TableCell from './Table/TableCell.vue'
import { useForm } from '@inertiajs/inertia-vue3'

const props = defineProps({
  gradeColumn: Object,
  grade: Object,
  student: Object,
})

const emit = defineEmits(['createGrade', 'updateGrade', 'updateValue'])

const gradeInput = useForm({
  value: props.grade?.value || '',
})
</script>

<template>
  <TableCell
    v-if="grade"
    :class="[grade?.status
      ? 'bg-lime-200'
      : grade?.status !== null ? 'bg-rose-300' : 'bg-white']"
    @dblclick="emit('updateGrade', gradeColumn.id, student.id, inputVal, !grade.status)"
  >
    <input
      v-model="gradeInput.value"
      :class="[grade?.status
        ? 'bg-lime-200'
        : grade?.status !== null ? 'bg-rose-300' : 'bg-white']"
      class="size-full cursor-pointer border-0 p-0 text-center text-gray-900 shadow-none ring-0 focus:border-0 focus:ring-0"
      @change="emit('updateGrade', gradeColumn.id, student.id, gradeInput.value, grade.status)"
    >
  </TableCell>
  <TableCell v-else class="bg-white" @dblclick="emit('updateGrade', props.gradeColumn.id, props.student.id, true, gradeInput.value)">
    <input
      v-model="gradeInput.value"
      class="size-full cursor-pointer border-0 p-0 text-center text-gray-900 shadow-none ring-0 focus:border-0 focus:ring-0"
      @change="emit('createGrade', gradeColumn.id, student.id, null, gradeInput.value)"
    >
  </TableCell>
</template>
