<template>
    <Transition name="slide-fade">
        <div class="col-12">
            <div class="card card-warning">
                <div class="card-header">
                    <h3 class="card-title"><strong>Update Transaction</strong></h3>
                </div>
                <div class="card-body">
                    <Form v-slot="{ errors }" :validation-schema="schema" validate-on-mount
                        @submit="$trans.UpdateAPI($trans.params.id)">
                        <div class="row">

                            <div class="col-12 col-md-6">

                                <div class="form-group">
                                    <label>Client</label>
                                    <div class="mb-2">
                                        <img :src="$trans.params.client.user.avatar" style="height: 3em;"
                                            class="img-circle float-left mr-3 my-2">
                                        <span class="">
                                            {{ $trans.params.client.name }}
                                        </span>
                                    </div>
                                    <Field v-model="$trans.params.client.id" name="client_id" type="hidden" />
                                    <div class="mb-2 text-danger">
                                        <ErrorMessage name="client_id" />
                                    </div>
                                </div>

                            </div>

                            <div class="col-12 col-md-6">

                                <div class="form-group">
                                    <label for="or-input">OR Number (Auto regenerate if empty)</label>
                                    <Field v-model="$trans.params.or" name="or" type="text" class="form-control"
                                        id="or-input" placeholder="Optional" :disabled="$trans.params.agent.id == ''" />
                                    <div class="mb-2 text-danger">
                                        <ErrorMessage name="or" />
                                    </div>
                                </div>


                                <div class="form-group">
                                    <label>Plan</label>
                                    <select v-model="$trans.params.plan" @click="SelectPlan()" class="form-control"
                                        :disabled="$trans.params.agent.id == ''">
                                        <option v-for="row in $plan.content" :value="row">{{ row.name }}</option>
                                    </select>
                                </div>


                                <div class="form-group">
                                    <label>Payment Type</label>
                                    <select v-model="$trans.params.pay_type_id" @click="SelectPlan()" class="form-control"
                                        :disabled="$trans.params.agent.id == ''">
                                        <option v-for="row in $payType.content" :value="row.id">{{ row.name }}</option>
                                    </select>
                                </div>


                                <div class="form-group">
                                    <label for="mid-input">Amount</label>
                                    <Field v-model="$trans.params.amount" name="amount" type="text" class="form-control"
                                        id="mid-input" placeholder="Enter Amount"
                                        :disabled="$trans.params.agent.id == ''" />
                                    <div class="mb-2 text-danger">
                                        <ErrorMessage name="amount" />
                                    </div>
                                </div>


                            </div>
                        </div>


                        <button @click="$trans.ChangeForm('')" class="btn btn-danger float-right">Cancel</button>
                        <button type="submit" class="btn btn-warning float-right mr-1"
                            :disabled="Object.keys(errors).length != 0">Update</button>
                    </Form>
                </div>

            </div>

        </div>

    </Transition>
</template>

<script setup>
import { onMounted } from 'vue'
import { Form, Field, ErrorMessage, configure, } from 'vee-validate'
import * as Yup from 'yup'
import { usePlanStore } from '@/store/system/PlanStore'
import { usePayTypeStore } from '@/store/system/PayTypeStore'
import { useAgentStore } from '@/store/users/AgentStore'
import { useTransactionStore } from '@/store/transactions/TransactionStore'
import { PlanToAmount } from '@/helpers/converter'
import { useUsersStore } from '@/store/users/UsersStore'

const $plan = usePlanStore();
const $payType = usePayTypeStore();
const $agent = useAgentStore();
const $trans = useTransactionStore();
const $user = useUsersStore();

configure({
    validateOnInput: true,
})

function SelectPlan() {
    $trans.params.amount = PlanToAmount($trans.params.pay_type_id, $trans.params.plan)
}

const schema = Yup.object({
    client_id: Yup.string().required('Client is Needed'),
    or: Yup.string().required('OR Number is required'),
    amount: Yup.string().required('Amount is required'),
})

onMounted(() => {
    $payType.GetAPI()
    $plan.GetAPI()
});
</script>

<style scoped>
.slide-fade-enter-active {
    transition: all 0.3s ease-out;
}

.slide-fade-leave-active {
    transition: all 0.1s cubic-bezier(1, 0.5, 0.8, 1);
}

.slide-fade-enter-from,
.slide-fade-leave-to {
    transform: translateY(-20px);
    opacity: 0;
}

.separator {
    display: flex;
    align-items: center;
    text-align: center;
}

.separator::before,
.separator::after {
    content: '';
    flex: 1;
    border-bottom: 1px solid #c5cdd4;
}

.separator:not(:empty)::before {
    margin-right: .25em;
}

.separator:not(:empty)::after {
    margin-left: .25em;
}
</style>
