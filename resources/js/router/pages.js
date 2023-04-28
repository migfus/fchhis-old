export const pages = [
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
]

