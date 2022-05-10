<template>
  <div class="flex flex-row flex-nowrap">
    <facebook class="ml-2" :url="url" />
    <email class="ml-2" :url="url" />
    <linked-in class="ml-2" :url="url" />
    <whats-app class="ml-2" :url="url" />
    <telegram class="ml-2" :url="url" />
  </div>
</template>

<script>
import Email from "../../components/share-network/email.vue";
import Facebook from "../../components/share-network/facebook.vue";
import LinkedIn from "../../components/share-network/linkedIn.vue";
import Telegram from "../../components/share-network/telegram.vue";
import WhatsApp from "../../components/share-network/whatsApp.vue";
export default {
  components: {
    Facebook,
    Email,
    LinkedIn,
    WhatsApp,
    Telegram,
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