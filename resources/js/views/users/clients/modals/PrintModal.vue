<template>
    <div class="modal fade" id="print-modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">

                <Form v-slot="{ errors }" :validation-schema="schema" validate-on-mount @submit="$user.PrintAPI()">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Print Date Range</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="username-input">Start Date</label>
                            <Field v-model="$user.query.start" name="start" type="date" class="form-control"
                                id="username-input" placeholder="Enter Date" />
                            <div class="mb-2 text-danger">
                                <ErrorMessage name="start" />
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="username-input">End Date</label>
                            <Field v-model="$user.query.end" name="end" type="date" class="form-control" id="username-input"
                                placeholder="Enter Date" />
                            <div class="mb-2 text-danger">
                                <ErrorMessage name="end" />
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button v-if="!$user.config.loading" @click="Print()" :disabled="Object.keys(errors).length != 0"
                            type="button" class="btn btn-success">
                            Print
                        </button>
                        <button v-else disabled type="button" class="btn btn-secondary">
                            <i class="fa fa-circle-notch fa-spin"></i>
                        </button>
                    </div>
                </Form>

            </div>
        </div>
    </div>
</template>

<script setup lang="ts">
import { useUsersStore } from '@/store/@staff/UsersStore'
import { useAuthStore } from '@/store/auth/AuthStore'
import { Form, Field, ErrorMessage, configure, } from 'vee-validate'
import * as Yup from 'yup'
import XLSX from 'xlsx';
import moment from 'moment'
import { NumberAddComma } from '@/helpers/converter'

const $user = useUsersStore();
const $auth = useAuthStore();

configure({
    validateOnInput: true,
})
const schema = Yup.object({
    start: Yup.date()
        .typeError('Invalid date format')
        .required('Start Date is required'),
    end: Yup.date()
        .typeError('Invalid date format')
        .required('End Date is required'),
})

async function Print(): void {
    $user.config.loading = true
    await $user.PrintAPI()
    $user.config.loading = false

    const xlsxDataConstruct = [
        ['Future Care and Helping Hands Insurance Services'],
        ['Clients Report', '', '', moment().format('MMM D, YYYY HH:mm A')],
        [`${moment($user.query.start).format('MMM D, YYYY')} - ${moment($user.query.end).format('MMM D, YYYY')}`],
        [],
        [$auth.content.auth.name],

        [
            'Name',
            'Username',
            'Email',
            'Plan',
            'Pay Type',
            'Address',
            'Total',
            `Amount payed on (${`${moment($user.query.start).format('MM/DD/YYYY')} - ${moment($user.query.end).format('MM/DD/YYYY')}`})`,
            'Due Date',
            'Agent',
            'Staff',
            'Registered'
        ],

        ...$user.contentReport.map(m => {
            return [
                m.name,
                m.username,
                m.email,
                m.info.plan.name,
                m.info.pay_type.name,
                m.info.address,
                m.client_transactions_sum_amount > 0 ? m.client_transactions_sum_amount : 0,
                'latest payed',
                m.info.due_at,
                m.info.agent.name,
                m.info.staff.name,
                moment(m.created_at).format('MM/DD/YYYY hh:mm A'),
            ]
        }),
        // @ts-ignore
        ['', '', '', '', '',
            'Total: ',
            $user.contentReport.reduce((a, b) => a + Number(b.client_transactions_sum_amount ?? 0), 0)
        ],
    ]

    const ws = XLSX.utils.aoa_to_sheet(xlsxDataConstruct);
    const wb = XLSX.utils.book_new();
    XLSX.utils.book_append_sheet(wb, ws, 'Sheet1');
    const xlsxData = XLSX.write(wb, { bookType: 'xlsx', type: 'binary' });
    const blob = new Blob([s2ab(xlsxData)], { type: 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet' });
    const tet = $user.contentReport.reduce((acc, b) => {
        // console.log(`type: ${typeof Number(b.client_transactions_sum_amount ?? 0)} value: ${Number(b.client_transactions_sum_amount ?? 0)}`)
        return acc + Number(b.client_transactions_sum_amount ?? 0)
    }, 0)

    // console.log('value: ', tet)
    saveExport(blob, `${moment().format('YYYY-MM-DD-HH-mm')}_FCHHIS_Clients_Report.xlsx`);
}

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
</script>
