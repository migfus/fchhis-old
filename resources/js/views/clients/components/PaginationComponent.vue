<template>
  <div class="col-12">
    <div class="card">
      <div class="card-body">
        <Bootstrap5Pagination :data="$user.list" :limit="2" @pagination-change-page="$user.GetAPI"
          class="float-right mb-0" />
      </div>
    </div>
  </div>
</template>

<script setup>
import Bootstrap5Pagination from '@/components/Bootstrap5Pagination.vue';
import { useUserStore } from '@/store/users/users'

const $user = useUserStore();

</script>
