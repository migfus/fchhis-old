import { useStorage, StorageSerializers } from '@vueuse/core'
import { defineStore } from 'pinia'
import axios from 'axios'
import { reactive } from 'vue'

type IConfig = {
    loading: boolean
}
type IQuery = {
    search: string
}
const title = '@client/BeneficiariesStore'

export const useBeneficiariesStore = defineStore(title, () => {
    const CancelToken = axios.CancelToken;
    let cancel;

    const content = useStorage(`${title}/content`, null, localStorage, { serializer: StorageSerializers.object })
    const config = reactive<IConfig>({ loading: false })
    const query = reactive<IQuery>({ search: '' })

    // SECTION API
    function CancelAPI() {
        cancel()
        content.value = null
    }

    async function GetAPI() {
        config.loading = true
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
        config.loading = false
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
