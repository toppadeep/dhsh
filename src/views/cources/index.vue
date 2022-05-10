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
          <h1 class="mb-5 text-md md:text-4xl">Направления</h1>
          <p class="font-light mb-5 text-lg">
            Всё что поможет развитию навыков
          </p>
        </div>
      </div>
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
      cources: [],
    };
  },
  components: {
    CourceItem,
  },
  methods: {
    async initData() {
      const response = await fetch(`${process.env.VUE_APP_ROOT_API}/course`, {
        method: "GET",
      });
      this.cources = await response.json();
    },
  },
  async created() {
    this.initData();
  },
};
</script>
