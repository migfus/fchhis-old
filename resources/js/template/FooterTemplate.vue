<template>
  <footer class="main-footer">
    <div :class="fluid ? 'container-fluid' : 'container'">
      <div class="float-right d-none d-sm-block">
        <b>Version</b> 0.0.5
      </div>
      <strong>Copyright © </strong>Future Care and Helping Hands Insurance Services
    </div>


  </footer>
</template>

<script setup>
const $props = defineProps({
  fluid: {
    type: Boolean,
    default: false,
  }
});
</script>
