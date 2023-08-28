<template>
    <div v-if="$auth.content">

        <!-- SECTION ADMIN -->
        <div v-if="$auth.content.auth.role == 2">
            <!-- <AdminPage v-if="$stat.content" /> -->
        </div>

        <!-- SECTION AGENT -->
        <div v-else-if="$auth.content.auth.role == 4">
            <!-- <AgentCard v-if="$stat.content" /> -->
        </div>

        <!-- SECTION STAFF -->
        <div v-else-if="RoleToDesc($auth.content.role) == 'Staff'">
            <StaffPage />
        </div>

        <!-- SECTION CLIENT -->
        <div v-else>
            <ClientPage />
        </div>

    </div>
</template>

<script setup>
import { onMounted } from 'vue';
// import { useStatisticStore } from '@/store/dashboard/StatisticStore'
import { useAuthStore } from '@/store/auth/AuthStore'
import { RoleToDesc } from '@/helpers/converter'

import ClientPage from './@client/ClientPage.vue';
import StaffPage from './@staff/StaffPage.vue';

import AgentCard from './agent/AgentCard.vue';
import AdminPage from './admin/AdminPage.vue';

// const $stat = useStatisticStore();
const $auth = useAuthStore();

onMounted(() => {
    // $stat.GetAPI();
});
</script>
