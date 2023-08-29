<template>
    <div class="row">
        <!-- NOTE ADD/EDIT -->
        <EditForm v-if="$user.config.form == 'update'" />
        <ORForm v-if="$user.config.form == 'or'" />
        <AddForm v-if="$user.config.form == 'add'" />

        <!-- NOTE REPORT -->
        <!-- <ReportForm /> -->

        <UserSummary />

        <!-- NOTE SEARCH -->
        <SearchComponent />

        <!-- NOTE TABLE -->
        <!-- <TableComponent v-if="$user.config.tableView" /> -->

        <!-- NOTE MOBILE -->
        <MobileComponent />

        <!-- NOTE PAGINATION -->
        <PaginationComponent v-if="$user.content" />

    </div>
</template>

<script setup lang="ts">
import { useUsersStore } from '@/store/@staff/UsersStore'
// import { usePlanStore } from '@/store/system/plan'
import { onMounted } from 'vue';

import UserSummary from './contents/UserSummary.vue'
import AddForm from './forms/AddForm.vue'
import EditForm from './forms/EditForm.vue'
import SearchComponent from './search/SearchComponent.vue'
// import TableComponent from './contents/TableComponent.vue'
import MobileComponent from './contents/MobileComponent.vue'
import PaginationComponent from './components/PaginationComponent.vue'
// import ReportForm from './forms/ReportForm.vue'
import ORForm from './forms/ORForm.vue'

const $user = useUsersStore();
// const $plan = usePlanStore();

onMounted(() => {
    // $plan.GetAPI();
});
</script>
