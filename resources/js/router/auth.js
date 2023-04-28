export const auth = [
  {
    path: "/login",
    name: "login",
    component: () => import("@/views/auth/LoginPage.vue"),
    meta: {
      title: "Login",
    },
  },
  {
    path: "/forgot",
    name: "forgot",
    component: () => import("@/views/auth/ForgotPasswordPage.vue"),
    meta: {
      title: "Forgot Password",
    },
  },
  {
    path: "/register",
    name: "register",
    component: () => import("@/views/auth/RegisterPage.vue"),
    meta: {
      title: "Register",
    },
  },
  {
    path: "/register/fill",
    name: "register-fill",
    component: () => import("@/views/auth/RegisterFillPage.vue"),
    meta: {
      title: "Register",
    },
  },
]
