<template>
  <div class="row">
    <div class="col-lg-6 col-6">

      <div v-if="data.users" class="small-box bg-info">
        <div class="inner">
          <h3><i class="fas fa-users mr-2"></i>{{ data.users }}</h3>
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

    <div class="col-lg-6 col-6">

      <div class="small-box bg-success">
        <div class="inner">
          <h3>₱ 10,000 </h3>
          <p>Monthly Income</p>
        </div>
        <div class="icon">
          <i class="fas fa-chart-line"></i>
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
