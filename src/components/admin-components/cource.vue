<template>
  <div class="flex w-full flex-col flex-nowrap">
    <div class="flex w-full justify-between items-center flex-row flex-nowrap">
      <h2 class="font-bold text-2xl">Курсы</h2>
      <button class="activeTab" @click="mode.create = !mode.create">
        <i class="fas fa-times mr-2" v-if="mode.create"></i
        ><i class="fas fa-plus mr-2" v-else></i
        >{{ mode.create ? "Cкрыть" : "Добавить" }}
      </button>
    </div>

    <confirm
      @remove="removeCource"
      @toggle="mode.delete = !mode.delete"
      :data="cource"
      :show="mode.delete"
    />

    <transition>
      <div
        v-if="mode.edit"
        class="flex rounded-md h-full mt-5 w-full flex-col flex-nowrap"
      >
        <div
          class="
            flex flex-col flex-nowrap
            w-full
            h-screen
            items-center
            z-20
            fixed
            top-0
            left-0
            pt-10
            pb-20
            pl-5
            pr-5
            backdrop-brightness-50
            overflow-y-auto
          "
        >
          <div
            class="
              flex flex-col flex-nowrap
              w-1/2
              h-max
              bg-white
              dark:bg-dark-800
              p-10
              rounded-md
            "
          >
            <div
              class="
                flex
                w-full
                justify-between
                items-start
                pt-5
                pb-5
                mb-5
                border-b-2 border-gray-100
              "
            >
              <h1 class="font-bold text-3xl">Обновить данные о курсе</h1>
              <button @click="mode.edit = !mode.edit">Скрыть</button>
            </div>
            <form
              @submit.prevent="courceUpdate(cource.id)"
              class="w-full p-5 rounded-md"
            >
              <div class="flex flex-col flex-nowrap">
                <label for="title">Название курса</label>
                <input
                  type="text"
                  v-model="cource.title"
                  name="title"
                  placeholder="Введите текст"
                />
                <label for="body">Описание</label>
                <quill-editor
                  v-model="cource.body"
                  name="body"
                  class="bg-white dark:bg-dark-800 mt-5 mb-5"
                  ref="myQuillEditor"
                  :options="editorOption"
                />
                <div class="flex w-full flex-col space-y-4 mb-5">
                  <label for="cover">Обложка</label>
                  <UploadImage @uploadImage="uploadImage" />
                </div>
                <div class="flex w-full flex-col space-y-4 mb-5">
                  <label for="images">Изображения</label>
                  <UploadsImages @uploadImages="uploadsImages" />
                </div>
                <div class="flex flex-col space-y-4 mb-5">
                  <label for="documents">Документы</label>
                  <UploadsDocs @uploadDocs="uploadsDocs" />
                </div>
                <span class="font-bold mb-2"
                  >Текущее изображение:
                  <span class="text-purple-900">{{ cource.image }}</span></span
                >
                <label for="payment">Тип распространения</label>
                <select class="w-max" name="payment" v-model="cource.payment">
                  <option disabled value="Тип">Тип</option>
                  <option value="Бесплатный">Бесплатный</option>
                  <option value="Платный">Платный</option>
                </select>
                <div class="flex flex-row">
                  <loader :loading="loading" />
                  <input
                    v-if="loading == false"
                    class="bg-gray-200 text-gray-400 font-bold activeTab w-max"
                    type="submit"
                    value="Опубликовать"
                  />
                  <input
                    class="
                      bg-gray-100
                      text-gray-500
                      hover:bg-gray-600 hover:text-white
                      w-max
                      ml-2
                    "
                    type="reset"
                    value="Очистить"
                  />
                </div>
              </div>
            </form>
          </div>
        </div>
      </div>
    </transition>

    <transition name="slide-fade">
      <div
        v-if="mode.create"
        class="flex rounded-md h-full mt-5 w-full flex-col flex-nowrap modal"
      >
        <div
          class="
            flex
            w-full
            flex-col flex-nowrap
            bg-white
            dark:bg-dark-800
            pt-5
            pb-5
            pr-10
            pl-10
            border border-gray-100
            rounded-md
          "
        >
          <div class="flex w-full pt-5 pb-5 mb-5">
            <h1 class="font-bold text-3xl">Создать курс</h1>
          </div>
          <div class="flex w-full h-full pl-2 pr-2 scroll">
            <form @submit.prevent="courceCreate()" class="w-full">
              <div class="flex flex-col flex-nowrap">
                <label for="title">Название курса</label>
                <input
                  type="text"
                  v-model="cource.title"
                  name="title"
                  placeholder="Введите текст"
                />
                <label for="body">Описание</label>
                <quill-editor
                  v-model="cource.body"
                  name="body"
                  class="bg-white dark:bg-dark-800 mt-5 mb-5"
                  ref="myQuillEditor"
                  :options="editorOption"
                />
                <div class="flex w-full flex-col space-y-4 mb-5">
                  <label for="cover">Обложка</label>
                  <UploadImage @uploadImage="uploadImage" />
                </div>
                <div class="flex w-full flex-col space-y-4 mb-5">
                  <label for="images">Изображения</label>
                  <UploadsImages @uploadImages="uploadsImages" />
                </div>
                <div class="flex flex-col space-y-4 mb-5">
                  <label for="documents">Документы</label>
                  <UploadsDocs @uploadDocs="uploadsDocs" />
                </div>
                <label for="payment">Тип распространения</label>
                <select class="w-max" name="payment" v-model="cource.payment">
                  <option disabled value="Тип">Тип</option>
                  <option value="Бесплатный">Бесплатный</option>
                  <option value="Платный">Платный</option>
                </select>
                <div class="flex flex-row">
                  <loader :loading="loading" />
                  <input
                    v-if="loading == false"
                    class="bg-gray-200 text-gray-400 font-bold activeTab w-max"
                    type="submit"
                    value="Опубликовать"
                  />
                  <input
                    class="
                      bg-gray-100
                      text-gray-500
                      hover:bg-gray-600 hover:text-white
                      w-max
                      ml-2
                    "
                    type="reset"
                    value="Очистить"
                  />
                </div>
              </div>
            </form>
          </div>
        </div>
      </div>
    </transition>
    <div class="table w-full mt-10 mb-10 overflow-x-auto">
      <div class="table-header-group">
        <div class="table-row">
          <div class="table-cell text-left font-bold p-2">ID</div>
          <div class="table-cell text-left font-bold">Название</div>
          <div class="table-cell text-left font-bold">Описание</div>
          <div class="table-cell text-left font-bold">Тип</div>
          <div class="table-cell text-left font-bold">Действия</div>
        </div>
      </div>
      <div v-if="cource" class="table-row-group">
        <cource-table-item
          @update="update"
          @remove="remove"
          v-for="(cource, index) in paginateData"
          :key="cource.id"
          :index="index"
          :cource="cource"
          class="odd:bg-gray-200 dark:odd:bg-dark-900"
        />
      </div>
    </div>
    <loader :loading="loading" />
    <Pagination-lists
      @prev-page="prevPage"
      @next-page="nextPage"
      @current-page="currentPage($event)"
      :data="cources"
      :pag="this.pagination.pag"
      :page="this.pagination.page"
    />
  </div>
</template>

<script>
import { quillEditor } from "vue-quill-editor";
import CourceTableItem from "./cource-table-item.vue";
import Loader from "../loaders/loader.vue";
import Confirm from "../notificate/confirm.vue";
import UploadsImages from "../uploads/uploadsImages.vue";
import UploadImage from "../uploads/uploadImage.vue";
import UploadsDocs from "../uploads/uploadsDocs.vue";
import PaginationLists from "../pagination/pagination-lists.vue";
export default {
  components: {
    quillEditor,
    CourceTableItem,
    Loader,
    Confirm,
    UploadsImages,
    UploadImage,
    UploadsDocs,
    PaginationLists,
  },
  data() {
    return {
      token: this.$store.state.auth.token,
      cources: [],
      pagination: {
        page: 0,
        pag: 9,
      },
      response: {
        status: null,
        message: null,
        errors: [],
      },
      mode: {
        create: false,
        edit: false,
        delete: false,
      },
      cource: {
        index: null,
        id: null,
        title: null,
        body: null,
        cover: null,
        images: null,
        documents: null,
        payment: "Бесплатный",
      },
      loading: false,
      editorOption: {
        theme: "snow",
        modules: {
          toolbar: [
            ["bold", "italic", "underline", "strike"],
            ["blockquote", "code-block"],
            [{ header: 1 }, { header: 2 }],
            [{ list: "ordered" }, { list: "bullet" }],
            [{ script: "sub" }, { script: "super" }],
            [{ indent: "-1" }, { indent: "+1" }],
            [{ direction: "rtl" }],
            [{ size: ["small", false, "large", "huge"] }],
            [{ header: [1, 2, 3, 4, 5, 6, false] }],
            [{ color: [] }, { background: [] }],
            [{ align: [] }],
            ["clean"],
            ["link"],
          ],
        },
      },
    };
  },
  created() {
    this.loading = true;
    try {
      this.getCourses();
    } catch {
      this.loading = false;
    }
  },
  computed: {
    paginateData() {
      let start = this.pagination.page * this.pagination.pag;
      let end = start + this.pagination.pag;
      return this.cources.slice(start, end);
    },
  },
  methods: {
    async getCourses() {
      const response = await fetch(`${process.env.VUE_APP_ROOT_API}/course`, {
        method: "GET",
      });
      const cources = await response.json();
      this.cources = cources;
      this.loading = false;
    },
    prevPage() {
      this.pagination.page--;
    },
    nextPage() {
      this.pagination.page++;
    },
    currentPage(index) {
      this.pagination.page = index;
    },
    uploadImage(data) {
      this.cource.cover = data;
    },
    uploadsImages(data) {
      this.cource.images = data;
    },
    uploadsDocs(data) {
      this.cource.documents = data;
    },
    update(id, title, body, cover, images, documents, payment) {
      this.cource.id = id;
      this.cource.title = title;
      this.cource.body = body;
      this.cource.cover = cover;
      this.cource.images = images;
      this.cource.documents = documents;
      this.cource.payment = payment;
      this.mode.edit = !this.mode.edit;
    },
    remove(index, id, title) {
      this.cource.index = index;
      this.cource.id = id;
      this.cource.title = title;
      this.mode.delete = !this.mode.delete;
    },
    async courceUpdate(id) {
      const cource = new FormData();
      cource.append("title", this.cource.title);
      cource.append("body", this.cource.body);
      cource.append("cover", this.cource.cover);
      if (this.cource.images !== null) {
        for (var i = 0; i < this.cource.images.length; i++) {
          let file = this.cource.images[i];
          cource.append("images[" + i + "]", file);
        }
      }
      if (this.cource.documents !== null) {
        for (var d = 0; d < this.cource.documents.length; d++) {
          let file = this.cource.documents[d];
          cource.append("documents[" + d + "]", file);
        }
      }
      cource.append("payment", this.cource.payment);
      cource.append("_method", "PATCH");

      const myHeaders = new Headers();
      myHeaders.append("Authorization", `Bearer ${this.token}`);
      const response = await fetch(
        `${process.env.VUE_APP_ROOT_API}/course/${id}`,
        {
          method: "POST",
          body: cource,
          headers: myHeaders,
        }
      );
      const message = await response.json();
      if (message.status == true) {
        this.$toast.success(message.message);
      } else if (message.status == false) {
        this.$toast.error(message.message);
        this.response.status = message.status;
        this.response.errors = message.errors;
        this.response.color = "red";
      }
      this.mode.edit = !this.mode.edit;
    },
    async courceCreate() {
      const cource = new FormData();
      cource.append("title", this.cource.title);
      cource.append("body", this.cource.body);
      cource.append("cover", this.cource.cover);
      if (this.cource.images !== null) {
        for (var i = 0; i < this.cource.images.length; i++) {
          let file = this.cource.images[i];
          cource.append("images[" + i + "]", file);
        }
      }
      if (this.cource.documents !== null) {
        for (var d = 0; d < this.cource.documents.length; d++) {
          let file = this.cource.documents[d];
          cource.append("documents[" + d + "]", file);
        }
      }
      cource.append("payment", this.cource.payment);

      const myHeaders = new Headers();
      myHeaders.append("Authorization", `Bearer ${this.token}`);

      const response = await fetch(`${process.env.VUE_APP_ROOT_API}/course`, {
        method: "POST",
        body: cource,
        headers: myHeaders,
      });

      const message = await response.json();
      if (message.status == true) {
        this.$toast.success(message.message);
        this.mode.create = !this.mode.create;
      } else if (message.status == false) {
        this.$toast.error("Ошибка создания");
        this.response.status = message.status;
        this.response.errors = message.errors;
        this.response.color = "red";
      }
      this.courses.push(this.cource);
    },
    async removeCource(id, index) {
      const authHeaders = new Headers();
      authHeaders.append("Authorization", `Bearer ${this.token}`);
      const response = await fetch(
        `${process.env.VUE_APP_ROOT_API}/course/${id}`,
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
      this.cources.splice(index, 1);
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
</style>