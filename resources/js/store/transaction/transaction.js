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
  const params = reactive ({
    search: '',
    filter: '',
    target: 6, // show transaction by role (idK)
    filter: '',
    search: '',
    start: '',
    end: '',
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
  const _sum = ref(0)

  function NotifyToggle() {
    config.notify = false
    localStorage.setItem('transaction-notify', true)
  }

  async function GetAPI(page = 1) {
    config.loading = true
    try {
      let { data: {data, sum}} = await axios.get('/api/transactions', { params: { ...query, page: page} })
      content.value = data
      _sum.value = sum
    }
    catch(e) {
      $Err('GetAPI Err', {e})
    }
    config.loading = false
  }

  function Update() {

  }

  function Delete() {

  }

  return {
    content,
    config,
    params,
    _sum,
    query,

    GetAPI,
    Update,
    Delete,
    NotifyToggle,
  }
})
