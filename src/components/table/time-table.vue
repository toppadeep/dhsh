<template>
  <div class="table-row h-14">
    <div class="table-cell">{{ timetable.group }}</div>
    <div class="table-cell">{{ timetable.time }}</div>
    <div class="table-cell">{{ timetable.teacher }}</div>
    <div class="table-cell">{{ timetable.cabinet }}</div>
    <div class="table-cell">{{ timetable.day }}</div>
  </div>
</template>

<script>
export default {
  props: {
    timetable: {
      type: Object,
      default: () => {},
    },
  },
};
</script>

<style>
</style>