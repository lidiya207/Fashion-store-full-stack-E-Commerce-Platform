import { defineStore } from 'pinia'
import { api } from '../api/client'

export const useCartStore = defineStore('cart', {
  state: () => ({
    cart: null,
    loading: false,
    error: null,
  }),
  getters: {
    items: (s) => s.cart?.items || [],
  },
  actions: {
    async fetchCart() {
      this.loading = true
      this.error = null
      try {
        const { data } = await api.get('/cart')
        // API returns { data: { id, items: [...] } }
        this.cart = data.data || data
        // Ensure items array exists
        if (!this.cart || !this.cart.items) {
          this.cart = { id: null, items: [] }
        }
      } catch (e) {
        this.error = e?.response?.data?.message || 'Failed to load cart.'
        throw e
      } finally {
        this.loading = false
      }
    },
    async addItem(product_variant_id, quantity) {
      this.loading = true
      this.error = null
      try {
        const { data } = await api.post('/cart/items', { product_variant_id, quantity })
        // API returns { cart: { id, items: [...] } }
        this.cart = data.cart || data.data || data
        // Ensure items array exists
        if (!this.cart || !this.cart.items) {
          this.cart = { id: null, items: [] }
        }
      } catch (e) {
        this.error = e?.response?.data?.message || 'Failed to add item.'
        throw e
      } finally {
        this.loading = false
      }
    },
    async updateItem(cartItemId, quantity) {
      this.loading = true
      this.error = null
      try {
        const { data } = await api.put(`/cart/items/${cartItemId}`, { quantity })
        this.cart = data.cart || data.data || data
        if (!this.cart || !this.cart.items) {
          this.cart = { id: null, items: [] }
        }
      } catch (e) {
        this.error = e?.response?.data?.message || 'Failed to update item.'
        throw e
      } finally {
        this.loading = false
      }
    },
    async removeItem(cartItemId) {
      this.loading = true
      this.error = null
      try {
        const { data } = await api.delete(`/cart/items/${cartItemId}`)
        this.cart = data.cart || data.data || data
        if (!this.cart || !this.cart.items) {
          this.cart = { id: null, items: [] }
        }
      } catch (e) {
        this.error = e?.response?.data?.message || 'Failed to remove item.'
        throw e
      } finally {
        this.loading = false
      }
    },
  },
})

