<template>
    <div class="col-12">
        <div class="small-box bg-success">
            <div class="inner">
                <h3>₱ {{ NumberAddComma($stat.content.transactionCount) }} </h3>
                <p>Monthly Income</p>
            </div>
            <div class="icon">
                <i class="fas fa-chart-line"></i>
            </div>
            <a href="#" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
        </div>
    </div>
</template>

<script setup>
import { useStatisticStore } from '@/store/dashboard/StatisticStore';
import { NumberAddComma } from '@/helpers/converter'

const $stat = useStatisticStore();
</script>
