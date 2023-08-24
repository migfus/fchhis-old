<template>
    <div v-if="$stat.config.loading">
        <Carousel v-bind="config.bind" :breakpoints="config.breakpoints">

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
    <div v-else>
        <Carousel v-bind="config.bind" :breakpoints="config.breakpoints">

            <Slide v-for="(row, idx,) in $stat.content.userList" :key="row.name">

                <div class="info-box mb-0 mr-2" style="height: 100px">
                    <span :class="`info-box-icon elevation-1 bg-${row.color}`">
                        <i :class="`fas ${row.icon}`"></i>
                    </span>
                    <div class="info-box-content">
                        <span class="info-box-text text-bold">{{ row.name }}</span>
                        <span class="info-box-text text-bold">{{ row.count }}</span>
                        <!-- <span class="info-box-number card-loader-content" style="height: 1em">&nbsp;</span> -->
                    </div>
                </div>

            </Slide>

            <template #addons>
                <Navigation />
            </template>
        </Carousel>
    </div>
</template>

<script setup>
import { Carousel, Navigation, Slide } from 'vue3-carousel'
import 'vue3-carousel/dist/carousel.css'
import { useStatisticStore } from '@/store/dashboard/StatisticStore'

const $stat = useStatisticStore()

const config = {
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

function Ranking(i) {
    var j = i % 10,
        k = i % 100;
    if (j == 1 && k != 11) {
        return i + "st";
    }
    if (j == 2 && k != 12) {
        return i + "nd";
    }
    if (j == 3 && k != 13) {
        return i + "rd";
    }
    return i + "th";
}
</script>

<style scoped>
.ribbon-wrapper .ribbon {
    text-transform: unset;
}
</style>
