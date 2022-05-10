<template>
  <div
    v-if="show"
    class="
      flex flex-col flex-nowrap
      justify-center
      w-full
      h-full
      items-center
      z-20
      fixed
      top-0
      left-0
      backdrop-brightness-50
    "
  >
    <div
      class="
        flex flex-col
        rounded-lg
        shadow-xl
        w
        h-max
        bg-white
        dark:bg-dark-800
      "
    >
      <div
        class="
          flex flex-row
          justify-between
          items-center
          bg-dark-800
          rounded-tl-md rounded-tr-md
          px-5
          py-2
          border-b
          w-full
        "
      >
        <h2 class="text-white font-normal">Подтверждение удаления</h2>
        <i
          class="fa-solid fa-xmark cursor-pointer ml-4 text-xl text-white"
          @click="show = false"
        ></i>
      </div>

      <div
        class="
          flex flex-col flex-nowrap
          justify-center
          items-start
          p-5
          border-b border-gray-200
        "
      >
        <span :title="data.title" class="font-bold text-xl line-clamp-1">{{
          data.title
        }}</span>
        <p class="text-default mt-4">
          <span class="text-red-400">Внимание:</span> данное действие невозможно
          будет отменить
        </p>
      </div>
      <div class="flex flex-row justify-end p-2">
        <button @click="$emit('toggle')">Отмена</button>
        <button
          @click="$emit('remove', data.id, data.index)"
          class="
            w-24
            ml-2
            mb-0
            ring-0
            pl-2
            pr-2
            text-white
            bg-red-500
            border
            hover:text-white
          "
        >
          удалить
        </button>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  props: {
    show: {
      type: Boolean,
      default: false,
    },
    data: {
      type: Object,
      default: () => {},
    },
  },
};
</script>


<style scoped>
.w {
  width: 464px;
}
</style>