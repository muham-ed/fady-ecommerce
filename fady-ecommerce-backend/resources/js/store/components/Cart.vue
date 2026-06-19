<template>
  <div>
    <h2 class="text-xl font-bold">Cart</h2>
    <div v-if="items.length === 0">Cart is empty</div>
    <div v-else>
      <div v-for="it in items" :key="it.product_id">Product: {{ it.product_id }} — Qty: {{ it.quantity }}</div>
    </div>
  </div>
</template>

<script setup>
import { ref } from 'vue'
import axios from 'axios'

const items = ref([])

async function load() {
  const res = await axios.get('/api/cart')
  items.value = res.data.items
}

load()
</script>
