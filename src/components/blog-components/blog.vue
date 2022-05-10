<template>
  <div
    id="news"
    class="
      flex
      justify-start
      items-center
      flex-row flex-wrap
      max-w-7xl
      w-full
      mb-10
      box-border
      relative
    "
  >
    <description
      v-for="data in dataDecription"
      :key="data.title"
      :dataDecription="data"
    />
    <div
      class="
        flex
        justify-center
        items-center
        flex-col flex-nowrap
        max-w-7xl
        w-full
      "
    >
      <div class="flex w-full flex-col lg:flex-row justify-between items-start">
        <div class="flex w-full lg:w-1/2 flex-col flex-nowrap">
          <blog-item
            v-for="post in postsReverse.slice(0, range)"
            :key="post.id"
            :post="post"
          />
        </div>
        <div
          class="
            flex flex-col flex-wrap
            justify-start
            items-start
            w-full lg:w-1/2
            h-max
            lg:px-5
          "
        >
          <h2 class="m-5">Узнавайте больше о нас</h2>
          <div class="flex w-full flex-row flex-wrap">
            <router-link
              v-for="category in categories"
              :key="category.id"
              :to="{ name: 'categories-category', params: { category: category.slug } }"
              class="h-10 pl-5 pr-5 p-2 border m-2 border-gray-200 rounded-md"
            >
              <i class="fa-solid fa-tag mr-2"></i>{{ category.name }}
            </router-link>
          </div>
        </div>
      </div>
      <div class="flex flex-row justify-center items-center">
        <button
          class="flex justify-between items-center flex-row flex-nowrap mr-5"
          v-if="this.posts.slice(0, range).length < this.posts.length"
          @click="range = range + 3"
        >
          <i class="fa-solid fa-caret-down mr-2"></i>
          Показать ещё
        </button>
      </div>
    </div>
  </div>
</template>

<script>
import description from "../home-components/decription.vue";
import blogItem from "../blog-components/blog-item.vue";
export default {
  components: {
    description,
    blogItem,
  },
  data() {
    return {
      dataDecription: [
        {
          title: "Блог",
          desc: "Всегда свежие новости",
        },
      ],
      posts: [],
      categories: [],
      range: 9,
    };
  },
  async created() {
    const posts = await fetch(`${process.env.VUE_APP_ROOT_API}/post`, {
      method: "GET",
    });
    const categories = await fetch(`${process.env.VUE_APP_ROOT_API}/category`, {
      method: "GET",
    });
    this.posts = await posts.json();
    this.categories = await categories.json();
  },
  computed: {
    postsReverse: function () {
      return this.posts.slice().reverse();
    },
  },
};
</script>


