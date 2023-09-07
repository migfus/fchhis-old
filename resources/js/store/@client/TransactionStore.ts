import { defineStore } from 'pinia'
import axios from 'axios'
import { useStorage, StorageSerializers } from '@vueuse/core'
import { reactive } from 'vue'
import type { TGConfig, TGQuery, TPlanDetails, TPayType } from '@/store/GlobalTypes'

type IContent = {
    data: Array<{
        id: number
        or: string
        amount: number
        plan_details: TPlanDetails
        pay_type: TPayType
        created_at: dateFns
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
    const config = reactive<TGConfig>({
        loading: false,
    })
    const query = reactive<TGQuery>({
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

    // SECTION FUNCTIONS
    return {
        content,
        config,
        query,

        GetAPI,
        CancelAPI,
    }
})
