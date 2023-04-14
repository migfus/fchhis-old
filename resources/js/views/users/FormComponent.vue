<template>
  <Transition name="slide-fade">
    <div v-if="$user.config.form" class="col-12">
      <div class="card">
        <div class="card-header">
          <h3 class="card-title"><strong>{{ $user.config.form == 'add' ? 'Add' : 'Update' }} User</strong></h3>
        </div>
        <div class="card-body">
          <div class="row">

            <div class="col-12 col-md-6">

              <div class="users-list clearfix d-flex justify-content-center">
                <li class="pt-0 w-100">
                  <img src="https://adminlte.io/themes/v3/dist/img/user1-128x128.jpg" alt="User Image">
                  <button class="btn btn-info ml-2">Upload Avatar</button>
                </li>
              </div>


              <div class="form-group">
                <label for="username-input">Username</label>
                <input v-model="input.username" type="text" class="form-control" id="username-input"
                  placeholder="Enter Username">
              </div>

              <div class="form-group">
                <label for="email-input">Email</label>
                <input v-model="input.email" type="email" class="form-control" id="email-input" placeholder="Enter Email">
              </div>

              <label for="password-input">Password</label>
              <div class="input-group mb-3">
                <input v-model="input.password" type="text" class="form-control" placeholder="Enter or Generate Password">
                <div class="input-group-append">
                  <span @click="GeneratePasword()" class="input-group-text" style="cursor: pointer">Generate</span>
                </div>
              </div>

              <label for="mobile-input">Mobile</label>
              <div class="input-group mb-3">
                <input v-model="input.mobile" type="text" class="form-control" placeholder="Enter Mobile Number">
                <div class="input-group-append">
                  <span v-if="input.notify" @click="input.notify = !input.notify" class="input-group-text bg-success"
                    style="cursor: pointer">
                    <i class="fas fa-bell"></i>
                  </span>
                  <span v-else @click="input.notify = !input.notify" class="input-group-text bg-danger"
                    style="cursor: pointer">
                    <i class="fas fa-bell-slash"></i>
                  </span>
                </div>
              </div>

              <div class="form-group">
                <label>Role</label>
                <select v-model="input.role" class="form-control">
                  <option value="client">Client</option>
                  <option value="staff">Staff</option>
                  <option value="agent">Agent</option>
                  <option value="manager">Manager</option>
                  <option value="admin">Admin</option>
                  <option value="ban">Ban</option>
                </select>
              </div>

              <div class="form-group">
                <label>Plan</label>
                <select v-model="input.plan" class="form-control">
                  <option value="jasper">Jasper</option>
                  <option value="jade">Jade</option>
                  <option value="beryl">Beryl</option>
                  <option value="onyx">Onyx</option>
                </select>
              </div>




            </div>

            <div class="col-12 col-md-6">

              <div class="form-group">
                <label for="last-input">Last Name</label>
                <input v-model="input.lastName" type="text" class="form-control" id="last-input"
                  placeholder="Enter Last Name">
              </div>

              <div class="form-group">
                <label for="first-input">First Name</label>
                <input v-model="input.firstName" type="text" class="form-control" id="first-input"
                  placeholder="Enter First Name">
              </div>

              <div class="form-group">
                <label for="mid-input">Middle Name (Complete)</label>
                <input v-model="input.midName" type="text" class="form-control" id="mid-input"
                  placeholder="Enter Middle Name">
              </div>

              <div class="form-group">
                <label>Extension Name</label>
                <select v-model="input.extName" class="form-control">
                  <option value="">N/A</option>
                  <option value="jr">Jr</option>
                  <option value="sr">Sr</option>
                  <option value="i">I</option>
                  <option value="ii">II</option>
                  <option value="iii">III</option>
                  <option value="iv">IV</option>
                  <option value="v">V</option>
                  <option value="vi">VI</option>
                  <option value="vii">VII</option>
                </select>
              </div>

              <div class="form-group">
                <label>Sex</label>
                <select v-model="input.sex" class="form-control">
                  <option :value="true">Male</option>
                  <option :value="false">Female</option>
                </select>
              </div>

              <div class="separator mb-2"><strong>BIRTH DAY</strong></div>
              <div class="form-group">
                <div class="row">
                  <div class="col-6">
                    <label for="bday-input">Birth Day {{ `(${age} Years Old)` }}</label>
                    <input v-model="input.bday" type="date" class="form-control" id="bday-input"
                      placeholder="Enter Birth Day">
                  </div>
                  <div class="col-6">
                    <label>Birth Place (City)</label>
                    <select v-model="input.bplace_id" class="form-control">
                      <option value="">N/A</option>
                    </select>
                  </div>
                </div>
              </div>

              <div class="separator mb-2"><strong>ADDRESS</strong></div>
              <div class="form-group">
                <div class="row">
                  <div class="col-6">
                    <label>Province</label>
                    <select v-model="input.province" class="form-control">
                      <option value="">N/A</option>
                    </select>
                  </div>
                  <div class="col-6">
                    <label>City</label>
                    <select v-model="input.city" class="form-control">
                      <option value="">N/A</option>
                    </select>
                  </div>
                </div>
              </div>

              <div class="form-group">
                <label for="mid-input">Address</label>
                <input v-model="input.address" type="text" class="form-control" id="mid-input"
                  placeholder="(Ex: P-1. Poblacion)">
              </div>

            </div>
          </div>


          <button @click="$user.ChangeForm('')" class="btn btn-danger float-right">Cancel</button>
          <button @click="$user.ChangeForm('')" class="btn btn-info float-right mr-1">Add</button>
        </div>

      </div>
    </div>
  </Transition>
</template>

<script setup>
import { useUserStore } from '@/store/users'
import { reactive, computed } from 'vue'
import moment from 'moment'

const $user = useUserStore();

const input = reactive({
  avatar: '',
  username: '',
  email: '',
  password: '',
  mobile: '',
  notify: true,
  role: 'client',
  plan: 'jasper',

  lastName: '',
  firstName: '',
  midName: '',
  extName: '',
  sex: true,

  bday: '',
  bplace_id: 16,

  province: 16,
  city: 16,
  addres: '',
})
const age = computed(() => {
  try {
    return moment().diff(input.bday, 'years')
  }
  catch (e) {
    return '?'
  }
})

function GeneratePasword(length = 8) {
  let result = '';
  const characters = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789';
  const charactersLength = characters.length;
  let counter = 0;
  while (counter < length) {
    result += characters.charAt(Math.floor(Math.random() * charactersLength));
    counter += 1;
  }
  if (input.username) {
    input.password = `${input.username}-${result.substring(0, 3)}`;
  }
  else {
    input.password = result;
  }
}
</script>

<style scoped>
.slide-fade-enter-active {
  transition: all 0.3s ease-out;
}

.slide-fade-leave-active {
  transition: all 0.1s cubic-bezier(1, 0.5, 0.8, 1);
}

.slide-fade-enter-from,
.slide-fade-leave-to {
  transform: translateY(-20px);
  opacity: 0;
}

.separator {
  display: flex;
  align-items: center;
  text-align: center;
}

.separator::before,
.separator::after {
  content: '';
  flex: 1;
  border-bottom: 1px solid #c5cdd4;
}

.separator:not(:empty)::before {
  margin-right: .25em;
}

.separator:not(:empty)::after {
  margin-left: .25em;
}
</style>
