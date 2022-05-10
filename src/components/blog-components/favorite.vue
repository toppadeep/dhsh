<template>
  <div class="flex justify-start items-center w-max flex-row relative pb-2 m-2">
    <router-link
      :title="fav.title"
      :to="{ name: 'posts-post', params: { post: fav.slug } }"
      class="h-max pl-5 pr-5 p-2 border border-gray-200 rounded-md"
    >
      {{ fav.title }}
    </router-link>
    <div
      @click="show = !show"
      class="
        flex
        justify-center
        items-center
        py-2
        px-4
        bg-gray-100
        dark:bg-dark-900
        ml-2
        rounded-lg
        cursor-pointer
        hover:scale-110
      "
    >
      <i class="fa-solid fa-ellipsis-vertical"></i>
    </div>
    <div
      v-if="show"
      @click="favorite(fav.id)"
      class="
        flex
        cursor-pointer
        w-max
        py-2
        px-4
        rounded-lg
        absolute
        top-full
        right-0
        bg-red-600
        text-white
        hover:scale-110 z-20
      "
    >
      <p class="text-sm">Удалить</p>
    </div>
  </div>
</template>

<script>
export default {
  data() {
    return {
      show: false,
    };
  },
  methods: {
    async favorite(postId)  {
      const userId = this.userId;
      this.$store.dispatch("favoritePosts", {userId, postId});
    },
  },
  computed: {
    userId() {
      return this.$store.state.auth.user.id;
    },
  },
  props: {
    fav: {
      type: Object,
      default: () => {},
    },
  },
};
</script>

<style>
</style>