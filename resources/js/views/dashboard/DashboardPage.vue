<template>
    <div v-if="$auth.content">

        <!-- SECTION ADMIN -->
        <div v-if="$auth.content.auth.role == 2">
            <AdminPage v-if="$stat.content" />
        </div>

        <!-- SECTION AGENT -->
        <div v-else-if="$auth.content.auth.role == 4">
            <AgentCard v-if="$stat.content" />
        </div>

        <!-- SECTION STAFF -->
        <div v-else-if="$auth.content.auth.role == 5">
            <StaffCard v-if="$stat.content" />
        </div>

        <!-- SECTION CLIENT -->
        <div v-else>
            <ClientDashboard v-if="$stat.content" />
        </div>

    </div>
</template>

<script setup>
import { onMounted } from 'vue';
import { useStatisticStore } from '@/store/dashboard/StatisticStore'
import { useAuthStore } from '@/store/auth/AuthStore'

import ClientDashboard from './client/ClientPage.vue';
import AgentCard from './agent/AgentCard.vue';
import StaffCard from './staff/StaffCard.vue';
import AdminPage from './admin/AdminPage.vue';

const $stat = useStatisticStore();
const $auth = useAuthStore();

onMounted(() => {
    $stat.GetAPI();
});
</script>
