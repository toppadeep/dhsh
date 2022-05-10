<template>
  <div
    class="
      flex flex-row flex-nowrap
      w-full
      h-max
      md:w-1/2
      lg:w-96
      rounded-lg
      h-48
      border border-gray-200
      mb-5 m-2
    "
  >
    <div  class="flex w-full justify-center flex-col flex-nowrap dark:bg-dark-900 rounded-lg">
      <div class="flex justify-start items-start flex-row flex-nowrap px-5  pb-2">
        <span class="font-bold text-2xl text-default mr-2">
          0{{ offer.id }}</span
        >
        <h1>{{ offer.title }}</h1>
      </div>
      <h3 :class="{ 'line-clamp-2': !more }" class="mt-2 pl-5 pr-5">{{ offer.description }}</h3>
    </div>
  </div>
</template>

<script>
export default {
  data() {
    return {
      more: false
    }
  },
  props: {
    offer: {
      type: Object,
      default: () => {},
    },
  },
};
</script>

