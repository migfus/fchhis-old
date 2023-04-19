<template>
  <div class="row">
    <ResponsiveCard />
  </div>
</template>

<script setup>
import { onMounted } from 'vue';
import { useTransactionStore } from '@/store/transaction/transaction';

import ResponsiveCard from './ResponsiveCard.vue'

const $trans = useTransactionStore();

onMounted(() => {
  $trans.GetAPI()
});
</script>
