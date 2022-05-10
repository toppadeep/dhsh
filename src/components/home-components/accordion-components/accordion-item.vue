<template>
  <div
    @click="show = !show"
    class="
      flex
      w-full
      justify-start
      items-center
      flex-row flex-wrap
      cursor-pointer
      transition-all
      ease-in-out
      duration-1000
    "
  >
    <div
      class="
        flex
        w-full
        justify-between
        items-center
        flex-row flex-wrap
        p-3
        border border-gray-200
        rounded-lg
        mb-2
      "
    >
      <div class="flex flex-row flex-nowrap">
        <h4 class="uppercase font-normal md:text-base">
          {{ faqItems.question }}
        </h4>
      </div>

      <i v-if="!show" class="fa-solid fa-angle-up"></i>
      <i v-if="show" class="fa-solid fa-angle-down"></i>
      <transition name="slide-fade">
        <div
          v-if="show"
          class="
            flex
            w-full
            justify-start
            items-center
            flex-row flex-nowrap
            font-body
            p-5
            transition-all
            ease-in-out
            duration-1000
            mt-5
            mb-5
            rounded-md
            text-white
          "
        >
          <h3 v-html="faqItems.answer" class="font-medium"></h3>
          <i class="fa-solid fa-turn-up ml-4"></i>
        </div>
      </transition>
    </div>
  </div>
</template>

<script>
export default {
  data() {
    return {
      show: false,
    };
  },
  props: {
    faqItems: {
      type: Object,
      default: () => {},
    },
  },
};
</script>
