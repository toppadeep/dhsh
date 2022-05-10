<template>
  <div
    class="
      flex
      justify-center
      items-center
      mx-auto
      min-w-7xl
      h-full
      flex-row flex-nowrap pt-0
    "
  >
    <div  class="flex w-full">
      <admin-panel />
    </div>
  </div>
</template>

<script>
const AdminPanel = () => import("../components/admin-components/main-admin-panel.vue");
export default {
  head() {
    return {
      title: "Управление сайтом",
    };
  },
  components: {
    AdminPanel,
  },
  methods: {
    reload() {
      location.reload();
    },
  },
};
</script>
