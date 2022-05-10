<template>
  <div class="flex w-full p-5 flex-col flex-nowrap">
    <form
      @submit.prevent="register"
      class="flex flex-col flex-nowrap justify-around items-center"
    >
      <input
        name="name"
        v-model="user.name"
        type="text"
        placeholder="Введите имя администратора"
        required
      />
      <input
        name="login"
        v-model="user.login"
        type="text"
        placeholder="Введите логин администратора"
        required
      />
      <input
        name="password"
        v-model="user.password"
        type="password"
        placeholder="Пароль"
      />
      <input
        name="password_confirmation"
        v-model="user.password_confirmation"
        type="password"
        placeholder="Подтвердите пароль"
      />
      <input
        type="file"
        class="
          file:mr-4
          file:py-2
          file:px-4
          file:rounded-full
          file:border-0
          file:text-sm
          file:font-semibold
          file:bg-violet-50
          file:text-violet-700
          hover:file:bg-violet-100
        "
        name="avatar"
        @change="onFileChange"
      />
      <input
        type="submit"
        :disabled="
          !user.name ||
          !user.login ||
          !user.password ||
          !user.password_confirmation
        "
        :class="{
          disabled:
            !user.name ||
            !user.login ||
            !user.password ||
            !user.password_confirmation,
        }"
        value="Регистрация"
        class="hover:bg-main hover:text-white"
      />
    </form>
    <p v-if="error" class="font-bold text-red-900" id="error">
      Такой логин уже существует или/и ошибка подтверждения пароля
    </p>
  </div>
</template>

<script>
export default {
  data() {
    return {
      user: {
        name: null,
        login: null,
        password: null,
        password_confirmation: null,
        avatar: null,
      },
    };
  },
  computed: {
    error: function () {
      return this.$store.getters.authStatus == "error";
    },
  },
  methods: {
    onFileChange(e) {
      this.user.avatar = e.target.files[0];
    },
    async register() {
      const user = new FormData();
      user.append("name", this.user.name);
      user.append("login", this.user.login);
      user.append("password", this.user.password);
      user.append("password_confirmation", this.user.password_confirmation);
      user.append("avatar", this.user.avatar);

      this.$store.dispatch("Register", user);
    },
  },
};
</script>
