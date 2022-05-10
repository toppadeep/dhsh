<template>
  <div
    class="
      flex
      justify-start
      items-center
      p-4
      transition-all
      ease-in-out
      duration-1000
      relative
      w-full
    "
  >
    <div
      class="
        w-full
        absolute
        bottom-0
        mt-2
        z-10
        flex flex-row
        justify-center
        items-center
        m-2
        space-x-2
      "
    >
      <span
        v-for="index in group"
        :key="index"
        class="flex w-2 h-2 rounded-full bg-gray-300 cursor-pointer"
        :class="{ 'bg-main': currnetSlideIndex == index - 1 }"
        @click="navigateSlide(index - 1)"
      ></span>
    </div>
    <div
      :class="{ hidden: currnetSlideIndex == group }"
      @click="nextSlide"
      class="
        hidden
        md:flex
        justify-center
        items-center
        hover:bg-gray-300
        dark:hover:bg-dark-900
        opacity-50
        text-black
        dark:text-white dark:hover:text-gray-400
        absolute
        top-0
        right-0
        z-10
        w-12
        h-full
      "
    >
      <i class="fa-solid fa-chevron-right"></i>
    </div>
    <div
      :class="{ hidden: currnetSlideIndex == 0 }"
      @click="prewSlide"
      class="
        hidden
        md:flex
        justify-center
        items-center
        hover:bg-gray-300
        dark:hover:bg-dark-900
        opacity-50
        text-black
        dark:text-white dark:hover:text-gray-400
        absolute
        top-0
        left-0
        z-10
        w-12
        h-full
      "
    >
      <i class="fa-solid fa-chevron-left"></i>
    </div>
    <div
      class="
        flex flex-row flex-nowrap flex-shrink-0
        whitespace-nowrap
        space-x-4
        transition-all
        ease-in-out
        duration-1000
        w-full
        overflow-hidden
        items
        relative
      "
      @mousedown="hundlerStart"
      @mousemove="move"
      @mouseleave="end"
      @mouseup="end"
      @touchstart="hundlerStart"
      @touchmove="move"
      @touchend="end"
    >
      <Cource-item
        v-for="(cource, index) of cources"
        :key="index"
        :cource="cource"
        class="transition-all ease-in-out duration-1000 w-full flex-shrink-0 flex-grow-0 basis-1/3"
      />
      <Post-item v-for="post of posts" :key="post.id" :post="post" />
      <Document
        v-for="document in documents"
        :key="document.id"
        :document="document"
      />
    </div>
  </div>
</template>

<script>
import PostItem from "../blog-components/post-item.vue";
import CourceItem from "../home-components/course-components/cource-item.vue";
import Document from "../documents/document-tab.vue";
export default {
  components: {
    CourceItem,
    PostItem,
    Document,
  },
  data() {
    return {
      currnetSlideIndex: 0,
      isDown: false,
      start: 0,
      scrollLeft: 0,
    };
  },
  props: {
    swipes: {
      type: Number,
      default: () => [],
    },
    cources: {
      type: Array,
      default: () => [],
    },
    posts: {
      type: Array,
      default: () => [],
    },
    documents: {
      type: Array,
      default: () => [],
    },
    loop: {
      type: Number,
      default: 1,
    },
    width: {
      type: Number,
    },
    interval: {
      type: Number,
      default: 10000,
    },
  },
  computed: {
    group() {
      return Math.ceil(this.swipes / this.loop);
    },
  },
  methods: {
    nextSlide() {
      if (this.currnetSlideIndex == this.group - 1) {
        this.currnetSlideIndex = 0;
      } else {
        this.currnetSlideIndex++;
        const slider = document.querySelector(".items");
        slider.scrollLeft = this.width * this.currnetSlideIndex;
      }
    },
    prewSlide() {
      if (this.currnetSlideIndex > 0) {
        this.currnetSlideIndex--;
        const slider = document.querySelector(".items");
        slider.scrollLeft = -(this.width * this.currnetSlideIndex);
      }
    },
    navigateSlide(slide) {
      this.currnetSlideIndex = slide;
      const slider = document.querySelector(".items");
      slider.scrollLeft = this.width * this.currnetSlideIndex;
    },
    end() {
      this.isDown = false;
    },
    hundlerStart(e) {
      const slider = document.querySelector(".items");
      this.isDown = true;
      this.start = e.pageX || e.touches[0].pageX - slider.offsetLeft;
      this.scrollLeft = slider.scrollLeft;
    },
    move(e) {
      if (!this.isDown) return;
      e.preventDefault();
      const slider = document.querySelector(".items");
      const x = e.pageX || e.touches[0].pageX - slider.offsetLeft;
      const dist = x - this.start;
      slider.scrollLeft = this.scrollLeft - dist;
    },
  },
  // mounted() {
  //   if (this.group > 1) {
  //     let is = this;
  //     setInterval(function name() {
  //       is.nextSlide();
  //     }, is.interval);
  //   }
  // },
};
</script>

<style scoped>
.slider-item {
  flex: 0 0 33%;
}

.next-slide::before {
  content: url("../../assets/icons/arrow-right.png");
  margin-top: 0.5em;
}

.prev-slide::before {
  content: url("../../assets/icons/arrow-left.png");
  margin-top: 0.5em;
}

.f-child:first-child {
  margin-left: 0;
}
</style>
