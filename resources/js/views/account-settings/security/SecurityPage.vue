<template>
  <div class="row">
    <div class="col-12">
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

          <!-- <div class="tab-content" id="custom-tabs-four-tabContent"> -->
          <!-- </div> -->
        </div>

      </div>
    </div>
  </div>
</template>

<script setup>
import PasswordTab from './PasswordTab.vue';


</script>

<style scoped>
.card-primary.card-outline-tabs>.card-header a.active,
.card-primary.card-outline-tabs>.card-header a.active:hover {
  border-top: 3px solid var(--info);
}
</style>
