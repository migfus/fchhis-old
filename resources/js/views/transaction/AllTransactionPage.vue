<template>
  <div class="row">
    <!-- <AddForm v-if="$trans.config.form == 'add'" /> -->
    <!-- <UpdateForm v-if="$trans.config.form == 'update'" /> -->

    <SearchComponent />
    <!-- <ResponsiveCard /> -->
    <!-- <PaginationComponent /> -->
  </div>
</template>

<script setup>
// import { onMounted } from 'vue';
import { useTransactionStore } from '@/store/transactions/TransactionStore';

// import ResponsiveCard from './contents/ResponsiveCard.vue'
// import PaginationComponent from './components/PaginationComponent.vue';
import SearchComponent from './search/SearchComponent.vue';
// import AddForm from './forms/AddForm.vue';
// import UpdateForm from './forms/UpdateForm.vue';

const $trans = useTransactionStore();
</script>
