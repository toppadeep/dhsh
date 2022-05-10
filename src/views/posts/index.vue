<template>
  <div
    class="
      flex
      justify-center
      items-center
      w-full
      mx-auto
      flex-col flex-nowrap
      text-black
      dark:text-white
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
    >
      <div
        class="
          flex
          justify-center
          items-center
          flex-row flex-nowrap
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
          <h1 class="mb-5 text-md md:text-4xl">Новости</h1>
          <p class="font-light mb-5 text-lg">Много чего интересного</p>
        </div>
      </div>
    </div>
    <div class="flex max-w-7xl w-full justify-end p-2 rounded-lg mt-10">
      <div
        class="
          flex
          w-full
          flex-col
          md:flex-row
          justify-between
          md:space-x-4
          items-end
        "
      >
        <div class="flex w-full flex-col flex-nowrap space-y-4">
          <span class="font-bold">Категории</span>
          <div class="flex w-full items-center flex-row space-x-4">
            <Select :options="categories" @filterOption="change($event)" />
            <div
              class="
                flex
                text-white
                bg-main
                rounded-full
                justify-center
                items-center
                w-6
                h-6
                ml-5
              "
              v-if="filtered"
            >
              {{ filtered.length }}
            </div>
          </div>
        </div>
        <form
          @submit.prevent="submit"
          class="
            flex
            w-full
            flex-row flex-nowrap
            justify-between
            items-center
            rounded-full
            p-0
            mt-2
          "
          action=""
        >
          <div
            class="
              flex flex-row
              w-full
              justify-start
              items-center
              bg-white
              dark:bg-dark-800
              rounded-full
              border border-gray-200
            "
          >
            <span class="h-max p-2 pr-5 pl-5">
              <i class="fa-solid fa-magnifying-glass text-gray-500"></i>
            </span>
            <input
              class="
                m-0
                ring-0
                focus:ring-0
                rounded-full rounded-tl-lg rounded-bl-lg
                pl-2
              "
              placeholder="Поиск"
              type="search"
              name=""
              v-model="search"
            />
          </div>
        </form>
      </div>
    </div>
    <div
      class="
        flex
        max-w-7xl
        w-full
        h-max
        flex-col flex-wrap
        justify-start
        rounded-lg
        mt-2
        p-2
        mb-10
      "
    >
      <div class="flex w-full h-full justify-center items-center">
        <loader :loading="loading" />
      </div>
      <h3 v-if="search != ''" class="ml-5 mb-5">
        Результат поиска:
        <span class="font-bold text-xl text-black dark:text-white"
          >"{{ search }}"</span
        >
      </h3>
      <div
        v-if="filtered.length == 0"
        class="flex w-full h-72 justify-center items-center flex-col"
      >
        <i class="fa-solid fa-magnifying-glass mb-2 text-2xl"></i>
        <h4>Не найдено</h4>
      </div>
      <div
        v-else-if="posts.length !== 0"
        class="flex flex-col lg:flex-row justify-between"
      >
        <div class="flex w-full lg:w-1/2 flex-col flex-nowrap">
          <blog-item
            v-for="post in filtered.slice().reverse()"
            :key="post.id"
            :post="post"
          />
        </div>
        <div
          class="
            flex flex-col flex-wrap
            justify-start
            items-start
            w-full
            lg:w-1/2
            pl-5
            pr-5
          "
        >
          <h2 class="m-5">
            <i class="fa-solid fa-bookmark mr-2"></i>Избранные
          </h2>
          <div v-if="isLoggedIn" class="flex w-full flex-row flex-wrap">
            <Favorite v-for="fav in favorites" :key="fav.id" :fav="fav" />
          </div>
          <div
            v-else-if="!isLoggedIn"
            class="flex w-full flex-col justify-center items-center flex-wrap"
          >
            <router-link
              to="/login"
              class="h-max pl-5 pr-5 p-2 border m-2 border-gray-200 rounded-md"
            >
              Войти
            </router-link>
            <p>Войдите, чтобы посмотреть</p>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>
<script>
export default {
  components: {
    Select: () => import("../../components/select/select.vue"),
    Loader: () => import("../../components/loaders/loader.vue"),
    BlogItem: () => import("../../components/blog-components/blog-item.vue"),
    Favorite: () => import("../../components/blog-components/favorite.vue"),
  },
  data() {
    return {
      token: this.$store.state.auth.token,
      title: "ДХШ - СОБЫТИЯ",
      loading: false,
      search: "",
      posts: [],
      categories: null,
      selectCategory: "Категории",
      pagination: {
        meta: null,
        links: null,
      },
    };
  },
  metaInfo() {
    return {
      title: this.title,
    };
  },
  async created() {
    this.loading = true;
    try {
      this.getPosts();
    } catch {
      this.loading = false;
    }
    this.getCategories();
  },
  methods: {
    async getPosts() {
      const myHeaders = new Headers();
      myHeaders.append("Authorization", `Bearer ${this.token}`);
      const response = await fetch(`${process.env.VUE_APP_ROOT_API}/post`, {
        method: "GET",
        headers: myHeaders,
      });
      const posts = await response.json();
      this.posts = posts;
      this.loading = false;
    },
    async getCategories() {
      const categories = await fetch(
        `${process.env.VUE_APP_ROOT_API}/category`,
        {
          method: "GET",
        }
      );
      this.categories = await categories.json();
    },
    change(select) {
      this.selectCategory = select;
    },
    isOpen() {
      this.show = !this.show;
    },
  },
  computed: {
    isLoggedIn: function () {
      return this.$store.getters.isLoggedIn;
    },
    favorites() {
      return this.$store.state.auth.favorites;
    },
    filtered: function () {
      return this.posts
        .filter((post) => {
          return (
            this.selectCategory == "Категории" ||
            post.category == this.selectCategory
          );
        })
        .filter((post) => {
          return (
            this.search == "" ||
            post.title.toLowerCase().indexOf(this.search.toLowerCase()) !== -1
          );
        });
    },
  },
};
</script>
