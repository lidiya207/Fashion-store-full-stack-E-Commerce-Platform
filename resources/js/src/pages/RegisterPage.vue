<template>
  <div class="flex items-center justify-center min-h-[60vh]">
    <div class="w-full max-w-md">
      <div class="text-center mb-8">
        <div class="text-5xl mb-4">🛍️</div>
        <h2 class="text-3xl font-bold">Create Account</h2>
        <p class="text-slate-600 mt-2">Join us and start shopping today</p>
      </div>

      <div class="rounded-2xl border bg-white p-8 shadow-sm">
        <form class="space-y-5" @submit.prevent="onSubmit">
          <div>
            <label class="block text-sm font-medium text-slate-700 mb-2">
              Full Name
            </label>
            <input
              v-model="name"
              type="text"
              required
              placeholder="John Doe"
              class="w-full rounded-xl border border-slate-300 px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-slate-900 focus:border-transparent transition"
            />
          </div>

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
              placeholder="At least 8 characters"
              minlength="8"
              class="w-full rounded-xl border border-slate-300 px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-slate-900 focus:border-transparent transition"
            />
            <p class="mt-1 text-xs text-slate-500">Must be at least 8 characters</p>
          </div>

          <div>
            <label class="block text-sm font-medium text-slate-700 mb-2">
              Confirm Password
            </label>
            <input
              v-model="password_confirmation"
              type="password"
              required
              placeholder="Re-enter your password"
              class="w-full rounded-xl border border-slate-300 px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-slate-900 focus:border-transparent transition"
            />
          </div>

          <div v-if="error" class="rounded-xl border border-red-200 bg-red-50 p-4">
            <div class="flex items-start gap-3">
              <div class="text-red-500 text-xl">⚠️</div>
              <div class="flex-1">
                <div class="text-sm font-medium text-red-800 mb-1">Registration Error</div>
                <div class="text-sm text-red-700">{{ error }}</div>
              </div>
            </div>
          </div>

          <button
            type="submit"
            :disabled="auth.loading || !name || !email || !password || password !== password_confirmation"
            class="w-full rounded-xl bg-slate-900 px-4 py-3 text-white font-medium hover:bg-slate-800 disabled:opacity-50 disabled:cursor-not-allowed transition"
          >
            {{ auth.loading ? 'Creating Account...' : 'Create Account' }}
          </button>
        </form>

        <div class="mt-6 text-center">
          <p class="text-sm text-slate-600">
            Already have an account?
            <RouterLink to="/login" class="text-slate-900 font-medium hover:underline">
              Sign in
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
      // Format validation errors
      error.value = Object.values(errors).flat().join(', ')
    } else {
      error.value = e?.response?.data?.message || 'Registration failed. Please try again.'
    }
  }
}
</script>
