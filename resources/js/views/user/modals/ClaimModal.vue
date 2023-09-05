<template>
    <div class="modal fade" id="claim-modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">

                <div class="modal-header">
                    <h5 class="modal-title " id="exampleModalLabel">Declare a Claim</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>

                <div class="modal-body">
                    <div>
                        Declare a claim on this Client?
                    </div>

                    <AppButton v-if="$user.content.fulfilled_at" @click="Update($user.content.id)" color="secondary"
                        data-dismiss="modal" push="right">
                        Unclaim
                    </AppButton>
                    <AppButton v-else color="secondary" push="right" dada-dismiss="modal">
                        Claim
                    </AppButton>
                </div>
            </div>
        </div>
    </div>
</template>

<script setup>
import { useUserDetailsStore } from '@/store/user/UserDetailStore'
import axios from 'axios'
import { useToast } from 'vue-toastification'

import AppButton from '@/components/AppButton.vue'

const $user = useUserDetailsStore();
const $toast = useToast();

async function Update(id) {
    try {
        let { data: { data } } = await axios.post('/api/claim/' + id)
        $toast.success('Updated')
        $user.GetAPI(id)
    }
    catch (e) {
    }
}
</script>
