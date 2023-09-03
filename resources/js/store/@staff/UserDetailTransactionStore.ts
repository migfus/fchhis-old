import { defineStore } from 'pinia'
import axios from 'axios'
import { useStorage, StorageSerializers } from '@vueuse/core'
import { reactive } from 'vue'
import { useUserDetailsStore } from '@/store/@staff/UserDetailStore'
import { useRoute } from 'vue-router'

type IConfig = {
    loading: boolean
    form: string
}
type TParams = {
    agent_id: number
    or: string
    pay_type_id: number
    plan_id: number
    amount: number
    client_id: number
    id: number
}

const title = '@staff/UserDetailTransactionStore'

export const useUserDetailTransactionStore = defineStore(title, () => {
    const $user = useUserDetailsStore();
    const $route = useRoute();

    const config = reactive<IConfig>({
        loading: false,
        form: null
    })
    const params = reactive<TParams>(InitParams())


    // SECTION API
    async function StoreAPI() {
        try {
            let {data: {data}} = await axios.post(`/api/transaction`, params )
            ResetParams()
            $user.GetAPI()
        }
        catch(e) {
            console.log('ADD API ERROR', {e})
        }
    }

    async function UpdateAPI() {
        try {
            let { data } = await axios.put(`/api/transaction/${params.id}`, { ...params, client_id: $route.params.id })
            ResetParams()
            $user.GetAPI()
        }
        catch(e) {
            console.log('UPDate api errpR', {e})
        }
    }

    function ResetParams() {
        Object.assign(params, InitParams())

        config.form = null
    }

    function Update(row) {
        params.id = row.id,
        params.agent_id = row.agent.id,
        params.or = row.or,
        params.pay_type_id = row.pay_type.id,
        params.plan_id = row.plan.id,
        params.amount = row.amount,

        config.form = 'update'
    }

    function InitParams() {
        return {
            id: null,
            agent_id: null,
            or: '',
            pay_type_id: null,
            plan_id: null,
            amount: 0,
            client_id: null,
        }
    }

    // SECTION FUNCTIONS
    return {
        config,
        params,

        StoreAPI,
        UpdateAPI,

        ResetParams,
        Update,
    }
})
