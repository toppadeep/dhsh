<template>
  <div
    @click="$emit('select', option.name)"
    class="
      emp
      pr-5
      pl-5
      pt-2
      pb-2
      bg-white dark:bg-dark-800
      hover:bg-gray-100 dark:hover:bg-dark-900
      shadow-md
      cursor-pointer
    "
  >
    {{ option.name }}
  </div>
</template>

<script>
export default {
  props: {
    option: {
      type: Object,
      default: () => {},
    },
  },
};
</script>