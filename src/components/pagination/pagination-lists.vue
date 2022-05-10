<template>
  <div class="flex flex-row w-full justify-end items-center my-10">
    <div class="flex md:hidden flex-row">
      <button
        class="
          flex
          px-4
          py-2
          border
          hover:border-gray-200
          rounded-none rounded-tl-lg rounded-bl-lg
          cursor-pointer
          hover:text-blue-500
          border-gray-200
        "
        :disabled="page === 0"
        :class="{ 'cursor-not-allowed': page === 0 }"
        @click="EmitPreviosPage"
      >
        назад
      </button>

      <button
        class="
          flex
          px-4
          py-2
          border
          hover:border-gray-200
          rounded-none rounded-tr-lg rounded-br-lg
          cursor-pointer
          hover:text-blue-500
          border-gray-200
        "
        @click="EmitNextPage"
        :disabled="page >= countPage - 1"
        :class="{ 'cursor-not-allowed': page >= countPage - 1 }"
      >
        Вперёд
      </button>
    </div>
    <div class="hidden md:flex flex-row flex-nowrap">
      <button
        class="
          flex
          px-4
          py-3
          border
          hover:border-gray-200
          rounded-none rounded-tl-lg rounded-bl-lg
          cursor-pointer
          hover:text-blue-500
          border-gray-200
          bg-gray-100
        "
        :disabled="page === 0"
        :class="{ 'cursor-not-allowed': page === 0 }"
        @click="EmitPreviosPage"
      >
        <i class="fa-solid fa-chevron-left"></i>
      </button>
      <ul class="flex flex-row m-0">
        <li
          class="
            flex
            px-4
            py-2
            border
            cursor-pointer
            hover:text-blue-500
            border-gray-200
          "
          v-for="(p, index) in this.countPage"
          :key="index"
          @click="EmitCurrentPage(index)"
          :class="{ 'bg-blue-400 text-white': currentPage == index }"
        >
          {{ p }}
        </li>
      </ul>
      <button
        class="
          flex
          px-4
          py-3
          border
          hover:border-gray-200
          rounded-none rounded-tr-lg rounded-br-lg
          cursor-pointer
          hover:text-blue-500
          border-gray-200
          bg-gray-100
        "
        @click="EmitNextPage"
        :disabled="page >= countPage - 1"
        :class="{ 'cursor-not-allowed': page >= countPage - 1 }"
      >
        <i class="fa-solid fa-chevron-right"></i>
      </button>
    </div>
  </div>
</template>

<script>
export default {
  methods: {
    EmitPreviosPage() {
      this.$emit("prev-page");
    },
    EmitNextPage() {
      this.$emit("next-page");
    },
    EmitCurrentPage(index) {
      this.$emit("current-page", index);
    },
  },
  computed: {
    countPage() {
      return Math.ceil(this.data.length / this.pag);
    },
    currentPage() {
      return this.page;
    },
  },
  props: {
    data: {
      type: Array,
      default: () => [],
    },
    page: {
      type: Number,
      default: 0,
    },
    pag: {
      type: Number,
      default: 10,
    },
  },
};
</script>

<style>
</style>