<template>
  <div v-if="$user.config.loading" class="col-12">
    <!-- <Carousel v-bind="config.bind"  :breakpoints="config.breakpoints"> -->
    <Carousel :breakpoints="config.breakpoints">

      <Slide v-for="row in 10" :key="row" class="mb-2">
        <div class="info-box mb-0 mr-2 card-loader" style="height: 100px">
          <span :class="`info-box-icon elevation-1 card-loader-content`"></span>
          <div class="info-box-content">
            <span class="info-box-text card-loader-content mb-2" style="height: 1em">&nbsp;</span>
            <span class="info-box-number card-loader-content" style="height: 1em">&nbsp;</span>
          </div>
        </div>
      </Slide>

    </Carousel>
  </div>
  <div v-else class="col-12">
    <!-- <Carousel v-bind="config.bind" :breakpoints="config.breakpoints"> -->
    <Carousel :breakpoints="config.breakpoints">

      <Slide v-for="row in $user.counts" :key="row.name" class="mb-2">
        <div class="info-box mb-0 mr-2" style="height: 100px">
          <span :class="`info-box-icon elevation-1 bg-${row.color}`"><i :class="`fas ${row.icon}`"></i></span>
          <div class="info-box-content">
            <span class="info-box-text">{{ row.name }}</span>
            <span class="info-box-number">
              {{ row.count }}
            </span>
          </div>
        </div>
      </Slide>

      <template #addons>
        <Navigation />
      </template>
    </Carousel>
  </div>
</template>

<script setup lang="ts">
import { onMounted } from 'vue'
import { Carousel, Navigation, Slide } from 'vue3-carousel'
import 'vue3-carousel/dist/carousel.css'
import { useUsersStore } from '@/store/users/UsersStore'

const $user = useUsersStore()

const config = {
  autoplay: 10 * 1000,
  bind: {
    itemsToShow: 1,
    snapAlign: 'center',
  },
  breakpoints: {
    500: {
      itemsToShow: 1,
      snapAlign: 'center',
    },
    700: {
      itemsToShow: 3.5,
      snapAlign: 'center',
    },
    // 1024 and up
    1024: {
      itemsToShow: 4.5,
      snapAlign: 'start',
    },

    1360: {
      itemsToShow: 4.5,
      snapAlign: 'start',
    },

    1600: {
      itemsToShow: 6.5,
      snapAlign: 'start',
    },
  }
};

onMounted(() => {
  setTimeout(() => {
    $user.GetCount()
  }, 1);
});
</script>
