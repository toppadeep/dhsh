<template>
  <div
    class="
      flex
      justify-start
      items-start
      w-full
      h-max
      flex-col flex-nowrap
      p-10
      rounded-lg
      relative
      border border-gray-200
    "
  >
    <div class="flex flex-row flex-nowrap mb-5">
      <img
        class="
          lg:hidden
          md:hidden
          sm:hidden
          2xl:flex
          bg-cover w-24
          h-32
          rounded-lg
          scale
        "
        :src="teacher.avatar"
        alt=""
      />
      <div
        class="
          flex
          justify-start
          flex-col flex-nowrap
          items-start
          w-max
          h-32
          p-5
        "
      >
        <h2 class="font-bold">
          {{ teacher.role }}
        </h2>
        <router-link
          class="text-2xl"
          :to="{ name: 'teachers-teacher', params: { teacher: teacher.slug } }"
        >
          {{ teacher.name }}
        </router-link>
      </div>
    </div>
    <div class="flex w-full h-max overflow-hidden relative backdrop-blur-md">
      <div
        @click="nextSlide"
        class="
          flex
          justify-center
          items-center
          bg-white/50
          hover:bg-white
          absolute
          top-0
          right-0
          z-10
          rounded-full
          w-12
          h-12
        "
      >
        <i class="fa-solid fa-chevron-right"></i>
      </div>
      <div
        @click="prewSlide"
        class="
          flex
          justify-center
          items-center
          bg-white/50
          hover:bg-white
          absolute
          top-0
          left-0
          z-10
          rounded-full
          w-12
          h-12
        "
      >
        <i class="fa-solid fa-chevron-left"></i>
      </div>
      <div
        class="flex w-full h-12 transition-all ease-in-out duration-1000"
        :style="{ 'margin-left': '-' + 30 * currnetSlideIndex + '%' }"
      >
        <div
          v-for="cource in teacher.courses"
          :key="cource.id"
          class="
            flex flex-row flex-nowrap
            justify-center
            items-center
            rounded-full
            pr-5
            pl-5
            border
            w-max
            mr-2
            bg-white
            text-sm
          "
        >
          {{ cource.title }}
        </div>
      </div>
    </div>

    <div class="flex w-full flex-col">
      <button
        @click="teacherMore = !teacherMore"
        class="
          flex
          justify-between
          items-center
          w-full
          mt-5
          bg-white
          border border-blue-500
          rounded-full
        "
      >
        Общие сведения <i class="fa-solid fa-angle-down"></i>
      </button>
      <div
        v-if="teacherMore"
        class="
          flex
          w-full
          h-max
          flex-col flex-nowrap
          p-5
          bg-white
          border border-gray-200
          rounded-lg
          mt-2
        "
      >
        <div><span>Образование:</span> {{ teacher.education }}</div>
        <div><span>Роль:</span> {{ teacher.role }}</div>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  data() {
    return {
      teacherMore: false,
      currnetSlideIndex: 0,
    };
  },
  props: {
    teacher: {
      type: Object,
      default: () => {},
    },
  },
  methods: {
    nextSlide() {
      if (this.currnetSlideIndex == this.teacher.courses.length - 1) {
        this.currnetSlideIndex = 0;
      } else {
        this.currnetSlideIndex++;
      }
    },
    prewSlide() {
      if (this.currnetSlideIndex > 0) {
        this.currnetSlideIndex--;
      }
    },
  },
};
</script>

