<template>
    <div class="row">
        <div v-if="$stat.content" class="col-md-3 col-sm-6 col-12">
            <div class="info-box">
                <span class="info-box-icon bg-success"><i class="fas fa-child"></i></span>
                <div class="info-box-content">
                    <span class="info-box-text">Clients</span>
                    <span class="info-box-number">{{ $stat.content.clients }}</span>
                </div>

            </div>

        </div>

    </div>
</template>

<script setup>
import { onMounted, } from 'vue'
import { useStatisticStore } from '@/store/dashboard/StatisticStore'

const $stat = useStatisticStore();

onMounted(() => {
    $stat.GetAPI()
    console.log('summary cards onMOunted')
});

// onUnmounted(() => {
//   $stat.content = []
// });
</script>
