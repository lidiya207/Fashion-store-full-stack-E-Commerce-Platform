import { defineStore } from 'pinia'
import { api } from '../api/client'

export const useAuthStore = defineStore('auth', {
  state: () => ({
    user: null,
    token: localStorage.getItem('token'),
    loading: false,
    initialized: false,
    error: null,
  }),
  actions: {
    async init() {
      if (this.initialized) return
      this.initialized = true
      if (!this.token) return
      try {
        const { data } = await api.get('/auth/me')
        this.user = data.user
      } catch (e) {
        localStorage.removeItem('token')
        this.token = null
        this.user = null
      }
    },
    async login(payload) {
      this.loading = true
      this.error = null
      try {
        const { data } = await api.post('/auth/login', payload)
        this.token = data.token
        localStorage.setItem('token', data.token)
        this.user = data.user
      } catch (e) {
        this.error = e?.response?.data?.message || 'Login failed.'
        throw e
      } finally {
        this.loading = false
      }
    },
    async register(payload) {
      this.loading = true
      this.error = null
      try {
        const { data } = await api.post('/auth/register', payload)
        this.token = data.token
        localStorage.setItem('token', data.token)
        this.user = data.user
      } catch (e) {
        this.error = e?.response?.data?.message || 'Registration failed.'
        throw e
      } finally {
        this.loading = false
      }
    },
    async logout() {
      this.loading = true
      try {
        if (this.token) {
          await api.post('/auth/logout')
        }
      } finally {
        this.user = null
        this.token = null
        localStorage.removeItem('token')
        this.loading = false
      }
    },
  },
})

