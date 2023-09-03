import { defineStore } from 'pinia'
import axios from 'axios'
import { useStorage, StorageSerializers } from '@vueuse/core'
import { reactive } from 'vue'
import { useRoute } from 'vue-router'

type TContent = Array<{
    name: string
    bday: Date
    id: number
}>
type TParams = {
    id: number
    name: string
    bday: string
}
type TConfig = {
    loading: boolean
    form: string
}

const title = '@staff/UserDetailBeneficiariesStore'

export const useUserDetailBeneficiariesStore = defineStore(title, () => {
    const $route = useRoute()

    const content = useStorage<TContent>(`${title}/content`, null, localStorage, { serializer: StorageSerializers.object })
    const config = reactive<TConfig>({
        loading: false,
        form: null
    })
    const params = reactive<TParams>({
        ...ParamsInit()
    })

    // SECTION API
    async function GetAPI() {
        config.loading = true
        try {
            let { data: {data}} = await axios.get('/api/beneficiary/', { params: { id: Number($route.params.id) }})
            content.value = data
        }
        catch(e) {
            console.log('Get API Error', {e})
        }
        config.loading = false
    }

    async function DestroyAPI(id: number) {
        params.id = id
        try {
            let { data } = await axios.delete(`/api/beneficiary/${params.id}`)
            GetAPI()
        }
        catch(e) {
            console.log('DLETE API Error', {e})
        }
    }

    async function UpdateAPI() {
        try {
            let { data } = await axios.put(`/api/beneficiary/${params.id}`, { ...params, userId: Number($route.params.id) })
            ResetParams()
            GetAPI()
        }
        catch(e) {
            console.log('UpdateAPI ERR', {e})
        }
    }

    async function StoreAPI() {
        try {
            let { data } = await axios.post(`/api/beneficiary`, params )
            ResetParams()
            GetAPI()
        }
        catch(e) {
            console.log('add API Error', {e})
        }

    }

    function Update(data) {
        params.id = data.id
        params.name = data.name
        params.bday = data.bday

        config.form = 'update'
    }

    function ResetParams() {
        Object.assign(params, ParamsInit())
        config.form = null
    }

    function ParamsInit() {
        return {
            userId: null,
            id: null,
            name: '',
            bday: '',
        }
    }


    return {
        content,
        config,
        params,

        GetAPI,
        DestroyAPI,
        UpdateAPI,
        StoreAPI,

        Update,
        ResetParams,
    }
})
