<template>
  <Header />
  <MediaList />
  <Toasts />
  <Footer />
</template>

<script>
import { provide } from  'vue'
import store from '@/store'
import Header from "@/components/Header";
import Footer from "@/components/Footer";
import MediaList from "@/components/MediaList";
import Toasts from "@/components/Toasts";

export default {
  name: "App",
  components: {Toasts, Footer, Header, MediaList},
  setup(){
    provide('store', store)

  }
}
</script>
