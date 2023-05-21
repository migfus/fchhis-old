<template>
  <div class="col-12">
    <div class="card">
      <div class="card-body">
        <Bootstrap5Pagination :data="$trans.content" :limit="2" @pagination-change-page="$trans.GetAPI"
          class="float-right mb-0" />
      </div>
    </div>
  </div>
</template>

<script setup>
import Bootstrap5Pagination from '@/components/Bootstrap5Pagination.vue';
import { useTransactionStore } from '@/store/transactions/TransactionStore'

const $trans = useTransactionStore();

</script>
