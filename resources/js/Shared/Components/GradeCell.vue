<script setup>
import TableCell from './Table/TableCell.vue'

const props = defineProps({
  gradeColumn: Object,
  grade: Object,
  student: Object,
})

const emit = defineEmits(['createGrade', 'updateGrade', 'updateValue'])
let clicks = 0
let timeout = null

function createGradeOnClick() {
  clicks++

  if (clicks === 1) {
    timeout = setTimeout(() => {
      emit('createGrade', props.gradeColumn.id, props.student.id, true)
      clicks = 0
    }, 200)
  } else {
    clearTimeout(timeout)
    emit('createGrade', props.gradeColumn.id, props.student.id, false)
    clicks = 0
  }
}
</script>

<template>
  <TableCell
    v-if="grade"
    :class="[grade?.status
      ? 'bg-lime-200'
      : grade ? 'bg-rose-300' :'bg-white']"
    @dblclick="emit('updateGrade',gradeColumn.id, student.id, grade.value, !grade.status)"
  >
    <input
      :class="[grade.status? 'bg-lime-200' : 'bg-rose-300']"
      :value="grade.value"
      class="h-full w-full cursor-pointer border-0 p-0 text-center font-bold text-gray-900 shadow-none ring-0 focus:border-0 focus:ring-0"
      @change="emit('updateGrade',gradeColumn.id, student.id, $event.target.value, grade.status)"
    >
  </TableCell>
  <TableCell v-else class="bg-white" @click="createGradeOnClick" />
</template>
