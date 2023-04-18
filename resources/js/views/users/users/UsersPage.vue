<template>
  <div class="row">
    <!-- NOTE ADD/EDIT -->
    <EditForm v-if="$user.config.form == 'update'" />
    <AddForm v-else-if="$user.config.form" />

    <!-- NOTE REPORT -->
    <ReportForm />

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
import { useUserStore } from '@/store/users/users'

import UserSummary from './UserSummary.vue'
import AddForm from './AddForm.vue'
import EditForm from './EditForm.vue'
import SearchComponent from './SearchComponent.vue'
import TableComponent from './TableComponent.vue'
import MobileComponent from './MobileComponent.vue'
import PaginationComponent from './PaginationComponent.vue'
import ReportForm from './ReportForm.vue'

const $user = useUserStore();
</script>
