<template>
  <div class="p-4">
    <h1 class="text-2xl font-bold mb-4">Admin</h1>
    <div v-if="!loggedIn">
      <h2 class="text-lg font-semibold">Login</h2>
      <form @submit.prevent="login" class="max-w-sm">
        <div class="mb-2"><input v-model="creds.email" placeholder="email" class="w-full border p-1" /></div>
        <div class="mb-2"><input v-model="creds.password" type="password" placeholder="password" class="w-full border p-1" /></div>
        <button class="btn" type="submit">Login</button>
      </form>
    </div>
    <div v-else>
      <div class="flex items-center justify-between mb-4">
        <h2 class="text-2xl">Products</h2>
        <button @click="logout" class="btn">Logout</button>
      </div>
      <ProductList />
    </div>
  </div>
</template>

<script setup>
import ProductList from './components/ProductList.vue'
import { ref } from 'vue'
import axios from 'axios'

const creds = ref({ email: '', password: '' })
const loggedIn = ref(!!localStorage.getItem('api_token'))

if (localStorage.getItem('api_token')) {
  axios.defaults.headers.common['Authorization'] = 'Bearer ' + localStorage.getItem('api_token')
}

async function login() {
  const res = await axios.post('/api/login', creds.value)
  const token = res.data.token ?? res.data.access_token ?? null
  if (token) {
    localStorage.setItem('api_token', token)
    axios.defaults.headers.common['Authorization'] = 'Bearer ' + token
    loggedIn.value = true
  } else {
    alert('Login failed')
  }
}

async function logout() {
  await axios.post('/api/logout')
  localStorage.removeItem('api_token')
  delete axios.defaults.headers.common['Authorization']
  loggedIn.value = false
}
</script>

<style scoped>
</style>
