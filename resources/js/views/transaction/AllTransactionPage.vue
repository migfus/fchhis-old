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

import ResponsiveCard from './contents/ResponsiveCard.vue'
import PaginationComponent from './components/PaginationComponent.vue';
import SearchComponent from './search/SearchComponent.vue';

const $trans = useTransactionStore();

onMounted(() => {
  $trans.GetAPI()
});
</script>
