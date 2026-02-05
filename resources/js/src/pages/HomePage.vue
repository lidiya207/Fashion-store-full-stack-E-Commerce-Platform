<template>
  <div class="space-y-12">
    <!-- Hero Section with Enhanced Design -->
    <section class="relative rounded-3xl border overflow-hidden">
      <div class="absolute inset-0 bg-gradient-to-br from-slate-800 via-slate-700 to-slate-900 opacity-95"></div>
      <div class="absolute inset-0 bg-[url('data:image/svg+xml;base64,PHN2ZyB3aWR0aD0iNjAiIGhlaWdodD0iNjAiIHhtbG5zPSJodHRwOi8vd3d3LnczLm9yZy8yMDAwL3N2ZyI+PGRlZnM+PHBhdHRlcm4gaWQ9ImdyaWQiIHdpZHRoPSI2MCIgaGVpZ2h0PSI2MCIgcGF0dGVyblVuaXRzPSJ1c2VyU3BhY2VPblVzZSI+PHBhdGggZD0iTSAxMCAwIEwgMCAwIDAgMTAiIGZpbGw9Im5vbmUiIHN0cm9rZT0id2hpdGUiIHN0cm9rZS1vcGFjaXR5PSIwLjEiIHN0cm9rZS13aWR0aD0iMSIvPjwvcGF0dGVybj48L2RlZnM+PHJlY3Qgd2lkdGg9IjEwMCUiIGhlaWdodD0iMTAwJSIgZmlsbD0idXJsKCNncmlkKSIvPjwvc3ZnPg==')] opacity-50"></div>
      
      <div class="relative max-w-4xl mx-auto px-8 md:px-12 py-16 md:py-24 text-center text-white">
        <div class="inline-block animate-pulse mb-6">
          <div class="text-7xl">👕</div>
        </div>
        <h1 class="text-5xl md:text-7xl font-bold tracking-tight mb-6 drop-shadow-lg">
          Fashion Store
        </h1>
        <p class="text-xl md:text-2xl text-white/90 mb-8 max-w-2xl mx-auto leading-relaxed">
          Discover premium quality clothing and the latest trends. 
          <strong>Your style, Your statement.</strong>
        </p>
        <div class="flex flex-col sm:flex-row gap-4 justify-center items-center">
          <RouterLink 
            to="/shop" 
            class="group relative inline-flex items-center gap-2 rounded-xl bg-white px-8 py-4 text-lg font-bold text-slate-800 hover:bg-slate-50 transition transform hover:scale-105 shadow-2xl"
          >
            <span>Shop Now</span>
            <svg class="w-5 h-5 group-hover:translate-x-1 transition" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"/>
            </svg>
          </RouterLink>
          <RouterLink 
            to="/shop?featured=true" 
            class="inline-flex items-center gap-2 rounded-xl bg-white/20 backdrop-blur-sm px-8 py-4 text-lg font-bold text-white hover:bg-white/30 transition border-2 border-white/50"
          >
            View Featured
          </RouterLink>
        </div>
        
        <!-- Trust Badges -->
        <div class="mt-12 pt-8 border-t border-white/30">
          <div class="grid grid-cols-3 gap-4 md:gap-8 max-w-2xl mx-auto">
            <div class="flex flex-col items-center">
              <div class="text-3xl mb-2">🚚</div>
              <div class="text-sm font-semibold">Free Shipping</div>
              <div class="text-xs text-white/70">On orders over $50</div>
            </div>
            <div class="flex flex-col items-center">
              <div class="text-3xl mb-2">🔒</div>
              <div class="text-sm font-semibold">Secure Payment</div>
              <div class="text-xs text-white/70">100% Protected</div>
            </div>
            <div class="flex flex-col items-center">
              <div class="text-3xl mb-2">↩️</div>
              <div class="text-sm font-semibold">Easy Returns</div>
              <div class="text-xs text-white/70">30-day guarantee</div>
            </div>
          </div>
        </div>
      </div>
    </section>

    <!-- Features Section -->
    <section class="grid md:grid-cols-3 gap-6">
      <div class="group rounded-2xl border-2 border-slate-200 p-6 hover:border-teal-300 hover:shadow-xl transition bg-gradient-to-br from-white to-teal-50">
        <div class="w-12 h-12 rounded-xl bg-gradient-to-br from-teal-600 to-cyan-600 flex items-center justify-center mb-4 group-hover:scale-110 transition">
          <span class="text-2xl">⭐</span>
        </div>
        <h3 class="text-xl font-bold mb-2">Premium Quality</h3>
        <p class="text-slate-600">Carefully curated collection of high-quality garments from top brands.</p>
      </div>
      
      <div class="group rounded-2xl border-2 border-slate-200 p-6 hover:border-blue-300 hover:shadow-xl transition bg-gradient-to-br from-white to-blue-50">
        <div class="w-12 h-12 rounded-xl bg-gradient-to-br from-blue-500 to-indigo-600 flex items-center justify-center mb-4 group-hover:scale-110 transition">
          <span class="text-2xl">💎</span>
        </div>
        <h3 class="text-xl font-bold mb-2">Latest Trends</h3>
        <p class="text-slate-600">Stay ahead with the newest fashion trends updated weekly.</p>
      </div>
      
      <div class="group rounded-2xl border-2 border-slate-200 p-6 hover:border-green-300 hover:shadow-xl transition bg-gradient-to-br from-white to-green-50">
        <div class="w-12 h-12 rounded-xl bg-gradient-to-br from-green-500 to-teal-500 flex items-center justify-center mb-4 group-hover:scale-110 transition">
          <span class="text-2xl">🎯</span>
        </div>
        <h3 class="text-xl font-bold mb-2">Best Prices</h3>
        <p class="text-slate-600">Competitive pricing with regular sales and exclusive member discounts.</p>
      </div>
    </section>

    <!-- Advertisement Banner -->
    <section class="relative rounded-3xl overflow-hidden shadow-2xl">
      <div class="absolute inset-0 bg-gradient-to-r from-blue-600 via-blue-700 to-indigo-700"></div>
      <div class="absolute inset-0 opacity-20">
        <div class="absolute top-0 left-0 w-72 h-72 bg-white rounded-full blur-3xl"></div>
        <div class="absolute bottom-0 right-0 w-96 h-96 bg-white rounded-full blur-3xl"></div>
      </div>
      
      <div class="relative p-8 md:p-12 flex flex-col md:flex-row items-center justify-between gap-6">
        <div class="text-white">
          <div class="inline-block px-4 py-1 bg-white/20 backdrop-blur-sm rounded-full text-sm font-semibold mb-4">
            🔥 Limited Time Offer
          </div>
          <h2 class="text-4xl md:text-5xl font-bold mb-3">Summer Sale!</h2>
          <p class="text-2xl text-blue-100 mb-1">Up to 30% off</p>
          <p class="text-lg text-blue-200">on selected items & collections</p>
        </div>
        <RouterLink 
          to="/shop?featured=true" 
          class="group rounded-2xl bg-white px-8 py-4 text-blue-700 text-xl font-bold hover:bg-blue-50 transition transform hover:scale-105 shadow-xl whitespace-nowrap flex items-center gap-2"
        >
          Shop Sale
          <svg class="w-6 h-6 group-hover:translate-x-1 transition" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"/>
          </svg>
        </RouterLink>
      </div>
    </section>

    <!-- Featured Products -->
    <section class="space-y-6">
      <div class="flex items-center justify-between">
        <div>
          <h2 class="text-3xl font-bold mb-2">Featured Products</h2>
          <p class="text-slate-600">Handpicked favorites just for you</p>
        </div>
        <RouterLink to="/shop?featured=true" class="group flex items-center gap-2 text-blue-700 hover:text-blue-800 font-semibold">
          View all
          <svg class="w-5 h-5 group-hover:translate-x-1 transition" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"/>
          </svg>
        </RouterLink>
      </div>

      <div v-if="loading" class="flex items-center justify-center py-12">
        <div class="animate-spin rounded-full h-12 w-12 border-4 border-pink-500 border-t-transparent"></div>
      </div>
      
      <div v-else-if="error" class="rounded-2xl border-2 border-red-200 bg-red-50 p-6 text-center">
        <div class="text-red-600 text-lg font-semibold">{{ error }}</div>
      </div>
      
      <div v-else-if="products.length === 0" class="rounded-2xl border-2 border-slate-200 bg-slate-50 p-12 text-center">
        <div class="text-6xl mb-4">🛍️</div>
        <p class="text-slate-500 text-lg">No featured products available at the moment.</p>
      </div>
      
      <div v-else class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-4 gap-6">
        <RouterLink
          v-for="p in products"
          :key="p.id"
          :to="`/products/${p.id}`"
          class="group rounded-2xl border-2 border-slate-200 overflow-hidden hover:border-pink-300 hover:shadow-xl transition-all duration-300 bg-white"
        >
          <div class="aspect-[4/3] bg-gradient-to-br from-slate-100 to-slate-200 overflow-hidden relative">
            <img 
              v-if="p.images?.[0]?.url || p.images?.[0]?.path" 
              :src="p.images[0]?.url || p.images[0]?.path"
              :alt="p.name" 
              class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500" 
            />
            <div v-else class="w-full h-full flex items-center justify-center text-slate-400 text-4xl">
              👕
            </div>
            
            <!-- Discount Badge -->
            <div v-if="p.discount_cents" class="absolute top-3 right-3 bg-gradient-to-r from-red-600 to-orange-600 text-white px-3 py-1 rounded-full text-xs font-bold shadow-lg">
              SALE
            </div>
          </div>
          
          <div class="p-4">
            <div class="text-xs font-semibold text-teal-600 uppercase tracking-wide mb-1">
              {{ p.category?.name || 'Fashion' }}
            </div>
            <div class="font-bold text-slate-900 line-clamp-2 mb-2 group-hover:text-blue-700 transition">
              {{ p.name }}
            </div>
            <div class="flex items-baseline gap-2">
              <span class="text-lg font-bold text-slate-900">
                {{ formatMoney(p.price_cents - (p.discount_cents || 0)) }}
              </span>
              <span v-if="p.discount_cents" class="text-sm text-slate-400 line-through">
                {{ formatMoney(p.price_cents) }}
              </span>
            </div>
          </div>
        </RouterLink>
      </div>
    </section>

    <!-- Categories Section -->
    <section class="space-y-6">
      <div class="text-center">
        <h2 class="text-3xl font-bold mb-2">Shop by Category</h2>
        <p class="text-slate-600">Find exactly what you're looking for</p>
      </div>
      
      <div class="grid grid-cols-2 md:grid-cols-4 gap-6">
        <RouterLink
          to="/shop?category=men"
          class="group relative rounded-2xl border-2 border-slate-200 p-8 text-center hover:border-blue-400 hover:shadow-xl transition-all overflow-hidden bg-gradient-to-br from-white to-blue-50"
        >
          <div class="absolute inset-0 bg-gradient-to-br from-blue-500/0 to-blue-500/5 opacity-0 group-hover:opacity-100 transition"></div>
          <div class="relative">
            <div class="text-5xl mb-3 group-hover:scale-110 transition-transform">👔</div>
            <div class="font-bold text-xl text-slate-900 group-hover:text-blue-600 transition">Men</div>
            <div class="text-sm text-slate-500 mt-1">Explore collection →</div>
          </div>
        </RouterLink>
        
        <RouterLink
          to="/shop?category=women"
          class="group relative rounded-2xl border-2 border-slate-200 p-8 text-center hover:border-purple-400 hover:shadow-xl transition-all overflow-hidden bg-gradient-to-br from-white to-purple-50"
        >
          <div class="absolute inset-0 bg-gradient-to-br from-purple-500/0 to-purple-500/5 opacity-0 group-hover:opacity-100 transition"></div>
          <div class="relative">
            <div class="text-5xl mb-3 group-hover:scale-110 transition-transform">👗</div>
            <div class="font-bold text-xl text-slate-900 group-hover:text-purple-600 transition">Women</div>
            <div class="text-sm text-slate-500 mt-1">Explore collection →</div>
          </div>
        </RouterLink>
        
        <RouterLink
          to="/shop?category=kids"
          class="group relative rounded-2xl border-2 border-slate-200 p-8 text-center hover:border-green-400 hover:shadow-xl transition-all overflow-hidden bg-gradient-to-br from-white to-green-50"
        >
          <div class="absolute inset-0 bg-gradient-to-br from-green-500/0 to-green-500/5 opacity-0 group-hover:opacity-100 transition"></div>
          <div class="relative">
            <div class="text-5xl mb-3 group-hover:scale-110 transition-transform">👶</div>
            <div class="font-bold text-xl text-slate-900 group-hover:text-green-600 transition">Kids</div>
            <div class="text-sm text-slate-500 mt-1">Explore collection →</div>
          </div>
        </RouterLink>
        
        <RouterLink
          to="/shop?category=accessories"
          class="group relative rounded-2xl border-2 border-slate-200 p-8 text-center hover:border-purple-400 hover:shadow-xl transition-all overflow-hidden bg-gradient-to-br from-white to-purple-50"
        >
          <div class="absolute inset-0 bg-gradient-to-br from-purple-500/0 to-purple-500/5 opacity-0 group-hover:opacity-100 transition"></div>
          <div class="relative">
            <div class="text-5xl mb-3 group-hover:scale-110 transition-transform">👜</div>
            <div class="font-bold text-xl text-slate-900 group-hover:text-purple-600 transition">Accessories</div>
            <div class="text-sm text-slate-500 mt-1">Explore collection →</div>
          </div>
        </RouterLink>
      </div>
    </section>

    <!-- New Arrivals Banner -->
    <section class="relative rounded-3xl overflow-hidden shadow-2xl">
      <div class="absolute inset-0 bg-gradient-to-r from-blue-600 via-indigo-600 to-purple-600"></div>
      <div class="absolute inset-0">
        <div class="absolute top-0 right-0 w-96 h-96 bg-white/10 rounded-full blur-3xl"></div>
        <div class="absolute bottom-0 left-0 w-72 h-72 bg-white/10 rounded-full blur-3xl"></div>
      </div>
      
      <div class="relative p-8 md:p-12 text-center text-white">
        <div class="inline-block px-4 py-1 bg-white/20 backdrop-blur-sm rounded-full text-sm font-semibold mb-4">
          ✨ Just Dropped
        </div>
        <h2 class="text-4xl md:text-5xl font-bold mb-4">New Arrivals</h2>
        <p class="text-xl text-blue-100 mb-6 max-w-2xl mx-auto">
          Check out our latest collection featuring the hottest trends of the season
        </p>
        <RouterLink 
          to="/shop" 
          class="group inline-flex items-center gap-2 rounded-2xl bg-white px-8 py-4 text-lg font-bold text-indigo-600 hover:bg-blue-50 transition transform hover:scale-105 shadow-xl"
        >
          Explore Collection
          <svg class="w-6 h-6 group-hover:translate-x-1 transition" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"/>
          </svg>
        </RouterLink>
      </div>
    </section>

    <!-- Why Choose Us Section -->
    <section class="bg-gradient-to-br from-slate-50 to-slate-100 rounded-3xl p-8 md:p-12">
      <div class="text-center mb-10">
        <h2 class="text-3xl font-bold mb-2">Why Choose Fashion Store?</h2>
        <p class="text-slate-600">Join thousands of satisfied customers</p>
      </div>
      
      <div class="grid md:grid-cols-2 lg:grid-cols-4 gap-6">
        <div class="text-center">
          <div class="w-16 h-16 rounded-2xl bg-gradient-to-br from-teal-600 to-cyan-600 flex items-center justify-center mx-auto mb-4">
            <span class="text-3xl">🌟</span>
          </div>
          <h3 class="font-bold text-lg mb-2">Top Quality</h3>
          <p class="text-sm text-slate-600">Premium fabrics and impeccable craftsmanship</p>
        </div>
        
        <div class="text-center">
          <div class="w-16 h-16 rounded-2xl bg-gradient-to-br from-blue-500 to-indigo-600 flex items-center justify-center mx-auto mb-4">
            <span class="text-3xl">⚡</span>
          </div>
          <h3 class="font-bold text-lg mb-2">Fast Delivery</h3>
          <p class="text-sm text-slate-600">Quick shipping to your doorstep</p>
        </div>
        
        <div class="text-center">
          <div class="w-16 h-16 rounded-2xl bg-gradient-to-br from-green-500 to-teal-500 flex items-center justify-center mx-auto mb-4">
            <span class="text-3xl">💯</span>
          </div>
          <h3 class="font-bold text-lg mb-2">Satisfaction</h3>
          <p class="text-sm text-slate-600">100% money-back guarantee</p>
        </div>
        
        <div class="text-center">
          <div class="w-16 h-16 rounded-2xl bg-gradient-to-br from-indigo-600 to-purple-600 flex items-center justify-center mx-auto mb-4">
            <span class="text-3xl">🎁</span>
          </div>
          <h3 class="font-bold text-lg mb-2">Exclusive Deals</h3>
          <p class="text-sm text-slate-600">Member-only discounts and offers</p>
        </div>
      </div>
    </section>
  </div>
</template>

<script setup>
import { onMounted, ref } from 'vue'
import { RouterLink } from 'vue-router'
import { api } from '../api/client'

const products = ref([])
const loading = ref(false)
const error = ref(null)

function formatMoney(cents) {
  return new Intl.NumberFormat(undefined, { style: 'currency', currency: 'USD' }).format((cents || 0) / 100)
}

async function loadFeatured() {
  loading.value = true
  error.value = null
  try {
    const { data } = await api.get('/products', { 
      params: { 
        featured: true,
        per_page: 8 
      } 
    })
    products.value = data.data || data
  } catch (e) {
    error.value = e?.response?.data?.message || 'Failed to load featured products.'
  } finally {
    loading.value = false
  }
}

onMounted(() => {
  loadFeatured()
})
</script>
