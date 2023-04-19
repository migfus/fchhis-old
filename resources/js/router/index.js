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
    // NOTE TRANSACTIONS
    {
      path: "/transaction/list",
      name: "transaction-list",
      component: () => import("@/views/transaction/TransactionPage.vue"),
      meta: {
        title: "Transaction's Management",
        role: 2, //admin
      },
    },
    // NOTE PLANS
    {
      path: "/plans",
      name: "plans",
      component: () => import("@/views/plans/PlanPage.vue"),
      meta: {
        title: "Plans' Management",
        role: 2, //admin
      },
    },
    // NOTE USERS
    {
      path: "/users/list",
      name: "users-list",
      component: () => import("@/views/users/users/UsersPage.vue"),
      meta: {
        title: "Users' Management",
        role: 2, //admin
      },
    },
    {
      path: "/users/roles",
      name: "users-roles",
      component: () => import("@/views/users/roles/RolePage.vue"),
      meta: {
        title: "User's Roles",
        role: 2, //admin
      },
    },
    // NOTE ACCOUNT SETTINGS
    {
      path: "/account-settings",
      name: "account-settings",
      component: () =>
        import(
          "@/views/account-settings/account-settings/AccountSettingsPage.vue"
        ),
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
