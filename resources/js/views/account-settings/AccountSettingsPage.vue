<template>
  <div class="row">

    <div class="col-12 col-lg-6 col-xl-4">

      <div class="card card-widget widget-user">
        <div class="widget-user-header text-white"
          style="background: url(https://adminlte.io/themes/v3/dist/img/photo1.png) center center; ">
          <h3 class="widget-user-username text-right">{{ $auth.content.auth.email }}</h3>
          <h5 class="widget-user-desc text-right">{{ RoleToDesc($auth.content.auth.role) }}</h5>
        </div>
        <div class="widget-user-image">
          <img data-toggle="modal" data-target="#avatar-modal" style="cursor: pointer" class="img-circle"
            :src="$auth.content.auth.avatar" alt="User Avatar">
        </div>
        <div class="card-footer pt-3">
          <div class="row">
            <div class="col-12">
              <button data-toggle="modal" data-target="#avatar-modal" class="btn btn-info float-right">Change
                Avatar</button>
            </div>
          </div>
        </div>
      </div> <!-- SECTION CARD -->

    </div> <!-- SECTION COL -->

    <div class="col-12 col-lg-6 col-xl-8">
      <div class="card card-primary card-outline card-outline-tabs">
        <div class="card-header p-0 border-bottom-0">
          <ul class="nav nav-tabs" id="custom-tabs-four-tab" role="tablist">
            <li class="nav-item">
              <a class="nav-link active" id="password-tab" data-toggle="pill" href="#notification" role="tab"
                aria-controls="notification" aria-selected="true">Change Password</a>
            </li>
          </ul>
        </div>
        <div class="card-body">
          <PasswordTab :active="true" id="password-tab" />
        </div>
      </div>
    </div> <!-- SECTION COL -->
  </div>
  <!-- <ChangeAvatarModal /> -->
  <UploadAvatarModal v-model="$auth.content.auth.avatar" @update="PostAPI" />
</template>

<script setup lang="ts">
import { useAuthStore } from '@/store/auth/AuthStore';
import { RoleToDesc } from '@/helpers/converter'

import PasswordTab from './tabs/PasswordTab.vue';
import UploadAvatarModal from '@/components/UploadAvatarModal.vue';
import axios from 'axios';

const $auth = useAuthStore();

async function PostAPI() {
  try {
    let { data } = await axios.post('/api/avatar', { file: $auth.content.auth.avatar })
    $auth.UpdateLocalStorage()
  }
  catch (e) {
    console.log({ e })
  }
}
</script>

<style scoped>
.card-primary.card-outline-tabs>.card-header a.active,
.card-primary.card-outline-tabs>.card-header a.active:hover {
  border-top: 3px solid var(--info);
}

a {
  color: #777
}
</style>
