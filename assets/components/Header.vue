<template>
  <nav class="navbar navbar-dark bg-dark">
    <form @submit.prevent="store.methods.uploadImage()" class="container flex-nowrap needs-validation">
      <a class="navbar-brand">pron1mo-dev</a>
      <input class="form-control mx-5" v-model="url" type="url" placeholder="Введите URL изображения" aria-label="url" required>
      <button class="btn btn-success d-inline-flex align-items-center" type="submit" :disabled="isUploading" :class="{disabled: isUploading}">
        <span v-show="isUploading" class="spinner-border spinner-border-sm me-2" role="status" aria-hidden="true">
        </span>
          Загрузить
      </button>
    </form>
  </nav>
</template>

<script>
import { inject, computed } from 'vue'

export default {
  name: "Header",
  setup() {
    const store = inject('store')
    const url = computed({
      get() {
        return store.state.url
      },
      set(value) {
        store.methods.setUrl(value)
      }
    })
    const isUploading = computed(() => {
      return store.state.isUploading
    })
    return { url, store, isUploading }
  }
}
</script>
