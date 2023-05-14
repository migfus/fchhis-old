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
                  <div v-if="$trans.params.client.person.id" class="mb-2">
                    {{
                      FullNameConvert(
                        $trans.params.client.person.lastName,
                        $trans.params.client.person.firstName,
                        $trans.params.client.person.midName,
                        $trans.params.client.extName
                      )
                    }}
                  </div>
                  <div>
                    <button @click="SelectClient()" class="btn btn-success" data-toggle="modal"
                      data-target="#modal-client">
                      Select Client
                    </button>
                  </div>
                  <Field v-model="$trans.params.client.person.id" name="client_id" type="hidden" />
                  <div class="mb-2 text-danger">
                    <ErrorMessage name="client_id" />
                  </div>
                </div>

                <div class="form-group">
                  <label>Agent</label>
                  <div v-if="$trans.params.agent.person.id" class="mb-2">
                    {{
                      FullNameConvert(
                        $trans.params.agent.person.lastName,
                        $trans.params.agent.person.firstName,
                        $trans.params.agent.person.midName,
                        $trans.params.agent.extName
                      )
                    }}
                  </div>
                  <div>
                    <button @click="SelectAgent()" class="btn btn-info" data-toggle="modal"
                      data-target="#modal-agent">Select Agent</button>
                  </div>
                  <Field v-model="$trans.params.agent.person.id" name="agent_id" type="hidden" />
                  <div class="mb-2 text-danger">
                    <ErrorMessage name="agent_id" />
                  </div>
                </div>

              </div>

              <div class="col-12 col-md-6">

                <div class="form-group">
                  <label for="or-input">OR Number (Auto regenerate if empty)</label>
                  <Field v-model="$trans.params.or" name="or" type="text" class="form-control" id="or-input"
                    placeholder="Optional" :disabled="$trans.params.agent.person.id == ''" />
                  <div class="mb-2 text-danger">
                    <ErrorMessage name="or" />
                  </div>
                </div>


                <div class="form-group">
                  <label>Plan</label>
                  <select v-model="$trans.params.plan" @click="SelectPlan()" class="form-control"
                    :disabled="$trans.params.agent.person.id == ''">
                    <option v-for="row in $plan.content" :value="row">{{ row.name }}</option>
                  </select>
                </div>


                <div class="form-group">
                  <label>Payment Type</label>
                  <select v-model="$trans.params.pay_type_id" @click="SelectPlan()" class="form-control"
                    :disabled="$trans.params.agent.person.id == ''">
                    <option v-for="row in $payType.content" :value="row.id">{{ row.name }}</option>
                  </select>
                </div>


                <div class="form-group">
                  <label for="mid-input">Amount</label>
                  <Field v-model="$trans.params.amount" name="transaction" type="text" class="form-control" id="mid-input"
                    placeholder="Optional" :disabled="$trans.params.agent.person.id == ''" />
                </div>


              </div>
            </div>


            <button @click="$trans.Clear()" class="btn btn-danger float-right">Cancel</button>
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
import { usePlanStore } from '@/store/system/plan'
import { usePayTypeStore } from '@/store/system/payTypes'
import { useAgentStore } from '@/store/users/agent'
import { useTransactionStore } from '@/store/transaction/transaction'
import { FullNameConvert, PlanToAmount } from '@/helpers/converter'
import { useUserStore } from '@/store/users/users'

const $plan = usePlanStore();
const $payType = usePayTypeStore();
const $agent = useAgentStore();
const $trans = useTransactionStore();
const $user = useUserStore();

configure({
  validateOnInput: true,
})

function SelectPlan() {
  $trans.params.amount = PlanToAmount($trans.params.pay_type_id, $trans.params.plan)
}

function SelectClient() {
  $user.params.role = 6;
  $user.GetAPI()
}

function SelectAgent() {
  $user.params.role = 4;
  $user.GetAPI()
}

const schema = Yup.object({
  client_id: Yup.string().required('Client is Needed'),
  agent_id: Yup.string().required('Agent is Needed'),
  or: Yup.string().required('OR Number is required'),
})

onMounted(() => {
  $payType.GetAPI()
  $agent.GetAPI()
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
