<template>
  <div class="row">
    <!-- NOTE ADD/EDIT -->
    <FormComponent />

    <UserSummary />

    <!-- NOTE SEARCH -->
    <SearchComponent />

    <!-- NOTE TABLE -->
    <TableComponent v-if="$user.config.tableView" />

    <!-- NOTE MOBILE -->
    <MobileComponent v-else />

    <!-- NOTE PAGINATION -->
    <PaginationComponent />

  </div>
</template>

<script setup>
import { useUserStore } from '@/store/users'

import UserSummary from './UserSummary.vue'
import FormComponent from './FormComponent.vue'
import SearchComponent from './SearchComponent.vue'
import TableComponent from './TableComponent.vue'
import MobileComponent from './MobileComponent.vue'
import PaginationComponent from './PaginationComponent.vue'

const $user = useUserStore();
</script>
