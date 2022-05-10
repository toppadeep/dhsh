<template>
  <div
    class="
      flex
      w-full
      flex-col flex-nowrap
      justify-start
      items-start
      space-y-4
      py-10
      dark:bg-dark-900
      rounded-lg
    "
  >
    <div
      v-if="filterDocs.length !== 0"
      class="
        flex
        max-w-7xl
        w-full
        h-max
        flex-row flex-wrap
        justify-start
        items-center
        space-y-4
      "
    >
      <Carousel class="hidden md:flex" :documents="filterDocs" :width="244" :loop="3" :swipes="filterDocs.length" />
      <Document-tab :document="file" />
    </div>
    <div v-else class="flex w-full h-full justify-center items-center">
      <Loader :loading="loading" />
    </div>
  </div>
</template>

<script>
import Loader from "../loaders/loader.vue";
import Carousel from "../carousel-components/carousel.vue";
import DocumentTab from './document-tab.vue';
export default {
  data() {
    return {
      documents: [],
    };
  },
  components: {
    Loader,
    Carousel,
    DocumentTab,
  },
  props: {
    category: {
      type: String,
    },
  },
  methods: {
    async initData() {
      const response = await fetch(`${process.env.VUE_APP_ROOT_API}/document`, {
        method: "GET",
      });
      this.documents = await response.json();
    },
  },
  async created() {
    this.loading = true;
    try {
      this.initData();
    } catch {
      this.loading = false;
    }
  },
  computed: {
    filterDocs() {
      return this.documents.filter((el) => el.category === this.category);
    },
  },
};
</script>

<style>
</style>