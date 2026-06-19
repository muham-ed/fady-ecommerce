<template>
  <div v-if="product">
    <h1 class="text-2xl font-bold">{{ product.name }}</h1>
    <p class="mt-2">{{ product.description }}</p>
    <div class="mt-4">Price: {{ product.price }} USD</div>
    <button @click="addToCart">Add to cart</button>
  </div>
</template>

<script setup>
import { ref } from 'vue'
import axios from 'axios'

const product = ref(null)
const slug = window.PRODUCT_SLUG || ''

async function load() {
  const res = await axios.get('/api/products/' + slug)
  product.value = res.data
}

async function addToCart() {
  await axios.post('/api/cart/add', { product_id: product.value.id, quantity: 1 })
  alert('Added')
}

load()
</script>
