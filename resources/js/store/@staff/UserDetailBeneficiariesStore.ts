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
}

const title = '@staff/UserDetailBeneficiariesStore'

export const useUserDetailBeneficiariesStore = defineStore(title, () => {

    const content = useStorage<TContent>(`${title}/content`, null, localStorage, { serializer: StorageSerializers.object })
    const config = reactive<{loading: boolean}>({
        loading: false,
    })
    const params = reactive<TParams>({
        userId: null,
        id: null
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

    function ChangeForm(form = '') {
        return 1;
    }

    return {
        content,
        config,
        params,

        GetAPI,
        DestroyAPI,
        ChangeForm,
    }
})
