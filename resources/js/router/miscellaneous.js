export const miscellaneous = [
  {
    path: "/:pathMatch(.*)*",
    name: 'error',
    component: () => import("@/views/pages/ErrorPage.vue"),
    meta: {
      title: "Page not Found!",
    },
  },
]
