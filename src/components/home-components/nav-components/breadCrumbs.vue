<template>
  <div class="flex max-w-7xl w-full justify-start items-center flex-row flex-nowrap mt-2 mb-2">
    <ul>
      <li
      class="flex justify-center items-center"
        v-for="(breadcrumb, idx) in breadcrumbList"
        :key="idx"
        @click="routeTo(idx)"
        :class="{ linked: !!breadcrumb.link }"
      >
        <a class="text-gray-400"  :class="{ linked: !breadcrumb.link }">{{ breadcrumb.name }}</a>
      </li>
    </ul>
  </div>
</template>

<script>
export default {
  name: "Breadcrumb",
  data() {
    return {
      breadcrumbList: [],
    };
  },
  mounted() {
    this.updateList();
  },
  watch: {
    $route() {
      this.updateList();
    },
  },
  methods: {
    routeTo(pRouteTo) {
      if (this.breadcrumbList[pRouteTo].link)
        this.$router.push(this.breadcrumbList[pRouteTo].link);
    },
    updateList() {
      this.breadcrumbList = this.$route.meta.breadcrumb;
    },
  },
};
</script>

<style scoped>
ul {
  display: flex;
  flex-flow: row wrap;
  justify-content: center;
  list-style-type: none;
  margin: 0;
  padding: 0;
}


ul > li:not(:last-child)::after {
  content: "›";
  font-size: 0.8em;
  margin: 0 0.5em;
  cursor: default;
}

.linked {
  cursor: pointer;
  font-weight: normal;
  color:rgb(209, 209, 209)
}

</style>