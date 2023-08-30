import { defineStore } from 'pinia'
import axios from 'axios'
import { useStorage, StorageSerializers } from '@vueuse/core'
import { reactive } from 'vue'
import { useUserDetailsStore } from '@/store/@staff/UserDetailStore'

type IConfig = {
    loading: boolean
    form: string
}
type TParams = {
    userId: number
    agent_id: number
    or: string
    pay_type_id: number
    plan_id: number
    amount: number
}

const title = '@staff/UserDetailTransactionStore'

export const useUserDetailTransactionStore = defineStore(title, () => {
    const $user = useUserDetailsStore();

    const config = reactive<IConfig>({
        loading: false,
        form: null
    })
    const params = reactive<TParams>(InitParams())


    // SECTION API
    async function StoreAPI() {
        try {
            let {data: {data}} = await axios.post(`/api/transaction`, params )
            config.form = null
            Object.assign(params, InitParams())
            $user.GetAPI(params.userId)
        }
        catch(e) {
            console.log('ADD API ERROR', {e})
        }
    }

    function InitParams() {
        return {
            userId: null,
            agent_id: null,
            or: '',
            pay_type_id: null,
            plan_id: null,
            amount: 0,
        }
    }

    // SECTION FUNCTIONS
    return {
        config,
        params,

        StoreAPI,
    }
})
