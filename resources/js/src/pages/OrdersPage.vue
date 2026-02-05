<template>
  <div class="min-h-screen bg-gradient-to-br from-blue-50 via-indigo-50 to-purple-50 -m-6 p-6">
    <div class="max-w-7xl mx-auto">
      <!-- Header -->
      <div class="mb-8 flex items-center justify-between flex-wrap gap-4">
        <div>
          <div class="flex items-center gap-3 mb-2">
            <div class="text-4xl">📋</div>
            <h1 class="text-4xl font-bold bg-gradient-to-r from-blue-600 via-indigo-600 to-purple-600 bg-clip-text text-transparent">
              My Orders
            </h1>
          </div>
          <p class="text-slate-600 ml-16">Track and manage your order history</p>
        </div>
        <button 
          @click="load" 
          :disabled="loading"
          class="px-6 py-2.5 rounded-xl bg-white/70 backdrop-blur border border-white/40 text-slate-700 font-medium hover:shadow-lg hover:scale-105 transition-all duration-300 disabled:opacity-50"
        >
          🔄 Refresh
        </button>
      </div>

      <!-- Error State -->
      <div v-if="error" class="max-w-lg mx-auto">
        <div class="backdrop-blur-xl bg-gradient-to-br from-red-50 to-rose-50 border-2 border-red-200 rounded-3xl p-8 shadow-xl">
          <div class="flex items-start gap-4">
            <div class="text-5xl">⚠️</div>
            <div class="flex-1">
              <h4 class="text-xl font-bold text-red-800 mb-2">Error Loading Orders</h4>
              <p class="text-red-600 mb-4">{{ error }}</p>
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

      <!-- Loading State -->
      <div v-else-if="loading" class="text-center py-20">
        <div class="inline-block animate-spin text-6xl mb-4">🔄</div>
        <p class="text-slate-600 text-lg">Loading your orders...</p>
      </div>

      <!-- Empty State -->
      <div v-else-if="orders.length === 0" class="max-w-lg mx-auto">
        <div class="backdrop-blur-xl bg-white/70 border border-white/20 rounded-3xl p-12 shadow-xl text-center">
          <div class="text-8xl mb-6">📦</div>
          <h3 class="text-3xl font-bold text-slate-800 mb-3">No Orders Yet</h3>
          <p class="text-slate-600 mb-8">Start shopping to see your orders here</p>
          <RouterLink 
            to="/shop" 
            class="inline-block px-8 py-4 rounded-xl bg-gradient-to-r from-blue-600 to-purple-600 text-white font-medium hover:shadow-lg hover:scale-105 transition-all duration-300"
          >
            Start Shopping
          </RouterLink>
        </div>
      </div>

      <!-- Orders List -->
      <div v-else class="space-y-4">
        <div
          v-for="order in orders"
          :key="order.id"
          class="group backdrop-blur-xl bg-white/70 border border-white/20 rounded-3xl p-6 shadow-xl hover:shadow-2xl transition-all duration-300"
        >
          <!-- Order Header -->
          <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4 mb-6 pb-6 border-b border-slate-200">
            <div class="flex-1">
              <div class="flex items-center gap-3 mb-2">
                <h3 class="text-2xl font-bold text-slate-900">Order #{{ order.id }}</h3>
                <span :class="[
                  'px-3 py-1 rounded-full text-xs font-bold',
                  getStatusClass(order.status)
                ]">
                  {{ order.status.toUpperCase() }}
                </span>
              </div>
              <div class="text-sm text-slate-600 flex items-center gap-4 flex-wrap">
                <span class="flex items-center gap-1">
                  <span>📅</span>
                  <span>{{ formatDate(order.created_at) }}</span>
                </span>
                <span class="flex items-center gap-1">
                  <span>📦</span>
                  <span>{{ order.items?.length || 0 }} {{ (order.items?.length || 0) === 1 ? 'item' : 'items' }}</span>
                </span>
              </div>
            </div>
            <div class="text-right">
              <div class="text-sm text-slate-600 mb-1">Total Amount</div>
              <div class="text-3xl font-bold bg-gradient-to-r from-blue-600 to-purple-600 bg-clip-text text-transparent">
                {{ formatMoney(order.total_cents) }}
              </div>
            </div>
          </div>

          <!-- Order Items -->
          <div class="space-y-3 mb-6">
            <div
              v-for="item in order.items"
              :key="item.id"
              class="flex gap-4 p-4 rounded-xl bg-gradient-to-br from-slate-50 to-blue-50 border border-slate-200"
            >
              <div class="h-20 w-20 rounded-xl bg-gradient-to-br from-slate-100 to-slate-200 overflow-hidden shrink-0 shadow-md">
                <img
                  v-if="item.product?.images?.[0]?.url || item.product?.images?.[0]?.path"
                  :src="item.product.images[0]?.url || item.product.images[0]?.path"
                  class="h-full w-full object-cover"
                  :alt="item.product?.name"
                />
                <div v-else class="h-full w-full flex items-center justify-center text-slate-400 text-2xl">
                  📷
                </div>
              </div>
              <div class="flex-1 min-w-0">
                <RouterLink
                  :to="`/products/${item.product?.id}`"
                  class="font-bold text-slate-900 hover:text-blue-600 transition line-clamp-2 mb-1"
                >
                  {{ item.product?.name }}
                </RouterLink>
                <div class="flex items-center gap-2 mb-2">
                  <span class="px-2 py-1 rounded-full bg-blue-100 text-blue-700 text-xs font-medium">
                    {{ item.variant?.size }}
                  </span>
                  <span class="px-2 py-1 rounded-full bg-purple-100 text-purple-700 text-xs font-medium">
                    {{ item.variant?.color }}
                  </span>
                  <span class="text-xs text-slate-500">Qty: {{ item.quantity }}</span>
                </div>
                <div class="text-lg font-bold text-slate-900">
                  {{ formatMoney(item.price_cents * item.quantity) }}
                </div>
              </div>
            </div>
          </div>

          <!-- Order Actions -->
          <div class="flex items-center justify-between pt-4 border-t border-slate-200">
            <RouterLink
              :to="`/orders/${order.id}`"
              class="px-6 py-3 rounded-xl bg-white/60 backdrop-blur border border-slate-300 text-slate-700 font-medium hover:bg-slate-50 hover:shadow-md transition-all duration-300 flex items-center gap-2"
            >
              <span>View Details</span>
              <span>→</span>
            </RouterLink>
            <div class="text-sm text-slate-500">
              Order placed on {{ formatDate(order.created_at) }}
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script setup>
import { onMounted, ref } from 'vue'
import { RouterLink } from 'vue-router'
import { api } from '../api/client'

const orders = ref([])
const loading = ref(false)
const error = ref(null)

function formatMoney(cents) {
  return new Intl.NumberFormat(undefined, { style: 'currency', currency: 'USD' }).format((cents || 0) / 100)
}

function formatDate(dateString) {
  if (!dateString) return 'N/A'
  const date = new Date(dateString)
  return date.toLocaleDateString('en-US', { 
    year: 'numeric', 
    month: 'long', 
    day: 'numeric',
    hour: '2-digit',
    minute: '2-digit'
  })
}

function getStatusClass(status) {
  const statusMap = {
    'pending': 'bg-yellow-100 text-yellow-800',
    'processing': 'bg-blue-100 text-blue-800',
    'shipped': 'bg-indigo-100 text-indigo-800',
    'delivered': 'bg-green-100 text-green-800',
    'cancelled': 'bg-red-100 text-red-800',
  }
  return statusMap[status?.toLowerCase()] || 'bg-slate-100 text-slate-800'
}

async function load() {
  loading.value = true
  error.value = null
  try {
    const { data } = await api.get('/orders')
    orders.value = data.data || []
  } catch (e) {
    error.value = e?.response?.data?.message || 'Failed to load orders.'
  } finally {
    loading.value = false
  }
}

onMounted(load)
</script>
