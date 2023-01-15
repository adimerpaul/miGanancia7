import { RouteRecordRaw } from 'vue-router'
import MainLayout from 'layouts/MainLayout.vue'
import IndexPage from 'pages/IndexPage.vue'
import Login from 'pages/Login.vue'
import Inventory from 'pages/Inventory.vue'
import Users from 'pages/Users.vue'
import Providers from 'pages/Providers.vue'
import Clients from 'pages/Clients.vue'

const routes: RouteRecordRaw[] = [
  {
    path: '/',
    component: MainLayout,
    children: [
      { path: '', component: IndexPage, meta: { requiresAuth: true } },
      { path: 'inventory', component: Inventory, meta: { requiresAuth: true } },
      { path: 'users', component: Users, meta: { requiresAuth: true } },
      { path: 'clients', component: Clients, meta: { requiresAuth: true } },
      { path: 'providers', component: Providers, meta: { requiresAuth: true } }
    ]
  },
  {
    path: '/login',
    component: Login
  },
  // Always leave this as last one,
  // but you can also remove it
  {
    path: '/:catchAll(.*)*',
    component: () => import('pages/ErrorNotFound.vue')
  }
]

export default routes
