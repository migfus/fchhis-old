<template>
    <div v-if="$user.content" class="col-12">
        <TransitionGroup name="list" tag="div">
            <div v-for="(row, idx,) in $user.content.data" :key="row.id" class="card mb-2">
                <div class="card-body">
                    <div class="row">

                        <div class="col-xl-3 col-lg-6 col-md-12">
                            <img :src="row.avatar ?? '/images/logo.png'" style="height: 3em;"
                                class="img-circle float-left mr-3 mb-2">

                            <div class="d-inline d-lg-none float-right">
                                <RouterLink :to="{ name: 'user', params: { id: row.id } }"
                                    class="btn btn-warning btn-sm mr-1">
                                    Update</RouterLink>
                                <RouterLink :to="{ name: 'user', params: { id: row.id } }" class="btn btn-info btn-sm">
                                    Info</RouterLink>
                            </div>
                            <div>
                                <strong>
                                    {{ row.name }}
                                </strong>
                            </div>
                            <div>
                                <strong class="text-secondary">
                                    {{ row.username }}
                                </strong>
                            </div>
                            <div>
                                <strong class="text-secondary">
                                    {{ row.email }}
                                </strong>
                            </div>
                        </div>

                        <div class="col-xl-3 col-lg-6 col-md-12">
                            <div class="d-none d-lg-inline d-xl-none float-right">
                                <RouterLink :to="{ name: 'user', params: { id: row.id } }"
                                    class="btn btn-warning btn-sm mr-1">
                                    Update</RouterLink>
                                <RouterLink :to="{ name: 'user', params: { id: row.id } }" class="btn btn-info btn-sm">
                                    Info</RouterLink>
                            </div>
                            <div>
                                <img :src="row.info.plan.avatar" style="height: 20px; width: 20px"
                                    class="img-circle float-left mr-2">
                                <strong>
                                    {{ row.info.plan.name }}
                                </strong>
                            </div>
                            <div>
                                <i style="height: 20px; width: 20px"
                                    class="img-circle float-left mt-1 text-secondary fab fa-google-play"></i>
                                <strong>
                                    {{ row.info.pay_type.name }}
                                </strong>
                            </div>
                            <div>
                                <i style="height: 20px; width: 20px"
                                    class="img-circle float-left mt-1 fa fa-map-pin text-secondary"></i>
                                <strong>
                                    {{ `${row.info.address}, ${$address.CityIDToFullAddress(row.info.address_id)}` }}
                                </strong>
                            </div>

                        </div>

                        <div class="col-xl-3 col-lg-6 col-md-12">

                            <div>
                                <i style="height: 20px; width: 20px"
                                    class="img-circle float-left mt-1 text-info fa fa-wallet"></i>
                                <strong>
                                    Total: {{ NumberAddComma(row.client_transactions_sum_amount) }}
                                </strong>
                            </div>
                            <div>
                                <i style="height: 20px; width: 20px"
                                    class="img-circle float-left mt-1 text-success fa fa-plus-circle"></i>
                                <strong class="text-success">
                                    + {{ NumberAddComma(row.client_transactions_sum_amount) }}
                                </strong>
                            </div>
                            <div>
                                <i style="height: 20px; width: 20px"
                                    class="img-circle float-left mt-1 text-danger fa fa-calendar-times"></i>
                                <strong v-if="row.info.due_at">
                                    Due in {{ moment(row.info.due_at).fromNow(true) }}
                                </strong>
                                <strong v-else>
                                    Due: N/A
                                </strong>
                            </div>
                        </div>

                        <div class="col-xl-3 col-lg-6 col-md-12">
                            <div class="d-none d-xl-inline float-right">
                                <RouterLink :to="{ name: 'user', params: { id: row.id } }"
                                    class="btn btn-warning btn-sm mr-1">
                                    Update</RouterLink>
                                <RouterLink :to="{ name: 'user', params: { id: row.id } }" class="btn btn-info btn-sm">
                                    Info</RouterLink>
                            </div>
                            <div>
                                <img :src="row.info.agent.avatar" style="height: 20px; width: 20px"
                                    class="img-circle float-left mr-2">
                                <strong>
                                    Agent: {{ row.info.agent.name }}
                                </strong>
                            </div>
                            <div>
                                <img :src="row.info.staff.avatar" style="height: 20px; width: 20px"
                                    class="img-circle float-left mr-2">
                                <strong>
                                    Staff: {{ row.info.staff.name }}
                                </strong>
                            </div>
                            <div>
                                <i style="height: 20px; width: 20px"
                                    class="img-circle float-left mr-2 mt-1 fa fa-clock text-secondary"></i>
                                <strong>
                                    {{ moment(row.created_at).format('MMM D, YYYY hh:mm A') }}
                                </strong>
                            </div>
                        </div>
                    </div>




                </div>
            </div>
        </TransitionGroup>

    </div>
</template>

<script setup>
import moment from "moment"
import { useUsersStore } from '@/store/@staff/UsersStore'
import { RoleToDesc } from '@/helpers/converter'
import BadgeComponent from '../components/BadgeComponent.vue'
import { NumberAddComma } from '@/helpers/converter'
import { useAddressStore } from "@/store/public/AddressStore"
import VueAvatar from "@webzlodimir/vue-avatar"
import "@webzlodimir/vue-avatar/dist/style.css"

const $user = useUsersStore();
const $address = useAddressStore();
</script>

<style scoped>
.list-enter,
.list-leave-to {
    opacity: 0
}

.list-leave,
.list-enter-to {
    opacity: 1
}

.list-enter-active,
.list-leave-active {
    transition: opacity 300ms
}



.bg-warning {
    background-color: #EFDFAE !important;
}

.bg-gray {
    background-color: #9CB9C5 !important;
    color: black !important;
}

.ribbon-wrapper {
    left: 0 !important;
    transform: rotate(270deg)
}
</style>
