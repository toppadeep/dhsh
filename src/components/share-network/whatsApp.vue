<template>
  <span @click="whatsappLink(url, title)">
    <i class="fab fa-whatsapp-square text-3xl text-black"></i>
  </span>
</template>

<script>
import objectToGetParams from "../share-network/objectToGetParams";
export default {
  name: "whatsapp",
  methods: {
    whatsappLink(url, separator, title) {
      window.open(
        "https://api.whatsapp.com/send" +
          objectToGetParams({
            text: title ? title + separator + url : url,
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
  data() {
    return {
      separator: "",
    };
  },
};
</script>