<template>
    <div v-if="$trans.content" class="col-12">


        <div v-for="(row, idx,) in $trans.content.data"
            :class="`card mb-2 ${$trans.config.viewAll ? '' : 'collapsed-card'}`">
            <div class="card-header" style="cursor: pointer;">
                <div data-card-widget="collapse" ref="collapse-click">
                    <div class="row">
                        <div class="col-12 col-md-6 col-xl-4">
                            <span class="d-inline d-md-none float-right text-secondary">
                                {{ moment(row.created_at).format('MMM D YYYY') }}
                            </span>

                            <img v-if="row.client" :src="row.client.user.avatar" style="height: 3em;"
                                class="img-circle float-left mr-3 my-2">
                            <img v-else src="https://fchhis.migfus20.com/images/logo.png" style="height: 3em;"
                                class="img-circle float-left mr-3 my-2">


                            <div class="text-bold h5 mb-1"><span class="text-success">+{{ NumberAddComma(row.amount)
                            }}</span>
                            </div>
                            <div v-if="row.client">
                                {{ row.client.name }}
                            </div>
                            <div>Accumulated:
                                <strong v-if="row.client" class="text-info">
                                    {{ NumberAddComma(row.client.client_transactions_sum_amount) }}
                                </strong>
                            </div>
                        </div>
                        <div class="d-none d-md-inline col-md-6 col-xl-4">
                            <span class="d-inline d-xl-none float-right text-secondary">{{
                                moment(row.created_at).format('MMM D YYYY')
                            }}</span>
                            <div class="h5 mb-1">Plan: <strong>{{ row.plan.name }}</strong></div>
                            <div>Due Date: <strong>{{ row.client.due_at ? moment(row.client.due_at).format('MMM D, YYYY') :
                                'N/A'
                            }}</strong>
                            </div>
                            <div>Est. Bal. Due:
                                <strong v-if="row.client" class="text-danger">
                                    {{ NumberAddComma(PlanToPay(row.pay_type, row.plan) -
                                        row.client.client_transactions_sum_amount) }}
                                </strong>
                            </div>


                        </div>
                        <div class="d-none d-xl-inline col-12 col-md-6 col-xl-4">
                            <span class="float-right text-secondary"> {{ moment(row.created_at).format('MMM D YYYY') }}
                            </span>
                            <div class="h5 mb-1">OR:
                                <strong class="text-info">{{ row.or }}</strong>
                            </div>
                            <div v-if="row.staff">Staff: <strong>{{ row.staff.name }}</strong></div>
                            <div v-if="row.staff">Agent: <strong>{{ row.agent.name }}</strong></div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card-body">
                <div class="row mb-2">
                    <div class="col-12 col-md-6 col-lg-4 col-xl-3">
                        <div>Payment: <strong class="text-success">+{{ NumberAddComma(row.amount) }}</strong></div>
                        <div>Accumulated: <strong v-if="row.client" class="text-success">{{
                            NumberAddComma(row.client.client_transactions_sum_amount)
                        }}</strong></div>
                        <div>To Pay: <strong class="text-danger">{{ NumberAddComma(PlanToPay(row.pay_type, row.plan)) }}
                            </strong>
                        </div>
                        <hr class="mt-1" />


                    </div>
                    <div class="col-12 col-md-6 col-lg-4 col-xl-3">
                        <div>Payed By: <strong v-if="row.client" class="text-success">{{ row.client.name }}</strong></div>
                        <div>Username: <strong v-if="row.client">{{ row.client.user.username }}</strong></div>
                        <div>Email: <strong v-if="row.client">{{ row.client.user.email }}</strong></div>
                        <hr class="mt-1" />


                    </div>
                    <div class="col-12 col-md-6 col-lg-4 col-xl-3">
                        <div>Staff:
                            <strong v-if="row.staff" class="text-info"> {{ row.staff.name }} </strong>
                        </div>
                        <div>Agent:
                            <strong class="text-warning"> {{ row.agent.name }} </strong>
                        </div>
                        <div>Referal ID: <strong> {{ row.agent.id }} </strong> </div>
                        <!-- <div>Birth Day: <strong>[bla]</strong></div>
            <div>Birth Place: <strong>[bla]</strong></div> -->
                        <hr class="mt-1" />

                    </div>
                    <div class="col-12 col-md-6 col-lg-4 col-xl-3">
                        <div>Address: <strong>{{ CityIDToFullAddress(row.client.address_id) }}</strong></div>
                        <div>Spot Payment: <strong>{{ NumberAddComma(row.plan.spot_pay) }}</strong></div>
                        <div>Spot Service: <strong>{{ NumberAddComma(row.plan.spot_service) }}</strong></div>
                        <!-- <div>Contract Price: <strong>{{ NumberAddComma(row.plan.contract_price) }}</strong></div> -->
                        <hr class="mt-1" />
                    </div>
                </div>
                <div class="row">
                    <div class="col-12 col-md-6">
                        <div v-if="$auth.content.auth.id != row.staff_id" class="alert alert-light mb-2 p-1 px-2"
                            role="alert">
                            Accessable only by:
                            <strong v-if="row.staff">
                                {{ row.staff.name }}
                            </strong>
                        </div>
                    </div>
                    <div class="col-12 col-md-6">
                        <button v-if="$auth.content.auth.role == 2" @click="$trans.DestroyAPI(row.id, idx)"
                            class="btn btn-danger float-right">
                            <i class="fas fa-times mr-2"></i>Remove
                        </button>

                        <button v-if="$auth.content.auth.person.id == row.staff_id || $auth.content.auth.role == 2"
                            @click="$trans.Update(row)" class="btn btn-warning float-right mr-1">
                            <i class="fas fa-edit mr-1"></i> Edit
                        </button>
                        <button v-else class="btn btn-danger float-right mr-1" Disabled>
                            <i class="fas fa-ban mr-1"></i> You can't edit
                        </button>
                        <!-- {{ `Trans Staff ID: ${row.staff_id}` }}
            {{ `Auth Staff ID: ${$auth.auth.id}` }} -->

                        <RouterLink v-if="row.client" :to="`/user/${row.client.id}`"
                            class="btn btn-success float-right mr-1">
                            <i class="fas fa-info-circle mr-1"></i> Info
                        </RouterLink>

                        <button @click="Print(row)" class="btn btn-info float-right mr-1">
                            <i class="fas fa-print mr-1"></i> Print
                        </button>




                    </div>
                </div>

            </div>

        </div>

    </div>
</template>

<script setup>
import { useTransactionStore } from '@/store/transactions/TransactionStore'
import { NumberAddComma, PlanToPay, CityIDToFullAddress } from '@/helpers/converter'
import moment from 'moment'
import { useAuthStore } from '@/store/auth/AuthStore'
import { useReceiptStore } from '@/store/print/receipt'

const $trans = useTransactionStore();
const $auth = useAuthStore();
const $receipt = useReceiptStore();

function Print(row) {
    $receipt.Print({
        header: {
            date: moment().format('MMM D, YYYY HH:mm A'),
            or: '[or]',
            name: row.client.name
        },
        body: [
            {
                plan: row.plan.name,
                type: row.pay_type.name,
                amount: row.amount
            },
        ],
        footer: {
            payType: 'Cash on Hand',
            received: row.staff.name,
        }
    }
    )
}
</script>
