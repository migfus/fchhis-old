<template>
  <Transition name="slide-fade">
    <div v-if="$register.params.id" class="col-12">
      <div class="card card-success">
        <div class="card-header">
          <h3 class="card-title"><strong>Register</strong></h3>
        </div>
        <div class="card-body">
          <Form v-slot="{ errors }" :validation-schema="schema" validate-on-mount @submit="$register.RegisterAPI">
            <div class="row">

              <div class="col-12 col-md-6">

                <div class="users-list clearfix d-flex justify-content-center">
                  <li class="pt-0 w-100">
                    <img data-toggle="modal" data-target="#avatar-modal"
                      :src="$register.params.avatar || 'https://fchhis.migfus20.com/images/logo.png'"
                      style="width: 162px; height: 162px" alt="User Image">
                    <button data-toggle="modal" data-target="#avatar-modal" class="btn btn-info ml-2">Upload
                      Avatar</button>
                  </li>
                </div>


                <div class="form-group">
                  <label for="username-input">Username</label>
                  <Field v-model="$register.params.username" name="username" type="text" class="form-control"
                    id="username-input" placeholder="Enter Username" />
                  <div class="mb-2 text-danger">
                    <ErrorMessage name="username" />
                  </div>
                </div>


                <div class="form-group">
                  <label for="email-input">Email</label>
                  <Field v-model="$register.params.email" name="email" type="email" class="form-control" id="email-input"
                    placeholder="Enter Email" />
                  <div class="mb-2 text-danger">
                    <ErrorMessage name="email" />
                  </div>
                </div>

                <label for="password-input">Password</label>
                <div class="form-group">
                  <Field v-model="$register.params.password" name="password" type="password" class="form-control"
                    placeholder="Enter Password" />
                  <div class="mb-3 text-danger">
                    <ErrorMessage name="password" />
                  </div>
                </div>


                <label for="password-input">Confirm Password</label>
                <div class="form-group">
                  <Field v-model="$register.params.confirmPassword" name="confirmPassword" type="password"
                    class="form-control" placeholder="Enter Password" />
                  <div class="mb-3 text-danger">
                    <ErrorMessage name="confirmPassword" />
                  </div>
                </div>


                <label for="mobile-input">Mobile</label>
                <div class="form-group">
                  <Field v-model="$register.params.mobile" name="mobile" type="text" class="form-control"
                    placeholder="Enter Mobile Number" />
                  <div class="mb-3 text-danger">
                    <ErrorMessage name="mobile" />
                  </div>
                </div>


              </div>

              <div class="col-12 col-md-6">

                <div class="form-group">
                  <label for="last-input">Name</label>
                  <Field v-model="$register.params.name" name="name" type="text" class="form-control" id="last-input"
                    placeholder="Enter Name" />
                  <div class="mb-2 text-danger">
                    <ErrorMessage name="name" />
                  </div>
                </div>

                <div class="form-group">
                  <label>Sex</label>
                  <select v-model="$register.params.sex" class="form-control">
                    <option :value="true">Male</option>
                    <option :value="false">Female</option>
                  </select>
                </div>

                <div class="separator mb-2"><strong>BIRTH DAY</strong></div>
                <div class="form-group">
                  <div class="row">
                    <div class="col-6">
                      <label for="bday-input">Birth Day </label>
                      <Field v-model="$register.params.bday" name="bday" type="date" class="form-control" id="bday-input"
                        placeholder="Enter Birth Day" />
                      <div class="mb-2 text-danger">
                        <ErrorMessage name="bday" />
                      </div>
                    </div>
                    <div class="col-6">
                      <label>Birth Place (Province)</label>
                      <select v-model="BDayProvinceID" class="form-control">
                        <option v-for="row in $address.content" :key="row.id" :value="row.id">{{ row.name }}</option>
                      </select>
                    </div>

                    <div class="col-12">
                      <label>Birth Place (City)</label>
                      <Field as="select" name="bplace" v-model="$register.params.bplace_id" class="form-control">
                        <option v-for="row in $address.content.find(item => item.id === BDayProvinceID).cities"
                          :key="row.id" :value="row.id">{{ row.name }}</option>
                      </Field>
                      <div class="mb-2 text-danger">
                        <ErrorMessage name="bplace" />
                      </div>
                    </div>

                  </div>
                </div>

                <div class="separator mb-2"><strong>ADDRESS</strong></div>
                <div class="form-group">
                  <div class="row">
                    <div class="col-6">
                      <label>Province</label>
                      <select v-model="AddressProvinceID" class="form-control">
                        <option v-for="row in $address.content" :key="row.id" :value="row.id">{{ row.name }}</option>
                      </select>
                    </div>
                    <div class="col-6">
                      <label>City</label>
                      <Field v-model="$register.params.address_id" name="addressID" as="select" class="form-control">
                        <!-- <option v-if="!AddressProvinceID" selected :value="0">Select Province</option> -->
                        <option v-for="row in $address.content.find(item => item.id === AddressProvinceID).cities"
                          :key="row.id" :value="row.id">{{ row.name }}</option>
                      </Field>
                      <div class="mb-2 text-danger">
                        <ErrorMessage name="addressID" />
                      </div>
                    </div>
                  </div>
                </div>

                <div class="form-group">
                  <label for="mid-input">Address</label>
                  <Field v-model="$register.params.address" name="address" type="text" class="form-control" id="mid-input"
                    placeholder="(Ex: Purok 1, Poblacion)" />
                  <div class="mb-2 text-danger">
                    <ErrorMessage name="address" />
                  </div>
                </div>

              </div>
            </div>

            <button type="submit" class="btn btn-success float-right mr-1"
              :disabled="Object.keys(errors).length != 0">Register</button>
          </Form>
        </div>

      </div>
      <UploadAvatarModal v-model="$register.params.avatar" />

    </div>
  </Transition>
</template>

<script setup>
import { computed, ref, onMounted } from 'vue'
import moment from 'moment'
import { useAddressStore } from '@/store/system/AddressStore'
import { Form, Field, ErrorMessage, configure, } from 'vee-validate'
import * as Yup from 'yup'
import { useRegisterStore } from '@/store/auth/RegisterStore'
import { useRouter } from 'vue-router'
import { $DebugInfo, $Err, $Log } from '@/helpers/debug'

import UploadAvatarModal from '@/components/UploadAvatarModal.vue'

$DebugInfo('RegisterFillPage');
const $address = useAddressStore();
const $register = useRegisterStore();
const $router = useRouter();

const BDayProvinceID = ref(16);
const AddressProvinceID = ref(16);

configure({
  validateOnInput: true,
})
const schema = Yup.object({
  username: Yup.string().required('Username is Required'),
  email: Yup.string().required('Email is Required').email('Invalid Email'),
  password: Yup.string().required('Password is Required').min(8, 'Minimum of 8 Characters'),
  confirmPassword: Yup.string().oneOf([Yup.ref('password'), null], 'Password must match to Password'),
  mobile: Yup.string().required('Mobile Number is Required').min(10, 'Minimum of 10 Number'),
  name: Yup.string().required('Name is Required'),
  bday: Yup.date('Invalid Date').required('Birth Day is Required'),
  bplace: Yup.string().required('Birth Place is Required'),
  addressID: Yup.string().required('City is Required'),
  address: Yup.string().required('Specific Address is Required'),
})

onMounted(() => {
  $address.GetAPI()
  $Log('onMounted', $register.content)
  if (!$register.params.id) {
    $router.push({ name: 'register', query: { error: 'Invalid OR', or: '' } })
  }
});
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
