import { defineStore } from 'pinia'
import axios from 'axios'
import { useStorage, StorageSerializers } from '@vueuse/core'
import { reactive } from 'vue'
import { useRoute } from 'vue-router'
import type { TGConfig, TAuthContent } from '../GlobalTypes'

type TParams = {
    region_id: bigint
    branch_id: bigint
    id: bigint
    role: string
    plan_id: bigint
    pay_type_id: bigint
    agent_id: bigint
    staff_id: bigint
    due_at: dateFns
    name: string
    sex: boolean
    bday: dateFns
    bplace_id: bigint
    address: string
    address_id: bigint
}

const title = '@staff/UserDetailsStore'
export const useUserDetailsStore = defineStore(title, () => {
    const $route = useRoute()

    const content = useStorage<TAuthContent>(`${title}/content`, null, localStorage, { serializer: StorageSerializers.object })
    const config = reactive<TGConfig>({
        loading: false,
        form: null
    })
    const params = reactive<TParams>({
        region_id: null,
        branch_id: null,
        id: null,
        role: null,
        plan_id: null,
        pay_type_id: null,
        agent_id: null,
        staff_id: null,
        due_at: null,
        name: null,
        sex: null,
        bday: null,
        bplace_id: null,
        address: null,
        address_id: null,
    })

    // SECTION API
    async function GetAPI() {
        config.loading = true
        try {
            let { data: {data}} = await axios.get('/api/users/'+ Number($route.params.id))
            content.value = data
        }
        catch(e) {
            console.log('Get API Error', {e})
        }
        config.loading = false
    }

    function InitParams() {
        Object.assign(params, {
            region_id: content.value.region_id,
            branch_id: content.value.branch_id,
            id: content.value.id,
            role: content.value.role,
            plan_id: content.value.info.plan_details_id,
            pay_type_id: content.value.info.pay_type_id,
            agent_id: content.value.info.agent_id,
            staff_id: content.value.info.staff_id,
            due_at: content.value.info.due_at,
            name: content.value.name,
            sex: content.value.info.sex,
            bday: content.value.info.bday,
            bplace_id: content.value.info.bplace_id,
            address: content.value.info.address,
            address_id: content.value.info.address_id,
        })
    }

    return {
        content,
        config,
        params,

        GetAPI,

        InitParams,
    }
})
