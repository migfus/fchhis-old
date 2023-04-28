import axios from "axios";
import { useAuthStore } from "../store/auth/auth";
import { $DebugInfo, $Err, $Log} from '@/helpers/debug'

export default function jwtInterceptor() {
  $DebugInfo('JWT Interceptor')
  const $auth = useAuthStore();

  axios.interceptors.request.use((config) => {
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
      return Promise.reject(error);
    }
  );
}
