<template>
  <div class="toast-container p-3">
    <TransitionGroup name="fade">
      <ToastItem v-for="toast in store.getters.getToasts()" :message="toast.message" :type="toast.type" :key="Math.random()" />
    </TransitionGroup>
  </div>
</template>

<script>
import { inject, computed } from 'vue'
import ToastItem from "@/components/Toasts/ToastItem";

export default {
  name: "Toasts",
  components: {ToastItem},
  setup(){
    const store = inject('store')
    return { store }
  }
}
</script>

<style scoped>
.toast-container {
  position: absolute;
  bottom: 4rem;
  right: 0;
}
.fade-enter-active,
.fade-leave-active {
  transition: opacity 0.2s ease;
}

.fade-enter-from,
.fade-leave-to {
  opacity: 0;
}
</style>