<template>
  <div v-if="$route.meta.noNav" class="d-flex justify-content-center align-middle">
    <RouterView />
  </div>

  <div v-else class="wrapper">
    <!-- NOTE HEADER -->
    <HeaderTemplate />

    <div class="content-wrapper">
      <!-- NOTE  BREADCRUMBS -->
      <BreadCrumbTemplate />

      <!-- NOTE  PAGES -->
      <section class="content">
        <div class="container-fluid">
          <RouterView></RouterView>
        </div>
      </section>

    </div>

    <!-- NOTE FOOTER -->
    <FooterTemplate />
  </div>
</template>

<script setup>
import FooterTemplate from './template/FooterTemplate.vue'
import HeaderTemplate from './template/header/HeaderTemplate.vue'
import BreadCrumbTemplate from './template/BreadCrumbTemplate.vue';
import { useRoute } from 'vue-router';
import { onMounted } from 'vue'
import { useAddressStore } from '@/store/system/address'

import "vue-toastification/dist/index.css";

const $route = useRoute();
const $address = useAddressStore();

onMounted(() => {
  $address.GetAPI();
});
</script>
