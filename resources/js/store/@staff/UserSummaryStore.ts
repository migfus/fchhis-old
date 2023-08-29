import { useStorage, StorageSerializers } from '@vueuse/core'
import { defineStore } from 'pinia'
import axios from 'axios'
import { useToast } from 'vue-toastification'
import { reactive } from 'vue'

type IConfig = {
    loading: boolean
}
type TContent = Array<{
    name: string
    color: string
    icon: string
    count: string
}>

const title = '@staff/UserSummaryStore'

export const useUserSummaryStore = defineStore(title, () => {
    const $toast = useToast();
    const CancelToken = axios.CancelToken;
    let cancel;

    const content = useStorage<TContent>(`${title}/content`, null, localStorage, { serializer: StorageSerializers.object })
    const config = reactive<IConfig>({
        loading: false
    })

    // SECTION API
    async function GetAPI() {
        config.loading = true
        try {
            let { data: {data}} = await axios.get('/api/users/count', {
                cancelToken: new CancelToken(function executor(c) { cancel = c; })
            })
            content.value = data
        }
        catch(e) {
            console.log('UsersStore GetAPI Error', {e})
        }
        config.loading = false
    }

    function CancelAPI() {
        cancel()
        content.value = null
    }

    return {
        content,
        config,

        GetAPI,
        CancelAPI,
    }
})
