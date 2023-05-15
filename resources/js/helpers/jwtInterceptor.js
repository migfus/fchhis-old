import axios from "axios";
import { useAuthStore } from "../store/auth/auth";
import { $DebugInfo, $Err, $Log} from '@/helpers/debug'
import { useToast } from "vue-toastification";

export default function jwtInterceptor(cancelSource) {
  $DebugInfo('JWT Interceptor')
  const $auth = useAuthStore();
  const $toast = useToast();


  axios.interceptors.request.use(config => {
    config.cancelToken = cancelSource.token;
    if ($auth.token) {
      config.headers.Authorization = `Bearer ${$auth.token}`;
    }

    return config;
  });

  axios.interceptors.response.use(
    (response) => {
      if (response.data.auth) {
        $auth.role = response.data.auth.role;
        $auth.auth = response.data.auth;
        $auth.ip = response.data.ip;
        $Log("Role Updated", {response});
      }
      return response;
    },
    (error) => {
      $Err("auth error: ", error);

      const { status } = error.response;
      const { data } = error.response;
      if (status === 401 && data.message == "Logout") {
        $auth.Logout();
      }
      if (status === 401 && data.message == "Unauthenticated.") {
        $auth.Logout();
      }
      if(status === 401 && data.message == 'Invalid Input') {
        $toast.error(JSON.stringify(data.errors))
      }
      if(status === 429) {
        alert("Too Many Requests of Data!")
      }
      return Promise.reject(error);
    }
  );
}
