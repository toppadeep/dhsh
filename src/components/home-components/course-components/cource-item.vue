<template>
  <router-link
    :title="cource.title"
    :to="{ name: 'courses-cource', params: { cource: cource.slug } }"
    class="flex
      rounded-xl relative
    "
  >
    <div
      class="
        flex
        w-full
        justify-center
        items-center
        flex-col flex-nowrap
        p-5
        bg-white/50
        dark:bg-dark-900/50
        rounded-xl
      "
    >
      <div
        :style="{
          backgroundImage: `url(${cource.cover})`,
          backgroundSize: 'cover',
        }"
        :title="cource.title"
        class="flex rounded-full shadow-2xl h-16 w-16 md:w-32 md:h-32"
      ></div>
      <p class="mt-5">{{ cource.title }}</p>
    </div>
    <div
      class="
        flex
        pl-5
        pr-5
        p-2
        rounded-tl-lg
        justify-center
        items-center
        absolute
        top-0
        left-0
        bg-green-600
      "
    >
      <span class="text-white">{{ cource.payment }}</span>
    </div>
  </router-link>
</template>

<script>
export default {
  data() {
    return {};
  },
  props: {
    cource: {
      type: Object,
      default: () => {},
    },
  },
};
</script>
