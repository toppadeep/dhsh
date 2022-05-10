<template>
  <div class="flex w-full flex-col flex-nowrap">
    <div class="flex w-full justify-between items-center flex-row flex-nowrap">
      <h2 class="font-bold text-2xl">Документы</h2>
      <button class="activeTab" @click="mode.create = !mode.create">
        <i class="fas fa-times mr-2" v-if="mode.create"></i
        ><i class="fas fa-plus mr-2" v-else></i
        >{{ mode.create ? "Cкрыть" : "Добавить" }}
      </button>
    </div>

    <confirm
      @remove="removeDocument"
      @toggle="mode.delete = !mode.delete"
      :data="document"
      :show="mode.delete"
    />

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
            space-y-4
          "
        >
          <div class="flex w-full pt-5 pb-5 mb-5">
            <h1 class="font-bold text-3xl">Добавить документы</h1>
          </div>
          <UploadsDocs @uploadDocs="uploadsDocs" />
          <Select :options="options" @filterOption="change($event)" />
          <button @click="documentCreate()">Загрузить</button>
          <Notification :response="response" />
        </div>
      </div>
    </transition>
    <div class="table w-full mt-10 mb-10 overflow-x-auto">
      <div class="table-header-group">
        <div class="table-row">
          <div class="table-cell text-left font-bold p-2">ID</div>
          <div class="table-cell text-left font-bold">Название</div>
          <div class="table-cell text-left font-bold">Тип</div>
          <div class="table-cell text-left font-bold">Размер</div>
          <div class="table-cell text-left font-bold">Действия</div>
        </div>
      </div>
      <div v-if="documents" class="table-row-group relative">
        <doc-table-item
          @remove="remove"
          v-for="(document, index) of this.paginateData"
          :key="document.id"
          :index="index"
          :document="document"
          class="odd:bg-gray-200 dark:odd:bg-dark-900"
        />
      </div>
    </div>
    <loader :loading="loading" />
    <Pagination-lists
      @prev-page="prevPage"
      @next-page="nextPage"
      @current-page="currentPage($event)"
      :data="documents"
      :pag="this.pagination.pag"
      :page="this.pagination.page"
    />
  </div>
</template>

<script>
import Loader from "../loaders/loader.vue";
import DocTableItem from "./doc-table-item.vue";
import Confirm from "../notificate/confirm.vue";
import UploadsDocs from "../uploads/uploadsDocs.vue";
import Notification from "../notificate/notification.vue";
import Select from "../select/select.vue";
import PaginationLists from "../pagination/pagination-lists.vue";
export default {
  components: {
    Loader,
    DocTableItem,
    Confirm,
    UploadsDocs,
    Notification,
    Select,
    PaginationLists,
  },
  data() {
    return {
      token: this.$store.state.auth.token,
      options: [
        { name: "Нормативно-правовые" },
        { name: "Образование" },
        { name: "Платные образовательные услуги" },
        { name: "Финансово-хозяйственная" },
        { name: "Прочее" },
      ],
      documents: [],
      mode: {
        create: false,
        edit: false,
        delete: false,
      },
      document: {
        index: "",
        id: "",
        title: "В обработке",
        filetype: "",
        filesize: "",
        files: [],
      },
      response: {
        status: null,
        message: null,
        errors: null,
      },
      pagination: {
        page: 0,
        pag: 9,
      },
      loading: false,
      selectCategory: "",
    };
  },
  created() {
    this.loading = true;
    try {
      this.getDocuments();
    } catch {
      this.loading = false;
    }
  },
  computed: {
    paginateData() {
      let start = this.pagination.page * this.pagination.pag;
      let end = start + this.pagination.pag;
      return this.documents.slice(start, end);
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
    change(select) {
      this.selectCategory = select;
    },
    uploadsDocs(data) {
      this.documents.files = data;
    },
    async getDocuments() {
      const response = await fetch(`${process.env.VUE_APP_ROOT_API}/document`, {
        method: "GET",
      });
      const documents = await response.json();
      this.documents = documents;
      this.loading = false;
    },
    remove(id, title, index) {
      this.document.index = index;
      this.document.id = id;
      this.document.title = title;
      this.mode.delete = !this.mode.delete;
    },
    async documentCreate() {
      console.log(this.documents.files);
      const document = new FormData();
      document.append("category", this.selectCategory);
      if (this.documents.files.length !== 0) {
        for (var i = 0; i < this.documents.files.length; i++) {
          let file = this.documents.files[i];
          document.append("document[" + i + "]", file);
        }
      }
      const myHeaders = new Headers();
      myHeaders.append("Authorization", `Bearer ${this.token}`);

      const response = await fetch(`${process.env.VUE_APP_ROOT_API}/document`, {
        method: "POST",
        headers: myHeaders,
        body: document,
      });

      const message = await response.json();
      if (message.status == true) {
        this.$toast.success(message.message);
        this.mode.create = !this.mode.create;
        this.documents.push(this.document);
        this.loading = false;
      } else if (message.status == false) {
        this.$toast.error(message.message);
        this.response.status = message.status;
        this.response.errors = message.errors;
        this.response.color = "red";
        this.loading = false;
      }
    },
    async removeDocument(id, index) {
      const authHeaders = new Headers();
      authHeaders.append("Authorization", `Bearer ${this.token}`);
      const response = await fetch(
        `${process.env.VUE_APP_ROOT_API}/document/${id}`,
        {
          method: "DELETE",
          headers: authHeaders,
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
      this.documents.splice(index, 1);
      if (message.status == true || message.status == false) {
        this.mode.delete = !this.mode.delete;
      }
    },
  },
};
</script>
  
<style scoped>
.n:nth-child(odd) {
  background-color: rgb(247, 247, 247);
}

/* Анимации появления и исчезновения могут иметь */
/* различные продолжительности и динамику.       */
.slide-fade-enter-active {
  transition: all 0.3s ease;
}
.slide-fade-leave-active {
  transition: all 0.5s cubic-bezier(1, 0.5, 0.8, 1);
}
.slide-fade-enter, .slide-fade-leave-to
/* .slide-fade-leave-active до версии 2.1.8 */ {
  transform: translateX(10px);
  opacity: 0;
}
</style>

