<template>
  <div class="min-h-screen bg-gradient-to-br from-violet-50 via-purple-50 to-fuchsia-50 -m-6 p-6">
    <!-- Header Section -->
    <div class="max-w-6xl mx-auto">
      <div class="mb-8">
        <div class="flex items-center gap-3 mb-2">
          <div class="text-4xl">👤</div>
          <h1 class="text-4xl font-bold bg-gradient-to-r from-violet-600 via-purple-600 to-fuchsia-600 bg-clip-text text-transparent">
            My Account
          </h1>
        </div>
        <p class="text-slate-600 ml-16">Manage your profile and addresses</p>
      </div>

      <div v-if="!auth.user" class="max-w-md mx-auto">
        <div class="backdrop-blur-xl bg-white/70 border border-white/20 rounded-3xl p-8 shadow-xl text-center">
          <div class="text-6xl mb-4">🔒</div>
          <h3 class="text-xl font-semibold mb-2">Login Required</h3>
          <p class="text-slate-600 mb-4">Please login to view your account details</p>
          <RouterLink 
            to="/login" 
            class="inline-block px-6 py-3 rounded-xl bg-gradient-to-r from-violet-600 to-fuchsia-600 text-white font-medium hover:shadow-lg hover:scale-105 transition-all duration-300"
          >
            Login Now
          </RouterLink>
        </div>
      </div>

      <div v-else class="space-y-6">
        <!-- Profile Card -->
        <div class="backdrop-blur-xl bg-white/70 border border-white/20 rounded-3xl p-8 shadow-xl hover:shadow-2xl transition-all duration-300">
          <div class="flex items-center gap-4 mb-6">
            <div class="w-20 h-20 rounded-2xl bg-gradient-to-br from-violet-500 via-purple-500 to-fuchsia-500 flex items-center justify-center text-4xl shadow-lg">
              {{ auth.user?.name?.charAt(0).toUpperCase() || '👤' }}
            </div>
            <div>
              <h2 class="text-2xl font-bold text-slate-800">{{ auth.user?.name }}</h2>
              <p class="text-slate-600">{{ auth.user?.email }}</p>
            </div>
          </div>
          
          <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
            <div class="bg-gradient-to-br from-violet-100 to-violet-50 rounded-2xl p-4 border border-violet-200">
              <div class="text-2xl mb-2">📧</div>
              <div class="text-xs text-violet-600 font-medium mb-1">EMAIL</div>
              <div class="text-sm font-semibold text-slate-800 break-all">{{ auth.user?.email }}</div>
            </div>
            
            <div class="bg-gradient-to-br from-purple-100 to-purple-50 rounded-2xl p-4 border border-purple-200">
              <div class="text-2xl mb-2">👤</div>
              <div class="text-xs text-purple-600 font-medium mb-1">NAME</div>
              <div class="text-sm font-semibold text-slate-800">{{ auth.user?.name }}</div>
            </div>
            
            <div class="bg-gradient-to-br from-fuchsia-100 to-fuchsia-50 rounded-2xl p-4 border border-fuchsia-200">
              <div class="text-2xl mb-2">⭐</div>
              <div class="text-xs text-fuchsia-600 font-medium mb-1">ROLE</div>
              <div class="text-sm font-semibold text-slate-800 capitalize">{{ auth.user?.role?.name || 'Customer' }}</div>
            </div>
          </div>
        </div>

        <!-- Addresses Section -->
        <div class="backdrop-blur-xl bg-white/70 border border-white/20 rounded-3xl p-8 shadow-xl hover:shadow-2xl transition-all duration-300">
          <div class="flex items-center justify-between mb-6">
            <div class="flex items-center gap-3">
              <div class="text-3xl">📍</div>
              <h3 class="text-2xl font-bold text-slate-800">Saved Addresses</h3>
            </div>
            <button
              class="px-5 py-2.5 rounded-xl bg-gradient-to-r from-violet-600 to-fuchsia-600 text-white font-medium hover:shadow-lg hover:scale-105 transition-all duration-300 flex items-center gap-2"
              @click="showAddForm = true"
            >
              <span class="text-xl">+</span>
              Add Address
            </button>
          </div>

          <div v-if="loading" class="text-center py-12">
            <div class="inline-block animate-spin text-5xl mb-4">⏳</div>
            <p class="text-slate-600">Loading addresses...</p>
          </div>
          
          <div v-else-if="error" class="rounded-2xl bg-gradient-to-r from-red-50 to-rose-50 border border-red-200 p-6">
            <div class="flex items-start gap-3">
              <div class="text-3xl">⚠️</div>
              <div>
                <h4 class="font-semibold text-red-800 mb-1">Error Loading Addresses</h4>
                <p class="text-sm text-red-600">{{ error }}</p>
              </div>
            </div>
          </div>
          
          <div v-else-if="addresses.length === 0" class="text-center py-12">
            <div class="text-6xl mb-4">📭</div>
            <h4 class="text-xl font-semibold text-slate-700 mb-2">No Addresses Yet</h4>
            <p class="text-slate-600">Add your first address to get started</p>
          </div>
          
          <div v-else class="space-y-4">
            <div
              v-for="addr in addresses"
              :key="addr.id"
              class="group backdrop-blur-sm bg-gradient-to-br from-white/60 to-white/40 border border-white/40 rounded-2xl p-6 hover:shadow-lg hover:scale-[1.02] transition-all duration-300"
            >
              <div class="flex items-start justify-between">
                <div class="flex-1">
                  <div class="flex items-center gap-2 mb-3">
                    <div class="text-2xl">🏠</div>
                    <div>
                      <div class="font-bold text-lg text-slate-800">{{ addr.full_name }}</div>
                      <div v-if="addr.label" class="inline-block px-3 py-1 rounded-full bg-violet-100 text-violet-700 text-xs font-medium mt-1">
                        {{ addr.label }}
                      </div>
                    </div>
                  </div>
                  
                  <div class="text-slate-600 text-sm leading-relaxed ml-9">
                    {{ addr.line1 }}<br />
                    <span v-if="addr.line2">{{ addr.line2 }}<br /></span>
                    {{ addr.city }}, {{ addr.state }} {{ addr.postal_code }}<br />
                    {{ addr.country }}
                  </div>
                  
                  <div v-if="addr.phone" class="mt-2 ml-9 flex items-center gap-2 text-sm text-slate-500">
                    <span>📞</span>
                    <span>{{ addr.phone }}</span>
                  </div>
                  
                  <div v-if="addr.is_default" class="mt-3 ml-9 inline-flex items-center gap-2 px-3 py-1.5 rounded-full bg-gradient-to-r from-emerald-500 to-teal-500 text-white text-xs font-semibold shadow-md">
                    <span>✓</span>
                    <span>Default Address</span>
                  </div>
                </div>
                
                <div class="flex flex-col gap-2 ml-4">
                  <button
                    v-if="!addr.is_default"
                    class="px-4 py-2 rounded-xl bg-white/80 border border-violet-200 text-violet-700 text-sm font-medium hover:bg-violet-50 hover:shadow-md transition-all duration-300"
                    @click="setDefault(addr.id)"
                    :disabled="loading"
                  >
                    Set Default
                  </button>
                  <button
                    class="px-4 py-2 rounded-xl bg-white/80 border border-red-200 text-red-600 text-sm font-medium hover:bg-red-50 hover:shadow-md transition-all duration-300"
                    @click="onDelete(addr.id)"
                    :disabled="loading"
                  >
                    Delete
                  </button>
                </div>
              </div>
            </div>
          </div>

          <!-- Add Address Form -->
          <div v-if="showAddForm" class="mt-6 backdrop-blur-sm bg-gradient-to-br from-violet-50/80 to-fuchsia-50/80 border-2 border-violet-200 rounded-2xl p-6 space-y-4">
            <div class="flex items-center gap-3 mb-4">
              <div class="text-3xl">➕</div>
              <h4 class="text-xl font-bold text-slate-800">Add New Address</h4>
            </div>
            
            <input
              v-model="newAddress.label"
              type="text"
              placeholder="🏷️ Label (e.g., Home, Work, Office)"
              class="w-full rounded-xl bg-white/80 backdrop-blur border border-violet-200 px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-violet-500 focus:border-transparent transition-all"
            />
            
            <input
              v-model="newAddress.full_name"
              type="text"
              placeholder="👤 Full Name *"
              required
              class="w-full rounded-xl bg-white/80 backdrop-blur border border-violet-200 px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-violet-500 focus:border-transparent transition-all"
            />
            
            <input
              v-model="newAddress.phone"
              type="tel"
              placeholder="📱 Phone Number"
              class="w-full rounded-xl bg-white/80 backdrop-blur border border-violet-200 px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-violet-500 focus:border-transparent transition-all"
            />
            
            <input
              v-model="newAddress.line1"
              type="text"
              placeholder="🏠 Address Line 1 *"
              required
              class="w-full rounded-xl bg-white/80 backdrop-blur border border-violet-200 px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-violet-500 focus:border-transparent transition-all"
            />
            
            <input
              v-model="newAddress.line2"
              type="text"
              placeholder="🏢 Address Line 2 (Optional)"
              class="w-full rounded-xl bg-white/80 backdrop-blur border border-violet-200 px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-violet-500 focus:border-transparent transition-all"
            />
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-3">
              <input
                v-model="newAddress.city"
                type="text"
                placeholder="🌆 City *"
                required
                class="w-full rounded-xl bg-white/80 backdrop-blur border border-violet-200 px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-violet-500 focus:border-transparent transition-all"
              />
              <input
                v-model="newAddress.state"
                type="text"
                placeholder="📍 State/Province"
                class="w-full rounded-xl bg-white/80 backdrop-blur border border-violet-200 px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-violet-500 focus:border-transparent transition-all"
              />
            </div>
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-3">
              <input
                v-model="newAddress.postal_code"
                type="text"
                placeholder="📮 Postal Code"
                class="w-full rounded-xl bg-white/80 backdrop-blur border border-violet-200 px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-violet-500 focus:border-transparent transition-all"
              />
              <input
                v-model="newAddress.country"
                type="text"
                placeholder="🌍 Country Code (e.g., US)"
                maxlength="2"
                class="w-full rounded-xl bg-white/80 backdrop-blur border border-violet-200 px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-violet-500 focus:border-transparent transition-all uppercase"
              />
            </div>
            
            <label class="flex items-center gap-3 p-4 rounded-xl bg-white/60 cursor-pointer hover:bg-white/80 transition-all">
              <input 
                v-model="newAddress.is_default" 
                type="checkbox" 
                class="w-5 h-5 rounded border-violet-300 text-violet-600 focus:ring-violet-500"
              />
              <span class="text-sm font-medium text-slate-700">⭐ Set as default address</span>
            </label>
            
            <div class="flex gap-3 pt-2">
              <button
                class="flex-1 px-6 py-3 rounded-xl bg-white/80 border border-slate-300 text-slate-700 font-medium hover:bg-slate-50 hover:shadow-md transition-all duration-300"
                @click="showAddForm = false; resetNewAddress()"
              >
                Cancel
              </button>
              <button
                class="flex-1 px-6 py-3 rounded-xl bg-gradient-to-r from-violet-600 to-fuchsia-600 text-white font-medium hover:shadow-lg hover:scale-105 transition-all duration-300 disabled:opacity-50 disabled:cursor-not-allowed"
                @click="onAddAddress"
                :disabled="loading"
              >
                {{ loading ? 'Saving...' : 'Save Address' }}
              </button>
            </div>
          </div>
        </div>

        <!-- Orders Link -->
        <RouterLink 
          to="/orders" 
          class="group block backdrop-blur-xl bg-white/70 border border-white/20 rounded-3xl p-6 shadow-xl hover:shadow-2xl transition-all duration-300"
        >
          <div class="flex items-center justify-between">
            <div class="flex items-center gap-4">
              <div class="w-14 h-14 rounded-2xl bg-gradient-to-br from-amber-400 to-orange-500 flex items-center justify-center text-2xl shadow-lg">
                📦
              </div>
              <div>
                <h3 class="text-xl font-bold text-slate-800 group-hover:text-violet-600 transition-colors">View My Orders</h3>
                <p class="text-sm text-slate-600">Track and manage your orders</p>
              </div>
            </div>
            <div class="text-3xl text-slate-400 group-hover:text-violet-600 group-hover:translate-x-2 transition-all">
              →
            </div>
          </div>
        </RouterLink>
      </div>
    </div>
  </div>
</template>

<script setup>
import { onMounted, ref } from 'vue'
import { RouterLink } from 'vue-router'
import { useAuthStore } from '../stores/auth'
import { api } from '../api/client'

const auth = useAuthStore()

const addresses = ref([])
const loading = ref(false)
const error = ref(null)
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
  loading.value = true
  error.value = null
  try {
    const { data } = await api.get('/addresses')
    addresses.value = data.data || data
  } catch (e) {
    error.value = e?.response?.data?.message || 'Failed to load addresses.'
  } finally {
    loading.value = false
  }
}

async function onAddAddress() {
  if (!newAddress.value.full_name || !newAddress.value.line1 || !newAddress.value.city) {
    return
  }
  loading.value = true
  error.value = null
  try {
    const { data } = await api.post('/addresses', newAddress.value)
    addresses.value.push(data.address)
    showAddForm.value = false
    resetNewAddress()
  } catch (e) {
    error.value = e?.response?.data?.message || 'Failed to add address.'
  } finally {
    loading.value = false
  }
}

async function setDefault(addressId) {
  loading.value = true
  error.value = null
  try {
    const { data } = await api.put(`/addresses/${addressId}/default`)
    await loadAddresses()
  } catch (e) {
    error.value = e?.response?.data?.message || 'Failed to set default address.'
  } finally {
    loading.value = false
  }
}

async function onDelete(addressId) {
  if (!confirm('Delete this address?')) return
  loading.value = true
  error.value = null
  try {
    await api.delete(`/addresses/${addressId}`)
    addresses.value = addresses.value.filter((a) => a.id !== addressId)
  } catch (e) {
    error.value = e?.response?.data?.message || 'Failed to delete address.'
  } finally {
    loading.value = false
  }
}

onMounted(async () => {
  if (auth.user) {
    await loadAddresses()
  }
})
</script>
