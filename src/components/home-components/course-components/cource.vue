<template>
  <div
    class="
      flex
      justify-center
      items-center
      flex-col flex-nowrap
      max-w-7xl
      h-max
      pt-0
      mb-10
      box-border
      relative
      rounded-lg 
    "
  >
    <Description
      v-for="(obj, index) in dataDecription"
      :key="index"
      :dataDecription="obj"
    />
    <Carousel :cources="cources" :loop="2" :width="400" :swipes="cources.length" />
  </div>
</template>

<script>
import Carousel from "../../carousel-components/carousel.vue";
import Description from "../decription.vue";
export default {
  data() {
    return {
      cources: [],
      dataDecription: [
        {
          title: "Направления",
          desc: "В нашем образовательном учреждении мы предлагаем множество программ и преимуществ для успешного обучения ваших детей, позволяя при этом оставаться активным, творческим и здоровым",
        },
      ],
    };
  },
  components: { Description, Carousel },
  async created() {
    const response = await fetch(`${process.env.VUE_APP_ROOT_API}/course`, {
      method: "GET",
    });
    this.cources = await response.json();
  },
};
</script>
