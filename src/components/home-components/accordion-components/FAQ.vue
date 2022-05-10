<template>
  <div
    class="
      flex
      justify-start
      items-center
      flex-row flex-wrap
      max-w-7xl
      w-full
      mt-10
      mb-10
      box-border
      relative
    "
  >
    <Description
      v-for="(obj, index) in dataDecription"
      :key="index"
      :dataDecription="obj"
    />
    <div
      class="
        flex
        w-full
        justify-between
        h-full
        items-center
        flex-row flex-wrap
        mt-10
        mb-10
      "
    >
      <accordion />
    </div>
  </div>
</template>

<script>
import Accordion from "../accordion-components/accordion.vue";
import Description from "../decription.vue";
export default {
  components: {
    Description,
    Accordion,
  },
  data() {
    return {
      dataDecription: [
        {
          title: "FAQ",
          desc: "Часто задаваемые вопросы",
        },
      ],
    };
  },
};
</script>