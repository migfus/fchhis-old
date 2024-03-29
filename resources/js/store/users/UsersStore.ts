import { useStorage, StorageSerializers } from '@vueuse/core'
import { defineStore } from 'pinia'
import axios from 'axios'
import { useToast } from 'vue-toastification'
import { reactive } from 'vue'

type IConfig = {
    loading: boolean
    notify: boolean
    form: string
    tableView: boolean
    viewAll: boolean
    RemoveNotify: boolean
}
type IQuery = {
    search: string
    sort: 'ASC' | 'DESC'
    limit: number
    start: string
    end: string
    filter: string
    role: number
    overdue: boolean
}
type IParams = {
    avatar: string
    username: string
    email: string
    password: string
    role: number
    plan: number
    pay_type_id: number
    transaction: number,
    agent_id: string
    mobile: string
    name: string
    sex: boolean
    bday: string
    bplace_id: number
    address: string
    address_id: number
    or: string
    agent: number
    plan_details_id: number
    id: number
    phones?: Array<{phone: string}>
}
type ICounts = Array<{
    name: string
    color: string
    icon: string
    count: string
}>
type IList = {
    data: Array<{
        avatar: string
        name: string
        role: number
        username: string
        email: string
        created_at: dateFns
    }>
}

const title = 'users/UsersStore'

export const useUsersStore = defineStore(title, () => {
    const $toast = useToast();
    const CancelToken = axios.CancelToken;
    let cancel;

    // DEBUG ADd type on 'content' & 'print'
    const content = useStorage(`${title}/content`, null, localStorage, { serializer: StorageSerializers.object })
    const print = useStorage(`${title}/print`, null, localStorage)
    const config = reactive<IConfig>({
        loading: false,
        notify: true,
        form: '',
        tableView: false,
        viewAll: false,
        RemoveNotify: false
    })
    const query = reactive<IQuery>({
        search: '',
        sort: 'ASC',
        limit: 10,
        start: '',
        end: '',
        filter: 'name',
        role: 6,
        overdue: false
    })
    const params = useStorage<IParams>(`${title}/params`, {
        ...InitParams(),

    }, localStorage, { serializer: StorageSerializers.object })
    const counts = useStorage<ICounts>(`${title}/counts`, null, localStorage);
    const list = useStorage<IList>(`${title}/list`, null, localStorage);


    // SECTION API
    async function GetAPI(page = 1) {
        config.loading = true
        try {
            let { data: {data}} = await axios.get('/api/users', {
                cancelToken: new CancelToken(function executor(c) { cancel = c; }),
                params: { ...query, page: page}
            })
            content.value = data
        }
        catch(e) {
            console.log('UsersStore GetAPI Error', {e})
        }
        config.loading = false
    }

    async function PrintAPI() {
        try {
            let { data: {data}} = await axios.get('/api/users', {
                cancelToken: new CancelToken(function executor(c) { cancel = c; }),
                params: { ...query, print: true}
            })
            print.value = data
        }
        catch(e) {
            console.log('UsersStore PrintAPI Error', {e})
        }
    }

    function CancelAPI() {
        cancel()
        content.value = null
    }

    async function StoreAPI() {
        try {
            let { data: { data }} = await axios.post('/api/users', params.value)
            Object.assign(params.value, {... InitParams()})
            $toast.success('Successfully created');
            GetAPI(1)
            ChangeForm('')
        }
        catch(e) {
            console.log('UsersTore SToreAPI Error', {e})
        }
    }

    async function UpdateAPI(id) {
        try {
            let { data: { data }} = await axios.put('/api/users/'+id, params.value)
            Object.assign(params.value, {... InitParams()})
            $toast.success('Successfully created');
            GetAPI(1)
            ChangeForm('')
        }
        catch(e) {
            console.log('UsersTore SToreAPI Error', {e})
        }
    }

    async function DestroyAPI(id) {
        try {
            let { data: { data }} = await axios.delete('/api/users/'+ id)
            $toast.success('Successfully deleted');
            GetAPI(1)
        }
        catch(e) {
            console.log('UsersTore SToreAPI Error', {e})
        }
    }

    // SECTION FUNCTIONS
    function ChangeForm(input) {
        config.form = input
        window.scrollTo({
            top: 0,
            left: 0,
            behavior: 'smooth',
        })
    }



    function InitParams() {
        return {
            avatar: '',
            username: '',
            email: '',
            password: '',
            role: 6,
            plan: 1,
            pay_type_id: 1,
            transaction: 0,
            agent_id: '',
            mobile: '',
            name: '',
            sex: true,
            bday: '',
            bplace_id: 0,
            address: '',
            address_id: 0,
            or: '',
            phones: null,
            agent: 0,
            plan_details_id: 0,
            id: 0
        }
    }

    function Update(row) {
        Object.assign(params.value, row)

        config.form = 'update'

        window.scrollTo({
            top: 0,
            left: 0,
            behavior: 'smooth'
        });
    }

    // DEBUG IDK
    function GetCount() {
        return counts.value
    }

    return {
        content,
        config,
        query,
        print,
        params,
        counts,

        GetAPI,
        PrintAPI,
        CancelAPI,
        StoreAPI,
        UpdateAPI,
        DestroyAPI,

        ChangeForm,
        Update,
        GetCount,
    }
})
