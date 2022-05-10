<template>
  <div
    class="
      flex
      w-full
      justify-between
      items-start
      flex-wrap flex-row
      mt-1
      mb-10 pt-5
      rounded-lg
    "
  >
    <h2 class="flex w-full uppercase pb-10 tracking-widest">
      {{ dataDecription.title }}
    </h2>
    <p class="flex w-full text-start tracking-wider">
      {{ dataDecription.desc }}
    </p>
  </div>
</template>

<script>
export default {
  props: {
    dataDecription: {
      type: Object,
      default: () => {},
    },
  },
};
</script>
