import axios from "axios";
import { useAuthStore } from "@/store/auth/AuthStore";
import { useToast } from "vue-toastification";

export default function jwtInterceptor() {
    const $auth = useAuthStore()
    const $toast = useToast()

    axios.interceptors.request.use(config => {
        if ($auth.token) {
            config.headers.Authorization = `Bearer ${$auth.token}`;
        }

        return config;
    });

    axios.interceptors.response.use(
        (response) => {
        if (response.data.auth) {
            $auth.content = response.data.auth;
            console.log("Role Updated", {response});
        }
        return response;
        },
        (error) => {
            if(axios.isCancel(error)) {
                console.log('Interceptor','Cancelled')
                return true;
            }
            else {
                const { status } = error.response;
                const { data } = error.response;
                if (status === 401 && data.message == "Logout") {
                    $auth.Logout();
                }
                if (status === 401 && data.message == "Unauthenticated.") {
                    $auth.Logout();
                }
                if(status === 401 && data.message == 'Invalid Input') {
                    $toast.error('Invalid Input')
                }
                if(status === 429) {
                    alert("Too Many Requests of Data!")
                }
            }


            return Promise.reject(error);
        }
    );
}
