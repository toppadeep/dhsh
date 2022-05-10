<template>
  <span @click="emailLink(url, { subject, body })">
    <i class="fas fa-at text-3xl text-black"></i>
  </span>
</template>

<script>
import objectToGetParams from "../share-network/objectToGetParams";
export default {
  name: "email",
  methods: {
    emailLink(url, { subject, body }) {
      window.open(
        "mailto:" +
          objectToGetParams({
            subject,
            body: body || url,
          }),
        "__blank"
      );
    },
  },
  props: {
    url: {
      type: String,
      required: true,
    },
    subject: {
      required: false,
      type: String,
    },
    body: {
      required: false,
      type: String,
    },
  },
};
</script>