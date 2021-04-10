<template>
  <div class="toast align-items-center show" :class="`bg-${type}`" role="alert" aria-live="assertive" aria-atomic="true">
    <div class="d-flex">
      <div class="toast-body text-white">
        {{ message }}
      </div>
    </div>
  </div>
</template>

<script>
export default {
  props: ['message', 'type'],
  name: "ToastItem"
}
</script>