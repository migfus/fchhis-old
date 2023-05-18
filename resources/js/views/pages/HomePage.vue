<template>
  <div class="row">
    <SliderComponent class="mb-3" />

    <PricingComponent />

    <div class="col-6 mb-2">
      <ul class="list-group">
        <li class="list-group-item">
          <h4>Burial Package</h4>
        </li>
        <li class="list-group-item">Casket</li>
        <li class="list-group-item">Casket Deocaration</li>
        <li class="list-group-item">Embalming</li>
        <li class="list-group-item">Flower</li>
        <li class="list-group-item">Tarpaulin</li>
        <li class="list-group-item">Viewing (7 Days Residence)</li>
        <li class="list-group-item">Free 25 Kilometers</li>
        <li class="list-group-item">Plus...</li>
      </ul>
    </div>

    <div class="col-6 mb-2">
      <ul class="list-group">
        <li class="list-group-item">
          <h4>Special Benefits</h4>
        </li>
        <li class="list-group-item">18-70 (Dependents) Jade/Beryl</li>
        <li class="list-group-item">Natural Death / Accidental Death -- 6,000</li>
        <li class="list-group-item">Burial Package Services -- 25,000</li>
      </ul>
    </div>


    <div class="col-12 mb-2">
      <ul class="list-group">
        <li class="list-group-item">
          <h4>Service Guaranteed</h4>
        </li>
        <li class="list-group-item">Villanueva Funeral Homes</li>
      </ul>
    </div>
  </div>
</template>

<script setup>
import SliderComponent from './component/SliderComponent.vue';
import PricingComponent from './component/PricingComponent.vue';
import { onMounted, onUnmounted } from 'vue'
import { useTestStore } from '@/store/auth/test';

const $test = useTestStore();

onMounted(() => {
  $test.GetAPI()
});
onUnmounted(() => {
  $test.CloseAPI()
});
</script>
