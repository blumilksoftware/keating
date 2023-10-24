<script setup>
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
    timeout = setTimeout( () => {
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
  <div
    v-if="grade"
    :class="[grade?.status
      ? 'bg-green-300'
      : grade ? 'bg-red-300' :'bg-white']"
    @dblclick="emit('updateGrade',gradeColumn.id, student.id, grade.value, !grade.status)"
  >
    <input class="min-h-[50px] w-full cursor-pointer border-0 p-0 text-center font-bold shadow-none ring-0 focus:border-0 focus:ring-0"
           :class="[grade.status? 'bg-green-300' : 'bg-red-300']" :value="grade.value"
           @change="emit('updateGrade',gradeColumn.id, student.id, $event.target.value, grade.status)"
    >
  </div>
  <div v-else class="bg-white"
       @click="createGradeOnClick"
  />
</template>
