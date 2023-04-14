import { ref, reactive } from 'vue'
import { defineStore } from 'pinia'
import axios from 'axios'

export const useUserStore = defineStore('users', () => {
  const list = ref([])
  const counts = ref([])
  const input = ref({
   ...InitInput()
  })
  const params = reactive({
    role: 7,
    search: '',
    start: '',
    end: '',
    filter: 'name',
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
      plan: 'jasper',

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

  function Info() {
    $toast.warning('ifno')
  }

  function Update() {
    window.scrollTo({
      top: 0,
      left: 0,
      behavior: 'smooth'
    });
    $toast.warning('update')
  }


  return { list, counts, params, config, input, ChangeForm, RemoveNotify, GetAPI, GetCount, Delete, Info, Update}
})
