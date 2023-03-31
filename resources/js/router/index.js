import { createRouter, createWebHistory } from "vue-router";
import { useAuthStore } from "@/store/auth/auth";

const router = createRouter({
  history: createWebHistory(import.meta.env.APP_URL),
  routes: [
    // NOTE OUTSIDE
    {
      path: "/",
      redirect: { name: "dashboard" },
    },
    {
      path: "/login",
      name: "login",
      component: () => import("@/views/auth/LoginPage.vue"),
      meta: {
        noNav: true,
        title: "Login",
        noAuth: true,
      },
    },
    {
      path: "/forgot",
      name: "forgot",
      component: () => import("@/views/auth/ForgotPasswordPage.vue"),
      meta: {
        noNav: true,
        title: "Forgot Password",
      },
    },

    // NOTE DASHBOARD
    {
      path: "/dashboard",
      name: "dashboard",
      component: () => import("@/views/dashboard/DashboardPage.vue"),
      meta: {
        title: "Dashboard",
      },
    },
    // NOTE USERS
    {
      path: "/users/admin",
      name: "users-admin",
      component: () => import("@/views/users/AdminPage.vue"),
      meta: {
        title: "User Admin",
      },
    },
    // NOTE ACCOUNT SETTINGS
    {
      path: "/account-settings",
      name: "account-settings",
      component: () =>
        import("@/views/account-settings/AccountSettingsPage.vue"),
      meta: {
        title: "Account Settings",
      },
    },
    {
      path: "/account-settings/security",
      name: "account-settings-security",
      component: () =>
        import("@/views/account-settings/security/SecurityPage.vue"),
      meta: {
        title: "Security",
      },
    },
  ],
});
const TITLE = "Future Care and Helping Hands Insurance Service";

router.beforeEach(async (to, from) => {
  const $auth = useAuthStore();

  if ($auth.token == "" && to.name !== "login") {
    return { name: "login" };
  }
});

router.afterEach((to) => {
  document.title = to.meta.title ? `${to.meta.title} | ${TITLE}` : "";
});

export default router;
