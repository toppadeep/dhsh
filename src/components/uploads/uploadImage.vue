<template>
  <div
    class="flex flex-col flex-nowrap space-y-4 w-full h-full pl-2 pr-2 relative"
  >
    <div class="space-y-4" v-if="isUpload">
      <div
        class="
          flex flex-row flex-nowrap
          w-full
          justify-start
          items-center
          space-x-4
        "
      >
        <div v-if="cover != undefined" ref="cover" class="flex justify-start items-center w-44 h-44 relative bg-contain  rounded-lg bg-no-repeat">
          <div
            class="
              flex
              justify-center
              opacity-50
              hover:opacity-100
              cursor-pointer
              items-center
              absolute
              top-0
              right-0
              w-10
              h-10
              p-2
              rounded-md
              bg-white dark:bg-dark-900
            "
            @click="remove()"
          >
            <i class="fa-solid fa-trash"></i>
          </div>
        </div>
      </div>
    </div>
    <form
      class="w-full h-44 bg-gray-100 border-2 border-dashed border-gray-300"
      @dragover="dragover"
      @dragleave="dragleave"
      @drop="drop"
    >
      <input
      :disabled="cover != null"
        type="file"
        id="assetsFieldHandleImage"
        class="w-px h-px opacity-0 overflow-hidden absolute"
        @change="uploadFiles()"
        ref="image"
        accept=".jpg,.jpeg,.png"
      />
      <label for="assetsFieldHandleImage" class="flex justify-center items-center w-full h-full cursor-pointer">
        <div>
          Перетащите файл сюда или
          <span class="underline"><i class="fa-solid fa-paperclip"></i></span>
          для его загрузки
        </div>
      </label>
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
          Перед загрузкой изображения на сервер убедитесь, что формат имеет
          значение 16:9 или "Широкоформатное".
        </p>
      </div>
      <div class="flex flex-row flex-nowrap w-full">
        Поддерживаемые типы:
        <ul class="flex flex-row space-x-4 flex-nowrap font-bold list-none">
          <li>.jpg</li>
          <li>.png</li>
          <li>.jpeg</li>
        </ul>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  data() {
    return {
      cover: null,
      isUpload: false,
    };
  },
  methods: {
    uploadFiles() {
      this.cover = this.$refs.image.files[0];
      console.log(this.cover);
      this.isUpload = true;
      let is = this;
      if (this.cover != undefined) {
        let img = this.$refs.image.files[0];
        let preupload = new FileReader();
        preupload.readAsDataURL(img);
        let URL = "";
        preupload.onload = function () {
          URL = this.result.substring(this.result.indexOf(",") + 1);
          is.$refs["cover"].setAttribute("style", "background-image: url(data:image/png;base64," + URL + ")");
        };
      }
      
      this.$emit("uploadImage", this.cover);
    },
    remove() {
      this.isUpload = false;
      this.cover = null;
      this.$refs["cover"].removeAttribute("src");
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
      this.$refs.image.files = event.dataTransfer.files;
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