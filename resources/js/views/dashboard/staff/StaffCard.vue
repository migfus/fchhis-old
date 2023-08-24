<template>
    <div>
        <div class="row">
            <div class="col-lg-2 col-sm-6 col-12">
                <div class="info-box">
                    <span class="info-box-icon bg-purple"><i class="fas fa-handshake"></i></span>
                    <div class="info-box-content">
                        <span class="info-box-text">Total Agents</span>
                        <span class="info-box-number">{{ $stat.content.agents }}</span>
                    </div>
                </div>
            </div>

            <div class="col-lg-2 col-sm-6 col-12">
                <div class="info-box">
                    <span class="info-box-icon bg-orange"><i class="fas fa-user-friends"></i></span>
                    <div class="info-box-content">
                        <span class="info-box-text">Total Beneficiaries</span>
                        <span class="info-box-number">{{ $stat.content.beneficiaries }}</span>
                    </div>
                </div>
            </div>

            <div class="col-lg-2 col-sm-6 col-12">
                <div class="info-box">
                    <span class="info-box-icon bg-info"><i class="fas fa-users"></i></span>
                    <div class="info-box-content">
                        <span class="info-box-text">Total Clients</span>
                        <span class="info-box-number">{{ $stat.content.total }}</span>
                    </div>
                </div>
            </div>

            <div class="col-lg-2 col-sm-6 col-12">
                <div class="info-box">
                    <span class="info-box-icon bg-success"><i class="fas fa-child"></i></span>
                    <div class="info-box-content">
                        <span class="info-box-text">Created Clients</span>
                        <span class="info-box-number">{{ $stat.content.clients }}</span>
                    </div>
                </div>
            </div>

            <div class="col-lg-2 col-sm-6 col-12">
                <div class="info-box">
                    <span class="info-box-icon bg-warning"><i class="fas fa-receipt"></i></span>
                    <div class="info-box-content">
                        <span class="info-box-text">Month's Transactions</span>
                        <span class="info-box-number">{{ NumberAddComma($stat.content.transactions) }}</span>
                    </div>

                </div>

            </div>

            <div class="col-lg-2 col-sm-6 col-12">
                <div class="info-box">
                    <span class="info-box-icon bg-secondary"><i class="fas fa-book-medical"></i></span>
                    <div class="info-box-content">
                        <span class="info-box-text">Deceased Clients</span>
                        <span class="info-box-number">{{ $stat.content.deceased }}</span>
                    </div>
                </div>
            </div>

        </div>

        <ClientsCard />
    </div>
</template>

<script setup>
import { useStatisticStore } from '@/store/dashboard/StatisticStore'
import { NumberAddComma } from '@/helpers/converter'

import ClientsCard from './ClientsCard.vue';

const $stat = useStatisticStore();
</script>
