<template>
  <div>
    <h2 class="text-xl font-semibold mb-2">Products</h2>
    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4">
      <div v-for="product in products" :key="product.id" class="border p-3 rounded">
        <img :src="product.image || 'https://via.placeholder.com/300'" alt="" class="w-full h-40 object-cover mb-2" />
        <h3 class="font-medium">{{ product.name }}</h3>
        <p class="text-sm text-gray-600">{{ product.category?.name }}</p>
        <div class="mt-2 flex items-center justify-between">
          <span class="font-bold">${{ product.price }}</span>
          <router-link :to="`/product/${product.id}`" class="text-sm text-blue-600">View</router-link>
        </div>
      </div>
    </div>
  </div>
</template>

<script setup>
import { ref, onMounted } from 'vue'
import api from '../api'

const products = ref([])

onMounted(async () => {
  try {
    const res = await api.get('/products')
    products.value = res.data.data || res.data
  } catch (e) {
    console.error(e)
  }
})
</script>
