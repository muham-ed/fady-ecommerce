<template>
  <div>
    <div class="flex gap-2 items-center">
      <button @click="showForm = !showForm" class="btn">{{ showForm ? 'Close' : 'Add Product' }}</button>
      <button @click="load" class="btn">Refresh</button>
    </div>
    <div v-if="showForm" class="mt-4 p-4 border rounded">
      <h2 class="font-bold mb-2">New Product</h2>
      <form @submit.prevent="create">
        <div class="mb-2">
          <label>Name</label>
          <input v-model="form.name" class="border p-1 w-full" />
        </div>
        <div class="mb-2">
          <label>Slug</label>
          <input v-model="form.slug" class="border p-1 w-full" />
        </div>
        <div class="mb-2">
          <label>Price</label>
          <input v-model.number="form.price" type="number" class="border p-1 w-full" />
        </div>
        <div class="mb-2">
          <label>Images</label>
          <input ref="images" type="file" multiple class="block" />
        </div>
        <button type="submit" class="btn">Create</button>
      </form>
    </div>
    <table class="min-w-full mt-4">
      <thead>
        <tr><th>Name</th><th>Price</th><th>Actions</th></tr>
      </thead>
      <tbody>
        <tr v-for="p in products.data" :key="p.id">
          <td>{{ p.name }}</td>
          <td>{{ p.price }}</td>
          <td>
            <button @click="edit(p.id)">Edit</button>
            <button @click="remove(p.id)">Delete</button>
          </td>
        </tr>
      </tbody>
    </table>
  </div>
</template>

<script setup>
import { ref } from 'vue'
import axios from 'axios'

const products = ref({ data: [] })
const showForm = ref(false)
const form = ref({ name: '', slug: '', price: 0 })

async function load() {
  const res = await axios.get('/api/admin/products')
  products.value = res.data
}

function edit(id) {
  // open edit dialog (left as exercise)
  alert('Edit ' + id)
}

async function remove(id) {
  if (!confirm('Delete?')) return
  await axios.delete('/api/admin/products/' + id)
  await load()
}

async function create() {
  const data = new FormData()
  data.append('name', form.value.name)
  data.append('slug', form.value.slug)
  data.append('price', form.value.price)
  const input = images.value
  if (input && input.files.length) {
    for (let i = 0; i < input.files.length; i++) {
      data.append('images[]', input.files[i])
    }
  }
  await axios.post('/api/admin/products', data, { headers: { 'Content-Type': 'multipart/form-data' } })
  showForm.value = false
  form.value = { name: '', slug: '', price: 0 }
  await load()
}

const images = ref(null)

load()
</script>
