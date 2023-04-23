import { createRouter, createWebHistory } from "vue-router";
import { useAuthStore } from "@/store/auth/auth";

const router = createRouter({
  history: createWebHistory(import.meta.env.APP_URL),
  routes: [
    // NOTE PAGES
    {
      path: "/",
      name: 'home',
      component: () => import('@/views/pages/HomePage.vue'),
      meta: {
        title: 'Home',
      }
    },
    {
      path: "/about",
      name: 'about',
      component: () => import('@/views/pages/AboutPage.vue'),
      meta: {
        title: 'About',
      }
    },
    {
      path: "/contact",
      name: 'contact',
      component: () => import('@/views/pages/ContactPage.vue'),
      meta: {
        title: 'Contact',
      }
    },
    // NOTE OUTSIDE

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

    // NOTE DASHBOARD
    {
      path: "/dashboard",
      name: "dashboard",
      component: () => import("@/views/dashboard/DashboardPage.vue"),
      meta: {
        sideBar: true,
        title: "Dashboard",
        auth: true,
      },
    },
    // NOTE TRANSACTIONS
    {
      path: "/transactions-all",
      name: "transactions-all",
      component: () => import("@/views/transaction/AllTransactionPage.vue"),
      meta: {
        title: "All Transactions",
        role: 2, //admin
        auth: true,
        sideBar: true,
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
        auth: true,
        sideBar: true,
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
        auth: true,
        sideBar: true,
      },
    },
    {
      path: "/users/roles",
      name: "users-roles",
      component: () => import("@/views/users/roles/RolePage.vue"),
      meta: {
        title: "User's Roles",
        role: 2, //admin
        auth: true,
        sideBar: true,
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
        auth: true,
        sideBar: true,
      },
    },
    {
      path: "/account-settings/security",
      name: "account-settings-security",
      component: () =>
        import("@/views/account-settings/security/SecurityPage.vue"),
      meta: {
        title: "Security",
        auth: true,
        sideBar: true,
      },
    },
    // NOTE OTHER
    {
      path: "/:pathMatch(.*)*",
      name: 'error',
      component: () => import("@/views/pages/ErrorPage.vue"),
      meta: {
        title: "Page not Found!",
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

  if(!to.meta.auth && !$auth.token) {
    return { name: 'error'};
  }

  if(to.meta.role) {
    if(to.meta.role != $auth.auth.role) {
      return { name: 'error'}
    }
  }

});

router.afterEach((to) => {
  document.title = to.meta.title ? `${to.meta.title} | ${TITLE}` : "";
});

export default router;
