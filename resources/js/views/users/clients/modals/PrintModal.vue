<template>
    <div class="modal fade" id="print-modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">

                <Form v-slot="{ errors }" :validation-schema="schema" validate-on-mount @submit="$user.PrintAPI()">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Print Date Range</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="username-input">Start Date</label>
                            <Field v-model="$user.query.start" name="start" type="date" class="form-control"
                                id="username-input" placeholder="Enter Date" />
                            <div class="mb-2 text-danger">
                                <ErrorMessage name="start" />
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="username-input">End Date</label>
                            <Field v-model="$user.query.end" name="end" type="date" class="form-control" id="username-input"
                                placeholder="Enter Date" />
                            <div class="mb-2 text-danger">
                                <ErrorMessage name="end" />
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button v-if="!$user.config.loading" :disabled="Object.keys(errors).length != 0" type="button"
                            class="btn btn-success">
                            Print
                        </button>
                        <button v-else disabled type="button" class="btn btn-secondary">
                            <i class="fa fa-circle-notch fa-spin"></i>
                        </button>
                    </div>
                </Form>

            </div>
        </div>
    </div>
</template>

<script setup lang="ts">
import { useUsersStore } from '@/store/@staff/UsersStore'
import { useAuthStore } from '@/store/auth/AuthStore'
import { Form, Field, ErrorMessage, configure, } from 'vee-validate'
import * as Yup from 'yup'
import moment from 'moment'
import { NumberAddComma } from '@/helpers/converter'

const $user = useUsersStore();
const $auth = useAuthStore();

configure({
    validateOnInput: true,
})
const schema = Yup.object({
    start: Yup.date()
        .typeError('Invalid date format')
        .required('Start Date is required'),
    end: Yup.date()
        .typeError('Invalid date format')
        .required('End Date is required'),
})


</script>
