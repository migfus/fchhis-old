import { ref, reactive } from 'vue'
import { defineStore } from 'pinia'
import axios from 'axios'
import { useToast } from 'vue-toastification'

type configInt = {
  loading: boolean
  loadingCount: boolean
  enableDelete: boolean
  notify: boolean
  form: string
}
type queryInt = {
  search: string
  filter: string
  start: string
  end: string
}
type paramsInt = {
  avatar: string
  desc: string
  name: string
  start: string
  end: string
  contract_price: string
  spot_payment: string
  spot_service: string
  annual: string
  semi_annual: string
  quarterly: string
  monthly: string
}

export const usePlanStore = defineStore('system/PlanStore', ()=> {
  const $toast = useToast();

  // DEBUG add type for this 'content'
  const content = ref([])
  const count = ref<number>(0)
  const config = reactive<configInt>({
    loading: false,
    loadingCount: false,
    enableDelete: false,
    notify: sessionStorage.getItem('plan-notify') ? true : false,
    form: '',
  })
  const query = reactive<queryInt>({
    search: '',
    filter: 'name',
    start: '',
    end: '',
  })
  const params = ref<paramsInt>({
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
      console.log('GetAPI', {e})
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
      console.log('GetCount Err', {e})
    }
    config.loadingCount = false
  }

  async function UpdateAPI(id: number) {
    config.loading = true
    try {
      let { data: { data } } = await axios.put('/api/plan/'+id, params.value)
      console.log('UpdateAPI', {data})
      ChangeForm('')
      GetAPI()
    }
    catch(e) {
      console.log('UpdateAPI Err', {e})
    }
    config.loading = false
  }

  async function AddAPI() {
    config.loading = true
    try {
      let { data: { data } } = await axios.post('/api/plan', params.value)
      console.log('AddAPI', {data})
      ChangeForm('')
      GetAPI()
      $toast.success('Successfully added')
    }
    catch(e) {
      console.log('AddAPI Err', {e})
    }
    config.loading = false
  }

  async function DeleteAPI(id: number, idx: number) {
    content.value.splice(idx, 1)
    try {
      let { data: { data}} = await axios.delete('/api/plan/' + id)
      console.log('DeleteAPI', {data})
      $toast.success('Successfully deleted')
      GetAPI()
    }
    catch(e) {
      console.log('DeleteAPI Error', {e})
    }
  }


  // SECTION FUNCTIONS
  function RemoveNotify() {
    config.notify = true
    sessionStorage.setItem('plan-notify', '1');
  }

  function ToggleEnableDelete() {
    if(confirm('Deleting plans is not recommended. Are you sure you want to delete?')) {
      config.enableDelete = !config.enableDelete
    }
  }

  function ChangeForm(fo: string) {
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

  function Update(row: paramsInt) {
    params.value = row
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