<template>
  <div class="flex w-full justify-center items-center flex-col flex-wrap">
    <div @click="documents = !documents" class="flex p-2 w-full dark:bg-dark-800 rounded-lg">
      <h2>Документы</h2>
    </div>
    <ul v-if="documents" class="flex w-full p-2 flex-col flex-nowrap bg-white dark:bg-dark-800 m-0">
      <li>
        <router-link :to="{ name: 'documents', hash: '#education' }"
          >Образование</router-link
        >
      </li>
      <li>
        <router-link :to="{ name: 'documents', hash: '#normative' }"
          >Нормативно-правовые</router-link
        >
      </li>
      <li>
        <router-link :to="{ name: 'documents', hash: '#paidservices' }"
          >Платные образовательные услуги</router-link
        >
      </li>
      <li>
        <router-link :to="{ name: 'documents', hash: '#economicactivity' }"
          >Финансово-хозяйственная деятельность</router-link
        >
      </li>
      <li>
        <router-link :to="{ name: 'documents', hash: '#other' }"
          >Прочее</router-link
        >
      </li>
    </ul>
  </div>
</template>

<script>
export default {
    data() {
        return {
            documents: false
        }
    }
};
</script>

<style scoped>
li {
    list-style: none;
}
</style>