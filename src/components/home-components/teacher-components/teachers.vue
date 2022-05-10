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
    <teacher-item
      v-for="(teacher, index) in teachers"
      :key="index"
      :teacher="teacher"
    />
  </div>
</template>

<script>
import Description from "../decription.vue";
import TeacherItem from "./teacher-item.vue";
export default {
  components: {
    Description,
    TeacherItem,
  },
  data() {
    return {
      dataDecription: [
        {
          title: "Наши замечательные учителя",
          desc: "Мы стремимся предоставлять широкий спектр услуг для повышения навыков ваших детей, чтобы они развивались и повышали базовые знания",
        },
      ],
      teachers: null,
    };
  },
  async created() {
    const response = await fetch(`${process.env.VUE_APP_ROOT_API}/teacher`, {
      method: "GET",
    });
    this.teachers = await response.json();
  },
};
</script>