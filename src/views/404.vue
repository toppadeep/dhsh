<template>
  <div
    class="
      flex
      max-w-7xl
      w-full
      h-max
      justify-center
      items-center
      bg-white
      dark:bg-dark-800
      text-black
      dark:text-white
    "
  >
    <div
      class="
        flex flex-row
        w-full
        h
        m-20
        flex-nowrap
        justify-center
        items-center
      "
    >
      <div
        class="flex w-1/2 h-96"
        :style="{
          backgroundImage: 'url(' + require('@/assets/' + '404.jpg') + ')',
          backgroundRepeat: 'no-repeat',
        }"
      ></div>
      <div
        class="flex w-1/2 h-95 justify-center items-center flex-col flex-nowrap"
      >
        <span class="text-4xl md:text-9xl">404</span>
        <h1 class="font-bold text-3xl">Страница не найдена</h1>
        <router-link to="/"
          ><i class="fa-solid fa-arrow-left-long"></i> Вернуться
        </router-link>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  data() {
    return {
      title: "Ошибка 404",
    };
  },
  metaInfo() {
    return {
      title: this.title,
      // ...
    };
  },
};
</script>

<style scoped>
.h {
  height: 500px;
}
</style>