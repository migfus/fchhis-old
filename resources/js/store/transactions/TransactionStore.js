import { ref, reactive } from 'vue'
import { defineStore } from 'pinia'
import { $DebugInfo, $Err} from '@/helpers/debug'
import axios from 'axios'

export const useTransactionStore = defineStore('TransactionStore', () => {
  $DebugInfo('TransactionStore')
  const CancelToken = axios.CancelToken;
  let cancel;

  const content = ref(null)
  const print = ref(null)
  const config = reactive({
    loading: false,
    viewAll:false,
    form: '',
  })
  const query = reactive({
    search: '',
    sort: 'ASC',
    start: '',
    end: '',
    filter: 'name'
  })
  const params = reactive({
    ...InitParams(),
  })

  // SECTION API
  async function GetAPI(page = 1) {
    config.loading = true
    try {
      let { data: {data}} = await axios.get('/api/transaction', {
        cancelToken: new CancelToken(function executor(c) { cancel = c; }),
        params: { ...query, page: page}
      })
      content.value = data
    }
    catch(e) {
      $Err('StatisticStore GetAPI Error', {e})
    }
    config.loading = false
  }

  async function PrintAPI() {
    try {
      let { data: {data}} = await axios.get('/api/transaction', {
        cancelToken: new CancelToken(function executor(c) { cancel = c; }),
        params: { ...query, print: true}
      })
      print.value = data
    }
    catch(e) {
      $Err('StatisticStore PrintAPI Error', {e})
    }
  }

  function CancelAPI() {
    cancel()
  }

  function ChangeForm(input) {
    config.form = input

    window.scrollTo({
      top: 0,
      left: 0,
      behavior: 'smooth'
    });
  }

  function InitParams() {
    return {
      or: '',
      payt_type_id: '',
      amount: '',

      plan: {
        name: '',
      },


      client: {
        user: {
          avatar: '',
        },
        name: '',
        id: '',
      },

      agent: {
        user: {
          avatar: '',
        },
        name: '',
        id: '',
      },

    }
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

    ChangeForm,
    InitParams,
  }
})
