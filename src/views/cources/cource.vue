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
    "
  >
    <div
      class="
        flex
        justify-center
        items-center
        flex-col flex-nowrap
        w-full
        h-max
        rounded-xl
        m-2
        border border-gray-200
        relative
      "
      :style="{
        backgroundImage: `url(${cource.cover})`,
        backgroundSize: '100% 50%',
        backgroundRepeat: 'no-repeat',
      }"
    >
      <div
        class="
          flex
          w-full
          justify-center
          items-start
          flex-col flex-nowrap
          p-5
          pl-10
          bg-white/50
          backdrop-blur-xl
          rounded-xl
        "
      >
        <img
          :src="cource.cover"
          :alt="cource.title"
          :title="cource.title"
          class="flex w-32 h-32 rounded-full bg-contain shadow-2xl"
        />
        <h1 class="mt-5">{{ cource.title }}</h1>
      </div>
    </div>
    <div class="flex w-full flex-col md:flex-row flex-nowrap">
      <div class="flex w-full md:w-1/2 flex-col flex-nowrap justify-start items-start">
        <h3 class="mb-10 mt-10 font-bold text-xl">О курсe</h3>
        <p class="w-full" v-html="cource.body"></p>
      </div>
      <div class="flex w-full md:w-1/2">
        <Gallery :images="cource.images" />
      </div>
    </div>
  </div>
</template>

<script>
import Gallery from '../../components/carousel-components/gallery.vue';
// import Slider from "../../components/carousel-components/slider.vue";
export default {
  data() {
    return {
      cource: null,
      cources: [],
    };
  },
  components: {
    Gallery
    // Slider,
  },
  methods: {
    async initData() {
      const response = await fetch(`${process.env.VUE_APP_ROOT_API}/course`, {
        method: "GET",
      });
      this.cources = await response.json();
      const filteredCource = this.cources.find(
        (el) => el.slug === this.$route.params.cource
      );

      if (filteredCource) {
        this.cource = filteredCource;
      } else {
        this.$route.push("/");
      }
    },
  },
  async created() {
    this.initData();
  },
};
</script> 

<style>
</style>