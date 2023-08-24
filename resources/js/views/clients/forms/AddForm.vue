<template>
    <Transition name="slide-fade">
        <div class="col-12">
            <div class="card card-success">
                <div class="card-header">
                    <h3 class="card-title"><strong>Add User</strong></h3>
                </div>
                <div class="card-body">
                    <Form v-slot="{ errors }" :validation-schema="schema" validate-on-mount @submit="$user.Add">
                        <div class="row">

                            <div class="col-12 col-md-6">

                                <div class="users-list clearfix d-flex justify-content-center">
                                    <li class="pt-0 w-100">
                                        <img data-toggle="modal" data-target="#avatar-modal"
                                            :src="$user.input.avatar || 'https://fchhis.migfus20.com/images/logo.png'"
                                            style="width: 162px; height: 162px" alt="User Image">
                                        <button data-toggle="modal" data-target="#avatar-modal"
                                            class="btn btn-info ml-2">Upload
                                            Avatar</button>
                                    </li>
                                </div>


                                <div class="form-group">
                                    <label for="username-input">Username</label>
                                    <Field @input="GeneratePasword()" v-model="$user.input.username" name="username"
                                        type="text" class="form-control" id="username-input" placeholder="Enter Username" />
                                    <div class="mb-2 text-danger">
                                        <ErrorMessage name="username" />
                                    </div>
                                </div>


                                <div class="form-group">
                                    <label for="email-input">Email</label>
                                    <Field v-model="$user.input.email" name="email" type="email" class="form-control"
                                        id="email-input" placeholder="Enter Email" />
                                    <div class="mb-2 text-danger">
                                        <ErrorMessage name="email" />
                                    </div>
                                </div>

                                <label for="password-input">Password</label>
                                <div class="input-group ">
                                    <Field v-model="$user.input.password" name="password" type="text" class="form-control"
                                        placeholder="Enter or Generate Password" />
                                    <div class="input-group-append">
                                        <span @click="GeneratePasword()" class="input-group-text"
                                            style="cursor: pointer">Generate</span>
                                    </div>
                                </div>
                                <div class="mb-3 text-danger">
                                    <ErrorMessage name="password" />
                                </div>

                                <label for="mobile-input">Mobile</label>
                                <div class="input-group">
                                    <Field v-model="$user.input.mobile" name="mobile" type="text" class="form-control"
                                        placeholder="Enter Mobile Number" />
                                    <div class="input-group-append">
                                        <span v-if="$user.input.notifyMobile"
                                            @click="$user.input.notifyMobile = !$user.input.notifyMobile"
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
                                    <label>Role</label>
                                    <input type="text" value="Client" class="form-control" disabled>
                                </div>

                                <div class="form-group">
                                    <label>Plan</label>
                                    <select v-model="$user.input.plan" class="form-control">
                                        <option v-for="row in $plan.content" :value="row.id">{{ row.name }}</option>
                                    </select>
                                </div>

                                <div class="form-group">
                                    <label for="mid-input">Initial Transaction</label>
                                    <Field v-model="$user.input.transaction" name="transaction" type="text"
                                        class="form-control" id="mid-input" placeholder="Optional" />
                                </div>

                                <div class="form-group">
                                    <label>Payment Type</label>
                                    <select v-model="$user.input.pay_type_id" class="form-control">
                                        <option v-for="row in $payType.content" :value="row.id">{{ row.name }}</option>
                                    </select>
                                </div>

                                <div class="form-group">
                                    <label>Agent</label>
                                    <Field name="agent" as='select' v-model="$user.input.agent" class="form-control">
                                        <option v-for="row in $agent.content" :value="row.id">
                                            {{ row.person.name }}
                                        </option>
                                    </Field>
                                    <div class="mb-2 text-danger">
                                        <ErrorMessage name="agent" />
                                    </div>
                                </div>

                            </div>

                            <div class="col-12 col-md-6">

                                <div class="form-group">
                                    <label for="last-input">Last Name</label>
                                    <Field v-model="$user.input.lastName" name="lastName" type="text" class="form-control"
                                        id="last-input" placeholder="Enter Last Name" />
                                    <div class="mb-2 text-danger">
                                        <ErrorMessage name="lastName" />
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label for="first-input">First Name</label>
                                    <Field v-model="$user.input.firstName" name="firstName" type="text" class="form-control"
                                        id="first-input" placeholder="Enter First Name" />
                                    <div class="mb-2 text-danger">
                                        <ErrorMessage name="firstName" />
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label for="mid-input">Middle Name (Complete)</label>
                                    <Field v-model="$user.input.midName" name="midName" type="text" class="form-control"
                                        id="mid-input" placeholder="Enter Middle Name" />
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

                                <div class="form-group">
                                    <label>Sex</label>
                                    <select v-model="$user.input.sex" class="form-control">
                                        <option :value="true">Male</option>
                                        <option :value="false">Female</option>
                                    </select>
                                </div>

                                <div class="separator mb-2"><strong>BIRTH DAY</strong></div>
                                <div class="form-group">
                                    <div class="row">
                                        <div class="col-6">
                                            <label for="bday-input">Birth Day {{ `(${age} Years Old)` }}</label>
                                            <Field v-model="$user.input.bday" name="bday" type="date" class="form-control"
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
                                            <Field as="select" name="bplace" v-model="$user.input.bplaceID"
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
                                            <Field v-model="$user.input.addressID" name="addressID" as="select"
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
                                    <Field v-model="$user.input.address" name="address" type="text" class="form-control"
                                        id="mid-input" placeholder="(Ex: Purok 1, Poblacion)" />
                                    <div class="mb-2 text-danger">
                                        <ErrorMessage name="address" />
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
            <AvatarUpload />

        </div>
    </Transition>
</template>

<script setup>
import { useUserStore } from '@/store/users/users'
import { computed, ref } from 'vue'
import moment from 'moment'
import { useAddressStore } from '@/store/system/address'
import { Form, Field, ErrorMessage, configure, } from 'vee-validate'
import * as Yup from 'yup'
import { usePlanStore } from '@/store/system/plan'
import { usePayTypeStore } from '@/store/system/payTypes'
import { useAgentStore } from '@/store/users/agent'

import AvatarUpload from '../modals/AvatarUpload.vue'

const $address = useAddressStore();
const $user = useUserStore();
const $plan = usePlanStore();
const $payType = usePayTypeStore();
const $agent = useAgentStore();

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
    lastName: Yup.string().required('Last Name is Required'),
    firstName: Yup.string().required('First Name is Required'),
    bday: Yup.date('Invalid Date').required('Birth Day is Required'),
    bplace: Yup.string().required('Birth Place is Required'),
    addressID: Yup.string().required('City is Required'),
    address: Yup.string().required('Specific Address is Required'),
    agent: Yup.string().required('Agent is Required')
})

const age = computed(() => {
    try {
        return moment().diff($user.input.bday, 'years')
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
    if ($user.input.username) {
        $user.input.password = `${$user.input.username}-${result.substring(0, 3)}`;
    }
    else {
        $user.input.password = result;
    }
}
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
}</style>
