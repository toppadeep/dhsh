<template>
  <div
    class="
      md:hidden
      flex
      w-11/12
      justify-around
      items-center
      bg-gray-200
      dark:bg-dark-900
      mt-5
      p-4
      rounded-lg
      fixed
      bottom-0
      z-50
    "
  >
    <span class="py-2 px-3 rounded-lg bg-gray-100 dark:bg-dark-800">
      <router-link to="/"><i class="fa-solid fa-house"></i></router-link>
    </span>
    <span class="py-2 px-3 rounded-lg bg-gray-100 dark:bg-dark-800">
      <router-link to="/posts"
        ><i class="fa-solid fa-newspaper"></i
      ></router-link>
    </span>
    <span class="py-2 px-3 rounded-lg bg-gray-100 dark:bg-dark-800">
      <router-link to="/cources"
        ><i class="fa-solid fa-graduation-cap"></i
      ></router-link>
    </span>
    <span class="py-2 px-3 rounded-lg bg-gray-100 dark:bg-dark-800">
      <router-link to="/parrent"
        ><i class="fa-solid fa-user-group"></i
      ></router-link>
    </span>
    <span class="py-2 px-3 rounded-lg bg-gray-100 dark:bg-dark-800">
      <router-link to="/posts"
        ><i class="fa-solid fa-user-graduate"></i
      ></router-link>
    </span>
    <span class="py-2 px-3 rounded-lg bg-gray-100 dark:bg-dark-800">
      <router-link to="/documents"
        ><i class="fa-solid fa-file"></i
      ></router-link>
    </span>
    <span class="py-2 px-3 rounded-lg bg-gray-100 dark:bg-dark-800">
      <router-link to="/about"
        ><i class="fa-solid fa-circle-info"></i
      ></router-link>
    </span>
  </div>
</template>

<script>
export default {};
</script>

<style>
</style>