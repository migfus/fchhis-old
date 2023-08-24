<template>
    <Transition name="slide-fade">
        <div class="col-12">
            <div class="card card-info">
                <div class="card-header">
                    <h3 class="card-title"><strong>Add OR</strong></h3>
                </div>
                <div class="card-body">
                    <Form v-slot="{ errors }" :validation-schema="schema" validate-on-mount @submit="$user.StoreAPI()">
                        <div class="row">

                            <div class="col-12">

                                <div class="alert alert-success alert-dismissible fade show" role="alert">
                                    To Activate this "OR"s account, the User must registered first by inputting his/her
                                    personal
                                    information. I would be better to notify this user about the registration.
                                </div>

                            </div>

                            <div class="col-12 col-md-6">

                                <label for="or-input">OR</label>
                                <div class="form-group">
                                    <Field v-model="$user.params.or" name="or" type="text" class="form-control"
                                        placeholder="Enter OR Number" />
                                </div>
                                <div class="mb-3 text-danger">
                                    <ErrorMessage name="or" />
                                </div>

                                <div class="form-group">
                                    <label>Plan</label>
                                    <select v-model="$user.params.plan" class="form-control">
                                        <option v-for="row in $plan.content" :value="row.id">{{ row.name }}</option>
                                    </select>
                                </div>

                                <div class="form-group">
                                    <label>Payment Type</label>
                                    <select v-model="$user.params.pay_type_id" class="form-control">
                                        <option v-for="row in $payType.content" :value="row.id">{{ row.name }}</option>
                                    </select>
                                </div>

                                <div class="form-group">
                                    <label for="mid-params">Initial Transaction</label>
                                    <Field v-model="$user.params.transaction" name="transaction" type="text"
                                        class="form-control" id="mid-input" placeholder="Optional" />
                                </div>


                                <label for="">URL Registratino for Client: <a :href="url" target="_blank">{{ url
                                }}</a></label>
                            </div>

                            <div class="col-12 col-md-6">
                                <div class="form-group">
                                    <label>Agent</label>
                                    <Field name="agent" as='select' v-model="$user.params.agent" class="form-control">
                                        <option v-for="row in $agent.content" :value="row.id">
                                            {{ row.person.name }}
                                        </option>
                                    </Field>
                                    <div class="mb-2 text-danger">
                                        <ErrorMessage name="agent" />
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label for="lastName-input">Name</label>
                                    <Field v-model="$user.params.name" name="name" type="text" class="form-control"
                                        id="lastName-input" placeholder="Enter Name" />
                                    <div class="mb-2 text-danger">
                                        <ErrorMessage name="name" />
                                    </div>
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

<script setup lang="ts">
import { useUsersStore } from '@/store/users/UsersStore'
import { usePlanStore } from '@/store/system/PlanStore'
import { Form, Field, ErrorMessage, configure, } from 'vee-validate'
import * as Yup from 'yup'
import { computed, onMounted } from 'vue'
import { usePayTypeStore } from '@/store/system/PayTypeStore'
import { useAgentStore } from '@/store/users/AgentStore'

const $user = useUsersStore();
const $plan = usePlanStore();
const $payType = usePayTypeStore();
const $agent = useAgentStore();

configure({
    validateOnInput: true,
})
const schema = Yup.object({
    or: Yup.string().required('OR is Required'),
    name: Yup.string().required('Name is Required'),
})
const url = computed(() => {
    if ($user.params.or) {
        return `https://fchhis.migfus20.com/register?or=${$user.params.or}`
    }
    return ''
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
