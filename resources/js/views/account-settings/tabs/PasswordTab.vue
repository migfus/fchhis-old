<template>
    <div :class="`tab-pane fade ${$props.active ? 'active show' : ''}`" id="password" role="tabpanel"
        aria-labelledby="password-tab">

        <div class="card-body">
            <Form v-slot="{ errors }" :validation-schema="schema" @submit="Update">

                <div class="form-group">
                    <label for="current-password">Current Password</label>
                    <Field v-model="input.currentPassword" name="currentPassword" type="password" class="form-control"
                        id="current-password" placeholder="Current Password" :disabled="!can('update', 'auth')" />
                    <div class="mb-3 text-danger">
                        <ErrorMessage name="currentPassword" />
                    </div>
                </div>


                <div class="form-group">
                    <label for="new-password">New Password</label>
                    <Field v-model="input.newPassword" name="newPassword" type="password" class="form-control"
                        id="new-password" placeholder="New Password" :disabled="!can('update', 'auth')" />
                    <div class="mb-3 text-danger">
                        <ErrorMessage name="newPassword" />
                    </div>
                </div>


                <div class="form-group">
                    <label for="confirm-password">Confirm Password</label>
                    <Field v-model="input.confirmPassword" name="confirmPassword" type="password" class="form-control"
                        id="confirm-password" placeholder="Confirm Password" :disabled="!can('update', 'auth')" />
                    <div class="mb-3 text-danger">
                        <ErrorMessage name="confirmPassword" />
                    </div>
                </div>

                <button v-if="can('update', 'auth')" class="btn btn-info float-right"
                    :disabled="Object.keys(errors).length != 0">
                    Change
                </button>
                <button v-else class="btn btn-danger float-right" disabled>
                    Disabled
                </button>

            </Form>

        </div>

    </div>
</template>

<script setup lang="ts">
import { reactive } from 'vue';
import * as Yup from 'yup'
import { Form, Field, ErrorMessage, configure, } from 'vee-validate'
import axios from 'axios'
import { useToast } from "vue-toastification"
import { useAbility } from '@casl/vue'

configure({
    validateOnInput: true,
})

const schema = Yup.object({
    currentPassword: Yup.string().required('Current Password Required').min(8, 'Minimum of 8 Characters'),
    newPassword: Yup.string().required('New Password Required').min(8, 'Minimum of 8 Characters'),
    confirmPassword: Yup.string().oneOf([Yup.ref('newPassword'), null], 'Password must match to New Password')
})

const input = reactive({
    currentPassword: '',
    newPassword: '',
    confirmPassword: '',
})

const $props = defineProps(['active', 'id']);
const $toast = useToast();
const { can } = useAbility();

async function Update() {
    try {
        const { data } = await axios.post('/api/change-password', input)
        console.log('UpdateAPI', data.data)
        $toast.success('Successfuly Changed')
        Object.assign(input, { currentPassword: '', newPassword: '', confirmPassword: '' })
    }
    catch (e) {
        console.log('UpdateAPI Err', { e })
        $toast.error('Incorrect Current Password')
    }
}
</script>


