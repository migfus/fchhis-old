<template>
  <Carousel>
    <Slide :wrapAround="true" snapAlign="center">
      <div class="p-5 bg-info text-white rounded w-100" style="font-family: 'Tilt Warp', cursive; height: auto">
        <h1>We Care Your Family Future</h1>
        <h4>Thank You & God Bless us All...</h4>
      </div>
    </Slide>

    <Slide :wrapAround="true" snapAlign="center">
      <div class="p-5 bg-info text-white rounded w-100" style="font-family: 'Tilt Warp', cursive;  height: auto">
        <h4>"I have told you these things, so that in me you may have peace. In this wolrd you will have trouble, But take
          heart, I have overcome the world"</h4>
        <h5>John 16:33</h5>
      </div>
    </Slide>

    <template #addons>
      <Navigation />
      <Pagination />
    </template>
  </Carousel>
</template>

<script setup>
import { Carousel, Navigation, Pagination, Slide } from 'vue3-carousel'

import 'vue3-carousel/dist/carousel.css'
</script>

<style scoped>
@import url('https://fonts.googleapis.com/css2?family=Tilt+Warp&display=swap');

.text-white {
  font-family: 'Tilt Warp', cursive !important;
}
</style>
