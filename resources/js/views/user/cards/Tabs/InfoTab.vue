<template>
    <form>
        <div class="row">
            <div class="col-sm-6">
                <div class="form-group">
                    <label>Region</label>
                    <input v-model="$user.params.region_id" type="text" class="form-control" disabled>
                </div>
            </div>
            <div class="col-sm-6">
                <div class="form-group">
                    <label>Branch</label>
                    <input v-model="$user.params.branch_id" type="text" class="form-control" disabled>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-sm-6">
                <div class="form-group">
                    <label>ID</label>
                    <input v-model="$user.params.id" type="text" class="form-control" disabled>
                </div>
            </div>
            <div class="col-sm-6">
                <div class="form-group">
                    <label>Role</label>
                    <input v-model="$user.params.role" type="text" class="form-control" disabled>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-sm-6">
                <div class="form-group">
                    <label>Plan</label>
                    <input v-model="$user.params.plan_id" type="text" class="form-control" disabled>
                </div>
            </div>
            <div class="col-sm-6">
                <div class="form-group">
                    <label>PayType</label>
                    <input v-model="$user.params.pay_type_id" type="text" class="form-control" disabled>
                </div>
            </div>
        </div>


        <div class="row">
            <div class="col-sm-6">
                <div class="form-group">
                    <label>Agent</label>
                    <input v-model="$user.params.agent_id" type="text" class="form-control" disabled>
                </div>
            </div>
            <div class="col-sm-6">
                <div class="form-group">
                    <label>Staff</label>
                    <input v-model="$user.params.staff_id" type="text" class="form-control" disabled>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-sm-12">
                <div class="form-group">
                    <label>Due At</label>
                    <input v-model="$user.params.due_at" type="date" class="form-control">
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-sm-6">
                <div class="form-group">
                    <label>Name</label>
                    <input v-model="$user.params.name" type="text" class="form-control" placeholder="Enter ...">
                </div>
            </div>
            <div class="col-sm-6">
                <div class="form-group">
                    <label>Sex</label>
                    <select v-model="$user.params.sex" class="form-control">
                        <option :value="true">Male</option>
                        <option :value="false">Female</option>
                    </select>
                </div>
            </div>
        </div>


        <div class="row">
            <div class="col-sm-12">
                <div class="separator mb-2"><strong>BIRTHDAY</strong></div>
                <div class="form-group">
                    <label>Birth Day</label>
                    <input v-model="$user.content.info.bday" type="date" class="form-control" placeholder="Enter ...">
                </div>
            </div>
            <div class="col-sm-6">
                <div class="form-group">
                    <label>Birth Place (City)</label>
                    <select v-model="$user.content.info.bplace_id" class="form-control">
                        <option>option 1</option>
                        <option>option 2</option>
                        <option>option 3</option>
                        <option>option 4</option>
                        <option>option 5</option>
                    </select>
                </div>
            </div>
            <div class="col-sm-6">
                <div class="form-group">
                    <label>Birth Place (Province)</label>
                    <select class="form-control">
                        <option>option 1</option>
                        <option>option 2</option>
                        <option>option 3</option>
                        <option>option 4</option>
                        <option>option 5</option>
                    </select>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-sm-12">
                <div class="separator mb-2"><strong>ADDRESS</strong></div>

                <div class="form-group">
                    <label>Specific Address</label>
                    <input v-model="$user.params.address" type="text" class="form-control" placeholder="Enter ...">
                </div>
            </div>
            <div class="col-sm-6">
                <div class="form-group">
                    <label>City (Address)</label>
                    <select v-model="$user.params.address_id" class="form-control">
                        <option>option 1</option>
                        <option>option 2</option>
                        <option>option 3</option>
                        <option>option 4</option>
                        <option>option 5</option>
                    </select>
                </div>
            </div>
            <div class="col-sm-6">
                <div class="form-group">
                    <label>Province (Address)</label>
                    <select class="form-control">
                        <option>option 1</option>
                        <option>option 2</option>
                        <option>option 3</option>
                        <option>option 4</option>
                        <option>option 5</option>
                    </select>
                </div>
            </div>
        </div>

        <AppButton @click="$user.config.form = null" color="danger" icon="fa-times" push="right">
            Cancel
        </AppButton>

        <AppButton @click="$user.config.form = null" color="warning" icon="fa-pen" push="right" mr="1">
            Update
        </AppButton>
    </form>
</template>

<script setup lang="ts">
import { onMounted } from 'vue'
import { useUserDetailsStore } from '@/store/@staff/UserDetailStore'
import { useAddressStore } from '@/store/public/AddressStore';

import AppButton from '@/components/AppButton.vue';

const $user = useUserDetailsStore()
const $address = useAddressStore()

onMounted(() => {
    $user.InitParams()
})
</script>

<style scoped>
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
