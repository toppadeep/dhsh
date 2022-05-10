<template>
  <div
    class="
      flex
      justify-start
      items-start
      flex-col flex-nowrap
      mr-5
      relative
      text-xl
      p-2
      rounded-lg
    "
  >
    <router-link
      class="h-max pl-5 pr-5 p-2 border border-gray-200 rounded-md"
      :to="{ name: 'posts-post', params: { post: post.slug } }"
    >
      {{ post.title }}
    </router-link>
  </div>
</template>

<script>
export default {
  data() {
    return {};
  },
  props: {
    post: {
      type: Object,
      default: () => {},
    },
  },
};
</script>
