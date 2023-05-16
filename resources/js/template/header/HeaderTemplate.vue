<template>
  <nav class="main-header navbar navbar-expand navbar-white navbar-light">



    <ul class="navbar-nav">
      <li class="nav-item">
        <a class="nav-link" data-widget="pushmenu" href="#" role="button" ref="hiddenMenu"><i class="fas fa-bars"></i></a>
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
      <img src="https://fchhis.migfus20.com/images/logo.png" alt="AdminLTE Logo"
        class="brand-image img-circle elevation-3" style="opacity: .8">
      <span class="brand-text ml-2">FCHHIS</span>
    </RouterLink>

    <div class="sidebar">

      <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">

          <li v-for="row in menu" :key="row.name" :class="`${row.icon ? 'nav-item' : 'nav-header'}`">
            <RouterLink v-if="row.icon" :to="row.link"
              :class="`${$route.name == row.link.name ? 'active' : ''} nav-link`">
              <i :class="`nav-icon fas ${row.icon}`"></i>
              <p>
                {{ row.name }}
                <span v-if="row.span" class="right badge badge-danger">{{ row.span.content }}</span>
              </p>
            </RouterLink>
            <div v-else> {{ row.name }}</div>
          </li>

        </ul>
      </nav>
    </div>
  </aside>
</template>

<script setup>
import { ref, computed, onMounted } from 'vue'
import { useRoute } from 'vue-router'
import NotificationDropdown from './NotificationDropdown.vue';
import UserDropDown from './UserDropDown.vue';
import { useAuthStore } from '@/store/auth/auth';

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
        name: 'Transactions',
        icon: 'fa-list-ol',
        link: { name: 'transactions-all' }
      },
      {
        name: 'Agent',
        icon: 'fa-list-ol',
        link: { name: 'transactions-all' }
      },
      {
        name: 'Client',
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

const isStaff = computed(() => {
  if ($auth.auth.role == 5) {
    return [
      {
        name: 'CLIENTS',
      },
      {
        name: 'Transactions',
        icon: 'fa-receipt',
        link: { name: 'transactions-all' }
      },
      {
        name: 'Overdue',
        icon: 'fa-exclamation-circle',
        link: { name: 'overdue' },
        span: { content: 1, color: 'danger' }
      },
      {
        name: 'Clients',
        icon: 'fa-users',
        link: { name: 'clients-list' }
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
  ...isStaff.value,
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
  document.body.classList.remove('layout-top-nav');
  document.body.classList.add('sidebar-mini')
});
</script>

<style scoped>
.sidebar-dark-primary .nav-sidebar>.nav-item>.nav-link.active,
.sidebar-light-primary .nav-sidebar>.nav-item>.nav-link.active {
  background-color: var(--info);
  color: #fff;
}
</style>
