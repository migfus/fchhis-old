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
                <li v-if="$route.name == 'dashboard'"></li>
                <li v-else-if="$route.meta.auth" class="breadcrumb-item">
                  <RouterLink :to="{ name: 'dashboard' }">Dashboard</RouterLink>
                </li>
                <li v-else class="breadcrumb-item">
                  <RouterLink :to="{ name: 'home' }">Home</RouterLink>
                </li>
                <li v-if="$route.name != 'home'" class="breadcrumb-item active">{{ $route.meta.title }}</li>
              </ol>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>
</template>
<script setup lang="ts">
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
