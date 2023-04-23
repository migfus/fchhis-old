export const pages = () => {
  const home = {
    path: "/",
    name: "home",
    component: () => import("@/views/auth/LoginPage.vue"),
    meta: {
      noNav: true,
      title: "Login",
      noAuth: true,
    },
  }
  return { ...home }
}
