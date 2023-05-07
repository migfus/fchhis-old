<template>
  <Transition name="slide-fade">
    <div class="col-12">
      <div class="card card-info">
        <div class="card-header">
          <h3 class="card-title"><strong>Add OR</strong></h3>
        </div>
        <div class="card-body">
          <Form v-slot="{ errors }" :validation-schema="schema" validate-on-mount @submit="$user.Add">
            <div class="row">

              <div class="col-12">

                <div class="alert alert-success alert-dismissible fade show" role="alert">
                  To Activate this "OR"s account, the User must registered first by inputting his/her personal
                  information. I would be better to notify this user about the registration.
                </div>

              </div>

              <div class="col-12 col-md-6">

                <label for="or-input">OR</label>
                <div class="input-group">
                  <Field v-model="$user.input.or" name="or" type="text" class="form-control"
                    placeholder="Enter OR Number" />
                  <div class="input-group-append">
                    <span @click="GeneratePasword()" class="input-group-text bg-info" style="cursor: pointer">
                      Generate OR
                    </span>
                  </div>
                </div>
                <div class="mb-3 text-danger">
                  <ErrorMessage name="or" />
                </div>

                <label for="mobile-input">Mobile</label>
                <div class="input-group">
                  <Field v-model="$user.input.mobile" name="mobile" type="text" class="form-control"
                    placeholder="Enter Mobile Number" />
                  <div class="input-group-append">
                    <span v-if="$user.input.notifyMobile" @click="$user.input.notifyMobile = !$user.input.notifyMobile"
                      class="input-group-text bg-success" style="cursor: pointer">
                      <i class="fas fa-bell"></i>
                    </span>
                    <span v-else @click="$user.input.notifyMobile = !$user.input.notifyMobile"
                      class="input-group-text bg-danger" style="cursor: pointer">
                      <i class="fas fa-bell-slash"></i>
                    </span>
                  </div>
                </div>
                <div class="mb-3 text-danger">
                  <ErrorMessage name="mobile" />
                </div>

                <div class="form-group">
                  <label>Plan</label>
                  <select v-model="$user.input.plan" class="form-control">
                    <option v-for="row in $plan.content" :value="row.id">{{ row.name }}</option>
                  </select>
                </div>

                <div class="form-group">
                  <label>Payment Type</label>
                  <select v-model="$user.input.pay_type_id" class="form-control">
                    <option v-for="row in $payType.content" :value="row.id">{{ row.name }}</option>
                  </select>
                </div>

                <div class="form-group">
                  <label for="mid-input">Initial Transaction</label>
                  <Field v-model="$user.input.transaction" name="transaction" type="text" class="form-control"
                    id="mid-input" placeholder="Optional" />
                </div>

                <div class="form-group">
                  <label>Agent</label>
                  <Field name="agent" as='select' v-model="$user.input.agent" class="form-control">
                    <option v-for="row in $agent.content" :value="row.id">
                      {{ FullNameConvert(row.person.lastName, row.person.firstName, row.person.midName,
                        row.person.extName) }}
                    </option>
                  </Field>
                  <div class="mb-2 text-danger">
                    <ErrorMessage name="agent" />
                  </div>
                </div>

                <label for="">URL Registratino for Client: <a :href="url" target="_blank">{{ url }}</a></label>
              </div>

              <div class="col-12 col-md-6">

                <div class="form-group">
                  <label for="lastName-input">Last Name</label>
                  <Field v-model="$user.input.lastName" name="lastName" type="text" class="form-control"
                    id="lastName-input" placeholder="Enter Last Name" />
                  <div class="mb-2 text-danger">
                    <ErrorMessage name="lastName" />
                  </div>
                </div>

                <div class="form-group">
                  <label for="firstName-input">First Name</label>
                  <Field v-model="$user.input.firstName" name="firstName" type="text" class="form-control"
                    id="firstName-input" placeholder="Enter First Name" />
                  <div class="mb-2 text-danger">
                    <ErrorMessage name="firstName" />
                  </div>
                </div>

                <div class="form-group">
                  <label for="midName-input">Mid Name</label>
                  <Field v-model="$user.input.midName" name="midName" type="text" class="form-control" id="midName-input"
                    placeholder="Enter Middle Name" />
                </div>

                <div class="form-group">
                  <label>Extension Name</label>
                  <select v-model="$user.input.extName" class="form-control">
                    <option value="">N/A</option>
                    <option value="jr">Jr</option>
                    <option value="sr">Sr</option>
                    <option value="i">I</option>
                    <option value="ii">II</option>
                    <option value="iii">III</option>
                    <option value="iv">IV</option>
                    <option value="v">V</option>
                    <option value="vi">VI</option>
                    <option value="vii">VII</option>
                  </select>
                </div>

              </div>
            </div>


            <button @click="$user.ChangeForm('')" class="btn btn-danger float-right">Cancel</button>
            <button type="submit" class="btn btn-info float-right mr-1"
              :disabled="Object.keys(errors).length != 0">Add</button>
          </Form>
        </div>

      </div>

    </div>
  </Transition>
</template>

<script setup>
import { useUserStore } from '@/store/users/users'
import { usePlanStore } from '@/store/system/plan'
import { Form, Field, ErrorMessage, configure, } from 'vee-validate'
import * as Yup from 'yup'
import moment from 'moment'
import { computed, onMounted } from 'vue'
import { usePayTypeStore } from '@/store/system/payTypes'
import { useAgentStore } from '@/store/users/agent'
import { FullNameConvert } from '@/helpers/converter'

const $user = useUserStore();
const $plan = usePlanStore();
const $payType = usePayTypeStore();
const $agent = useAgentStore();

configure({
  validateOnInput: true,
})
const schema = Yup.object({
  or: Yup.string().required('OR is Required'),
  mobile: Yup.string().required('Mobile is Required'),
  lastName: Yup.string().required('Last Name is Required'),
  firstName: Yup.string().required('First Name is Required'),
})
const url = computed(() => {
  if ($user.input.or) {
    return `https://fchhis.migfus20.com/register?or=${$user.input.or}`
  }
  return ''
})

function GeneratePasword(length = 4) {
  let result = '';
  const characters = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789';
  const charactersLength = characters.length;
  let counter = 0;
  while (counter < length) {
    result += characters.charAt(Math.floor(Math.random() * charactersLength));
    counter += 1;
  }

  $user.input.or = `${moment().format('YYYYMMDD')}-${result}`;
}

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
