import { ref, reactive } from 'vue'
import { defineStore } from 'pinia'
import axios from 'axios'
import { $DebugInfo, $Err, $Log } from '@/helpers/debug'
import { useToast } from 'vue-toastification'

export const usePlanStore = defineStore('plan', ()=> {
  $DebugInfo('PlanStore')
  const $toast = useToast();

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
  const query = reactive({
    search: '',
    filter: 'name',
    start: '',
    end: '',
  })
  const params = ref({
    ...InitParams()
  })

  // SECTION API
  async function GetAPI() {
    config.loading = true
    try {
      let { data: {data}} = await axios.get('/api/plan', { params: query});
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

  async function AddAPI() {
    config.loading = true
    try {
      let { data: { data } } = await axios.post('/api/plan', params.value)
      $Log('AddAPI', {data})
      ChangeForm('')
      GetAPI()
      $toast.success('Successfully added')
    }
    catch(e) {
      $Err('AddAPI Err', {e})
    }
    config.loading = false
  }

  async function DeleteAPI(id, idx) {
    content.value.splice(idx, 1)
    try {
      let { data: { data}} = await axios.delete('/api/plan/' + id)
      $Log('DeleteAPI', {data})
      $toast.success('Successfully deleted')
      GetAPI()
    }
    catch(e) {
      $Log('DeleteAPI Error', {e})
    }
  }


  // SECTION FUNCTIONS
  function RemoveNotify() {
    config.notify = true
    sessionStorage.setItem('plan-notify', true);
  }

  function ToggleEnableDelete() {
    if(confirm('Deleting plans is not recommended. Are you sure you want to delete?')) {
      config.enableDelete = !config.enableDelete
    }
  }

  function ChangeForm(fo) {
    if(fo == '') {
      params.value = InitParams()
    }
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

  function InitParams() {
    return {
      avatar: '',
      desc: '',
      name: '',
      start: '18',
      end: '70',
      contract_price: '',
      spot_payment: '',
      spot_service:'',
      annual: '',
      semi_annual: '',
      quarterly: '',
      monthly: '',
    }
  }

  return {
    content,
    count,
    config,
    query,
    params,

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
