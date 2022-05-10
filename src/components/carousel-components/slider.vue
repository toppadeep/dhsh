<template>
  <div
    class="
      flex
      justify-center
      items-center
      flex-col flex-nowrap
      w-full
      h-full
      relative
    "
  >
    <div
      v-for="(slide, index) in this.slides"
      :key="index"
      class="w-full justify-center items-center h-full"
      :class="{ flex: index == currentSlide, hidden: index != currentSlide }"
    >
      <transition
        name="fade"
        enter-active-class="animate__animated animate__flipInY"
      >
        <div v-if="index == currentSlide" class="flex w-full h-full">
          <img
            class="w-full h-full"
            :src="require(`@/assets/offerImages/${slide.url}`)"
            :aria-hidden="[index != currentSlide]"
            alt=""
          />
        </div>
      </transition>
    </div>
    <div
      v-if="controls"
      class="
         hidden md:flex flex-col flex-nowrap
        justify-between
        items-center
        absolute
        left-5
        bottom-16 z-30  transition-all
        ease-in-out
        duration-1000 
      "
    >
      <button
        class="flex justify-center items-center rounded-full w-10 h-10 mb-5"
        :class="{ disabled: currentSlide == 0 }"
        @click="prewSlide"
      >
        <i class="fa-solid fa-chevron-up"></i>
      </button>
      <span
        v-for="(indicate, index) of swipes"
        :key="index"
        style="width: 1px"
        class="flex h-10 rounded-full bg-gray-100 cursor-pointer"
        :class="{ 'bg-main w-1 animate-pulse': currentSlide == index }"
        @click="navigateSlide(index)"
      ></span>
      <button
        class="flex justify-center items-center rounded-full w-10 h-10 m-5"
        :class="{ disabled: currentSlide == swipes }"
        @click="nextSlide"
      >
        <i class="fa-solid fa-chevron-down"></i>
      </button>
    </div>
  </div>
</template>

<script>
export default {
  data() {
    return {
      currentSlide: 0,
      interval: 10000,
    };
  },
  methods: {
    nextSlide() {
      if (this.currentSlide == this.swipes - 1) {
        this.currentSlide = 0;
      } else {
        this.currentSlide++;
      }
    },
    prewSlide() {
      if (this.currentSlide > 0) {
        this.currentSlide--;
      }
    },
    navigateSlide(slide) {
      this.currentSlide = slide;
    },
  },
  mounted() {
    if (this.auto) {
      let is = this;
      setInterval(function name() {
        is.nextSlide();
      }, is.interval);
    }
  },
  computed: {
    swipes() {
      if (this.slides.length !== 0) {
        return this.slides.length;
      }
      return 0;
    },
  },
  props: {
    slides: {
      type: Array,
      default: () => [],
    },
    auto: {
      type: Boolean,
      default: false,
    },
    controls: {
      type: Boolean,
      default: false,
    },
    loop: {
        type: Number,
        default: 1
    }
  },
};
</script>

<style scoped>
.slide-fade-enter-active {
  @apply animate-pulse;
}
.slide-fade-leave-active {
  transition: all 0.8s cubic-bezier(1, 0.5, 0.8, 1);
}
.slide-fade-enter,
.slide-fade-leave-to {
  opacity: 0;
}
</style>