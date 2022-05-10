<template>
  <div
    class="
      flex
      max-w-7xl
      w-full
      flex-col flex-nowrap
      justify-start
      items-start
      space-y-4
      px-5
      py-10
      bg-gray-100
      dark:bg-dark-900
      rounded-lg
      overflow-x-auto
    "
  >
    <h2 class="ml-4">{{ this.category }}</h2>

    <div
      v-if="filterDocs.length !== 0"
      class="table w-full mt-10 mb-10 overflow-x-auto"
    >
      <div class="table-header-group">
        <div class="table-row mb-4">
          <div class="table-cell text-left font-bold">Название</div>
          <div class="table-cell text-left font-bold">Тип</div>
          <div class="table-cell text-left font-bold">Размер</div>
          <div class="table-cell text-left font-bold">Скачать</div>
        </div>
      </div>
      <div class="table-row-group relative">
        <document-list
          v-for="(document, index) in filterDocs"
          :key="document.id"
          :index="index"
          :document="document"
          class="odd:bg-gray-200 dark:odd:bg-dark-800"
        />
      </div>
    </div>
    <div
      v-else-if="filterDocs.length == 0"
      class="flex w-full h-full justify-center items-center"
    >
      <p>Документы не найдены</p>
    </div>
    <div v-else class="flex w-full h-full justify-center items-center">
      <Loader :loading="loading" />
    </div>
  </div>
</template>

<script>
import Loader from "../loaders/loader.vue";
import DocumentList from "./document-list.vue";

export default {
  data() {
    return {
      documents: [],
    };
  },
  components: {
    Loader,
    DocumentList,
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
    console.log(this.category);
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