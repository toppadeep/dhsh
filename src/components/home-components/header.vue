<template>
  <div
    class="
      flex
      min-w-7xl
      w-full
      h-full
      justify-center
      items-center
      flex-nowrap flex-col
      relative
    "
  >
    <div class="flex justify-center items-center w-full h-96 md:h-screen">
      <Slider :slides="images" :auto="true" :controls="true" />
      <div
        class="
          flex
          w-full
          h-full
          flex-col flex-nowrap
          justify-center
          items-center
          text-center
          absolute
          backdrop-brightness-50
        "
      >
        <h1 class="mb-5 text-md md:text-6xl text-white">
          Детская художественная школа имени Иванова
        </h1>
        <p class="font-light mb-5 text-lg text-white">
          MБУДО ДХШ Муниципальное бюджетное учреждение дополнительного
          образования
        </p>
        <button>Поступить</button>
      </div>
    </div>
  </div>
</template>

<script>
import Slider from "../carousel-components/slider.vue";
export default {
  data() {
    return {
      images: [
        {
          url: "offer-1.jpg",
          title: "HITMAN ABSOLUTE",
        },
        {
          url: "offer-2.jpg",
          title: "SPIDER-MAN",
        },
        {
          url: "offer-3.jpg",
        },
        {
          url: "offer-4.jpg",
        },
        {
          url: "offer-5.jpg",
        },
        {
          url: "offer-7.jpg",
        },
      ],
    };
  },
  components: { Slider },
};
</script>

<style scoped>
.h {
  height: 600px;
}
</style>