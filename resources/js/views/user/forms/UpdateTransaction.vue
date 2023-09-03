<template>
    <div class="card">
        <div class="card-header">
            <h3 class="card-title text-bold">Update Transaction</h3>
        </div>

        <div class="card-body">

            <Form v-slot="{ errors }" :validation-schema="schema" validate-on-mount @submit="$trans.StoreAPI()">
                <div class="text-secondary">
                    ID: {{ $trans.params.id }}
                </div>
                <div class="form-group">
                    <label for="exampleInputEmail1">OR</label>
                    <Field v-model="$trans.params.or" name="or" type="text" class="form-control" id="username-input"
                        placeholder="Enter OR Number" />
                    <div class="mb-2 text-danger">
                        <ErrorMessage name="or" />
                    </div>
                </div>
                <!--
                <div class="form-group">
                    <label>Agent</label>
                    <Field name="agent" as='select' v-model="$trans.params.agent_id" class="form-control">
                        <option v-for="row in $agent.content" :value="row.id">
                            {{ row.name }}
                        </option>
                    </Field>
                    <div class="mb-2 text-danger">
                        <ErrorMessage name="agent" />
                    </div>
                </div> -->

                <div class="form-group">
                    <label>Pay Type</label>
                    <Field name="payType" as='select' v-model="$trans.params.pay_type_id" class="form-control">
                        <option v-for="row in $payType.content" :value="row.id">
                            {{ row.name }}
                        </option>
                    </Field>
                    <div class="mb-2 text-danger">
                        <ErrorMessage name="payType" />
                    </div>
                </div>

                <div class="form-group">
                    <label>Pay Type</label>
                    <Field name="plan" as='select' v-model="$trans.params.plan_id" class="form-control">
                        <option v-for="row in $plan.content" :value="row.id">
                            {{ row.name }}
                        </option>
                    </Field>
                    <div class="mb-2 text-danger">
                        <ErrorMessage name="plan" />
                    </div>
                </div>

                <div class="form-group">
                    <label for="exampleInputEmail1">Amount</label>
                    <Field v-model="$trans.params.amount" name="amount" type="number" class="form-control"
                        id="username-input" placeholder="Enter Amount" />
                    <div class="mb-2 text-danger">
                        <ErrorMessage name="amount" />
                    </div>
                </div>

                <button @click="$trans.ResetParams()" class=" btn btn-sm btn-danger float-right"><i
                        class="fas fa-times mr-1"></i>Cancel</button>
                <button @click="$trans.UpdateAPI()" class="btn btn-sm btn-warning float-right mr-2">
                    <i class="fas fa-pen mr-1"></i>Update</button>
            </Form>
        </div>

    </div>
</template>

<script setup lang="ts">
import { useUserDetailTransactionStore } from '@/store/@staff/UserDetailTransactionStore'
import { useAgentStore } from '@/store/@staff/AgentStore'
import { onMounted } from 'vue'
import { Form, Field, ErrorMessage, configure, } from 'vee-validate'
import { usePayTypeStore } from '@/store/system/PayTypeStore'
import * as Yup from 'yup'
import { usePlanStore } from '@/store/system/PlanStore'
import { useRoute } from 'vue-router'

configure({
    validateOnInput: true,
})
const schema = Yup.object({
    agent: Yup.string().required('Username is Required'),
    or: Yup.string().required('OR is Required'),
    payType: Yup.string().required('Pay Type is required'),
    plan: Yup.string().required('Plan is required'),
    amount: Yup.string().required('Amount is required'),
})

const $trans = useUserDetailTransactionStore();
const $agent = useAgentStore();
const $payType = usePayTypeStore();
const $plan = usePlanStore();
const $route = useRoute();

onMounted(() => {
    $agent.GetAPI()
    $payType.GetAPI()
    $plan.GetAPI()
})
</script>
