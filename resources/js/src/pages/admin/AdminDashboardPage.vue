<template>
  <div class="space-y-6">
    <h2 class="text-2xl font-semibold">Admin Dashboard</h2>

    <div class="grid gap-4 md:grid-cols-3">
      <RouterLink
        to="/admin/products"
        class="rounded-xl border p-6 hover:bg-slate-50 transition-colors"
      >
        <h3 class="font-semibold mb-2">Products</h3>
        <p class="text-sm text-slate-600">Manage products, variants, and inventory</p>
      </RouterLink>

      <RouterLink
        to="/admin/categories"
        class="rounded-xl border p-6 hover:bg-slate-50 transition-colors"
      >
        <h3 class="font-semibold mb-2">Categories</h3>
        <p class="text-sm text-slate-600">Manage product categories</p>
      </RouterLink>

      <RouterLink
        to="/admin/orders"
        class="rounded-xl border p-6 hover:bg-slate-50 transition-colors"
      >
        <h3 class="font-semibold mb-2">Orders</h3>
        <p class="text-sm text-slate-600">View and manage customer orders</p>
      </RouterLink>
    </div>
  </div>
</template>

<script setup>
import { RouterLink } from 'vue-router'
</script>
