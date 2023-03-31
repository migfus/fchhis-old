<template>
  <li class="nav-item dropdown dropdown-menu-right">
    <a id="dropdownSubMenu1" href="#" class="nav-link dropdown-toggle pt-0" data-toggle="dropdown" aria-haspopup="true"
      aria-expanded="false">
      <img :src="$auth.auth.avatar" alt="admin@gmail.com" class="brand-image img-circle elevation-3"
        style="opacity: 0.8; height: 40px;">
    </a>
    <ul aria-labelledby="dropdownSubMenu1" class="dropdown-menu border-0 shadow dropdown-menu-right">
      <li>
        <h6 class="dropdown-header">{{ $auth.auth.email }}</h6>
      </li>
      <li>
        <RouterLink :to="{ name: 'account-settings' }" class="dropdown-item">Account Settings</RouterLink>
      </li>
      <li>
        <a href="#" class="dropdown-item" @click="$auth.Logout(true)">Logout</a>
      </li>
    </ul>
  </li>
</template>

<script setup>
import { useAuthStore } from '../../store/auth/auth';

const $auth = useAuthStore();

</script>

<style scoped>
.dropdown-toggle::after {
  display: none;
}
</style>
