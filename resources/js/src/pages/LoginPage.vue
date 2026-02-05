<template>
  <div class="min-h-screen bg-gradient-to-br from-blue-50 via-indigo-50 to-purple-50 -m-6 p-6 flex items-center justify-center">
    <div class="w-full max-w-md">
      <!-- Header Section -->
      <div class="text-center mb-8">
        <div class="inline-block mb-4">
          <div class="text-7xl animate-pulse">👕</div>
        </div>
        <h1 class="text-4xl md:text-5xl font-bold bg-gradient-to-r from-blue-600 via-indigo-600 to-purple-600 bg-clip-text text-transparent mb-3">
          Welcome Back
        </h1>
        <p class="text-slate-600 text-lg">Sign in to your account to continue shopping</p>
      </div>

      <!-- Login Card -->
      <div class="backdrop-blur-xl bg-white/70 border border-white/20 rounded-3xl p-8 shadow-2xl">
        <form class="space-y-6" @submit.prevent="onSubmit">
          <!-- Email Field -->
          <div>
            <label class="block text-sm font-semibold text-slate-700 mb-2 flex items-center gap-2">
              <span>📧</span>
              <span>Email Address</span>
            </label>
            <input
              v-model="email"
              type="email"
              required
              placeholder="you@example.com"
              class="w-full rounded-xl border-2 border-slate-300 bg-white/80 backdrop-blur px-4 py-3.5 text-base focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all"
            />
          </div>

          <!-- Password Field -->
          <div>
            <label class="block text-sm font-semibold text-slate-700 mb-2 flex items-center gap-2">
              <span>🔒</span>
              <span>Password</span>
            </label>
            <input
              v-model="password"
              type="password"
              required
              placeholder="Enter your password"
              class="w-full rounded-xl border-2 border-slate-300 bg-white/80 backdrop-blur px-4 py-3.5 text-base focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all"
            />
          </div>

          <!-- Error Message -->
          <Transition
            enter-active-class="transition ease-out duration-300"
            enter-from-class="opacity-0 translate-y-2"
            enter-to-class="opacity-100 translate-y-0"
            leave-active-class="transition ease-in duration-200"
            leave-from-class="opacity-100"
            leave-to-class="opacity-0"
          >
            <div v-if="error" class="rounded-xl bg-gradient-to-r from-red-50 to-rose-50 border-2 border-red-200 p-4">
              <div class="flex items-start gap-3">
                <div class="text-2xl">⚠️</div>
                <div class="flex-1">
                  <div class="text-sm font-semibold text-red-800 mb-1">Login Failed</div>
                  <div class="text-sm text-red-700">{{ error }}</div>
                </div>
              </div>
            </div>
          </Transition>

          <!-- Submit Button -->
          <button
            type="submit"
            :disabled="auth.loading || !email || !password"
            class="w-full rounded-xl bg-gradient-to-r from-blue-600 via-indigo-600 to-purple-600 px-6 py-4 text-white font-bold text-lg shadow-xl hover:shadow-2xl hover:scale-105 transition-all duration-300 disabled:opacity-50 disabled:cursor-not-allowed disabled:hover:scale-100 flex items-center justify-center gap-2"
          >
            <span v-if="auth.loading" class="animate-spin">🔄</span>
            <span v-else>🚀</span>
            <span>{{ auth.loading ? 'Signing in...' : 'Sign In' }}</span>
          </button>
        </form>

        <!-- Divider -->
        <div class="relative my-6">
          <div class="absolute inset-0 flex items-center">
            <div class="w-full border-t border-slate-300"></div>
          </div>
          <div class="relative flex justify-center text-sm">
            <span class="px-4 bg-white/70 text-slate-500">New to Fashion Store?</span>
          </div>
        </div>

        <!-- Register Link -->
        <div class="text-center">
          <RouterLink 
            to="/register" 
            class="inline-flex items-center gap-2 px-6 py-3 rounded-xl bg-white/60 backdrop-blur border-2 border-slate-300 text-slate-700 font-semibold hover:bg-white hover:border-blue-400 hover:shadow-lg transition-all duration-300"
          >
            <span>Create Account</span>
            <span>→</span>
          </RouterLink>
        </div>
      </div>

      <!-- Trust Badges -->
      <div class="mt-6 text-center">
        <div class="inline-flex items-center gap-6 text-sm text-slate-600">
          <div class="flex items-center gap-2">
            <span>🔒</span>
            <span>Secure</span>
          </div>
          <div class="flex items-center gap-2">
            <span>⚡</span>
            <span>Fast</span>
          </div>
          <div class="flex items-center gap-2">
            <span>✓</span>
            <span>Reliable</span>
          </div>
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
