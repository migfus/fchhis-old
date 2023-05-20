<template>
  <div class="row">
    <!-- NOTE ADD/EDIT -->
    <!-- <EditForm v-if="$user.config.form == 'update'" />
    <ORForm v-else-if="$user.config.form == 'or'" /> -->
    <AddForm v-if="$user.config.form == 'add'" />

    <!-- NOTE REPORT -->
    <!-- <ReportForm /> -->

    <!-- <UserSummary /> -->

    <!-- NOTE SEARCH -->
    <SearchComponent />

    <!-- NOTE TABLE -->
    <!-- <TableComponent v-if="$user.config.tableView" /> -->

    <!-- NOTE MOBILE -->
    <MobileComponent />

    <!-- NOTE PAGINATION -->
    <!-- <PaginationComponent /> -->

  </div>
</template>

<script setup>
// import { useUserStore } from '@/store/users/users'
// import { usePlanStore } from '@/store/system/plan'
import { onMounted } from 'vue';

// import UserSummary from './contents/UserSummary.vue'
import AddForm from './forms/AddForm.vue'
// import EditForm from './forms/EditForm.vue'
import SearchComponent from './search/SearchComponent.vue'
// import TableComponent from './contents/TableComponent.vue'
import MobileComponent from './contents/MobileComponent.vue'
// import PaginationComponent from './components/PaginationComponent.vue'
// import ReportForm from './forms/ReportForm.vue'
// import ORForm from './forms/ORForm.vue'

// const $user = useUserStore();
// const $plan = usePlanStore();

onMounted(() => {
  // $plan.GetAPI();
});
</script>
