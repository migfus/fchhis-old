export const clients = [
  {
    path: "/clients",
    name: "clients-list",
    component: () => import("@/views/clients/ClientPage.vue"),
    meta: {
      title: "Users' Management",
      role: 5, //client only
      auth: true,
      sideBar: true,
    },
  },
]
