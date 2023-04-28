import { createRouter, createWebHistory } from "vue-router";
import { useAuthStore } from "@/store/auth/auth";
import { pages } from './pages'
import { auth } from './auth'
import { dashboard } from "./dashboard";
import { transactions } from "./transactions";
import { miscellaneous } from "./miscellaneous";
import { accountSettings } from './accountSettings';
import { clients } from './clients'
import { users } from './users'
import { plans } from './plans'

const router = createRouter({
  history: createWebHistory(import.meta.env.APP_URL),
  scrollBehavior(to, from, savedPosition) {
    return new Promise((resolve, reject) => {
      setTimeout(() => {
        resolve({ left: 0, top: 0, behavior: 'smooth' })
      }, 500)
    })
  },
  routes: [
    // NOTE PAGES
    ...pages,
    // NOTE AUTH
    ...auth,
    // NOTE DASHBOARD
    ...dashboard,
    // NOTE TRANSACTIONS
    ...transactions,
    // NOTE PLANS
    ...plans,
    // NOTE USERS
    ...users,
    // NOTE CLIENTS
    ...clients,
    // NOTE ACCOUNT SETTINGS
    ...accountSettings,
    // NOTE OTHER
    ...miscellaneous,
  ],
});
const TITLE = "Future Care and Helping Hands Insurance Service";

router.beforeEach(async (to, from) => {
  const $auth = useAuthStore();



  // if ($auth.token == "" && to.name !== "login") {
  //   return { name: "login" };
  // }

  if(to.meta.auth && $auth.token == '' && to.meta.name != 'login') {
    return { name: 'login'};
    // return false
  }

  if(to.meta.role) {
    if(to.meta.role != $auth.auth.role && to.meta.name != 'error') {
      // return { name: 'error'}
      return false
    }
  }

});

router.afterEach((to) => {
  document.title = to.meta.title ? `${to.meta.title} | ${TITLE}` : "";
});

export default router;
