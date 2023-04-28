<template>
  <Transition name="slide-fade">
    <div class="col-12">
      <div class="card card-success">
        <div class="card-header">
          <h3 class="card-title"><strong>Add Plan</strong></h3>
        </div>
        <div class="card-body">
          <Form v-slot="{ errors }" :validation-schema="schema" validate-on-mount @submit="$plan.UpdateAPI()">
            <div class="row">

              <div class="col-12 col-md-6">

                <div class="users-list clearfix d-flex justify-content-center">
                  <li class="pt-0 w-100">
                    <img data-toggle="modal" data-target="#avatar-modal"
                      :src="$plan.input.avatar || 'https://i.imgflip.com/437aqu.jpg?a466704'"
                      style="width: 162px; height: 162px" alt="User Image">
                    <button data-toggle="modal" data-target="#avatar-modal" class="btn btn-info ml-2">Upload
                      Image</button>
                  </li>
                </div>

                <div class="form-group">
                  <label for="name-input">Description</label>
                  <QuillEditor v-model:content="$plan.input.desc" contentType="html" theme="snow" style="height: 300px"
                    placeholder="Place" />
                </div>
              </div>

              <div class="col-12 col-md-6">

                <div class="form-group">
                  <label for="name-input">Name</label>
                  <Field v-model="$plan.input.name" name="name" type="text" class="form-control" id="name-input"
                    placeholder="Enter Plan's Name" />
                  <div class="mb-2 text-danger">
                    <ErrorMessage name="name" />
                  </div>
                </div>

                <div class="separator mb-2"><strong>AGE REQUIREMENTS</strong></div>
                <div class="form-group">
                  <div class="row">
                    <div class="col-6">
                      <label for="start-input">Start Age</label>
                      <Field v-model="$plan.input.age_start" name="start_age" type="text" class="form-control"
                        id="start-input" placeholder="Enter Start Age" />
                      <div class="mb-2 text-danger">
                        <ErrorMessage name="start_age" />
                      </div>
                    </div>
                    <div class="col-6">
                      <label for="end-input">End Age</label>
                      <Field v-model="$plan.input.age_end" name="end_age" type="text" class="form-control" id="end-input"
                        placeholder="Enter End Age" />
                      <div class="mb-2 text-danger">
                        <ErrorMessage name="end_age" />
                      </div>
                    </div>
                  </div>
                </div>

                <div class="separator mb-2"><strong>PAYMENT</strong></div>
                <div class="form-group">
                  <label for="contract-price">Contract Price</label>
                  <Field v-model="$plan.input.contract_price" name="contract_price" type="text" class="form-control"
                    id="contract-price" placeholder="Enter Contract Price" />
                  <div class="mb-2 text-danger">
                    <ErrorMessage name="contract_price" />
                  </div>
                </div>

                <div class="form-group">
                  <div class="row">
                    <div class="col-6">
                      <label for="spot_payment">Spot Payment</label>
                      <Field v-model="$plan.input.spot_pay" name="spot_payment" type="text" class="form-control"
                        id="spot_payment" placeholder="Enter Spot Payment" />
                      <div class="mb-2 text-danger">
                        <ErrorMessage name="spot_payment" />
                      </div>
                    </div>
                    <div class="col-6">
                      <label for="spot_service">Spot Service</label>
                      <Field v-model="$plan.input.spot_service" name="spot_service" type="text" class="form-control"
                        id="spot_service" placeholder="Enter Spot Service" />
                      <div class="mb-2 text-danger">
                        <ErrorMessage name="spot_service" />
                      </div>
                    </div>
                  </div>
                </div>

                <div class="form-group">
                  <div class="row">
                    <div class="col-6">
                      <label for="annually">Annual</label>
                      <Field v-model="$plan.input.annual" name="annually" type="text" class="form-control" id="annually"
                        placeholder="Enter Annual" />
                      <div class="mb-2 text-danger">
                        <ErrorMessage name="annually" />
                      </div>
                    </div>
                    <div class="col-6">
                      <label for="semi_annually">Semi Annual</label>
                      <Field v-model="$plan.input.semi_annual" name="semi_annually" type="text" class="form-control"
                        id="semi_annually" placeholder="Enter Semi-Annual" />
                      <div class="mb-2 text-danger">
                        <ErrorMessage name="semi_annually" />
                      </div>
                    </div>
                  </div>
                </div>

                <div class="form-group">
                  <div class="row">
                    <div class="col-6">
                      <label for="querterly">Quarterly</label>
                      <Field v-model="$plan.input.quarterly" name="querterly" type="text" class="form-control"
                        id="querterly" placeholder="Enter Quarterly" />
                      <div class="mb-2 text-danger">
                        <ErrorMessage name="querterly" />
                      </div>
                    </div>
                    <div class="col-6">
                      <label for="monthly">Monthly</label>
                      <Field v-model="$plan.input.monthly" name="monthly" type="text" class="form-control" id="monthly"
                        placeholder="Enter Monthly" />
                      <div class="mb-2 text-danger">
                        <ErrorMessage name="monthly" />
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>


            <button @click="$plan.ChangeForm('')" class="btn btn-danger float-right">Cancel</button>
            <button type="submit" class="btn btn-info float-right mr-1"
              :disabled="Object.keys(errors).length != 0">Add</button>
          </Form>
        </div>

      </div>
      <AvatarUpload />

    </div>
  </Transition>
</template>

<script setup>
import { Form, Field, ErrorMessage, configure, } from 'vee-validate'
import * as Yup from 'yup'
import { QuillEditor } from '@vueup/vue-quill'
import '@vueup/vue-quill/dist/vue-quill.snow.css';
import { usePlanStore } from '@/store/system/plan'

import AvatarUpload from '../modals/AvatarUpload.vue'

configure({
  validateOnInput: true,
})
const schema = Yup.object({
  name: Yup.string().required('Plan\'s Name is Required'),
  contract_price: Yup.string().required('Plan\'s Contract Price is Required'),
  start_age: Yup.string().required('Start age is Required'),
  end_age: Yup.string().required('End age is Required'),
  spot_payment: Yup.string().required('Spot payment is Required'),
  spot_service: Yup.string().required('Spot service is Required'),
  annually: Yup.string().required('Annually is Required'),
  semi_annually: Yup.string().required('Annually is Required'),
  querterly: Yup.string().required('Querterly is Required'),
  monthly: Yup.string().required('Monthly is Required'),
})
const $plan = usePlanStore();

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
