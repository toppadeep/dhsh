<template>
  <div class="table-row h-14">
    <div class="table-cell">{{ document.title }}</div>
    <div class="table-cell">{{ document.filetype }}</div>
    <div class="table-cell">{{ document.filesize }}</div>
    <div class="table-cell">
      <span class="mr-5">
        <a :href="document.document" class="p-4 dark:hover:text-white" title="Скачать">
          <i class="fa-solid fa-download text-blue-500"></i>
        </a>
      </span>
    </div>
  </div>
</template>

<script>
export default {
  props: {
    document: {
      type: Object,
      default: () => {},
    },
  },
};
</script>