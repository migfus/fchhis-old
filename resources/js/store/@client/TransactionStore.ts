import { defineStore } from 'pinia'
import axios from 'axios'
import { useStorage, StorageSerializers } from '@vueuse/core'
import { reactive } from 'vue'

type IConfig = {
    loading: boolean
}
type IQuery = {
    search: string
    sort: 'ASC' | 'DESC'
}
type IContent = {
    data: Array<{
        id: number
        or: string
        amount: number
        plan_details: {
            plan: {
                name: string
            }
        }
        pay_type: { name: string}
        created_at: string
    }>
    sumTransactions: number
    sum: number
}

const title = '@client/TransactionsStore'

export const useTransactionStore = defineStore(title, () => {
    const CancelToken = axios.CancelToken;
    let cancel;

  // DEBUG please add type 'content' & 'print'
    const content = useStorage<IContent>(`${title}/content` , null, localStorage, { serializer: StorageSerializers.object })
    const print = useStorage(`${title}/print`, null, localStorage)
    const config = reactive<IConfig>({
        loading: false,
    })
    const query = reactive<IQuery>({
        search: '',
        sort: 'ASC',
    })


    // SECTION API
    function CancelAPI() {
        cancel()
        content.value = null
    }

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

    // SECTION FUNCTIONS
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
