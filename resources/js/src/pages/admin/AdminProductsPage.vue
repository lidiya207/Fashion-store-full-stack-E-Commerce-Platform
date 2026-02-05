<template>
  <div class="space-y-6">
    <div class="flex items-center justify-between">
      <h2 class="text-2xl font-semibold">Products</h2>
      <button
        class="rounded-xl bg-slate-900 px-4 py-2 text-sm text-white"
        @click="showForm = true; editingProduct = null"
      >
        + Add Product
      </button>
    </div>

    <div v-if="loading" class="text-sm text-slate-500">Loading…</div>
    <div v-else-if="error" class="rounded-xl border border-red-200 bg-red-50 p-3 text-sm text-red-700">
      {{ error }}
    </div>
    <div v-else-if="products.length === 0" class="text-sm text-slate-500">No products found.</div>
    <div v-else class="space-y-3">
      <div
        v-for="product in products"
        :key="product.id"
        class="rounded-xl border p-4 flex items-center justify-between"
      >
        <div class="flex gap-4 flex-1">
          <div class="h-16 w-16 rounded-lg bg-slate-100 overflow-hidden shrink-0">
            <img
              v-if="product.images?.[0]?.url"
              :src="product.images[0].url"
              class="h-full w-full object-cover"
            />
          </div>
          <div class="flex-1">
            <div class="font-medium">{{ product.name }}</div>
            <div class="text-sm text-slate-500">{{ product.category?.name }} • ${{ product.price }}</div>
            <div class="text-xs text-slate-400 mt-1">
              Stock: {{ product.variants?.reduce((sum, v) => sum + v.stock, 0) || 0 }}
            </div>
          </div>
        </div>
        <div class="flex gap-2">
          <button
            class="rounded-xl border px-3 py-1.5 text-sm"
            @click="editProduct(product)"
          >
            Edit
          </button>
          <button
            class="rounded-xl border border-red-200 text-red-600 px-3 py-1.5 text-sm"
            @click="deleteProduct(product.id)"
            :disabled="loading"
          >
            Delete
          </button>
        </div>
      </div>
    </div>

    <!-- Product Form Modal -->
    <div
      v-if="showForm"
      class="fixed inset-0 z-50 flex items-center justify-center bg-black/50 p-4"
      @click.self="closeForm"
    >
      <div class="bg-white rounded-xl max-w-2xl w-full max-h-[90vh] overflow-y-auto p-6 space-y-4">
        <h3 class="text-lg font-semibold">{{ editingProduct ? 'Edit Product' : 'Add Product' }}</h3>

        <div class="space-y-3">
          <div>
            <label class="block text-sm font-medium mb-1">Name *</label>
            <input
              v-model="form.name"
              type="text"
              class="w-full rounded-xl border px-3 py-2 text-sm"
            />
          </div>
          <div>
            <label class="block text-sm font-medium mb-1">Description</label>
            <textarea
              v-model="form.description"
              rows="3"
              class="w-full rounded-xl border px-3 py-2 text-sm"
            />
          </div>
          <div class="grid grid-cols-2 gap-3">
            <div>
              <label class="block text-sm font-medium mb-1">Price *</label>
              <input
                v-model.number="form.price"
                type="number"
                step="0.01"
                class="w-full rounded-xl border px-3 py-2 text-sm"
              />
            </div>
            <div>
              <label class="block text-sm font-medium mb-1">Category *</label>
              <select
                v-model.number="form.category_id"
                class="w-full rounded-xl border px-3 py-2 text-sm"
              >
                <option :value="null">Select category</option>
                <option v-for="cat in categories" :key="cat.id" :value="cat.id">
                  {{ cat.name }}
                </option>
              </select>
            </div>
          </div>
          <div class="flex items-center gap-2">
            <input v-model="form.is_featured" type="checkbox" id="featured" />
            <label for="featured" class="text-sm">Featured</label>
          </div>
        </div>

        <div class="flex gap-2 pt-2">
          <button
            class="flex-1 rounded-xl border px-4 py-2 text-sm"
            @click="closeForm"
          >
            Cancel
          </button>
          <button
            class="flex-1 rounded-xl bg-slate-900 px-4 py-2 text-sm text-white"
            @click="saveProduct"
            :disabled="loading || !form.name || !form.price || !form.category_id"
          >
            {{ loading ? 'Saving...' : 'Save' }}
          </button>
        </div>
      </div>
    </div>
  </div>
</template>

<script setup>
import { onMounted, ref } from 'vue'
import { api } from '../../api/client'

const products = ref([])
const categories = ref([])
const loading = ref(false)
const error = ref(null)
const showForm = ref(false)
const editingProduct = ref(null)

const form = ref({
  name: '',
  description: '',
  price: 0,
  category_id: null,
  is_featured: false,
})

function resetForm() {
  form.value = {
    name: '',
    description: '',
    price: 0,
    category_id: null,
    is_featured: false,
  }
  editingProduct.value = null
}

function closeForm() {
  showForm.value = false
  resetForm()
}

function editProduct(product) {
  editingProduct.value = product
  form.value = {
    name: product.name,
    description: product.description || '',
    price: product.price,
    category_id: product.category_id,
    is_featured: product.is_featured || false,
  }
  showForm.value = true
}

async function loadCategories() {
  try {
    const { data } = await api.get('/admin/categories')
    categories.value = data.data || data
  } catch (e) {
    console.error('Failed to load categories:', e)
  }
}

async function loadProducts() {
  loading.value = true
  error.value = null
  try {
    const { data } = await api.get('/admin/products')
    products.value = data.data || data
  } catch (e) {
    error.value = e?.response?.data?.message || 'Failed to load products.'
  } finally {
    loading.value = false
  }
}

async function saveProduct() {
  loading.value = true
  error.value = null
  try {
    if (editingProduct.value) {
      const { data } = await api.put(`/admin/products/${editingProduct.value.id}`, form.value)
      const idx = products.value.findIndex((p) => p.id === editingProduct.value.id)
      if (idx >= 0) products.value[idx] = data.product || data
    } else {
      const { data } = await api.post('/admin/products', form.value)
      products.value.push(data.product || data)
    }
    closeForm()
  } catch (e) {
    error.value = e?.response?.data?.message || 'Failed to save product.'
  } finally {
    loading.value = false
  }
}

async function deleteProduct(id) {
  if (!confirm('Delete this product?')) return
  loading.value = true
  error.value = null
  try {
    await api.delete(`/admin/products/${id}`)
    products.value = products.value.filter((p) => p.id !== id)
  } catch (e) {
    error.value = e?.response?.data?.message || 'Failed to delete product.'
  } finally {
    loading.value = false
  }
}

onMounted(async () => {
  await Promise.all([loadProducts(), loadCategories()])
})
</script>
