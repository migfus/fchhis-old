import { defineStore } from 'pinia'
import axios from 'axios'
import { useStorage, StorageSerializers } from '@vueuse/core'
import { reactive } from 'vue'
import type { TGConfig, TPlanDetails, TPayType } from '@/store/GlobalTypes'

type IContent = {
    data: Array<{
        id: number
        or: string
        amount: number
        plan_details: TPlanDetails
        pay_type: TPayType
        created_at: string
    }>
    sumTransactions: number
    sum: number
}

const title = '@staff/TransactionDashboardStore'
export const useTransactionDashboardStore = defineStore(title, () => {
    const CancelToken = axios.CancelToken;
    let cancel;

  // DEBUG please add type 'content' & 'print'
    const content = useStorage<IContent>(`${title}/content` , null, localStorage, { serializer: StorageSerializers.object })
    const config = reactive<TGConfig>({
        loading: false,
    })

    // SECTION API
    function CancelAPI() {
        cancel()
        content.value = null
    }

    async function GetAPI() {
        config.loading = true
        try {
            let { data: {data}} = await axios.get('/api/transaction/dashboard', {
                cancelToken: new CancelToken(function executor(c) { cancel = c; })
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

        GetAPI,
        CancelAPI,
    }
})
