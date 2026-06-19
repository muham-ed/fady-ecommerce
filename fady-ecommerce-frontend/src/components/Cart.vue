<template>
  <div class="container mx-auto p-4">
    <h1 class="text-xl font-bold mb-4">Shopping Cart</h1>
    <div v-if="items.length">
      <div v-for="it in items" :key="it.id" class="flex items-center justify-between border p-2 mb-2">
        <div>{{ it.id }}</div>
        <div>Quantity: {{ it.quantity }}</div>
      </div>
      <router-link to="/checkout" class="bg-green-600 text-white px-4 py-2 rounded">Checkout</router-link>
    </div>
    <div v-else>
      <p>Your cart is empty</p>
    </div>
  </div>
</template>

<script setup>
import { ref, onMounted } from 'vue'
const items = ref([])
onMounted(() => {
  items.value = JSON.parse(localStorage.getItem('cart') || '[]')
})
</script>
