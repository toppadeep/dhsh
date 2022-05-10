<template>
  <div id="app" class="bg-white dark:bg-dark-800 text-black dark:text-white">
    <router-view :key="$route.path"></router-view>
  </div>
</template>

<style>
#app {
  font-family: "Nunito", sans-serif;
  font-display: optional;
  -webkit-font-smoothing: antialiased;
  -moz-osx-font-smoothing: grayscale;
}
</style>
