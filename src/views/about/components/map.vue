<template>
  <div
    class="
      flex
      w-full
      flex-col
      md:flex-row
      flex-wrap
      p-10
      justify-between
      items-start
      bg-gray-100
      dark:bg-dark-900
      rounded-lg
      sm:space-y-4
    "
  >
    <div class="flex w-full md:w-1/2 flex-col flex-nowrap space-y-4 p-4">
      <h2>Наши координаты</h2>
      <p>Адрес: 663600 Красноярский край, г. Канск, ул. Московская, дом 64</p>
      <p>
        Вы так же можете простроить маршрут или отследить другую интересующую
        вас информацию
      </p>
    </div>
    <div class="flex w-full md:w-1/2 justify-center items-center">
      <yandex-map
        id="map"
        :coords="[56.204999, 95.709798]"
        zoom="18"
        class="rounded-lg w-full h-96"
      >
        <ymap-marker
          v-for="n in markers"
          :key="n.id"
          :marker-id="n.id"
          marker-type="placemark"
          :coords="n.coord"
          :balloon="{ body: n.text }"
        ></ymap-marker>
      </yandex-map>
    </div>
  </div>
</template>

<script>
export default {
  data() {
    return {
      markers: [{ coord: [56.204999, 95.709798], text: "ДХШ" }].map((n, i) => ({
        ...n,
        id: i + 1,
      })),
    };
  },
};
</script>

<style>
</style>