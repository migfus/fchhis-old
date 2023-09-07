<template>
    <div class="card card-widget widget-user">
        <!-- <div v-if="$user.content.fulfilled_at" class="ribbon-wrapper">
            <div class="ribbon bg-secondary">
                Claimed
            </div>
        </div> -->

        <!-- <div v-if="$user.content.fulfilled_at" class="widget-user-header text-white bg-secondary"
            style="background: #375459;">
            <h3 class="widget-user-username text-right">
                {{ $user.content.name }}
            </h3>
            <h5 class="widget-user-desc text-right">{{ $user.content.user.email }}</h5>
        </div> -->
        <div class="widget-user-header text-white"
            style="background: url('https://adminlte.io/themes/v3/dist/img/photo1.png') center center;">
            <h3 class="widget-user-username text-right">
                {{ $user.content.name }}
            </h3>
            <h5 class="widget-user-desc text-right">{{ $user.content.email }}</h5>
        </div>
        <div class="widget-user-image">
            <img class="img-circle" :src="$user.content.avatar ?? '/images/logo.png'" alt="User Avatar">
        </div>
        <div class="card-footer">
            <div class="row">
                <div class="col-sm-3 border-right">
                    <div class="description-block">
                        <h5 class="description-header" style="text-transform: capitalize;">{{ $user.content.role }}</h5>
                    </div>

                </div>
                <div class="col-sm-3 border-right">
                    <div class="description-block">
                        <h5 class="description-header">{{ $user.content.info.plan_details.plan.name }}</h5>
                    </div>

                </div>

                <div class="col-sm-3">
                    <div class="description-block">
                        <h5 class="description-header text-danger">
                            {{
                                NumberAddComma(
                                    PlanToPay($user.content.info.pay_type, $user.content.info.plan_details) -
                                    $user.content.client_transactions_sum_amount)
                            }}
                        </h5>
                    </div>
                </div>

                <div class="col-sm-3">
                    <div class="description-block">
                        <h5 class="description-header text-success">
                            {{
                                NumberAddComma($user.content.client_transactions_sum_amount)
                            }}
                        </h5>
                    </div>
                </div>

                <div class="col-sm-3">
                    <div class="description-block">
                        <h5 class="description-header text-success">
                            Due on
                            {{ moment($user.content.info.due_at).format('MMM DD, YYYY') ?? 'N/A' }}
                        </h5>
                    </div>
                </div>
            </div>

        </div>
    </div>
</template>

<script setup>
import { NumberAddComma, PlanToPay } from '@/helpers/converter'
import { useUserDetailsStore } from '@/store/@staff/UserDetailStore'
import moment from 'moment'

import AppButton from '@/components/AppButton.vue'

const $user = useUserDetailsStore();
</script>
