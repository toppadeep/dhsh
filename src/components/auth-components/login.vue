<template>
  <div class="flex p-5 w-full">
    <form
      @submit.prevent="login"
      class="flex flex-col flex-nowrap justify-around items-center w-full"
    >
      <label class="block w-full">
        <span class="block text-sm font-medium text-slate-700">Логин</span>
        <input
          v-model="user.login"
          type="text"
          class="
            mt-1
            block
            w-full
            px-3
            py-2
            bg-white
            border border-slate-300
            rounded-md
            text-sm
            shadow-sm
          "
        />
      </label>
      <label class="block w-full">
        <span class="block text-sm font-medium text-slate-700">Пароль</span>
        <input
          v-model="user.password"
          type="password"
          class="
            mt-1
            block
            w-full
            px-3
            py-2
            bg-white
            border border-slate-300
            rounded-md
            text-sm
            shadow-sm
          "
        />
      </label>
      <input
        @keyup.enter="login"
        type="submit"
        value="Войти"
        :class="{ disabled: !user.login || !user.password }"
        class="hover:bg-main hover:text-white"
        :disabled="!user.login || !user.password"
      />
      <p v-if="error" class="font-bold text-red-900" id="error">
        Логин или пароль неверны
      </p>
    </form>
  </div>
</template>

<script>
export default {
  data() {
    return {
      user: {
        login: null,
        password: null,
      },
    };
  },
  methods: {
    login: function () {
      this.$store.dispatch("LogIn", this.user).then(() => {
        this.$router.push("/");
      });
    },
  },
  computed: {
    error: function () {
      return this.$store.getters.authStatus == "error";
    },
  },
};
</script>


