export const plans = [
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
]
