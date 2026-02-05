<template>
  <div class="min-h-screen bg-gradient-to-br from-blue-50 via-indigo-50 to-purple-50 -m-6 p-6">
    <div class="max-w-7xl mx-auto">
      <!-- Loading State -->
      <div v-if="loading" class="text-center py-20">
        <div class="inline-block animate-spin text-6xl mb-4">🔄</div>
        <p class="text-slate-600 text-lg">Loading product details...</p>
      </div>

      <!-- Error State -->
      <div v-else-if="error" class="max-w-lg mx-auto">
        <div class="backdrop-blur-xl bg-gradient-to-br from-red-50 to-rose-50 border-2 border-red-200 rounded-3xl p-8 shadow-xl">
          <div class="flex items-start gap-4">
            <div class="text-5xl">⚠️</div>
            <div class="flex-1">
              <h4 class="text-xl font-bold text-red-800 mb-2">Oops! Something went wrong</h4>
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

      <!-- Product Details -->
      <div v-else-if="product" class="space-y-8">
        <!-- Breadcrumb -->
        <nav class="flex items-center gap-2 text-sm text-slate-600">
          <RouterLink to="/" class="hover:text-slate-900 transition">Home</RouterLink>
          <span>/</span>
          <RouterLink to="/shop" class="hover:text-slate-900 transition">Shop</RouterLink>
          <span>/</span>
          <RouterLink :to="`/shop?category=${product.category?.slug}`" class="hover:text-slate-900 transition">
            {{ product.category?.name }}
          </RouterLink>
          <span>/</span>
          <span class="text-slate-900 font-medium">{{ product.name }}</span>
        </nav>

        <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 lg:gap-12">
          <!-- Image Gallery -->
          <div class="space-y-4">
            <!-- Main Image -->
            <div class="relative rounded-3xl overflow-hidden bg-gradient-to-br from-slate-100 to-slate-200 aspect-square shadow-2xl group">
              <img 
                v-if="currentImage" 
                :src="currentImage" 
                class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-700"
                :alt="product.name"
              />
              <div v-else class="w-full h-full flex items-center justify-center text-slate-400">
                <span class="text-6xl">📷</span>
              </div>
              
              <!-- Badges -->
              <div class="absolute top-4 left-4 flex flex-col gap-2">
                <div v-if="product.discount_cents" class="px-4 py-2 rounded-xl bg-gradient-to-r from-red-500 to-rose-500 text-white font-bold text-sm shadow-lg">
                  {{ Math.round((product.discount_cents / product.price_cents) * 100) }}% OFF
                </div>
                <div v-if="product.is_featured" class="px-4 py-2 rounded-xl bg-gradient-to-r from-yellow-400 to-orange-500 text-white font-bold text-sm shadow-lg">
                  ⭐ FEATURED
                </div>
              </div>

              <!-- Image Navigation Arrows -->
              <button
                v-if="product.images?.length > 1 && selectedImage > 0"
                @click="selectedImage = selectedImage - 1"
                class="absolute left-4 top-1/2 -translate-y-1/2 w-12 h-12 rounded-full bg-white/90 backdrop-blur-sm shadow-lg flex items-center justify-center hover:bg-white transition-all hover:scale-110"
              >
                <span class="text-2xl">←</span>
              </button>
              <button
                v-if="product.images?.length > 1 && selectedImage < product.images.length - 1"
                @click="selectedImage = selectedImage + 1"
                class="absolute right-4 top-1/2 -translate-y-1/2 w-12 h-12 rounded-full bg-white/90 backdrop-blur-sm shadow-lg flex items-center justify-center hover:bg-white transition-all hover:scale-110"
              >
                <span class="text-2xl">→</span>
              </button>
            </div>

            <!-- Thumbnail Gallery -->
            <div v-if="product.images?.length > 1" class="grid grid-cols-4 gap-3">
              <button
                v-for="(img, idx) in product.images.slice(0, 4)"
                :key="idx"
                @click="selectedImage = idx"
                :class="[
                  'relative rounded-xl overflow-hidden bg-gradient-to-br from-slate-100 to-slate-200 aspect-square border-2 transition-all duration-300 hover:scale-105',
                  selectedImage === idx 
                    ? 'border-indigo-500 shadow-lg ring-2 ring-indigo-200' 
                    : 'border-transparent hover:border-slate-300'
                ]"
              >
                <img 
                  :src="img.url || img.path" 
                  class="w-full h-full object-cover"
                  :alt="`${product.name} view ${idx + 1}`"
                />
                <div v-if="selectedImage === idx" class="absolute inset-0 bg-indigo-500/20"></div>
              </button>
            </div>
          </div>

          <!-- Product Info -->
          <div class="space-y-6">
            <!-- Category & Name -->
            <div>
              <div class="inline-flex items-center gap-2 px-4 py-2 rounded-full bg-gradient-to-r from-blue-100 to-indigo-100 text-blue-700 text-sm font-medium mb-3">
                <span>🏷️</span>
                <span>{{ product.category?.name }}</span>
              </div>
              <h1 class="text-4xl lg:text-5xl font-bold bg-gradient-to-r from-slate-900 via-indigo-900 to-purple-900 bg-clip-text text-transparent mb-4">
                {{ product.name }}
              </h1>
            </div>

            <!-- Price -->
            <div class="flex items-baseline gap-4">
              <span class="text-4xl font-bold bg-gradient-to-r from-blue-600 to-purple-600 bg-clip-text text-transparent">
                {{ formatMoney(product.price_cents - (product.discount_cents || 0)) }}
              </span>
              <span v-if="product.discount_cents" class="text-2xl text-slate-400 line-through">
                {{ formatMoney(product.price_cents) }}
              </span>
            </div>

            <!-- Description -->
            <div v-if="product.description" class="prose max-w-none">
              <p class="text-slate-700 text-lg leading-relaxed">{{ product.description }}</p>
            </div>

            <!-- Variant Selection -->
            <div class="space-y-4">
              <div>
                <label class="block text-sm font-semibold text-slate-700 mb-3">
                  <span class="flex items-center gap-2">
                    <span>📏</span>
                    <span>Select Size & Color</span>
                  </span>
                </label>
                <select 
                  v-model="variantId" 
                  class="w-full rounded-xl border-2 border-slate-300 bg-white px-4 py-3 text-base font-medium focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-all"
                >
                  <option disabled value="">Choose a variant...</option>
                  <option v-for="v in inStockVariants" :key="v.id" :value="v.id">
                    {{ v.size }} / {{ v.color }} ({{ v.stock }} in stock)
                  </option>
                </select>
              </div>

              <div>
                <label class="block text-sm font-semibold text-slate-700 mb-3">
                  <span class="flex items-center gap-2">
                    <span>🔢</span>
                    <span>Quantity</span>
                  </span>
                </label>
                <div class="flex items-center gap-3">
                  <button
                    @click="qty = Math.max(1, qty - 1)"
                    :disabled="qty <= 1"
                    class="w-12 h-12 rounded-xl border-2 border-slate-300 bg-white font-bold text-xl hover:bg-slate-50 disabled:opacity-50 disabled:cursor-not-allowed transition-all"
                  >
                    −
                  </button>
                  <input 
                    v-model.number="qty" 
                    type="number" 
                    min="1" 
                    max="20" 
                    class="w-20 text-center rounded-xl border-2 border-slate-300 bg-white px-4 py-3 text-lg font-semibold focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500"
                  />
                  <button
                    @click="qty = Math.min(20, qty + 1)"
                    :disabled="qty >= 20"
                    class="w-12 h-12 rounded-xl border-2 border-slate-300 bg-white font-bold text-xl hover:bg-slate-50 disabled:opacity-50 disabled:cursor-not-allowed transition-all"
                  >
                    +
                  </button>
                </div>
              </div>
            </div>

            <!-- Action Buttons -->
            <div class="space-y-3 pt-4">
              <button
                v-if="auth.user"
                @click="addToCart"
                :disabled="!variantId || addingToCart"
                class="w-full rounded-xl bg-gradient-to-r from-blue-600 via-indigo-600 to-purple-600 px-8 py-4 text-white font-bold text-lg shadow-xl hover:shadow-2xl hover:scale-105 transition-all duration-300 disabled:opacity-50 disabled:cursor-not-allowed disabled:hover:scale-100 flex items-center justify-center gap-2"
              >
                <span v-if="addingToCart" class="animate-spin">🔄</span>
                <span v-else>🛒</span>
                <span>{{ addingToCart ? 'Adding to Cart...' : 'Add to Cart' }}</span>
              </button>
              <div v-else class="rounded-xl bg-gradient-to-r from-amber-50 to-orange-50 border-2 border-amber-200 p-4">
                <p class="text-sm text-amber-800 text-center">
                  Please <RouterLink to="/login" class="font-semibold underline hover:text-amber-900">login</RouterLink> to add items to your cart
                </p>
              </div>

              <div v-if="!variantId && inStockVariants.length > 0" class="rounded-xl bg-gradient-to-r from-yellow-50 to-amber-50 border-2 border-yellow-200 p-3">
                <p class="text-sm text-amber-800 text-center flex items-center justify-center gap-2">
                  <span>⚠️</span>
                  <span>Please select a size and color</span>
                </p>
              </div>

              <RouterLink 
                to="/cart" 
                class="block w-full rounded-xl border-2 border-slate-300 bg-white px-8 py-4 text-center text-slate-700 font-semibold text-lg hover:bg-slate-50 hover:border-indigo-300 transition-all duration-300"
              >
                View Cart →
              </RouterLink>
            </div>

            <!-- Product Features -->
            <div class="grid grid-cols-2 gap-4 pt-6 border-t border-slate-200">
              <div class="flex items-center gap-3 p-4 rounded-xl bg-white/60 backdrop-blur border border-slate-200">
                <div class="text-3xl">🚚</div>
                <div>
                  <div class="font-semibold text-slate-900">Free Shipping</div>
                  <div class="text-xs text-slate-600">Over $50</div>
                </div>
              </div>
              <div class="flex items-center gap-3 p-4 rounded-xl bg-white/60 backdrop-blur border border-slate-200">
                <div class="text-3xl">↩️</div>
                <div>
                  <div class="font-semibold text-slate-900">Easy Returns</div>
                  <div class="text-xs text-slate-600">30-day policy</div>
                </div>
              </div>
              <div class="flex items-center gap-3 p-4 rounded-xl bg-white/60 backdrop-blur border border-slate-200">
                <div class="text-3xl">🔒</div>
                <div>
                  <div class="font-semibold text-slate-900">Secure Payment</div>
                  <div class="text-xs text-slate-600">100% safe</div>
                </div>
              </div>
              <div class="flex items-center gap-3 p-4 rounded-xl bg-white/60 backdrop-blur border border-slate-200">
                <div class="text-3xl">⭐</div>
                <div>
                  <div class="font-semibold text-slate-900">Quality Guarantee</div>
                  <div class="text-xs text-slate-600">Premium quality</div>
                </div>
              </div>
            </div>
          </div>
        </div>

        <!-- Success Toast -->
        <Transition
          enter-active-class="transition ease-out duration-300"
          enter-from-class="opacity-0 translate-y-2"
          enter-to-class="opacity-100 translate-y-0"
          leave-active-class="transition ease-in duration-200"
          leave-from-class="opacity-100"
          leave-to-class="opacity-0"
        >
          <div v-if="showSuccess" class="fixed top-4 right-4 z-50">
            <div class="backdrop-blur-xl bg-gradient-to-r from-green-500 to-emerald-500 text-white px-6 py-4 rounded-2xl shadow-2xl flex items-center gap-3">
              <span class="text-2xl">✓</span>
              <span class="font-semibold">Added to cart successfully!</span>
            </div>
          </div>
        </Transition>
      </div>
    </div>
  </div>
</template>

<script setup>
import { computed, onMounted, ref } from 'vue'
import { RouterLink, useRoute } from 'vue-router'
import { api } from '../api/client'
import { useAuthStore } from '../stores/auth'
import { useCartStore } from '../stores/cart'

const route = useRoute()
const auth = useAuthStore()
const cart = useCartStore()

const product = ref(null)
const loading = ref(false)
const error = ref(null)

const variantId = ref('')
const qty = ref(1)
const selectedImage = ref(0)
const addingToCart = ref(false)
const showSuccess = ref(false)

const inStockVariants = computed(() => (product.value?.variants || []).filter((v) => v.stock > 0))

const currentImage = computed(() => {
  if (!product.value?.images?.length) return null
  const img = product.value.images[selectedImage.value] || product.value.images[0]
  return img?.url || img?.path
})

function formatMoney(cents) {
  return new Intl.NumberFormat(undefined, { style: 'currency', currency: 'USD' }).format((cents || 0) / 100)
}

async function load() {
  loading.value = true
  error.value = null
  try {
    const { data } = await api.get(`/products/${route.params.id}`)
    product.value = data.data || data
  } catch (e) {
    error.value = e?.response?.data?.message || 'Failed to load product.'
  } finally {
    loading.value = false
  }
}

async function addToCart() {
  if (!variantId.value) {
    error.value = 'Please select a size and color'
    return
  }
  addingToCart.value = true
  error.value = null
  try {
    await cart.addItem(Number(variantId.value), Number(qty.value || 1))
    await cart.fetchCart()
    
    // Show success message
    showSuccess.value = true
    setTimeout(() => {
      showSuccess.value = false
    }, 3000)
  } catch (e) {
    error.value = e?.response?.data?.message || 'Failed to add to cart'
  } finally {
    addingToCart.value = false
  }
}

onMounted(load)
</script>
