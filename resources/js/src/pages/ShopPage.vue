<template>
  <div class="space-y-6">
    <div class="flex flex-col gap-4 md:flex-row md:items-end md:justify-between">
      <div>
        <h2 class="text-3xl font-bold">Shop</h2>
        <p class="text-sm text-slate-600 mt-1">Browse our collection and find your perfect style</p>
      </div>
      <div class="flex gap-2">
        <input 
          v-model="q" 
          class="flex-1 md:w-80 rounded-xl border border-slate-300 px-4 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-slate-900 focus:border-transparent" 
          placeholder="Search products..." 
          @keyup.enter="load"
        />
        <button 
          class="rounded-xl bg-slate-900 px-6 py-2 text-sm text-white font-medium hover:bg-slate-800 transition disabled:opacity-50" 
          @click="load" 
          :disabled="loading"
        >
          Search
        </button>
      </div>
    </div>

    <!-- Category Filters -->
    <div class="flex flex-wrap gap-2">
      <button
        @click="selectedCategory = ''"
        :class="[
          'px-4 py-2 rounded-xl text-sm font-medium transition',
          selectedCategory === '' 
            ? 'bg-slate-900 text-white' 
            : 'bg-white border border-slate-300 text-slate-700 hover:bg-slate-50'
        ]"
      >
        All Categories
      </button>
      <button
        v-for="cat in categories"
        :key="cat.id"
        @click="selectedCategory = cat.slug"
        :class="[
          'px-4 py-2 rounded-xl text-sm font-medium transition',
          selectedCategory === cat.slug 
            ? 'bg-slate-900 text-white' 
            : 'bg-white border border-slate-300 text-slate-700 hover:bg-slate-50'
        ]"
      >
        {{ cat.name }}
      </button>
    </div>

    <div v-if="error" class="rounded-xl border border-red-200 bg-red-50 p-4">
      <div class="flex items-start gap-3">
        <div class="text-red-500 text-xl">⚠️</div>
        <div class="flex-1 text-sm text-red-700">{{ error }}</div>
      </div>
    </div>

    <div v-if="loading" class="text-center py-12">
      <div class="inline-block animate-spin rounded-full h-8 w-8 border-b-2 border-slate-900"></div>
      <p class="mt-2 text-sm text-slate-500">Loading products...</p>
    </div>

    <div v-else-if="products.length === 0" class="text-center py-12">
      <div class="text-4xl mb-4">🔍</div>
      <h3 class="text-lg font-semibold mb-2">No products found</h3>
      <p class="text-sm text-slate-600">Try adjusting your search or filters</p>
    </div>

    <div v-else class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
      <RouterLink
        v-for="p in products"
        :key="p.id"
        :to="`/products/${p.id}`"
        class="rounded-2xl border bg-white overflow-hidden hover:shadow-xl transition-all group"
      >
        <div class="aspect-[4/3] bg-slate-100 overflow-hidden relative">
          <img 
            v-if="p.images?.[0]?.url || p.images?.[0]?.path" 
            :src="p.images[0]?.url || p.images[0]?.path" 
            class="h-full w-full object-cover group-hover:scale-110 transition-transform duration-500" 
            :alt="p.name"
          />
          <div v-else class="w-full h-full flex items-center justify-center text-slate-400">
            <span class="text-4xl">👕</span>
          </div>
          <div v-if="p.discount_cents" class="absolute top-2 right-2 bg-red-500 text-white text-xs font-bold px-2 py-1 rounded">
            SALE
          </div>
          <div v-if="p.is_featured" class="absolute top-2 left-2 bg-slate-900 text-white text-xs font-bold px-2 py-1 rounded">
            FEATURED
          </div>
        </div>
        <div class="p-4">
          <div class="text-xs text-slate-500 mb-1">{{ p.category?.name }}</div>
          <div class="font-semibold text-slate-900 mb-2 line-clamp-2">{{ p.name }}</div>
          <div class="flex items-center gap-2">
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

    <!-- Pagination -->
    <div v-if="pagination && pagination.last_page > 1" class="flex items-center justify-center gap-2">
      <button
        @click="loadPage(pagination.current_page - 1)"
        :disabled="!pagination.prev_page_url"
        class="px-4 py-2 rounded-xl border border-slate-300 text-sm font-medium hover:bg-slate-50 disabled:opacity-50 disabled:cursor-not-allowed"
      >
        Previous
      </button>
      <span class="text-sm text-slate-600">
        Page {{ pagination.current_page }} of {{ pagination.last_page }}
      </span>
      <button
        @click="loadPage(pagination.current_page + 1)"
        :disabled="!pagination.next_page_url"
        class="px-4 py-2 rounded-xl border border-slate-300 text-sm font-medium hover:bg-slate-50 disabled:opacity-50 disabled:cursor-not-allowed"
      >
        Next
      </button>
    </div>
  </div>
</template>

<script setup>
import { ref, onMounted, watch } from 'vue'
import { RouterLink, useRoute } from 'vue-router'
import { api } from '../api/client'

const route = useRoute()

const products = ref([])
const categories = ref([])
const loading = ref(false)
const error = ref(null)
const q = ref('')
const selectedCategory = ref('')
const pagination = ref(null)

function formatMoney(cents) {
  return new Intl.NumberFormat(undefined, { style: 'currency', currency: 'USD' }).format((cents || 0) / 100)
}

async function loadCategories() {
  try {
    const { data } = await api.get('/categories')
    categories.value = data.data || []
  } catch (e) {
    console.error('Failed to load categories:', e)
    // Fallback: try to extract from products
    try {
      const { data: productsData } = await api.get('/products', { params: { per_page: 100 } })
      const categoryMap = new Map()
      if (productsData.data) {
        productsData.data.forEach(product => {
          if (product.category && !categoryMap.has(product.category.id)) {
            categoryMap.set(product.category.id, product.category)
          }
        })
      }
      categories.value = Array.from(categoryMap.values())
    } catch (e2) {
      console.error('Failed to load categories from products:', e2)
    }
  }
}

async function load(page = 1) {
  loading.value = true
  error.value = null
  try {
    const params = {
      q: q.value || undefined,
      category: selectedCategory.value || undefined,
      page,
      per_page: 24,
    }
    
    // Remove undefined params
    Object.keys(params).forEach(key => params[key] === undefined && delete params[key])
    
    const { data } = await api.get('/products', { params })
    
    if (data.data) {
      products.value = data.data
      pagination.value = {
        current_page: data.current_page || 1,
        last_page: data.last_page || 1,
        prev_page_url: data.prev_page_url,
        next_page_url: data.next_page_url,
      }
    } else {
      products.value = Array.isArray(data) ? data : []
    }
  } catch (e) {
    error.value = e?.response?.data?.message || 'Failed to load products.'
    products.value = []
  } finally {
    loading.value = false
  }
}

function loadPage(page) {
  load(page)
}

// Watch for category changes
watch(selectedCategory, () => {
  load()
})

// Watch for route query changes (for category links from home page)
watch(() => route.query.category, (newCategory) => {
  if (newCategory) {
    selectedCategory.value = newCategory
  }
}, { immediate: true })

onMounted(async () => {
  await loadCategories()
  // Check if category is in route query
  if (route.query.category) {
    selectedCategory.value = route.query.category
  }
  await load()
})
</script>
