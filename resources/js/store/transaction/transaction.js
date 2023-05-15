import { ref, reactive } from 'vue'
import { defineStore } from 'pinia'
import axios from 'axios'
import { $DebugInfo, $Err, $Log } from '@/helpers/debug'

export const useTransactionStore = defineStore('transaction', () => {
  $DebugInfo('TransactionStore')
  const content = ref([])
  const printContent = ref([])
  const config = reactive({
    loading: false,
    viewAll: false,
    notify: localStorage.getItem('transaction-notify') ? false : true,
    form: '',
    tableView: false
  })
  const params = reactive({
    ...InitValue(),
  })
  const query = reactive({
    search: '',
    target: 6, // show transaction by role (idK)
    filter: 'name',
    search: '',
    start: '',
    end: '',
    limit: 10,
    role: '',
    print: false,
  })

  function InitValue() {
    return {
      or: '',
      amount: 0,
      plan: {
        id: '',
      },
      pay_type_id: '',
      client: {
        person: {
          id: '',
        }
      },
      agent: {
        person: {
          id: '',
        }
      },
    }
  }

  function Clear() {
    Object.assign(params, InitValue())
    config.form = ''
  }

  async function GetAPI(page = 1) {
    config.loading = true
    try {
      let { data: {data, sum}} = await axios.get('/api/transactions', { params: { ...query, page: page} })
      content.value = data
    }
    catch(e) {
      $Err('GetAPI Err', {e})
    }
    config.loading = false
  }

  async function PrintAPI() {
    config.loading = true
    try {
      let { data: {data}} = await axios.get('/api/transactions', { params: query })
      printContent.value = data
    }
    catch(e) {
      $Err("PrintAPI Err", {e})
    }
    config.loading = false
  }

  async function AddAPI() {
    try {
      let { data: {data}} = await axios.post('/api/transactions', params)
      GetAPI(1)
      Object.assign(params, InitValue())
      config.form = ''

      window.scrollTo({
        top: 0,
        left: 0,
        behavior: 'smooth',
      })
    }
    catch (e) {
      $Err('AddAPI Err', {e})
    }
  }

  function Update(row) {
    config.form = 'update'
    console.log({row})
    Object.assign(params, row)

    window.scrollTo({
      top: 0,
      left: 0,
      behavior: 'smooth',
    })
  }

  async function UpdateAPI(id) {
    try {
      let { data: {data}} = await axios.put(`/api/transactions/${id}`, params)
      GetAPI(1)
      Object.assign(params, InitValue())
      config.form = ''

      window.scrollTo({
        top: 0,
        left: 0,
        behavior: 'smooth',
      })
    }
    catch (e) {
      $Err('UpdateAPI Err', {e})
    }
  }

  async function DeleteAPI(row, idx) {
    try {
      content.value.splice(idx, 1)
      let { data: {data}} = await axios.delete(`/api/transactions/${row.id}`)
      $Log("DeleteAPI", {data})
      GetAPI()
    }
    catch(e) {
      $Err('DeleteAPI Err', {e})
    }
  }

  return {
    content,
    config,
    params,
    query,
    printContent,

    Clear,
    GetAPI,
    PrintAPI,
    AddAPI,
    DeleteAPI,
    UpdateAPI,
    Update,
  }
})
