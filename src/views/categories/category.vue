<template>
  <div
    class="
      flex
      justify-center
      items-center
      mx-auto
      max-w-7xl
      w-full
      flex-col flex-nowrap
      bg-white
      dark:bg-dark-800
    "
  >
  <h1>Категория  {{ category.name }} </h1>
  </div>
</template>

<script>
export default {
  data() {
    return {
      category: {},
    };
  },
   methods: {
    async initData() {
      const response = await fetch(
        `${process.env.VUE_APP_ROOT_API}/category/${this.$route.params.category}`,
        {
          method: "GET",
        }
      );
      this.category = await response.json();

    },
  },
  async created() {
    await this.initData();
  },
};
</script>

<style>
</style>