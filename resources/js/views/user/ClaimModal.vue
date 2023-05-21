<template>
  <div class="modal fade" id="claim-modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">

        <div class="modal-header">
          <h5 class="modal-title " id="exampleModalLabel">Claim</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>


        <div class="modal-body">
          <div>
            Claim this Client?
          </div>
          <button v-if="$user.content.fulfilled_at" type="button" class="btn btn-secondary float-right"
            data-dismiss="modal">Unclaim</button>
          <button v-else type="button" class="btn btn-secondary float-right" data-dismiss="modal">Claim</button>
        </div>
      </div>
    </div>
  </div>
</template>

<script setup>
import { useUserDetailsStore } from '@/store/user/UserDetailStore'

const $user = useUserDetailsStore();
</script>
