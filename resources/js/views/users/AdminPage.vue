<template>
  <section class="content">
    <div class="container-fluid">
      <div class="row">
        <div class="col-12">
          <div class="card">
            <div class="card-header">
              <h3 class="card-title">Responsive Hover Table</h3>
              <div class="card-tools">
                <div class="input-group input-group-sm" style="width: 150px;">
                  <input type="text" name="table_search" class="form-control float-right" placeholder="Search">
                  <div class="input-group-append">
                    <button type="submit" class="btn btn-default">
                      <i class="fas fa-search"></i>
                    </button>
                  </div>
                </div>
              </div>
            </div>

            <div class="card-body table-responsive p-0">
              <table class="table table-hover text-nowrap">
                <thead>
                  <tr>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Created</th>
                    <th>Action</th>
                  </tr>
                </thead>
                <tbody>
                  <tr v-for="row in table" :key="row.name">
                    <td>183</td>
                    <td>John Doe</td>
                    <td>11-7-2014</td>
                    <td><span class="tag tag-success">Approved</span></td>
                    <td>Bacon ipsum dolor sit amet salami venison chicken flank fatback doner.</td>
                  </tr>
                </tbody>
              </table>
            </div>

          </div>
        </div>
      </div>
    </div>
  </section>
</template>

<script setup>
import { ref } from 'vue'

const table = ref([
  {
    name: 'Name Here',
    email: 'email@gmail.com',
    created_at: '12/12/2022',
  },
  {
    name: 'Name Here',
    email: 'email@gmail.com',
    created_at: '12/12/2022',
  },
  {
    name: 'Name Here',
    email: 'email@gmail.com',
    created_at: '12/12/2022',
  },
  {
    name: 'Name Here',
    email: 'email@gmail.com',
    created_at: '12/12/2022',
  },
  {
    name: 'Name Here',
    email: 'email@gmail.com',
    created_at: '12/12/2022',
  },
  {
    name: 'Name Here',
    email: 'email@gmail.com',
    created_at: '12/12/2022',
  },
  {
    name: 'Name Here',
    email: 'email@gmail.com',
    created_at: '12/12/2022',
  },
  {
    name: 'Name Here',
    email: 'email@gmail.com',
    created_at: '12/12/2022',
  },
  {
    name: 'Name Here',
    email: 'email@gmail.com',
    created_at: '12/12/2022',
  },
  {
    name: 'Name Here',
    email: 'email@gmail.com',
    created_at: '12/12/2022',
  },
]);
</script>
