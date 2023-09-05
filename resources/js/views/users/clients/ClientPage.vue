<template>
    <div class="row">
        <!-- NOTE ADD/EDIT -->
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

import UserSummary from './contents/UserSummary.vue'
import AddForm from './forms/AddForm.vue'
import SearchComponent from './search/SearchComponent.vue'
import MobileComponent from './contents/MobileComponent.vue'
import PaginationComponent from './components/PaginationComponent.vue'


const $user = useUsersStore();
</script>
