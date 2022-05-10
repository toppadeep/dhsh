<template>
  <div
    class="
      flex
      justify-between
      items-start
      flex-col
      w-full md:w-56
      h-36
      bg-gray-200 dark:bg-dark-800
      p-5
      rounded-lg
      mr-5 space-y-4 cursor-pointer
    "
  >
   <div class="flex flex-row flex-nowrap space-x-4">
      <i
      v-if="document.filetype === 'docx' || document.filetype === 'doc'"
      class="fa-solid fa-file-word text-5xl text-blue-500"
    ></i>
    <i
      v-if="document.filetype === 'pdf'"
      class="fa-solid fa-file-pdf text-5xl text-red-500"
    ></i>
    <i
      v-if="document.filetype === 'xlsx'"
      class="fa-solid fa-file-excel text-5xl text-green-500"
    ></i>
    <span class="w-full break-words line-clamp-2" :title="document.title">{{ document.title }}</span>
   </div>
    <div class="flex w-full flex-row flex-nowrap space-x-4">
      <span class="w-full" :title="document.filesize"><h3>{{ document.filesize }}</h3></span>
    <button><a :href="document.document">Скачать</a></button>
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