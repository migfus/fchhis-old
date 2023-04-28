export const dashboard = [
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
]
