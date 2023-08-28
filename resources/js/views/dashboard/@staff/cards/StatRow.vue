<template>
    <div class="row">

        <div v-if="$stat.content" class="col-12">
            <Carousel :breakpoints="config.breakpoints" class="box-shadow_">
                <Slide class="mr-2">

                    <div class="info-box mb-0">
                        <span class="info-box-icon bg-purple"><i class="fas fa-handshake"></i></span>
                        <div class="info-box-content text-left">
                            <span class="info-box-text">Total Agents</span>
                            <NumberComponent :data="$stat.content.agents" />
                        </div>
                    </div>

                </Slide>

                <Slide class="mr-2">
                    <div class="info-box mb-0">
                        <span class="info-box-icon bg-orange"><i class="fas fa-user-friends"></i></span>
                        <div class="info-box-content text-left">
                            <span class="info-box-text">Total Beneficiaries</span>
                            <NumberComponent :data="$stat.content.beneficiaries" />
                        </div>
                    </div>
                </Slide>

                <Slide class="mr-2">
                    <div class="info-box mb-0">
                        <span class="info-box-icon bg-info"><i class="fas fa-users"></i></span>
                        <div class="info-box-content text-left">
                            <span class="info-box-text">Total Clients</span>
                            <NumberComponent :data="$stat.content.total" />
                        </div>
                    </div>
                </Slide>

                <Slide class="mr-2">
                    <div class="info-box mb-0">
                        <span class="info-box-icon bg-success"><i class="fas fa-child"></i></span>
                        <div class="info-box-content text-left">
                            <span class="info-box-text">Created Clients</span>
                            <NumberComponent :data="$stat.content.clients" />
                        </div>
                    </div>
                </Slide>


                <Slide class="mr-2">
                    <div class="info-box mb-0">
                        <span class="info-box-icon bg-warning"><i class="fas fa-receipt"></i></span>
                        <div class="info-box-content text-left">
                            <span class="info-box-text">Month's Transactions</span>
                            <NumberComponent :data="$stat.content.total" />
                        </div>

                    </div>
                </Slide>

                <Slide class="mr-2">
                    <div class="info-box mb-0">
                        <span class="info-box-icon bg-secondary"><i class="fas fa-check-circle"></i></span>
                        <div class="info-box-content text-left">
                            <span class="info-box-text">Deceased/Claimed</span>
                            <NumberComponent :data="$stat.content.deceased" />
                        </div>
                    </div>
                </Slide>


            </Carousel>
        </div>

        <div v-else class="col-12">
            <Carousel :breakpoints="config.breakpoints">
                <Slide v-for="row in 6" :key="row" class="mb-2">
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
    </div>
</template>

<script setup lang="ts">
import { onMounted, onUnmounted } from 'vue'
import { useStatisticStore } from '@/store/@staff/StatisticStore'
import { Carousel, Navigation, Slide } from 'vue3-carousel'
import 'vue3-carousel/dist/carousel.css'

import NumberComponent from '../components/NumberComponent.vue'

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
        1280: {
            itemsToShow: 5.5,
            snapAlign: 'start',
        },
    }
};
const $stat = useStatisticStore();

onMounted(() => {
    $stat.GetAPI()
})
onUnmounted(() => {
    $stat.CancelAPI()
})
</script>

<style scoped>
/* .box-shadow_ {
    box-shadow:
        inset 11px 0px 10px -10px #ccc,
        inset 11px 0px 8px -10px #ccc;
    z-index: 100;
} */
</style>
