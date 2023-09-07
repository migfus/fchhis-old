<template>
    <div class="card">
        <div class="card-body">
            <AppTransition>
                <PasswordTab v-if="$user.config.form == 'pass'" />
                <InfoTab v-else-if="$user.config.form == 'info'" />


                <div v-else>
                    <div class="row float-right mb-1">
                        <RouterLink :to="{ name: 'users-clients' }">
                            <AppButton icon="fa-arrow-left" color="secondary" mr="1">
                                Back to List
                            </AppButton>
                        </RouterLink>


                        <AppButton color="success" push="right" mr="1" icon="fa-arrow-down">
                            Download Data
                        </AppButton>



                        <AppButton icon="fa-check-circle" color="danger" push="right" mr="1" data-toggle="modal"
                            data-target="#claim-modal">
                            Declare Claim
                        </AppButton>

                    </div>
                    <div class="row float-right">
                        <AppButton @click="$user.config.form = 'pass'" icon="fa-pen" color="warning" push="right" mr="1">
                            Change Password
                        </AppButton>
                        <AppButton @click="$user.config.form = 'info'" icon="fa-user-edit" color="info" push="right" mr="1">
                            Update Info
                        </AppButton>
                    </div>
                </div>
            </AppTransition>
        </div>
    </div>
</template>

<script setup lang="ts">
import { ref } from 'vue'
import { useUserDetailsStore } from '@/store/@staff/UserDetailStore'
// @ts-ignore
import PasswordTab from './tabs/PasswordTab.vue'
// @ts-ignore
import InfoTab from './tabs/InfoTab.vue'
import AppButton from '@/components/AppButton.vue'
import AppTransition from '@/components/AppTransition.vue'

const $user = useUserDetailsStore()
</script>

<style scoped>
.card-primary.card-outline-tabs>.card-header a.active,
.card-primary.card-outline-tabs>.card-header a.active:hover {
    border-top: 3px solid #5a6268;
}

a {
    color: #5a6268
}
</style>
