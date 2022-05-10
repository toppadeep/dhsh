<template>
  <div
    class="
      flex
      w-full
      bg-white
      dark:bg-dark-800
      px-4
      py-3
      items-center
      justify-start
      border-t border-gray-200
      sm:px-6
    "
  >
    <div class="flex-1 flex justify-between sm:hidden">
      <a
        :class="{ disable: links.prev == null }"
        @click.prevent="$emit('url', links.prev)"
        href="#"
        class="
          relative
          inline-flex
          items-center
          px-4
          py-2
          border border-gray-300
          text-sm
          font-medium
          rounded-md
          text-gray-700
          bg-white
          dark:bg-dark-900
          hover:bg-gray-50
        "
      >
        Назад
      </a>
      <a
        :class="{ disable: links.next == null }"
        @click.prevent="$emit('url', links.next)"
        href="#"
        class="
          ml-3
          relative
          inline-flex
          items-center
          px-4
          py-2
          border border-gray-300
          text-sm
          font-medium
          rounded-md
          text-gray-700
          bg-white
          dark:bg-dark-900
          hover:bg-gray-50
        "
      >
        Вперёд
      </a>
    </div>
    <div class="hidden sm:flex-1 sm:flex sm:items-center sm:justify-between">
      <div>
        <p class="text-sm">
          Сраница:
          <span class="font-bold"> {{ meta.current_page }}</span>
          Показано от:
          <span class="font-bold">{{ meta.from }}</span>
          до
          <span class="font-bold">{{ meta.to }}</span>
          из
          <span class="font-bold">{{ meta.total }}</span>
          Результата(ов)
        </p>
      </div>
      <div>
        <nav
          class="relative z-0 inline-flex rounded-md shadow-sm -space-x-px"
          aria-label="Pagination"
        >
          <a
            :class="{ disabled: links.prev == null }"
            @click.prevent="$emit('url', links.prev)"
            href="#"
            class="
              relative
              inline-flex
              items-center
              px-2
              py-2
              rounded-l-md
              border border-gray-300
              bg-white
              dark:bg-dark-900
              text-sm
              font-medium
              text-gray-500
              hover:bg-gray-50
            "
          >
            <i class="fa-solid fa-angle-left"></i>
          </a>
          <a
            v-for="link in meta.links.slice(1, -1)"
            :key="link.label"
            @click.prevent="$emit('url', link.url)"
            :class="{ active: link.active }"
            href="#"
            aria-current="page"
            class="
              bg-white
              dark:bg-dark-900
              border-gray-300
              text-gray-500
              hover:bg-gray-50
              relative
              inline-flex
              items-center
              px-4
              py-2
              border
              text-sm
              font-medium
            "
          >
            {{ link.label }}
          </a>
          <a
            :class="{ disabled: links.next == null }"
            @click.prevent="$emit('url', links.next)"
            href="#"
            class="
              relative
              inline-flex
              items-center
              px-2
              py-2
              rounded-r-md
              border border-gray-300
              bg-white
              dark:bg-dark-900
              text-sm
              font-medium
              text-gray-500
              hover:bg-gray-50
            "
          >
            <i class="fa-solid fa-angle-right"></i>
          </a>
        </nav>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  props: {
    meta: {
      type: Object,
      default: () => {},
    },
    links: {
      type: Object,
      default: () => {},
    },
  },
};
</script>

<style scoped>
.active {
  @apply z-10 bg-gray-200 dark:bg-dark-800 border-gray-500 text-gray-500 dark:text-white relative inline-flex items-center px-4 py-2 border text-sm font-medium;
}
</style>