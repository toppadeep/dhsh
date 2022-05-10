<template>
  <nav
    class="
      flex
      justify-center
      items-center
      w-full
      h-16
      fixed
      top-0
      z-50
      px-4
      backdrop-blur-lg
    "
  >
    <div
      class="
        flex
        justify-between
        items-center
        flex-row
        max-w-7xl
        w-full
        h-16
        relative
      "
    >
      <div class="flex justify-start items-center flex-row flex-wrap">
        <i
          class="fa-solid fa-bars flex md:hidden text-xl"
          @click="menu = !menu"
        ></i>
        <router-link to="/" class="text-2xl uppercase font-bold" title="Главная"
          ><img src="@/assets/logodefault.svg" class="w-24 h-16" alt="Главная"
        /></router-link>
      </div>
      <nav class="hidden md:flex items-center">
        <ul class="topmenu">
          <li>
            <router-link to="/posts">Блог</router-link>
            <ul class="submenu bg-white dark:bg-dark-800">
             <li>
                <router-link :to="{ name: 'bookmarks' }"
                  >Избранное</router-link
                >
              </li>
            </ul>
          </li>
          <li><router-link to="/cources">Курсы</router-link></li>
          <li>
            <router-link to="/parrent">Родителям</router-link>
            <ul class="submenu bg-white dark:bg-dark-800">
              <li><a href="">Правила поступления</a></li>
              <li><a href="">Рекомендуемые художественные материалы</a></li>
              <li><a href="">Группы развития детей</a></li>
              <li><a href="">Художественное отделение</a></li>
              <li><a href="">Расписание</a></li>
              <li>
                <a href="">Заявление для приема на бюджетное отделение</a>
              </li>
            </ul>
          </li>
          <li>
            <router-link to="/cources">Учащимся</router-link>
          </li>
          <li>
            <router-link to="/documents">Документы</router-link>
            <ul class="submenu bg-white dark:bg-dark-800">
              <li>
                <router-link :to="{ name: 'documents', hash: '#education' }"
                  >Образование</router-link
                >
              </li>
              <li>
                <router-link :to="{ name: 'documents', hash: '#normative' }"
                  >Нормативно-правовые</router-link
                >
              </li>
              <li>
                <router-link :to="{ name: 'documents', hash: '#paidservices' }"
                  >Платные образовательные услуги</router-link
                >
              </li>
              <li>
                <router-link
                  :to="{ name: 'documents', hash: '#economicactivity' }"
                  >Финансово-хозяйственная деятельность</router-link
                >
              </li>
              <li>
                <router-link :to="{ name: 'documents', hash: '#other' }"
                  >Прочее</router-link
                >
              </li>
            </ul>
          </li>
          <li>
            <router-link to="/about">О нас</router-link>
            <ul class="submenu bg-white dark:bg-dark-800">
              <li><a href="">Основные сведения</a></li>
              <li>
                <a href=""
                  >Структура и органы управления образовательной организацией</a
                >
              </li>
              <li>
                <router-link :to="{ name: 'about', hash: '#education' }"
                  >Образование</router-link
                >
              </li>
              <li>
                <router-link :to="{ name: 'about', hash: '#standarts' }"
                  >Образовательные стандарты</router-link
                >
              </li>
              <li>
                <router-link :to="{ name: 'about', hash: '#staff' }"
                  >Руководство и педагогический состав</router-link
                >
              </li>
              <li>
                <router-link :to="{ name: 'about', hash: '#provision' }"
                  >Материально-техническое обеспечение</router-link
                >
              </li>
              <li>
                <router-link :to="{ name: 'about', hash: '#financialsupport' }"
                  >Стипендии и иные виды материальной поддержки</router-link
                >
              </li>
              <li>
                <router-link :to="{ name: 'about', hash: '#paidservices' }"
                  >Платные образовательные услуги</router-link
                >
              </li>
              <li>
                <router-link :to="{ name: 'about', hash: '#jobopenings' }"
                  >Вакантные места для приема (перевода)</router-link
                >
              </li>
            </ul>
          </li>
        </ul>
      </nav>
      <Setting class="hidden md:flex" />
      <div>
        <router-link
          v-if="isLoggedIn && user.status == 2"
          to="/admin-panel"
          class=""
          >СMS</router-link
        >
        <div
          v-else-if="isLoggedIn && user.status == 1"
          class="flex justify-start items-center w-full rounded-md mt-4 p-2"
        >
          <img class="flex rounded-full w-10 h-10" :src="user.avatar" alt="" />
          <div class="flex flex-col flex-nowrap ml-5">
            <span class="font-bold"> {{ user.login }} </span>
            <span
              class="text-gray-400 hover:text-blue-500 cursor-pointer"
              @click="logout"
            >
              Выйти
            </span>
          </div>
        </div>
        <router-link v-else to="/login" class="">Войти</router-link>
      </div>
      <div
        v-if="menu"
        class="
          flex flex-row flex-wrap
          justify-start
          items-start
          w-full
          h-screen
          p-4
          absolute
          top-14
          bg-gray-100
          dark:bg-dark-900
          z-50
        "
      >
        <Menu />
        <div
          class="
            flex
            w-full
            justify-between
            items-center
            bg-gray-200
            dark:bg-dark-800
            mt-5
            p-4
            rounded-lg
          "
        >
          <span>Light</span> <Setting /> <span>Night</span>
        </div>
      </div>
    </div>
  </nav>
</template>

<script>
import Setting from "../../settings/setting.vue";

import Menu from "../menu/menu.vue";
export default {
  components: { Setting, Menu },
  data() {
    return {
      menu: false,
    };
  },
  methods: {
    async logout() {
      await this.$store.dispatch("LogOut");
      this.$router.push("/");
    },
  },
  computed: {
    isLoggedIn: function () {
      return this.$store.getters.isLoggedIn;
    },
    user() {
      return this.$store.state.auth.user;
    },
  },
};
</script>

<style scoped>
nav ul {
  list-style: none;
  margin: 0;
  padding: 0;
}
nav a {
  text-decoration: none;
  display: flex;
}
.topmenu > li {
  display: inline-block;
  position: relative;
}
.topmenu > li > a {
  @apply cursor-pointer border border-gray-200 pt-2 pb-2 pr-5 pl-5 rounded-full mr-2;
}
.topmenu > li > a:before {
  content: "";
  position: absolute;
  z-index: 5;
  left: 50%;
  top: 100%;
  width: 10px;
  height: 10px;
  border-radius: 50%;
  transform: translate(-50%, 20px);
  opacity: 0;
  transition: 0.3s;
}
.topmenu li:hover a:before {
  transform: translate(-50%, 0);
  opacity: 1;
}
.submenu {
  position: absolute;
  z-index: 4;
  left: 50%;
  top: 100%;
  width: max-content;
  padding: 15px 10px 15px;
  margin-top: 5px;
  border-radius: 5px;
  box-shadow: 0 0 30px rgba(0, 0, 0, 0.2);
  box-sizing: border-box;
  visibility: hidden;
  opacity: 0;
  transform: translate(-50%, 20px);
  transition: 0.3s;
}
.topmenu > li:hover .submenu {
  visibility: visible;
  opacity: 1;
  transform: translate(-50%, 0);
}
.submenu a {
  letter-spacing: 1px;
  padding: 5px 10px;
  transition: 0.3s linear;
  border-radius: 5px;
}
</style>