<template>
  <div class="flex justify-start items-center flex-row flex-nowrap p-5">
    <div
      @click="show = !show"
      class="
        flex
        w-full
        justify-start
        flex-row flex-nowrap
        items-center
        new
        relative
      "
    >
      <div class="flex flex-row flex-nowrap h-9">
        <span class="text-main-second-black font-bold w-full after">
          {{ $auth.user.login }}</span
        >
      </div>
    </div>
    <transition name="fade">
      <div
        v-if="show"
        class="
          flex flex-col flex-nowrap
          p-5
          m-2
          rounded-md
          absolute
          top-20
          right-14
          backdrop-blur-xl
        "
      >
        <div
          v-if="$auth.loggedIn"
          class="flex p-2 flex-col flex-nowrap justify-start items-start"
        >
          <img :src="$auth.user.avatar" class="w-11 h-11 rounded-full" alt="" />
          <span
            class="
              font-bold
              p-2
              pl-0
              m-0
              border-b border-main-primary-gray-default
            "
            >{{ $auth.user.login }}
          </span>
          <span class="mt-2 cursor-pointer" @click="logout()"> Выйти </span>
        </div>
        <div v-else class="flex justify-between p-2 flex-row flex-nowrap">
          <router-link to="/auntificate">Войти</router-link>
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
    };
  },
  methods: {
    async logout() {
      await this.$auth.logout();
      this.$router.push({ path: "/" });
    },
  },
};
</script>

<style scoped>
.after::after {
  content: url(~static/icons/after.svg);
  margin-left: 1em;
}
</style>