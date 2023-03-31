import { ref } from "vue";
import { defineStore } from "pinia";
import { useToast } from "vue-toastification";
import axios from "axios";

export const useAuthStore = defineStore("auth", () => {
  const $toast = useToast();

  const auth = ref(JSON.parse(localStorage.getItem("auth")) || {});
  const token = ref(localStorage.getItem("token") || "");

  function UpdateToken(input) {
    token.value = input;
    localStorage.setItem("token", input);
  }

  function UpdateAuth(input) {
    auth.value = input;
    localStorage.setItem("auth", JSON.stringify(input));
  }

  function Logout(mode = false) {
    auth.value = "";
    token.value = "";
    localStorage.removeItem("token");
    localStorage.removeItem("auth");
    this.$router.push({ name: "login" });
    if (mode) {
      $toast.success("Logout", { position: "bottom-right" });
    } else {
      $toast.error("Session Expired", { position: "bottom-right" });
    }
  }

  async function Login(input) {
    try {
      let {
        data: {
          data: { auth, token },
        },
      } = await axios.post("/api/login", input);
      UpdateAuth(auth);
      UpdateToken(token);
      $toast.success("Successfully Login", { position: "bottom-right" });
      this.$router.push({ name: "dashboard" });
    } catch (e) {
      console.log("login error", e);
    }
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

    UpdateAuth,
    UpdateToken,
    Logout,
    Login,
    CheckAuth,
  };
});
