<template>
  <div class="row">

    <div class="col-md-4">

      <div class="card card-widget widget-user">

        <div class="widget-user-header text-white"
          style="background: url('https://adminlte.io/themes/v3/dist/img/photo1.png') center center;">
          <h3 class="widget-user-username text-right">Elizabeth Pierce</h3>
          <h5 class="widget-user-desc text-right">Web Designer</h5>
        </div>
        <div class="widget-user-image">
          <img class="img-circle" :src="$auth.auth.avatar" alt="User Avatar">
        </div>
        <div class="card-footer">
          <div class="row">
            <div class="col-sm-4 border-right">
              <div class="description-block">
                <h5 class="description-header">3,200</h5>
                <span class="description-text">SALES</span>
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

    <div class="col-8">
      <div class="card card-primary card-outline card-outline-tabs">

        <div class="card-header p-0 border-bottom-0">
          <ul class="nav nav-tabs" id="custom-tabs-four-tab" role="tablist">

            <li class="nav-item">
              <a class="nav-link active" id="password-tab" data-toggle="pill" href="#password" role="tab"
                aria-controls="password" aria-selected="true">Password</a>
            </li>

            <!-- <li class="nav-item">
              <a class="nav-link" id="custom-tabs-four-profile-tab" data-toggle="pill" href="#custom-tabs-four-profile"
                role="tab" aria-controls="custom-tabs-four-profile" aria-selected="false">Profile</a>
            </li> -->
          </ul>
        </div>

        <div class="card-body">
          <PasswordTab :active="true" />
        </div>

      </div>
    </div>
  </div>
</template>

<script setup>
import { useAuthStore } from '../../store/auth/auth';

const $auth = useAuthStore();
</script>
