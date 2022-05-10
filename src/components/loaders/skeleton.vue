<template>
  <div class="flex w-full h-44 mb-5 skeleton"></div>
</template>

<script>
export default {};
</script>

<style >
.w {
  width: 300px;
}
.skeleton {
  display: inline-block;
  position: relative;
  overflow: hidden;
  background-color: #dddbdd;
}

.skeleton {
  background: #eee;
  background: linear-gradient(110deg, #ececec 8%, #f5f5f5 18%, #ececec 33%);
  border-radius: 5px;
  background-size: 200% 100%;
  animation: 1.5s shine linear infinite;
}

@keyframes shine {
  to {
    background-position-x: -200%;
  }
}
</style>