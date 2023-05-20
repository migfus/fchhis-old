import { ref, reactive } from 'vue'
import { defineStore } from 'pinia'
import { $DebugInfo, $Err} from '@/helpers/debug'
import axios from 'axios'

export const useUsersStore = defineStore('useUsersStore', () => {
  $DebugInfo('useUsersStore')
  const CancelToken = axios.CancelToken;
  let cancel;

  const content = ref(null)
  const print = ref(null)
  const config = reactive({
    loading: false
  })
  const query = reactive({
    search: '',
    sort: 'ASC',
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

  return {
    content,
    config,
    query,
    print,

    GetAPI,
    PrintAPI,
    CancelAPI,
  }
})
