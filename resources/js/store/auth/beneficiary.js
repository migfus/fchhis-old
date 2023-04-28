import { ref, reactive, watch} from 'vue'
import { defineStore } from 'pinia'
import axios from 'axios'
import { $Err, $DebugInfo, $Log} from '@/helpers/debug'

export const useBeneficiaryStore = defineStore('beneficiary', () => {
  $DebugInfo("BeneficiaryStore")

  const content = ref(null)
  const query = reactive({
    search: '',
  })
  const params = reactive({
    ...InitParam()
  })
  const config = reactive({
    loading: false,
    form: '',
  })

  function InitParam() {
    return {
      lastName: '',
      firstName: '',
      midName: '',
      extName: '',
      bday: '',
    }
  }

  function ChangeForm(form) {
    if(form == '') {
      Object.assign(params, InitParam());
    }
    config.form  = form
  }

  function Edit(row) {
    Object.assign(params, row)
    config.form = 'update'
  }

  async function GetAPI() {
    config.loading = true
    try {
      let { data: {data}} = await axios.get('/api/beneficiary', { params: query })
      content.value = data
    }
    catch(e) {
      $Err('Get API', {e})
    }
    config.loading = false
  }

  async function StoreAPI() {
    try {
      let { data: {data}} = await axios.post('/api/beneficiary', params)
      $Log('Store API', {data})
      GetAPI();
      ChangeForm('')
    }
    catch(e) {
      $Err('Store API Error', {e})
    }
  }

  async function UpdateAPI(id) {
    try {
      let { data: {data}} = await axios.put(`/api/beneficiary/${id}`, params)
      $Log("Update API", {data})
      GetAPI();
      ChangeForm('')
    }
    catch(e) {
      $Err("Update API ERRor", {e})
    }
  }

  async function DeleteAPI(id, idx) {
    content.value.splice(idx, 1)
    try {
      let { data: {data}} = await axios.delete(`/api/beneficiary/${id}`)
      $Log("Delete API Response", {data})
    }
    catch(e) {
      $Err("Delete API Error", {e})
    }
  }

  return {
    content,
    query,
    params,
    config,

    Edit,
    ChangeForm,

    GetAPI,
    StoreAPI,
    DeleteAPI,
    UpdateAPI
  }
})
