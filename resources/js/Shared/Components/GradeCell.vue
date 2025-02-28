<script setup>
import TableCell from './Table/TableCell.vue'
import { useForm } from '@inertiajs/inertia-vue3'
import GradeCellManipulator from '@/Shared/Components/GradeCellManipulator.vue'

const props = defineProps({
  gradeColumn: Object,
  grade: Object,
  student: Object,
})

const emit = defineEmits(['createGrade', 'updateGrade', 'updateValue'])

const gradeInput = useForm({
  value: props.grade?.value || '',
})

function getTableCellClass(grade) {
  return [
    grade
      ? grade?.status
        ? 'bg-lime-200'
        : grade?.status !== null ? 'bg-rose-300' : 'bg-white'
      : 'bg-white',
  ]
}
</script>

<template>
  <TableCell :class="getTableCellClass(grade)">
    <div class="flex flex-col gap-4">
      <input v-if="grade" v-model="gradeInput.value" :class="getTableCellClass(grade)" class="size-full cursor-pointer border-0 p-0 text-center font-bold text-gray-900 shadow-none ring-0 focus:border-0 focus:ring-0" @change="emit('updateGrade', gradeColumn.id, student.id, gradeInput.value, grade.status)">
      <input v-else v-model="gradeInput.value" class="size-full cursor-pointer border-0 p-0 text-center font-bold text-gray-900 shadow-none ring-0 focus:border-0 focus:ring-0" @change="emit('createGrade', gradeColumn.id, student.id, null, gradeInput.value)">

      <div class="flex justify-center bg-white/50">
        <GradeCellManipulator background="bg-lime-200" @click="emit('updateGrade', gradeColumn.id, student.id, gradeInput.value, true)" />
        <GradeCellManipulator background="bg-rose-300" @click="emit('updateGrade', gradeColumn.id, student.id, gradeInput.value, false)" />
        <GradeCellManipulator background="bg-white" @click="emit('updateGrade', gradeColumn.id, student.id, gradeInput.value, null)" />
      </div>
    </div>
  </TableCell>
</template>
