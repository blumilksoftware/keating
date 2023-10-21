<script setup>
const emit = defineEmits(['createOrUpdateGrade', 'updateValue'])

defineProps({
  gradeColumn: Object,
  grade: Object,
  student: Object,
})
</script>

<template>
  <div
    :class="[grade?.status
      ? 'bg-green-300'
      : grade ? 'bg-red-300' :'bg-white']"
    @click="emit('createOrUpdateGrade',gradeColumn.id, student.id, grade?.value, true)"
    @dblclick="emit('createOrUpdateGrade',gradeColumn.id, student.id, grade?.value, false)"
  >
    <input v-if="grade?.status"
           id="name"
           :class="[grade?.status
             ? 'bg-green-300'
             : grade ? 'bg-red-300' :'bg-white']"
           :value="grade.value"
           class="min-h-[50px] w-full cursor-pointer border-0 p-0 text-center font-bold shadow-none ring-0 focus:border-0 focus:ring-0"
           @change="emit('updateValue',gradeColumn.id, student.id, $event.target.value, true)"
    >
  </div>
</template>
