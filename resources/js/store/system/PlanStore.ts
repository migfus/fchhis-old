import { defineStore } from 'pinia'
import axios from 'axios'
import { useToast } from 'vue-toastification'
import { useStorage, StorageSerializers } from '@vueuse/core'

type configInt = {
    loading: boolean
    loadingCount: boolean
    enableDelete: boolean
    notify: boolean
    form: string
}
type queryInt = {
    search: string
    filter: string
    start: string
    end: string
}
type paramsInt = {
    avatar: string
    desc: string
    name: string
    start: string
    end: string
    contract_price: string
    spot_payment: string
    spot_service: string
    annual: string
    semi_annual: string
    quarterly: string
    monthly: string
}

const title = 'system/PlanStore'
export const usePlanStore = defineStore(title, ()=> {
    const $toast = useToast();

    // DEBUG add type for this 'content'
    const content = useStorage(`${title}/content`, [], localStorage, { serializer: StorageSerializers.object })
    const count = useStorage<number>(`${title}/count`, 0, localStorage)
    const config = useStorage<configInt>(`${title}/config`, {
        loading: false,
        loadingCount: false,
        enableDelete: false,
        notify: sessionStorage.getItem('plan-notify') ? true : false,
        form: '',
    }, localStorage, { serializer: StorageSerializers.object })
    const query = useStorage<queryInt>(`${title}/query`, {
        search: '',
        filter: 'name',
        start: '',
        end: '',
    }, localStorage, { serializer: StorageSerializers.object })
    const params = useStorage<paramsInt>(`${title}/params`, {
        ...InitParams()
    }, localStorage, {serializer: StorageSerializers.object})

    // SECTION API
    async function GetAPI() {
        config.value.loading = true
        try {
            let { data: {data}} = await axios.get('/api/plan', { params: query.value });
            content.value = data
        }
        catch(e) {
            console.log('GetAPI', {e})
        }
        config.value.loading = false
    }

    async function GetCount() {
        config.value.loadingCount = true
        try {
            let { data: {data}} = await axios.get('/api/plan', { params: { count: true }});
            count.value = data
        }
        catch(e) {
            console.log('GetCount Err', {e})
        }
        config.value.loadingCount = false
    }

    async function UpdateAPI(id: number) {
        config.value.loading = true
        try {
            let { data: { data } } = await axios.put('/api/plan/'+id, params.value)
            console.log('UpdateAPI', {data})
            ChangeForm('')
            GetAPI()
        }
        catch(e) {
            console.log('UpdateAPI Err', {e})
        }
        config.value.loading = false
    }

    async function AddAPI() {
        config.value.loading = true
        try {
            let { data: { data } } = await axios.post('/api/plan', params.value)
            console.log('AddAPI', {data})
            ChangeForm('')
            GetAPI()
            $toast.success('Successfully added')
        }
        catch(e) {
            console.log('AddAPI Err', {e})
        }
        config.value.loading = false
    }

    async function DeleteAPI(id: number, idx: number) {
        content.value.splice(idx, 1)
        try {
            let { data: { data}} = await axios.delete('/api/plan/' + id)
            console.log('DeleteAPI', {data})
            $toast.success('Successfully deleted')
            GetAPI()
        }
        catch(e) {
            console.log('DeleteAPI Error', {e})
        }
    }


    // SECTION FUNCTIONS
    function RemoveNotify() {
        config.value.notify = true
        sessionStorage.setItem('plan-notify', '1');
    }

    function ToggleEnableDelete() {
        if(confirm('Deleting plans is not recommended. Are you sure you want to delete?')) {
            config.value.enableDelete = !config.value.enableDelete
        }
    }

    function ChangeForm(fo: string) {
        if(fo == '') {
            params.value = InitParams()
        }
        config.value.form = fo

        window.scrollTo({
            top: 0,
            left: 0,
            behavior: 'smooth',
        })
    }

    function Update(row: paramsInt) {
        params.value = row
        ChangeForm('update')
    }

    function InitParams() {
        return {
            avatar: '',
            desc: '',
            name: '',
            start: '18',
            end: '70',
            contract_price: '',
            spot_payment: '',
            spot_service:'',
            annual: '',
            semi_annual: '',
            quarterly: '',
            monthly: '',
        }
    }

    return {
        content,
        count,
        config,
        query,
        params,

        GetAPI,
        GetCount,
        RemoveNotify,
        ToggleEnableDelete,
        DeleteAPI,
        AddAPI,
        ChangeForm,
        Update,
        UpdateAPI,
    }
})
