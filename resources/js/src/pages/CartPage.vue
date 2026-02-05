<template>
  <div class="min-h-screen bg-gradient-to-br from-blue-50 via-indigo-50 to-purple-50 -m-6 p-6">
    <div class="max-w-7xl mx-auto">
      <!-- Header Section -->
      <div class="mb-8 flex items-center justify-between flex-wrap gap-4">
        <div>
          <div class="flex items-center gap-3 mb-2">
            <div class="text-4xl">🛒</div>
            <h1 class="text-4xl font-bold bg-gradient-to-r from-blue-600 via-indigo-600 to-purple-600 bg-clip-text text-transparent">
              Shopping Cart
            </h1>
          </div>
          <p class="text-slate-600 ml-16">Review your items and proceed to checkout</p>
        </div>
        <RouterLink 
          to="/shop" 
          class="px-6 py-2.5 rounded-xl bg-white/70 backdrop-blur border border-white/40 text-slate-700 font-medium hover:shadow-lg hover:scale-105 transition-all duration-300"
        >
          ← Continue Shopping
        </RouterLink>
      </div>

      <!-- Login Required State -->
      <div v-if="!auth.user" class="max-w-lg mx-auto">
        <div class="backdrop-blur-xl bg-white/70 border border-white/20 rounded-3xl p-12 shadow-xl text-center">
          <div class="text-7xl mb-6 animate-bounce">🛒</div>
          <h3 class="text-2xl font-bold text-slate-800 mb-3">Your Cart is Waiting</h3>
          <p class="text-slate-600 mb-6">Please login to view and manage your shopping cart</p>
          <RouterLink 
            to="/login" 
            class="inline-block px-8 py-4 rounded-xl bg-gradient-to-r from-blue-600 to-purple-600 text-white font-medium hover:shadow-lg hover:scale-105 transition-all duration-300"
          >
            Login to Continue
          </RouterLink>
        </div>
      </div>

      <div v-else>
        <!-- Loading State -->
        <div v-if="cart.loading && !cart.cart" class="text-center py-20">
          <div class="inline-block animate-spin text-6xl mb-4">🔄</div>
          <p class="text-slate-600 text-lg">Loading your cart...</p>
        </div>

        <!-- Error State -->
        <div v-else-if="cart.error" class="max-w-lg mx-auto">
          <div class="backdrop-blur-xl bg-gradient-to-br from-red-50 to-rose-50 border-2 border-red-200 rounded-3xl p-8 shadow-xl">
            <div class="flex items-start gap-4">
              <div class="text-5xl">⚠️</div>
              <div class="flex-1">
                <h4 class="text-xl font-bold text-red-800 mb-2">Oops! Something went wrong</h4>
                <p class="text-red-600 mb-4">{{ cart.error }}</p>
                <button 
                  @click="load" 
                  class="px-6 py-3 rounded-xl bg-gradient-to-r from-red-600 to-rose-600 text-white font-medium hover:shadow-lg hover:scale-105 transition-all duration-300"
                >
                  Try Again
                </button>
              </div>
            </div>
          </div>
        </div>

        <!-- Empty Cart State -->
        <div v-else-if="cart.items.length === 0" class="max-w-lg mx-auto">
          <div class="backdrop-blur-xl bg-white/70 border border-white/20 rounded-3xl p-12 shadow-xl text-center">
            <div class="text-8xl mb-6">🛍️</div>
            <h3 class="text-3xl font-bold text-slate-800 mb-3">Your Cart is Empty</h3>
            <p class="text-slate-600 mb-8">Discover amazing products and start shopping!</p>
            <RouterLink 
              to="/shop" 
              class="inline-block px-8 py-4 rounded-xl bg-gradient-to-r from-blue-600 to-purple-600 text-white font-medium hover:shadow-lg hover:scale-105 transition-all duration-300"
            >
              Browse Products
            </RouterLink>
          </div>
        </div>

        <!-- Cart Content -->
        <div v-else class="grid gap-6 lg:grid-cols-3">
          <!-- Cart Items -->
          <div class="lg:col-span-2 space-y-4">
            <div class="backdrop-blur-xl bg-white/70 border border-white/20 rounded-2xl p-4 flex items-center justify-between">
              <div class="flex items-center gap-2">
                <div class="text-2xl">📦</div>
                <h3 class="text-lg font-bold text-slate-800">
                  {{ cart.items.length }} {{ cart.items.length === 1 ? 'Item' : 'Items' }}
                </h3>
              </div>
              <button 
                @click="load" 
                :disabled="cart.loading"
                class="px-4 py-2 rounded-xl bg-white/60 border border-indigo-200 text-indigo-700 text-sm font-medium hover:bg-indigo-50 hover:shadow-md transition-all duration-300 disabled:opacity-50"
              >
                🔄 Refresh
              </button>
            </div>

            <div class="space-y-4">
              <div
                v-for="item in cart.items"
                :key="item.id"
                class="group backdrop-blur-xl bg-white/70 border border-white/20 rounded-2xl p-6 hover:shadow-xl hover:scale-[1.01] transition-all duration-300"
              >
                <div class="flex gap-5">
                  <!-- Product Image -->
                  <div class="h-28 w-28 rounded-xl bg-gradient-to-br from-slate-100 to-slate-200 overflow-hidden shrink-0 shadow-md">
                    <img 
                      v-if="item.product?.images?.[0]?.url || item.product?.images?.[0]?.path" 
                      :src="item.product.images[0]?.url || item.product.images[0]?.path" 
                      class="h-full w-full object-cover group-hover:scale-110 transition-transform duration-300" 
                      :alt="item.product?.name"
                    />
                    <div v-else class="h-full w-full flex items-center justify-center text-slate-400 text-3xl">
                      📷
                    </div>
                  </div>
                  
                  <!-- Product Info -->
                  <div class="flex-1 min-w-0">
                    <RouterLink 
                      :to="`/products/${item.product?.id}`"
                      class="font-bold text-lg text-slate-900 hover:text-indigo-600 line-clamp-2 transition-colors"
                    >
                      {{ item.product?.name }}
                    </RouterLink>
                    
                    <div class="flex items-center gap-3 mt-2">
                      <div class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full bg-gradient-to-r from-blue-100 to-indigo-100 text-xs font-medium text-blue-700">
                        <span>📏</span>
                        <span>{{ item.variant?.size }}</span>
                      </div>
                      <div class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full bg-gradient-to-r from-purple-100 to-fuchsia-100 text-xs font-medium text-purple-700">
                        <span>🎨</span>
                        <span>{{ item.variant?.color }}</span>
                      </div>
                    </div>
                    
                    <div class="text-2xl font-bold bg-gradient-to-r from-blue-600 to-purple-600 bg-clip-text text-transparent mt-3">
                      ${{ ((item.product?.price_cents || 0) / 100 * item.quantity).toFixed(2) }}
                    </div>
                    
                    <!-- Quantity Controls -->
                    <div class="mt-4 flex items-center gap-4">
                      <div class="flex items-center bg-white/80 backdrop-blur border-2 border-indigo-200 rounded-xl overflow-hidden shadow-sm">
                        <button
                          @click="onUpdate(item.id, Math.max(1, item.quantity - 1))"
                          :disabled="cart.loading"
                          class="px-4 py-2 text-indigo-600 hover:bg-indigo-50 disabled:opacity-50 transition-all font-bold text-lg"
                        >
                          −
                        </button>
                        <input
                          type="number"
                          :value="item.quantity"
                          min="1"
                          max="20"
                          @change="(e) => onUpdate(item.id, Number(e.target.value) || 1)"
                          :disabled="cart.loading"
                          class="w-16 text-center border-0 focus:ring-0 font-semibold bg-transparent"
                        />
                        <button
                          @click="onUpdate(item.id, Math.min(20, item.quantity + 1))"
                          :disabled="cart.loading"
                          class="px-4 py-2 text-indigo-600 hover:bg-indigo-50 disabled:opacity-50 transition-all font-bold text-lg"
                        >
                          +
                        </button>
                      </div>
                      
                      <button
                        @click="onRemove(item.id)"
                        :disabled="cart.loading"
                        class="px-4 py-2 rounded-xl bg-gradient-to-r from-red-500 to-rose-500 text-white text-sm font-medium hover:shadow-lg hover:scale-105 transition-all duration-300 disabled:opacity-50"
                      >
                        🗑️ Remove
                      </button>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>

          <!-- Order Summary -->
          <div class="lg:col-span-1">
            <div class="backdrop-blur-xl bg-white/70 border border-white/20 rounded-3xl p-6 shadow-xl sticky top-6">
              <div class="flex items-center gap-3 mb-6">
                <div class="text-3xl">💰</div>
                <h3 class="text-2xl font-bold text-slate-800">Order Summary</h3>
              </div>
              
              <div class="space-y-4">
                <div class="bg-gradient-to-br from-blue-50 to-indigo-50 rounded-2xl p-4 border border-blue-100">
                  <div class="flex justify-between items-center mb-3">
                    <span class="text-slate-600 font-medium">Subtotal</span>
                    <span class="text-xl font-bold text-slate-800">${{ subtotal.toFixed(2) }}</span>
                  </div>
                  <div class="flex justify-between items-center text-sm">
                    <span class="text-slate-500">Shipping</span>
                    <span class="text-slate-600 font-medium">At checkout</span>
                  </div>
                </div>
                
                <div class="bg-gradient-to-br from-purple-100 to-fuchsia-100 rounded-2xl p-5 border-2 border-purple-200">
                  <div class="flex justify-between items-center">
                    <span class="text-lg font-bold text-slate-800">Total</span>
                    <span class="text-3xl font-bold bg-gradient-to-r from-blue-600 to-purple-600 bg-clip-text text-transparent">
                      ${{ subtotal.toFixed(2) }}
                    </span>
                  </div>
                </div>
              </div>

              <RouterLink
                to="/checkout"
                class="mt-6 block w-full rounded-xl bg-gradient-to-r from-blue-600 via-indigo-600 to-purple-600 px-6 py-4 text-center text-white font-bold text-lg hover:shadow-2xl hover:scale-105 transition-all duration-300"
              >
                <div class="flex items-center justify-center gap-2">
                  <span>Proceed to Checkout</span>
                  <span class="text-xl">→</span>
                </div>
              </RouterLink>

              <RouterLink
                to="/orders"
                class="mt-3 block w-full rounded-xl bg-white/60 backdrop-blur border border-slate-300 px-4 py-3 text-center text-slate-700 font-medium hover:bg-slate-50 hover:shadow-md transition-all duration-300"
              >
                📋 View Order History
              </RouterLink>

              <!-- Trust Badges -->
              <div class="mt-6 pt-6 border-t border-slate-200 space-y-2">
                <div class="flex items-center gap-2 text-sm text-slate-600">
                  <span class="text-lg">🔒</span>
                  <span>Secure checkout</span>
                </div>
                <div class="flex items-center gap-2 text-sm text-slate-600">
                  <span class="text-lg">🚚</span>
                  <span>Free shipping over $50</span>
                </div>
                <div class="flex items-center gap-2 text-sm text-slate-600">
                  <span class="text-lg">↩️</span>
                  <span>Easy 30-day returns</span>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script setup>
import { computed, onMounted, watch } from 'vue'
import { RouterLink, useRoute } from 'vue-router'
import { useAuthStore } from '../stores/auth'
import { useCartStore } from '../stores/cart'

const route = useRoute()

const auth = useAuthStore()
const cart = useCartStore()

const subtotal = computed(() => {
  return cart.items.reduce((sum, item) => {
    return sum + ((item.product?.price_cents || 0) / 100) * item.quantity
  }, 0)
})

async function load() {
  if (auth.user) {
    await cart.fetchCart()
  }
}

async function onUpdate(id, qty) {
  if (!qty || qty < 1) return
  await cart.updateItem(id, qty)
}

async function onRemove(id) {
  if (confirm('Remove this item from cart?')) {
    await cart.removeItem(id)
  }
}

// Watch for auth changes and reload cart
watch(() => auth.user, async (newUser) => {
  if (newUser) {
    await load()
  } else {
    cart.cart = null
  }
})

// Watch for route changes and reload cart
watch(() => route.path, async () => {
  if (auth.user && route.path === '/cart') {
    await load()
  }
})

onMounted(async () => {
  if (auth.user) {
    await load()
  }
})
</script>
