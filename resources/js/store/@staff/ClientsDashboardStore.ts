import { useStorage, StorageSerializers } from '@vueuse/core'
import { defineStore } from 'pinia'
import axios from 'axios'

type configInt = {
    loading: boolean
}
const title = '@staff/ClientsDashboardStore'

export const useClientsDashboardStore = defineStore(title, () => {
    const CancelToken = axios.CancelToken;
    let cancel;

    const content = useStorage(`${title}/content`, null, localStorage, { serializer: StorageSerializers.object })
    const config = useStorage<configInt>(`${title}/config`, { loading: false }, localStorage, { serializer: StorageSerializers.object })

    // SECTION API
    async function GetAPI() {
        config.value.loading = true
        try {
            let { data: {data}} = await axios.get('/api/users/dashboard', { cancelToken: new CancelToken(function executor(c) { cancel = c; }) })
            content.value = data
        }
        catch(e) {
            console.log('UsersStore GetAPI Error', {e})
        }
        config.value.loading = false
    }

    function CancelAPI() {
        cancel()
    }

    return {
        content,
        config,

        GetAPI,
        CancelAPI,
    }
})
