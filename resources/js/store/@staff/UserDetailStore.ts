import { defineStore } from 'pinia'
import axios from 'axios'
import { useStorage, StorageSerializers } from '@vueuse/core'
import { reactive } from 'vue'

type TContent = {
    avatar: string
    branch_id: number
    client_transactions: Array<{
        agent_id: number
        amount: number
        client_id: number
        created_at: string
        id: number
        or: number
        pay_type_id: number
        plan_id: number
        staff_id: number
        updated_at: string
    }>
    client_transactions_sum_amount: number
    created_at: string
    email: string
    id: number
    region_id: number
    role: string
    username: string
}

const title = '@staff/UserDetailsStore'

export const useUserDetailsStore = defineStore(title, () => {

    const content = useStorage<TContent>(`${title}/content`, null, localStorage, { serializer: StorageSerializers.object })
    const config = reactive<{loading: boolean}>({
        loading: false,
    })

    // SECTION API
    async function GetAPI(id: bigint) {
        config.loading = true
        try {
            let { data: {data}} = await axios.get('/api/users/'+ id)
            content.value = data
        }
        catch(e) {
            console.log('Get API Error', {e})
        }
        config.loading = false
    }

    return {
        content,
        config,

        GetAPI,
    }
})
