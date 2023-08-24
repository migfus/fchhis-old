<template>
    <nav class="main-header navbar navbar-expand navbar-white navbar-light">
        <ul class="navbar-nav">
            <li class="nav-item">
                <a class="nav-link" data-widget="pushmenu" href="#" role="button" ref="hiddenMenu"><i
                        class="fas fa-bars"></i></a>
            </li>
            <li v-for="row in pages" :key="row.name" class="nav-item d-none d-sm-inline-block">
                <RouterLink :to="{ name: row.link }" class="nav-link">{{ row.name }}</RouterLink>
            </li>
        </ul>

        <ul class="order-1 order-md-3 navbar-nav navbar-no-expand ml-auto">
            <UserDropDown />
        </ul>
    </nav>

    <aside class="main-sidebar sidebar-dark-primary elevation-4">

        <RouterLink to="/" class="brand-link">
            <img src="/images/logo.png" alt="AdminLTE Logo" class="brand-image img-circle elevation-3" style="opacity: .8">
            <span class="brand-text ml-2">FCHHIS</span>
        </RouterLink>

        <div class="sidebar">
            <nav class="mt-2">
                <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">

                    <!-- <li v-for="row in menu" :key="row.name" :class="`${row.icon ? 'nav-item' : 'nav-header'}`">
                        <RouterLink v-if="row.icon" :to="row.link"
                            :class="`${$route.name == row.link.name ? 'active' : ''} nav-link`">
                            <i :class="`nav-icon fas ${row.icon}`"></i>
                            <p>
                                {{ row.name }}
                                <span v-if="row.span && $overdue.content.overdue" class="right badge badge-danger">{{
                                    $overdue.content.overdue }}</span>
                                <span v-if="row.span && $overdue.content.grace" class="right badge badge-warning">
                                    {{ Number($overdue.content.grace) - Number($overdue.content.overdue) }}
                                </span>
                            </p>
                        </RouterLink>
                        <div v-else> {{ row.name }}</div>
                    </li> -->

                    <!-- SECTION DASHBOARD -->
                    <li class="nav-header">
                        <div>DASHBOARD</div>
                    </li>

                    <li v-if="can('index', 'auth')" class="nav-item">
                        <RouterLink :to="{ name: 'dashboard' }"
                            :class="`${$route.name == 'dashboard' ? 'active' : ''} nav-link`">
                            <i class="nav-icon fas fa-table"></i>
                            <p>
                                Dashboard
                            </p>
                        </RouterLink>
                    </li>

                    <!-- SECTION AUTH -->
                    <li class="nav-header">
                        <div>MY ACCOUNT</div>
                    </li>

                    <li v-if="can('index', 'auth')" class="nav-item">
                        <RouterLink :to="{ name: 'account-settings' }"
                            :class="`${$route.name == 'account-settings' ? 'active' : ''} nav-link`">
                            <i class="nav-icon fas fa-user-cog"></i>
                            <p>
                                Account Settings
                            </p>
                        </RouterLink>
                    </li>

                </ul>
            </nav>
        </div>
    </aside>
</template>

<script setup lang="ts">
import { ref, computed, onMounted } from 'vue'
import { useRoute } from 'vue-router'
import UserDropDown from './UserDropdown.vue';
import { useAuthStore } from '@/store/auth/AuthStore';
import { useOverdueStore } from '@/store/users/OverdueStore';
import { string } from 'yup';
import { useAbility } from '@casl/vue'

const $route = useRoute();
const $auth = useAuthStore();
const $overdue = useOverdueStore()
const { can } = useAbility();

const hiddenMenu = ref()

const isAdmin = computed(() => {
    if ($auth.content.auth.role) {
        if ($auth.content.auth.role == 2) {
            return [
                {
                    name: 'TRANSACTIONS',
                },
                {
                    name: 'Transactions',
                    icon: 'fa-list-ol',
                    link: { name: 'transactions-all' }
                },
                // {
                //   name: 'Agent',
                //   icon: 'fa-list-ol',
                //   link: { name: 'transactions-all' }
                // },
                // {
                //   name: 'Client',
                //   icon: 'fa-list-ol',
                //   link: { name: 'transactions-all' }
                // },

                {
                    name: 'USERS',
                },
                {
                    name: 'Overdue',
                    icon: 'fa-exclamation-circle',
                    link: { name: 'users-overdue' },
                    span: { content: 1, color: 'danger' }
                },
                {
                    name: 'Users',
                    icon: 'fa-users',
                    link: { name: 'users-list' }
                },
                {
                    name: 'Roles',
                    icon: 'fa-tasks',
                    link: { name: 'users-roles' }
                },

                {
                    name: 'ADMIN',
                },
                {
                    name: 'Plans',
                    icon: 'fa-map-pin',
                    link: { name: 'plans' }
                },
            ]
        }
    }

    return []
})

const isStaff = computed(() => {
    if ($auth.content.auth.role) {
        if ($auth.content.auth.role == 5) {
            return [
                {
                    name: 'USERS',
                },
                {
                    name: 'Overdue',
                    icon: 'fa-exclamation-circle',
                    link: { name: 'users-overdue' },
                    span: { content: 1, color: 'danger' }
                },
                {
                    name: 'Clients',
                    icon: 'fa-users',
                    link: { name: 'users-clients' }
                },

                {
                    name: 'TRANSACTIONS',
                },
                {
                    name: 'Transactions',
                    icon: 'fa-receipt',
                    link: { name: 'transactions-all' }
                },
            ]
        }
    }
    return []
})

type menuInt = Array<{
    name: string
    icon?: string
    link?: { name: string }
    span?: { content: number, color: string }
}>


const menu = ref<menuInt>([
    // NOTE DASHBOARD
    {
        name: 'DASHBOARD',
    },
    {
        name: 'Dashboard',
        icon: 'fa-table',
        link: { name: 'dashboard' }
    },
    // USERS
    ...isAdmin.value,
    ...isStaff.value,
]);

const pages = ref([
    {
        name: 'Home',
        link: "home"
    },
    {
        name: 'About',
        link: "about"
    },
    {
        name: 'Contact',
        link: "contact"
    },
]);


onMounted(() => {
    document.body.classList.remove('layout-top-nav');
    document.body.classList.add('sidebar-mini')

    if ($auth.content.auth.role == 5 || $auth.content.auth.role == 2)
        $overdue.GetAPI()
});
</script>

<style scoped>
.sidebar-dark-primary .nav-sidebar>.nav-item>.nav-link.active,
.sidebar-light-primary .nav-sidebar>.nav-item>.nav-link.active {
    background-color: var(--info);
    color: #fff;
}
</style>
