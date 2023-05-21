import { ref, reactive } from 'vue'
import { defineStore } from 'pinia'
import axios from 'axios'
import { $DebugInfo, $Err, $Log } from '@/helpers/debug'

export const usePlanStore = defineStore('plan', ()=> {
  $DebugInfo('PlanStore')

  const content = ref([])
  const count = ref([])
  const config = reactive({
    loading: false,
    loadingCount: false,
    notify: false,
    enableDelete: false,
    notify: sessionStorage.getItem('plan-notify') ? true : false,
    form: '',
  })
  const params = reactive({
    search: '',
    filter: 'name',
  })
  const input = ref({
    avatar: '',
    desc: '',
    name: '',
    start: '',
    end: '',
    contract_price: '',
    spot_payment: '',
    spot_service:'',
    annual: '',
    semi_annual: '',
    quarterly: '',
    monthly: '',
  })

  async function GetAPI() {
    config.loading = true
    try {
      let { data: {data}} = await axios.get('/api/plan', { params: params});
      content.value = data
    }
    catch(e) {
      $Err('GetAPI', {e})
    }
    config.loading = false
  }

  async function GetCount() {
    config.loadingCount = true
    try {
      let { data: {data}} = await axios.get('/api/plan', { params: { count: true}});
      count.value = data
    }
    catch(e) {
      $Err('GetCount Err', {e})
    }
    config.loadingCount = false
  }

  function RemoveNotify() {
    config.notify = true
    sessionStorage.setItem('plan-notify', true);
  }

  function ToggleEnableDelete() {
    if(confirm('Deleting plans is not recommended. Are you sure you want to delete?')) {
      config.enableDelete = !config.enableDelete
    }
  }

  async function DeleteAPI(id, idx) {
    content.value.splice(idx, 1)
    try {
      let { data: { data}} = await axios.delete('/api/plan/' + id)
      $Log('DeleteAPI', {data})
    }
    catch(e) {
      $Log('DeleteAPI Error', {e})
    }
  }

  async function AddAPI() {
    config.loading = true
    try {
      let { data: { data } } = await axios.post('/api/plan', input.value)
      $Log('AddAPI', {data})
      GetAPI()
    }
    catch(e) {
      $Err('AddAPI Err', {e})
    }
    config.loading = false
  }

  function ChangeForm(fo) {
    config.form = fo

    window.scrollTo({
      top: 0,
      left: 0,
      behavior: 'smooth',
    })
  }

  function Update(row) {
    input.value = row
    ChangeForm('update')
  }

  async function UpdateAPI() {
    config.loading = true
    try {
      let { data: { data } } = await axios.put('/api/plan', input.value)
      $Log('UpdateAPI', {data})
      GetAPI()
    }
    catch(e) {
      $Err('UpdateAPI Err', {e})
    }
    config.loading = false
  }

  return {
    content,
    count,
    config,
    params,
    input,

    GetAPI,
    GetCount,
    RemoveNotify,
    ToggleEnableDelete,
    DeleteAPI,
    AddAPI,
    ChangeForm,
    Update,
    UpdateAPI,
  }
})
