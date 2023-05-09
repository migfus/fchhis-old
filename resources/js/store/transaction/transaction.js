import { ref, reactive } from 'vue'
import { defineStore } from 'pinia'
import axios from 'axios'
import { $DebugInfo, $Err, $Log } from '@/helpers/debug'

export const useTransactionStore = defineStore('transaction', () => {
  $DebugInfo('TransactionStore')
  const content = ref([])
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
    filter: '',
    target: 6, // show transaction by role (idK)
    filter: '',
    search: '',
    start: '',
    end: '',
    limit: 10,
  })

  function InitValue() {
    return {
      or: '',
      amount: 0,
      plan_id: '',
      pay_type_id: '',
      client_id: '',
      agent_id: '',
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

  function UpdateAPI() {

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

    Clear,
    GetAPI,
    DeleteAPI,
    UpdateAPI,
  }
})
