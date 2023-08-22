import { ref, reactive } from 'vue'
import { defineStore } from 'pinia'
import axios from 'axios'
import { useToast} from 'vue-toastification'

type configInt = {
  loading: boolean
  viewAll: boolean
  form: string
}
type queryInt = {
  search: string
  sort: 'ASC' | 'DESC'
  start: string
  end: string
  filter: string
}
type paramsInt = {
  or: string
  pay_type: {
    name: string
  }
  pay_type_id: string
  amount: string
  plan: {
    name: string
  }
  client: {
    user: {
      avatar: string
    }
    name: string
    id: string
  }
  agent: {
    user: {
      avatar: string
    }
    name: string
    id: string
  }
}
type contentInt = {
  transaction: any
}

export const useTransactionStore = defineStore('transactions/TransactionStore', () => {
  const $toast = useToast();
  const CancelToken = axios.CancelToken;
  let cancel;

  // DEBUG please add type 'content' & 'print'
  const content = ref<any>(null)
  const print = ref(null)
  const config = reactive<configInt>({
    loading: false,
    viewAll:false,
    form: '',
  })
  const query = reactive<queryInt>({
    search: '',
    sort: 'ASC',
    start: '',
    end: '',
    filter: 'name'
  })
  const params = reactive<paramsInt>({
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
      console.log('StatisticStore GetAPI Error', {e})
    }
    config.loading = false
  }

  async function PrintAPI() {
    try {
      let { data: {data} } = await axios.get('/api/transaction', {
        cancelToken: new CancelToken(function executor(c) { cancel = c; }),
        params: { ...query, print: true}
      })
      print.value = data
    }
    catch(e) {
      console.log('StatisticStore PrintAPI Error', {e})
    }
  }

  async function StoreAPI() {
    try {
      let { data: {data}} = await axios.post('/api/transaction', params)
      if(data) {
        $toast.success('Successfully Added')
        ChangeForm('')
        Object.assign(params, { ...InitParams })
        GetAPI()
      }
    }
    catch(e) {
      console.log('StatisticStore StoreAPI Error', {e})
    }
  }

  async function UpdateAPI(id: bigint) {
    try {
      let { data: {data}} = await axios.put('/api/transaction/'+id, params)
      if(data) {
        $toast.success('Successfully Added')
        ChangeForm('')
        Object.assign(params, { ...InitParams })
        GetAPI()
      }
    }
    catch(e) {
      console.log('StatisticStore UpdateAPI Error', {e})
    }
  }

  async function DestroyAPI(id: bigint, idx: bigint) {
    try {
      let { data: {data}} = await axios.delete('/api/transaction/'+id)
      if(data) {
        $toast.success('Successfully Deleted')
        GetAPI()
      }
    }
    catch(e) {
      console.log('StatisticStore UpdateAPI Error', {e})
    }
  }

  // SECTION FUNCTIONS


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

  function Update(row) {
    Object.assign(params, row)

    window.scrollTo({
      top: 0,
      left: 0,
      behavior: 'smooth'
    });

    ChangeForm('update')
  }

  function InitParams() {
    return {
      or: '',
      pay_type: {
        name: 'Monthly'
      },
      pay_type_id: '',
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
    StoreAPI,
    UpdateAPI,
    DestroyAPI,

    ChangeForm,
    InitParams,
    Update,
  }
})
