<template>
    <div class="card">
        <div class="card-header">
            <h3 class="card-title text-bold">Clients</h3>
        </div>

        <div class="card-body p-0">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Plan</th>
                        <th>Accumulated Transactions</th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="row in $user.content.agent_clients" :key="row.id">
                        <td>{{ row.name }}</td>
                        <td>{{ `${row.plan.name} (${row.pay_type.name})` }}</td>
                        <td>
                            {{ NumberAddComma(row.client_transactions_sum_amount ? '+' + row.client_transactions_sum_amount
                                : '0') }}
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>

    </div>
</template>

<script setup>
import { useUserDetailsStore } from '@/store/user/UserDetailStore'
import moment from 'moment'
import { NumberAddComma } from '@/helpers/converter'

const $user = useUserDetailsStore();
</script>
