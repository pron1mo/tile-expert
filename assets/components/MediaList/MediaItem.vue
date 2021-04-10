<template>
  <div class="image card position-relative mx-2 my-4 shadow-sm position-relative">
    <div class="d-flex w-100 h-100 justify-content-center align-items-center position-absolute" :class="{spinner: data.isDeleting}">
      <div
          class="spinner-border text-light"
          :class="{
            'text-danger': data.isDeleting,
            'text-light': !data.isDeleting
          }"
          style="width: 3rem; height: 3rem;"
          role="status">
      </div>
    </div>
    <img :src="src" :data-id="id" alt="">
    <span @click="deleteFile(id)" class="badge rounded-pill bg-danger py-2 pill" role="button">
      <i class="bi bi-trash"></i>
    </span>
  </div>
</template>

<script>
import { inject, reactive } from 'vue'

export default {
  props: ['src', 'id'],
  name: "MediaItem",
  setup() {
    const store = inject('store')

    const data = reactive({
      isDeleting: false
    })

    const toggleIsDeleting = () => {
      data.isDeleting = !data.isDeleting
    }

    const deleteFile = (id) => {
      toggleIsDeleting()
      store.methods.removeFile(id)
      store.methods.deleteImage(id)
          .then(res => {
            store.methods.removeFile(res.data)
          })
          .catch(err => {
            store.methods.addToast('danger', err.response.data)
            toggleIsDeleting()
          })
    }

    return {store, data, deleteFile }
  }
}
</script>

<style scoped>
.image {
  width: 200px;
  height: 200px;
}
.spinner {
  background-color: rgba(0,0,0,.2);
  z-index: 25;
}
.pill {
  position: absolute;
  bottom: -0.75rem;
  right: -0.75rem;
  border: 5px white solid;
  z-index: 35;
}
img {
  z-index: 10;
}
</style>
