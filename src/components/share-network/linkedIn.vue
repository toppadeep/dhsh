<template>
  <span @click="linkedinLink(url)">
    <i class="fab fa-linkedin text-3xl text-black"></i>
  </span>
</template>

<script>
import objectToGetParams from "../share-network/objectToGetParams";
  export default {
    name: 'Linkedin',
    methods: {
      linkedinLink(url) {
        window.open(
          'https://linkedin.com/shareArticle' +
            objectToGetParams({
              mini: true,
              url: url
            }),
          '__blank'
        );
      }
    },
    props: {
      url: {
        required: true,
        type: String
      },
    }
  };
</script>