import { ref, reactive } from 'vue'
import { defineStore } from 'pinia'
import { $DebugInfo, $Err} from '@/helpers/debug'
import axios from 'axios'
import { useToast } from 'vue-toastification'

export const useUsersStore = defineStore('useUsersStore', () => {
  $DebugInfo('useUsersStore')
  const $toast = useToast();
  const CancelToken = axios.CancelToken;
  let cancel;

  const content = ref(null)
  const print = ref(null)
  const config = reactive({
    loading: false,
    notify: true,
    form: '',
    tableView: false,
    viewAll: false,
  })
  const query = reactive({
    search: '',
    sort: 'ASC',
    limit: 10,
    start: '',
    end: '',
    filter: 'name',
    role: 6
  })
  const params = reactive({
    ...InitParams(),
  })

  // SECTION API
  async function GetAPI(page = 1) {
    config.loading = true
    try {
      let { data: {data}} = await axios.get('/api/users', {
        cancelToken: new CancelToken(function executor(c) { cancel = c; }),
        params: { ...query, page: page}
      })
      content.value = data
    }
    catch(e) {
      $Err('UsersStore GetAPI Error', {e})
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
      $Err('UsersStore PrintAPI Error', {e})
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
      $Err('UsersTore SToreAPI Error', {e})
    }
  }

  async function UpdateAPI(id) {
    try {
      let { data: { data }} = await axios.put('/api/users/'+id, params)
      Object.assign(params, {... InitParams()})
      $toast.success('Successfully created');
      GetAPI(1)
      ChangeForm('')
    }
    catch(e) {
      $Err('UsersTore SToreAPI Error', {e})
    }
  }

  async function DestroyAPI(id) {
    try {
      let { data: { data }} = await axios.delete('/api/users/'+id)
      $toast.success('Successfully deleted');
      GetAPI(1)
    }
    catch(e) {
      $Err('UsersTore SToreAPI Error', {e})
    }
  }

  // SECTION FUNCTIONS
  function ChangeForm(input) {
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

  function Update(row) {
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
    UpdateAPI,
    DestroyAPI,

    ChangeForm,
    Update,
  }
})
