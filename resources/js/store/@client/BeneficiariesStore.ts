import { useStorage, StorageSerializers } from '@vueuse/core'
import { defineStore } from 'pinia'
import axios from 'axios'
import { reactive } from 'vue'

type configInt = {
    loading: boolean
}
type queryInt = {
    search: string
}
const title = '@client/BeneficiariesStore'

export const useBeneficiariesStore = defineStore(title, () => {
    const CancelToken = axios.CancelToken;
    let cancel;

    const content = useStorage(`${title}/content`, null, localStorage, { serializer: StorageSerializers.object })
    const config = useStorage<configInt>(`${title}/config`, { loading: false }, localStorage, { serializer: StorageSerializers.object })
    const query = reactive<queryInt>({ search: '' })


    // SECTION API

    function CancelAPI() {
        cancel()
    }

    async function GetAPI() {
        config.value.loading = true
        try {
            let { data: {data}} = await axios.get('/api/users', {
                cancelToken: new CancelToken(function executor(c) { cancel = c; }),
                params: { ...query }
            })
            content.value = data
        }
        catch(e) {
            console.log('UsersStore GetAPI Error', {e})
        }
        config.value.loading = false
    }

    return {
        content,
        config,
        query,
        print,

        GetAPI,
        CancelAPI,
    }
})
