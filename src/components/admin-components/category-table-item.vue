<template>
  <div
    class="table-row h-14"
  >
    <div class="table-cell font-bold p-2">{{ category.id }}</div>
    <div v-if="edit == false" class="table-cell">{{ category.name }}</div>
    <div v-else class="table-cell">
      <input
        class="w-max"
        type="text"
        v-model="editName"
        :placeholder="category.name"
      />
      <button
        class="
          ml-2
          pt-2
          pb-2
          pl-5
          pr-5
          w-mac
          bg-purple-900
          rounded-md
          text-white
          font-bold
          hover:bg-white hover:text-purple-900
        "
        @click="update(category.id, category.name)"
      >
        Сохранить
      </button>
    </div>

    <div class="table-cell">
      <span @click="edit = !edit" class="mr-5">
        <i class="far fa-edit text-yellow-600 hover:text-yellow-800"></i>
      </span>
      <span @click="remove(category.id, category.name, index)" class="mr-5">
        <i class="far fa-trash-alt text-red-600 hover:text-red-900"></i>
      </span>
    </div>
  </div>
</template>

<script>
export default {
  data() {
    return {
      edit: false,
      editName: this.category.name
    };
  },
  methods: {
    update(id, name) {
      this.$emit("update", id, name);
      this.edit = !this.edit;
    },
    remove(id, name, index) {
      this.$emit("remove", id, name, index);
    },
  },
  props: {
    index: {
      type: Number,
    },
    category: {
      type: Object,
      default: () => {},
    },
  },
};
</script>

<style>
.table-cell {
  vertical-align: middle;
}
</style>