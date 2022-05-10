<template>
  <div class="flex w-full flex-col">
    <h3 class="mb-10 mt-10 font-bold text-xl">Галерея</h3>
    <div class="flex w-full justify-center items-center flex-row flex-wrap">
      <img
        v-for="(image, index) of images"
        class="w-full md:w-1/3 h-max m-2 hover:cursor-pointer hover:scale-105"
        :key="index"
        :src="image.path"
        alt=""
        @click="openFrame(index)"
      />
    </div>
    <transition
      name="fade"
      enter-active-class="animate__animated animate__fadeInBottomRight"
      leave-to-class="animate__animated animate__fadeOutBottomRight"
    >
      <div
        v-if="show"
        class="
          flex
          justify-center
          items-center
          flex-row flex-nowrap
          w-full
          h-screen
          fixed
          top-0
          left-0
          z-50
          bg-black/40
          backdrop-blur-lg
        "
      >
        <span
          class="
            absolute
            top-10
            right-10
            flex
            justify-center
            items-center
            space-x-4
          "
        >
          <i
            v-if="play == false"
            @click="auto = true"
            class="
              fa-solid fa-play
              text-2xl text-gray-300
              hover:text-white
              cursor-pointer
            "
            title="Играть"
          ></i>
          <i
            v-if="play == true"
            @click="auto = false"
            class="
              fa-solid fa-pause
              text-3xl text-gray-300
              hover:text-white
              cursor-pointer
            "
            title="Стоп"
          ></i>
          <i
            @click="show = false"
            class="
              fa-solid fa-xmark
              text-4xl text-gray-300
              hover:text-white
              cursor-pointer
            "
            title="Закрыть"
          ></i
        ></span>
        <button
          class="
            flex
            justify-center
            items-center
            rounded-full
            w-10
            h-10
            mb-5
            absolute
            top-1/2
            left-0
            z-50
          "
          title="Prew"
          @click="prewSlide"
        >
          <i class="fa-solid fa-arrow-left-long"></i>
        </button>
        <button
          class="
            flex
            justify-center
            items-center
            rounded-full
            w-10
            h-10
            m-5
            absolute
            top-1/2
            right-0
            z-50
          "
          title="Next"
          @click="nextSlide"
        >
          <i class="fa-solid fa-arrow-right-long"></i>
        </button>
        <div
          v-for="(image, index) in this.images"
          :key="index"
          class="w-full md:w-10/12 h-64 md:h-5/6 justify-center items-center"
          :class="{
            flex: index == currentImage,
            hidden: index != currentImage,
          }"
        >
          <transition
            name="fade"
            enter-active-class="animate__animated animate__backInRight"
          >
            <img
              v-if="index == currentImage"
              class="w-max h-full"
              :src="image.path"
              :aria-hidden="[index != currentImage]"
              alt=""
            />
          </transition>
        </div>
        <div class="hidden md:flex flex-col flex-nowrap w-32 h-5/6 relative">
          <div
            class="
              overflow-hidden
              items
              transition-all
              ease-in-out
              duration-1000
            "
            @mousedown="hundlerStart"
            @mousemove="move"
            @mouseleave="end"
            @mouseup="end"
            @touchstart="hundlerStart"
            @touchmove="move"
            @touchend="end"
          >
            <img
              v-for="(image, index) of images"
              class="w-32 h-max mb-4 hover:cursor-pointer hover:scale-105"
              :class="{'border-l-2 border-blue-500' : index == currentImage}"
              :key="index"
              :src="image.path"
              alt=""
              @click="navigateSlide(index)"
            />
          </div>
        </div>
      </div>
    </transition>
  </div>
</template>

<script>
export default {
  data() {
    return {
      show: false,
      currentImage: 0,
      isDown: false,
      start: 0,
      scrollHeight: 0,
      interval: 2000,
      auto: false,
      intervalId: null,
    };
  },
  props: {
    images: {
      type: Array,
      default: () => [],
    },
  },
  methods: {
    nextSlide() {
      if (this.currentImage == this.images.length - 1) {
        this.currentImage = 0;
      } else {
        this.currentImage++;
      }
    },
    prewSlide() {
      if (this.currentImage == 0) {
        this.currentImage = this.images.length - 1;
      } else {
        this.currentImage--;
      }
    },
    navigateSlide(slide) {
      this.currentImage = slide;
      const slider = document.querySelector(".items");
      slider.scrollTop = 40 * this.currentImage;
    },
    openFrame(image) {
      this.show = !this.show;
      this.currentImage = image;
    },
    end() {
      this.isDown = false;
    },
    hundlerStart(e) {
      const slider = document.querySelector(".items");
      this.isDown = true;
      this.start = e.pageY || e.touches[0].pageY - slider.offsetHeight;
      this.scrollHeight = slider.scrollTop;
    },
    move(e) {
      if (!this.isDown) return;
      e.preventDefault();
      const slider = document.querySelector(".items");
      const y = e.pageY || e.touches[0].pageY - slider.offsetHeight;
      const dist = y - this.start;
      slider.scrollTop = this.scrollHeight - dist;
    },
    statePlay() {
      if (this.auto == true) {
        let is = this;
        this.intervalId = setInterval(function name() {
          is.nextSlide();
        }, is.interval);
      } else {
        clearInterval(this.intervalId);
      }
    },
    cancel() {
      clearInterval(this.intervalId);
    },
  },
  computed: {
    play() {
      this.statePlay();
      return this.auto;
    },
  },
};
</script>
