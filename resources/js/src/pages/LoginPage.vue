<template>
  <div class="flex items-center justify-center min-h-[60vh]">
    <div class="w-full max-w-md">
      <div class="text-center mb-8">
        <div class="text-5xl mb-4">👕</div>
        <h2 class="text-3xl font-bold">Welcome Back</h2>
        <p class="text-slate-600 mt-2">Sign in to your account to continue shopping</p>
      </div>

      <div class="rounded-2xl border bg-white p-8 shadow-sm">
        <form class="space-y-5" @submit.prevent="onSubmit">
          <div>
            <label class="block text-sm font-medium text-slate-700 mb-2">
              Email Address
            </label>
            <input
              v-model="email"
              type="email"
              required
              placeholder="you@example.com"
              class="w-full rounded-xl border border-slate-300 px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-slate-900 focus:border-transparent transition"
            />
          </div>

          <div>
            <label class="block text-sm font-medium text-slate-700 mb-2">
              Password
            </label>
            <input
              v-model="password"
              type="password"
              required
              placeholder="Enter your password"
              class="w-full rounded-xl border border-slate-300 px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-slate-900 focus:border-transparent transition"
            />
          </div>

          <div v-if="error" class="rounded-xl border border-red-200 bg-red-50 p-4">
            <div class="flex items-start gap-3">
              <div class="text-red-500 text-xl">⚠️</div>
              <div class="flex-1 text-sm text-red-700">{{ error }}</div>
            </div>
          </div>

          <button
            type="submit"
            :disabled="auth.loading || !email || !password"
            class="w-full rounded-xl bg-slate-900 px-4 py-3 text-white font-medium hover:bg-slate-800 disabled:opacity-50 disabled:cursor-not-allowed transition"
          >
            {{ auth.loading ? 'Signing in...' : 'Sign In' }}
          </button>
        </form>

        <div class="mt-6 text-center">
          <p class="text-sm text-slate-600">
            Don't have an account?
            <RouterLink to="/register" class="text-slate-900 font-medium hover:underline">
              Create one
            </RouterLink>
          </p>
        </div>


      </div>
    </div>
  </div>
</template>

<script setup>
import { ref } from 'vue'
import { useRouter } from 'vue-router'
import { RouterLink } from 'vue-router'
import { useAuthStore } from '../stores/auth'

const auth = useAuthStore()
const router = useRouter()

const email = ref('')
const password = ref('')
const error = ref(null)

async function onSubmit() {
  error.value = null
  try {
    await auth.login({ email: email.value, password: password.value })
    await router.push('/')
  } catch (e) {
    error.value = e?.response?.data?.message || 'Login failed. Please check your credentials.'
  }
}
</script>
