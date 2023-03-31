<template>
  <section class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1>{{ $route.meta.title }}</h1>
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
  </section>
</template>
<script setup>
import { useRoute } from 'vue-router'

const $route = useRoute();
</script>

<style scoped>
a {
  color: var(--info)
}
</style>
