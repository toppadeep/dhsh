<template>
  <div
    class="
      flex
      justify-start
      items-center
      mx-auto
      min-w-7xl w-full
      flex-col flex-nowrap
      relative
      h-full
    "
  >
    <div
      class="flex flex-col flex-nowrap w-full md:w-1/3"
    >
      <div>
        <div
          class="flex p-5 justify-start w-full items-center"
        >
          <span
            class="mr-5 cursor-pointer"
            v-for="tab in tabs"
            v-bind:key="tab"
            :class="{ active: currentTab === tab }"
            v-on:click="currentTab = tab"
          >
            {{ tab }}
          </span>
        </div>
      </div>
      <keep-alive>
        <component v-bind:is="currentTabComponent"></component>
      </keep-alive>
    </div>
  </div>
</template>

<script>
import Register from "../components/auth-components/register.vue";
import Login from "../components/auth-components/login.vue";

export default {
  data() {
    return {
      currentTab: "Login",
      tabs: ["Login", "Register"],
    };
  },
  components: {
    Login: Login,
    Register: Register,
  },
  computed: {
    currentTabComponent: function () {
      return this.currentTab.toLowerCase();
    },
  },
  head() {
    return {
      title: "Авторизация",
    };
  },
};
</script>

<style scoped>
.active {
  border-bottom: 2px solid #4f91ff;
}
</style>