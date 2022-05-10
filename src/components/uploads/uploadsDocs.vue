<template>
  <div
    class="flex flex-col flex-nowrap space-y-4 w-full h-full pl-2 pr-2 relative"
  >
    <form
      class="w-full h-44 bg-gray-100 border-2 border-dashed border-gray-300"
      @dragover="dragover"
      @dragleave="dragleave"
      @drop="drop"
    >
      <input
        type="file"
        multiple
        name="fields[assetsFieldHandle][]"
        id="assetsFieldHandle"
        class="w-px h-px opacity-0 overflow-hidden absolute"
        @change="uploadFiles()"
        ref="docs"
        accept=".pdf,.doc,.docx,.xsml"
      />
      <label for="assetsFieldHandle" class="flex justify-center items-center w-full h-full cursor-pointer">
        <div>
          Перетащите файлы сюда или
          <span class="underline"><i class="fa-solid fa-paperclip"></i></span>
          для загрузки файлов
        </div>
      </label>
      <ul class="mt-4" v-if="Files != null">
        <li class="text-sm p-1" v-for="(file, index) in Files" :key="index">
          {{ file.name
          }}<button
            class="ml-2"
            type="button"
            @click="removeFile(index)"
            title="Удалить документ"
          >
            Удалить
          </button>
        </li>
      </ul>
    </form>
    <div
      class="
        w-full
        flex
        p-5
        flex-col flex-nowrap
        items-start
        space-y-4
        rounded-lg
        bg-gray-200
        dark:bg-dark-800
      "
    >
      <div class="flex flex-row flex-nowrap justify-start items-start">
        <i class="fa-solid fa-circle-info text-yellow-400 mr-4"></i>
        <p>
          Перед загрузкой документов на сервер убедитесь, что название
          документа(ов) не слишком длинные. Оптимальная длина до 20 символов.
        </p>
      </div>
      <div class="flex flex-row flex-nowrap w-full">
        Поддерживаемые типы:
        <ul class="flex flex-row space-x-4 flex-nowrap font-bold list-none">
          <li>.pdf</li>
          <li>.doc</li>
          <li>.docx</li>
          <li>.xsml</li>
        </ul>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  data() {
    return {
      Files: [],
    };
  },
  methods: {
    uploadFiles() {
      this.Files = [...this.$refs.docs.files];
      this.$emit("uploadDocs", this.Files);
    },
    removeFile(i) {
      this.Files.splice(i, 1);
    },
    dragover(event) {
      event.preventDefault();
      // Add some visual fluff to show the user can drop its files
      if (
        event.currentTarget.classList.contains("bg-gray-100") ||
        event.currentTarget.classList.contains("bg-dark-900")
      ) {
        event.currentTarget.classList.remove("bg-gray-100");
        event.currentTarget.classList.add("bg-gray-300");
      }
    },
    dragleave(event) {
      // Clean up
      event.currentTarget.classList.add("bg-gray-100");
      event.currentTarget.classList.remove("bg-gray-300");
    },
    drop(event) {
      event.preventDefault();
      this.$refs.docs.files = event.dataTransfer.files;
      this.uploadFiles(); // Trigger the onChange event manually
      // Clean up
      event.currentTarget.classList.add("bg-gray-100");
      event.currentTarget.classList.remove("bg-gray-300");
    },
  },
};
</script>

<style>
</style>