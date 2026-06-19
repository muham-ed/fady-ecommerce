<template>
  <div class="container mx-auto p-4">
    <div class="flex gap-6">
      <img :src="product.image || 'https://via.placeholder.com/400'" class="w-1/2 object-cover" />
      <div class="w-1/2">
        <h1 class="text-2xl font-bold">{{ product.name }}</h1>
        <p class="text-gray-700 my-2">{{ product.description }}</p>
        <div class="text-xl font-semibold">${{ product.price }}</div>
        <button @click="addToCart" class="mt-4 bg-blue-600 text-white px-4 py-2 rounded">Add to cart</button>
      </div>
    </div>
  </div>
</template>

<script setup>
import { ref, onMounted } from 'vue'
import { useRoute } from 'vue-router'
import api from '../api'

const route = useRoute()
const product = ref({})

onMounted(async () => {
  try {
    const res = await api.get(`/products/${route.params.id}`)
    product.value = res.data
  } catch (e) {
    console.error(e)
  }
})

function addToCart() {
  // simple localStorage cart for MVP
  const cart = JSON.parse(localStorage.getItem('cart') || '[]')
  cart.push({ id: product.value.id, quantity: 1 })
  localStorage.setItem('cart', JSON.stringify(cart))
  alert('Added to cart')
}
</script>
