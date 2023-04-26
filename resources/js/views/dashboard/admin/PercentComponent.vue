<template>
  <span v-if="GetPercentage(num1, num2) > 0" class="text-success">
    <i class="fas fa-arrow-up"></i>
    {{ GetPercentage(num1, num2) }}
    %
  </span>
  <span v-else class="text-info">
    <i class="fas fa-circle"></i>
    0.00 %
  </span>
</template>

<script setup>
import { GetPercentage } from '@/helpers/converter'
const $props = defineProps({
  num1: {
    type: Number,
    required: true,
  },
  num2: {
    type: Number,
    required: true,
  },
});
</script>
