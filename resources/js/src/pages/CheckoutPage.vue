<template>
  <div class="min-h-screen bg-gradient-to-br from-blue-50 via-indigo-50 to-purple-50 -m-6 p-6">
    <div class="max-w-7xl mx-auto">
      <!-- Header -->
      <div class="mb-8 flex items-center justify-between flex-wrap gap-4">
        <div>
          <div class="flex items-center gap-3 mb-2">
            <div class="text-4xl">💳</div>
            <h1 class="text-4xl font-bold bg-gradient-to-r from-blue-600 via-indigo-600 to-purple-600 bg-clip-text text-transparent">
              Checkout
            </h1>
          </div>
          <p class="text-slate-600 ml-16">Complete your purchase securely</p>
        </div>
        <RouterLink 
          to="/cart" 
          class="px-6 py-2.5 rounded-xl bg-white/70 backdrop-blur border border-white/40 text-slate-700 font-medium hover:shadow-lg hover:scale-105 transition-all duration-300"
        >
          ← Back to Cart
        </RouterLink>
      </div>

      <!-- Login Required -->
      <div v-if="!auth.user" class="max-w-lg mx-auto">
        <div class="backdrop-blur-xl bg-white/70 border border-white/20 rounded-3xl p-12 shadow-xl text-center">
          <div class="text-7xl mb-6">🔒</div>
          <h3 class="text-2xl font-bold text-slate-800 mb-3">Login Required</h3>
          <p class="text-slate-600 mb-6">Please login to proceed with checkout</p>
          <RouterLink 
            to="/login" 
            class="inline-block px-8 py-4 rounded-xl bg-gradient-to-r from-blue-600 to-purple-600 text-white font-medium hover:shadow-lg hover:scale-105 transition-all duration-300"
          >
            Login to Continue
          </RouterLink>
        </div>
      </div>

      <!-- Loading State -->
      <div v-else-if="cart.loading || addresses.loading" class="text-center py-20">
        <div class="inline-block animate-spin text-6xl mb-4">🔄</div>
        <p class="text-slate-600 text-lg">Loading checkout...</p>
      </div>

      <!-- Error State -->
      <div v-else-if="cart.error" class="max-w-lg mx-auto">
        <div class="backdrop-blur-xl bg-gradient-to-br from-red-50 to-rose-50 border-2 border-red-200 rounded-3xl p-8 shadow-xl">
          <div class="flex items-start gap-4">
            <div class="text-5xl">⚠️</div>
            <div class="flex-1">
              <h4 class="text-xl font-bold text-red-800 mb-2">Error Loading Cart</h4>
              <p class="text-red-600 mb-4">{{ cart.error }}</p>
              <button 
                @click="cart.fetchCart()" 
                class="px-6 py-3 rounded-xl bg-gradient-to-r from-red-600 to-rose-600 text-white font-medium hover:shadow-lg hover:scale-105 transition-all duration-300"
              >
                Try Again
              </button>
            </div>
          </div>
        </div>
      </div>

      <!-- Empty Cart -->
      <div v-else-if="!cart.cart || cart.items.length === 0" class="max-w-lg mx-auto">
        <div class="backdrop-blur-xl bg-white/70 border border-white/20 rounded-3xl p-12 shadow-xl text-center">
          <div class="text-8xl mb-6">🛒</div>
          <h3 class="text-3xl font-bold text-slate-800 mb-3">Your Cart is Empty</h3>
          <p class="text-slate-600 mb-8">Add items to your cart to checkout</p>
          <RouterLink 
            to="/shop" 
            class="inline-block px-8 py-4 rounded-xl bg-gradient-to-r from-blue-600 to-purple-600 text-white font-medium hover:shadow-lg hover:scale-105 transition-all duration-300"
          >
            Continue Shopping
          </RouterLink>
        </div>
      </div>

      <!-- Checkout Form -->
      <div v-else class="grid gap-8 lg:grid-cols-2">
        <!-- Shipping Address Section -->
        <div class="space-y-6">
          <div class="backdrop-blur-xl bg-white/70 border border-white/20 rounded-3xl p-6 shadow-xl">
            <div class="flex items-center gap-3 mb-6">
              <div class="text-3xl">📍</div>
              <h2 class="text-2xl font-bold text-slate-800">Shipping Address</h2>
            </div>

            <!-- Address Error -->
            <div v-if="addresses.error" class="mb-4 rounded-xl bg-gradient-to-r from-red-50 to-rose-50 border-2 border-red-200 p-4">
              <p class="text-sm text-red-700">{{ addresses.error }}</p>
            </div>

            <!-- No Addresses -->
            <div v-if="addresses.addresses.length === 0 && !showAddForm" class="text-center py-8">
              <div class="text-6xl mb-4">📮</div>
              <p class="text-slate-600 mb-4">No addresses saved</p>
              <button
                class="px-6 py-3 rounded-xl bg-gradient-to-r from-blue-600 to-purple-600 text-white font-medium hover:shadow-lg hover:scale-105 transition-all duration-300"
                @click="showAddForm = true"
              >
                + Add Address
              </button>
            </div>

            <!-- Address List -->
            <div v-else-if="!showAddForm" class="space-y-3">
              <div
                v-for="addr in addresses.addresses"
                :key="addr.id"
                @click="selectedAddressId = addr.id"
                :class="[
                  'cursor-pointer rounded-2xl p-5 border-2 transition-all duration-300',
                  selectedAddressId === addr.id
                    ? 'bg-gradient-to-br from-blue-50 to-indigo-50 border-blue-500 shadow-lg scale-[1.02]'
                    : 'bg-white/60 border-slate-200 hover:border-blue-300 hover:shadow-md'
                ]"
              >
                <div class="flex items-start justify-between">
                  <div class="flex-1">
                    <div class="flex items-center gap-2 mb-2">
                      <span class="font-bold text-lg text-slate-900">{{ addr.full_name }}</span>
                      <span v-if="addr.is_default" class="px-2 py-1 rounded-full bg-gradient-to-r from-green-500 to-emerald-500 text-white text-xs font-bold">
                        DEFAULT
                      </span>
                    </div>
                    <div class="text-sm text-slate-600 space-y-1">
                      <div>{{ addr.line1 }}</div>
                      <div v-if="addr.line2">{{ addr.line2 }}</div>
                      <div>{{ addr.city }}, {{ addr.state }} {{ addr.postal_code }}</div>
                      <div>{{ addr.country }}</div>
                    </div>
                    <div v-if="addr.phone" class="mt-2 text-xs text-slate-500 flex items-center gap-1">
                      <span>📞</span>
                      <span>{{ addr.phone }}</span>
                    </div>
                  </div>
                  <div class="ml-4">
                    <div :class="[
                      'w-6 h-6 rounded-full border-2 flex items-center justify-center transition-all',
                      selectedAddressId === addr.id
                        ? 'border-blue-600 bg-blue-600'
                        : 'border-slate-300'
                    ]">
                      <div v-if="selectedAddressId === addr.id" class="w-3 h-3 rounded-full bg-white"></div>
                    </div>
                  </div>
                </div>
              </div>

              <button
                class="w-full rounded-xl border-2 border-dashed border-slate-300 bg-white/60 px-6 py-4 text-slate-700 font-medium hover:border-blue-400 hover:bg-blue-50 transition-all duration-300 flex items-center justify-center gap-2"
                @click="showAddForm = true"
              >
                <span class="text-xl">+</span>
                <span>Add New Address</span>
              </button>
            </div>

            <!-- Add Address Form -->
            <div v-if="showAddForm" class="space-y-4 rounded-2xl bg-gradient-to-br from-slate-50 to-blue-50 p-6 border-2 border-blue-200">
              <div class="flex items-center justify-between mb-4">
                <h3 class="text-xl font-bold text-slate-800">Add New Address</h3>
                <button
                  @click="showAddForm = false; resetNewAddress()"
                  class="text-slate-500 hover:text-slate-700 text-2xl"
                >
                  ×
                </button>
              </div>
              
              <div class="grid gap-4">
                <input
                  v-model="newAddress.label"
                  type="text"
                  placeholder="Label (e.g., Home, Work)"
                  class="w-full rounded-xl border-2 border-slate-300 bg-white px-4 py-3 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition"
                />
                <input
                  v-model="newAddress.full_name"
                  type="text"
                  placeholder="Full Name *"
                  required
                  class="w-full rounded-xl border-2 border-slate-300 bg-white px-4 py-3 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition"
                />
                <input
                  v-model="newAddress.phone"
                  type="tel"
                  placeholder="Phone Number"
                  class="w-full rounded-xl border-2 border-slate-300 bg-white px-4 py-3 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition"
                />
                <input
                  v-model="newAddress.line1"
                  type="text"
                  placeholder="Address Line 1 *"
                  required
                  class="w-full rounded-xl border-2 border-slate-300 bg-white px-4 py-3 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition"
                />
                <input
                  v-model="newAddress.line2"
                  type="text"
                  placeholder="Address Line 2 (Optional)"
                  class="w-full rounded-xl border-2 border-slate-300 bg-white px-4 py-3 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition"
                />
                <div class="grid grid-cols-2 gap-4">
                  <input
                    v-model="newAddress.city"
                    type="text"
                    placeholder="City *"
                    required
                    class="w-full rounded-xl border-2 border-slate-300 bg-white px-4 py-3 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition"
                  />
                  <input
                    v-model="newAddress.state"
                    type="text"
                    placeholder="State"
                    class="w-full rounded-xl border-2 border-slate-300 bg-white px-4 py-3 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition"
                  />
                </div>
                <div class="grid grid-cols-2 gap-4">
                  <input
                    v-model="newAddress.postal_code"
                    type="text"
                    placeholder="Postal Code"
                    class="w-full rounded-xl border-2 border-slate-300 bg-white px-4 py-3 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition"
                  />
                  <input
                    v-model="newAddress.country"
                    type="text"
                    placeholder="Country (e.g., US)"
                    maxlength="2"
                    class="w-full rounded-xl border-2 border-slate-300 bg-white px-4 py-3 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition"
                  />
                </div>
                <label class="flex items-center gap-3 text-sm text-slate-700 cursor-pointer">
                  <input 
                    v-model="newAddress.is_default" 
                    type="checkbox" 
                    class="w-5 h-5 rounded border-2 border-slate-300 text-blue-600 focus:ring-2 focus:ring-blue-500"
                  />
                  <span>Set as default address</span>
                </label>
                <div class="flex gap-3 pt-2">
                  <button
                    class="flex-1 rounded-xl border-2 border-slate-300 bg-white px-6 py-3 text-slate-700 font-medium hover:bg-slate-50 transition"
                    @click="showAddForm = false; resetNewAddress()"
                  >
                    Cancel
                  </button>
                  <button
                    class="flex-1 rounded-xl bg-gradient-to-r from-blue-600 to-purple-600 px-6 py-3 text-white font-medium hover:shadow-lg hover:scale-105 transition-all duration-300 disabled:opacity-50"
                    @click="onAddAddress"
                    :disabled="addresses.loading"
                  >
                    {{ addresses.loading ? 'Saving...' : 'Save Address' }}
                  </button>
                </div>
              </div>
            </div>
          </div>
        </div>

        <!-- Order Summary Section -->
        <div class="space-y-6">
          <div class="backdrop-blur-xl bg-white/70 border border-white/20 rounded-3xl p-6 shadow-xl sticky top-6">
            <div class="flex items-center gap-3 mb-6">
              <div class="text-3xl">📦</div>
              <h2 class="text-2xl font-bold text-slate-800">Order Summary</h2>
            </div>

            <!-- Cart Items -->
            <div class="space-y-4 mb-6">
              <div v-for="item in cart.items" :key="item.id" class="flex gap-4 p-4 rounded-xl bg-gradient-to-br from-slate-50 to-blue-50 border border-slate-200">
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
                  <div class="font-bold text-slate-900 mb-1 line-clamp-2">{{ item.product?.name }}</div>
                  <div class="flex items-center gap-2 mb-2">
                    <span class="px-2 py-1 rounded-full bg-blue-100 text-blue-700 text-xs font-medium">
                      {{ item.variant?.size }}
                    </span>
                    <span class="px-2 py-1 rounded-full bg-purple-100 text-purple-700 text-xs font-medium">
                      {{ item.variant?.color }}
                    </span>
                    <span class="text-xs text-slate-500">× {{ item.quantity }}</span>
                  </div>
                  <div class="text-lg font-bold bg-gradient-to-r from-blue-600 to-purple-600 bg-clip-text text-transparent">
                    {{ formatMoney((item.product?.price_cents || 0) * item.quantity) }}
                  </div>
                </div>
              </div>
            </div>

            <!-- Price Breakdown -->
            <div class="space-y-3 pt-6 border-t border-slate-200">
              <div class="flex justify-between items-center text-slate-600">
                <span>Subtotal</span>
                <span class="font-semibold">{{ formatMoney(subtotal) }}</span>
              </div>
              <div class="flex justify-between items-center text-slate-500 text-sm">
                <span>Shipping</span>
                <span>Calculated at checkout</span>
              </div>
              <div class="pt-4 border-t border-slate-200">
                <div class="flex justify-between items-center">
                  <span class="text-lg font-bold text-slate-900">Total</span>
                  <span class="text-2xl font-bold bg-gradient-to-r from-blue-600 to-purple-600 bg-clip-text text-transparent">
                    {{ formatMoney(subtotal) }}
                  </span>
                </div>
              </div>
            </div>

            <!-- Place Order Button -->
            <button
              class="w-full mt-6 rounded-xl bg-gradient-to-r from-blue-600 via-indigo-600 to-purple-600 px-8 py-4 text-white font-bold text-lg shadow-xl hover:shadow-2xl hover:scale-105 transition-all duration-300 disabled:opacity-50 disabled:cursor-not-allowed disabled:hover:scale-100 flex items-center justify-center gap-2"
              @click="onCheckout"
              :disabled="!selectedAddressId || checkout.loading"
            >
              <span v-if="checkout.loading" class="animate-spin">🔄</span>
              <span v-else>💳</span>
              <span>{{ checkout.loading ? 'Processing Order...' : 'Place Order' }}</span>
            </button>

            <!-- Checkout Error -->
            <div v-if="checkout.error" class="mt-4 rounded-xl bg-gradient-to-r from-red-50 to-rose-50 border-2 border-red-200 p-4">
              <p class="text-sm text-red-700 flex items-center gap-2">
                <span>⚠️</span>
                <span>{{ checkout.error }}</span>
              </p>
            </div>

            <!-- Security Badges -->
            <div class="mt-6 pt-6 border-t border-slate-200 space-y-2">
              <div class="flex items-center gap-2 text-sm text-slate-600">
                <span class="text-lg">🔒</span>
                <span>Secure checkout</span>
              </div>
              <div class="flex items-center gap-2 text-sm text-slate-600">
                <span class="text-lg">✓</span>
                <span>SSL encrypted</span>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script setup>
import { computed, onMounted, ref } from 'vue'
import { useRouter } from 'vue-router'
import { RouterLink } from 'vue-router'
import { useAuthStore } from '../stores/auth'
import { useCartStore } from '../stores/cart'
import { api } from '../api/client'

const router = useRouter()
const auth = useAuthStore()
const cart = useCartStore()

const addresses = ref({
  addresses: [],
  loading: false,
  error: null,
})

const checkout = ref({
  loading: false,
  error: null,
})

const selectedAddressId = ref(null)
const showAddForm = ref(false)

const newAddress = ref({
  label: '',
  full_name: '',
  phone: '',
  line1: '',
  line2: '',
  city: '',
  state: '',
  postal_code: '',
  country: 'US',
  is_default: false,
})

const subtotal = computed(() => {
  return cart.items.reduce((sum, item) => {
    const price = item.product?.price_cents || 0
    return sum + (price * item.quantity)
  }, 0)
})

function formatMoney(cents) {
  return new Intl.NumberFormat(undefined, { style: 'currency', currency: 'USD' }).format((cents || 0) / 100)
}

function resetNewAddress() {
  newAddress.value = {
    label: '',
    full_name: '',
    phone: '',
    line1: '',
    line2: '',
    city: '',
    state: '',
    postal_code: '',
    country: 'US',
    is_default: false,
  }
}

async function loadAddresses() {
  addresses.value.loading = true
  addresses.value.error = null
  try {
    const { data } = await api.get('/addresses')
    addresses.value.addresses = data.data || data
    if (addresses.value.addresses.length > 0 && !selectedAddressId.value) {
      const defaultAddr = addresses.value.addresses.find((a) => a.is_default)
      selectedAddressId.value = defaultAddr ? defaultAddr.id : addresses.value.addresses[0].id
    }
  } catch (e) {
    addresses.value.error = e?.response?.data?.message || 'Failed to load addresses.'
  } finally {
    addresses.value.loading = false
  }
}

async function onAddAddress() {
  if (!newAddress.value.full_name || !newAddress.value.line1 || !newAddress.value.city) {
    return
  }
  addresses.value.loading = true
  addresses.value.error = null
  try {
    const { data } = await api.post('/addresses', newAddress.value)
    addresses.value.addresses.push(data.address)
    selectedAddressId.value = data.address.id
    showAddForm.value = false
    resetNewAddress()
  } catch (e) {
    addresses.value.error = e?.response?.data?.message || 'Failed to add address.'
  } finally {
    addresses.value.loading = false
  }
}

async function onCheckout() {
  if (!selectedAddressId.value) {
    checkout.value.error = 'Please select a shipping address.'
    return
  }
  checkout.value.loading = true
  checkout.value.error = null
  try {
    const { data } = await api.post('/checkout', { address_id: selectedAddressId.value })
    cart.cart = null
    router.push(`/orders/${data.order.id}`)
  } catch (e) {
    checkout.value.error = e?.response?.data?.message || 'Checkout failed. Please try again.'
  } finally {
    checkout.value.loading = false
  }
}

onMounted(async () => {
  if (auth.user) {
    await Promise.all([cart.fetchCart(), loadAddresses()])
  }
})
</script>
