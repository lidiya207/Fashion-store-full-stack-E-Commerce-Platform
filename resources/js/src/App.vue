<template>
  <div class="min-h-screen flex flex-col bg-slate-50">
    <header class="sticky top-0 z-50 border-b bg-white/80 backdrop-blur-sm shadow-sm">
      <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
        <div class="flex h-16 items-center justify-between">
          <!-- Logo -->
          <RouterLink to="/" class="flex items-center gap-2 group">
            <div class="text-3xl transition-transform group-hover:scale-110">👕</div>
            <span class="text-xl font-bold bg-gradient-to-r from-slate-900 to-slate-600 bg-clip-text text-transparent">
              Fashion Store
            </span>
          </RouterLink>

          <!-- Desktop Navigation -->
          <nav class="hidden md:flex items-center gap-1">
            <RouterLink 
              to="/shop" 
              class="px-4 py-2 rounded-lg text-sm font-medium text-slate-700 hover:bg-slate-100 hover:text-slate-900 transition"
              active-class="bg-slate-100 text-slate-900"
            >
              Shop
            </RouterLink>
            
            <RouterLink 
              to="/cart" 
              class="relative px-4 py-2 rounded-lg text-sm font-medium text-slate-700 hover:bg-slate-100 hover:text-slate-900 transition"
              active-class="bg-slate-100 text-slate-900"
            >
              <span class="flex items-center gap-2">
                <span>Cart</span>
                <span 
                  v-if="auth.user && cart.items.length > 0" 
                  class="bg-slate-900 text-white text-xs font-bold rounded-full h-5 w-5 flex items-center justify-center min-w-[1.25rem]"
                >
                  {{ cart.items.length }}
                </span>
              </span>
            </RouterLink>

            <template v-if="auth.user">
              <RouterLink 
                to="/account" 
                class="px-4 py-2 rounded-lg text-sm font-medium text-slate-700 hover:bg-slate-100 hover:text-slate-900 transition"
                active-class="bg-slate-100 text-slate-900"
              >
                Account
              </RouterLink>
              
              <RouterLink 
                v-if="auth.user.role?.name === 'admin'" 
                to="/admin" 
                class="px-4 py-2 rounded-lg text-sm font-medium text-slate-700 hover:bg-slate-100 hover:text-slate-900 transition"
                active-class="bg-slate-100 text-slate-900"
              >
                Admin
              </RouterLink>
              
              <button 
                @click="onLogout" 
                :disabled="auth.loading"
                class="ml-2 px-4 py-2 rounded-lg text-sm font-medium text-red-600 hover:bg-red-50 transition disabled:opacity-50"
              >
                Logout
              </button>
            </template>
            
            <template v-else>
              <RouterLink 
                to="/login" 
                class="px-4 py-2 rounded-lg text-sm font-medium text-slate-700 hover:bg-slate-100 hover:text-slate-900 transition"
                active-class="bg-slate-100 text-slate-900"
              >
                Login
              </RouterLink>
              <RouterLink 
                to="/register" 
                class="ml-2 px-4 py-2 rounded-lg text-sm font-medium bg-slate-900 text-white hover:bg-slate-800 transition"
              >
                Sign Up
              </RouterLink>
            </template>
          </nav>

          <!-- Mobile Menu Button -->
          <button 
            @click="mobileMenuOpen = !mobileMenuOpen"
            class="md:hidden p-2 rounded-lg text-slate-700 hover:bg-slate-100"
          >
            <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
              <path v-if="!mobileMenuOpen" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
              <path v-else stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
            </svg>
          </button>
        </div>

        <!-- Mobile Navigation -->
        <div v-if="mobileMenuOpen" class="md:hidden border-t py-4 space-y-2">
          <RouterLink 
            to="/shop" 
            class="block px-4 py-2 rounded-lg text-sm font-medium text-slate-700 hover:bg-slate-100"
            @click="mobileMenuOpen = false"
          >
            Shop
          </RouterLink>
          
          <RouterLink 
            to="/cart" 
            class="block px-4 py-2 rounded-lg text-sm font-medium text-slate-700 hover:bg-slate-100"
            @click="mobileMenuOpen = false"
          >
            <span class="flex items-center justify-between">
              <span>Cart</span>
              <span 
                v-if="auth.user && cart.items.length > 0" 
                class="bg-slate-900 text-white text-xs font-bold rounded-full h-5 w-5 flex items-center justify-center min-w-[1.25rem]"
              >
                {{ cart.items.length }}
              </span>
            </span>
          </RouterLink>

          <template v-if="auth.user">
            <RouterLink 
              to="/account" 
              class="block px-4 py-2 rounded-lg text-sm font-medium text-slate-700 hover:bg-slate-100"
              @click="mobileMenuOpen = false"
            >
              Account
            </RouterLink>
            
            <RouterLink 
              v-if="auth.user.role?.name === 'admin'" 
              to="/admin" 
              class="block px-4 py-2 rounded-lg text-sm font-medium text-slate-700 hover:bg-slate-100"
              @click="mobileMenuOpen = false"
            >
              Admin
            </RouterLink>
            
            <button 
              @click="onLogout(); mobileMenuOpen = false" 
              :disabled="auth.loading"
              class="w-full text-left px-4 py-2 rounded-lg text-sm font-medium text-red-600 hover:bg-red-50 disabled:opacity-50"
            >
              Logout
            </button>
          </template>
          
          <template v-else>
            <RouterLink 
              to="/login" 
              class="block px-4 py-2 rounded-lg text-sm font-medium text-slate-700 hover:bg-slate-100"
              @click="mobileMenuOpen = false"
            >
              Login
            </RouterLink>
            <RouterLink 
              to="/register" 
              class="block px-4 py-2 rounded-lg text-sm font-medium bg-slate-900 text-white hover:bg-slate-800"
              @click="mobileMenuOpen = false"
            >
              Sign Up
            </RouterLink>
          </template>
        </div>
      </div>
    </header>

    <main class="flex-1">
      <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8 py-6">
        <RouterView />
      </div>
    </main>

    <footer class="relative bg-gradient-to-br from-slate-900 via-slate-800 to-slate-900 text-white mt-16">
      <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8 pt-12 pb-8">
        <!-- Newsletter Section -->
        <div class="border-b border-slate-700 pb-10 mb-10">
          <div class="max-w-2xl mx-auto text-center">
            <h3 class="text-2xl font-bold mb-2">Stay Updated</h3>
            <p class="text-slate-300 mb-6">Subscribe to our newsletter for exclusive deals and latest trends</p>
            <div class="flex flex-col sm:flex-row gap-3 max-w-md mx-auto">
              <input 
                type="email" 
                placeholder="Enter your email" 
                class="flex-1 px-4 py-3 rounded-lg bg-white/10 border border-slate-600 text-white placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition"
              />
              <button class="px-6 py-3 bg-gradient-to-r from-blue-600 to-indigo-600 rounded-lg font-semibold hover:from-blue-700 hover:to-indigo-700 transition transform hover:scale-105 shadow-lg">
                Subscribe
              </button>
            </div>
          </div>
        </div>

        <!-- Main Footer Content -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8 mb-10">
          <!-- Brand Column -->
          <div>
            <div class="flex items-center gap-2 mb-4">
              <span class="text-3xl">👕</span>
              <span class="font-bold text-xl bg-gradient-to-r from-white to-slate-300 bg-clip-text text-transparent">Fashion Store</span>
            </div>
            <p class="text-sm text-slate-300 mb-4 leading-relaxed">
              Your one-stop destination for premium fashion. Quality clothing, trendy styles, unbeatable prices.
            </p>
            <!-- Social Media Links -->
            <div class="flex gap-3">
              <a href="#" class="w-10 h-10 rounded-full bg-white/10 hover:bg-blue-600 flex items-center justify-center transition transform hover:scale-110">
                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/></svg>
              </a>
              <a href="#" class="w-10 h-10 rounded-full bg-white/10 hover:bg-blue-600 flex items-center justify-center transition transform hover:scale-110">
                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zM12 0C8.741 0 8.333.014 7.053.072 2.695.272.273 2.69.073 7.052.014 8.333 0 8.741 0 12c0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98C8.333 23.986 8.741 24 12 24c3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98C15.668.014 15.259 0 12 0zm0 5.838a6.162 6.162 0 100 12.324 6.162 6.162 0 000-12.324zM12 16a4 4 0 110-8 4 4 0 010 8zm6.406-11.845a1.44 1.44 0 100 2.881 1.44 1.44 0 000-2.881z"/></svg>
              </a>
              <a href="#" class="w-10 h-10 rounded-full bg-white/10 hover:bg-blue-600 flex items-center justify-center transition transform hover:scale-110">
                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path d="M23.953 4.57a10 10 0 01-2.825.775 4.958 4.958 0 002.163-2.723c-.951.555-2.005.959-3.127 1.184a4.92 4.92 0 00-8.384 4.482C7.69 8.095 4.067 6.13 1.64 3.162a4.822 4.822 0 00-.666 2.475c0 1.71.87 3.213 2.188 4.096a4.904 4.904 0 01-2.228-.616v.06a4.923 4.923 0 003.946 4.827 4.996 4.996 0 01-2.212.085 4.936 4.936 0 004.604 3.417 9.867 9.867 0 01-6.102 2.105c-.39 0-.779-.023-1.17-.067a13.995 13.995 0 007.557 2.209c9.053 0 13.998-7.496 13.998-13.985 0-.21 0-.42-.015-.63A9.935 9.935 0 0024 4.59z"/></svg>
              </a>
              <a href="#" class="w-10 h-10 rounded-full bg-white/10 hover:bg-blue-600 flex items-center justify-center transition transform hover:scale-110">
                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path d="M19 0h-14c-2.761 0-5 2.239-5 5v14c0 2.761 2.239 5 5 5h14c2.762 0 5-2.239 5-5v-14c0-2.761-2.238-5-5-5zm-11 19h-3v-11h3v11zm-1.5-12.268c-.966 0-1.75-.79-1.75-1.764s.784-1.764 1.75-1.764 1.75.79 1.75 1.764-.783 1.764-1.75 1.764zm13.5 12.268h-3v-5.604c0-3.368-4-3.113-4 0v5.604h-3v-11h3v1.765c1.396-2.586 7-2.777 7 2.476v6.759z"/></svg>
              </a>
            </div>
          </div>
          
          <!-- Shop Column -->
          <div>
            <h3 class="font-bold text-lg mb-4 text-white">Shop</h3>
            <ul class="space-y-3 text-sm">
              <li><RouterLink to="/shop" class="text-slate-300 hover:text-blue-400 transition flex items-center gap-2">
                <span class="text-blue-400">→</span> All Products
              </RouterLink></li>
              <li><RouterLink to="/shop?category=men" class="text-slate-300 hover:text-blue-400 transition flex items-center gap-2">
                <span class="text-blue-400">→</span> Men's Collection
              </RouterLink></li>
              <li><RouterLink to="/shop?category=women" class="text-slate-300 hover:text-blue-400 transition flex items-center gap-2">
                <span class="text-blue-400">→</span> Women's Collection
              </RouterLink></li>
              <li><RouterLink to="/shop?category=kids" class="text-slate-300 hover:text-blue-400 transition flex items-center gap-2">
                <span class="text-blue-400">→</span> Kids' Collection
              </RouterLink></li>
              <li><RouterLink to="/shop?category=accessories" class="text-slate-300 hover:text-blue-400 transition flex items-center gap-2">
                <span class="text-blue-400">→</span> Accessories
              </RouterLink></li>
            </ul>
          </div>
          
          <!-- Account Column -->
          <div>
            <h3 class="font-bold text-lg mb-4 text-white">Customer Service</h3>
            <ul class="space-y-3 text-sm">
              <li><RouterLink to="/account" class="text-slate-300 hover:text-blue-400 transition flex items-center gap-2">
                <span class="text-blue-400">→</span> My Account
              </RouterLink></li>
              <li><RouterLink to="/orders" class="text-slate-300 hover:text-blue-400 transition flex items-center gap-2">
                <span class="text-blue-400">→</span> Order Tracking
              </RouterLink></li>
              <li><RouterLink to="/cart" class="text-slate-300 hover:text-blue-400 transition flex items-center gap-2">
                <span class="text-blue-400">→</span> Shopping Cart
              </RouterLink></li>
              <li><a href="#" class="text-slate-300 hover:text-blue-400 transition flex items-center gap-2">
                <span class="text-blue-400">→</span> Wishlist
              </a></li>
              <li><a href="#" class="text-slate-300 hover:text-blue-400 transition flex items-center gap-2">
                <span class="text-blue-400">→</span> Help & Support
              </a></li>
            </ul>
          </div>
          
          <!-- Company Column -->
          <div>
            <h3 class="font-bold text-lg mb-4 text-white">Company</h3>
            <ul class="space-y-3 text-sm mb-6">
              <li><a href="#" class="text-slate-300 hover:text-blue-400 transition flex items-center gap-2">
                <span class="text-blue-400">→</span> About Us
              </a></li>
              <li><a href="#" class="text-slate-300 hover:text-blue-400 transition flex items-center gap-2">
                <span class="text-blue-400">→</span> Contact
              </a></li>
              <li><a href="#" class="text-slate-300 hover:text-blue-400 transition flex items-center gap-2">
                <span class="text-blue-400">→</span> Privacy Policy
              </a></li>
              <li><a href="#" class="text-slate-300 hover:text-blue-400 transition flex items-center gap-2">
                <span class="text-blue-400">→</span> Terms of Service
              </a></li>
              <li><a href="#" class="text-slate-300 hover:text-blue-400 transition flex items-center gap-2">
                <span class="text-blue-400">→</span> Careers
              </a></li>
            </ul>
            <!-- Payment Methods -->
            <div>
              <p class="text-xs text-slate-400 mb-2">We Accept</p>
              <div class="flex gap-2 flex-wrap">
                <div class="px-2 py-1 bg-white rounded text-xs font-semibold text-slate-900">VISA</div>
                <div class="px-2 py-1 bg-white rounded text-xs font-semibold text-slate-900">MC</div>
                <div class="px-2 py-1 bg-white rounded text-xs font-semibold text-slate-900">AMEX</div>
                <div class="px-2 py-1 bg-white rounded text-xs font-semibold text-slate-900">PayPal</div>
              </div>
            </div>
          </div>
        </div>
        
        <!-- Bottom Bar -->
        <div class="pt-8 border-t border-slate-700">
          <div class="flex flex-col md:flex-row justify-between items-center gap-4 text-sm text-slate-400">
            <p>© {{ new Date().getFullYear() }} Fashion Store. All rights reserved.</p>
            <div class="flex gap-6 text-xs">
              <a href="#" class="hover:text-pink-400 transition">Privacy</a>
              <a href="#" class="hover:text-pink-400 transition">Terms</a>
              <a href="#" class="hover:text-pink-400 transition">Cookies</a>
              <a href="#" class="hover:text-pink-400 transition">Sitemap</a>
            </div>
          </div>
        </div>
      </div>

      <!-- Decorative Elements -->
      <div class="absolute top-0 left-0 w-full h-1 bg-gradient-to-r from-blue-600 via-indigo-600 to-blue-600"></div>
    </footer>
  </div>
</template>

<script setup>
import { onMounted, ref, watch } from 'vue'
import { RouterLink, RouterView, useRouter } from 'vue-router'
import { useAuthStore } from './stores/auth'
import { useCartStore } from './stores/cart'

const auth = useAuthStore()
const cart = useCartStore()
const router = useRouter()
const mobileMenuOpen = ref(false)

onMounted(async () => {
  await auth.init()
  if (auth.user) {
    await cart.fetchCart()
  }
})

// Watch for auth changes and reload cart
watch(() => auth.user, async (newUser) => {
  if (newUser) {
    await cart.fetchCart()
  } else {
    cart.cart = null
  }
})

async function onLogout() {
  await auth.logout()
  cart.cart = null
  await router.push('/login')
}
</script>
