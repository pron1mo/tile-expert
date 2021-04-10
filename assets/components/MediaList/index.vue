<template>
  <div class="container d-flex flex-column my-5 overflow-auto">
    <div class="card mb-2">
      <div class="card-body d-flex flex-wrap justify-content-around">
        <div class="spinner-border text-secondary" v-show="store.state.isLoading" style="width: 3rem; height: 3rem;" role="status">
          <span class="visually-hidden">Loading...</span>
        </div>
        <p class="mb-0" v-if="!store.state.isLoading && files.length === 0">Еще не загружено не одной картинки!</p>
        <MediaItem v-for="file in files" :src="file.src" :id="file.id" :key="file.id" />
      </div>
    </div>
    <p class="text-muted small mb-5">
      Все загружаемые изображения будут удалены с сервера через 2 часа после загрузки.
    </p>
  </div>
</template>

<script>
import {inject, onMounted, computed} from 'vue'
import MediaItem from "@/components/MediaList/MediaItem";

export default {
  name: "MediaList",
  components: {MediaItem},
  setup() {
    const store = inject('store')
    const files = computed(() => {
      return store.state.files;
    })
    onMounted(() => {
      store.methods.loadFiles()
    })

    return { store, files }
  }
}
</script>
