import { ref, reactive } from "vue";
import { defineStore } from "pinia";
import { useToast } from "vue-toastification";
import axios from "axios";
import { useDashboardStore } from '@/store/dashboard/dashboard'
import { $Err, $DebugInfo} from '@/helpers/debug'

export const useAuthStore = defineStore("auth", () => {
  $DebugInfo('AuthStore');
  const $toast = useToast();
  const $dash = useDashboardStore();

  const auth = ref(JSON.parse(localStorage.getItem("auth")) || {});
  const token = ref(localStorage.getItem("token") || "");
  const role = auth.role;
  const ip = ref('')
  const config = reactive({
    loading: false
  })

  function UpdateToken(input) {
    token.value = input;
    localStorage.setItem("token", input);
  }

  function UpdateAuth(input) {
    auth.value = input;
    localStorage.setItem("auth", JSON.stringify(input));
  }

  function UpdateAvatar(avatar) {
    auth.value.avatar = avatar;
    localStorage.setItem("auth", JSON.stringify(auth.value));
  }

  function Logout(mode = false) {
    auth.value = "";
    token.value = "";
    localStorage.removeItem("token");
    localStorage.removeItem("auth");
    this.$router.push({ name: "login" });
    $dash.content = false
    if (mode) {
      $toast.success("Successfuly Logout", { position: "bottom-right" });
    } else {
      $toast.error("Session Expired", { position: "bottom-right" });
    }
  }

  async function Login(input) {
    config.loading = true
    try {
      let { data: { data } } = await axios.post("/api/login", input);
      UpdateAuth(data.auth);
      UpdateToken(data.token);
      $toast.success("Successfully Login");
      this.$router.push({ name: "dashboard" });
    } catch (e) {
      $toast.error("Incorrect credentials")
      $Err("login error", e);
    }
    config.loading = false
  }

  function CheckAuth() {
    alert(auth.value);
    if (token.value == "") {
      return true;
    }
    return false;
  }

  return {
    auth,
    token,
    role,
    config,
    ip,

    UpdateAuth,
    UpdateToken,
    Logout,
    Login,
    CheckAuth,
    UpdateAvatar,
  };
});
