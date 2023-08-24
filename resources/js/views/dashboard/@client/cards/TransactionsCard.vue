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
                            <i class="fas fa-search"></i>
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
                        <th width="60">Action</th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="row in $trans.content.data">
                        <td>{{ row.id }}</td>
                        <td class="text-success text-bold">+{{ NumberAddComma(row.amount) }}</td>
                        <td class="text-bold">{{ `${row.plan.name} (${row.pay_type.name})` }}</td>
                        <td class="">{{ moment(row.created_at).format('MMM D, YYYY HH:mm:ss') }}</td>
                        <td>
                            <button data-toggle="modal" data-target="#receipt-modal" @click="OpenReceipt(row)"
                                class="btn btn-warning btn-sm mr-1 float-right"><i class="fas fa-receipt"></i></button>
                        </td>
                    </tr>
                </tbody>
            </table>
            <div class='mt-3'>
                Total: <strong v-if="$trans.content.sumTransactions" class="text-success">
                    {{ NumberAddComma($trans.content.sum) }}
                </strong>

                <button data-toggle="modal" data-target="#receipt-modal" @click="Print()"
                    class="btn btn-success btn-sm mr-1 float-right">Print</button>
            </div>
            <!-- <div>
            To Pay: <strong class="text-orange">78,000.00</strong>
            </div> -->


        </div>
        <ReceiptModal v-if="data" :data="data" />

    </div>
</template>


<script setup lang='ts'>
import { ref, onMounted, watch } from 'vue'
import moment from 'moment'
import { useTransactionStore } from '@/store/@client/TransactionStore'
import { NumberAddComma } from '@/helpers/converter'
import { useTransactionReportStore } from '@/store/print/transactionReport'
import { useAuthStore } from '@/store/auth/AuthStore'
import { throttle } from 'lodash'
import XLSX from 'xlsx';

import ReceiptModal from '../modals/ReceiptModal.vue'

const $trans = useTransactionStore();
const $report = useTransactionReportStore();
const $auth = useAuthStore();

const data = ref(false);

function OpenReceipt(row) {
    console.log('OpenReceipt', { row })
    data.value = row
}

function Print(): void {
    const xlsxDataConstruct = [
        ['Future Care and Helping Hands Insurance Services'],
        ['Transaction Report', '', '', moment().format('MMM D, YYYY HH:mm A')],
        [],
        [$auth.content.auth.info.name],

        ['Plan Name', 'Plan Type', 'Amount', 'Date'],

        ...$trans.content.data.map(m => { return [m.plan.name, m.pay_type.name, m.amount, moment(m.created_at).format('MM/DD/YYYY HH:MM A')] }),

        ['', '', 'Total: ', NumberAddComma($trans.content.data.reduce((a, b) => Number(a.amount) + Number(b.amount)))],
    ]

    const ws = XLSX.utils.aoa_to_sheet(xlsxDataConstruct);
    const wb = XLSX.utils.book_new();
    XLSX.utils.book_append_sheet(wb, ws, 'Sheet1');
    const xlsxData = XLSX.write(wb, { bookType: 'xlsx', type: 'binary' });
    const blob = new Blob([s2ab(xlsxData)], { type: 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet' });
    saveExport(blob, 'report.xlsx');
};

// NOTE BLOB CONVERTER
function s2ab(s): ArrayBuffer {
    const buf = new ArrayBuffer(s.length);
    const view = new Uint8Array(buf);
    for (let i = 0; i < s.length; i++) {
        view[i] = s.charCodeAt(i) & 0xFF;
    }
    return buf;
};

function saveExport(blob: Blob, filename): void {
    const link = document.createElement('a');
    link.href = URL.createObjectURL(blob);
    link.download = filename;
    link.click();
}

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
