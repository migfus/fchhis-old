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

  function NotifyToggle() {
    config.notify = false
    localStorage.setItem('transaction-notify', true)
  }

  async function GetAPI(page = 1) {
    config.loading = true
    try {
      let { data: {data }} = await axios.get('/api/transactions', { params: { ...params, page: page} })
      content.value = data
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

    GetAPI,
    Update,
    Delete,
    NotifyToggle,
  }
})
