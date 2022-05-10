<template>
  <div class="flex flex-col shadow-lg flex-nowrap w-10/12 fixed bottom-5 left-1/2 z-50 bg-white dark:bg-dark-900 pt-10 pb-5 pl-10 pr-10 -translate-x-1/2 rounded-2xl border border-gray-200" v-if="isOpen">
    <div class="text-black dark:text-white">
        {{ message }}
    </div>
    <div class="flex w-full justify-end items-center mt-5 text-white">
        <button class="mr-2 bg-[#8C1824] border hover:border-black hover:text-white" @click="accept()" >Даю согласие на обработку данных</button>
    </div>
  </div>
</template>

<script>
export default {
  data() {
    return {
      isOpen: false,
      message:
        'Продолжая использовать наш сайт, вы даете согласие на обработку файлов cookie, пользовательских данных (сведения о местоположении; тип и версия ОС; тип и версия Браузера; тип устройства и разрешение его экрана; источник откуда пришел на сайт пользователь; с какого сайта или по какой рекламе; язык ОС и Браузера; какие страницы открывает и на какие кнопки нажимает пользователь; ip-адрес) в целях функционирования сайта, проведения ретаргетинга и проведения статистических исследований и обзоров. Если вы не хотите, чтобы ваши данные обрабатывались, покиньте сайт.требование ФЗ №152 ч. (9) "Согласие субъекта персональных данных на обработку его персональных данных")',
    };
  },
  created() {
      if (!this.getGDPR() === true) {
          this.isOpen = true
      }
  },
  methods: {
    getGDPR() {
      return localStorage.getItem("GDPR:accepted", true);
    },
    accept() {
        this.isOpen = false;
        localStorage.setItem("GDPR:accepted", true);
    },
    cansel() {
        this.isOpen = false;
        localStorage.setItem("GDPR:accepted", false);
    },
  },
};
</script>

<style>
</style>