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
      bg-white
      dark:bg-dark-800
      text-black
      dark:text-white
    "
  >
    <div
      class="
        flex
        justify-center
        items-start
        max-w-7xl
        w-full
        flex-row flex-nowrap
      "
    >
      <div
        class="
          hidden
          lg:flex
          w-1/6
          rounded-lg
          mr-10
          flex-col flex-nowrap
          backdrop-blur-lg
          bg-white/70
          sticky
          top-20
          bg-white
          dark:bg-dark-800
        "
      >
        <div class="flex w-full flex-col flex-nowrap p-5">
          <img
            class="rounded-full w-14 h-14 mb-5"
            :src="post.userAvatar"
            alt=""
          />
          <span class="text-main-second-black font-bold">
            @{{ post.userLogin }}
          </span>
          <span class="text-main-primary-gray-default">
            {{ post.userName }}
          </span>
        </div>

        <div
          class="
            flex
            w-full
            flex-row flex-wrap
            p-5
            rounded-md
            bg-gray-100
            dark:bg-dark-900
          "
        >
          <h4 class="text-md font-bold pb-2 border-b-2 border-white">
            Прикрепленные документы
            <i class="fa-solid fa-download text-main ml-2"></i>
          </h4>
          <div
            v-if="post.documents !== null"
            class="flex w-full mt-2 flex-col flex-wrap"
          >
            <span
              class="flex w-full text-sm line-clamp-1"
              v-for="(document, index) of post.documents"
              :key="index"
            >
              <a class="w-min" :href="document.path" :title="document.name">{{
                document.name
              }}</a>
            </span>
          </div>
          <div v-else class="flex w-full justify-center items-center p-2">
            <h3>Пусто</h3>
          </div>
        </div>
      </div>
      <div class="flex w-full md:w-10/12 flex-col flex-nowrap">
        <div
          class="
            flex flex-col flex-nowrap
            md:p-10
            pb-0
            mb-5
            w-full
            bg-white
            dark:bg-dark-800
            rounded-lg
          "
        >
          <h1 class="font-bold text-4xl text-main-second-black mb-5">
            {{ post.title }}
          </h1>
          <div
            class="
              flex
              w-full
              flex-row flex-nowrap
              justify-start
              items-center
              p-2
              mb-10
            "
          >
            <router-link to="/" class="mr-5">
              <i class="fa-solid fa-tag"></i>
              {{ post.category }}
            </router-link>
            <span class="text-sm"
              ><i class="fa-solid fa-calendar-days"></i> {{ post.date }}
            </span>
          </div>
          <h2 class="text-main-second-black mb-5 font-medium">
            {{ post.subtitle }}
          </h2>
          <div v-html="post.body" class=""></div>
          <img
            v-for="(file, index) in post.images"
            :key="index"
            class="rounded-lg w-full h-full"
            :src="file.path"
            alt=""
          />
        </div>
        <div
          class="
            flex
            w-full
            flex-col flex-nowrap
            bg-gray-100
            dark:bg-dark-900
            p-5
            rounded-lg
            mb-10
          "
        >
          <h2 class="pt-5 pb-5 font-bold">Ещё</h2>
          <div
            v-if="recomendations.length !== 0"
            class="flex flex-row flex-nowrap"
          >
            <Post-item
              v-for="post of recomendations"
              :key="post.id"
              :post="post"
            />
          </div>

          <p
            class="
              flex
              justify-center
              items-center
              w-full
              p-5
              text-lg text-main-primary-gray-default
              mb-10
            "
            v-else
          >
            Пусто
          </p>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import PostItem from "../../components/blog-components/post-item.vue";

export default {
  data() {
    return {
      post: {},
      category: "",
      recomendations: [],
    };
  },
  components: {
    PostItem,
  },
  methods: {
    async initData() {
      const response = await fetch(
        `${process.env.VUE_APP_ROOT_API}/post/${this.$route.params.post}`,
        {
          method: "GET",
        }
      );
      const more = await fetch(`${process.env.VUE_APP_ROOT_API}/post`, {
        method: "GET",
      });
      this.post = await response.json();
      const posts = await more.json();

      const Filtered = posts.filter(
        (post) =>
          post.category === this.post.category &&
          post.slug != this.$route.params.post
      );
      if (Filtered) {
        this.recomendations = Filtered;
      }
    },
  },
  async created() {
    await this.initData();
  },
};
</script> 
