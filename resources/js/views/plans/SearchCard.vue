<template>
  <div class="col-12">
    <div class="card">
      <div class="card-body">
        <div class="row">

          <div v-if="$plan.config.notify" class="col-12">
            <div class="alert alert-warning alert-dismissible fade show" role="alert">
              <strong>Notify</strong> We don't recommend to delete some records, it will reflect everything that they
              transact.
              <button @click="$plan.RemoveNotify" type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
          </div>

          <div class="col-12 col-md-6 mb-2">
            <div class="input-group">
              <div class="input-group-prepend">
                <span class="input-group-text"><i class="fas fa-filter"></i></span>
              </div>
              <select v-model="$plan.params.filter" class="form-control">
                <option value="name">Name</option>
                <option value="desc">Description</option>
                <option value="user">User</option>
              </select>
            </div>
          </div>

          <div class="col-12 col-md-6">
            <div class="input-group input-group float-right">
              <input v-model="$plan.params.search" type="text" name="table_search" class="form-control float-right"
                placeholder="Search">
              <div class="input-group-append">
                <button type="submit" class="btn btn-default">
                  <i :class="`fas ${$plan.config.loading ? 'fa-spinner fa-spin' : 'fa-search'}`"></i>
                </button>
              </div>
            </div>
          </div>
        </div>

        <div class="row mt-2">
          <div class="col-12">
            <button v-if="$plan.config.form" @click="$plan.ChangeForm('add')" class="btn btn-danger float-right">
              <i class="fas fa-plus-square d-inline d-xl-none"></i>
              <span class="d-none d-xl-inline">Cancel</span>
            </button>
            <button v-else @click="$plan.ChangeForm('add')" class="btn btn-success float-right">
              <i class="fas fa-plus-square d-inline d-xl-none"></i>
              <span class="d-none d-xl-inline">Add</span>
            </button>

            <button v-if="$plan.config.enableDelete" @click="$plan.ToggleEnableDelete"
              class="btn btn-success mr-1 float-right">
              Disable Delete
            </button>
            <button v-else @click="$plan.ToggleEnableDelete" class="btn btn-danger mr-1 float-right">
              Enable Delete
            </button>

            <button v-if="$plan.config.loading" class="btn card-loader-content card-loader mr-1 float-right"
              style="width: 42px">
              &nbsp;
            </button>
            <button v-else class="btn btn-info mr-1 float-right">
              <i class="fas fa-print"></i>
            </button>

          </div>
        </div>

      </div>
    </div>
  </div>
</template>

<script setup>
import { watch, onMounted } from 'vue'
import { throttle } from 'lodash'
import { usePlanStore } from '@/store/system/plan'

const $plan = usePlanStore();

watch($plan.params, throttle(() => {
  $plan.GetAPI(1)
}, 1000))

onMounted(() => {
  $plan.GetAPI()
});
</script>
