<template>
  <div class="row">

    <div class="col-12 col-lg-6 col-xl-4">

      <div class="card card-widget widget-user">

        <div class="widget-user-header text-white"
          style="background: url(https://adminlte.io/themes/v3/dist/img/photo1.png) center center; ">
          <h3 class="widget-user-username text-right">{{ $auth.auth.email }}</h3>
          <h5 class="widget-user-desc text-right">{{ RoleToDesc($auth.auth.role) }}</h5>
        </div>
        <div class="widget-user-image">
          <img data-toggle="modal" data-target="#avatar-modal" style="cursor: pointer" class="img-circle"
            :src="$auth.auth.avatar" alt="User Avatar">
        </div>
        <div class="card-footer">
          <div class="row">
            <div class="col-sm-4 border-right">
              <div class="description-block">
                <h5 class="description-header">3,200</h5>
                <span class="description-text">Users</span>
              </div>

            </div>

            <div class="col-sm-4 border-right">
              <div class="description-block">
                <h5 class="description-header">13,000</h5>
                <span class="description-text">FOLLOWERS</span>
              </div>

            </div>

            <div class="col-sm-4">
              <div class="description-block">
                <h5 class="description-header">35</h5>
                <span class="description-text">PRODUCTS</span>
              </div>

            </div>

          </div>

        </div>
      </div>

    </div>

    <div class="col-12 col-lg-6 col-xl-8">
      <div class="card card-primary card-outline card-outline-tabs">

        <div class="card-header p-0 border-bottom-0">
          <ul class="nav nav-tabs" id="custom-tabs-four-tab" role="tablist">

            <!-- <li class="nav-item">
              <a class="nav-link active" id="password-tab" data-toggle="pill" href="#password" role="tab"
                aria-controls="password" aria-selected="true">Information</a>
            </li> -->

            <li class="nav-item">
              <a class="nav-link active" id="notification-tab" data-toggle="pill" href="#notification" role="tab"
                aria-controls="notification" aria-selected="true">Notification</a>
            </li>

            <li class="nav-item">
              <a class="nav-link" id="preference-tab" data-toggle="pill" href="#notification" role="tab"
                aria-controls="notification" aria-selected="true">Preference</a>
            </li>
            <!-- <li class="nav-item">
              <a class="nav-link" id="custom-tabs-four-profile-tab" data-toggle="pill" href="#custom-tabs-four-profile"
                role="tab" aria-controls="custom-tabs-four-profile" aria-selected="false">Profile</a>
            </li> -->
          </ul>
        </div>

        <div class="card-body">
          <NotificationTab :active="true" id="notification-tab" />
          <PreferenceTab :active="false" id="preference-tab" />
        </div>

      </div>
    </div>
  </div>
  <ChangeAvatarModal />
</template>

<script setup>
import { useAuthStore } from '@/store/auth/auth';
import NotificationTab from './tabs/NotificationTab.vue';
import PreferenceTab from './tabs/PreferenceTab.vue';
import { RoleToDesc } from '@/helpers/converter'
import ChangeAvatarModal from './modals/ChangeAvatarModal.vue';

const $auth = useAuthStore();
</script>

<style scoped>
.card-primary.card-outline-tabs>.card-header a.active,
.card-primary.card-outline-tabs>.card-header a.active:hover {
  border-top: 3px solid var(--info);
}
</style>
