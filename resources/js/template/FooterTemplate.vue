<template>
  <footer class="main-footer bg-light ">
    <section class="mt-5 pt-4 pb-4">
      <div :class="`pt-15 pb-20 ${$props.fluid ? 'container-fluid' : 'container'}`">
        <div class="row">
          <div class="col-lg-4 col-md-6">
            <div class="widget-about font-md mb-md-5 mb-lg-0">
              <div class="mb-2">
                <RouterLink :to="{ name: 'home' }"><img src="/images/logo.png" alt="logo" style="width: 70px">
                </RouterLink>
              </div>
              <h6 class="my-2 text-secondary">
                <strong>Address: </strong>2nd Floor, Facoma Bldg., P-12 Poblacion, Valencia City, Bukidnon
              </h6>
              <h6 class="my-2 text-secondary">

                <strong>Phone: </strong>0916-859-8192
              </h6>
              <h6 class="my-2 text-secondary">

                <strong>Email: </strong>futurecareandhelpinghandsinsuranceservices@gmail.com
              </h6>
            </div>
          </div>
          <div class="col-lg-2 col-md-3">
            <h5 class="mb-3">Pages</h5>
            <RouterLink :to="{ name: 'home' }">
              <h6 class="text-secondary">Home</h6>
            </RouterLink>
            <RouterLink :to="{ name: 'about' }">
              <h6 class="text-secondary">About</h6>
            </RouterLink>
            <RouterLink :to="{ name: 'contact' }">
              <h6 class="text-secondary">Contact</h6>
            </RouterLink>
            <RouterLink :to="{ name: 'faq' }">
              <h6 class="text-secondary">FAQs</h6>
            </RouterLink>
          </div>
          <div class="col-lg-2  col-md-3">
            <h5 class="mb-3">My Account</h5>
            <RouterLink :to="{ name: 'login' }">
              <h6 class="text-secondary">Login</h6>
            </RouterLink>
            <RouterLink :to="{ name: 'dashboard' }">
              <h6 class="text-secondary">Dashboard</h6>
            </RouterLink>
            <RouterLink :to="{ name: 'account-settings' }">
              <h6 class="text-secondary">Account Settings</h6>
            </RouterLink>
          </div>
          <div class="col-lg-4">
            <h5 class="mb-3">Install App</h5>

            <h6 class="text-secondary">From App Store or Google Play</h6>
            <h6 class="text-secondary">Coming Soon...</h6>

            <h5 class="mt-3">Follow Us</h5>
            <div class="">
              <a href="https://web.facebook.com/profile.php?id=100064257452834" target="_blank"
                class="mr-2 h5 text-secondary"><i class="fab fa-facebook-square"></i></a>
              <!-- <a href="#" class="mr-2 h5 text-secondary"><i class="fab fa-youtube"></i></a> -->
              <!-- <a href="#" class="mr-2 h5 text-secondary"><i class="fab fa-twitter"></i></a> -->
            </div>
          </div>
        </div>
      </div>
    </section>
    <div :class="fluid ? 'container-fluid' : 'container'">
      <div class="float-right d-none d-sm-block">
        <b>Version</b> 0.0.5
      </div>
      <strong>Copyright © 2023 </strong>Future Care and Helping Hands Insurance Services
    </div>


  </footer>
</template>

<script setup>
const $props = defineProps({
  fluid: {
    type: Boolean,
    default: false,
  }
});
</script>
