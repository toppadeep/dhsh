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
      space-y-8
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
          <h1 class="mb-5 text-md md:text-4xl">
            Сведения об образовательной организации
          </h1>
          <p class="font-light mb-5 text-lg">Общие положения и документы</p>
        </div>
      </div>
    </div>
    <div class="flex flex-сol flex-wrap max-w-7xl w-full">
      <div
        class="
          flex
          w-full
          sticky
          top-16
          flex-nowrap flex-row
          z-20
          overflow-x-auto
          pb-2
          bg-white
          dark:bg-dark-800
        "
      >
        <button
          v-for="(tab, index) in tabs"
          :key="index"
          class="
            flex
            w-full
            justify-between
            items-center
            flex-row flex-nowrap
            text-sm
            relative
            rounded-lg
            dark:hover:bg-dark-900
            border-none
          "
          :class="{
            ' bg-gray-100 dark:bg-dark-900': currentTab == tab,
          }"
          @click="currentTab = tab"
        >
          <p class="w-max break-normal">{{ tab }}</p>
          <span
            class="w-2 h-2 rounded-full bg-gray-200 ml-4"
            :class="{
              'bg-blue-500': currentTab == tab,
            }"
          ></span>
        </button>
      </div>
      <keep-alive>
        <component :is="currentTab"></component>
      </keep-alive>
    </div>
  </div>
</template>

<script>
import Education from "./components/education.vue";
import MainInfo from "./components/main-info.vue";
import Map from "./components/map.vue";
import Paidservices from "./components/paidservices.vue";
export default {
  data() {
    return {
      currentTab: "Основные сведения",
      tabs: ["Основные сведения", "Образование", "Платные услуги", "Карта"],
    };
  },
  components: {
    Карта: Map,
    Образование: Education,
    "Основные сведения": MainInfo,
    "Платные услуги": Paidservices,
  },
};
</script>


