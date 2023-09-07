import { useStorage, StorageSerializers } from '@vueuse/core'
import { defineStore } from 'pinia'
import axios from 'axios'
import { reactive } from 'vue'
import type { TGConfig } from '@/store/GlobalTypes'

const title = '@staff/ClientsDashboardStore'
export const useClientsDashboardStore = defineStore(title, () => {
    const CancelToken = axios.CancelToken;
    let cancel;

    const content = useStorage(`${title}/content`, null, localStorage, { serializer: StorageSerializers.object })
    const config = reactive<TGConfig>({
        loading: false
    })

    // SECTION API
    async function GetAPI() {
        config.loading = true
        try {
            let { data: {data}} = await axios.get('/api/users/dashboard', { cancelToken: new CancelToken(function executor(c) { cancel = c; }) })
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
