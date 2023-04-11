import axios from "axios";
import { useAuthStore } from "../store/auth/auth";

export default function jwtInterceptor() {
  const $auth = useAuthStore();

  axios.interceptors.request.use((config) => {
    if ($auth.token) {
      config.headers.Authorization = `Bearer ${$auth.token}`;
    }

    return config;
  });

  axios.interceptors.response.use(
    (response) => {
      if (response.data.role) {
        $auth.role = response.data.role;
        console.log("Role Updated");
      }
      return response;
    },
    (error) => {
      console.log("auth error: ", error);

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
