<template>
  <Transition name="slide-fade">
    <div class="col-12">
      <div class="card card-success">
        <div class="card-header">
          <h3 class="card-title"><strong>Add Transaction</strong></h3>
        </div>
        <div class="card-body">
          <Form v-slot="{ errors }" :validation-schema="schema" validate-on-mount @submit="$trans.AddAPI()">
            <div class="row">

              <div class="col-12 col-md-6">

                <div class="form-group">
                  <label>Client</label>
                  <Field name="agent" as='select' v-model="$trans.params.client_id" class="form-control">
                    <option v-for="row in $agent.content" :value="row.id">
                      {{ FullNameConvert(row.person.lastName, row.person.firstName, row.person.midName,
                        row.person.extName) }}
                    </option>
                  </Field>
                  <div class="mb-2 text-danger">
                    <ErrorMessage name="agent" />
                  </div>
                </div>

                <div class="form-group">
                  <label>Agent</label>
                  <Field name="agent" as='select' v-model="$trans.params.agent_id" class="form-control">
                    <option v-for="row in $agent.content" :value="row.id">
                      {{ FullNameConvert(row.person.lastName, row.person.firstName, row.person.midName,
                        row.person.extName) }}
                    </option>
                  </Field>
                  <div class="mb-2 text-danger">
                    <ErrorMessage name="agent" />
                  </div>
                </div>




              </div>

              <div class="col-12 col-md-6">

                <div class="form-group">
                  <label for="or-input">OR Number (Auto regenerate if empty)</label>
                  <Field @input="GeneratePasword()" v-model="$trans.params.or" name="or" type="text" class="form-control"
                    id="or-input" placeholder="Optional" />
                  <div class="mb-2 text-danger">
                    <ErrorMessage name="or" />
                  </div>
                </div>

                <div class="form-group">
                  <label for="mid-input">Amount</label>
                  <Field v-model="$trans.params.amount" name="transaction" type="text" class="form-control" id="mid-input"
                    placeholder="Optional" />
                </div>

                <div class="form-group">
                  <label>Plan</label>
                  <select v-model="$trans.params.plan_id" class="form-control">
                    <option v-for="row in $plan.content" :value="row.id">{{ row.name }}</option>
                  </select>
                </div>


                <div class="form-group">
                  <label>Payment Type</label>
                  <select v-model="$trans.params.pay_type_id" class="form-control">
                    <option v-for="row in $payType.content" :value="row.id">{{ row.name }}</option>
                  </select>
                </div>


              </div>
            </div>


            <button @click="$trans.Clear()" class="btn btn-danger float-right">Cancel</button>
            <button type="submit" class="btn btn-info float-right mr-1"
              :disabled="Object.keys(errors).length != 0">Add</button>
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
import { FullNameConvert } from '@/helpers/converter'
import { useTransactionStore } from '@/store/transaction/transaction'

const $plan = usePlanStore();
const $payType = usePayTypeStore();
const $agent = useAgentStore();
const $trans = useTransactionStore();

configure({
  validateOnInput: true,
})

const schema = Yup.object({
  or: Yup.string().required('OR Number is required'),
})

onMounted(() => {
  $payType.GetAPI()
  $agent.GetAPI()
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
