<template>
  <div class="flex w-full flex-col flex-nowrap relative">
    <confirm
      @remove="removeCategory"
      @toggle="mode.delete = !mode.delete"
      :data="category"
      :show="mode.delete"
    />

    <div class="flex w-full justify-between items-center flex-row flex-nowrap">
      <h2 class="font-bold text-2xl">Категории</h2>
      <button class="activeTab" @click="mode.create = !mode.create">
        <i class="fas fa-times mr-2" v-if="mode.create"></i
        ><i class="fas fa-plus mr-2" v-else></i
        >{{ mode.create ? "Cкрыть" : "Добавить" }}
      </button>
    </div>
    <transition name="slide-fade">
      <div
        v-if="mode.create"
        class="flex h-full mt-5 w-full flex-col flex-nowrap modal"
      >
        <div
          class="
            flex
            w-full
            flex-col flex-nowrap
            bg-white
            dark:bg-dark-900
            pt-5
            pb-5
            pr-10
            pl-10
            border border-gray-100
            rounded-md
          "
        >
          <div class="flex w-full pt-5 pb-5 mb-5">
            <h1 class="font-bold text-3xl">Создать категорию</h1>
          </div>
          <div class="flex w-full h-full pl-2 pr-2 relative">
            <form @submit.prevent="categoryCreate()" class="w-1/2">
              <label for="name">Название</label>
              <input
                class="w-full"
                name="name"
                v-model="category.name"
                placeholder="Введите текст"
                :maxlength="max"
                type="text"
              />
              <input
                class="
                  w-max
                  pt-2
                  pb-2
                  pl-5
                  pr-5
                  bg-white
                  text-sm
                  rounded-full
                  hover:text-main
                  dark:hover:text-white dark:hover:ring-white
                "
                type="submit"
                value="Создать"
              />
            </form>
            <div
              :style="{
                background: max - category.name.length == 0 ? 'red' : 'green',
              }"
              class="
                flex
                justify-center
                items-center
                p-5
                w-max
                h-5
                rounded-md
                font-bold
                text-white
                absolute
                bottom-0
                right-0
              "
            >
              <span class="" v-text="max - category.name.length"></span>
              <span class="pl-2">/ {{ max }}</span>
            </div>
          </div>
        </div>
      </div>
    </transition>
    <div class="table w-full mt-10 mb-10 overflow-x-auto">
      <div class="table-header-group">
        <div class="table-row">
          <div class="table-cell text-left font-bold p-2">ID</div>
          <div class="table-cell text-left font-bold">Название</div>
          <div class="table-cell text-left font-bold">Действия</div>
        </div>
      </div>
      <div v-if="categories" class="table-row-group">
        <table-item
          @update="updateCategory"
          @remove="remove"
          v-for="(category, index) in paginateData"
          :key="category.id"
          :index="index"
          :category="category"
          class="odd:bg-gray-200 dark:odd:bg-dark-900"
        />
      </div>
    </div>
    <loader :loading="loading" />
    <Pagination-lists
      @prev-page="prevPage"
      @next-page="nextPage"
      @current-page="currentPage($event)"
      :data="categories"
      :pag="this.pagination.pag"
      :page="this.pagination.page"
    />
  </div>
</template>

<script>
import tableItem from "./category-table-item.vue";
import Loader from "../loaders/loader.vue";
import Confirm from "../notificate/confirm.vue";
import PaginationLists from "../pagination/pagination-lists.vue";
export default {
  components: { tableItem, Loader, Confirm, PaginationLists },
  data() {
    return {
      max: 20,
      token: this.$store.state.auth.token,
      mode: {
        create: false,
        edit: false,
        delete: false,
      },
      categories: [],
      pagination: {
        page: 0,
        pag: 9,
      },
      category: {
        index: null,
        id: "New",
        name: "",
      },
      response: {
        status: null,
        message: null,
        color: null,
        errors: [],
      },
      loading: false,
    };
  },
  created() {
    this.loading = true;
    try {
      this.getCategories();
    } catch {
      this.loading = false;
    }
  },
  computed: {
    paginateData() {
      let start = this.pagination.page * this.pagination.pag;
      let end = start + this.pagination.pag;
      return this.categories.slice(start, end);
    },
  },
  methods: {
    prevPage() {
      this.pagination.page--;
    },
    nextPage() {
      this.pagination.page++;
    },
    currentPage(index) {
      this.pagination.page = index;
    },
    async getCategories() {
      const response = await fetch(`${process.env.VUE_APP_ROOT_API}/category`, {
        method: "GET",
      });
      const categories = await response.json();
      this.categories = categories;
      this.loading = false;
    },
    async updateCategory(id, name) {
      const category = new FormData();
      category.append("name", name);
      category.append("_method", "PUT");

      const myHeaders = new Headers();
      myHeaders.append("Authorization", `Bearer ${this.token}`);
      const response = await fetch(
        `${process.env.VUE_APP_ROOT_API}/category/${id}`,
        {
          method: "POST",
          body: category,
          headers: myHeaders,
        }
      );

      const message = await (await response).json();
      if (message.status == true) {
        this.$toast.success(message.message);
      } else if (message.status == false) {
        this.$toast.error(message.message);
        this.response.status = message.status;
        this.response.errors = message.errors;
        this.response.color = "red";
      }
    },
    remove(id, name, index) {
      this.category.index = index;
      this.category.id = id;
      this.category.title = name;
      this.mode.delete = !this.mode.delete;
    },
    async categoryCreate() {
      const category = new FormData();
      category.append("name", this.category.name);
      const myHeaders = new Headers();
      myHeaders.append("Authorization", `Bearer ${this.token}`);
      const response = await fetch(`${process.env.VUE_APP_ROOT_API}/category`, {
        method: "POST",
        body: category,
        headers: myHeaders,
      });

      const message = await (await response).json();
      if (message.status == true) {
        this.$toast.success(message.message);
        this.mode.create = !this.mode.create;
      } else if (message.status == false) {
        this.$toast.error(message.message);
        this.response.status = message.status;
        this.response.errors = message.errors;
        this.response.color = "red";
      }
      this.categories.push(this.category);
    },
    async removeCategory(id, index) {
      const myHeaders = new Headers();
      myHeaders.append("Authorization", `Bearer ${this.token}`);
      const response = await fetch(
        `${process.env.VUE_APP_ROOT_API}/category/${id}`,
        {
          method: "DELETE",
          headers: myHeaders,
        }
      );
      const message = await response.json();
      if (message.status == true) {
        this.$toast.success(message.message);
      } else if (message.status == false) {
        this.$toast.error("Ошибка удаления");
        this.response.status = message.status;
        this.response.errors = message.errors;
        this.response.color = "red";
      }
      this.categories.splice(index, 1);
      if (message.status == true) {
        this.mode.delete = !this.mode.delete;
      }
    },
  },
};
</script>
