<template>
  <div
    class="
      flex flex-col flex-nowrap
      w-full
      md:w-max
      h-max
      bg-white dark:bg-dark-800 dark:border-gray-400
      rounded-md
      relative
      mt-2
    "
  >
    <div
      @click="show = !show"
      :class="{ active: show }"
      class="
        flex
        justify-between
        items-center
        w-full
        md:w-64
        h-11
        pr-5
        pl-5
        border border-gray-200
        rounded-md
        cursor-pointer
      "
    >
      {{ selectOption }}
      <i v-if="!show && selectOption == 'Категории'" class="fa-solid fa-angle-up text-xs text-gray-400"></i>
      <i @click="selectChange('Категории')" v-if="selectOption != 'Категории'" class="z-20 fa-solid fa-xmark"></i>
    </div>
    <div
      v-if="show"
      class="
        flex
        w-full
        flex-col flex-nowrap
        h-max max-h-56
        overflow-y-scroll
        scroll
        absolute
        top-12
        z-10
        rounded-md
      "
    >
      <Option
        @select="selectChange"
        :option="{ name: 'Категории' }"
      />
      <Option
        @select="selectChange"
        v-for="category in options"
        :key="category.id"
        :option="category"
      />
    </div>
  </div>
</template>

<script>
import Option from "./option.vue";
export default {
  data() {
    return {
      show: false,
      selectOption: 'Категории',
    };
  },
  components: { Option },
  props: {
    options: {
      type: Array,
      default: () => [],
    },
  },
  methods: {
    selectChange(option) {
      this.selectOption = option;
      this.show = !this.show;
      this.$emit("filterOption", option);
    },
  },

};
</script>

<style scoped>
.active {
  border: 2px solid gray;
}
</style>