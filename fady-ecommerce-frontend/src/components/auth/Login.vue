<template>
  <div class="max-w-md mx-auto p-4">
    <h2 class="text-xl font-semibold mb-4">Login</h2>
    <form @submit.prevent="submit">
      <div class="mb-2">
        <input v-model="form.email" placeholder="Email" class="w-full border p-2 rounded" />
      </div>
      <div class="mb-2">
        <input v-model="form.password" type="password" placeholder="Password" class="w-full border p-2 rounded" />
      </div>
      <button type="submit" class="bg-green-600 text-white px-4 py-2 rounded">Login</button>
    </form>
  </div>
</template>

<script setup>
import { ref } from 'vue'
import api from '../api'
import { useRouter } from 'vue-router'

const router = useRouter()
const form = ref({ email: '', password: '' })

async function submit() {
  try {
    const res = await api.post('/login', form.value)
    localStorage.setItem('token', res.data.token)
    api.defaults.headers.common['Authorization'] = `Bearer ${res.data.token}`
    router.push('/')
  } catch (e) {
    alert(e.response?.data?.message || 'Login failed')
  }
}
</script>
