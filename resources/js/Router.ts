import { createRouter, createWebHistory } from "vue-router";
import { useAuthStore } from "@/store/auth/AuthStore";
import ability from '@/Ability';

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
        {
            path: '/faq',
            name: 'faq',
            component: () => import('@/views/pages/FaqPage.vue'),
            meta: {
                title: 'FAQs'
            }
        },
        // NOTE AUTH
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
        path: "/forgot/fill",
            name: "forgot-recovery",
            component: () => import("@/views/auth/RecoveryPage.vue"),
            meta: {
                title: "Recovery",
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
                title: "Transactions",
                // role: 5, //admin
                auth: true,
                sideBar: true,
            },
        },
        {
            path: "/overdue",
            name: "overdue",
            component: () => import("@/views/users/overdue/OverduePage.vue"),
            meta: {
                title: "Overdue",
                role: 5, //admin
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
            path: '/users/clients',
            name: 'users-clients',
            component: () => import("@/views/users/clients/ClientPage.vue"),
            meta: {
                title: 'Clients Management',
                // role: 5,
                auth: true,
                sideBar: true,
            }
        },
        {
            path: '/users/overdue',
            name: 'users-overdue',
            component: () => import("@/views/users/overdue/OverduePage.vue"),
            meta: {
                title: 'Overdue Management',
                // role: 5,
                auth: true,
                sideBar: true,
            }
        },
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
        {
            path: '/user/:id',
            name: 'user',
            component: () => import("@/views/user/UserPage.vue"),
            meta: {
                title: "User Details",
                // role: 5,
                auth: true,
                sideBar: true,
            }
        },
        // NOTE CLIENTS
        // {
        //   path: "/clients",
        //   name: "clients-list",
        //   component: () => import("@/views/clients/ClientPage.vue"),
        //   meta: {
        //     title: "Users' Management",
        //     role: 5, //client only
        //     auth: true,
        //     sideBar: true,
        //   },
        // },
        // NOTE ACCOUNT SETTINGS
        {
            path: "/account-settings",
            name: "account-settings",
            component: () =>
                import(
                "@/views/account-settings/AccountSettingsPage.vue"
                ),
            meta: {
                title: "Account Settings",
                auth: true,
                sideBar: true,
                resource: 'auth',
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

    if(to.meta.auth && $auth.token == '' && to.meta.name != 'login') {
        return { name: 'login'};
        // return false
    }

    if(to.meta.role) {
        if($auth.content.auth.role == 2) {

        }
        else if(to.meta.role != $auth.content.auth.role && to.meta.name != 'error') {
        // return { name: 'error'}
            return false
        }
    }

    $auth.UpdateAbility()

    const canNavigate = to.matched.some(row => {
        if(row.meta.resource) {
            // @ts-ignore
            return ability.can(row.meta.action || 'index', row.meta.resource)
        }
        return true;
    })
    if(!canNavigate) {
        alert('Route Disabled (no permission)')
    }

});

router.afterEach((to) => {
    document.title = to.meta.title ? `${to.meta.title} | ${TITLE}` : "";
});

export default router;
