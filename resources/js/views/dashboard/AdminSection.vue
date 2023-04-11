<template>
  <div class="row">
    <div class="col-lg-3 col-6">

      <div v-if="data.users" class="small-box bg-info">
        <div class="inner">
          <h3>{{ data.users }}</h3>
          <p>Users</p>
        </div>
        <div class="icon">
          <i class="fas fa-users"></i>
        </div>
        <a href="#" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
      </div>

      <div v-else class="small-box card-loader">
        <div class="inner">
          <h3 class="card-loader-content mw-1">&nbsp;</h3>
          <p class="card-loader-contnet">&nbsp;</p>
        </div>
        <div class="icon">
          <i class="fas fa-refresh"></i>
        </div>
      </div>

    </div>

    <div class="col-lg-3 col-6">

      <div class="small-box bg-success">
        <div class="inner">
          <h3>53<sup style="font-size: 20px">%</sup></h3>
          <p>Bounce Rate</p>
        </div>
        <div class="icon">
          <i class="ion ion-stats-bars"></i>
        </div>
        <a href="#" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
      </div>
    </div>

    <div class="col-lg-3 col-6">

      <div class="small-box bg-warning">
        <div class="inner">
          <h3>44</h3>
          <p>User Registrations</p>
        </div>
        <div class="icon">
          <i class="ion ion-person-add"></i>
        </div>
        <a href="#" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
      </div>
    </div>

    <div class="col-lg-3 col-6">

      <div class="small-box bg-danger">
        <div class="inner">
          <h3>65</h3>
          <p>Unique Visitors</p>
        </div>
        <div class="icon">
          <i class="ion ion-pie-graph"></i>
        </div>
        <a href="#" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
      </div>
    </div>

  </div>
</template>

<script setup>
import { reactive, onMounted } from 'vue'
import axios from 'axios'


const data = reactive({})

async function GetAPI() {
  try {
    const { data: { users } } = await axios.get('/api/dashboard')
    data.users = users
  }
  catch (e) {
    console.log({ e })
  }
}

onMounted(() => {
  GetAPI()
});

</script>
