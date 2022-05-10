<template>
  <div class="table-row h-14">
    <div class="table-cell font-bold p-2">{{ teacher.id }}</div>
    <div class="table-cell">
      <router-link
        :to="{ name: 'teachers-teacher', params: { teacher: teacher.slug } }"
      >
        {{ teacher.name }} </router-link
      >
    </div>
    <div class="table-cell">{{ teacher.role }}</div>
    <div class="table-cell">{{ teacher.education }}</div>
    <div class="table-cell">
      <span
        @click="
          update(
            teacher.id,
            teacher.name,
            teacher.role,
            teacher.description,
            teacher.avatar,
            teacher.images,
            teacher.documents,
            teacher.education
          )
        "
        class="mr-5"
      >
        <i class="far fa-edit text-yellow-600"></i>
      </span>
      <span @click="remove(teacher.id, teacher.name, index)" class="mr-5">
        <i class="far fa-trash-alt text-red-600"></i>
      </span>
    </div>
  </div>
</template>

<script>
export default {
  methods: {
    update(id, name, role, description, avatar, images, documents, education) {
      this.$emit("update", id, name, role, description, avatar, images, documents, education);
    },
    remove(id, name, index) {
      this.$emit("remove", id, name, index);
    },
  },
  props: {
    index: {
      type: Number,
    },
    teacher: {
      type: Object,
      default: () => {},
    },
  },
};
</script>
