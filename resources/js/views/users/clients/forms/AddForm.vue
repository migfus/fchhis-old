<template>
    <Transition name="slide-fade">
        <div class="col-12">
            <div class="card card-success">
                <div class="card-header">
                    <h3 class="card-title"><strong>Add User</strong></h3>
                </div>
                <div class="card-body">
                    <Form v-slot="{ errors }" :validation-schema="schema" validate-on-mount @submit="$user.StoreAPI()">
                        <div class="row">

                            <div class="col-12 col-md-6">

                                <div class="users-list clearfix d-flex justify-content-center">
                                    <li class="pt-0 w-100">
                                        <img data-toggle="modal" data-target="#avatar-modal"
                                            :src="$user.params.avatar || '/images/logo.png'"
                                            style="width: 162px; height: 162px" alt="User Image">
                                        <button data-toggle="modal" data-target="#avatar-modal" class="btn btn-info ml-2">
                                            Upload Avatar
                                        </button>
                                    </li>
                                </div>


                                <div class="separator mb-2"><strong>ACCOUNT</strong></div>
                                <div class="form-group">
                                    <label for="username-input">Username</label>
                                    <Field @input="GeneratePasword()" v-model="$user.params.username" name="username"
                                        type="text" class="form-control" id="username-input" placeholder="Enter Username" />
                                    <div class="mb-2 text-danger">
                                        <ErrorMessage name="username" />
                                    </div>
                                </div>


                                <div class="form-group">
                                    <label for="email-input">Email</label>
                                    <Field v-model="$user.params.email" name="email" type="email" class="form-control"
                                        id="email-input" placeholder="Enter Email" />
                                    <div class="mb-2 text-danger">
                                        <ErrorMessage name="email" />
                                    </div>
                                </div>

                                <label for="password-input">Password</label>
                                <div class="input-group ">
                                    <Field v-model="$user.params.password" name="password" type="text" class="form-control"
                                        placeholder="Enter or Generate Password" />
                                    <div class="input-group-append">
                                        <span @click="GeneratePasword()" class="input-group-text"
                                            style="cursor: pointer">Generate</span>
                                    </div>
                                </div>
                                <div class="mb-3 text-danger">
                                    <ErrorMessage name="password" />
                                </div>

                                <div class="separator mb-2"><strong>AGENT</strong></div>
                                <div class="form-group">
                                    <label>Agent</label>
                                    <Field name="agent" as='select' v-model="$user.params.agent_id" class="form-control">
                                        <option v-for="row in $agent.content" :value="row.id">
                                            {{ row.name }}
                                        </option>
                                    </Field>
                                    <div class="mb-2 text-danger">
                                        <ErrorMessage name="agent" />
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label for="mid-input">Role</label>
                                    <Field value="Client" name="role" type="text" class="form-control" disabled />
                                </div>

                                <!-- <div class="form-group">
                                    <label>Role</label>
                                    <select v-model="$user.params.role" class="form-control" disabled>
                                        <option :value="6">Client</option>
                                    </select>
                                </div> -->

                                <div class="separator mb-2"><strong>PLAN/TRANSACTION</strong></div>

                                <div class="form-group">
                                    <label>Plan</label>
                                    <select v-model="$user.params.plan_details_id" class="form-control">
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
                                    <label for="mid-input">Initial Transaction</label>
                                    <Field v-model="$user.params.transaction" name="transaction" type="text"
                                        class="form-control" id="mid-input" placeholder="Optional" />
                                </div>





                            </div>

                            <div class="col-12 col-md-6">





                                <div class="separator mb-2"><strong>PROFILE</strong></div>

                                <div class="form-group">
                                    <label for="last-input">Name</label>
                                    <Field v-model="$user.params.name" name="name" type="text" class="form-control"
                                        id="last-input" placeholder="Enter Complete Name" />
                                    <div class="mb-2 text-danger">
                                        <ErrorMessage name="name" />
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label>Sex</label>
                                    <select v-model="$user.params.sex" class="form-control">
                                        <option :value="true">Male</option>
                                        <option :value="false">Female</option>
                                    </select>
                                </div>

                                <div class="separator mb-2"><strong>BIRTH DAY</strong></div>
                                <div class="form-group">
                                    <div class="row">
                                        <div class="col-6">
                                            <label for="bday-input">Birth Day <span v-if="age">{{ `(${age} Years Old)`
                                            }}</span></label>
                                            <Field v-model="$user.params.bday" name="bday" type="date" class="form-control"
                                                id="bday-input" placeholder="Enter Birth Day" />
                                        </div>
                                        <div class="col-6">
                                            <label>Birth Place (Province)</label>
                                            <select v-model="BDayProvinceID" class="form-control">
                                                <option v-for="row in $address.content" :key="row.id" :value="row.id">{{
                                                    row.name }}</option>
                                            </select>

                                        </div>
                                        <div class="col-12">
                                            <label>Birth Place (City)</label>
                                            <Field as="select" name="bplace" v-model="$user.params.bplace_id"
                                                class="form-control">
                                                <option
                                                    v-for="row in $address.content.find(item => item.id === BDayProvinceID).cities"
                                                    :key="row.id" :value="row.id">{{ row.name }}</option>
                                            </Field>
                                            <div class="mb-2 text-danger">
                                                <ErrorMessage name="bplace" />
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <label for="mobile-input">Mobile</label>
                                <div class="form-group">
                                    <Field v-model="$user.params.mobile" name="mobile" type="text" class="form-control"
                                        placeholder="Enter Mobile Number" />
                                    <div class="mb-3 text-danger">
                                        <ErrorMessage name="mobile" />
                                    </div>
                                </div>

                                <div class="separator mb-2"><strong>ADDRESS</strong></div>
                                <div class="form-group">
                                    <div class="row">
                                        <div class="col-6">
                                            <label>Province</label>
                                            <select v-model="AddressProvinceID" class="form-control">
                                                <option v-for="row in $address.content" :key="row.id" :value="row.id">{{
                                                    row.name }}</option>
                                            </select>
                                        </div>
                                        <div class="col-6">
                                            <label>City</label>
                                            <Field v-model="$user.params.address_id" name="addressID" as="select"
                                                class="form-control">
                                                <option
                                                    v-for="row in $address.content.find(item => item.id === AddressProvinceID).cities"
                                                    :key="row.id" :value="row.id">{{ row.name }}</option>
                                            </Field>
                                            <div class="mb-2 text-danger">
                                                <ErrorMessage name="addressID" />
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label for="mid-input">Address</label>
                                    <Field v-model="$user.params.address" name="address" type="text" class="form-control"
                                        id="mid-input" placeholder="(Ex: Purok 1, Poblacion)" />
                                    <div class="mb-2 text-danger">
                                        <ErrorMessage name="address" />
                                    </div>
                                </div>





                                <div class="text-secondary">
                                    Branch: {{ $auth.content.auth.branch_id }}
                                </div>
                                <div class="text-secondary">
                                    Region: {{ $auth.content.auth.region_id }}
                                </div>

                            </div>
                        </div>

                        <AppButton @click="$user.ChangeForm('')" icon="fa-times" color="danger" push="right">
                            Cancel
                        </AppButton>
                        <AppButton color="info" icon="fa-plus" :disabled="Object.keys(errors).length != 0" type="submit"
                            push="right" mr="1">
                            Add
                        </AppButton>
                    </Form>
                </div>

            </div>
            <UploadAvatarModal v-model="$user.params.avatar" />

        </div>
    </Transition>
</template>

<script setup>
import { useUsersStore } from '@/store/@staff/UsersStore'
import { computed, ref, onMounted } from 'vue'
import moment from 'moment'
import { useAddressStore } from '@/store/public/AddressStore'
import { Form, Field, ErrorMessage, configure, } from 'vee-validate'
import * as Yup from 'yup'
import { usePlanStore } from '@/store/system/PlanStore'
import { usePayTypeStore } from '@/store/system/PayTypeStore'
import { useAgentStore } from '@/store/@staff/AgentStore'
import { useAuthStore } from '@/store/auth/AuthStore'

import UploadAvatarModal from '@/components/UploadAvatarModal.vue'
import AppButton from '@/components/AppButton.vue'

const $address = useAddressStore();
const $user = useUsersStore();
const $plan = usePlanStore();
const $payType = usePayTypeStore();
const $agent = useAgentStore();
const $auth = useAuthStore();

const BDayProvinceID = ref(16);
const AddressProvinceID = ref(16);

configure({
    validateOnInput: true,
})
const schema = Yup.object({
    username: Yup.string().required('Username is Required'),
    email: Yup.string().required('Email is Required').email('Invalid Email'),
    password: Yup.string().required('Password is Required').min(8, 'Minimum of 8 Characters'),
    mobile: Yup.string().required('Mobile Number is Required').min(10, 'Minimum of 10 Number'),
    name: Yup.string().required('Name is Required'),
    bday: Yup.date('Invalid Date').required('Birth Day is Required'),
    bplace: Yup.string().required('Birth Place is Required'),
    addressID: Yup.string().required('City is Required'),
    address: Yup.string().required('Specific Address is Required'),
})

const age = computed(() => {
    try {
        return moment().diff($user.params.bday, 'years')
    }
    catch (e) {
        return '?'
    }
})

function GeneratePasword(length = 8) {
    let result = '';
    const characters = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789';
    const charactersLength = characters.length;
    let counter = 0;
    while (counter < length) {
        result += characters.charAt(Math.floor(Math.random() * charactersLength));
        counter += 1;
    }
    if ($user.params.username) {
        $user.params.password = `${$user.params.username}-${result.substring(0, 3)}`;
    }
    else {
        $user.params.password = result;
    }
}

onMounted(() => {
    $payType.GetAPI()
    $address.GetAPI()
    $plan.GetAPI()
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
