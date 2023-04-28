export const transactions = [
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
]
