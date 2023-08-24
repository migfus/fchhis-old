import { defineStore } from 'pinia'
import axios from 'axios'
import { useToast } from 'vue-toastification'
import { useStorage, StorageSerializers } from '@vueuse/core'
import { reactive } from 'vue'

type configInt = {
    loading: boolean
}
type queryInt = {
    search: string
    sort: 'ASC' | 'DESC'
}
type contentInt = {
    transaction: any
}

const title = '@client/TransactionsStore'

export const useTransactionStore = defineStore(title, () => {
    const CancelToken = axios.CancelToken;
    let cancel;

  // DEBUG please add type 'content' & 'print'
    const content = useStorage<any>(`${title}/content` , null, localStorage, { serializer: StorageSerializers.object })
    const print = useStorage(`${title}/print`, null, localStorage)
    const config = useStorage<configInt>(`${title}/config`, {
        loading: false,
    }, localStorage, {serializer:StorageSerializers.object })
    const query = reactive<queryInt>({
        search: '',
        sort: 'ASC',
    })


    // SECTION API
    function CancelAPI() {
        cancel()
    }

    async function GetAPI(page = 1) {
        config.value.loading = true
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
        config.value.loading = false
    }

    async function PrintAPI() {
        try {
            let { data: {data} } = await axios.get('/api/transaction', {
                cancelToken: new CancelToken(function executor(c) { cancel = c; }),
                params: { ...query.value, print: true}
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
