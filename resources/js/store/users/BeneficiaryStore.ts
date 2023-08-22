import { ref, reactive } from 'vue'
import { defineStore } from 'pinia'
import axios from 'axios'
import { useToast } from 'vue-toastification'

type configInt = {
  loading: boolean
  form: string
}
type queryInt = {
  search: string
  sort: 'ASC' | 'DESC'
  limit: number
  start: string
  end: string
  filter: string
}
type paramsInt = {
  avatar: string
  username: string
  email: string
  password: string
  role: number
  plan: number
  pay_type_id: number
  transaction: number
  agent_id: string
  mobile: string
  name: string
  sex: boolean
  bday: string
  bplace_id: string
  address: string
  address_id: string
  or: string
}

export const useBeneficiaryStore = defineStore('users/BeneficiaryStore', () => {
  const $toast = useToast();
  const CancelToken = axios.CancelToken;
  let cancel;

  // DEBUG ADD TYPE on 'content' & 'print'
  const content = ref(null)
  const print = ref(null)
  const config = reactive<configInt>({
    loading: false,
    form: '',
  })
  const query = reactive<queryInt>({
    search: '',
    sort: 'DESC',
    limit: 10,
    start: '',
    end: '',
    filter: 'name',
  })
  const params = reactive<paramsInt>({
    ...InitParams(),
  })

  // SECTION API
  async function GetAPI(page = 1) {
    config.loading = true
    try {
      let { data: {data}} = await axios.get('/api/beneficiary', {
        cancelToken: new CancelToken(function executor(c) { cancel = c; }),
        params: { ...query, page: page}
      })
      content.value = data
    }
    catch(e) {
      console.log('UsersStore GetAPI Error', {e})
    }
    config.loading = false
  }

  async function PrintAPI() {
    try {
      let { data: {data}} = await axios.get('/api/users', {
        cancelToken: new CancelToken(function executor(c) { cancel = c; }),
        params: { ...query, print: true}
      })
      print.value = data
    }
    catch(e) {
      console.log('UsersStore PrintAPI Error', {e})
    }
  }

  function CancelAPI() {
    cancel()
  }

  async function StoreAPI() {
    try {
      let { data: { data }} = await axios.post('/api/users', params)
      Object.assign(params, {... InitParams()})
      $toast.success('Successfully created');
      GetAPI(1)
      ChangeForm('')
    }
    catch(e) {
      console.log('UsersTore SToreAPI Error', {e})
    }
  }

  // SECTION FUNCTIONS
  function ChangeForm(input: string) {
    config.form = input
    window.scrollTo({
      top: 0,
      left: 0,
      behavior: 'smooth',
    })
  }

  function InitParams() {
    return {
      avatar: '',
      username: '',
      email: '',
      password: '',
      role: 6,
      plan: 1,
      pay_type_id: 1,
      transaction: 0,
      agent_id: '',
      mobile: '',
      name: '',
      sex: true,
      bday: '',
      bplace_id: '',
      address: '',
      address_id: '',
      or: '',
    }
  }

  function Update(row: paramsInt) {
    Object.assign(params, row)

    config.form = 'update'

    window.scrollTo({
      top: 0,
      left: 0,
      behavior: 'smooth'
    });
  }

  return {
    content,
    config,
    query,
    print,
    params,

    GetAPI,
    PrintAPI,
    CancelAPI,
    StoreAPI,

    ChangeForm,
    Update,
  }
})
