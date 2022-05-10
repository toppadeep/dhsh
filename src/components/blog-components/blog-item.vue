<template>
  <div
    class="
      flex
      justify-between
      items-start
      w-full
      h-max
      flex-row flex-nowrap
      p-5
      bg-gray-100
      dark:bg-dark-900
      rounded-lg
      mb-5
    "
  >
    <div
      class="
        flex
        justify-center
        items-center
        flex-row flex-wrap
        md:flex-nowrap
        w-full
        h-full
        text-xl
        cursor-pointer
        relative
      "
    >
      <span
        v-if="isLoggedIn"
        class="
          absolute
          top-0
          right-0
          py-2
          rounded-lg
          px-4
          bg-gray-200/50
          dark:bg-dark-800/50 dark:hover:bg-white
          hover:bg-white
          group
          z-20
        "
        @click="favorite(post.id)"
        ><i
          class="fa-solid fa-bookmark group-hover:text-blue-500"
          :class="{ 'text-yellow-400': post.isBookmark }"
        ></i
      ></span>
      <div class="flex justify-center items-start w-full flex-col flex-nowrap">
        <div class="flex w-full flex-row justify-start items-center">
          <img
            :src="post.userAvatar"
            class="w-5 h-5 rounded-full"
            :title="post.userLogin"
            :alt="post.userLogin"
          />
          <h4 class="ml-2">{{ post.userLogin }}</h4>
        </div>
        <router-link
          class="line-clamp-2 font-bold text-xl mt-2"
          :title="post.title"
          :to="{ name: 'posts-post', params: { post: post.slug } }"
          >{{ post.title }}</router-link
        >
        <h3 class="line-clamp-2 mt-2">{{ post.subtitle }}</h3>
        <div class="flex flex-row mt-2 w-full justify-start items-center">
          <h4 class="mr-5">
            <i class="fa-solid fa-calendar-days"></i> {{ post.date }}
          </h4>
          <router-link to="/">
            <i class="fa-solid fa-tag"></i>
            {{ post.category }}
          </router-link>
        </div>
      </div>
      <div
        class="w-full h-32"
        :style="{
          'background-image': 'url(' + post.cover + ')',
          'background-size': 'cover',
          'background-repeat': 'no-repeat',
        }"
      ></div>
    </div>
  </div>
</template>

<script>
export default {
  components: {},
  methods: {
    async favorite(postId) {
      this.fav = !this.fav;
      const userId = this.userId;
      this.$store.dispatch("favoritePosts", { userId, postId });
    },
  },
  computed: {
    userId() {
      return this.$store.state.auth.user.id;
    },
    isLoggedIn: function () {
      return this.$store.getters.isLoggedIn;
    },
  },
  props: {
    post: {
      type: Object,
      default: () => {},
    },
  },
};
</script>


