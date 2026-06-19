<template>
  <div>
    <div class="grid grid-cols-3 gap-4">
      <div v-for="p in products.data" :key="p.id" class="border p-3">
        <h2 class="font-semibold">{{ p.name }}</h2>
        <p class="text-sm">{{ p.short_description }}</p>
        <div class="mt-2">{{ p.price }} USD</div>
        <a :href="`/product/${p.slug}`" class="text-blue-600">View</a>
      </div>
    </div>
    <div class="mt-4">
      <button v-if="products.next_page_url" @click="loadNext">Load more</button>
    </div>
  </div>
</template>

<script setup>
import { ref } from 'vue'
import axios from 'axios'

const products = ref({ data: [] })
let page = 1

async function load() {
  const res = await axios.get('/api/products?page=' + page)
  products.value = res.data
}

function loadNext() {
  if (!products.value.next_page_url) return
  page++
  load()
}

load()
</script>
