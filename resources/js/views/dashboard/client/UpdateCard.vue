<template>
  <div class="card">
    <div class="card-header">
      <h4 class="card-title"><strong>Update Beneficiary</strong></h4>
    </div>
    <div class="card-body">
      <Form v-slot="{ errors }" :validation-schema="schema" validation-on-mount @submit="$ben.UpdateAPI($ben.params.id)">

        <div class="card-body">

          <div class="form-group">
            <label for="lastname-input">Last Name</label>
            <Field v-model="$ben.params.lastName" name="lastName" type="text" class="form-control" id="lastname-input"
              placeholder="Enter Last Name" />
            <div class="mb-2 text-danger">
              <ErrorMessage name="lastName" />
            </div>
          </div>

          <div class="form-group">
            <label for="firstname-input">First Name</label>
            <Field v-model="$ben.params.firstName" name="firstName" type="text" class="form-control" id="firstname-input"
              placeholder="Enter First Name" />
            <div class="mb-2 text-danger">
              <ErrorMessage name="firstName" />
            </div>
          </div>

          <div class="form-group">
            <label for="midname-input">Middle Name</label>
            <input v-model="$ben.params.midName" name="midName" type="text" class="form-control" id="midname-input"
              placeholder="Enter Middle Name">
          </div>

          <div class="form-group">
            <label>Extension Name</label>
            <select v-model="$ben.params.extName" class="form-control">
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
            <label for="bday-input">Birth Day</label>
            <Field v-model="$ben.params.bday" name="bday" type="date" class="form-control" id="bday-input"
              placeholder="Enter Birth Day" />
            <div class="mb-2 text-danger">
              <ErrorMessage name="bday" />
            </div>
          </div>

          <button @click="$ben.ChangeForm('')" class="btn btn-danger float-right mr-1">Cancel</button>

          <button :disabled="Object.keys(errors).length != 0" type="submit"
            class="btn btn-warning float-right mr-1">Update</button>

        </div>

      </form>
    </div>
  </div>
</template>

<script setup>
import { useBeneficiaryStore } from '@/store/auth/beneficiary';
import { Form, Field, ErrorMessage, configure, } from 'vee-validate'
import * as Yup from 'yup'

configure({
  validationOnInput: true,
})
const schema = Yup.object({
  lastName: Yup.string().required('Last Name is Required'),
  firstName: Yup.string().required('First Name is Required'),
  bday: Yup.date('Invalid Date').required('Birth Day is Required'),
})

const $ben = useBeneficiaryStore();
</script>
