<template>
  <div class="row">
    <SearchComponent />
    <ResponsiveCard />
    <PaginationComponent />
  </div>
</template>

<script setup>
import { onMounted } from 'vue';
import { useTransactionStore } from '@/store/transaction/transaction';

import ResponsiveCard from './ResponsiveCard.vue'
import PaginationComponent from './PaginationComponent.vue';
import SearchComponent from './SearchComponent.vue';

const $trans = useTransactionStore();

onMounted(() => {
  $trans.GetAPI()
});
</script>
