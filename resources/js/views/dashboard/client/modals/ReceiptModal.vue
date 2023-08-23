<template>
  <div class="modal fade" id="receipt-modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">

        <div class="modal-header">
          <h5 class="modal-title " id="exampleModalLabel">Receipt</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>

        <div class="modal-body">
          <div>
            OR Number:
            <strong class="text-info">
              {{ $props.data.or }}
            </strong>
          </div>
          <div>
            Name:
            <strong> {{ $props.data.client.name }} </strong>
          </div>
          <div>
            Amount:
            <strong class="text-success">
              {{ NumberAddComma($props.data.amount) }}
            </strong>
          </div>
          <div>
            Plan:
            <strong class="">
              {{ `${$props.data.plan.name} (${$props.data.pay_type.name})` }}
            </strong>
          </div>
          <div>
            Date of Payment:
            <strong>
              {{ moment($props.data.created_at).format('MMM D, YYYY HH:mm A') }}
            </strong>
          </div>
        </div>

        <div class="modal-footer">
          <button @click="Print()" type="button" class="btn btn-success" data-dismiss="modal">
            Print
          </button>
        </div>
      </div>
    </div>
  </div>
</template>

<script setup>
import { NumberAddComma } from '@/helpers/converter'
import moment from 'moment'
import { useReceiptStore } from '@/store/print/receipt'
import { onMounted } from 'vue';

const $receipt = useReceiptStore();

const $props = defineProps({
  data: {
    Type: Object,
    required: true,
  }
});

function Print() {
  // console.log($props.data)
  // return 1
  $receipt.Print({
    header: {
      date: moment($props.data.created_at).format('MMM D, YYYY HH:mm A'),
      or: $props.data.or,
      name: $props.data.client.name
    },
    body: [
      {
        plan: $props.data.plan.name,
        type: $props.data.pay_type.name,
        amount: $props.data.amount
      },
    ],
    footer: {
      payType: 'Cash on Hand',
      received: $props.data.staff.name,
    }
  }
  )
}

onMounted(() => {

});


</script>
