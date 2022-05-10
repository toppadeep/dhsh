<template>
  <div
    class="
      flex
      justify-center
      items-center
      mx-auto
      max-w-7xl
      w-full
      max-h-full
      flex-col flex-nowrap
      bg-white
      dark:bg-dark-800
      text-black
      dark:text-white
    "
  >
    <div
      class="
        flex
        w-full
        flex-col flex-nowrap
        p-10
        rounded-lg
        space-y-8
        bg-yellow-200
      "
    >
      <p class="text-gray-600">Категории</p>
      <h1 class="text-4xl">Всё что поможет в развитии ваших навыков</h1>
    </div>
    <div
      class="
        flex flex-row
        justify-start
        flex-wrap
        max-w-7xl
        w-full
        h-max
        pt-10
        pb-10
      "
    >
      <Cource-item
        v-for="cource of cources"
        :key="cource.id"
        :cource="cource"
      />
    </div>
  </div>
</template>

<script>
import CourceItem from "../../components/home-components/course-components/cource-item.vue";
export default {
  data() {
    return {
      categories: [],
    };
  },
  components: {
    CourceItem,
  },
  methods: {
    async initData() {
      const response = await fetch(`${process.env.VUE_APP_ROOT_API}/category`, {
        method: "GET",
      });
      this.categories = await response.json();
    },
  },
  async created() {
    this.initData();
  },
};
</script>
