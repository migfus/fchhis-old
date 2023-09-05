<template>
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <div class="row">

                    <div class="col-12 col-md-2 mb-2">
                        <VueDatePicker v-model="$user.query.start" :enable-time-picker="false"
                            :start-date="moment().startOf('month').format('YYYY-MM-DD')" placeholder="Start Date"
                            auto-apply />
                    </div>
                    <div class="col-12 col-md-2 mb-2">
                        <VueDatePicker v-model="$user.query.end" :enable-time-picker="false"
                            :start-date="moment().endOf('month').format('YYYY-MM-DD')" placeholder="End Date" auto-apply />
                    </div>

                    <div class="col-12 col-md-4 mb-2">
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text"><i class="fas fa-filter"></i></span>
                            </div>
                            <select v-model="$user.query.filter" class="form-control">
                                <!-- <option value="">All (Filter)</option> -->
                                <option value="name">Name</option>
                                <option value="email">Email</option>
                                <option value="address">Address</option>
                                <option value="plans">Plans</option>
                            </select>
                        </div>
                    </div>

                    <div class="col-12 col-md-4">
                        <div class="input-group input-group float-right">
                            <input v-model="$user.query.search" type="text" name="table_search"
                                class="form-control float-right" placeholder="Search">
                            <div class="input-group-append">
                                <button type="submit" class="btn btn-default">
                                    <i :class="`fas ${$user.config.loading ? 'fa-spinner fa-spin' : 'fa-search'}`"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row mt-2">
                    <div class="col-12">
                        <AppButton v-if="$user.config.form" @click="$user.ChangeForm('')" color="danger" icon="fa-times"
                            push="right">
                            Cancel
                        </AppButton>
                        <AppButton v-else @click="$user.ChangeForm('add')" color="success" icon="fa-plus" push="right"
                            :loading="$user.config.loading">
                            Add User
                        </AppButton>


                        <AppButton color="info" icon="fa-arrow-down" :loading="$user.config.loading" mr="1" push="right"
                            data-toggle="modal" data-target="#print-modal">
                            Download
                        </AppButton>
                    </div>
                </div>

            </div>
        </div>

        <PrintModal />
    </div>
</template>

<script setup lang="ts">
import { watch, onMounted } from 'vue'
import { useUsersStore } from '@/store/@staff/UsersStore'
import moment from 'moment'
import { throttle } from 'lodash'
import VueDatePicker from '@vuepic/vue-datepicker'
import '@vuepic/vue-datepicker/dist/main.css'

import PrintModal from '../modals/PrintModal.vue'
import AppButton from '@/components/AppButton.vue'

const $user = useUsersStore();

watch($user.query, throttle(() => {
    $user.GetAPI(1)
}, 1000))

onMounted(() => {
    $user.GetAPI()
});
</script>
