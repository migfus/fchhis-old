<template>
    <AddTransaction v-if="$trans.config.form == 'add'" />
    <UpdateTransaction v-if="$trans.config.form == 'update'" />

    <div class="card">
        <div class="card-header">
            <h3 class="card-title text-bold">Transactions</h3>
            <button @click="$trans.config.form = 'add'" class="btn btn-success btn-sm float-right">Add Transaction</button>
        </div>

        <div class="card-body p-0">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>Agent Name</th>
                        <th>Plan</th>
                        <th>Amount</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="row in $user.content.client_transactions" :key="row.id">
                        <td>{{ row.agent.name }}</td>
                        <td>
                            <img :src="row.plan_details.plan.avatar" style="height: 20px; width: 20px"
                                class="img-circle float-left mr-2">
                            {{ `${row.plan_details.plan.name} (${row.pay_type.name})` }}
                        </td>
                        <td class="text-success text-bold">
                            +{{ NumberAddComma(row.amount) }}
                        </td>
                        <td class="text-success text-bold">
                            <button @click="$trans.Update(row)" class="btn btn-warning btn-sm mr-2"><i
                                    class="fas fa-pen"></i></button>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>

        <div class="card-footer">
            <h3 class="card-title text-bold">Total: {{ NumberAddComma($user.content.client_transactions_sum_amount) }}</h3>
        </div>

    </div>
</template>

<script setup lang="ts">
import { useUserDetailsStore } from '@/store/@staff/UserDetailStore'
import moment from 'moment'
import { NumberAddComma } from '@/helpers/converter'
import { useUserDetailTransactionStore } from '@/store/@staff/UserDetailTransactionStore'

import AddTransaction from '../forms/AddTransaction.vue'
import UpdateTransaction from '../forms/UpdateTransaction.vue'

const $user = useUserDetailsStore();
const $trans = useUserDetailTransactionStore();
</script>
