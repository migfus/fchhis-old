<template>
  <span :class="`img-badge badge badge-left badge-${config.color}`">
    <i :class="`fas ${config.icon} pt-1`"></i>
  </span>
</template>

<script setup lang="ts">
import { computed } from 'vue'

const $props = defineProps({
  role: Number,
});
const config = computed(() => {
  switch ($props.role) {
    case 2:
      return { color: 'warning', icon: 'fa-crown' }
    case 3:
      return { color: 'warning', icon: 'fa-tasks' }
    case 4:
      return { color: 'info', icon: 'fa-hands-helping' }
    case 5:
      return { color: 'success', icon: 'fa-user-edit' }
    case 6:
      return { color: 'secondary', icon: 'fa-user' }
    case 0:
      return { color: 'danger', icon: 'fa-moon' }
    default:
      return { color: 'danger', icon: 'fa-ban' }
  }
});
</script>

<style scoped>
.img-badge {
  position: absolute;
  z-index: 100;
  left: 34px;
  top: 32px;
  width: 25px;
  height: 25px;
  border-radius: 50px
}
</style>
