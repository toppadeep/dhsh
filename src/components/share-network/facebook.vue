<template>
  <span @click="facebookLink(url)">
    <i class="fab fa-facebook text-3xl text-black"></i>
  </span>
</template>

<script>
  import objectToGetParams from '../share-network/objectToGetParams';
  export default {
    name: 'facebook',
    components: {
    },
    methods: {
      facebookLink(url) {
        window.open(
          `https://www.facebook.com/sharer/sharer.php` +
            objectToGetParams({
              u: url
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