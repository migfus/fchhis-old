<template>
    <div v-if="$trans.content" class="card table-responsive">
        <div class="card-header">
            <h4 class="card-title"><strong>Transactions</strong></h4>

            <div class="card-tools">
                <div class="input-group input-group-sm">
                    <input v-model="$trans.query.search" type="text" name="table_search" class="form-control float-right"
                        placeholder="Search">
                    <div class="input-group-append">
                        <button type="submit" class="btn btn-default">
                            <i v-if="$trans.config.loading" class="fas fa-circle-notch fa-spin"></i>
                            <i v-else class="fas fa-search"></i>
                        </button>
                        <button class="btn btn-sm btn-info">
                            <i v-if="$trans.query.sort == 'ASC'" @click="$trans.query.sort = 'DESC'"
                                class="fas fa-sort-up"></i>
                            <i v-else @click="$trans.query.sort = 'ASC'" class="fas fa-sort-down"></i>
                        </button>
                    </div>
                </div>
            </div>

        </div>
        <div class="card-body">
            <table class="table table-hover text-nowrap">
                <thead>
                    <tr>
                        <th width="100">OR</th>
                        <th>Amount</th>
                        <th>Plan</th>
                        <th width="100">Date</th>
                        <!-- <th width="60">Action</th> -->
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="row in $trans.content.data">
                        <td>{{ row.or }}</td>
                        <td class="text-success text-bold">+{{ NumberAddComma(row.amount) }}</td>
                        <td class="text-bold">{{ `${row.plan_details.plan.name} (${row.pay_type.name})` }}</td>
                        <td class="">{{ moment(row.created_at).format('MMM D, YYYY HH:mm A') }}</td>
                        <td>
                            <!-- <button data-toggle="modal" data-target="#receipt-modal" @click="OpenReceipt(row)"
                                class="btn btn-warning btn-sm mr-1 float-right"><i class="fas fa-receipt"></i></button> -->
                        </td>
                    </tr>
                </tbody>
            </table>
            <div class='mt-3'>
                Total:
                <strong class="text-success">
                    {{
                        NumberAddComma(
                            $trans.content.data.reduce((accum, d) => {
                                return accum + Number(d.amount)
                            }, 0)
                        )
                    }}
                </strong>

                <button @click="ClientPrintTransaction(
                            $trans.content.data.map(m => { return [m.or, m.plan_details.plan.name, m.pay_type.name, m.amount, moment(m.created_at).format('MM/DD/YYYY HH:MM A')] }),
                            $auth.content.auth.name
                        )" class="btn btn-success btn-sm mr-1 float-right"><i
                        class="fa fa-arrow-down mr-2"></i>Download
                    Data</button>
            </div>
        </div>

    </div>
</template>


<script setup lang='ts'>
import { ref, onMounted, watch, onUnmounted } from 'vue'
import moment from 'moment'
import { useTransactionStore } from '@/store/@client/TransactionStore'
import { NumberAddComma } from '@/helpers/converter'
import { useAuthStore } from '@/store/auth/AuthStore'
import { throttle } from 'lodash'
import { ClientPrintTransaction } from '@/helpers/print'

const $trans = useTransactionStore();
const $auth = useAuthStore();

const data = ref(false);

onMounted(() => {
    $trans.GetAPI(1)
});
onUnmounted(() => {
    $trans.CancelAPI()
})

watch($trans.query, throttle(() => {
    $trans.GetAPI(1)
}, 1000));
</script>
