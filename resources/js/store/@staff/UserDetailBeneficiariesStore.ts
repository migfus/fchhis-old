import { defineStore } from 'pinia'
import axios from 'axios'
import { useStorage, StorageSerializers } from '@vueuse/core'
import { reactive } from 'vue'

type TContent = Array<{
    name: string
    bday: Date
    id: number
}>
type TParams = {
    userId: number
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

    const content = useStorage<TContent>(`${title}/content`, null, localStorage, { serializer: StorageSerializers.object })
    const config = reactive<TConfig>({
        loading: false,
        form: null
    })
    const params = reactive<TParams>({
        userId: null,
        id: null,
        name: '',
        bday: '',
    })

    // SECTION API
    async function GetAPI() {
        config.loading = true
        try {
            let { data: {data}} = await axios.get('/api/beneficiary/', { params: { id: params.userId }})
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
            let {data: {data}} = await axios.delete(`/api/beneficiary/${params.id}`)
            GetAPI()
        }
        catch(e) {
            console.log('DLETE API Error', {e})
        }
    }

    async function AddAPI() {
        try {
            let {data: {data}} = await axios.post(`/api/beneficiary`, params )
            params.name = ''
            params.bday = ''
            config.form = null
            GetAPI()
        }
        catch(e) {
            console.log('add API Error', {e})
        }

    }

    function ChangeForm(form = '') {
        return 1;
    }

    return {
        content,
        config,
        params,

        GetAPI,
        DestroyAPI,
        AddAPI,
        ChangeForm,
    }
})
