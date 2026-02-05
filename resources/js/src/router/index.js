import { createRouter, createWebHistory } from 'vue-router'
import { useAuthStore } from '../stores/auth'

import HomePage from '../pages/HomePage.vue'
import ShopPage from '../pages/ShopPage.vue'
import ProductPage from '../pages/ProductPage.vue'
import CartPage from '../pages/CartPage.vue'
import CheckoutPage from '../pages/CheckoutPage.vue'
import LoginPage from '../pages/LoginPage.vue'
import RegisterPage from '../pages/RegisterPage.vue'
import AccountPage from '../pages/AccountPage.vue'
import OrdersPage from '../pages/OrdersPage.vue'
import AdminDashboardPage from '../pages/admin/AdminDashboardPage.vue'
import AdminProductsPage from '../pages/admin/AdminProductsPage.vue'
import AdminCategoriesPage from '../pages/admin/AdminCategoriesPage.vue'
import AdminOrdersPage from '../pages/admin/AdminOrdersPage.vue'

export const router = createRouter({
  history: createWebHistory(),
  routes: [
    { path: '/', component: HomePage },
    { path: '/shop', component: ShopPage },
    { path: '/products/:id', component: ProductPage },
    { path: '/cart', component: CartPage },
    { path: '/checkout', component: CheckoutPage, meta: { requiresAuth: true } },
    { path: '/login', component: LoginPage, meta: { guestOnly: true } },
    { path: '/register', component: RegisterPage, meta: { guestOnly: true } },
    { path: '/account', component: AccountPage, meta: { requiresAuth: true } },
    { path: '/orders', component: OrdersPage, meta: { requiresAuth: true } },
    { path: '/orders/:id', component: OrdersPage, meta: { requiresAuth: true } },
    { path: '/admin', component: AdminDashboardPage, meta: { requiresAuth: true, requiresAdmin: true } },
    { path: '/admin/products', component: AdminProductsPage, meta: { requiresAuth: true, requiresAdmin: true } },
    { path: '/admin/categories', component: AdminCategoriesPage, meta: { requiresAuth: true, requiresAdmin: true } },
    { path: '/admin/orders', component: AdminOrdersPage, meta: { requiresAuth: true, requiresAdmin: true } },
  ],
})

router.beforeEach(async (to) => {
  const auth = useAuthStore()
  if (!auth.initialized) {
    await auth.init()
  }

  if (to.meta.requiresAuth && !auth.user) {
    return { path: '/login' }
  }
  if (to.meta.guestOnly && auth.user) {
    return { path: '/' }
  }
  if (to.meta.requiresAdmin && auth.user?.role?.name !== 'admin') {
    return { path: '/' }
  }
})

