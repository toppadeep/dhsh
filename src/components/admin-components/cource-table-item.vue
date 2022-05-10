<template>
  <div class="table-row h-14">
    <div class="table-cell font-bold p-2">{{ index + 1 }}</div>
    <div class="table-cell">
      <router-link
        :to="{ name: 'courses-cource', params: { cource: cource.slug } }"
      >
        {{ cource.title }} </router-link
      >
    </div>
    <div class="table-cell line-clamp-2 w-60 pt-1"> {{cource.body}} </div>
    <div class="table-cell">{{ cource.payment }}</div>
    <div class="table-cell">
      <span
        @click="
          update(
            cource.id,
            cource.title,
            cource.body,
            cource.сover,
            cource.images,
            cource.documents,
            cource.payment
          )
        "
        class="mr-5"
      >
        <i class="far fa-edit text-yellow-600"></i>
      </span>
      <span @click="remove(index, cource.id, cource.title)" class="mr-5">
        <i class="far fa-trash-alt text-red-600"></i>
      </span>
    </div>
  </div>
</template>

<script>
export default {
  methods: {
    update(id, title, body, cover, images, documents, payment) {
      this.$emit("update", id, title, body, cover, images, documents, payment);
    },
    remove(id, name, index) {
      this.$emit("remove", id, name, index);
    },
  },
  props: {
    index: {
      type: Number,
    },
    cource: {
      type: Object,
      default: () => {},
    },
  },
};
</script>