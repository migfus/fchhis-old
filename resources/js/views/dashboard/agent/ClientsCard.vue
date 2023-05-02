<template>
  <div class="col-12 col-md-6">

    <div class="card">
      <div class="card-header">
        <h4 class="card-title"><strong>Clients</strong></h4>

        <div class="card-tools">
          <div class="input-group input-group-sm">
            <input type="text" name="table_search" class="form-control float-right" placeholder="Search">
            <div class="input-group-append">
              <button type="submit" class="btn btn-default">
                <i class="fas fa-search"></i>
              </button>
            </div>
          </div>
        </div>

      </div>
      <div class="card-body">
        <table class="table table-hover text-nowrap">
          <thead>
            <tr>
              <th width="100">Name</th>
              <!-- <th>Role</th> -->
            </tr>
          </thead>
          <tbody>
            <tr v-for="row in $down.content">
              <td>{{ FullNameConvert(row.lastName, row.firstName, row.midName, row.extName) }} </td>
              <!-- <td class="text-success text-bold">{{ }}</td> -->
            </tr>
          </tbody>
        </table>

      </div>
    </div>


  </div>
</template>

<script setup>
import { onMounted, watch } from 'vue';
import { useDownHeadStore } from '@/store/dashboard/downhead'
import { throttle } from 'lodash'
import { FullNameConvert, } from '@/helpers/converter'

const $down = useDownHeadStore();

onMounted(() => {
  $down.GetAPI()
});

watch($down.query, throttle(() => {
  $down.GetAPI(1)
}, 1000));
</script>
