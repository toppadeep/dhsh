<template>
  <div class="flex w-full flex-col flex-nowrap">
    <div class="flex w-full justify-between items-center flex-row flex-nowrap">
      <h3
        :after="posts.length"
        class="
          flex flex-row
          font-bold
          text-2xl
          after:content-[attr(after)]
          after:bg-main
          after:text-white
          after:w-6
          after:text-base
          after:flex
          after:justify-center
          after:items-center
          after:h-6
          after:rounded-full
        "
      >
        Все посты
      </h3>
      <button class="activeTab" @click="mode.create = !mode.create">
        <i class="fas fa-times mr-2" v-if="mode.create"></i
        ><i class="fas fa-plus mr-2" v-else></i
        >{{ mode.create ? "Cкрыть" : "Добавить" }}
      </button>
    </div>

    <confirm
      @remove="removePost"
      @toggle="mode.delete = !mode.delete"
      :data="post"
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
              w-10/12
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
                h-full
                justify-between
                items-start
                pt-5
                pb-5
                mb-5
                border-b-2 border-gray-100
              "
            >
              <h1 class="font-bold text-3xl">Обновить пост</h1>
              <button class="font-semibold" @click="mode.edit = !mode.edit">
                Скрыть
              </button>
            </div>
            <form
              @submit.prevent="postUpdate(post.id)"
              class="flex flex-col flex-nowrap w-full h-full items-start"
            >
              <label for="title">Заголовок</label>
              <input
                class="w-full"
                name="title"
                v-model="post.title"
                placeholder="Введите текст"
                type="text"
              />
              <label for="subtitle">Подзаголовок</label>
              <input
                v-model="post.subtitle"
                class="w-full"
                name="subtitle"
                placeholder="Введите текст"
                type="text"
              />
              <div class="flex flex-col space-y-4 mb-5">
                <label for="body">Описание</label>
                <quill-editor
                  v-model="post.body"
                  name="body"
                  class="bg-white dark:bg-dark-900 mt-5 mb-5 w-full"
                  ref="myQuillEditor"
                  :options="editorOption"
                />
              </div>
              <div class="flex flex-col flex-nowrap">
                <label for="category_id">Категории</label>
                <select
                  name="category_id"
                  v-model="post.category"
                  class="w-max mr-5"
                >
                  <option value="0" disabled>Категории</option>
                  <option
                    v-for="(category, index) in categories"
                    :key="index"
                    :value="category.id"
                  >
                    {{ category.name }}
                  </option>
                </select>
              </div>
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
            </form>
          </div>
        </div>
      </div>
    </transition>
    <transition name="slide-fade">
      <div
        v-if="mode.create"
        class="flex rounded-md h-max mt-5 w-full flex-col flex-nowrap modal"
      >
        <div
          class="
            flex
            w-full
            flex-col flex-nowrap
            bg-white
            dark:bg-dark-800
            rounded-md
          "
        >
          <div class="flex w-full pt-5 pb-5 mb-5">
            <h1 class="font-bold text-3xl">Создать пост</h1>
          </div>
          <div class="flex w-full h-full pl-2 pr-2 scroll">
            <form
              @submit.prevent="postCreate()"
              class="flex flex-col flex-nowrap w-full h-max"
            >
              <label for="title">Заголовок</label>
              <input
                class="w-full"
                name="title"
                v-model="post.title"
                placeholder="Введите текст"
                type="text"
                required
              />
              <label for="subtitle">Подзаголовок</label>
              <input
                v-model="post.subtitle"
                class="w-full"
                name="subtitle"
                placeholder="Введите текст"
                type="text"
                required
              />
              <label for="body">Описание</label>
              <quill-editor
                v-model="post.body"
                name="body"
                class="bg-white dark:bg-dark-800 mt-5 mb-5"
                ref="myQuillEditor"
                :options="editorOption"
              />
              <div class="flex mt-10 flex-col flex-nowrap">
                <label for="category_id">Категории</label>
                <select
                  name="category_id"
                  v-model="post.category"
                  class="w-max mr-5"
                >
                  <option value="0" disabled>Категории</option>
                  <option
                    v-for="(category, index) in categories"
                    :key="index"
                    :value="category.id"
                  >
                    {{ category.name }}
                  </option>
                </select>
              </div>
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
              <notification :response="response" />
            </form>
          </div>
        </div>
      </div>
    </transition>
    <div class="table w-full mt-10 mb-10 overflow-x-scroll">
      <div class="table-header-group">
        <div class="table-row">
          <div class="table-cell text-left font-bold p-2">ID</div>
          <div class="table-cell text-left font-bold">Название</div>
          <div class="table-cell text-left font-bold">Дата</div>
          <div class="table-cell text-left font-bold">Категория</div>
          <div class="table-cell text-left font-bold">Автор</div>
          <div class="table-cell text-left font-bold">Действия</div>
        </div>
      </div>
      <div v-if="posts" class="table-row-group relative">
        <post-table-item
          @update="update"
          @remove="remove"
          v-for="(post, index) in paginateData"
          :key="post.id"
          :index="index"
          :post="post"
          class="odd:bg-gray-200 dark:odd:bg-dark-900"
        />
      </div>
    </div>
    <loader :loading="loading" />
    <Pagination-lists
      @prev-page="prevPage"
      @next-page="nextPage"
      @current-page="currentPage($event)"
      :data="posts"
      :pag="this.pagination.pag"
      :page="this.pagination.page"
    />
  </div>
</template>

<script>
import { quillEditor } from "vue-quill-editor";
import PaginationLists from "../pagination/pagination-lists.vue";
export default {
  components: {
    quillEditor,
    Notification: () => import("../notificate/notification.vue"),
    PostTableItem: () => import("./post-table-item.vue"),
    Loader: () => import("../loaders/loader.vue"),
    Confirm: () => import("../notificate/confirm.vue"),
    UploadsImages: () => import("../uploads/uploadsImages.vue"),
    UploadImage: () => import("../uploads/uploadImage.vue"),
    UploadsDocs: () => import("../uploads/uploadsDocs.vue"),
    PaginationLists,
  },
  data() {
    return {
      form: {},
      token: this.$store.state.auth.token,
      posts: [],
      pagination: {
        page: 0,
        pag: 9,
      },
      mode: {
        create: false,
        edit: false,
        delete: false,
      },
      modal: false,
      post: {
        id: null,
        index: null,
        title: "",
        subtitle: "",
        body: "",
        category: "",
        cover: null,
        images: [],
        documents: [],
      },
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
            [{ font: [] }],
            [{ align: [] }],
            ["clean"],
            ["link"],
          ],
        },
      },
      categories: [],
      response: {
        status: null,
        message: null,
        errors: [],
      },
      loading: false,
    };
  },
  created() {
    this.loading = true;
    try {
      this.getPosts();
    } catch {
      this.loading = false;
    }
    this.getCategories();
  },
  computed: {
    paginateData() {
      let start = this.pagination.page * this.pagination.pag;
      let end = start + this.pagination.pag;
      return this.posts.slice(start, end);
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
    uploadsDocs(data) {
      this.post.documents = data;
    },
    uploadImage(data) {
      this.post.cover = data;
    },
    uploadsImages(data) {
      this.post.images = data;
    },
    async getPosts() {
      const response = await fetch(`${process.env.VUE_APP_ROOT_API}/post`, {
        method: "GET",
      });
      const posts = await response.json();
      this.posts = posts;
      this.loading = false;
    },
    async getCategories() {
      const categories = await fetch(
        `${process.env.VUE_APP_ROOT_API}/category`,
        {
          method: "GET",
        }
      );
      this.categories = await categories.json();
    },
    update(id, title, subtitle, body, cover, images, documents, category) {
      this.post.id = id;
      this.post.title = title;
      this.post.subtitle = subtitle;
      this.post.body = body;
      this.post.cover = cover;
      this.post.images = images;
      this.post.documents = documents;
      this.post.category = category;
      this.mode.edit = !this.mode.edit;
    },
    remove(id, title, index) {
      this.post.index = index;
      this.post.id = id;
      this.post.title = title;
      this.mode.delete = !this.mode.delete;
    },
    async postUpdate(id) {
      const post = new FormData();
      post.append("title", this.post.title);
      post.append("subtitle", this.post.subtitle);
      post.append("body", this.post.body);
      post.append("cover", this.post.cover);
      if (this.post.images !== null) {
        for (var i = 0; i < this.post.images.length; i++) {
          let file = this.post.images[i];
          post.append("images[" + i + "]", file);
        }
      }
      if (this.post.documents !== null) {
        for (var d = 0; d < this.post.documents.length; d++) {
          let file = this.post.documents[d];
          post.append("documents[" + d + "]", file);
        }
      }
      post.append("category_id", this.post.category);
      post.append("_method", "PATCH");

      const myHeaders = new Headers();
      myHeaders.append("Authorization", `Bearer ${this.token}`);

      this.loading = true;
      const response = await fetch(
        `${process.env.VUE_APP_ROOT_API}/post/${id}`,
        {
          method: "POST",
          body: post,
          headers: myHeaders,
        }
      );

      const message = await response.json();
      if (message.status == true) {
        this.$toast.success(message.message);
        this.loading = false;
      } else if (message.status == false) {
        this.$toast.error(message.message);
        this.response.status = message.status;
        this.response.errors = message.errors;
        this.response.color = "red";
        this.loading = false;
      }

      if (message.status == true) {
        this.mode.edit = !this.mode.edit;
      }
    },
    async postCreate() {
      const post = new FormData();
      post.append("title", this.post.title);
      post.append("subtitle", this.post.subtitle);
      post.append("body", this.post.body);
      post.append("cover", this.post.cover);
      if (this.post.images !== null) {
        for (var i = 0; i < this.post.images.length; i++) {
          let file = this.post.images[i];
          post.append("images[" + i + "]", file);
        }
      }
      if (this.post.documents !== null) {
        for (var d = 0; d < this.post.documents.length; d++) {
          let file = this.post.documents[d];
          post.append("documents[" + d + "]", file);
        }
      }
      post.append("category_id", this.post.category);

      const myHeaders = new Headers();
      myHeaders.append("Authorization", `Bearer ${this.token}`);
      this.loading = true;
      const response = await fetch(`${process.env.VUE_APP_ROOT_API}/post`, {
        method: "POST",
        body: post,
        headers: myHeaders,
      });
      const message = await response.json();
      if (message.status == true) {
        this.$toast.success(message.message);
        this.loading = false;
      } else if (message.status == false) {
        this.$toast.error(message.message);
        this.response.status = message.status;
        this.response.errors = message.errors;
        this.response.color = "red";
        this.loading = false;
      }

      if (message.status == true) {
        this.mode.create = !this.mode.create;
      }
    },
    async removePost(id, index) {
      const myHeaders = new Headers();
      myHeaders.append("Authorization", `Bearer ${this.token}`);
      const response = await fetch(
        `${process.env.VUE_APP_ROOT_API}/post/${id}`,
        {
          method: "DELETE",
          headers: myHeaders,
        }
      );
      this.posts.splice(index, 1);
      const message = await response.json();
      if (message.status == true) {
        this.$toast.success(message.message);
      } else if (message.status == false) {
        this.response.status = message.status;
        this.response.message = message.message;
        this.response.color = "red";
      }

      if (message.status == true || message.status == false) {
        this.mode.delete = !this.mode.delete;
      }
    },
  },
};
</script>

