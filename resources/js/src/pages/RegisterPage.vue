<template>
  <div class="min-h-screen bg-gradient-to-br from-blue-50 via-indigo-50 to-purple-50 -m-6 p-6 flex items-center justify-center">
    <div class="w-full max-w-md">
      <!-- Header Section -->
      <div class="text-center mb-8">
        <div class="inline-block mb-4">
          <div class="text-7xl animate-bounce">🛍️</div>
        </div>
        <h1 class="text-4xl md:text-5xl font-bold bg-gradient-to-r from-blue-600 via-indigo-600 to-purple-600 bg-clip-text text-transparent mb-3">
          Create Account
        </h1>
        <p class="text-slate-600 text-lg">Join us and start shopping today</p>
      </div>

      <!-- Register Card -->
      <div class="backdrop-blur-xl bg-white/70 border border-white/20 rounded-3xl p-8 shadow-2xl">
        <form class="space-y-5" @submit.prevent="onSubmit">
          <!-- Full Name Field -->
          <div>
            <label class="block text-sm font-semibold text-slate-700 mb-2 flex items-center gap-2">
              <span>👤</span>
              <span>Full Name</span>
            </label>
            <input
              v-model="name"
              type="text"
              required
              placeholder="John Doe"
              class="w-full rounded-xl border-2 border-slate-300 bg-white/80 backdrop-blur px-4 py-3.5 text-base focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all"
            />
          </div>

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
              placeholder="At least 8 characters"
              minlength="8"
              class="w-full rounded-xl border-2 border-slate-300 bg-white/80 backdrop-blur px-4 py-3.5 text-base focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all"
            />
            <p class="mt-2 text-xs text-slate-500 flex items-center gap-1">
              <span>ℹ️</span>
              <span>Must be at least 8 characters</span>
            </p>
          </div>

          <!-- Confirm Password Field -->
          <div>
            <label class="block text-sm font-semibold text-slate-700 mb-2 flex items-center gap-2">
              <span>🔐</span>
              <span>Confirm Password</span>
            </label>
            <input
              v-model="password_confirmation"
              type="password"
              required
              placeholder="Re-enter your password"
              class="w-full rounded-xl border-2 border-slate-300 bg-white/80 backdrop-blur px-4 py-3.5 text-base focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all"
            />
            <div v-if="password && password_confirmation && password !== password_confirmation" class="mt-2 text-xs text-red-600 flex items-center gap-1">
              <span>⚠️</span>
              <span>Passwords do not match</span>
            </div>
            <div v-else-if="password && password_confirmation && password === password_confirmation" class="mt-2 text-xs text-green-600 flex items-center gap-1">
              <span>✓</span>
              <span>Passwords match</span>
            </div>
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
                  <div class="text-sm font-semibold text-red-800 mb-1">Registration Error</div>
                  <div class="text-sm text-red-700">{{ error }}</div>
                </div>
              </div>
            </div>
          </Transition>

          <!-- Submit Button -->
          <button
            type="submit"
            :disabled="auth.loading || !name || !email || !password || password !== password_confirmation || password.length < 8"
            class="w-full rounded-xl bg-gradient-to-r from-blue-600 via-indigo-600 to-purple-600 px-6 py-4 text-white font-bold text-lg shadow-xl hover:shadow-2xl hover:scale-105 transition-all duration-300 disabled:opacity-50 disabled:cursor-not-allowed disabled:hover:scale-100 flex items-center justify-center gap-2"
          >
            <span v-if="auth.loading" class="animate-spin">🔄</span>
            <span v-else>✨</span>
            <span>{{ auth.loading ? 'Creating Account...' : 'Create Account' }}</span>
          </button>
        </form>

        <!-- Divider -->
        <div class="relative my-6">
          <div class="absolute inset-0 flex items-center">
            <div class="w-full border-t border-slate-300"></div>
          </div>
          <div class="relative flex justify-center text-sm">
            <span class="px-4 bg-white/70 text-slate-500">Already have an account?</span>
          </div>
        </div>

        <!-- Login Link -->
        <div class="text-center">
          <RouterLink 
            to="/login" 
            class="inline-flex items-center gap-2 px-6 py-3 rounded-xl bg-white/60 backdrop-blur border-2 border-slate-300 text-slate-700 font-semibold hover:bg-white hover:border-blue-400 hover:shadow-lg transition-all duration-300"
          >
            <span>←</span>
            <span>Sign In</span>
          </RouterLink>
        </div>
      </div>

      <!-- Benefits Section -->
      <div class="mt-6 grid grid-cols-3 gap-4 text-center">
        <div class="backdrop-blur-xl bg-white/50 border border-white/20 rounded-xl p-3">
          <div class="text-2xl mb-1">🚚</div>
          <div class="text-xs text-slate-600">Free Shipping</div>
        </div>
        <div class="backdrop-blur-xl bg-white/50 border border-white/20 rounded-xl p-3">
          <div class="text-2xl mb-1">🎁</div>
          <div class="text-xs text-slate-600">Exclusive Deals</div>
        </div>
        <div class="backdrop-blur-xl bg-white/50 border border-white/20 rounded-xl p-3">
          <div class="text-2xl mb-1">⭐</div>
          <div class="text-xs text-slate-600">Rewards</div>
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

const name = ref('')
const email = ref('')
const password = ref('')
const password_confirmation = ref('')
const error = ref(null)

async function onSubmit() {
  error.value = null
  
  if (password.value !== password_confirmation.value) {
    error.value = 'Passwords do not match'
    return
  }
  
  if (password.value.length < 8) {
    error.value = 'Password must be at least 8 characters'
    return
  }

  try {
    await auth.register({
      name: name.value,
      email: email.value,
      password: password.value,
      password_confirmation: password_confirmation.value,
    })
    await router.push('/')
  } catch (e) {
    const errors = e?.response?.data?.errors
    if (errors) {
      error.value = Object.values(errors).flat().join(', ')
    } else {
      error.value = e?.response?.data?.message || 'Registration failed. Please try again.'
    }
  }
}
</script>
