<template>
  <span @click="telegramLink(url, { title })">
    <i class="fab fa-telegram text-3xl text-black"></i>
  </span>
</template>

<script>
import objectToGetParams from "../share-network/objectToGetParams";
export default {
  name: "telegram",
  methods: {
    telegramLink(url, { title }) {
      window.open(
        "https://telegram.me/share/" +
          objectToGetParams({
            url: url,
            text: title,
          }),
        "__blank"
      );
    },
  },
  props: {
    url: {
      required: true,
      type: String,
    },
    title: {
      required: false,
      type: String,
    },
  },
};
</script>