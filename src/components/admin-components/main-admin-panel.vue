<template>
  <div
    class="
      flex
      justify-between
      items-center
      mx-auto
      w-full
      h-full
      flex-row flex-nowrap
      relative
      bg-white
      dark:bg-dark-800
    "
  >
    <div v-if="show" class="flex flex-col w-max justify-start items-start flex-nowrap absolute bottom-5 left-5 z-50 space-y-4 p-4 rounded-lg bg-gray-200" >
     <div class="flex flex-row flex-nowrap justify-between items-start">
        <h2 class=" w-96">Добро пожаловать, руководство использования здесь</h2>
          <i
          class="fa-solid fa-xmark cursor-pointer ml-4 text-xl text-black"
          @click="show = false"
        ></i>
     </div>

      <iframe
        width="432"
        height="300"
        src="https://miro.com/app/live-embed/uXjVO4AFwZg=/?moveToViewport=-3043,-1429,5843,2924"
        frameBorder="0"
        scrolling="no"
        allowFullScreen
      ></iframe>
      <button><h3>Больше не показывать</h3></button>
    </div>
    <div
      class="
        hidden
        lg:flex
        justify-start
        items-center
        p-5
        w-72
        h-screen
        flex-col flex-nowrap
        dark:bg-dark-900
      "
    >
      <div class="flex w-full justify-start items-center flex-row flex-wrap">
        <router-link to="/" class="text-2xl uppercase font-bold" title="Главная"
          ><img src="@/assets/logodefault.svg" class="w-24 h-16" alt="Главная"
        /></router-link>
      </div>
      <div class="flex justify-start items-center w-full rounded-md mt-4 p-2">
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
      <div class="flex w-full flex-nowrap flex-col mt-5">
        <button
          v-for="(tab, index) in tabs"
          :key="index"
          class="
            flex
            w-full
            justify-between
            items-center
            flex-row flex-nowrap
            mb-2
            text-sm
            relative
            rounded-lg
            dark:hover:bg-dark-900
          "
          :class="{
            ' border-blue-500 dark:bg-dark-900': currentTab == tab,
          }"
          @click="currentTab = tab"
        >
          <span
            :class="{
              ' bg-blue-500 shadow-lg': currentTab == tab,
            }"
            class="
              w-2
              h-full
              bg-gray-200
              absolute
              left-0
              rounded-bl-lg rounded-tl-lg
            "
          ></span>
          <p class="font-semibold">{{ tab }}</p>
          <i class="fa-solid fa-arrow-up-right-from-square"></i>
        </button>
      </div>
      <div
        class="
          flex
          w-full
          justify-between
          items-center
          dark:bg-dark-800
          mt-5
          p-4
          rounded-lg
        "
      >
        <span>Light</span> <Setting /> <span>Night</span>
      </div>
    </div>
    <div
      class="
        flex
        w-full
        justify-start
        items-center
        flex-col flex-nowrap
        pt-20
        pr-5
        pl-5
        h-screen
        overflow-y-auto
        relative
      "
    >
      <div
        class="
          flex
          w-full
          justify-between
          items-center
          flex-row flex-nowrap
          pt-5
          pl-2
          pr-2
        "
      >
        <h1 class="text-3xl">
          {{ phrasers }}, <span class="font-bold"> {{ user.login }} </span>
        </h1>
        <span class="font-bold text-xl"> {{ date }} </span>
      </div>
      <keep-alive>
        <component class="mt-10 pl-2 pr-2" :is="currentTab"></component>
      </keep-alive>
    </div>
  </div>
</template>


<script>
import Cource from "../admin-components/cource.vue";
import Posts from "../admin-components/posts.vue";
import Teacher from "../admin-components/teacher.vue";
import Category from "../admin-components/category.vue";
import Doc from "../admin-components/docs.vue";
import Setting from "../settings/setting.vue";
export default {
  data() {
    return {
      show: true,
      date: null,
      time: null,
      phrasers: null,
      currentTab: "Posts",
      tabs: ["Posts", "Teachers", "Cources", "Categories", "Documents"],
    };
  },
  components: {
    Posts: Posts,
    Teachers: Teacher,
    Cources: Cource,
    Categories: Category,
    Documents: Doc,
    Setting,
  },
  computed: {
    editor() {
      return this.$refs.myQuillEditor.quill;
    },
    user() {
      return this.$store.state.auth.user;
    },
  },
  created() {
    setInterval(this.getNow);
    setInterval(this.currentphrasers);
  },

  methods: {
    async logout() {
      await this.$store.dispatch("LogOut");
      this.$router.push("/");
    },
    currentphrasers() {
      if (this.time >= 6 && this.time <= 12) {
        this.phrasers = "Доброе утро";
      } else if (this.time > 12 && this.time <= 16) {
        this.phrasers = "Добрый день";
      } else if (this.time > 16 && this.time <= 23) {
        this.phrasers = "Добрый вечер";
      } else if (this.time > 23 && this.time <= 5) {
        this.phrasers = "Доброй ночи";
      } else {
        this.phrasers = "Здравствуйте";
      }
    },
    getNow: function () {
      const today = new Date();
      const date =
        today.getFullYear() +
        "-" +
        (today.getMonth() + 1) +
        "-" +
        today.getDate();
      const time = today.getHours();
      this.time = time;
      this.date = date;
    },
  },
};
</script>