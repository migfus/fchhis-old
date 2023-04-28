export const users = [
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
]
