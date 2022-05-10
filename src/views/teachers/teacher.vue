<template>
  <div
    class="
      flex
      justify-center
      items-center
      mx-auto
      max-w-7xl max-h-full
      flex-col flex-nowrap
      bg-white
      dark:bg-dark-800
      text-black
      dark:text-white
    "
  >
    <div
      class="
        flex
        justify-between
        items-start
        w-full
        p-2
        flex-row flex-nowrap
        mt-5
      "
    >
      <div
        class="
          flex
          w-52
          rounded-lg
          mr-10
          flex-col flex-nowrap
          sticky
          top-20
          bg-white
          dark:bg-dark-900
        "
      >
        <div class="flex w-full flex-col flex-nowrap p-5">
          <img
            class="rounded-full w-14 h-14 mb-5"
            :src="teacher.avatar"
            alt=""
          />
          <span class="text-main-primary-gray-default">
            {{ teacher.name }}
          </span>
        </div>

        <div
          class="
            flex
            w-full
            flex-row flex-wrap
            p-5
            rounded-md
            bg-gray-100
            dark:bg-dark-800
          "
        >
          <h4 class="text-md font-bold pb-2 border-b-2">
            Прикрепленные документы
            <i class="fa-solid fa-download text-blue-500 ml-2"></i>
          </h4>
          <div class="flex w-full mt-2 flex-col flex-wrap">
            <div
              class="flex w-full text-sm line-clamp-1"
              v-for="(document, index) in teacher.documents"
              :key="index"
            >
              <a class="w-min" :href="document.path" :title="document.name">{{
                document.name
              }}</a>
            </div>
          </div>
        </div>
      </div>
      <div class="flex flex-col flex-nowrap w p-10 rounded-lg">
        <div
          class="flex flex-row flex-wrap justify-between items-center p-2 mb-10"
        >
          <div
            class="flex w-full h-max overflow-hidden relative backdrop-blur-md"
          >
            <div
              @click="nextSlide"
              class="
                flex
                justify-center
                items-center
                bg-gray-200
                dark:bg-dark-800
                hover:bg-white
                dark:hover:bg-dark-900
                absolute
                top-0
                right-0
                z-30
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
                bg-gray-200
                dark:bg-dark-800
                hover:bg-white
                dark:hover:bg-dark-900
                absolute
                top-0
                left-0
                z-30
                rounded-full
                w-12
                h-12
              "
            >
              <i class="fa-solid fa-chevron-left"></i>
            </div>
            <div
              class="flex w-full h-12 transition-all ease-in-out duration-1000"
              :style="{ transform: `translateX(-${90 * currnetSlideIndex}px)` }"
            >
              <div
                v-for="cource in teacher.courses"
                :key="cource.id"
                class="
                  flex flex-row flex-nowrap
                  justify-center
                  items-center
                  rounded-full
                  px-4
                  border
                  w-max
                  mr-2
                  dark:bg-dark-900
                  text-sm
                  first:ml-10
                "
              >
                {{ cource.title }}
              </div>
            </div>
          </div>
        </div>
        <h1 class="font-bold text-4xl text-main-second-black mb-5">
          {{ teacher.name }}
        </h1>
        <div v-html="teacher.description" class="text-2xl"></div>
        <img
          v-for="(file, index) in teacher.images"
          :key="index"
          class="rounded-lg w-full h-full"
          :src="file.path"
          alt=""
        />
      </div>
    </div>
  </div>
</template>

<script>
export default {
  head() {
    return {
      title: this.post.title,
    };
  },
  data() {
    return {
      currnetSlideIndex: 0,
      teachers: null,
      teacher: null,
    };
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
    async initData() {
      const response = await fetch(`${process.env.VUE_APP_ROOT_API}/teacher`, {
        method: "GET",
      });
      this.teachers = await response.json();
      const filteredPost = this.teachers.find(
        (el) => el.slug === this.$route.params.teacher
      );
      if (filteredPost) {
        this.teacher = filteredPost;
      } else {
        this.$route.push("/");
      }
    },
  },
  async created() {
    this.initData();
  },
};
</script> 
