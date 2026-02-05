<template>
  <div class="space-y-6">
    <h2 class="text-2xl font-semibold">Orders</h2>

    <div v-if="loading" class="text-sm text-slate-500">Loading…</div>
    <div v-else-if="error" class="rounded-xl border border-red-200 bg-red-50 p-3 text-sm text-red-700">
      {{ error }}
    </div>
    <div v-else-if="orders.length === 0" class="text-sm text-slate-500">No orders found.</div>
    <div v-else class="space-y-4">
      <div
        v-for="order in orders"
        :key="order.id"
        class="rounded-xl border p-4 space-y-3"
      >
        <div class="flex items-center justify-between">
          <div>
            <div class="font-medium">Order #{{ order.id }}</div>
            <div class="text-sm text-slate-500">
              {{ order.user?.name }} • {{ new Date(order.created_at).toLocaleDateString() }}
            </div>
          </div>
          <div class="flex items-center gap-3">
            <select
              :value="order.status"
              @change="updateStatus(order.id, $event.target.value)"
              class="rounded-xl border px-3 py-1.5 text-sm"
              :disabled="updatingStatus === order.id"
            >
              <option value="pending">Pending</option>
              <option value="paid">Paid</option>
              <option value="shipped">Shipped</option>
              <option value="delivered">Delivered</option>
              <option value="cancelled">Cancelled</option>
            </select>
          </div>
        </div>

        <div class="text-sm space-y-1">
          <div v-for="item in order.items" :key="item.id" class="flex justify-between">
            <span>{{ item.product_name }} ({{ item.variant_size }}/{{ item.variant_color }}) × {{ item.quantity }}</span>
            <span>${{ (item.price * item.quantity).toFixed(2) }}</span>
          </div>
        </div>

        <div class="pt-2 border-t flex justify-between text-sm">
          <div>
            <div class="text-slate-500">Shipping to:</div>
            <div class="font-medium">
              {{ order.address?.full_name }}<br />
              {{ order.address?.line1 }}<br />
              {{ order.address?.city }}, {{ order.address?.state }} {{ order.address?.postal_code }}
            </div>
          </div>
          <div class="text-right">
            <div class="text-slate-500">Total</div>
            <div class="text-lg font-semibold">${{ order.total.toFixed(2) }}</div>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script setup>
import { onMounted, ref } from 'vue'
import { api } from '../../api/client'

const orders = ref([])
const loading = ref(false)
const error = ref(null)
const updatingStatus = ref(null)

async function loadOrders() {
  loading.value = true
  error.value = null
  try {
    const { data } = await api.get('/admin/orders')
    orders.value = data.data || data
  } catch (e) {
    error.value = e?.response?.data?.message || 'Failed to load orders.'
  } finally {
    loading.value = false
  }
}

async function updateStatus(orderId, status) {
  updatingStatus.value = orderId
  error.value = null
  try {
    const { data } = await api.put(`/admin/orders/${orderId}/status`, { status })
    const idx = orders.value.findIndex((o) => o.id === orderId)
    if (idx >= 0) orders.value[idx] = data.order || { ...orders.value[idx], status }
  } catch (e) {
    error.value = e?.response?.data?.message || 'Failed to update order status.'
  } finally {
    updatingStatus.value = null
  }
}

onMounted(() => {
  loadOrders()
})
</script>
