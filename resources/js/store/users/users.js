import { ref, reactive, watch } from 'vue'
import { defineStore } from 'pinia'
import axios from 'axios'
import { useToast } from 'vue-toastification'
import { useRoute } from 'vue-router'

export const useUserStore = defineStore('users', () => {
  const $toast = useToast();
  const $route = useRoute();

  const list = ref([])
  const counts = ref([])
  const input = ref({
   ...InitInput()
  })
  const params = reactive({
    role: 7,
    search: $route.query.search || '',
    start: '',
    end: '',
    filter: $route.query.filter || 'name',
  })
  const config = reactive({
    tableView: false,
    viewAll: false,
    loading: false,
    countLoading: false,
    notify: localStorage.getItem('removed-user-notify') ? false : true,
    form: '', // [add] [update] []
  })

  function InitInput() {
    return {
      avatar: '',
      username: '',
      email: '',
      password: '',
      mobile: '',
      notifyMobile: true,
      role: 'client',
      plan: 1,

      lastName: '',
      firstName: '',
      midName: '',
      extName: '',
      sex: true,
      bday: '',
      bplaceID: 258,
      addressID: 258,
      address: '',
    }
  }

  function RemoveNotify() {
    config.notify = false
    localStorage.setItem('removed-user-notify', true);
  }

  function ChangeForm(_input) {
    if(_input != '') {
      window.scrollTo({
        top: 0,
        left: 0,
        behavior: 'smooth',
      })
    }

    else {
      input.value = {
        ...InitInput()
      }
    }

    config.form = _input
  }

  async function GetAPI(page = 1) {
    config.loading = true
    try {
      let { data: { data } } = await axios.get(`/api/users`, {
        params: {
          page: page,
          ...params
        }
      })
      list.value = data
    }
    catch (e) {
      console.log({ e })
    }
    config.loading = false
  }

  async function GetCount() {
    config.countLoading = true
    try {
      let { data: { data } } = await axios.get(`/api/users`, { params: {
        count: true,
      }})
      counts.value = data
    }
    catch(e) {
      console.log({ e })
    }
    config.countLoading = false
  }

  async function Delete(id, idx) {
    if (confirm("Do you want to delete")) {
      list.value.data.splice(idx, 1)
      try {
        let { data } = await axios.delete(`/api/users/${id}`)
        GetAPI()
        console.log({ data })
      }
      catch (e) {
        console.log({ e })
      }
    }
  }

  async function Add() {
    config.loading = true
    try {
      let { data : {data } } = await axios.post(`/api/users`, input.value)
      console.log({ data })
      GetAPI()
      ChangeForm('')
      $toast.success('Successfully added');
    }
    catch (e) {
      console.log({ e })
    }
    config.loading = false
    window.scrollTo({
      top: 0,
      left: 0,
      behavior: 'smooth'
    });
  }

  function Info() {
    $toast.warning('ifno')
  }

  function Update(row) {
    input.value = row

    config.form = 'update'

    window.scrollTo({
      top: 0,
      left: 0,
      behavior: 'smooth'
    });
  }

  async function UpdateAPI() {
    config.loading = true
    try {
      let { data: { data}} = await axios.put(`/api/users/${input.value.id}`, input.value)
      console.log({data})
      GetAPI()
      $toast.success('Successfully updated');
    }
    catch(e) {
      console.log({e})
    }
    config.loading = false
    window.scrollTo({
      top: 0,
      left: 0,
      behavior: 'smooth'
    });
    ChangeForm('')
  }



  return {
    list,
    counts,
    params,
    config,
    input,

    ChangeForm,
    RemoveNotify,
    GetAPI,
    GetCount,
    Delete,
    Info,
    Update,
    Add,
    UpdateAPI
  }
})