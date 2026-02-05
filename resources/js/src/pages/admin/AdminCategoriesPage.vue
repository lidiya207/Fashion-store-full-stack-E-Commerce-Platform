<template>
  <div class="space-y-6">
    <div class="flex items-center justify-between">
      <h2 class="text-2xl font-semibold">Categories</h2>
      <button
        class="rounded-xl bg-slate-900 px-4 py-2 text-sm text-white"
        @click="showForm = true; editingCategory = null"
      >
        + Add Category
      </button>
    </div>

    <div v-if="loading" class="text-sm text-slate-500">Loading…</div>
    <div v-else-if="error" class="rounded-xl border border-red-200 bg-red-50 p-3 text-sm text-red-700">
      {{ error }}
    </div>
    <div v-else-if="categories.length === 0" class="text-sm text-slate-500">No categories found.</div>
    <div v-else class="space-y-3">
      <div
        v-for="category in categories"
        :key="category.id"
        class="rounded-xl border p-4 flex items-center justify-between"
      >
        <div>
          <div class="font-medium">{{ category.name }}</div>
          <div v-if="category.description" class="text-sm text-slate-500 mt-1">
            {{ category.description }}
          </div>
        </div>
        <div class="flex gap-2">
          <button
            class="rounded-xl border px-3 py-1.5 text-sm"
            @click="editCategory(category)"
          >
            Edit
          </button>
          <button
            class="rounded-xl border border-red-200 text-red-600 px-3 py-1.5 text-sm"
            @click="deleteCategory(category.id)"
            :disabled="loading"
          >
            Delete
          </button>
        </div>
      </div>
    </div>

    <!-- Category Form Modal -->
    <div
      v-if="showForm"
      class="fixed inset-0 z-50 flex items-center justify-center bg-black/50 p-4"
      @click.self="closeForm"
    >
      <div class="bg-white rounded-xl max-w-md w-full p-6 space-y-4">
        <h3 class="text-lg font-semibold">{{ editingCategory ? 'Edit Category' : 'Add Category' }}</h3>

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
            @click="saveCategory"
            :disabled="loading || !form.name"
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

const categories = ref([])
const loading = ref(false)
const error = ref(null)
const showForm = ref(false)
const editingCategory = ref(null)

const form = ref({
  name: '',
  description: '',
})

function resetForm() {
  form.value = {
    name: '',
    description: '',
  }
  editingCategory.value = null
}

function closeForm() {
  showForm.value = false
  resetForm()
}

function editCategory(category) {
  editingCategory.value = category
  form.value = {
    name: category.name,
    description: category.description || '',
  }
  showForm.value = true
}

async function loadCategories() {
  loading.value = true
  error.value = null
  try {
    const { data } = await api.get('/admin/categories')
    categories.value = data.data || data
  } catch (e) {
    error.value = e?.response?.data?.message || 'Failed to load categories.'
  } finally {
    loading.value = false
  }
}

async function saveCategory() {
  loading.value = true
  error.value = null
  try {
    if (editingCategory.value) {
      const { data } = await api.put(`/admin/categories/${editingCategory.value.id}`, form.value)
      const idx = categories.value.findIndex((c) => c.id === editingCategory.value.id)
      if (idx >= 0) categories.value[idx] = data.category || data
    } else {
      const { data } = await api.post('/admin/categories', form.value)
      categories.value.push(data.category || data)
    }
    closeForm()
  } catch (e) {
    error.value = e?.response?.data?.message || 'Failed to save category.'
  } finally {
    loading.value = false
  }
}

async function deleteCategory(id) {
  if (!confirm('Delete this category?')) return
  loading.value = true
  error.value = null
  try {
    await api.delete(`/admin/categories/${id}`)
    categories.value = categories.value.filter((c) => c.id !== id)
  } catch (e) {
    error.value = e?.response?.data?.message || 'Failed to delete category.'
  } finally {
    loading.value = false
  }
}

onMounted(() => {
  loadCategories()
})
</script>
