<template>
  <div class="row">
    <div class="col-12 col-md-6">

      <div class="card">
        <div class="card-header">
          <h4 class="card-title"><strong>Transactions (Summary)</strong></h4>

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
        <div class="card-body table-responsive">
          <table class="table table-hover text-nowrap">
            <thead>
              <tr>
                <th>Year</th>
                <th>Jan</th>
                <th>Feb</th>
                <th>Mar</th>
                <th>Apr</th>
                <th>May</th>
                <th>Jun</th>
                <th>Jul</th>
                <th>Aug</th>
                <th>Sep</th>
                <th>Oct</th>
                <th>Dec</th>
              </tr>
            </thead>
            <tbody>
              <tr>
                <td>2019</td>
                <td>183</td>
                <td>183</td>
                <td>183</td>
                <td>183</td>
                <td>183</td>
                <td>183</td>
                <td>183</td>
                <td>183</td>
                <td>183</td>
                <td>183</td>
                <td>183</td>
              </tr>
              <tr>
                <td>2020</td>
                <td>183</td>
                <td>183</td>
                <td>183</td>
                <td>183</td>
                <td>183</td>
                <td>183</td>
                <td>183</td>
                <td>183</td>
                <td>183</td>
                <td>183</td>
                <td>183</td>
              </tr>
            </tbody>
          </table>

          <div>
            <button class="btn btn-info float-right mt-2">Print</button>
          </div>
        </div>
      </div>

      <div class="card">
        <div class="card-header">
          <h4 class="card-title"><strong>Beneficiaries</strong></h4>

          <div class="card-tools">
            <div class="input-group input-group-sm">
              <input type="text" name="table_search" class="form-control float-right" placeholder="Search">
              <div class="input-group-append">
                <button type="submit" class="btn btn-default">
                  <i class="fas fa-search"></i>
                </button>
                <button type="submit" class="btn btn-success">
                  Add
                </button>
              </div>
            </div>
          </div>
        </div>
        <div class="card-body">
          <table class="table table-hover text-nowrap">
            <thead>
              <tr>
                <th>Name</th>
                <th>Age</th>
                <th width="100">Action</th>
              </tr>
            </thead>
            <tbody>
              <tr v-for="row in 5">
                <td>Juan De loslos</td>
                <td>12</td>
                <td>
                  <button class="btn btn-info btn-sm mr-1"><i class="fas fa-pen"></i></button>
                  <button class="btn btn-danger btn-sm px-2"><i class="fas fa-times"></i></button>
                </td>
              </tr>
            </tbody>
          </table>
        </div>
      </div>
    </div>

    <div class="col-12 col-md-6">
      <div class="card">
        <div class="card-header">
          <h4 class="card-title"><strong>Transactions</strong></h4>

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
                <th width="100">OR</th>
                <th>Amount</th>
                <th width="60">Action</th>
              </tr>
            </thead>
            <tbody>
              <tr v-for="row in 10">
                <td>20221212-XD4</td>
                <td class="text-success text-bold">+12,000</td>
                <td>
                  <button class="btn btn-warning btn-sm mr-1 float-right"><i class="fas fa-receipt"></i></button>
                </td>
              </tr>
            </tbody>
          </table>
          <div>
            Total: <strong class="text-success">10,000.00</strong>
          </div>
          <div>
            To Pay: <strong class="text-orange">78,000.00</strong>
          </div>

        </div>
      </div>
    </div>


  </div>
</template>

<script setup>

</script>
