<template>
  <transition name="slide-fade">
    <div
      class="
        flex
        justify-center
        items-center
        flex-row flex-wrap
        mt-5
        ml-2
        w-72
        relative
        h-max
        rounded-lg
        bg-white
        p-2
        border border-gray-200
      "
    >
      <img class="w-64 h-40" :src="post.cover" alt="" />
      <div
        class="
          flex flex-col flex-nowrap
          w-full
          h-full
          justify-between
          pl-5
          pr-5
        "
      >
        <div class="flex flex-col flex-nowrap justify-start h-full mt-2">
          <h2 class="line-clamp-2">
            <router-link
              :title="post.title"
              :to="{ name: 'posts-post', params: { post: post.slug } }"
              >{{ post.title }}</router-link
            >
          </h2>
          <h3 class="line-clamp-2 mt-2">{{ post.subtitle }}</h3>
          <div
            class="
              flex flex-row
              justify-between
              items-center
              mt-5
              text-gray-400
            "
          >
            <span class="flex flex-row flex-nowrap">
              <img
                :src="post.userAvatar"
                class="w-5 h-5 rounded-full mr-2"
                :title="post.userLogin"
                :alt="post.userLogin"
              />
              <h4 class="font-bold">{{ post.userLogin }}</h4>
            </span>
            <h4>
              <i class="fa-solid fa-calendar-days mr-2"></i>{{ post.date }}
            </h4>
          </div>
        </div>
      </div>
    </div>
  </transition>
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


<style >
.skeleton {
  display: inline-block;
  position: relative;
  overflow: hidden;
  background-color: #dddbdd;
}

.skeleton {
  background: #eee;
  background: linear-gradient(110deg, #ececec 8%, #f5f5f5 18%, #ececec 33%);
  border-radius: 5px;
  background-size: 200% 100%;
  animation: 1.5s shine linear infinite;
}

@keyframes shine {
  to {
    background-position-x: -200%;
  }
}
</style>