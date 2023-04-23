<template>
  <section class="content-header">
    <div :class="$props.fluid ? 'container-fluid' : 'container'">
      <div class="card mb-0">
        <div class="card-body p-3">
          <div class="row mx-1">
            <div class="col-sm-6">
              <h4 class="mb-0">{{ $route.meta.title }}</h4>
            </div>
            <div class="col-sm-6">
              <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item">
                  <RouterLink :to="{ name: 'dashboard' }">Dashboard</RouterLink>
                </li>
                <li class="breadcrumb-item active">{{ $route.meta.title }}</li>
              </ol>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>
</template>
<script setup>
import { useRoute } from 'vue-router'

const $route = useRoute();
const $props = defineProps({
  fluid: {
    type: Boolean,
    default: false,
  }
});
</script>

<style scoped>
a {
  color: var(--info)
}
</style>
