<template>
  <div
    class="
      flex
      justify-center
      items-center
      mx-auto
      min-w-7xl
      w-full
      max-h-full
      flex-col flex-nowrap
      space-y-4
    "
  >
    <div
      class="
        flex
        w-full
        h-full
        justify-center
        items-center
        flex-nowrap flex-col
        mr-5
        ml-5
        relative
      "
      style="
        background-image: linear-gradient(
          106.19deg,
          #e2f1ff 7.09%,
          #fffde6 91.38%
        );
      "
    >
      <div
        class="
          flex
          justify-center
          items-center
          flex-row flex-nowrap
          max-w-7xl
          w-full
          h-64
          px-5
          pt-5
          relative
        "
      >
        <div
          class="
            flex
            w-full
            flex-col flex-nowrap
            justify-center
            items-center
            text-center
          "
        >
          <h1 class="mb-5 text-md md:text-4xl">Все документы</h1>
          <p class="font-light mb-5 text-lg">
            Важная информация в удобном виде
          </p>
        </div>
      </div>
    </div>
    <div
      class="
        flex
        max-w-7xl
        w-full
        flex-col flex-nowrap
        p-5
        bg-gray-100
        dark:bg-dark-900
        rounded-tr-lg rounded-tl-lg
      "
    >
      <form
        @submit.prevent="submit"
        class="
          flex
          w-full
          flex-row flex-nowrap
          justify-between
          items-center
          rounded-full
          p-0
          mt-2
        "
        action=""
      >
        <div
          class="
            flex flex-row
            w-full
            justify-start
            items-center
            bg-white
            dark:bg-dark-800
            rounded-full
            border border-gray-200
          "
        >
          <span class="h-max p-2 pr-5 pl-5">
            <i class="fa-solid fa-magnifying-glass text-gray-500"></i>
          </span>
          <input
            class="
              m-0
              ring-0
              focus:ring-0
              rounded-full rounded-tl-lg rounded-bl-lg
              pl-2
            "
            placeholder="Поиск"
            type="search"
            name=""
            v-model="search"
          />
        </div>
      </form>
      <div
        v-if="search"
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
          dark:bg-dark-800
          rounded-lg
          p-5
          mt-5
        "
      >
        <h3>
          Результат поиска:
          <span class="text-black dark:text-white">"{{ search }}"</span>
        </h3>
        <div
          class="
            flex
            max-w-7xl
            w-full
            flex-row flex-wrap
            justify-start
            items-center
            space-y-4
          "
        >
          <Document
            class="dark:bg-dark-900 first:mt-4"
            v-for="document in searchForAll"
            :key="document.id"
            :document="document"
          />
        </div>
      </div>
    </div>
    <Lists category="Образование" id="education" />
    <Lists category="Нормативно-правовые" id="normative" />
    <Lists category="Платные образовательные услуги" id="paidservices" />
    <Lists category="Финансово-хозяйственная" id="economicactivity" />
    <Lists category="Прочее" id="other" />
  </div>
</template>

<script>
import Document from "../../components/documents/document-tab.vue";
import Lists from "../../components/documents/lists.vue";
export default {
  data() {
    return {
      search: "",
      documents: [],
    };
  },
  components: {
    Document,
    Lists,
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
    this.initData();
  },
  computed: {
    searchForAll() {
      return this.documents.filter(
        (el) =>
          this.search == "" ||
          el.title.toLowerCase().indexOf(this.search.toLowerCase()) !== -1
      );
    },
  },
};
</script>

