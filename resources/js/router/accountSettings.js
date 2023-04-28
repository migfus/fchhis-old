export const accountSettings = [
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
]
