<template>
  <div class="table-row h-14">
    <div class="table-cell font-bold p-2">{{ document.id }}</div>
    <div class="table-cell">{{ document.title }}</div>
    <div class="table-cell">{{ document.filetype }}</div>
    <div class="table-cell">{{ document.filesize }}</div>
    <div class="table-cell">
      <span @click="remove(document.id, document.title, index)" class="mr-5" title="Удалить">
        <i class="far fa-trash-alt text-red-600"></i>
      </span>
      <span class="mr-5">
        <a :href="document.document" title="Скачать">
          <i class="fa-solid fa-download text-blue-500"></i>
        </a>
      </span>
    </div>
  </div>
</template>

<script>
export default {
  methods: {
    remove(id, title, index) {
      this.$emit("remove", id, title, index);
    },
  },
  props: {
    index: {
      type: Number,
    },
    document: {
      type: Object,
      default: () => {},
    },
  },
};
</script>