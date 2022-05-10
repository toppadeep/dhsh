<template>
  <div
    class="
      flex
      justify-between
      items-center
      flex-col flex-nowrap
      max-w-7xl
      w-full
      h-max
      mt-10
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
    <div class="flex flex-row flex-wrap justify-between items-start">
      <Offer-item v-for="offer of offers" :key="offer.id" :offer="offer" />
    </div>
  </div>
</template>

<script>
import Description from "../decription.vue";
import OfferItem from "./offer-item.vue";
export default {
  components: {
    Description,
    OfferItem,
  },
  data() {
    return {
      dataDecription: [
        {
          title: "Что мы предлагаем?",
          desc: "В нашем образовательном учреждении мы предлагаем множество программ и преимуществ для успешного обучения ваших детей, позволяя при этом оставаться активным, творческим и здоровым",
        },
      ],
      offers: [
        {
          id: 1,
          title: "Множество программ для обучения",
          description:
            "Рисунок, живопись, декоративная композиция, лепка, и т.д",

          image: "/offer-1.jpg",
          color: "green",
        },
        {
          id: 2,
          title: "Квалифицированные педагоги ",
          description:
            "Рисунок, живопись, декоративная композиция, лепка, и т.д",
          image: "/offer-6.jpg",
          color: "green",
        },
        {
          id: 3,
          title: "Школа в центре города",
          description:
            "Вашим детям не придётся пробираться сквозь дворы, школа находится в шаговой доступности от остановок.",
          image: "/offer-2.jpg",
          color: "green",
        },
        {
          id: 4,
          title: "Счастливое окружение",
          description:
            "Педагоги помогут вашим детям чувствовать себя в безопасности",
          image: "/offer-4.jpg",
          color: "#ff9",
        },
        {
          id: 5,
          title: "Персональная помощь",
          description:
            "Рисунок, живопись, декоративная композиция, лепка, и т.д",
          image: "/offer-4.jpg",
          color: "purple",
        },
        {
          id: 7,
          title: "Креативные уроки",
          description:
            "ДХШ имени Е.В.Гурова сегодня - это удивительный мир творчества.",
          image: "/offer-1.jpg",
          color: "green",
        },
      ],
    };
  },
};
</script>

