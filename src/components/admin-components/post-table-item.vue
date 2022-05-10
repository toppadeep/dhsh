<template>
  <div class="table-row h-14">
    <div class="table-cell font-bold p-2">{{ post.id }}</div>
    <div class="table-cell">
      <router-link :to="{ name: 'posts-post', params: { post: post.slug } }">
        {{ post.title }}
      </router-link>
    </div>
    <div class="table-cell">{{ post.date }}</div>
    <div class="table-cell">{{ post.category }}</div>
    <div class="table-cell">{{ post.userLogin }}</div>
    <div class="table-cell">
      <span
        @click="
          update(
            post.id,
            post.title,
            post.subtitle,
            post.body,
            post.cover,
            post.images,
            post.documents,
            post.category_id
          )
        "
        class="mr-5"
      >
        <i class="far fa-edit text-yellow-600"></i>
      </span>
      <span @click="remove(post.id, post.title, index)" class="mr-5">
        <i class="far fa-trash-alt text-red-600"></i>
      </span>
    </div>
  </div>
</template>

<script>
export default {
  methods: {
    update(id, title, subtitle, body, cover, documents, files, category) {
      this.$emit("update", id, title, subtitle, body, cover, documents, files, category);
    },
    remove(id, title, index) {
      this.$emit("remove", id, title, index);
    },
  },
  props: {
    index: {
      type: Number,
    },
    post: {
      type: Object,
      default: () => {},
    },
  },
};
</script>