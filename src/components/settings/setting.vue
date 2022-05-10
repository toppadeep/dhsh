<template>
  <div class="flex justify-end items-center space-x-2">
    <span class="text-black dark:text-white"
      ><i class="fa-solid fa-sun"></i
    ></span>
    <div class="">
      <input
        @change="toggleTheme"
        type="checkbox"
        name=""
        id="toggle"
        class="hidden w-max h-max"
        v-model="checked"
      />
      <label for="toggle">
        <div class="w-9 h-5 flex items-center bg-gray-300 rounded-full p-1">
          <div
            class="
              toggle-switch
              transform
              w-4
              h-4
              bg-white
              dark:bg-dark-900
              rounded-full
              shadow-md
              duration-300
              ease-in-out
            "
          ></div>
        </div>
      </label>
    </div>
    <span class="text-black dark:text-white"
      ><i class="fa-solid fa-moon"></i
    ></span>
  </div>
</template>

<script>
export default {
  data() {
    return {
      checked: localStorage.getItem("theme") === "dark" ? true : false,
    };
  },
  methods: {
    toggleTheme() {
      var element = document.querySelector("html");
      if (this.checked) {
        localStorage.setItem("theme", "dark");
        element.classList.add("dark");
      } else if (!this.checked) {
        localStorage.setItem("theme", "light");
        element.classList.remove("dark");
      }
    },
  },
  mounted() {
    var element = document.querySelector("html");
    if (this.checked) {
      element.classList.add("dark");
    } else if (!this.checked) {
      element.classList.remove("dark");
    }
  },
};
</script>
