<template>
  <transition name="slide-fade">
    <div
      v-if="response.status == true || response.status == false"
      class="
        flex
        justify-between
        items-start
        flex-col
        w-full
        mt-10
        rounded-md
        text-md
        font-bold border
  
          border-gray-200
      "
    >
      <div
        :style="{ background: response.color }"
        class="
          flex
          pl-5
          pr-5
          pt-2
          pb-2
          text-white
          flex-row
          w-full
          flex-nowrap
          justify-between
          items-center
          rounded-tr-md rounded-tl-md
        "
      >
        <h2 class="">Ошибки создания:</h2>
        <span
          @click="hideNotification"
          class="flex justify-center items-center p-2 h-10 w-10 rounded-sm"
          ><i class="fas fa-times"></i
        ></span>
      </div>
      <div class="flex w-full p-5">
        <ol class="flex flex-col w-full flex-nowrap">
          <li v-for="(error, index) in response.errors" :key="index">
            <span
              v-for="(err, i) in error"
              :key="i"
              class="flex flex-col flex-nowrap font-bold"
            >
              {{ err }}
            </span>
          </li>
        </ol>
      </div>
    </div>
  </transition>
</template>

<script>
export default {
  methods: {
    hideNotification() {
      this.response.status = null;
    },
  },
  props: {
    response: {
      type: Object,
      default: () => {},
    },
  },
};
</script>