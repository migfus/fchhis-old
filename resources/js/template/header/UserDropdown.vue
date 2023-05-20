<template>
  <!-- <NotificationDropdown v-if="$auth.token" /> -->

  <li v-if="Object.keys($auth.content).length != 0" class="nav-item dropdown dropdown-menu-right">
    <a id="dropdownSubMenu1" href="#" class="nav-link dropdown-toggle pt-0" data-toggle="dropdown" aria-haspopup="true"
      aria-expanded="false">
      <img :src="$auth.content.auth.avatar || 'https://fchhis.migfus20.com/images/logo.png'" alt="avatar"
        class="brand-image img-circle elevation-3" style="opacity: 0.8; height: 40px;">
    </a>
    <ul aria-labelledby="dropdownSubMenu1" class="dropdown-menu border-0 shadow dropdown-menu-right">
      <li>
        <h6 class="dropdown-header">{{ $auth.content.auth.email }}</h6>
      </li>
      <li>
        <RouterLink :to="{ name: 'dashboard' }" class="dropdown-item">Dashboard</RouterLink>
      </li>
      <li>
        <RouterLink :to="{ name: 'account-settings' }" class="dropdown-item">Account Settings</RouterLink>
      </li>
      <li>
        <a href="#" class="dropdown-item" @click="Logout()">Logout</a>
      </li>
    </ul>
  </li>

  <li v-else class="nav-item dropdown dropdown-menu-right">
    <RouterLink :to="{ name: 'login' }" class="btn btn-info">
      Login
    </RouterLink>
  </li>
</template>

<script setup>
import { useAuthStore } from '@/store/auth/AuthStore';
import NotificationDropdown from './NotificationDropdown.vue';
import { useRouter } from 'vue-router'
import { useToast } from 'vue-toastification'

const $router = useRouter();
const $auth = useAuthStore();
const $toast = useToast();

function Logout() {
  $auth.content = {}
  $auth.token = ''

  $toast.success('Logout successful')
  $router.push({ name: 'login' })
  $router.push({ name: 'login' })
}
</script>

<style scoped>
.dropdown-toggle::after {
  display: none;
}
</style>
