<template>
  <nav class="main-header navbar navbar-expand navbar-white navbar-light">
    <div class="container-xl">

      <RouterLink :to="{ name: 'home' }" class="navbar-brand">
        <img src="https://fchhis.migfus20.com/images/logo.png" alt="AdminLTE Logo"
          class="brand-image img-circle elevation-1" style="opacity: .8">
        <span class="brand-text ml-1">FCHHIS</span>
      </RouterLink>

      <ul class="navbar-nav">
        <li v-for="row in pages" :key="row.name" class="nav-item d-none d-sm-inline-block">
          <RouterLink :to="{ name: row.link }" :class="`nav-link ${$route.name == row.link} ? 'active' : ''`">{{
            row.name }}</RouterLink>
        </li>
      </ul>

      <ul class="order-1 order-md-3 navbar-nav navbar-no-expand ml-auto">
        <UserDropDown />
      </ul>
    </div>


  </nav>
</template>

<script setup>
import { ref, computed, onMounted } from 'vue'
import { useRoute } from 'vue-router'

import { useAuthStore } from '@/store/auth/auth';
import UserDropDown from './UserDropDown.vue';

const $route = useRoute();
const $auth = useAuthStore();

const hiddenMenu = ref()

const isAdmin = computed(() => {
  if ($auth.auth.role == 2) {
    return [
      {
        name: 'TRANSACTIONS',
      },
      {
        name: 'All Transactions',
        icon: 'fa-list-ol',
        link: { name: 'transactions-all' }
      },
      {
        name: 'Agent Transactions',
        icon: 'fa-list-ol',
        link: { name: 'transactions-all' }
      },
      {
        name: 'Client Transactions',
        icon: 'fa-list-ol',
        link: { name: 'transactions-all' }
      },

      {
        name: 'USERS',
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
  return []
})

const menu = ref([
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
  // {
  //   name: 'Manager',
  //   icon: 'fa-user-friends',
  //   link: '/users/manager'
  // },
  // {
  //   name: 'Sales Agent',
  //   icon: 'fa-user-secret',
  //   link: '/users/agent'
  // },
  // {
  //   name: 'Staff',
  //   icon: 'fa-users',
  //   link: '/users/staff'
  // },
  // {
  //   name: 'Client',
  //   icon: 'fa-people-arrows',
  //   link: '/users/client'
  // },
  // ADMIN
  // {
  //   name: "ADMIN",
  // },
  // {
  //   name: 'Plans',
  //   icon: 'fa-clipboard-list',
  //   link: '/admin/plans'
  // },
  // {
  //   name: 'Transaction',
  //   icon: 'fa-wallet',
  //   link: '/admin/transactions'
  // },
  // {
  //   name: 'Referals',
  //   icon: 'fa-project-diagram',
  //   link: '/admin/referals'
  // },

  // SETTINGS
  {
    name: 'MY ACCOUNT',
  },
  {
    name: 'Account Settings',
    icon: 'fa-user-cog',
    link: { name: 'account-settings' },
  },
  {
    name: 'Security',
    icon: 'fa-shield-alt',
    link: { name: 'account-settings-security' },
  },

  // SETTINGS
  // {
  //   name: 'SETTINGS',
  // },
  // {
  //   name: 'System Settings',
  //   icon: 'fa-cog',
  //   link: '/settings/system',
  // },
  // {
  //   name: 'Backup',
  //   icon: 'fa-database',
  //   link: '/settings/backup',
  // },
  // {
  //   name: 'Logs',
  //   icon: 'fa-pen',
  //   link: '/settings/logs'
  // }
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

  // {
  //   name: 'FAQs',
  //   link: "faq"
  // },
]);

onMounted(() => {
  document.body.classList.add('layout-top-nav');
  document.body.classList.remove('sidebar-mini')
});

</script>

<style scoped>
.sidebar-dark-primary .nav-sidebar>.nav-item>.nav-link.active,
.sidebar-light-primary .nav-sidebar>.nav-item>.nav-link.active {
  background-color: var(--info);
  color: #fff;
}
</style>
