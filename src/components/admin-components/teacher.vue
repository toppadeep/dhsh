<template>
  <div class="flex w-full flex-col flex-nowrap">
    <div class="flex w-full justify-between items-center flex-row flex-nowrap">
      <h3
        :after="teachers.length"
        class="
          flex flex-row
          font-bold
          text-2xl
          after:content-[attr(after)]
          after:bg-yellow-400
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
        Все учителя
      </h3>
      <button class="activeTab" @click="mode.create = !mode.create">
        <i class="fas fa-times mr-2" v-if="mode.create"></i
        ><i class="fas fa-plus mr-2" v-else></i
        >{{ mode.create ? "Cкрыть" : "Добавить" }}
      </button>
    </div>

    <confirm
      @remove="removeTeacher"
      @toggle="mode.delete = !mode.delete"
      :data="teacher"
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
              <h1 class="font-bold text-3xl">
                Обновить данные о преподавателе
              </h1>
              <button @click="mode.edit = !mode.edit">Скрыть</button>
            </div>
            <form @submit.prevent="teacherUpdate(teacher.id)" class="w-full">
              <label for="name">Имя</label>
              <input
                class="w-full"
                name="name"
                v-model="teacher.name"
                placeholder="Введите текст"
                type="text"
              />

              <label for="description">Описание</label>
              <quill-editor
                v-model="teacher.description"
                name="description"
                class="bg-white dark:bg-dark-800 mt-5 mb-5"
                ref="myQuillEditor"
                :options="editorOption"
              />
              <div class="flex flex-row flex-wrap w-full">
                <div class="flex flex-col flex-nowrap">
                  <label for="role">Роль</label>
                  <select name="role" v-model="teacher.role" class="w-max mr-5">
                    <option value="Директор">Директор</option>
                    <option value="Преподаватель">Преподаватель</option>
                  </select>
                </div>

                <div class="flex flex-col flex-nowrap">
                  <label for="education">Образование</label>
                  <div class="flex flex-row">
                    <select
                      name="education"
                      v-model="teacher.education"
                      class="w-max mr-5"
                    >
                      <option value="Высшее">Высшее</option>
                      <option value="Средне-специальное">
                        Средне-специальное
                      </option>
                      <option value="Среднее">Среднее</option>
                    </select>
                  </div>
                </div>
                <div class="flex w-full flex-col space-y-4 mb-5">
                  <label for="avatar">Фото</label>
                  <UploadImage @uploadImage="uploadImage" />
                </div>
                <div class="flex w-full flex-col space-y-4 mb-5">
                  <label for="images">Изображения</label>
                  <UploadsImages @uploadImages="uploadImages" />
                </div>
                <div class="flex flex-col space-y-4 mb-5">
                  <label for="documents">Документы</label>
                  <UploadsDocs @uploadDocs="uploadDocs" />
                </div>
              </div>
              <div class="flex flex-row">
                <loader :loading="loading" />
                <input
                  v-if="loading == false"
                  class="bg-gray-200 text-gray-400 font-bold activeTab w-max"
                  type="submit"
                  value="Обновить"
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
            <h1 class="font-bold text-3xl">Добавить преподавателя</h1>
          </div>
          <div class="flex w-full h-full pl-2 pr-2 scroll">
            <form @submit.prevent="teacherCreate(teacher.id)" class="w-full">
              <label for="name">Имя</label>
              <input
                class="w-full"
                name="name"
                v-model="teacher.name"
                placeholder="Введите текст"
                type="text"
              />

              <label for="description">Описание</label>
              <quill-editor
                v-model="teacher.description"
                name="description"
                class="bg-white dark:bg-dark-800 mt-5 mb-5"
                ref="myQuillEditor"
                :options="editorOption"
              />
              <div class="flex flex-row flex-wrap w-full">
                <div class="flex flex-col flex-nowrap">
                  <label for="role">Роль</label>
                  <select name="role" v-model="teacher.role" class="w-max mr-5">
                    <option value="Директор">Директор</option>
                    <option value="Преподаватель">Преподаватель</option>
                  </select>
                </div>

                <div class="flex flex-col flex-nowrap">
                  <label for="education">Образование</label>
                  <div class="flex flex-row">
                    <select
                      name="education"
                      v-model="teacher.education"
                      class="w-max mr-5"
                    >
                      <option value="Высшее">Высшее</option>
                      <option value="Средне-специальное">
                        Средне-специальное
                      </option>
                      <option value="Среднее">Среднее</option>
                    </select>
                  </div>
                </div>
                <div class="flex w-full flex-col space-y-4 mb-5">
                  <label for="avatar">Фото</label>
                  <UploadImage @uploadImage="uploadImage" />
                </div>
                <div class="flex w-full flex-col space-y-4 mb-5">
                  <label for="images">Изображения</label>
                  <UploadsImages @uploadImages="uploadImages" />
                </div>
                <div class="flex flex-col space-y-4 mb-5">
                  <label for="documents">Документы</label>
                  <UploadsDocs @uploadDocs="uploadDocs" />
                </div>
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
    <div class="table w-full mt-10 mb-10 overflow-x-auto">
      <div class="table-header-group">
        <div class="table-row">
          <div class="table-cell text-left font-bold p-2">ID</div>
          <div class="table-cell text-left font-bold">Имя</div>
          <div class="table-cell text-left font-bold">Роль</div>
          <div class="table-cell text-left font-bold">Образование</div>
          <div class="table-cell text-left font-bold">Действия</div>
        </div>
      </div>
      <div v-if="teachers" class="table-row-group">
        <teacher-table-item
          @update="update"
          @remove="remove"
          v-for="(teacher, index) in paginateData"
          :key="teacher.id"
          :index="index"
          :teacher="teacher"
          class="odd:bg-gray-200 dark:odd:bg-dark-900"
        />
      </div>
    </div>
    <loader :loading="loading" />
    <Pagination-lists
      @prev-page="prevPage"
      @next-page="nextPage"
      @current-page="currentPage($event)"
      :data="teachers"
      :pag="this.pagination.pag"
      :page="this.pagination.page"
    />
  </div>
</template>

<script>
import { quillEditor } from "vue-quill-editor";
import TeacherTableItem from "./teacher-table-item.vue";
import Loader from "../loaders/loader.vue";
import Confirm from "../notificate/confirm.vue";
import UploadsImages from "../uploads/uploadsImages.vue";
import UploadImage from "../uploads/uploadImage.vue";
import UploadsDocs from "../uploads/uploadsDocs.vue";
import PaginationLists from "../pagination/pagination-lists.vue";
export default {
  components: {
    quillEditor,
    TeacherTableItem,
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
      teachers: [],
      pagination: {
        page: 0,
        pag: 9,
      },
      teacher: {
        index: null,
        id: null,
        name: null,
        title: null,
        description: null,
        role: "Преподаватель",
        education: "Высшее",
        images: [],
        documents: [],
        avatar: null,
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
      loading: false,
    };
  },
  created() {
    this.loading = true;
    try {
      this.getTeachers();
    } catch {
      this.loading = false;
    }
  },
  computed: {
    paginateData() {
      let start = this.pagination.page * this.pagination.pag;
      let end = start + this.pagination.pag;
      return this.teachers.slice(start, end);
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
    uploadImage(data) {
      this.teacher.avatar = data;
    },
    uploadImages(data) {
      this.teacher.images = data;
    },
    uploadDocs(data) {
      this.teacher.documents = data;
    },
    async getTeachers() {
      const response = await fetch(`${process.env.VUE_APP_ROOT_API}/teacher`, {
        method: "GET",
      });
      const teachers = await response.json();
      this.teachers = teachers;
      this.loading = false;
    },
    update(id, name, role, description, avatar, images, documents, education) {
      this.teacher.id = id;
      this.teacher.name = name;
      this.teacher.role = role;
      this.teacher.description = description;
      this.teacher.avatar = avatar;
      this.teacher.images = images;
      this.teacher.documents = documents;
      this.teacher.education = education;
      this.mode.edit = !this.mode.edit;
    },
    remove(id, name, index) {
      this.teacher.id = id;
      this.teacher.name = name;
      this.teacher.title = name;
      this.teacher.index = index;
      this.mode.delete = !this.mode.delete;
    },
    async teacherCreate() {
      const teacher = new FormData();
      teacher.append("name", this.teacher.name);
      teacher.append("description", this.teacher.description);
      teacher.append("education", this.teacher.education);
      teacher.append("role", this.teacher.role);
      teacher.append("avatar", this.teacher.avatar);
      if (this.teacher.images != null) {
        for (let i = 0; i < this.teacher.images.length; i++) {
          teacher.append("images[" + i + "]", this.teacher.images[i]);
        }
      }
      if (this.teacher.documents != null) {
        for (let i = 0; i < this.teacher.documents.length; i++) {
          teacher.append("documents[" + i + "]", this.teacher.documents[i]);
        }
      }

      const myHeaders = new Headers();
      myHeaders.append("Authorization", `Bearer ${this.token}`);

      const response = await fetch(`${process.env.VUE_APP_ROOT_API}/teacher`, {
        method: "POST",
        body: teacher,
        headers: myHeaders,
      });

      const message = await response.json();
      if (message.status == true) {
        this.$toast.success(message.message);
      } else if (message.status == false) {
        this.$toast.error("Ошибка создания");
        this.response.status = message.status;
        this.response.errors = message.errors;
        this.response.color = "red";
      }

      if (message.status == true) {
        this.mode.create = !this.mode.create;
      }
    },

    async teacherUpdate(id) {
      console.log(this.teacher.images);
      console.log(this.teacher.documents);
      const teacher = new FormData();
      teacher.append("name", this.teacher.name);
      teacher.append("description", this.teacher.description);
      teacher.append("education", this.teacher.education);
      teacher.append("role", this.teacher.role);
      teacher.append("avatar", this.teacher.avatar);
      if (this.teacher.images != null) {
        for (let i = 0; i < this.teacher.images.length; i++) {
          teacher.append("images[" + i + "]", this.teacher.images[i]);
        }
      }
      if (this.teacher.documents != null) {
        for (let i = 0; i < this.teacher.documents.length; i++) {
          teacher.append("documents[" + i + "]", this.teacher.documents[i]);
        }
      }

      teacher.append("_method", "PATCH");

      const myHeaders = new Headers();
      myHeaders.append("Authorization", `Bearer ${this.token}`);
      const response = await fetch(
        `${process.env.VUE_APP_ROOT_API}/teacher/${id}`,
        {
          method: "POST",
          body: teacher,
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

    async removeTeacher(id, index) {
      const authHeaders = new Headers();
      authHeaders.append("Authorization", `Bearer ${this.token}`);
      const response = await fetch(
        `${process.env.VUE_APP_ROOT_API}/teacher/${id}`,
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
      this.teachers.splice(index, 1);
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