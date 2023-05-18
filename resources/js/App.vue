<template>
  <div v-if="$route.meta.sideBar" class="wrapper">
    <!-- NOTE HEADER -->
    <HeaderTemplate />

    <div class="content-wrapper">
      <!-- NOTE  BREADCRUMBS -->
      <BreadCrumbTemplate :fluid="true" />

      <!-- NOTE  PAGES -->
      <section class="content">
        <div class="container-fluid">
          <RouterView></RouterView>
        </div>
      </section>

    </div>

    <!-- NOTE FOOTER -->
    <FooterTemplate :fluid="true" />
  </div>

  <div v-else class="wrapper">
    <!-- NOTE HEADER -->
    <HeaderNoSideBar />

    <div class="content">
      <!-- NOTE  BREADCRUMBS -->
      <BreadCrumbTemplate :fluid="false" />

      <!-- NOTE  PAGES -->
      <section class="content">
        <div class="container">
          <RouterView></RouterView>
        </div>
      </section>

    </div>

    <!-- NOTE FOOTER -->
    <FooterTemplate :fluid="false" />
  </div>
</template>

<script setup>
import FooterTemplate from '@/template/footer/FooterTemplate.vue'
import HeaderTemplate from '@/template/header/HeaderTemplate.vue'
import HeaderNoSideBar from '@/template/header/HeaderNoSideBar.vue';
import BreadCrumbTemplate from '@/template/header/BreadCrumbTemplate.vue';
import { useRoute } from 'vue-router';
import { onMounted } from 'vue'
import { useAddressStore } from '@/store/system/address'
import { useTestStore } from '@/store/auth/test';

import "vue-toastification/dist/index.css";

const $route = useRoute();
const $address = useAddressStore();
const $test = useTestStore();

onMounted(() => {
  $address.GetAPI();
});
</script>
